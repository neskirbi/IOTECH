<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Oll-ON | Seguridad con GPS y App Android - Monitoreo en Tiempo Real</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Oll-ON: Soluciones avanzadas de seguridad con GPS y aplicación Android. Protege tu flota, familia o negocio con rastreo en tiempo real.">
    <meta name="keywords" content="seguridad, GPS, app Android, rastreo vehicular, monitoreo, Oll-ON">

    <!-- Favicon -->
    <link href="{{asset('img/favicon.ico')}}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS Animación -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #000000;
            --secondary: #ffffff;
            --accent: #00e0ff;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Logo Oll-ON: fondo negro, letras blancas */
        .logo-ollon {
            background-color: #000000;
            padding: 8px 18px;
            border-radius: 40px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .logo-ollon h1 {
            color: white;
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: 1px;
            margin: 0;
        }

        .logo-ollon span {
            font-size: 1rem;
            font-weight: 400;
            color: #cccccc;
        }

        .navbar {
            background-color: #0a0a0a !important;
            padding: 15px 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }

        .navbar-nav .nav-link {
            color: #e2e8f0 !important;
            font-weight: 500;
            margin: 0 10px;
            transition: 0.2s;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #00e0ff !important;
        }

        .btn-primary-custom {
            background-color: #00e0ff;
            border: none;
            color: #000;
            font-weight: 700;
            padding: 12px 28px;
            border-radius: 40px;
            transition: 0.2s;
        }

        .btn-primary-custom:hover {
            background-color: #ffffff;
            color: #000;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,224,255,0.3);
        }

        .btn-android {
            background-color: #3DDC84;
            border: none;
            color: #000;
            font-weight: 700;
            padding: 12px 28px;
            border-radius: 40px;
            transition: 0.2s;
        }

        .btn-android:hover {
            background-color: #ffffff;
            color: #000;
            transform: translateY(-2px);
        }

        .btn-outline-light-custom {
            border: 2px solid white;
            background: transparent;
            color: white;
            border-radius: 40px;
            padding: 10px 24px;
            font-weight: 600;
        }

        .btn-outline-light-custom:hover {
            background: white;
            color: black;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%);
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
        }

        .hero .highlight {
            color: #00e0ff;
            border-bottom: 3px solid #00e0ff;
        }

        /* Tarjetas de servicios */
        .service-card {
            background: white;
            border-radius: 28px;
            padding: 2rem 1.5rem;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #eef2ff;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 40px rgba(0,0,0,0.1);
            border-color: #00e0ff;
        }

        .service-icon {
            font-size: 3rem;
            color: #00e0ff;
            margin-bottom: 1.5rem;
        }

        .app-section {
            background: linear-gradient(120deg, #f0f9ff 0%, #e6f0fa 100%);
        }

        .footer {
            background-color: #050505;
            color: #aaa;
        }

        .back-to-top {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background: #00e0ff;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: black;
            font-size: 1.5rem;
            z-index: 99;
            transition: 0.2s;
            text-decoration: none;
        }

        .badge-android {
            background-color: #3DDC84;
            color: #000;
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.2rem;
            }
            .logo-ollon h1 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>

<body>

    <!-- Topbar con acceso / login -->
    <div class="container-fluid bg-dark py-2">
        <div class="container">
            <div class="row">
                <div class="col-12 text-end">
                    <a href="{{url('login')}}" class="text-white-50 me-3">
                        <i class="fa fa-user me-1"></i> Ingresar
                    </a>
                    <a href="#" class="text-white-50">
                        <i class="fas fa-headset me-1"></i> Soporte 24/7
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar principal -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <!-- Logo Oll-ON -->
            <a class="navbar-brand" href="#">
                <div class="logo-ollon">
                    <h1>Oll-ON</h1>
                    <span><i class="fas fa-shield-alt"></i> Secure</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#soluciones">Soluciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="#app">App Android</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gps">GPS Tracking</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                </ul>
                <a href="#" class="btn btn-primary-custom ms-lg-3">Cotizar ahora</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <span class="badge-android mb-3 d-inline-block"><i class="fab fa-android me-1"></i> Exclusivo Android</span>
                    <h1 class="mb-4">Seguridad que <span class="highlight">siempre te acompaña</span>, donde estés.</h1>
                    <p class="lead mb-4 text-white-70">Monitoreo en tiempo real, alertas inteligentes y control total desde tu dispositivo Android. Oll-ON protege tu flota, familia o negocio con tecnología de rastreo de última generación.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{asset('apk/oll-on_v1.0.0.apk')}}" class="btn btn-android btn-lg px-5" download>
                            <i class="fab fa-android me-2"></i>Descargar APK v1.0.0
                        </a>
                        <a href="#soluciones" class="btn btn-outline-light-custom btn-lg"><i class="fas fa-map-marker-alt me-2"></i>Ver soluciones</a>
                    </div>
                    <div class="mt-5 d-flex gap-4">
                        <div><i class="fas fa-chart-line" style="color:#00e0ff"></i> <span class="text-white">Tecnología en expansión</span></div>
                        <div><i class="fas fa-rocket" style="color:#00e0ff"></i> <span class="text-white">Innovación constante</span></div>
                        <div><i class="fas fa-clock" style="color:#00e0ff"></i> <span class="text-white">Soporte 24/7</span></div>
                    </div>
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <img src="{{asset('images/home/pexels-photo-699122.jpeg')}}" alt="App Android seguridad GPS" class="img-fluid rounded-4 shadow-lg" style="max-height: 450px; object-fit: cover; width: 100%;">
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de servicios -->
    <section id="soluciones" class="py-5 py-md-8">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold">Soluciones integrales de <span style="color:#00e0ff">seguridad conectada</span></h2>
                <p class="lead text-muted">Integramos hardware GPS de última generación con nuestra app Android para que nunca pierdas el control.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4" data-aos="zoom-in">
                    <div class="service-card">
                        <div class="service-icon"><i class="fab fa-android"></i></div>
                        <h4>App Oll-ON para Android</h4>
                        <p>Visualiza ubicación en tiempo real, historial de rutas, zonas de seguridad y alertas instantáneas en tu celular Android.</p>
                        <a href="#" class="text-decoration-none fw-bold">Saber más →</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-satellite-dish"></i></div>
                        <h4>Rastreo GPS 4G</h4>
                        <p>Dispositivos de alta precisión, resistentes a interferencias, con batería de larga duración y geocercas.</p>
                        <a href="#" class="text-decoration-none fw-bold">Saber más →</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-chart-line"></i></div>
                        <h4>Panel de control</h4>
                        <p>Dashboard para empresas: flotas, reportes de conducción, alertas de velocidad y mantenimiento predictivo.</p>
                        <a href="#" class="text-decoration-none fw-bold">Saber más →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección App Android destacada -->
    <section id="app" class="app-section py-5">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2" data-aos="fade-left">
                    <img src="{{asset('images/home/pexels-pixabay-267350.jpg')}}" alt="App Android monitoreo" class="img-fluid rounded-4 shadow" style="max-height: 500px; width: 100%; object-fit: cover;">
                </div>
                <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                    <span class="badge-android mb-3 d-inline-block"><i class="fab fa-android me-1"></i> Solo para Android</span>
                    <h2 class="fw-bold">Controla todo desde <span style="color:#00e0ff">tu dispositivo Android</span></h2>
                    <p class="mt-3 fs-5">Con la app Oll-ON para Android recibes notificaciones al instante si tu vehículo o ser querido sale de un área segura, activas el modo pánico y compartes ubicación en vivo.</p>
                    <ul class="list-unstyled mt-4">
                        <li class="mb-2"><i class="fas fa-check-circle me-2" style="color:#00e0ff"></i> Localización precisa en tiempo real</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2" style="color:#00e0ff"></i> Historial de rutas de hasta 6 meses</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2" style="color:#00e0ff"></i> Compatible con dispositivos GPS Oll-ON</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2" style="color:#00e0ff"></i> Descarga directa APK</li>
                    </ul>
                    <div class="mt-4">
                        <a href="{{asset('apk/oll-on_v1.0.0.apk')}}" class="btn btn-android btn-lg px-5" download>
                            <i class="fab fa-android me-2"></i>Descargar APK v1.0.0
                        </a>
                        <p class="text-muted mt-2 small"><i class="fas fa-download"></i> Versión 1.0 | Requiere Android 8.0+</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección GPS -->
    <section id="gps" class="py-5 bg-white">
        <div class="container py-4">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h2 class="fw-bold">Tecnología GPS de nivel <span class="border-bottom border-3" style="border-color:#00e0ff">profesional</span></h2>
                    <p class="mt-3 lead">Nuestros rastreadores se instalan en minutos y funcionan con redes 4G, ideales para autos, motos, camiones y activos logísticos. Compatibilidad total con nuestra app Android.</p>
                    <div class="row mt-4">
                        <div class="col-6 mb-3">
                            <div class="bg-light p-3 rounded-3">
                                <h3 class="fw-bold" style="color:#00e0ff">±3m</h3>
                                <p class="mb-0">Precisión satelital</p>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="bg-light p-3 rounded-3">
                                <h3 class="fw-bold" style="color:#00e0ff">24/7</h3>
                                <p class="mb-0">Monitoreo continuo</p>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline-dark rounded-pill px-4 mt-2"><i class="fas fa-microchip me-2"></i> Ver dispositivos GPS</a>
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <img src="{{asset('images/home/pexels-leeloothefirst-5428830.jpg')}}" alt="dispositivo GPS" class="img-fluid rounded-4 shadow-lg" style="max-height: 380px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de valores / confianza -->
    <section class="bg-dark text-white py-5">
        <div class="container py-4 text-center">
            <div data-aos="fade-up">
                <i class="fas fa-shield-alt fa-3x mb-3 opacity-50" style="color:#00e0ff"></i>
                <p class="fs-3 fw-light mx-auto" style="max-width: 800px;">"Tecnología confiable, soporte inmediato y un compromiso real con tu seguridad. Oll-ON nace para revolucionar el monitoreo GPS."</p>
                <h5 class="mt-3">— Equipo Oll-ON</h5>
                <div class="mt-4">
                    <i class="fab fa-android fa-2x me-2" style="color:#3DDC84"></i>
                    <span class="text-white-50">Disponible exclusivamente para Android</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contacto" class="footer pt-5 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="logo-ollon mb-3">
                        <h1>Oll-ON</h1>
                    </div>
                    <p>Seguridad conectada mediante GPS y app Android. Protección real para lo que más valoras.</p>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 class="text-white">Enlaces</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">Inicio</a></li>
                        <li><a href="#soluciones" class="text-white-50 text-decoration-none">Soluciones</a></li>
                        <li><a href="#app" class="text-white-50 text-decoration-none">App Android</a></li>
                        <li><a href="#gps" class="text-white-50 text-decoration-none">GPS Tracking</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="text-white">Soporte</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">Contacto técnico</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Centro de ayuda</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Política de privacidad</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="text-white">Contacto directo</h5>
                    <p><i class="fas fa-phone-alt me-2"></i> +52 1 56 1990 3970</p>
                    <p><i class="fas fa-envelope me-2"></i> ventas@oll-on.com</p>
                    <p><i class="fas fa-map-marker-alt me-2"></i> Ciudad de México, México</p>
                </div>
            </div>
            <hr class="bg-secondary">
            <div class="text-center pt-3">
                <p class="mb-0">&copy; 2026 Oll-ON - Seguridad con tecnología GPS y App Android. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if(target) target.scrollIntoView({ behavior: 'smooth' });
            });
        });

        // Back to top
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) $('.back-to-top').fadeIn();
            else $('.back-to-top').fadeOut();
        });
        $('.back-to-top').click(function() {
            $('html, body').animate({scrollTop: 0}, 500);
            return false;
        });
    </script>
</body>

</html>