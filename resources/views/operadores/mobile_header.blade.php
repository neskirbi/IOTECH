<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#2196F3">
    
    <title>IOTECH | Control Chapas</title>
    
    <!-- Icono -->
    <link rel="icon" type="image/png" href="{{ asset('images/icono1.jpg') }}">
    
    <!-- Bootstrap 5 Mobile -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Leaflet Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    
    <!-- Estilos personalizados -->
    <style>
        * {
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
            user-select: none;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            height: 100vh;
            padding-bottom: 70px; /* Espacio para el bottom menu */
        }
        
        #map {
            width: 100%;
            height: 60vh;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-top: 10px;
        }
        
        .status-card {
            background: white;
            border-radius: 15px;
            padding: 15px;
            margin: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            padding: 15px 30px;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s;
        }
        
        .btn-primary:active {
            transform: scale(0.98);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            border-radius: 50px;
            padding: 15px 30px;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);
        }
        
        .btn-secondary:active {
            transform: scale(0.98);
        }
        
        .bottom-menu {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 0;
            box-shadow: 0 -2px 20px rgba(0,0,0,0.1);
            z-index: 1000;
            height: 60px;
        }
        
        .menu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 5px 15px;
            color: #666;
            text-decoration: none;
            font-size: 12px;
            transition: all 0.3s;
        }
        
        .menu-item.active {
            color: #667eea;
        }
        
        .menu-item i {
            font-size: 20px;
            margin-bottom: 3px;
        }
        
        .modal-mobile {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }
        
        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 25px;
            width: 90%;
            max-width: 400px;
            animation: slideUp 0.3s;
        }
        
        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .bluetooth-status {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }
        
        .bluetooth-connected {
            background: #4CAF50;
            box-shadow: 0 0 10px #4CAF50;
        }
        
        .bluetooth-disconnected {
            background: #f44336;
        }
        
        .codigo-resultado {
            font-size: 32px;
            font-weight: bold;
            color: #2196F3;
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background: #f0f8ff;
            border-radius: 10px;
            letter-spacing: 2px;
        }
        
        .loader {
            display: none;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Responsive */
        @media (max-height: 700px) {
            #map {
                height: 50vh;
            }
        }/* Estilos para el status Bluetooth en el log */
        .bluetooth-status-log {
            border: 1px solid #e9ecef;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        }

        .bluetooth-status-log i {
            font-size: 16px;
        }

        /* Estilos para logs de Bluetooth */
        .log-bluetooth {
            background-color: rgba(33, 150, 243, 0.05);
            border-left: 3px solid #2196F3;
        }

        /* Animación para nuevos logs */
        @keyframes highlightLog {
            0% { background-color: rgba(33, 150, 243, 0.2); }
            100% { background-color: transparent; }
        }

        .border-bottom {
            animation: highlightLog 1s ease-out;
        }
    </style>
</head>
<body>