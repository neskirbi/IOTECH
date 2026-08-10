<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oll-ON | Ingresar</title>
    @include('header')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* ============================================
           LOGIN OSCURO CON NEÓN - OIION THEME
           ============================================ */
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            min-height: 100vh;
            background: #050a15 !important;
            font-family: 'Inter', sans-serif !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 20px !important;
            margin: 0 !important;
            position: relative !important;
            top: 0 !important;
            left: 0 !important;
            overflow-x: hidden !important;
        }

        /* Contenedor principal */
        .main {
            width: 380px;
            max-width: 100%;
            background: rgba(11, 15, 25, 0.95) !important;
            border-radius: 24px !important;
            box-shadow: 
                0 0 30px rgba(6, 182, 212, 0.08),
                0 20px 60px rgba(0,0,0,0.8) !important;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.06);
            backdrop-filter: blur(10px);
            margin: 200px auto 0 auto !important;
            position: relative !important;
            top: 0 !important;
        }

        /* Logo + Nombre juntos */
        .login-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 35px 0 15px 0;
            background: transparent !important;
        }

        .login-header img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
        }

        .login-header h1 {
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 2px;
        }

        .login-header h1 span {
            color: #06b6d4;
        }

        #chk {
            display: none;
        }

        /* Formulario de ingreso */
        .signup {
            padding: 10px 30px 30px;
            background: transparent !important;
        }

        .signup label {
            display: none;
        }

        .signup input {
            width: 100%;
            padding: 12px 16px;
            margin-bottom: 14px;
            background: rgba(255,255,255,0.04) !important;
            border: 1px solid rgba(255,255,255,0.06) !important;
            border-radius: 12px !important;
            color: #ffffff !important;
            font-size: 14px;
            font-family: 'Inter', sans-serif !important;
            transition: 0.3s;
        }

        .signup input:focus {
            outline: none;
            border-color: #06b6d4 !important;
            box-shadow: 0 0 25px rgba(6, 182, 212, 0.06) !important;
            background: rgba(255,255,255,0.07) !important;
        }

        .signup input::placeholder {
            color: rgba(255,255,255,0.2);
        }

        .signup button {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
            border: none !important;
            border-radius: 12px !important;
            color: #000 !important;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .signup button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(6, 182, 212, 0.3) !important;
            background: linear-gradient(135deg, #22d3ee, #06b6d4) !important;
        }

        /* Panel secundario */
        .login {
            background: rgba(0,0,0,0.2) !important;
            padding: 25px 25px;
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.04) !important;
        }

        .login p {
            color: rgba(255,255,255,0.4) !important;
            font-size: 13px;
            margin: 8px 0;
            background: transparent !important;
        }

        .login p strong {
            color: #ffffff !important;
        }

        .login a {
            color: #22d3ee !important;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            font-size: 13px;
        }

        .login a:hover {
            color: #ffffff !important;
            text-shadow: 0 0 20px rgba(6, 182, 212, 0.2);
        }

        .tech-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 14px 0 10px;
            color: rgba(255,255,255,0.2) !important;
            font-size: 11px;
            background: transparent !important;
        }

        .tech-icons i {
            color: #06b6d4;
            margin-right: 4px;
            font-size: 12px;
        }

        hr {
            border: none;
            height: 1px;
            background: rgba(255,255,255,0.04) !important;
            margin: 14px 0;
        }

        .corner-logo {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
            color: rgba(255,255,255,0.04);
            letter-spacing: 2px;
            background: transparent;
            padding: 0;
        }

        /* Resetear estilos de AdminLTE */
        .wrapper,
        .main-header,
        .main-sidebar,
        .content-wrapper,
        .main-footer {
            all: unset !important;
        }
    </style>
</head>
<body>

@include('toast.toasts')

<div class="main">
    <!-- Logo + Nombre -->
    <div class="login-header">
        <img src="{{ asset('images/oiin-logo.png') }}" alt="Oll-ON Logo">
        <h1>Oll-<span>ON</span></h1>
    </div>

    <input type="checkbox" id="chk" aria-hidden="true">

    <!-- Formulario de INGRESO -->
    <div class="signup">
        <form action="{{url('Ingresar')}}" method="post">
            @csrf
            <label for="chk">Ingresar</label>
            <input type="email" name="mail" placeholder="Correo electrónico" required>
            <input type="password" name="pass" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
    </div>

    <!-- Panel con información de Oll-ON -->
    <div class="login">
        <p><strong>Seguridad conectada</strong><br>GPS + App Android</p>
        
        <div class="tech-icons">
            <span><i class="fas fa-satellite-dish"></i> GPS</span>
            <span><i class="fab fa-android"></i> Android</span>
            <span><i class="fas fa-shield-alt"></i> Seguridad</span>
        </div>
        
        <hr>
        
        <p>¿No tienes cuenta? <a href="{{url('create')}}">Regístrate aquí</a></p>
        <p><a href="#">¿Olvidaste tu contraseña?</a></p>
    </div>
</div>

<div class="corner-logo">
    OLL-ON SECURE
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

</body>
</html>