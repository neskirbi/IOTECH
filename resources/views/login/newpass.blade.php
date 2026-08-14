<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ getSiteTitle('Nueva Contraseña') }}</title>
    @include('header')
</head>
<body class="login-page">

@include('toast.toasts')

<div class="login-container">
    <!-- Logo + Nombre (Dinámico según tema) -->
    <div class="login-header">
        @php
            $theme = getTheme();
            $isKeySecure = isKeySecure();
        @endphp
        
        <!-- Logo -->
        <img src="{{ asset($theme['logo'] ?? 'images/oiin-logo.png') }}" alt="{{ $theme['name'] }}">
        
        <!-- Nombre: Solo para OIION, KeySecure solo logo -->
        @if(!$isKeySecure)
            <h1>{{ $theme['name'] }}</h1>
        @endif
    </div>

    <!-- Formulario de NUEVA CONTRASEÑA -->
    <div class="login-form">
        <form action="{{url('savepass')}}/{{$usuario->id}}" method="post" id="passwordForm">
            @csrf
            
            <input type="password" name="pass" id="pass" placeholder="Nueva Contraseña" required onkeyup="validarPassword();">
            <div id="passError" class="validation-message"></div>
            
            <input type="password" name="pass2" id="pass2" placeholder="Confirmar Contraseña" required onkeyup="validarPassword();">
            <div id="pass2Error" class="validation-message"></div>
            
            <button type="submit" class="btn-login" id="submitBtn" disabled>Actualizar Contraseña</button>
        </form>
    </div>

    <!-- Panel informativo -->
    <div class="login-footer">
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
    {{ $isKeySecure ? 'KEYSECURE' : $theme['name'] . ' SECURE' }}
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
            isValid = false;
        } else if (pass.length >= 6) {
            passError.innerHTML = '<span class="success-message"><i class="fas fa-check-circle"></i> Contraseña válida</span>';
        } else {
            passError.innerHTML = '';
        }
        
        // Validar confirmación
        if (pass2.length > 0 && pass !== pass2) {
            pass2Error.innerHTML = '<span class="error-message"><i class="fas fa-exclamation-circle"></i> Las contraseñas no coinciden</span>';
            isValid = false;
        } else if (pass2.length > 0 && pass === pass2 && pass.length >= 6) {
            pass2Error.innerHTML = '<span class="success-message"><i class="fas fa-check-circle"></i> Las contraseñas coinciden</span>';
        } else if (pass2.length > 0 && pass === pass2 && pass.length < 6) {
            pass2Error.innerHTML = '<span class="error-message"><i class="fas fa-exclamation-circle"></i> La contraseña es demasiado corta</span>';
            isValid = false;
        } else {
            pass2Error.innerHTML = '';
        }
        
        // Habilitar/deshabilitar botón
        submitBtn.disabled = !isValid;
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        validarPassword();
    });
</script>

</body>
</html>