<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oll-ON | Ingresar</title>
    @include('header')
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #e8f0fe 0%, #d4e4fc 100%);
            font-family: 'Jost', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Contenedor principal - tarjeta blanca */
        .main {
            width: 420px;
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        #chk {
            display: none;
        }

        /* Formulario de ingreso */
        .signup {
            padding: 40px 35px;
        }

        .signup label {
            display: block;
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            color: #000000;
            margin-bottom: 35px;
            letter-spacing: 1px;
        }

        .signup label i {
            color: #00aaff;
            margin-right: 8px;
        }

        .signup input {
            width: 100%;
            padding: 14px 18px;
            margin-bottom: 18px;
            background: #f5f7fa;
            border: 1px solid #e0e4e8;
            border-radius: 14px;
            color: #1a1a2e;
            font-size: 15px;
            font-family: 'Jost', sans-serif;
            transition: 0.2s;
        }

        .signup input:focus {
            outline: none;
            border-color: #00aaff;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(0,170,255,0.1);
        }

        .signup input::placeholder {
            color: #999;
        }

        .signup button {
            width: 100%;
            padding: 14px;
            background: #000000;
            border: none;
            border-radius: 14px;
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 10px;
        }

        .signup button:hover {
            background: #00aaff;
            transform: translateY(-2px);
        }

        /* Panel secundario (logo Oll-ON) */
        .login {
            background: #f8fafc;
            padding: 35px 30px;
            text-align: center;
            border-top: 1px solid #eef2f6;
        }

        .login label {
            display: inline-block;
            font-size: 32px;
            font-weight: 800;
            color: white;
            background: #000000;
            padding: 10px 28px;
            border-radius: 50px;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        .login p {
            color: #4a5568;
            font-size: 14px;
            margin: 12px 0;
        }

        .login a {
            color: #00aaff;
            text-decoration: none;
            font-weight: 600;
        }

        .login a:hover {
            text-decoration: underline;
        }

        .tech-icons {
            display: flex;
            justify-content: center;
            gap: 28px;
            margin: 20px 0 15px;
            color: #666;
            font-size: 13px;
        }

        .tech-icons i {
            color: #00aaff;
            margin-right: 6px;
            font-size: 14px;
        }

        hr {
            border: none;
            height: 1px;
            background: #e2e8f0;
            margin: 20px 0;
        }

        /* Logo pequeño en la esquina (opcional) */
        .corner-logo {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 12px;
            color: #aaa;
            background: rgba(0,0,0,0.05);
            padding: 6px 12px;
            border-radius: 20px;
        }
    </style>
</head>
<body>

@include('toast.toasts')

<div class="main">
    <input type="checkbox" id="chk" aria-hidden="true">

    <!-- Formulario de INGRESO -->
    <div class="signup">
        <form action="{{url('Ingresar')}}" method="post">
            @csrf
            <label for="chk"><i class="fas fa-lock"></i> Ingresar</label>
            <input type="email" name="mail" placeholder="Correo electrónico" required>
            <input type="password" name="pass" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
    </div>

    <!-- Panel con información de Oll-ON -->
    <div class="login">
        <form action="{{url('create')}}" method="get">
            <label>Oll-ON</label>
            <p><strong>Seguridad conectada</strong><br>GPS + App Android</p>
            
            <div class="tech-icons">
                <span><i class="fas fa-satellite-dish"></i> GPS</span>
                <span><i class="fab fa-android"></i> Android</span>
                <span><i class="fas fa-shield-alt"></i> Seguridad</span>
            </div>
            
            <hr>
            
            <p>¿No tienes cuenta? <a href="{{url('create')}}">Regístrate aquí</a></p>
            <p><a href="#">¿Olvidaste tu contraseña?</a></p>
        </form>
    </div>
</div>

<div class="corner-logo">
    <i class="fas fa-shield-alt"></i> Oll-ON Secure
</div>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

</body>
</html>