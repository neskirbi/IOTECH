<!DOCTYPE html>
<html lang="en">
<head>
  @include('administradores.header')
  <title>IOTECH | Crear Geocerca</title>
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  
  <style>
    #map {
      height: 500px;
      width: 100%;
      border-radius: 8px;
      border: 1px solid #ddd;
      margin-bottom: 20px;
    }
    .map-controls {
      position: absolute;
      top: 10px;
      left: 10px;
      z-index: 1000;
      background: white;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
@include('toast.toasts')
<div class="wrapper">

  @include('administradores.navigations.navigation')
  @include('administradores.sidebars.sidebar')

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="nav-icon fas fa-draw-polygon"></i> Crear Geocerca</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('operadores') }}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{ route('geocercas.index') }}">Geocercas</a></li>
              <li class="breadcrumb-item active">Crear</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Mapa</h3>
              </div>
              <div class="card-body position-relative">
                <div id="map"></div>
                <div class="map-controls">
                  <div class="form-group mb-2">
                    <label class="small mb-1"><i class="fas fa-mouse-pointer"></i> Tipo de dibujo:</label>
                    <select id="tipo-dibujo" class="form-control form-control-sm">
                      <option value="">Seleccionar tipo</option>
                      <option value="circular">Círculo</option>
                      <option value="poligono">Polígono</option>
                    </select>
                  </div>
                  
                  <div id="circle-controls" style="display: none;">
                    <small class="text-muted">Haz clic en el mapa para el centro</small>
                    <div class="input-group input-group-sm mb-2">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Radio (m)</span>
                      </div>
                      <input type="number" id="circle-radius" class="form-control" value="100" min="10">
                    </div>
                    <button class="btn btn-sm btn-info btn-block" onclick="dibujarCirculo()">
                      <i class="fas fa-draw-circle"></i> Dibujar Círculo
                    </button>
                  </div>
                  
                  <div id="polygon-controls" style="display: none;">
                    <small class="text-muted">Haz clic para crear puntos</small><br>
                    <small class="text-muted">Doble clic para terminar</small>
                    <button class="btn btn-sm btn-info btn-block mt-1" onclick="iniciarDibujoPoligono()">
                      <i class="fas fa-draw-polygon"></i> Empezar a dibujar
                    </button>
                    <button class="btn btn-sm btn-secondary btn-block mt-1" onclick="limpiarDibujo()">
                      <i class="fas fa-eraser"></i> Limpiar
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle"></i> Información de la Geocerca</h3>
              </div>
              <div class="card-body">
                <form action="{{ route('geocercas.store') }}" method="POST" id="geocerca-form">
                  @csrf
                  
                  <input type="hidden" id="tipo" name="tipo" value="">
                  
                  <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required 
                           placeholder="Ej: Zona de trabajo, Área restringida">
                  </div>

                  <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" 
                              placeholder="Descripción de la geocerca"></textarea>
                  </div>

                  <div id="circle-fields" style="display: none;">
                    <div class="form-row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="latitud">Latitud *</label>
                          <input type="text" class="form-control" id="latitud" name="latitud" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="longitud">Longitud *</label>
                          <input type="text" class="form-control" id="longitud" name="longitud" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="radio">Radio (metros) *</label>
                      <input type="number" class="form-control" id="radio" name="radio" min="10" step="1">
                    </div>
                  </div>

                  <div id="polygon-fields" style="display: none;">
                    <div class="form-group">
                      <label>Coordenadas del Polígono</label>
                      <input type="hidden" id="coordenadas" name="coordenadas">
                      <small class="text-muted">Puntos: <span id="point-count">0</span></small>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="color">Color</label>
                    <input type="color" class="form-control" id="color" name="color" value="#3B82F6">
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" id="submit-btn" disabled>
                      <i class="fas fa-save"></i> Guardar Geocerca
                    </button>
                    <a href="{{ route('geocercas.index') }}" class="btn btn-default btn-block">
                      <i class="fas fa-times"></i> Cancelar
                    </a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  
  <footer class="main-footer">
  </footer>
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
        $('#circle-fields').show();
        $('#polygon-fields').hide();
        $('#circle-controls').show();
        $('#polygon-controls').hide();
        limpiarDibujo();
      } else if (tipo === 'poligono') {
        $('#circle-fields').hide();
        $('#polygon-fields').show();
        $('#circle-controls').hide();
        $('#polygon-controls').show();
        limpiarDibujo();
      } else {
        $('#circle-fields').hide();
        $('#polygon-fields').hide();
        $('#circle-controls').hide();
        $('#polygon-controls').hide();
        limpiarDibujo();
      }
      
      actualizarEstadoBoton();
    });

    google.maps.event.addListener(map, 'click', function(event) {
      if (drawingMode === 'circular') {
        circleCenter = event.latLng;
        $('#latitud').val(circleCenter.lat().toFixed(8));
        $('#longitud').val(circleCenter.lng().toFixed(8));
        actualizarEstadoBoton();
      }
    });

    $('#color').change(function() {
      var color = $(this).val();
      if (circle) circle.setOptions({ fillColor: color, strokeColor: color });
      if (polygon) polygon.setOptions({ fillColor: color, strokeColor: color });
    });

    $('#nombre, #latitud, #longitud, #radio').on('input', actualizarEstadoBoton);
  }

  function dibujarCirculo() {
    if (!circleCenter) {
      alert('Haz clic en el mapa para definir el centro primero.');
      return;
    }
    
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
    
    $('#radio').val(radius);
    
    google.maps.event.addListener(circle, 'radius_changed', function() {
      var newRadius = Math.round(circle.getRadius());
      $('#radio').val(newRadius);
      $('#circle-radius').val(newRadius);
    });
    
    google.maps.event.addListener(circle, 'center_changed', function() {
      var center = circle.getCenter();
      $('#latitud').val(center.lat().toFixed(8));
      $('#longitud').val(center.lng().toFixed(8));
    });
    
    actualizarEstadoBoton();
  }

  function iniciarDibujoPoligono() {
    limpiarDibujo();
    polygonPath = [];
    
    polygonClickListener = google.maps.event.addListener(map, 'click', function(event) {
      agregarPuntoPoligono(event.latLng);
    });
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
      
      google.maps.event.addListener(polygon.getPath(), 'set_at', actualizarCoordenadasPoligono);
      google.maps.event.addListener(polygon.getPath(), 'insert_at', actualizarCoordenadasPoligono);
      google.maps.event.addListener(polygon.getPath(), 'remove_at', actualizarCoordenadasPoligono);
    } else {
      polygon.setPath(polygonPath);
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
    $('#radio').val('');
    $('#circle-radius').val('100');
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
      var radio = $('#radio').val();
      habilitar = nombre && lat && lng && radio && circle;
    } else if (tipo === 'poligono') {
      var pointCount = parseInt($('#point-count').text()) || 0;
      habilitar = nombre && pointCount >= 3 && polygon;
    }
    
    $('#submit-btn').prop('disabled', !habilitar);
  }

  $(document).ready(function() {
    cargarGoogleMaps();
    
    $('#map').on('dblclick', function() {
      if (drawingMode === 'poligono' && polygonPath.length >= 3) {
        if (polygonClickListener) {
          google.maps.event.removeListener(polygonClickListener);
          polygonClickListener = null;
        }
        alert('Polígono completado con ' + polygonPath.length + ' puntos.');
      }
    });
  });
</script>

<script src="{{ asset('dist/js/adminlte.js') }}"></script>
</body>
</html>