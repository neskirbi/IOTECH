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
    .geocerca-card:hover {
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .geocerca-badge {
      font-size: 0.8em;
      padding: 3px 8px;
    }
    .map-controls {
      position: absolute;
      top: 10px;
      left: 10px;
      z-index: 1000;
    }
    .botones-columna {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    .botones-columna .btn {
      width: 100%;
      text-align: center;
    }
    .modal-danger .modal-header {
      background-color: #dc3545;
      color: white;
    }
    .delete-icon {
      font-size: 4rem;
      color: #dc3545;
      margin-bottom: 1rem;
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
    <!-- /.content-header -->

    <!-- Main content -->
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
                              <span class="badge badge-success geocerca-badge">Activa</span>
                            @else
                              <span class="badge badge-danger geocerca-badge">Inactiva</span>
                            @endif
                          </h5>
                          <p class="card-text text-muted">
                            <i class="fas fa-info-circle"></i> {{ $geocerca->descripcion ?? 'Sin descripción' }}
                          </p>
                          <p class="card-text">
                            <small class="text-muted">
                              <i class="fas fa-map-marker-alt"></i> Lat: {{ $geocerca->latitud }}, Lng: {{ $geocerca->longitud }}<br>
                              <i class="fas fa-expand-arrows-alt"></i> Radio: {{ $geocerca->radio }} {{ $geocerca->unidad_distancia ?? 'metros' }}<br>
                              <i class="far fa-clock"></i> Creada: {{ $geocerca->created_at->format('d/m/Y H:i') }}
                            </small>
                          </p>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                          <div class="botones-columna">
                            <button type="button" class="btn btn-info btn-sm ver-geocerca" 
                                    data-id="{{ $geocerca->id }}" 
                                    data-nombre="{{ $geocerca->nombre }}"
                                    data-lat="{{ $geocerca->latitud }}"
                                    data-lng="{{ $geocerca->longitud }}">
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
  var geocercasEnMapa = [];
  var bounds = new google.maps.LatLngBounds();

  // Función que se llama cuando Google Maps está listo
  function inicializarAplicacion() {
    // Inicializar mapa
    initMap();
    
    // Configurar eventos de botones después de que jQuery esté listo
    $(document).ready(function() {
      // Eventos para los botones Ver
      $('.ver-geocerca').click(function() {
        var geocercaId = $(this).data('id');
        var nombre = $(this).data('nombre');
        var lat = $(this).data('lat');
        var lng = $(this).data('lng');
        verGeocercaEnMapa(geocercaId, nombre, lat, lng);
      });
      
      // Eventos para los botones Eliminar
      $('.btn-eliminar').click(function() {
        var geocercaId = $(this).data('id');
        var geocercaNombre = $(this).data('nombre');
        var deleteUrl = $(this).data('url');
        
        // Configurar el modal
        $('#geocercaName').text('"' + geocercaNombre + '"');
        $('#deleteForm').attr('action', deleteUrl);
        
        // Mostrar el modal
        $('#confirmDeleteModal').modal('show');
      });
    });
  }

  // Inicializar mapa
  function initMap() {
    // Coordenadas por defecto (Ciudad de México)
    var defaultCenter = { lat: 19.4326, lng: -99.1332 };
    
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: defaultCenter,
      mapTypeId: 'roadmap',
      streetViewControl: false,
      mapTypeControl: false,
      fullscreenControl: true,
      zoomControl: true
    });

    // Cargar geocercas en el mapa
    cargarGeocercasEnMapa();
  }

  // Cargar geocercas en el mapa
  function cargarGeocercasEnMapa() {
    // Limpiar geocercas anteriores
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

          // Crear infowindow
          var infowindow = new google.maps.InfoWindow({
            content: `
              <div class="p-2">
                <h6 class="font-weight-bold">{{ $geocerca->nombre }}</h6>
                <p class="mb-1">{{ $geocerca->descripcion ?? 'Sin descripción' }}</p>
                <p class="mb-0 small">
                  <i class="fas fa-circle"></i> Radio: {{ $geocerca->radio }} {{ $geocerca->unidad_distancia ?? 'metros' }}
                </p>
              </div>
            `
          });

          // Evento para mostrar infowindow
          circle.addListener('click', function() {
            infowindow.open(map);
            infowindow.setPosition(center);
          });

          geocercasEnMapa.push(circle);
          bounds.extend(center);
        @endif
      @endforeach

      // Ajustar zoom para mostrar todas las geocercas
      if (geocercasEnMapa.length > 0) {
        map.fitBounds(bounds);
        // Limitar zoom máximo
        google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
          if (this.getZoom() > 15) {
            this.setZoom(15);
          }
        });
      }
    @endif
  }

  // Centrar mapa en las geocercas
  function centrarMapa() {
    if (geocercasEnMapa.length > 0) {
      map.fitBounds(bounds);
    } else {
      map.setCenter({ lat: 19.4326, lng: -99.1332 });
      map.setZoom(12);
    }
  }

  // Función para ver geocerca en el mapa
  function verGeocercaEnMapa(geocercaId, nombre, lat, lng) {
    var center = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
    map.setCenter(center);
    map.setZoom(14);
    
    // Destacar la geocerca
    geocercasEnMapa.forEach(function(circle) {
      if (circle.geocercaId === geocercaId) {
        circle.setOptions({
          strokeWeight: 4,
          fillOpacity: 0.5
        });
        setTimeout(function() {
          circle.setOptions({
            strokeWeight: 2,
            fillOpacity: 0.3
          });
        }, 3000);
      }
    });
  }
</script>

<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
</body>
</html>