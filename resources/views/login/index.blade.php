<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ getSiteTitle('Ingresar') }}</title>
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

    <!-- Formulario de INGRESO -->
    <div class="login-form">
        <form action="{{url('Ingresar')}}" method="post">
            @csrf
            <input type="email" name="mail" placeholder="Correo electrónico" required>
            <input type="password" name="pass" placeholder="Contraseña" required>
            <button type="submit" class="btn-login">Entrar</button>
        </form>
    </div>

    <!-- Panel con información -->
    <div class="login-footer">
        <p><strong>Seguridad conectada</strong><br>GPS + App Android</p>
        
        <div class="tech-icons">
            <span><i class="fas fa-satellite-dish"></i> GPS</span>
            <span><i class="fab fa-android"></i> Android</span>
            <span><i class="fas fa-shield-alt"></i> Seguridad</span>
        </div>
        
        <hr>
        
        <p><a href="#">¿Olvidaste tu contraseña?</a></p>
    </div>
</div>

<div class="corner-logo">
    {{ $isKeySecure ? 'KEYSECURE' : $theme['name'] . ' SECURE' }}
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

</body>
</html>