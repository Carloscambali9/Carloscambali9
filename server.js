const express = require('express');
const bodyParser = require('body-parser');
const crypto = require('crypto');
const axios = require('axios');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware para parsear JSON
app.use(bodyParser.json());

// Chaves da Mastercard (substitua pelas suas)
const CONSUMER_KEY = process.env.MASTERCARD_CONSUMER_KEY || 'dXuaQ2BFxRn2_9JVvjc53R8CQN8S9cV13LoIinM166b0dcc8!f3b84547906b45aa93c93d22f05d3aa10000000000000000';
const PRIVATE_KEY = process.env.MASTERCARD_PRIVATE_KEY || '-----BEGIN PRIVATE KEY-----MIIEkzCCA3ugAwIBAgIIDzMLWnu8T/4wDQYJKoZIhvcNAQELBQAwgZAxCzAJBgNVBAYTAlVTMR0wGwYDVQQKExRNYXN0ZXJDYXJkIFdvcmxkd2lkZTEbMBkGA1UECxMSQ29ycG9yYXRlIFNlY3VyaXR5MUUwQwYDVQQDEzxNYXN0ZXJDYXJkIFBSRCBPcGVuQVBJIEluYm91bmQgRmllbGQgTGV2ZWwgRW5jcnlwdGlvbiBTdWIgQ0EwHhcNMjUwODE3MTE0NzE4WhcNMjYwOTE2MTE0NzE4WjCBhjEwMC4GA1UEAxMnZTFiOTI4Nzk4M2Y1OWM2M2FlNDAtaW5ib3VuZC1lbmNyeXB0aW9uMRMwEQYDVQQKEwpNYXN0ZXJDYXJkMRAwDgYDVQQLEwdPcGVuQVBJMREwDwYDVQQHEwhOZXcgWW9yazELMAkGA1UECBMCTlkxCzAJBgNVBAYTAlVTMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA1DOBo135ocGtAWyAYaMFTsF8n9qj588pGrPsq1aN7xiHOGAgnI35t30TznIsTJPI/kpfILGsl+iUnJOWe9cgwvW6N6z9snwYeivT6POyhu4ptqe+8DaEnpcMXRpuphg3fggJAUwjMXkOLO16BihNcvt8wz39JcODieTwuGGoWxtWHxDnHdvQiSP0b7ZuJrty7pTOyB5lcirgqcS+eMfli4/e8zZisKcDz/VA26/8hfwnmA9NjVSiJIBZVHEP6vJjXMFKpaQEAS8QlGEh0Fq19HfN1tZAxRgygq1+3bkt1JMXN1vZRROsg7PEV7QEv4GD6ufy+R5S+o93tPlnZatHZQIDAQABo4H4MIH1MA4GA1UdDwEB/wQEAwIAIDAMBgNVHRMBAf8EAjAAMB0GA1UdDgQWBBTZ5STjAjLWdGy/yynl4N1YSQ5zMjAfBgNVHSMEGDAWgBTCzQJmYIHGXuER5duiDh7Ofwea/TBhBgNVHR8EWjBYMFagVKBShlBodHRwOi8vY3JsZHAuZWNtcy5tY2xvY2FsLmludDoxMzUzNi9jMmNkMDI2NjYwODFjNjVlZTExMWU1ZGJhMjBlMWVjZTdmMDc5YWZkLmNybDAyBgNVHREEKzApgidlMWI5Mjg3OTgzZjU5YzYzYWU0MC1pbmJvdW5kLWVuY3J5cHRpb24wDQYJKoZIhvcNAQELBQADggEBAGJNxHoUxvAxDxLruHLbBo6G/nVzAPUl3PCgk7m1OZM8lgId7Nr6fe8MKQH03b2dpPXZuZmYd2J1mf6mUKm39B10eTu0aGaT9gCT6EGGYdIkpIDcHzkTHRdZ7LSAZWjjc6T/4Og0Rs5gW3tjqnOfFrGLIDwiX7nyhyvpei9ApYKNL01RU0yxDclWDhGMcki3A4KBcYH7Zfnm8SphUbDEZUjfnPOkCZmZ2ERiPgQf6J2aRo/s/iplLVB4mhk/Isp/LfjYLMigXHv1FY8DtoP9s3oHEsxUJHjr80BpB9zBHQ4owg+5VkGcY4gRuuy/mNtmDZeI8bkz3o/SibFZaUiNbZ8=-----END PRIVATE KEY-----';

// Rota para gerar o cabeçalho OAuth 1.0a
app.post('/api/mastercard/auth', (req, res) => {
  try {
    const { url, method, body } = req.body;

    // 1. Gerar nonce e timestamp
    const nonce = crypto.randomBytes(16).toString('hex');
    const timestamp = Math.floor(Date.now() / 1000);

    // 2. Criar a string de parâmetros OAuth
    const oauthParams = {
      oauth_consumer_key: CONSUMER_KEY,
      oauth_nonce: nonce,
      oauth_signature_method: 'RSA-SHA256',
      oauth_timestamp: timestamp,
      oauth_version: '1.0'
    };

    // 3. Gerar a assinatura (simplificado - adapte conforme a lib Java)
    const baseString = generateBaseString(method, url, oauthParams, body);
    const signature = signBaseString(baseString, PRIVATE_KEY);

    // 4. Retornar o cabeçalho de autorização
    const authHeader = `OAuth oauth_consumer_key="${CONSUMER_KEY}", oauth_nonce="${nonce}", oauth_signature="${encodeURIComponent(signature)}", oauth_signature_method="RSA-SHA256", oauth_timestamp="${timestamp}", oauth_version="1.0"`;
    
    res.json({ authHeader });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Funções auxiliares (simplificadas)
function generateBaseString(method, url, params, body) {
  const paramString = Object.keys(params)
    .sort()
    .map(key => `${key}=${params[key]}`)
    .join('&');
  return `${method.toUpperCase()}&${encodeURIComponent(url)}&${encodeURIComponent(paramString)}`;
}

function signBaseString(baseString, privateKey) {
  const signer = crypto.createSign('RSA-SHA256');
  signer.update(baseString);
  return signer.sign(privateKey, 'base64');
}

// Rota de teste
app.get('/', (req, res) => {
  res.send('API Mastercard OAuth 1.0a está online!');
});

app.listen(PORT, () => {
  console.log(`Servidor rodando em http://localhost:${PORT}`);
});
