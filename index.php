<?php
// Inicia a sessão (para futuras funcionalidades de login)
session_start();

// Configurações básicas
$page_title = "Gemiworld - O Futuro das Suas Finanças";
?>
<!DOCTYPE html>
<html lang="pt-AO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* --- ESTILOS GLOBAIS E VARIÁVEIS --- */
        :root {
            --primary: #0066cc;
            --secondary: #00ccff;
            --dark: #0a0a1a;
            --light: #f8f9fa;
            --text-muted: #a0a0b0;
            --border-color: rgba(0, 204, 255, 0.2);
            --tech-glow: rgba(0, 204, 255, 0.7);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--dark);
            color: var(--light);
            overflow-x: hidden;
            line-height: 1.7;
        }

        /* --- FUNDO E EFEITOS VISUAIS --- */
        .tech-background {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: -1;
            pointer-events: none;
        }
        .grid-lines {
            background-image: 
                linear-gradient(to right, rgba(0, 204, 255, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 204, 255, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        .glow-effect {
             background: radial-gradient(circle at 20% 30%, var(--tech-glow), transparent 40%),
                        radial-gradient(circle at 80% 70%, var(--primary), transparent 40%);
             opacity: 0.1;
        }

        /* --- CABEÇALHO (HEADER) --- */
        header {
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(10, 10, 26, 0.8);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--border-color);
            transition: padding 0.3s ease;
        }
        header.scrolled { padding: 0.5rem 5%; }

        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo img { height: 40px; transition: height 0.3s ease; }
        header.scrolled .logo img { height: 35px; }

        .logo-text {
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(45deg, var(--secondary), var(--light));
            -webkit-background-clip: text; background-clip: text; color: transparent;
        }

        .nav-links { display: flex; gap: 2rem; list-style: none; }
        .nav-links a { color: var(--light); text-decoration: none; font-weight: 500; transition: color 0.3s; position: relative; }
        .nav-links a:hover { color: var(--secondary); }
        .nav-links a::after {
            content: ''; position: absolute; bottom: -5px; left: 0;
            width: 0; height: 2px; background: var(--secondary);
            transition: width 0.3s;
        }
        .nav-links a:hover::after { width: 100%; }
        
        .auth-buttons { display: flex; gap: 1rem; }
        
        .btn {
            padding: 0.6rem 1.5rem; border-radius: 30px; font-weight: 600;
            text-decoration: none; transition: all 0.3s ease; display: inline-block;
            border: 2px solid transparent;
        }
        .btn-outline { border-color: var(--secondary); color: var(--secondary); }
        .btn-outline:hover { background: var(--secondary); color: var(--dark); transform: translateY(-3px); }
        .btn-primary { background: linear-gradient(45deg, var(--primary), var(--secondary)); color: var(--dark); }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0, 204, 255, 0.3); }

        .mobile-menu-toggle { display: none; font-size: 1.8rem; background: none; border: none; color: var(--light); cursor: pointer; }

        /* --- SECÇÃO HERO --- */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 100px 5% 0;
            position: relative;
        }
        .hero-content { max-width: 50%; z-index: 1; }
        .hero h1 {
            font-family: 'Orbitron', sans-serif; font-size: clamp(2.5rem, 5vw, 3.5rem);
            margin-bottom: 1.5rem; line-height: 1.2;
            background: linear-gradient(45deg, #fff, var(--secondary));
            -webkit-background-clip: text; background-clip: text; color: transparent;
        }
        .hero p { font-size: clamp(1rem, 2.5vw, 1.2rem); margin-bottom: 2rem; color: var(--text-muted); max-width: 550px;}
        .hero-buttons { display: flex; gap: 1rem; margin-top: 2rem; }

        .hero-image {
            position: absolute; right: 5%; top: 50%;
            transform: translateY(-50%); width: 45%; max-width: 600px;
            animation: float 6s ease-in-out infinite;
        }
        .hero-image img { width: 100%; filter: drop-shadow(0 0 50px var(--border-color)); }

        @keyframes float {
            0%, 100% { transform: translateY(-50%) scale(1); }
            50% { transform: translateY(-55%) scale(1.05); }
        }

        /* --- SECÇÕES GENÉRICAS --- */
        .section { padding: 5rem 5%; }
        .section-title {
            text-align: center; margin-bottom: 3rem; font-family: 'Orbitron', sans-serif;
            font-size: clamp(2rem, 4vw, 2.5rem); position: relative;
            display: table; margin-left: auto; margin-right: auto;
        }
        .section-title::after {
            content: ''; position: absolute; bottom: -10px; left: 10%;
            width: 80%; height: 3px; border-radius: 3px;
            background: linear-gradient(90deg, transparent, var(--secondary), transparent);
        }

        /* --- CARROSSÉIS --- */
        .carousel-wrapper { position: relative; }
        .carousel {
            display: flex; gap: 1.5rem; overflow-x: auto;
            padding: 2rem 0; scroll-snap-type: x mandatory;
            scrollbar-width: none; /* Firefox */
        }
        .carousel::-webkit-scrollbar { display: none; } /* Outros navegadores */
        
        .carousel-item {
            flex: 0 0 300px; height: 350px; scroll-snap-align: start;
            border-radius: 15px; overflow: hidden; position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }
        .carousel-item:hover { transform: translateY(-10px); }
        .carousel-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .carousel-item:hover img { transform: scale(1.1); }
        
        .carousel-caption {
            position: absolute; bottom: 0; left: 0; width: 100%; padding: 1.5rem;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.95), transparent);
            color: white;
        }
        .carousel-caption h3 { font-size: 1.3rem; margin-bottom: 0.5rem; }
        
        .carousel-nav {
            display: none; /* Visível apenas em telas maiores */
            position: absolute; top: 50%; width: 100%;
            justify-content: space-between; transform: translateY(-50%);
            padding: 0 1rem; pointer-events: none;
        }
        .carousel-nav button {
            background: rgba(10, 10, 26, 0.7); border: 1px solid var(--border-color);
            color: var(--light); width: 50px; height: 50px; border-radius: 50%;
            font-size: 1.5rem; cursor: pointer; pointer-events: all;
            transition: background-color 0.3s ease;
        }
        .carousel-nav button:hover { background-color: var(--primary); }
        
        /* --- GRELHA DE SERVIÇOS --- */
        .services-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem; margin-top: 3rem;
        }
        .service-card {
            background: rgba(255, 255, 255, 0.05); border-radius: 15px;
            padding: 2rem; transition: all 0.3s ease; text-align: center;
            border: 1px solid transparent; backdrop-filter: blur(5px);
        }
        .service-card:hover {
            transform: translateY(-10px); background: rgba(255, 255, 255, 0.1);
            border-color: var(--border-color);
        }
        .service-icon { font-size: 3rem; margin-bottom: 1.5rem; color: var(--secondary); }
        .service-card h3 { font-size: 1.5rem; margin-bottom: 1rem; font-family: 'Orbitron', sans-serif; }

        /* --- RODAPÉ (FOOTER) --- */
        footer {
            background: #060610; padding: 4rem 5% 2rem;
            margin-top: 5rem; border-top: 1px solid var(--border-color);
        }
        .footer-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
        }
        .footer-col h3 { font-family: 'Orbitron', sans-serif; margin-bottom: 1.5rem; font-size: 1.2rem; color: var(--secondary); }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 0.8rem; }
        .footer-col ul li a { color: var(--text-muted); text-decoration: none; transition: color 0.3s; }
        .footer-col ul li a:hover { color: var(--secondary); }
        .social-links { display: flex; gap: 1rem; margin-top: 1.5rem; }
        .social-links a { color: var(--text-muted); font-size: 1.5rem; transition: color 0.3s; }
        .social-links a:hover { color: var(--secondary); }
        .copyright { text-align: center; margin-top: 3rem; padding-top: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.1); color: var(--text-muted); }

        /* --- ESTILOS RESPONSIVOS --- */
        @media (min-width: 992px) {
            .carousel-nav { display: flex; }
        }

        @media (max-width: 991px) {
            .nav-links {
                position: fixed; top: 0; right: -100%;
                width: 60%; max-width: 300px; height: 100vh;
                background: var(--dark); flex-direction: column;
                padding: 6rem 2rem; gap: 1.5rem;
                transition: right 0.4s ease-in-out;
                border-left: 1px solid var(--border-color);
                box-shadow: -10px 0 30px rgba(0,0,0,0.5);
            }
            .nav-links.active { right: 0; }
            .mobile-menu-toggle { display: block; z-index: 1001; }
            .auth-buttons { display: none; } /* Opcional: ou mover para o menu mobile */
            
            .hero { text-align: center; flex-direction: column; padding-top: 120px; }
            .hero-content { max-width: 100%; }
            .hero-image { position: relative; transform: none; right: auto; top: auto; width: 80%; max-width: 400px; margin-top: 3rem; }
            .hero-buttons { justify-content: center; }
        }

        @media (max-width: 480px) {
            .hero-buttons { flex-direction: column; }
            .carousel-item { flex-basis: 250px; height: 300px; }
            .service-card, .footer-col { text-align: center; }
            .social-links, .footer-col ul { justify-content: center; }
        }

    </style>
</head>
<body>
    <div class="tech-background grid-lines"></div>
    <div class="tech-background glow-effect"></div>
    
    <header id="main-header">
        <a href="#home" class="logo">
            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiAgICA8ZGVmcz4KICAgICAgICA8bGluZWFyR3JhZGllbnQgaWQ9ImdFNzAyIiB4MT0iMCUiIHkxPSIwJSIgeDI9IjEwMCUiIHkyPSIxMDAlIj4KICAgICAgICAgICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3R5bGU9InN0b3AtY29sb3I6IzAwY2NmZiIgLz4KICAgICAgICAgICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdHlsZT0ic3RvcC1jb2xvcjojMDA2NmNjIiAvPgogICAgICAgIDwvbGluZWFyR3JhZGllbnQ+CiAgICA8L2RlZnM+CiAgICA8cGF0aCBkPSJNNTAgMTBMNjEuOCA0MC4yTDk1IDQyLjNMNzAuMyA2My45TDc4LjIgOTVMNTAgNzZMMjEuOCA5NUwyOS43IDYzLjlMNSA0Mi4zTDM4LjIgNDAuMloiIHN0cm9rZT0idXJsKCNnRTcwMikiIHN0cm9rZS13aWR0aD0iNiIgZmlsbD0idHJhbnNwYXJlbnQiIC8+Cjwvc3ZnPg==" alt="Gemiworld Logo">
            <span class="logo-text">GEMIWORLD</span>
        </a>
        
        <nav>
            <ul class="nav-links" id="nav-links">
                <li><a href="#home">Início</a></li>
                <li><a href="#cards">Cartões</a></li>
                <li><a href="#store">Loja</a></li>
                <li><a href="#crypto">Cripto</a></li>
                <li><a href="#services">Serviços</a></li>
                <li class="auth-buttons-mobile" style="display: none; flex-direction: column; gap: 1rem; margin-top: 2rem;">
                    <a href="login.php" class="btn btn-outline">Entrar</a>
                    <a href="register.php" class="btn btn-primary">Registrar</a>
                </li>
            </ul>
        </nav>
        
        <div class="auth-buttons">
            <a href="login.php" class="btn btn-outline">Entrar</a>
            <a href="register.php" class="btn btn-primary">Registrar</a>
        </div>
        
        <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Abrir menu">
            <i class="fas fa-bars"></i>
        </button>
    </header>
    
    <main>
        <section class="hero" id="home">
            <div class="hero-content">
                <h1>O Futuro das Finanças e Compras em Angola.</h1>
                <p>Cartões globais, encomendas internacionais e criptomoedas. Tudo numa plataforma segura e construída para si.</p>
                <div class="hero-buttons">
                    <a href="register.php" class="btn btn-primary">Criar Conta Agora</a>
                    <a href="#services" class="btn btn-outline">Ver Serviços</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://i.imgur.com/rC4Ce4D.png" alt="Cartão Gemiworld Mastercard Flutuante">
            </div>
        </section>
        
        <section class="section" id="cards">
            <h2 class="section-title">Cartões Para o Mundo</h2>
            <div class="carousel-wrapper">
                <div class="carousel" id="cards-carousel">
                    <div class="carousel-item"><img src="https://placehold.co/600x700/0a0a1a/00ccff?text=VISA+Virtual" alt="Cartão Visa Virtual"><div class="carousel-caption"><h3>Cartão Visa Virtual</h3><p>Para compras online seguras e rápidas.</p></div></div>
                    <div class="carousel-item"><img src="https://placehold.co/600x700/0a0a1a/0066cc?text=Mastercard+Físico" alt="Cartão Mastercard Físico"><div class="carousel-caption"><h3>Mastercard Físico</h3><p>Use o seu saldo em qualquer loja do mundo.</p></div></div>
                    <div class="carousel-item"><img src="https://placehold.co/600x700/111/ffc107?text=Cartão+Premium" alt="Cartão Premium"><div class="carousel-caption"><h3>Cartão Premium</h3><p>Benefícios e limites exclusivos para si.</p></div></div>
                    <div class="carousel-item"><img src="https://placehold.co/600x700/222/ffffff?text=Cartão+Cripto" alt="Cartão Cripto"><div class="carousel-caption"><h3>Cartão Cripto</h3><p>Gaste as suas criptomoedas diretamente.</p></div></div>
                </div>
                <div class="carousel-nav">
                    <button class="prev" data-carousel="cards-carousel" aria-label="Anterior"><i class="fas fa-chevron-left"></i></button>
                    <button class="next" data-carousel="cards-carousel" aria-label="Seguinte"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </section>

        <section class="section" id="services">
            <h2 class="section-title">Um Ecossistema Completo</h2>
            <div class="services-grid">
                <div class="service-card"><div class="service-icon"><i class="fas fa-credit-card"></i></div><h3>Cartões Globais</h3><p>Emita cartões virtuais e físicos, pré-pagos e de débito, aceites em todo o mundo.</p></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-shopping-bag"></i></div><h3>Loja Internacional</h3><p>Encomende de qualquer site e nós tratamos da logística e entrega em Angola.</p></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-coins"></i></div><h3>Câmbio Fiat e Cripto</h3><p>Compre e venda USD, EUR, USDT, TRX e LTC com taxas competitivas e liquidez imediata.</p></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-lock"></i></div><h3>Segurança de Ponta</h3><p>Proteja os seus ativos com PIN transacional, 2FA e criptografia avançada.</p></div>
            </div>
        </section>

        <section class="section" id="store">
            <h2 class="section-title">Produtos em Destaque</h2>
            <div class="carousel-wrapper">
                <div class="carousel" id="store-carousel">
                    <div class="carousel-item"><img src="https://placehold.co/600x700/333/fff?text=Smartwatch" alt="Smartwatch"><div class="carousel-caption"><h3>Smartwatches</h3><p>Tecnologia de ponta no seu pulso.</p></div></div>
                    <div class="carousel-item"><img src="https://placehold.co/600x700/444/fff?text=Notebook" alt="Notebook"><div class="carousel-caption"><h3>Notebooks</h3><p>Potência para trabalho e diversão.</p></div></div>
                    <div class="carousel-item"><img src="https://placehold.co/600x700/555/fff?text=Drones" alt="Drone"><div class="carousel-caption"><h3>Drones</h3><p>Capture o mundo de uma nova perspetiva.</p></div></div>
                    <div class="carousel-item"><img src="https://placehold.co/600x700/666/fff?text=Fones" alt="Fones de ouvido"><div class="carousel-caption"><h3>Fones de Ouvido</h3><p>Som imersivo para o seu dia a dia.</p></div></div>
                </div>
                <div class="carousel-nav">
                    <button class="prev" data-carousel="store-carousel" aria-label="Anterior"><i class="fas fa-chevron-left"></i></button>
                    <button class="next" data-carousel="store-carousel" aria-label="Seguinte"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </section>
        
    </main>
    
    <footer>
        <div class="footer-grid">
            <div class="footer-col">
                <h3>Gemiworld</h3>
                <p style="color: var(--text-muted);">A sua ponte para a economia global. Inovação financeira e e-commerce, feitos para Angola.</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Telegram"><i class="fab fa-telegram-plane"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h3>Serviços</h3>
                <ul>
                    <li><a href="#cards">Cartões</a></li>
                    <li><a href="#store">Loja Internacional</a></li>
                    <li><a href="#crypto">Criptomoedas</a></li>
                    <li><a href="#">Rastreamento</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Legal</h3>
                <ul>
                    <li><a href="#">Termos de Serviço</a></li>
                    <li><a href="#">Política de Privacidade</a></li>
                    <li><a href="#">Taxas e Limites</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Contacto</h3>
                <ul style="color: var(--text-muted);">
                    <li style="display:flex; align-items:center; gap:10px;"><i class="fas fa-envelope"></i> suporte@gemiworld.sbs</li>
                    <li style="display:flex; align-items:center; gap:10px;"><i class="fas fa-phone"></i> +244 9xx xxx xxx</li>
                    <li style="display:flex; align-items:center; gap:10px;"><i class="fas fa-map-marker-alt"></i> Luanda, Angola</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; <?php echo date('Y'); ?> Gemiworld. Todos os direitos reservados.</p>
        </div>
    </footer>
    
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // Efeito de encolher o header ao rolar
        const header = document.getElementById('main-header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Lógica do menu mobile
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const navLinks = document.getElementById('nav-links');
        const mobileAuthButtons = document.querySelector('.auth-buttons-mobile');

        // Mostra botões de auth no menu mobile se a tela for pequena
        if (window.innerWidth <= 991) {
            mobileAuthButtons.style.display = 'flex';
        }

        mobileMenuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            // Altera o ícone do menu
            const icon = mobileMenuToggle.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });
        
        // Fecha o menu mobile ao clicar num link
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                    const icon = mobileMenuToggle.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
        });

        // Lógica dos carrosséis
        const carouselNavButtons = document.querySelectorAll('.carousel-nav button');
        carouselNavButtons.forEach(button => {
            button.addEventListener('click', () => {
                const carouselId = button.dataset.carousel;
                const carousel = document.getElementById(carouselId);
                const itemWidth = carousel.querySelector('.carousel-item').offsetWidth + 24; // 24px de gap
                const scrollAmount = button.classList.contains('next') ? itemWidth : -itemWidth;
                carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });
        });
        
    });
    </script>
</body>
</html>
