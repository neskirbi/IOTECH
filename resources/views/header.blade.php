<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- ============================================================
     DETECCIÓN DE DOMINIO PARA TEMAS (Usando Helper)
     ============================================================ -->
@php
    $theme = getTheme();
    $isKeySecure = isKeySecure();
@endphp

<!-- Favicon dinámico -->
<link rel="icon" type="image/x-icon" href="{{ asset($theme['favicon']) }}">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset($theme['favicon']) }}">

<!-- Metodos -->
<script src="{{ asset('js/metodos.js') }}?version={{Version()}}"></script>

<!--Para la mensajeria apariencia y funciones-->
<link href="{{ asset('mensajeria/css/mensajeria.css') }}?version={{Version()}}" rel="stylesheet">
<script src="{{ asset('mensajeria/js/mensajeria.js') }}?version={{Version()}}"></script>

<!-- ============================================================
     TIPOGRAFÍA DINÁMICA (Según el tema)
     ============================================================ -->
@if($isKeySecure)
    <!-- KeySecure usa Archivo + JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;600;700;800;900&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
@else
    <!-- OIION usa Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endif

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Bootstrap 4 (Base de AdminLTE) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<!-- AdminLTE Theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<!-- Tema Personalizado (Dinámico según dominio) -->
<link rel="stylesheet" href="{{ asset($theme['css']) }}?version={{Version()}}">

<!-- Script personalizado para Toasts -->
<script src="{{ asset('js/oiion-toast.js') }}?version={{Version()}}"></script>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

@include('layouts.firebaseanalytics')