<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>OII-ON | Arquitecturas Inteligentes y Seguridad con GPS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="OII-ON: Soluciones avanzadas de seguridad con GPS, app Android y arquitectura tecnológica basada en divisiones especializadas: CORE, MOTION, VISION y NEXO.">
    <meta name="keywords" content="OII-ON, CORE, MOTION, VISION, NEXO, seguridad, GPS, app Android, arquitectura tecnológica">

    <!-- Favicon -->
    <link href="{{asset('img/favicon.ico')}}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

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
            background-color: #f8fafc;
        }

        /* Logo OII-ON: fondo negro, letras blancas */
        .logo-oiion {
            background-color: #000000;
            padding: 8px 18px;
            border-radius: 40px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .logo-oiion h1 {
            color: white;
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: 1px;
            margin: 0;
        }

        .logo-oiion span {
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
            margin: 0 5px;
            transition: 0.2s;
            font-size: 0.9rem;
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

        /* Tarjetas de divisiones */
        .division-card {
            background: white;
            border-radius: 28px;
            padding: 2.5rem 2rem;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #eef2ff;
            position: relative;
            overflow: hidden;
        }

        .division-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: #00e0ff;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .division-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 40px rgba(0,0,0,0.08);
            border-color: #00e0ff;
        }

        .division-card:hover::before {
            opacity: 1;
        }

        .division-icon {
            font-size: 2.8rem;
            color: #00e0ff;
            margin-bottom: 1.2rem;
        }

        .principles-list {
            padding-left: 1.2rem;
            margin-top: 1.2rem;
            color: #475569;
            font-size: 0.95rem;
        }

        .principles-list li {
            margin-bottom: 0.5rem;
        }

        .architecture-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            color: white;
            border-radius: 24px;
            padding: 4rem 3rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .about-section {
            background-color: #ffffff;
            border-radius: 24px;
            padding: 4rem 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid #e2e8f0;
        }

        .principle-direction-card {
            background: #f8fafc;
            border-left: 4px solid #00e0ff;
            padding: 1.5rem;
            border-radius: 0 12px 12px 0;
            height: 100%;
            transition: transform 0.2s;
        }

        .principle-direction-card:hover {
            transform: translateX(4px);
            background: #f1f5f9;
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
            .logo-oiion h1 {
                font-size: 1.4rem;
            }
        }

        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }

        * {
            box-sizing: border-box;
        }

        /* === MODAL COTIZACIÓN === */
        .modal-cotizacion .modal-content {
            border-radius: 24px;
            border: none;
            box-shadow: 0 30px 60px rgba(0,0,0,0.3);
        }
        .modal-cotizacion .modal-header {
            border-bottom: none;
            padding: 2rem 2rem 0 2rem;
        }
        .modal-cotizacion .modal-body {
            padding: 1.5rem 2rem 2rem 2rem;
        }
        .modal-cotizacion .modal-footer {
            border-top: none;
            padding: 0 2rem 2rem 2rem;
        }
        .modal-cotizacion .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
        }
        .modal-cotizacion .form-control:focus {
            border-color: #00e0ff;
            box-shadow: 0 0 0 3px rgba(0,224,255,0.15);
        }
        .modal-cotizacion .form-label {
            font-weight: 600;
            color: #1e293b;
        }
        .btn-cotizar-modal {
            background-color: #00e0ff;
            border: none;
            color: #000;
            font-weight: 700;
            padding: 14px 32px;
            border-radius: 40px;
            transition: 0.2s;
            width: 100%;
        }
        .btn-cotizar-modal:hover {
            background-color: #000;
            color: #fff;
            transform: translateY(-2px);
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/oiion-theme.css') }}">
</head>
@include('toast.toasts')
<body>

    <!-- Topbar con acceso / login -->
    <div class="container-fluid bg-dark py-2">
        <div class="container">
            <div class="row">
                <div class="col-12 text-end">
                    <a href="{{url('login')}}" class="text-white-50 me-3 text-decoration-none">
                        <i class="fa fa-user me-1"></i> Ingresar
                    </a>
                    <a href="#" class="text-white-50 text-decoration-none">
                        <i class="fas fa-headset me-1"></i> Soporte 24/7
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar principal -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <!-- Logo OII-ON -->
            <a class="navbar-brand" href="#">
                <div class="logo-oiion">
                    <h1>OII-ON</h1>
                    <span><i class="fas fa-shield-alt"></i> Secure</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="#proyectos">Proyectos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#configuracion">Configuración</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#acerca" style="color: #00e0ff !important;">Acerca de OII-ON</a></li>
                </ul>
                <!-- Botón Cotizar ahora - ABRE EL MODAL -->
                <button type="button" class="btn btn-primary-custom ms-lg-3" data-bs-toggle="modal" data-bs-target="#cotizarModal">
                    Cotizar ahora
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="dashboard">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <span class="badge-android mb-3 d-inline-block"><i class="fab fa-android me-1"></i> Exclusivo Android & Hardware</span>
                    <h1 class="mb-4">Seguridad que <span class="highlight">siempre te acompaña</span>, donde estés.</h1>
                    <p class="lead mb-4 text-white-50">Monitoreo en tiempo real, alertas inteligentes y control total desde tu dispositivo Android. OII-ON protege tu flota, familia o negocio con tecnología de rastreo de última generación.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{asset('apk/oii-on_v2.0.0_20260805.apk')}}" class="btn btn-android btn-lg px-5" download>
                            <i class="fab fa-android me-2"></i>Descargar APK v2.0.0
                        </a>
                        <a href="#core" class="btn btn-outline-light-custom btn-lg"><i class="fas fa-cubes me-2"></i>Ver divisiones</a>
                    </div>
                    <div class="mt-5 d-flex gap-4">
                        <div><i class="fas fa-chart-line" style="color:#00e0ff"></i> <span class="text-white">Tecnología robusta</span></div>
                        <div><i class="fas fa-rocket" style="color:#00e0ff"></i> <span class="text-white">Innovación constante</span></div>
                        <div><i class="fas fa-clock" style="color:#00e0ff"></i> <span class="text-white">Soporte 24/7</span></div>
                    </div>
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <img src="{{asset('images/home/pexels-lastly-699122.jpg')}}" alt="App Android seguridad GPS" class="img-fluid rounded-4 shadow-lg" style="max-height: 450px; object-fit: cover; width: 100%;">
                </div>
            </div>
        </div>
    </section>

    <!-- Secciones de Divisiones -->
    <section class="py-5 py-md-8 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="text-uppercase fw-bold tracking-wider" style="color: #00e0ff; letter-spacing: 2px;">Nuestras Divisiones Tecnológicas</span>
                <h2 class="fw-bold mt-2">Donde la arquitectura se convierte en <span style="color:#00e0ff">tecnología</span></h2>
                <p class="lead text-muted">Especialización e integración de punta a punta.</p>
            </div>

            <div class="row g-4">
                <!-- CORE -->
                <div class="col-lg-4" data-aos="zoom-in" id="core">
                    <div class="division-card">
                        <div class="division-icon"><i class="fas fa-microchip"></i></div>
                        <h3 class="fw-bold h4">CORE</h3>
                        <p class="text-muted fw-semibold small">Donde la arquitectura se convierte en tecnología.</p>
                        <p class="text-muted mt-3">CORE es la división responsable de concebir, desarrollar y proteger el núcleo tecnológico de OII-ON. Aquí convergen la ingeniería electrónica, el firmware, el diseño mecánico, las comunicaciones y la arquitectura de hardware que hacen posible cada solución.</p>
                        <p class="text-muted small">Su misión no es desarrollar dispositivos, sino construir plataformas tecnológicas robustas, modulares y preparadas para evolucionar.</p>
                        <h6 class="fw-bold mt-4 mb-2 text-dark">Principios de CORE</h6>
                        <ul class="principles-list">
                            <li>Diseñamos con visión de largo plazo.</li>
                            <li>La simplicidad es el resultado de una ingeniería profunda.</li>
                            <li>Cada componente debe aportar valor a la arquitectura.</li>
                            <li>La calidad no se inspecciona; se diseña.</li>
                            <li>Protegemos el conocimiento que hace única a OII-ON.</li>
                        </ul>
                    </div>
                </div>

                <!-- MOTION -->
                <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100" id="motion">
                    <div class="division-card">
                        <div class="division-icon"><i class="fas fa-route"></i></div>
                        <h3 class="fw-bold h4">MOTION</h3>
                        <p class="text-muted fw-semibold small">Donde la tecnología genera movimiento.</p>
                        <p class="text-muted mt-3">MOTION conecta la innovación con la operación. Es la división encargada de transformar la tecnología en soluciones funcionales para nuestros clientes mediante la integración, implementación, soporte y evolución operativa.</p>
                        <p class="text-muted small">Su propósito es asegurar que cada solución entregue valor desde el primer día y continúe evolucionando junto con las necesidades del negocio.</p>
                        <h6 class="fw-bold mt-4 mb-2 text-dark">Principios de MOTION</h6>
                        <ul class="principles-list">
                            <li>La tecnología solo tiene sentido cuando genera resultados.</li>
                            <li>Implementar también es innovar.</li>
                            <li>Cada instalación fortalece el conocimiento de la plataforma.</li>
                            <li>Escuchar al cliente es acelerar la evolución.</li>
                            <li>El éxito de nuestros clientes es el éxito de OII-ON.</li>
                        </ul>
                    </div>
                </div>

                <!-- VISION -->
                <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="200" id="vision">
                    <div class="division-card">
                        <div class="division-icon"><i class="fas fa-eye"></i></div>
                        <h3 class="fw-bold h4">VISION</h3>
                        <p class="text-muted fw-semibold small">Donde los datos se convierten en inteligencia.</p>
                        <p class="text-muted mt-3">VISION desarrolla las plataformas digitales que permiten administrar, analizar y transformar la información generada por los dispositivos de OII-ON. Su propósito es convertir cada evento en conocimiento útil para la toma de decisiones.</p>
                        <p class="text-muted small">No desarrolla únicamente software; construye inteligencia para la operación.</p>
                        <h6 class="fw-bold mt-4 mb-2 text-dark">Principios de VISION</h6>
                        <ul class="principles-list">
                            <li>Los datos adquieren valor cuando impulsan mejores decisiones.</li>
                            <li>Diseñamos información clara antes que interfaces complejas.</li>
                            <li>La inteligencia debe ser accesible, confiable y escalable.</li>
                            <li>Cada desarrollo debe responder a una necesidad real.</li>
                            <li>Evolucionamos la plataforma con base en la experiencia del usuario.</li>
                        </ul>
                    </div>
                </div>

                <!-- NEXO -->
                <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="300" id="nexo">
                    <div class="division-card">
                        <div class="division-icon"><i class="fas fa-handshake"></i></div>
                        <h3 class="fw-bold h4">NEXO</h3>
                        <p class="text-muted fw-semibold small">Donde la tecnología crea confianza.</p>
                        <p class="text-muted mt-3">NEXO conecta la innovación con las personas mediante la implementación, la capacitación y el acompañamiento operativo, asegurando que cada solución de OII-ON genere el impacto para el que fue diseñada.</p>
                        <p class="text-muted small">Su propósito es transformar la tecnología en relaciones de confianza duraderas, donde cada cliente se sienta acompañado y respaldado en cada etapa del proceso.</p>
                        <h6 class="fw-bold mt-4 mb-2 text-dark">Principios de NEXO</h6>
                        <ul class="principles-list">
                            <li>La confianza se construye con transparencia y cumplimiento.</li>
                            <li>La capacitación es el puente entre la tecnología y su uso efectivo.</li>
                            <li>Cada interacción debe fortalecer la relación con el cliente.</li>
                            <li>El acompañamiento operativo es parte esencial de la solución.</li>
                            <li>El éxito de nuestros clientes es la base de nuestra reputación.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Resumen Arquitectura -->
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="architecture-banner text-center text-lg-start mb-5" data-aos="fade-up">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <span class="badge bg-info text-dark mb-3 px-3 py-2 fw-bold rounded-pill">Ecosistema OII-ON</span>
                        <h2 class="fw-bold display-6 mb-3">Cuatro divisiones. Una sola arquitectura.</h2>
                        <ul class="list-unstyled text-white-50 fs-5 mb-4">
                            <li class="mb-2"><strong class="text-white">CORE</strong> imagina y construye la tecnología.</li>
                            <li class="mb-2"><strong class="text-white">MOTION</strong> la integra y la convierte en operación.</li>
                            <li class="mb-2"><strong class="text-white">VISION</strong> transforma la información en inteligencia.</li>
                            <li class="mb-2"><strong class="text-white">NEXO</strong> donde la tecnología crea confianza.</li>
                        </ul>
                        <p class="text-white-50 mb-0">Cada división representa una disciplina especializada; juntas conforman una arquitectura capaz de evolucionar, adaptarse y resolver desafíos complejos mediante una filosofía de colaboración, innovación y excelencia.</p>
                    </div>
                    <div class="col-lg-4 text-center">
                        <div class="p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                            <i class="fas fa-network-wired fa-3x mb-3 text-info"></i>
                            <h4 class="fw-bold text-white">Sinergia Total</h4>
                            <p class="small text-white-50 mb-0">Hardware, firmware, conectividad y software trabajando en perfecta sincronía.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Módulos Adicionales -->
    <section class="py-5 bg-light" id="proyectos">
        <div class="container py-3">
            <div class="row g-4">
                <div class="col-md-6" data-aos="fade-right">
                    <div class="p-4 bg-white rounded-4 shadow-sm border h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white p-3 rounded-3 me-3"><i class="fas fa-project-diagram fa-lg"></i></div>
                            <div>
                                <h4 class="fw-bold mb-0">Proyectos</h4>
                                <span class="badge bg-secondary text-light">Contenido pendiente</span>
                            </div>
                        </div>
                        <p class="text-muted mb-0">Espacio reservado para la gestión y seguimiento de implementaciones tecnológicas en desarrollo y despliegue a gran escala.</p>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left" id="configuracion">
                    <div class="p-4 bg-white rounded-4 shadow-sm border h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-dark text-white p-3 rounded-3 me-3"><i class="fas fa-cogs fa-lg"></i></div>
                            <div>
                                <h4 class="fw-bold mb-0">Configuración</h4>
                                <span class="badge bg-secondary text-light">Contenido pendiente</span>
                            </div>
                        </div>
                        <p class="text-muted mb-0">Panel de parámetros del sistema, ajustes de red, credenciales de dispositivos y control de accesos operativos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Institucional: Acerca de OII-ON -->
    <section class="py-5 py-md-8 bg-white" id="acerca">
        <div class="container py-5">
            <div class="about-section" data-aos="fade-up">
                <div class="text-center mb-5">
                    <span class="badge bg-dark text-white px-3 py-2 rounded-pill mb-2"><i class="fas fa-info-circle me-1"></i> Identidad Corporativa</span>
                    <h2 class="fw-bold display-5">Acerca de OII-ON</h2>
                    <p class="text-muted lead">Nuestra filosofía, propósito y principios fundamentales.</p>
                </div>

                <!-- Filosofía OII-ON -->
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-10">
                        <div class="p-4 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <h3 class="fw-bold h4 mb-3" style="color: #0f172a;"><i class="fas fa-lightbulb me-2 text-info"></i>Filosofía OII-ON</h3>
                            <p class="text-muted mb-0 fs-5" style="line-height: 1.7;">Creemos que la verdadera innovación no consiste en hacerlo todo, sino en integrar con inteligencia las fortalezas de quienes mejor saben hacerlo. La tecnología debe unir disciplinas, potenciar a las personas y crear soluciones capaces de evolucionar con el tiempo.</p>
                        </div>
                    </div>
                </div>

                <!-- Misión y Visión -->
                <div class="row g-4 mb-5">
                    <div class="col-lg-6" data-aos="fade-right">
                        <div class="p-4 h-100 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <h3 class="fw-bold h4 mb-3 text-dark"><i class="fas fa-bullseye me-2 text-info"></i>Misión</h3>
                            <p class="text-muted" style="line-height: 1.7;">Diseñar arquitecturas tecnológicas que transformen la seguridad física en sistemas inteligentes, integrando hardware, software y datos mediante la especialización de nuestras divisiones y la colaboración estratégica con los mejores aliados de cada industria.</p>
                            <p class="text-muted fw-medium small mb-0">En OII-ON no competimos por hacerlo todo; competimos por integrar mejor que nadie aquello que genera verdadero valor para nuestros clientes.</p>
                            <hr class="my-3 text-muted opacity-25">
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <div class="p-4 h-100 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <h3 class="fw-bold h4 mb-3 text-dark"><i class="fas fa-eye me-2 text-info"></i>Visión</h3>
                            <p class="text-muted" style="line-height: 1.7;">Ser la empresa referente en arquitecturas inteligentes para la protección y administración de activos físicos, construyendo un ecosistema de innovación donde la especialización, las alianzas estratégicas y la evolución tecnológica permitan crear soluciones que trasciendan a las personas, a los productos y al tiempo.</p>
                            <div class="mt-4 p-3 rounded-3" style="background: #e2e8f0; color: #1e293b;">
                                <h6 class="fw-bold mb-1"><i class="fas fa-shield-alt me-1"></i> Nuestra Convicción</h6>
                                <p class="small mb-0">La fortaleza de una empresa no se mide por la cantidad de procesos que controla, sino por la inteligencia con la que integra las capacidades de los mejores especialistas.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Principios de Dirección -->
                <div class="mb-5">
                    <h3 class="fw-bold text-center mb-4">Principios de Dirección</h3>
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                            <div class="principle-direction-card">
                                <h5 class="fw-bold text-dark">1. Protegemos nuestro núcleo tecnológico</h5>
                                <p class="text-muted small mb-0 mt-2">La arquitectura, el conocimiento y la evolución de OII-ON constituyen nuestro activo más valioso.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="principle-direction-card">
                                <h5 class="fw-bold text-dark">2. La especialización genera excelencia</h5>
                                <p class="text-muted small mb-0 mt-2">Cada división desarrolla aquello en lo que puede convertirse en referente.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="principle-direction-card">
                                <h5 class="fw-bold text-dark">3. Las alianzas multiplican capacidades</h5>
                                <p class="text-muted small mb-0 mt-2">Nos asociamos con empresas que dominan disciplinas complementarias para construir soluciones superiores.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="principle-direction-card">
                                <h5 class="fw-bold text-dark">4. Integramos, no improvisamos</h5>
                                <p class="text-muted small mb-0 mt-2">Cada componente, cada línea de código y cada proceso forman parte de una arquitectura diseñada para evolucionar.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="principle-direction-card">
                                <h5 class="fw-bold text-dark">5. Diseñamos sistemas, no dependencias</h5>
                                <p class="text-muted small mb-0 mt-2">El conocimiento pertenece a OII-ON y debe permanecer documentado para garantizar la continuidad de la organización.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                            <div class="principle-direction-card">
                                <h5 class="fw-bold text-dark">6. La innovación solo tiene valor cuando resuelve problemas reales</h5>
                                <p class="text-muted small mb-0 mt-2">Cada desarrollo debe responder a una necesidad concreta del mercado y generar beneficios medibles para nuestros clientes.</p>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 mx-auto" data-aos="fade-up" data-aos-delay="600">
                            <div class="principle-direction-card">
                                <h5 class="fw-bold text-dark">7. Evolucionamos antes de que el mercado nos obligue</h5>
                                <p class="text-muted small mb-0 mt-2">La mejora continua forma parte de nuestra identidad y no de una reacción ante la competencia.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cita Final -->
                <div class="text-center p-4 rounded-4" style="background: #0f172a; color: white;" data-aos="zoom-in">
                    <i class="fas fa-quote-left fa-2x text-info mb-3 opacity-50"></i>
                    <p class="fs-5 fst-italic mb-0" style="max-width: 800px; margin: 0 auto;">"La innovación no consiste en crear más tecnología, sino en integrar el conocimiento adecuado para resolver problemas que antes parecían imposibles."</p>
                    <span class="d-block mt-3 text-info fw-bold">— OII-ON Architecture</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- MODAL DE COTIZACIÓN -->
    <!-- ============================================================ -->
    <div class="modal fade modal-cotizacion" id="cotizarModal" tabindex="-1" aria-labelledby="cotizarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h4 class="modal-title fw-bold" id="cotizarModalLabel">
                            <i class="fas fa-file-invoice text-info me-2"></i>Solicitar Cotización
                        </h4>
                        <p class="text-muted small mb-0">Completa el formulario y te contactaremos en menos de 24 horas.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('cotizacion.enviar') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="cotNombre" class="form-label">Nombre completo *</label>
                                <input type="text" class="form-control" id="cotNombre" name="nombre" placeholder="Ej: Juan Pérez" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cotEmail" class="form-label">Correo electrónico *</label>
                                <input type="email" class="form-control" id="cotEmail" name="email" placeholder="ejemplo@correo.com" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cotTelefono" class="form-label">Teléfono de contacto</label>
                                <input type="tel" class="form-control" id="cotTelefono" name="telefono" placeholder="+52 55 1234 5678">
                            </div>
                            <div class="col-md-6">
                                <label for="cotSolucion" class="form-label">Tipo de solución</label>
                                <select class="form-select" id="cotSolucion" name="tipo_solucion">
                                    <option value="">Selecciona una opción</option>
                                    <option value="flota_vehicular">Rastreo de flota vehicular</option>
                                    <option value="seguridad_personal">Seguridad personal / familiar</option>
                                    <option value="seguridad_empresarial">Seguridad empresarial</option>
                                    <option value="gps_industrial">GPS para maquinaria / activos</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="cotMensaje" class="form-label">Mensaje o requerimientos</label>
                                <textarea class="form-control" id="cotMensaje" name="mensaje" rows="4" placeholder="Cuéntanos qué necesitas, cuántos dispositivos, plazos, etc."></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="cotTerminos" name="terminos" required>
                                   <label class="form-check-label small text-muted" for="cotTerminos">
                                        Acepto que mis datos serán tratados con fines comerciales y de contacto según la 
                                        <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#terminosModal">política de privacidad</a>.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn-cotizar-modal">
                            <i class="fas fa-paper-plane me-2"></i>Enviar cotización
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ============================================================ -->
    <!-- MODAL DE TÉRMINOS Y CONDICIONES -->
    <!-- ============================================================ -->
    <div class="modal fade" id="terminosModal" tabindex="-1" aria-labelledby="terminosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="terminosModalLabel">
                    <i class="fas fa-file-contract text-info me-2"></i>Términos y Condiciones
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <h6 class="fw-bold">1. Aceptación de los Términos</h6>
                <p class="text-muted small">Al utilizar los servicios de OII-ON, aceptas estos términos y condiciones en su totalidad.</p>

                <h6 class="fw-bold mt-3">2. Descripción del Servicio</h6>
                <p class="text-muted small">OII-ON proporciona soluciones de seguridad con GPS, app Android y arquitectura tecnológica basada en divisiones especializadas: CORE, MOTION, VISION y NEXO.</p>

                <h6 class="fw-bold mt-3">3. Privacidad de Datos</h6>
                <p class="text-muted small">Tus datos personales serán tratados con confidencialidad y utilizados únicamente para fines comerciales y de contacto, de acuerdo con nuestra política de privacidad.</p>

                <h6 class="fw-bold mt-3">4. Responsabilidades del Usuario</h6>
                <p class="text-muted small">El usuario se compromete a proporcionar información veraz y actualizada, y a utilizar los servicios de OII-ON de manera responsable.</p>

                <h6 class="fw-bold mt-3">5. Propiedad Intelectual</h6>
                <p class="text-muted small">Todo el contenido, marcas y tecnología de OII-ON están protegidos por derechos de propiedad intelectual.</p>

                <h6 class="fw-bold mt-3">6. Modificaciones</h6>
                <p class="text-muted small">OII-ON se reserva el derecho de modificar estos términos en cualquier momento. Los cambios serán publicados en esta página.</p>

                <h6 class="fw-bold mt-3">7. Contacto</h6>
                <p class="text-muted small">Para cualquier duda o consulta, contáctanos en ventas@oiion.com</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn-cotizar-modal" data-bs-dismiss="modal" style="width: auto; padding: 10px 32px;" onclick="marcarAceptado()">
    <i class="fas fa-check me-2"></i>Acepto los términos
</button>
            </div>
        </div>
    </div>
</div>

<script>
    function marcarAceptado() {
    document.getElementById('cotTerminos').checked = true;
    // Abrir el modal de cotización nuevamente
    var cotizarModal = new bootstrap.Modal(document.getElementById('cotizarModal'));
    cotizarModal.show();
}
</script>

    <!-- Footer -->
    <footer id="contacto" class="footer pt-5 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="logo-oiion mb-3">
                        <h1>OII-ON</h1>
                    </div>
                    <p class="text-white-50">Seguridad conectada mediante arquitecturas inteligentes, GPS y app Android. Protección real para lo que más valoras.</p>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 class="text-white">Divisiones</h5>
                    <ul class="list-unstyled">
                        <li><a href="#core" class="text-white-50 text-decoration-none">CORE</a></li>
                        <li><a href="#motion" class="text-white-50 text-decoration-none">MOTION</a></li>
                        <li><a href="#vision" class="text-white-50 text-decoration-none">VISION</a></li>
                        <li><a href="#nexo" class="text-white-50 text-decoration-none">NEXO</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="text-white">Institucional</h5>
                    <ul class="list-unstyled">
                        <li><a href="#acerca" class="text-white-50 text-decoration-none">Acerca de OII-ON</a></li>
                        <li><a href="#proyectos" class="text-white-50 text-decoration-none">Proyectos</a></li>
                        <li><a href="#configuracion" class="text-white-50 text-decoration-none">Configuración</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="text-white">Contacto directo</h5>
                    <p class="text-white-50 mb-1"><i class="fas fa-phone-alt me-2"></i> +52 1 56 1990 3970</p>
                    <p class="text-white-50 mb-1"><i class="fas fa-envelope me-2"></i> ventas@oiion.com</p>
                    <p class="text-white-50 mb-0"><i class="fas fa-map-marker-alt me-2"></i> Ciudad de México, México</p>
                </div>
            </div>
            <hr class="bg-secondary opacity-25">
            <div class="text-center pt-3">
                <p class="mb-0 text-white-50">&copy; 2026 OII-ON - Arquitecturas Inteligentes. Todos los derechos reservados.</p>
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

        // Smooth scroll para anclajes del menú
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
    <script src="{{ asset('js/oiion-toast.js') }}"></script>
</body>

</html>