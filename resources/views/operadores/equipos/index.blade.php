<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Oll-ON | Contraseña Actualizada</title>
    @include('header')
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Elementos decorativos de fondo */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(0,224,255,0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Contenedor principal */
        .main {
            width: 100%;
            max-width: 480px;
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(10px);
            border-radius: 48px;
            border: 1px solid rgba(255,255,255,0.1);
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Sección de éxito */
        .success-section {
            padding: 50px 35px;
            text-align: center;
        }

        /* Icono de éxito */
        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #00e0ff, #0099cc);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: pulse 0.8s ease-out;
        }

        @keyframes pulse {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-icon i {
            font-size: 50px;
            color: white;
        }

        .success-title {
            font-size: 32px;
            font-weight: 800;
            color: white;
            margin-bottom: 15px;
        }

        .success-title span {
            color: #00e0ff;
        }

        .success-message {
            color: rgba(255,255,255,0.7);
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .divider {
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #00e0ff, transparent);
            margin: 20px auto;
            border-radius: 3px;
        }

        /* Botón de acceso */
        .btn-login {
            background: linear-gradient(135deg, #00e0ff, #0099cc);
            border: none;
            padding: 16px 32px;
            border-radius: 50px;
            color: #000;
            font-weight: 700;
            font-size: 18px;
            width: 100%;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            text-decoration: none;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,224,255,0.3);
            color: #000;
        }

        .btn-login i {
            font-size: 20px;
        }

        /* Panel informativo inferior */
        .info-panel {
            background: rgba(0,0,0,0.4);
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .info-panel label {
            display: inline-block;
            font-size: 28px;
            font-weight: 800;
            color: white;
            background: #000000;
            padding: 8px 24px;
            border-radius: 50px;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        .info-panel p {
            color: rgba(255,255,255,0.6);
            font-size: 14px;
            margin: 10px 0;
        }

        .tech-icons {
            display: flex;
            justify-content: center;
            gap: 28px;
            margin: 20px 0 15px;
            color: rgba(255,255,255,0.5);
            font-size: 13px;
        }

        .tech-icons i {
            color: #00e0ff;
            margin-right: 6px;
            font-size: 14px;
        }

        hr {
            border: none;
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 20px 0;
        }

        .info-link {
            color: #00e0ff;
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s;
        }

        .info-link:hover {
            text-decoration: underline;
        }

        /* Logo en esquina */
        .corner-logo {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 12px;
            color: rgba(255,255,255,0.3);
            background: rgba(0,0,0,0.3);
            padding: 6px 12px;
            border-radius: 20px;
            backdrop-filter: blur(5px);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .success-section {
                padding: 40px 25px;
            }
            .success-title {
                font-size: 28px;
            }
            .success-icon {
                width: 80px;
                height: 80px;
            }
            .success-icon i {
                font-size: 40px;
            }
            .info-panel label {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

@include('toast.toasts')

<div class="main">
    <!-- Sección de éxito - Contraseña establecida -->
    <div class="success-section">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1 class="success-title">
            ¡Contraseña <span>actualizada!</span>
        </h1>
        
        <div class="divider"></div>
        
        <p class="success-message">
            Tu nueva contraseña ha sido establecida correctamente.<br>
            Ya puedes ingresar a la aplicación Oll-ON con tus credenciales.
        </p>
        
      
    </div>

    <!-- Panel informativo -->
    <div class="info-panel">
        <label>Oll-ON</label>
        <p><strong>Seguridad conectada</strong><br>GPS + App Android</p>
        
        <div class="tech-icons">
            <span><i class="fas fa-satellite-dish"></i> GPS</span>
            <span><i class="fab fa-android"></i> Android</span>
            <span><i class="fas fa-shield-alt"></i> Seguridad</span>
        </div>
        
        <hr>
        
        <p><i class="fas fa-info-circle"></i> ¿Problemas para ingresar? <a href="#" class="info-link">Contacta soporte</a></p>
    </div>
</div>

<div class="corner-logo">
    <i class="fas fa-shield-alt"></i> Oll-ON Secure
</div>

</body>
</html>