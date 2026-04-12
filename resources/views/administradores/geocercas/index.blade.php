<!DOCTYPE html>
<html lang="en">
<head>
  @include('administradores.header')
  <title>IOTECH | Geocercas</title>
  <!-- Google Maps API -->
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=drawing,geometry&callback=inicializarAplicacion" async defer></script>
  <style>
    #map {
      height: 500px;
      width: 100%;
      margin-bottom: 20px;
      border-radius: 8px;
      border: 1px solid #ddd;
    }
    .geocerca-card {
      border-left: 4px solid #3B82F6;
      margin-bottom: 15px;
      transition: all 0.3s;
    }
    .botones-columna {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
@include('toast.toasts')

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="confirmDeleteModalLabel">
          <i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <div class="delete-icon">
          <i class="fas fa-trash-alt"></i>
        </div>
        <h4>¿Estás seguro de eliminar esta geocerca?</h4>
        <p class="text-muted" id="geocercaName"></p>
        <p><small>Esta acción no se puede deshacer.</small></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-times"></i> Cancelar
        </button>
        <form id="deleteForm" method="POST" action="">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash"></i> Sí, eliminar
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="wrapper">
  @include('administradores.navigations.navigation')
  @include('administradores.sidebars.sidebar')

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="nav-icon fas fa-draw-polygon"></i> Geocercas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('operadores') }}">Inicio</a></li>
              <li class="breadcrumb-item active">Geocercas</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        
        <!-- Mapa -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Mapa de Geocercas</h3>
                <div class="card-tools">
                  <a href="{{ route('geocercas.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Crear Geocerca
                  </a>
                </div>
              </div>
              <div class="card-body position-relative">
                <div id="map"></div>
                <div class="map-controls">
                  <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-info" onclick="centrarMapa()">
                      <i class="fas fa-crosshairs"></i> Centrar
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Lista de Geocercas -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list"></i> Lista de Geocercas</h3>
              </div>
              <div class="card-body">
                @if($geocercas->count() > 0)
                  @foreach($geocercas as $geocerca)
                  <div class="card geocerca-card" style="border-left-color: {{ $geocerca->color ?? '#3B82F6' }}">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-8">
                          <h5 class="card-title">
                            {{ $geocerca->nombre }}
                            @if($geocerca->activa)
                              <span class="badge badge-success">Activa</span>
                            @else
                              <span class="badge badge-danger">Inactiva</span>
                            @endif
                            <span class="badge badge-info">{{ $geocerca->tipo }}</span>
                          </h5>
                          <p class="card-text text-muted">
                            {{ $geocerca->descripcion ?? 'Sin descripción' }}
                          </p>
                          <p class="card-text">
                            <small class="text-muted">
                              @if($geocerca->tipo == 'circular')
                                <i class="fas fa-map-marker-alt"></i> Centro: {{ number_format($geocerca->latitud, 6) }}, {{ number_format($geocerca->longitud, 6) }}<br>
                                <i class="fas fa-expand-arrows-alt"></i> Radio: {{ $geocerca->radio }} {{ $geocerca->unidad_distancia ?? 'metros' }}<br>
                              @else
                                <i class="fas fa-draw-polygon"></i> Polígono con puntos<br>
                              @endif
                              <i class="far fa-clock"></i> Creada: {{ $geocerca->created_at->format('d/m/Y H:i') }}
                            </small>
                          </p>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                          <div class="botones-columna">
                            <button type="button" class="btn btn-info btn-sm ver-geocerca" 
                                    data-id="{{ $geocerca->id }}" 
                                    data-tipo="{{ $geocerca->tipo }}">
                              <i class="fas fa-eye"></i> Ver en Mapa
                            </button>
                            <a href="{{ route('geocercas.edit', $geocerca->id) }}" class="btn btn-warning btn-sm">
                              <i class="fas fa-edit"></i> Editar
                            </a>
                            <button type="button" class="btn btn-danger btn-sm btn-eliminar" 
                                    data-id="{{ $geocerca->id }}" 
                                    data-nombre="{{ $geocerca->nombre }}"
                                    data-url="{{ route('geocercas.destroy', $geocerca->id) }}">
                              <i class="fas fa-trash"></i> Eliminar
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                @else
                  <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No hay geocercas creadas. 
                    <a href="{{ route('geocercas.create') }}" class="alert-link">Crea tu primera geocerca</a>
                  </div>
                @endif
              </div>
              @if($geocercas->hasPages())
              <div class="card-footer">
                <div class="float-right">
                   {{ $geocercas->appends($_GET)->links('pagination::bootstrap-4') }}
                </div>
              </div>
              @endif
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
  var geocercasEnMapa = [];
  var bounds = new google.maps.LatLngBounds();

  function inicializarAplicacion() {
    initMap();
    
    $(document).ready(function() {
      $('.ver-geocerca').click(function() {
        var geocercaId = $(this).data('id');
        var tipo = $(this).data('tipo');
        verGeocercaEnMapa(geocercaId, tipo);
      });
      
      $('.btn-eliminar').click(function() {
        var geocercaNombre = $(this).data('nombre');
        var deleteUrl = $(this).data('url');
        
        $('#geocercaName').text('"' + geocercaNombre + '"');
        $('#deleteForm').attr('action', deleteUrl);
        $('#confirmDeleteModal').modal('show');
      });
    });
  }

  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: { lat: 19.4326, lng: -99.1332 },
      mapTypeId: 'roadmap',
      streetViewControl: false,
      mapTypeControl: false,
      fullscreenControl: true,
      zoomControl: true
    });

    cargarGeocercasEnMapa();
  }

  function cargarGeocercasEnMapa() {
    geocercasEnMapa.forEach(function(geocerca) {
      geocerca.setMap(null);
    });
    geocercasEnMapa = [];
    bounds = new google.maps.LatLngBounds();

    @if($geocercas->count() > 0)
      @foreach($geocercas as $geocerca)
        @if($geocerca->tipo == 'circular' && $geocerca->latitud && $geocerca->longitud && $geocerca->radio)
          var center = new google.maps.LatLng(parseFloat({{ $geocerca->latitud }}), parseFloat({{ $geocerca->longitud }}));
          
          var circle = new google.maps.Circle({
            strokeColor: '{{ $geocerca->color ?? "#3B82F6" }}',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '{{ $geocerca->color ?? "#3B82F6" }}',
            fillOpacity: 0.3,
            map: map,
            center: center,
            radius: parseFloat({{ $geocerca->radio }}),
            geocercaId: '{{ $geocerca->id }}'
          });

          geocercasEnMapa.push(circle);
          bounds.extend(center);
        @elseif($geocerca->tipo == 'poligono' && $geocerca->coordenadas)
          @php
            $coordsArray = json_decode($geocerca->coordenadas, true) ?: [];
          @endphp
          
          @if(count($coordsArray) > 0)
            var coordinates = [];
            @foreach($coordsArray as $coord)
              coordinates.push(new google.maps.LatLng(parseFloat({{ $coord[0] }}), parseFloat({{ $coord[1] }})));
            @endforeach
            
            var polygon = new google.maps.Polygon({
              strokeColor: '{{ $geocerca->color ?? "#3B82F6" }}',
              strokeOpacity: 0.8,
              strokeWeight: 2,
              fillColor: '{{ $geocerca->color ?? "#3B82F6" }}',
              fillOpacity: 0.3,
              map: map,
              paths: coordinates,
              geocercaId: '{{ $geocerca->id }}'
            });
            
            geocercasEnMapa.push(polygon);
            
            // Extender bounds para incluir todos los puntos del polígono
            coordinates.forEach(function(point) {
              bounds.extend(point);
            });
          @endif
        @endif
      @endforeach

      if (geocercasEnMapa.length > 0) {
        map.fitBounds(bounds);
      }
    @endif
  }

  function centrarMapa() {
    if (geocercasEnMapa.length > 0) {
      map.fitBounds(bounds);
    } else {
      map.setCenter({ lat: 19.4326, lng: -99.1332 });
      map.setZoom(12);
    }
  }

  function verGeocercaEnMapa(geocercaId, tipo) {
    geocercasEnMapa.forEach(function(shape) {
      if (shape.geocercaId === geocercaId) {
        if (tipo === 'circular') {
          map.setCenter(shape.getCenter());
          map.setZoom(14);
        } else {
          var bounds = new google.maps.LatLngBounds();
          var path = shape.getPath();
          for (var i = 0; i < path.getLength(); i++) {
            bounds.extend(path.getAt(i));
          }
          map.fitBounds(bounds);
        }
        
        shape.setOptions({
          strokeWeight: 4,
          fillOpacity: 0.5
        });
        
        setTimeout(function() {
          shape.setOptions({
            strokeWeight: 2,
            fillOpacity: 0.3
          });
        }, 3000);
      }
    });
  }
</script>

<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.js"></script>
</body>
</html>