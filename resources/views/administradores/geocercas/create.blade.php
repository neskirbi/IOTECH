<!DOCTYPE html>
<html lang="en">
<head>
  @include('administradores.header')
  <title>IOTECH | Crear Geocerca</title>
  <!-- Google Maps API -->
 <script src="https://maps.googleapis.com/maps/api/js?key={{  env('GOOGLE_MAPS_API_KEY') }}&libraries=drawing,geometry"></script>
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
    .coordinate-input {
      font-size: 12px;
      padding: 2px 5px;
      height: 30px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
@include('toast.toasts')
<div class="wrapper">

  <!-- Navbar -->
  @include('administradores.navigations.navigation')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('administradores.sidebars.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
    <!-- /.content-header -->

    <!-- Main content -->
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
                    <small class="text-muted">Haz clic en el mapa para definir el centro</small>
                  </div>
                  <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Radio (m)</span>
                    </div>
                    <input type="number" id="circle-radius" class="form-control" value="100" min="10">
                  </div>
                  <button class="btn btn-sm btn-info btn-block" onclick="dibujarCirculo()">
                    <i class="fas fa-draw-circle"></i> Dibujar Círculo
                  </button>
                  <button class="btn btn-sm btn-danger btn-block mt-1" onclick="limpiarDibujo()">
                    <i class="fas fa-times"></i> Limpiar
                  </button>
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
                  
                  <input type="hidden" name="tipo" value="circular">
                  
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

                  <div class="form-row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="latitud">Latitud *</label>
                        <input type="text" class="form-control coordinate-input" id="latitud" name="latitud" 
                               placeholder="Ej: 19.4326" readonly required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="longitud">Longitud *</label>
                        <input type="text" class="form-control coordinate-input" id="longitud" name="longitud" 
                               placeholder="Ej: -99.1332" readonly required>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="radio">Radio (metros) *</label>
                    <input type="number" class="form-control" id="radio" name="radio" 
                           placeholder="Ej: 100" min="10" step="1" required>
                  </div>

                  <div class="form-group">
                    <label for="color">Color</label>
                    <input type="color" class="form-control" id="color" name="color" value="#3B82F6">
                  </div>

                  <input type="hidden" id="geocerca-definida" value="0">

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
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<script>
  // Variables globales
  var map;
  var circle = null;
  var circleCenter = null;

  // Inicializar mapa
  function initMap() {
    var defaultCenter = { lat: 19.4326, lng: -99.1332 };
    
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: defaultCenter,
      mapTypeId: 'roadmap',
      streetViewControl: false,
      mapTypeControl: false
    });

    // Escuchar clics en el mapa para definir centro
    google.maps.event.addListener(map, 'click', function(event) {
      circleCenter = event.latLng;
      $('#latitud').val(circleCenter.lat().toFixed(6));
      $('#longitud').val(circleCenter.lng().toFixed(6));
      
      // Si ya hay un círculo, actualizarlo
      if (circle) {
        circle.setCenter(circleCenter);
      }
      
      actualizarEstadoBoton();
    });
  }

  // Dibujar círculo
  function dibujarCirculo() {
    if (!circleCenter) {
      alert('Por favor, haz clic en el mapa para definir el centro primero.');
      return;
    }
    
    var radius = parseInt($('#circle-radius').val()) || 100;
    
    // Limpiar círculo anterior si existe
    if (circle) {
      circle.setMap(null);
    }
    
    circle = new google.maps.Circle({
      center: circleCenter,
      radius: radius,
      fillColor: $('#color').val(),
      fillOpacity: 0.3,
      strokeWeight: 2,
      strokeColor: $('#color').val(),
      map: map,
      editable: true
    });
    
    // Actualizar radio cuando se edite
    google.maps.event.addListener(circle, 'radius_changed', function() {
      var newRadius = Math.round(circle.getRadius());
      $('#radio').val(newRadius);
      $('#circle-radius').val(newRadius);
      actualizarEstadoBoton();
    });
    
    // Actualizar centro cuando se edite
    google.maps.event.addListener(circle, 'center_changed', function() {
      var center = circle.getCenter();
      circleCenter = center;
      $('#latitud').val(center.lat().toFixed(6));
      $('#longitud').val(center.lng().toFixed(6));
      actualizarEstadoBoton();
    });
    
    $('#radio').val(radius);
    $('#geocerca-definida').val('1');
    actualizarEstadoBoton();
  }

  // Limpiar dibujo
  function limpiarDibujo() {
    if (circle) {
      circle.setMap(null);
      circle = null;
    }
    
    circleCenter = null;
    $('#latitud').val('');
    $('#longitud').val('');
    $('#radio').val('');
    $('#circle-radius').val('100');
    $('#geocerca-definida').val('0');
    
    actualizarEstadoBoton();
  }

  // Actualizar estado del botón de guardar
  function actualizarEstadoBoton() {
    var nombre = $('#nombre').val().trim();
    var lat = $('#latitud').val();
    var lng = $('#longitud').val();
    var radio = $('#radio').val();
    var definida = $('#geocerca-definida').val() === '1';
    
    var habilitar = nombre && lat && lng && radio && definida;
    $('#submit-btn').prop('disabled', !habilitar);
  }

  // Cambiar color del círculo
  $('#color').change(function() {
    var color = $(this).val();
    
    if (circle) {
      circle.setOptions({
        fillColor: color,
        strokeColor: color
      });
    }
  });

  // Inicializar cuando el DOM esté listo
  $(document).ready(function() {
    initMap();
    
    // Actualizar estado del botón al cambiar campos
    $('#nombre, #latitud, #longitud, #radio, #circle-radius').on('input', actualizarEstadoBoton);
    
    // Prevenir envío del formulario si no hay geocerca definida
    $('#geocerca-form').submit(function(e) {
      if ($('#geocerca-definida').val() !== '1') {
        e.preventDefault();
        alert('Por favor, define un círculo en el mapa primero.');
        return false;
      }
    });
  });
</script>

<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
</body>
</html>