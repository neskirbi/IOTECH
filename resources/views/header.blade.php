<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">


<!-- Metodos -->
<script src="{{ asset('js/metodos.js') }}?version={{Version()}}"></script>

<!--Para la mensajeria apariencia y funciones-->
<link href="{{ asset('mensajeria/css/mensajeria.css') }}?version={{Version()}}" rel="stylesheet">
<script src="{{ asset('mensajeria/js/mensajeria.js') }}?version={{Version()}}"></script>


<!-- Google Font: Inter -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Bootstrap 4 (Base de AdminLTE) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<!-- AdminLTE Theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<!-- Tema Personalizado Cyber/Neón OIIon -->
<link rel="stylesheet" href="{{ asset('css/oiion-theme.css') }}">

<!-- FontAwesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Script personalizado para Toasts -->
<script src="{{ asset('js/oiion-toast.js') }}?version={{Version()}}"></script>


 <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

 @include('layouts.firebaseanalytics')