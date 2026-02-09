<!DOCTYPE html>
<html lang="en">
<head>
  @include('administradores.header')
  <title>IOTECH | Editar Geocerca</title>
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

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Mapa</h3>
              </div>
              <div class="card-body">
                <div id="map"></div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle"></i> Información de la Geocerca</h3>
              </div>
              <div class="card-body">
                <form action="{{ route('geocercas.update', $geocerca->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  
                  <input type="hidden" name="tipo" value="{{ $geocerca->tipo }}">
                  
                  <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ $geocerca->nombre }}">
                  </div>

                  <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ $geocerca->descripcion }}</textarea>
                  </div>

                  @if($geocerca->tipo == 'circular')
                  <div class="form-row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="latitud">Latitud *</label>
                        <input type="text" class="form-control" id="latitud" name="latitud" required value="{{ $geocerca->latitud }}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="longitud">Longitud *</label>
                        <input type="text" class="form-control" id="longitud" name="longitud" required value="{{ $geocerca->longitud }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="radio">Radio (metros) *</label>
                    <input type="number" class="form-control" id="radio" name="radio" min="10" step="1" required value="{{ $geocerca->radio }}">
                  </div>
                  
                  <input type="hidden" id="coordenadas" name="coordenadas" value="">
                  @else
                  <input type="hidden" id="coordenadas" name="coordenadas" value="{{ $geocerca->coordenadas }}">
                  <input type="hidden" id="latitud" name="latitud" value="">
                  <input type="hidden" id="longitud" name="longitud" value="">
                  <input type="hidden" id="radio" name="radio" value="">
                  @endif

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
      </div>
    </section>
  </div>
  
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>
</div>

<script>
  var map;
  var circle = null;
  var polygon = null;

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
    var center = { lat: 19.4326, lng: -99.1332 };
    
    @if($geocerca->tipo == 'circular' && $geocerca->latitud && $geocerca->longitud)
      center = { 
        lat: parseFloat({{ $geocerca->latitud }}), 
        lng: parseFloat({{ $geocerca->longitud }}) 
      };
    @endif
    
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 14,
      center: center,
      mapTypeId: 'roadmap',
      streetViewControl: false,
      mapTypeControl: false,
      fullscreenControl: true
    });

    @if($geocerca->tipo == 'circular')
      dibujarCirculoExistente();
    @else
      dibujarPoligonoExistente();
    @endif
  }

  function dibujarCirculoExistente() {
    var circleCenter = new google.maps.LatLng(
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
    
    google.maps.event.addListener(circle, 'radius_changed', function() {
      $('#radio').val(Math.round(circle.getRadius()));
    });
    
    google.maps.event.addListener(circle, 'center_changed', function() {
      var center = circle.getCenter();
      $('#latitud').val(center.lat().toFixed(8));
      $('#longitud').val(center.lng().toFixed(8));
    });
  }

  function dibujarPoligonoExistente() {
    @php
      // Decodificar las coordenadas del string JSON
      $coordsArray = json_decode($geocerca->coordenadas, true) ?: [];
    @endphp
    
    @if(count($coordsArray) > 0)
      var coordinates = [];
      
      @foreach($coordsArray as $coord)
        var point = new google.maps.LatLng(parseFloat({{ $coord[0] }}), parseFloat({{ $coord[1] }}));
        coordinates.push(point);
      @endforeach
      
      polygon = new google.maps.Polygon({
        paths: coordinates,
        fillColor: '{{ $geocerca->color ?? "#3B82F6" }}',
        fillOpacity: 0.3,
        strokeWeight: 2,
        strokeColor: '{{ $geocerca->color ?? "#3B82F6" }}',
        map: map,
        editable: true,
        draggable: true
      });
      
      google.maps.event.addListener(polygon.getPath(), 'set_at', actualizarCoordenadasPoligono);
      google.maps.event.addListener(polygon.getPath(), 'insert_at', actualizarCoordenadasPoligono);
      google.maps.event.addListener(polygon.getPath(), 'remove_at', actualizarCoordenadasPoligono);
      google.maps.event.addListener(polygon, 'dragend', actualizarCoordenadasPoligono);
      
      var bounds = new google.maps.LatLngBounds();
      for (var i = 0; i < coordinates.length; i++) {
        bounds.extend(coordinates[i]);
      }
      map.fitBounds(bounds);
    @endif
  }

  function actualizarCoordenadasPoligono() {
    if (!polygon) return;
    
    var path = polygon.getPath();
    var coordinates = [];
    
    for (var i = 0; i < path.getLength(); i++) {
      var point = path.getAt(i);
      coordinates.push([point.lat(), point.lng()]);
    }
    
    $('#coordenadas').val(JSON.stringify(coordinates));
  }

  function configurarEventos() {
    $('#color').change(function() {
      var color = $(this).val();
      @if($geocerca->tipo == 'circular')
      if (circle) circle.setOptions({ fillColor: color, strokeColor: color });
      @else
      if (polygon) polygon.setOptions({ fillColor: color, strokeColor: color });
      @endif
    });
  }

  $(document).ready(function() {
    cargarGoogleMaps();
  });
</script>

<script src="{{ asset('dist/js/adminlte.js') }}"></script>
</body>
</html>