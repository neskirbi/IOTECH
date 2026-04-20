<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IOTECH | Nueva Contraseña</title>
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

        /* Formulario de nueva contraseña */
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

        /* Mensajes de validación */
        .validation-message {
            font-size: 12px;
            margin-top: -12px;
            margin-bottom: 12px;
            padding-left: 5px;
        }

        .error-message {
            color: #e74c3c;
        }

        .success-message {
            color: #27ae60;
        }

        /* Panel secundario */
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

    <!-- Formulario de NUEVA CONTRASEÑA -->
    <div class="signup">
        <form action="{{url('savepass')}}/{{$usuario->id}}" method="post" id="passwordForm">
            @csrf
            <label for="chk"><i class="fas fa-key"></i> Nueva Contraseña</label>
            
            <input type="password" name="pass" id="pass" placeholder="Nueva Contraseña" required onkeyup="validarPassword();">
            <div id="passError" class="validation-message"></div>
            
            <input type="password" name="pass2" id="pass2" placeholder="Confirmar Contraseña" required onkeyup="validarPassword();">
            <div id="pass2Error" class="validation-message"></div>
            
            <button type="submit" id="submitBtn">Actualizar Contraseña</button>
        </form>
    </div>

    <!-- Panel informativo -->
    <div class="login">
        <label>IOTECH</label>
        <p><strong>Seguridad y tecnología</strong><br>Protege tu cuenta con una contraseña segura</p>
        
        <div class="tech-icons">
            <span><i class="fas fa-shield-alt"></i> Seguridad</span>
            <span><i class="fas fa-lock"></i> Encriptación</span>
            <span><i class="fas fa-database"></i> Respaldo</span>
        </div>
        
        <hr>
        
        <p><i class="fas fa-info-circle"></i> La contraseña debe tener al menos 6 caracteres</p>
        <p><a href="{{url('/')}}">← Volver al inicio</a></p>
    </div>
</div>

<div class="corner-logo">
    <i class="fas fa-microchip"></i> IOTECH Secure
</div>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<script>
    function validarPassword() {
        const pass = document.getElementById('pass').value;
        const pass2 = document.getElementById('pass2').value;
        const passError = document.getElementById('passError');
        const pass2Error = document.getElementById('pass2Error');
        const submitBtn = document.getElementById('submitBtn');
        
        let isValid = true;
        
        // Validar contraseña principal
        if (pass.length > 0 && pass.length < 6) {
            passError.innerHTML = '<span class="error-message"><i class="fas fa-exclamation-circle"></i> La contraseña debe tener al menos 6 caracteres</span>';
            passError.className = 'validation-message error-message';
            isValid = false;
        } else if (pass.length >= 6) {
            passError.innerHTML = '<span class="success-message"><i class="fas fa-check-circle"></i> Contraseña válida</span>';
            passError.className = 'validation-message success-message';
        } else {
            passError.innerHTML = '';
        }
        
        // Validar confirmación
        if (pass2.length > 0 && pass !== pass2) {
            pass2Error.innerHTML = '<span class="error-message"><i class="fas fa-exclamation-circle"></i> Las contraseñas no coinciden</span>';
            pass2Error.className = 'validation-message error-message';
            isValid = false;
        } else if (pass2.length > 0 && pass === pass2 && pass.length >= 6) {
            pass2Error.innerHTML = '<span class="success-message"><i class="fas fa-check-circle"></i> Las contraseñas coinciden</span>';
            pass2Error.className = 'validation-message success-message';
        } else if (pass2.length > 0 && pass === pass2 && pass.length < 6) {
            pass2Error.innerHTML = '<span class="error-message"><i class="fas fa-exclamation-circle"></i> La contraseña es demasiado corta</span>';
            pass2Error.className = 'validation-message error-message';
            isValid = false;
        } else {
            pass2Error.innerHTML = '';
        }
        
        // Habilitar/deshabilitar botón
        submitBtn.disabled = !isValid;
        if (!isValid) {
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';
        } else {
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        }
    }
    
    // Validar al cargar por si hay valores preexistentes
    document.addEventListener('DOMContentLoaded', function() {
        validarPassword();
    });
</script>

</body>
</html>