<!DOCTYPE html>
<html lang="en">
<head>
  @include('administradores.header')
  <title>IOTECH | Editar Geocerca</title>
  <!-- Google Maps API -->
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=drawing,geometry&callback=inicializarAplicacion" async defer></script>
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
    .circle-current {
      border: 2px solid #28a745;
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
            <h1 class="m-0"><i class="nav-icon fas fa-draw-polygon"></i> Editar Geocerca</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('operadores') }}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{ route('geocercas.index') }}">Geocercas</a></li>
              <li class="breadcrumb-item active">Editar</li>
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
                    <small class="text-muted">Arrastra el círculo para moverlo</small>
                  </div>
                  <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Radio (m)</span>
                    </div>
                    <input type="number" id="circle-radius" class="form-control" value="{{ $geocerca->radio }}" min="10">
                  </div>
                  <button class="btn btn-sm btn-info btn-block" onclick="actualizarCirculo()">
                    <i class="fas fa-sync-alt"></i> Actualizar
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
                <form action="{{ route('geocercas.update', $geocerca->id) }}" method="POST" id="geocerca-form">
                  @csrf
                  @method('PUT')
                  
                  <input type="hidden" name="tipo" value="circular">
                  
                  <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required 
                           placeholder="Ej: Zona de trabajo, Área restringida" value="{{ $geocerca->nombre }}">
                  </div>

                  <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" 
                              placeholder="Descripción de la geocerca">{{ $geocerca->descripcion }}</textarea>
                  </div>

                  <div class="form-row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="latitud">Latitud *</label>
                        <input type="text" class="form-control coordinate-input" id="latitud" name="latitud" 
                               placeholder="Ej: 19.4326" readonly required value="{{ $geocerca->latitud }}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="longitud">Longitud *</label>
                        <input type="text" class="form-control coordinate-input" id="longitud" name="longitud" 
                               placeholder="Ej: -99.1332" readonly required value="{{ $geocerca->longitud }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="radio">Radio (metros) *</label>
                    <input type="number" class="form-control" id="radio" name="radio" 
                           placeholder="Ej: 100" min="10" step="1" required value="{{ $geocerca->radio }}">
                  </div>

                  <div class="form-group">
                    <label for="color">Color</label>
                    <input type="color" class="form-control" id="color" name="color" value="{{ $geocerca->color ?? '#3B82F6' }}">
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="activa" name="activa" value="1" {{ $geocerca->activa ? 'checked' : '' }}>
                      <label class="custom-control-label" for="activa">Geocerca activa</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                      <i class="fas fa-save"></i> Guardar Cambios
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

  // Función que se llama cuando Google Maps está listo
  function inicializarAplicacion() {
    // Inicializar mapa
    initMap();
  }

  // Inicializar mapa
  function initMap() {
    // Usar las coordenadas de la geocerca existente
    var center = { 
      lat: parseFloat({{ $geocerca->latitud }}), 
      lng: parseFloat({{ $geocerca->longitud }}) 
    };
    
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 14,
      center: center,
      mapTypeId: 'roadmap',
      streetViewControl: false,
      mapTypeControl: false
    });

    // Dibujar círculo existente
    dibujarCirculoExistente();
  }

  // Dibujar círculo existente
  function dibujarCirculoExistente() {
    circleCenter = new google.maps.LatLng(
      parseFloat({{ $geocerca->latitud }}), 
      parseFloat({{ $geocerca->longitud }})
    );
    
    var radius = parseFloat({{ $geocerca->radio }});
    
    circle = new google.maps.Circle({
      center: circleCenter,
      radius: radius,
      fillColor: '{{ $geocerca->color ?? "#3B82F6" }}',
      fillOpacity: 0.3,
      strokeWeight: 2,
      strokeColor: '{{ $geocerca->color ?? "#3B82F6" }}',
      map: map,
      editable: true,
      draggable: true
    });
    
    // Actualizar campos cuando se edite el círculo
    google.maps.event.addListener(circle, 'radius_changed', function() {
      var newRadius = Math.round(circle.getRadius());
      $('#radio').val(newRadius);
      $('#circle-radius').val(newRadius);
    });
    
    // Actualizar centro cuando se mueva el círculo
    google.maps.event.addListener(circle, 'center_changed', function() {
      var center = circle.getCenter();
      circleCenter = center;
      $('#latitud').val(center.lat().toFixed(6));
      $('#longitud').val(center.lng().toFixed(6));
    });
    
    // Escuchar clics en el mapa para mover el círculo
    google.maps.event.addListener(map, 'click', function(event) {
      circle.setCenter(event.latLng);
      circleCenter = event.latLng;
      $('#latitud').val(event.latLng.lat().toFixed(6));
      $('#longitud').val(event.latLng.lng().toFixed(6));
    });
  }

  // Actualizar círculo desde controles
  function actualizarCirculo() {
    if (!circle) return;
    
    var radius = parseInt($('#circle-radius').val()) || {{ $geocerca->radio }};
    
    circle.setRadius(radius);
    $('#radio').val(radius);
    
    // Actualizar color
    var color = $('#color').val();
    circle.setOptions({
      fillColor: color,
      strokeColor: color
    });
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
    // Sincronizar radio inputs
    $('#circle-radius, #radio').on('input', function() {
      var value = $(this).val();
      $('#circle-radius').val(value);
      $('#radio').val(value);
    });
  });
</script>

<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
</body>
</html>