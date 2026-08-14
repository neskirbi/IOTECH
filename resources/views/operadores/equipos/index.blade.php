<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ getSiteTitle('Contraseña Actualizada') }}</title>
    @include('header')
</head>
<body class="login-page">

@include('toast.toasts')

<div class="login-container success-container">
    <!-- Sección de éxito - Contraseña establecida -->
    <div class="success-section">
        @php
            $theme = getTheme();
            $isKeySecure = isKeySecure();
        @endphp
        
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1 class="success-title">
            ¡Contraseña <span>actualizada!</span>
        </h1>
        
        <div class="divider"></div>
        
        <p class="success-message">
            Tu nueva contraseña ha sido establecida correctamente.<br>
            Ya puedes ingresar a la aplicación con tus credenciales.
        </p>
        
        <!-- Botón de acceso -->
        <a href="{{ url('/') }}" class="btn-login">
            <i class="fas fa-arrow-right"></i> Ir al inicio
        </a>
    </div>

    <!-- Panel informativo -->
    <div class="login-footer">
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
    {{ $isKeySecure ? 'KEYSECURE' : $theme['name'] . ' SECURE' }}
</div>

</body>
</html>