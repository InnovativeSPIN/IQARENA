<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Arena | NSCET</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Yanone+Kaffeesatz:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <style>
        :root {
            --gradient-primary: linear-gradient(135deg, #f97316, #ea580c);
            --gradient-secondary: linear-gradient(135deg, #fb923c, #f97316);
            --gradient-accent: linear-gradient(135deg, #fdba74, #fb923c);
            --color-primary: #f97316;
            --color-surface: rgba(26, 18, 11, 0.9);
            --card-border: rgba(249, 115, 22, 0.2);
            --shadow: rgba(0, 0, 0, 0.3);
            --color-background: #1a120b;
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background: linear-gradient(135deg, #1a120b 0%, #2d1b13 50%, #1a120b 100%);
            min-height: 100vh;
        }

        #confetti {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 50;
        }

        /* Animated background particles */
        .bg-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            background: var(--gradient-primary);
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite linear;
        }

        .particle:nth-child(1) { width: 80px; height: 80px; top: 10%; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 60px; height: 60px; top: 20%; left: 80%; animation-delay: -5s; }
        .particle:nth-child(3) { width: 100px; height: 100px; top: 60%; left: 20%; animation-delay: -10s; }
        .particle:nth-child(4) { width: 40px; height: 40px; top: 80%; left: 90%; animation-delay: -15s; }
        .particle:nth-child(5) { width: 70px; height: 70px; top: 40%; left: 60%; animation-delay: -7s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-30px) rotate(120deg); }
            66% { transform: translateY(15px) rotate(240deg); }
        }

        /* Floating shapes */
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: floatShape 15s infinite linear;
        }

        .shape:nth-child(1) {
            width: 100px;
            height: 100px;
            background: var(--gradient-primary);
            border-radius: 30%;
            top: 10%;
            left: -10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 80px;
            height: 80px;
            background: var(--gradient-secondary);
            border-radius: 50%;
            top: 70%;
            left: -10%;
            animation-delay: -5s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            background: var(--gradient-accent);
            border-radius: 20%;
            top: 40%;
            left: -10%;
            animation-delay: -10s;
        }

        @keyframes floatShape {
            0% {
                transform: translateX(0) translateY(0) rotate(0deg);
            }
            100% {
                transform: translateX(100vw) translateY(-100px) rotate(360deg);
            }
        }

        /* Main text animations */
        .text {
            font-family: "Yanone Kaffeesatz", sans-serif;
            font-size: clamp(60px, 8vw, 120px);
            display: flex;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            user-select: none;
            z-index: 10;
            justify-content: center;
            align-items: center;
        }

        .wrapper {
            padding: 10px 15px;
            display: inline-block;
        }

        .letter {
            transition: ease-out 0.4s;
            transform: translateY(0);
            color: var(--color-primary);
            display: inline-block;
        }

        .wrapper:hover .letter {
            transform: translateY(-20px);
            text-shadow: 0 10px 20px rgba(249, 115, 22, 0.5);
        }

        /* Button styles */
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(249, 115, 22, 0.5);
            animation: glow 2s infinite;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        @keyframes glow {
            0%, 100% { box-shadow: 0 15px 30px rgba(249, 115, 22, 0.5); }
            50% { box-shadow: 0 15px 40px rgba(249, 115, 22, 0.8), 0 0 60px rgba(249, 115, 22, 0.4); }
        }

      
        /* Header logo */
        .header-logo {
            position: absolute;
            left: 25px;
            top: 50%;
            transform: translateY(-50%);
            width: 120px;
            height: auto;
            z-index: 25;
        }

        /* Footer */
        .main-footer {
            background: linear-gradient(135deg, #ff9800, #ff5722);
            color: white;
            padding: 1.5rem 0;
            border-top: 2px solid #ff9800;
            position: relative;
            overflow: hidden;
            margin-top: auto;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .footer-text {
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 18px;
            text-align: center;
            margin: 0;
            font-weight: 700;
            animation: fadeInUp 0.5s ease-out 0.5s both;
        }

        /* Enhanced animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .text {
                font-size: clamp(40px, 10vw, 60px);
            }
            
            .header-logo {
                width: 50px;
                left: 12px;
            }

            .footer-text {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .header-logo {
                width: 50px;
                left: 10px;
            }
            
            .wrapper {
                padding: 5px 10px;
            }
        }

        /* Main layout */
        .main-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .main-sub-text {
            animation: fadeInUp 1s ease-out 1.5s both;
            text-shadow: 0 5px 15px rgba(249, 115, 22, 0.3);
        }

        .portal-section {
            animation: fadeInUp 1s ease-out 2s both;
            margin-top: 3rem;
        }
    </style>
</head>
<body class="main-container font-sans relative">
    <canvas id="confetti"></canvas>
    
    <!-- Background particles -->
    <div class="bg-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
     
    <!-- Header -->
    <div class="w-full text-center py-6 bg-gradient-to-r from-orange-600 via-orange-500 to-orange-700 text-white font-bold shadow-md z-20 relative">
        <div class="text-sm md:text-lg mb-1">THENI MELAPETTAI HINDU NADARGAL URAVINMURAI</div>
        <div class="text-lg md:text-2xl">NADAR SARASWATHI COLLEGE OF ENGINEERING AND TECHNOLOGY</div>
        <div class="header-logo">
           
            <img src="./assets/img/logo/logo.png" alt="NSCET Logo" style="width: 100px; height: auto;">
           
            
        </div>
    </div>

    <!-- Floating shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <!-- Content Area -->
    <div class="content-area">
        <!-- IQ Arena Logo -->
        <div class="top-img">
           
            <img src="./assets/img/logo/iqarena.png" alt="IQ Arena" style="width: 100px; height: auto;">

               
        </div>

        <!-- Main Text -->
        <header class="w-full text-center relative z-10">
            <div class="text">
                <div class="wrapper" data-aos="fade-down-right" data-aos-delay="100"><div class="letter">I</div></div>
                <div class="wrapper" data-aos="fade-down-right" data-aos-delay="200"><div class="letter">Q</div></div>
                <div class="wrapper" data-aos="fade-down-right" data-aos-delay="300"><div class="letter">&nbsp;</div></div>
                <div class="wrapper" data-aos="fade-down-right" data-aos-delay="400"><div class="letter">A</div></div>
                <div class="wrapper" data-aos="fade-down-right" data-aos-delay="500"><div class="letter">R</div></div>
                <div class="wrapper" data-aos="fade-down-right" data-aos-delay="600"><div class="letter">E</div></div>
                <div class="wrapper" data-aos="fade-down-right" data-aos-delay="700"><div class="letter">N</div></div>
                <div class="wrapper" data-aos="fade-down-right" data-aos-delay="800"><div class="letter">A</div></div>
            </div>
        </header>
        
        <!-- Subtitle -->
        <p class="text-center font-bold text-orange-500 main-sub-text text-2xl md:text-4xl px-4 mt-4">
            "The Skill Engine for the Next-Gen Engineers"
        </p>

        <!-- Portal Button -->
        <div class="portal-section">
            <a href="./login.php" class="btn-primary text-white font-semibold py-4 px-8 rounded-xl text-xl">
                Portal
            </a>
        </div>
    </div>

    <!-- Footer -->
    <div class="main-footer">
        <div class="footer-container">
            <p class="footer-text">Developed By Innovative Software Product Industry of NSCET</p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-out',
            once: true
        });

        // Confetti animation
        const canvas = document.getElementById('confetti');
        const ctx = canvas.getContext('2d');
        
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        const confettiPieces = [];
        const colors = ['#f97316', '#ea580c', '#fb923c', '#fdba74', '#fed7aa'];

        for (let i = 0; i < 50; i++) {
            confettiPieces.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                size: Math.random() * 3 + 1,
                speedX: (Math.random() - 0.5) * 2,
                speedY: Math.random() * 2 + 1,
                color: colors[Math.floor(Math.random() * colors.length)],
                opacity: Math.random() * 0.5 + 0.2
            });
        }

        function animateConfetti() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            confettiPieces.forEach(piece => {
                piece.x += piece.speedX;
                piece.y += piece.speedY;
                
                if (piece.y > canvas.height) {
                    piece.y = -10;
                    piece.x = Math.random() * canvas.width;
                }
                
                if (piece.x > canvas.width) piece.x = 0;
                if (piece.x < 0) piece.x = canvas.width;
                
                ctx.globalAlpha = piece.opacity;
                ctx.fillStyle = piece.color;
                ctx.fillRect(piece.x, piece.y, piece.size, piece.size);
            });
            
            requestAnimationFrame(animateConfetti);
        }
        
        animateConfetti();
    </script>
</body>
</html>