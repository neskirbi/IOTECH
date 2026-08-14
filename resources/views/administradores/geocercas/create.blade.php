<!DOCTYPE html>
<html lang="es">
<head>
  @include('header')
  <title>{{ getSiteTitle('Crear Geocerca') }}</title>
  
  <style>
    #map {
      height: 520px;
      width: 100%;
      border-radius: 12px;
      border: 1px solid var(--border-color);
    }
    .color-picker-wrapper {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .color-picker-wrapper input[type="color"] {
      border: 1px solid var(--border-color);
      border-radius: 6px;
      height: 38px;
      width: 50px;
      background: var(--bg-main);
      cursor: pointer;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="background-color: var(--bg-main);">
@include('toast.toasts')
<div class="wrapper">

  <!-- Navbar y Sidebar Neón -->
  @include('administradores.navbar')
  @include('administradores.sidebar')

  <div class="content-wrapper" style="background-color: var(--bg-main);">
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center">
          <div class="col-sm-6">
            <h1 class="m-0 text-white font-weight-bold" style="font-size: 1.5rem;">
              <i class="fas fa-draw-polygon mr-2" style="color: var(--accent-cyan);"></i> Crear Nueva Geocerca
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('operadores') }}" class="text-cyan">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{ route('geocercas.index') }}" class="text-cyan">Geocercas</a></li>
              <li class="breadcrumb-item active text-muted">Crear</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          
          <!-- Módulo Completo: Mapa (Full Width) + Formulario Integrado Abajo -->
          <div class="col-12 mb-4">
            <div class="card card-oiion">
              
              <!-- Header -->
              <div class="card-header border-0 d-flex align-items-center justify-content-between w-100">
                <h3 class="card-title text-white font-weight-bold m-0">
                  <i class="fas fa-map-marked-alt mr-2" style="color: var(--accent-cyan);"></i> Trazo en Mapa y Configuración
                </h3>
              </div>
              
              <div class="card-body p-3">
                <!-- Mapa extendido al 100% (Sin elementos flotantes) -->
                <div class="position-relative mb-4">
                  <div id="map"></div>
                </div>

                <!-- Formulario Integrado debajo del Mapa -->
                <form action="{{ route('geocercas.store') }}" method="POST" id="geocerca-form">
                  @csrf
                  <input type="hidden" id="tipo" name="tipo" value="">

                  <!-- Mensaje de aviso arriba a TODO LO ANCHO cuando no hay selección -->
                  <div id="default-fields-msg" class="row mb-3">
                    <div class="col-12">
                      <div class="p-3 border rounded text-center text-cyan" style="background: rgba(6, 182, 212, 0.05); border-color: var(--border-color) !important;">
                        <i class="fas fa-info-circle mr-2"></i> Selecciona un <strong>Tipo de Geocerca</strong> en el formulario para habilitar el trazo en el mapa.
                      </div>
                    </div>
                  </div>

                  <div class="row align-items-start">
                    
                    <!-- Columna 1: Tipo de Geocerca + Datos Generales -->
                    <div class="col-md-5 mb-3">
                      <div class="form-group mb-3">
                        <label for="tipo-dibujo" class="text-white font-weight-bold">
                          <i class="fas fa-shapes mr-1 text-cyan"></i> Tipo de Geocerca *
                        </label>
                        <select id="tipo-dibujo" class="form-control form-control-oiion">
                          <option value="">-- Seleccionar Forma --</option>
                          <option value="circular">Círculo (Punto y Radio)</option>
                          <option value="poligono">Polígono (Puntos Libres)</option>
                        </select>
                      </div>

                      <div class="form-group mb-3">
                        <label for="nombre" class="text-white font-weight-bold">Nombre de la Geocerca *</label>
                        <input type="text" class="form-control form-control-oiion" id="nombre" name="nombre" required 
                               placeholder="Ej: Zona Norte, Patio de carga">
                      </div>

                      <div class="form-group mb-0">
                        <label for="descripcion" class="text-white font-weight-bold">Descripción</label>
                        <textarea class="form-control form-control-oiion" id="descripcion" name="descripcion" rows="2" 
                                  placeholder="Breve descripción del propósito de esta zona"></textarea>
                      </div>
                    </div>

                    <!-- Columna 2: Parámetros e Instrucciones del Trazo (Dinámicos) -->
                    <div class="col-md-4 mb-3">
                      
                      <!-- Campos y Guía Círculo -->
                      <div id="circle-fields" style="display: none;">
                        <small class="text-cyan d-block mb-2"><i class="fas fa-mouse-pointer mr-1"></i> Haz clic en el mapa para fijar el centro.</small>
                        <div class="form-group mb-3">
                          <label for="circle-radius" class="text-white font-weight-bold">Radio (metros) *</label>
                          <input type="number" id="circle-radius" name="radio" class="form-control form-control-oiion" value="100" min="10" step="1">
                        </div>
                        <div class="form-row">
                          <div class="col-6">
                            <div class="form-group mb-0">
                              <label for="latitud" class="text-white font-weight-bold small">Latitud</label>
                              <input type="text" class="form-control form-control-oiion" id="latitud" name="latitud" readonly placeholder="Clic en mapa">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group mb-0">
                              <label for="longitud" class="text-white font-weight-bold small">Longitud</label>
                              <input type="text" class="form-control form-control-oiion" id="longitud" name="longitud" readonly placeholder="Clic en mapa">
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Campos, Guía y Limpiar Polígono -->
                      <div id="polygon-fields" style="display: none;">
                        <small class="text-cyan d-block mb-1"><i class="fas fa-mouse-pointer mr-1"></i> Clic en el mapa para agregar vértices.</small>
                        <small class="text-muted d-block mb-3"><i class="fas fa-check mr-1"></i> Doble clic para finalizar el trazo.</small>
                        
                        <input type="hidden" id="coordenadas" name="coordenadas">
                        
                        <div class="p-3 border rounded text-center mb-2" style="background: var(--bg-main); border-color: var(--border-color) !important;">
                          <i class="fas fa-draw-polygon text-cyan fa-2x mb-2"></i>
                          <div class="text-muted small">Vértices capturados: <span id="point-count" class="text-cyan font-weight-bold" style="font-size: 1.1rem;">0</span></div>
                        </div>

                        <button type="button" class="btn btn-outline-secondary btn-sm btn-block" onclick="limpiarDibujo()">
                          <i class="fas fa-eraser mr-1"></i> Limpiar Trazo
                        </button>
                      </div>

                    </div>

                    <!-- Columna 3: Color y Guardar -->
                    <div class="col-md-3 mb-3">
                      
                      <div class="form-group mb-4">
                        <label for="color" class="text-white font-weight-bold d-block">Color del Área</label>
                        <div class="color-picker-wrapper">
                          <input type="color" id="color" name="color" value="#3B82F6">
                          <span class="small text-muted">Personalizar trazo</span>
                        </div>
                      </div>

                      <div class="form-group mb-0 pt-2">
                        <button type="submit" class="btn btn-action btn-block font-weight-bold py-2 mb-2" id="submit-btn" disabled>
                          <i class="fas fa-save mr-1"></i> Guardar Geocerca
                        </button>
                        <a href="{{ route('geocercas.index') }}" class="btn btn-outline-secondary btn-block">
                          <i class="fas fa-times mr-1"></i> Cancelar
                        </a>
                      </div>

                    </div>

                  </div>
                </form>

              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>
  
  @include('footer')
</div>

<script>
  var map;
  var circle = null;
  var polygon = null;
  var polygonPath = [];
  var circleCenter = null;
  var drawingMode = null;
  var polygonClickListener = null;

  function inicializarAplicacion() {
    initMap();
    configurarEventos();
  }

  function cargarGoogleMaps() {
    if (typeof google !== 'undefined' && google.maps) {
      inicializarAplicacion();
      return;
    }
    
    var script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=drawing,geometry&callback=inicializarAplicacion';
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
  }

  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: { lat: 19.4326, lng: -99.1332 },
      mapTypeId: 'roadmap',
      streetViewControl: false,
      mapTypeControl: false,
      fullscreenControl: true
    });
  }

  function configurarEventos() {
    $('#tipo-dibujo').change(function() {
      var tipo = $(this).val();
      drawingMode = tipo;
      $('#tipo').val(tipo);
      
      if (tipo === 'circular') {
        $('#default-fields-msg').hide();
        $('#circle-fields').show();
        $('#polygon-fields').hide();
        limpiarDibujo();
      } else if (tipo === 'poligono') {
        $('#default-fields-msg').hide();
        $('#circle-fields').hide();
        $('#polygon-fields').show();
        iniciarDibujoPoligono();
      } else {
        $('#default-fields-msg').show();
        $('#circle-fields').hide();
        $('#polygon-fields').hide();
        limpiarDibujo();
      }
      
      actualizarEstadoBoton();
    });

    google.maps.event.addListener(map, 'click', function(event) {
      if (drawingMode === 'circular') {
        circleCenter = event.latLng;
        $('#latitud').val(circleCenter.lat().toFixed(8));
        $('#longitud').val(circleCenter.lng().toFixed(8));
        dibujarCirculo();
      } else if (drawingMode === 'poligono') {
        agregarPuntoPoligono(event.latLng);
      }
    });

    $('#color').change(function() {
      var color = $(this).val();
      if (circle) circle.setOptions({ fillColor: color, strokeColor: color });
      if (polygon) polygon.setOptions({ fillColor: color, strokeColor: color });
    });

    $('#circle-radius').on('input', function() {
      if (circle && circleCenter) {
        dibujarCirculo();
      }
    });

    $('#nombre, #latitud, #longitud, #circle-radius').on('input', actualizarEstadoBoton);
  }

  function dibujarCirculo() {
    if (!circleCenter) return;
    
    var radius = parseInt($('#circle-radius').val()) || 100;
    
    if (circle) circle.setMap(null);
    if (polygon) polygon.setMap(null);
    
    circle = new google.maps.Circle({
      center: circleCenter,
      radius: radius,
      fillColor: $('#color').val(),
      fillOpacity: 0.3,
      strokeWeight: 2,
      strokeColor: $('#color').val(),
      map: map,
      editable: true,
      draggable: true
    });
    
    google.maps.event.addListener(circle, 'radius_changed', function() {
      var newRadius = Math.round(circle.getRadius());
      $('#circle-radius').val(newRadius);
    });
    
    google.maps.event.addListener(circle, 'center_changed', function() {
      var center = circle.getCenter();
      circleCenter = center;
      $('#latitud').val(center.lat().toFixed(8));
      $('#longitud').val(center.lng().toFixed(8));
    });
    
    actualizarEstadoBoton();
  }

  function iniciarDibujoPoligono() {
    limpiarDibujo();
  }

  function agregarPuntoPoligono(latLng) {
    polygonPath.push(latLng);
    
    if (!polygon) {
      polygon = new google.maps.Polygon({
        paths: polygonPath,
        fillColor: $('#color').val(),
        fillOpacity: 0.3,
        strokeWeight: 2,
        strokeColor: $('#color').val(),
        map: map,
        editable: true,
        draggable: true
      });
      
      var path = polygon.getPath();
      google.maps.event.addListener(path, 'set_at', actualizarCoordenadasDesdePath);
      google.maps.event.addListener(path, 'insert_at', actualizarCoordenadasDesdePath);
      google.maps.event.addListener(path, 'remove_at', actualizarCoordenadasDesdePath);
    } else {
      polygon.setPath(polygonPath);
    }
    
    actualizarCoordenadasPoligono();
  }

  // Actualiza los datos leyendo la ruta actual del polígono (evita recursión infinita)
  function actualizarCoordenadasDesdePath() {
    if (!polygon) return;
    var path = polygon.getPath();
    polygonPath = [];
    
    for (var i = 0; i < path.getLength(); i++) {
      polygonPath.push(path.getAt(i));
    }
    actualizarCoordenadasPoligono();
  }

  function actualizarCoordenadasPoligono() {
    if (!polygon || polygonPath.length < 3) {
      $('#point-count').text(polygonPath.length);
      $('#coordenadas').val('');
      actualizarEstadoBoton();
      return;
    }
    
    var coordinates = [];
    for (var i = 0; i < polygonPath.length; i++) {
      coordinates.push([
        parseFloat(polygonPath[i].lat().toFixed(8)),
        parseFloat(polygonPath[i].lng().toFixed(8))
      ]);
    }
    
    $('#point-count').text(polygonPath.length);
    $('#coordenadas').val(JSON.stringify(coordinates));
    actualizarEstadoBoton();
  }

  function limpiarDibujo() {
    if (circle) {
      circle.setMap(null);
      circle = null;
    }
    if (polygon) {
      polygon.setMap(null);
      polygon = null;
    }
    
    circleCenter = null;
    polygonPath = [];
    
    $('#latitud').val('');
    $('#longitud').val('');
    $('#coordenadas').val('');
    $('#point-count').text('0');
    
    actualizarEstadoBoton();
  }

  function actualizarEstadoBoton() {
    var tipo = $('#tipo').val();
    var nombre = $('#nombre').val().trim();
    var habilitar = false;
    
    if (tipo === 'circular') {
      var lat = $('#latitud').val();
      var lng = $('#longitud').val();
      var radio = $('#circle-radius').val();
      habilitar = nombre && lat && lng && radio && circle;
    } else if (tipo === 'poligono') {
      var pointCount = parseInt($('#point-count').text()) || 0;
      habilitar = nombre && pointCount >= 3 && polygon;
    }
    
    $('#submit-btn').prop('disabled', !habilitar);
  }

  $(document).ready(function() {
    cargarGoogleMaps();
  });
</script>

</body>
</html>