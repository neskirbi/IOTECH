<!DOCTYPE html>
<html lang="es">
<head>
  @include('header')
  <title>{{ getSiteTitle('Geocercas') }}</title>
  <!-- Google Maps API -->
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=drawing,geometry&callback=inicializarAplicacion" async defer></script>
  
  <style>
    #map {
      height: 480px;
      width: 100%;
      border-radius: 12px;
      border: 1px solid var(--border-color);
    }
    .geocerca-card {
      border: 1px solid var(--border-color);
      border-left: 4px solid #3B82F6;
      background-color: var(--bg-card);
      border-radius: 8px;
      margin-bottom: 15px;
      transition: all 0.3s ease;
    }
    .geocerca-card:hover {
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    }
    .map-controls-overlay {
      position: absolute;
      top: 25px;
      right: 25px;
      z-index: 5;
    }

    /* ===== NUEVOS ESTILOS PARA SWITCH ===== */
    .switch-container {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin-right: 10px;
    }
    .switch-container .switch-label {
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--text-muted);
      cursor: pointer;
    }
    .switch-container .switch-label.active {
      color: var(--accent-green);
    }
    .switch-container .switch-label.inactive {
      color: var(--accent-red);
    }
    .switch-container .custom-switch {
      padding-left: 2.2rem;
      margin-bottom: 0;
    }
    .switch-container .custom-control-label::before {
      width: 2rem;
      height: 1rem;
      border-radius: 1rem;
      background-color: var(--bg-main);
      border: 1px solid var(--border-color);
    }
    .switch-container .custom-control-label::after {
      width: 0.8rem;
      height: 0.8rem;
      border-radius: 50%;
      background-color: var(--text-muted);
      top: 0.1rem;
      left: -1.8rem;
      transition: all 0.3s ease;
    }
    .switch-container .custom-control-input:checked ~ .custom-control-label::before {
      background-color: var(--accent-green);
      border-color: var(--accent-green);
    }
    .switch-container .custom-control-input:checked ~ .custom-control-label::after {
      background-color: #fff;
      transform: translateX(1rem);
    }
    .switch-container .custom-control-input:disabled ~ .custom-control-label {
      opacity: 0.5;
      cursor: not-allowed;
    }

    /* ===== ESTILOS BUSCADOR ===== */
    .search-box .form-control {
      background-color: var(--bg-main) !important;
      border: 1px solid var(--border-color) !important;
      color: var(--text-main) !important;
    }
    .search-box .form-control:focus {
      border-color: var(--accent-cyan) !important;
      box-shadow: 0 0 0 2px rgba(6, 182, 212, 0.15) !important;
    }
    .search-box .btn-search {
      background-color: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-muted);
    }
    .search-box .btn-search:hover {
      background-color: var(--bg-hover);
      color: var(--text-main);
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="background-color: var(--bg-main);">
@include('toast.toasts')

<!-- Modal de Confirmación para Eliminar Geocerca -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color: var(--bg-card); border: 1px solid rgba(239, 68, 68, 0.4); box-shadow: 0 0 20px rgba(239, 68, 68, 0.2);">
      
      <div class="modal-header border-0" style="background-color: rgba(239, 68, 68, 0.08);">
        <h5 class="modal-title text-white font-weight-bold" id="confirmDeleteModalLabel">
          <i class="fas fa-exclamation-triangle mr-2" style="color: var(--accent-red);"></i> Confirmar Eliminación
        </h5>
        <button type="button" class="close text-white-50" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body text-center text-light py-4">
        <div class="mb-3">
          <i class="fas fa-draw-polygon fa-3x" style="color: var(--accent-red);"></i>
        </div>
        <h4 class="text-white font-weight-bold mb-2">¿Deseas eliminar esta geocerca?</h4>
        <p class="text-white-50 font-weight-bold" id="geocercaName"></p>
        <p class="text-muted small mb-0">Esta acción no se puede deshacer de forma permanente.</p>
      </div>

      <div class="modal-footer border-0" style="background-color: rgba(255, 255, 255, 0.02);">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
          <i class="fas fa-times mr-1"></i> Cancelar
        </button>
        <form id="deleteForm" method="POST" action="" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm" style="background-color: var(--accent-red); color: #fff; font-weight: 600;">
            <i class="fas fa-trash-alt mr-1"></i> Sí, Eliminar
          </button>
        </form>
      </div>

    </div>
  </div>
</div>

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
              <i class="fas fa-draw-polygon mr-2" style="color: var(--accent-cyan);"></i> Gestión de Geocercas
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('operadores') }}" class="text-cyan">Inicio</a></li>
              <li class="breadcrumb-item active text-muted">Geocercas</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        
        <!-- Mapa de Geocercas -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card card-oiion">
              
              <!-- HEADER CORREGIDO CON w-100 Y justify-content-between -->
              <div class="card-header border-0 d-flex align-items-center justify-content-between w-100">
                <h3 class="card-title text-white font-weight-bold m-0">
                  <i class="fas fa-map-marked-alt mr-2" style="color: var(--accent-cyan);"></i> Mapa Interactivo
                </h3>
                <div class="card-tools ml-auto">
                  <a href="{{ route('geocercas.create') }}" class="btn btn-action btn-sm">
                    <i class="fas fa-plus mr-1"></i> Crear Geocerca
                  </a>
                </div>
              </div>

              <div class="card-body position-relative p-3">
                <div id="map"></div>
                <!-- Control en mapa -->
                <div class="map-controls-overlay">
                  <button type="button" class="btn btn-sm btn-dark text-cyan border-secondary" onclick="centrarMapa()" style="box-shadow: 0 4px 10px rgba(0,0,0,0.5);">
                    <i class="fas fa-crosshairs mr-1"></i> Centrar Mapa
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Lista de Geocercas -->
        <div class="row">
          <div class="col-12">
            <div class="card card-oiion">
              <div class="card-header border-0">
                <div class="row align-items-center">
                  <div class="col-md-5">
                    <h3 class="card-title text-white font-weight-bold m-0">
                      <i class="fas fa-list mr-2" style="color: var(--accent-green);"></i> Geocercas Registradas
                      <span class="badge badge-info ml-2">{{ $geocercas->total() }}</span>
                    </h3>
                  </div>
                  <div class="col-md-7">
                    <!-- BUSCADOR -->
                    <form method="GET" action="{{ route('geocercas.index') }}" class="search-box">
                      <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Buscar por nombre o descripción..." 
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                          <button class="btn btn-search" type="submit">
                            <i class="fas fa-search"></i>
                          </button>
                          @if(request('search'))
                            <a href="{{ route('geocercas.index') }}" class="btn btn-search">
                              <i class="fas fa-times"></i>
                            </a>
                          @endif
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card-body">
                @if($geocercas->count() > 0)
                  @foreach($geocercas as $geocerca)
<div class="card geocerca-card" style="border-left-color: {{ $geocerca->color ?? '#3B82F6' }};">
  <div class="card-body py-3">
    <div class="row align-items-center">
      
      <!-- Datos Principales -->
      <div class="col-md-8 col-8">
        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
          <h5 class="card-title text-white font-weight-bold m-0" style="font-size: 1.1rem;">
            {{ $geocerca->nombre }}
          </h5>
          
          <!-- Badge Estado Parpadeante -->
          <span class="status-badge {{ $geocerca->activa ? 'online' : 'offline' }} ml-2">
            <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
            <span class="badge-text">{{ $geocerca->activa ? 'Activa' : 'Inactiva' }}</span>
          </span>

          <span class="badge bg-dark border border-secondary text-cyan ml-1" style="font-size: 0.75rem;">
            <i class="{{ $geocerca->tipo == 'circular' ? 'fas fa-circle-notch' : 'fas fa-draw-polygon' }} mr-1"></i>
            {{ ucfirst($geocerca->tipo) }}
          </span>
        </div>

        <p class="card-text text-muted small mb-2">
          {{ $geocerca->descripcion ?? 'Sin descripción proporcionada.' }}
        </p>

        <p class="card-text mb-0">
          <small class="text-muted">
            @if($geocerca->tipo == 'circular')
              <i class="fas fa-map-marker-alt mr-1 text-cyan"></i> Centro: {{ number_format($geocerca->latitud, 6) }}, {{ number_format($geocerca->longitud, 6) }} &bull;
              <i class="fas fa-expand-arrows-alt mx-1 text-cyan"></i> Radio: {{ $geocerca->radio }} {{ $geocerca->unidad_distancia ?? 'metros' }} &bull;
            @else
              <i class="fas fa-draw-polygon mr-1 text-cyan"></i> Polígono delimitado por coordenadas &bull;
            @endif
            <i class="far fa-clock ml-1 mr-1"></i> Creada: {{ $geocerca->created_at->format('d/m/Y H:i') }}
          </small>
        </p>
      </div>

      <!-- Menú Desplegable con Switch dentro -->
      <div class="col-md-4 col-4 text-right">
        <div class="btn-group dropleft">
          <button class="btn btn-sm text-white-50 border-0" type="button" 
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
                  style="background: transparent;">
            <i class="fas fa-ellipsis-v text-white font-weight-bold" style="font-size: 1.2rem;"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right" style="background-color: var(--bg-card); border-color: var(--border-color); min-width: 200px;">
            
            <!-- SWITCH DENTRO DEL DROPDOWN -->
            <div class="dropdown-item-switch">
              <span class="switch-label ">
                Activar o Desactivar
              </span>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input toggle-status" 
                       id="toggle_{{ $geocerca->id }}"
                       data-id="{{ $geocerca->id }}"
                       {{ $geocerca->activa ? 'checked' : '' }}>
                <label class="custom-control-label" for="toggle_{{ $geocerca->id }}"></label>
              </div>
            </div>
            
            <div class="dropdown-divider" style="border-color: var(--border-color);"></div>
            
            <!-- Ver en Mapa -->
            <a class="dropdown-item text-light ver-geocerca" href="javascript:void(0)" 
               data-id="{{ $geocerca->id }}" data-tipo="{{ $geocerca->tipo }}">
              <i class="fas fa-eye mr-2 text-info"></i> Ver en Mapa
            </a>

            <!-- Editar -->
            <a class="dropdown-item text-light" href="{{ route('geocercas.edit', $geocerca->id) }}">
              <i class="fas fa-edit mr-2 text-warning"></i> Editar
            </a>

            <div class="dropdown-divider" style="border-color: var(--border-color);"></div>

            <!-- Eliminar -->
            <a class="dropdown-item text-danger btn-eliminar" href="javascript:void(0)"
               data-id="{{ $geocerca->id }}" 
               data-nombre="{{ $geocerca->nombre }}"
               data-url="{{ route('geocercas.destroy', $geocerca->id) }}">
              <i class="fas fa-trash-alt mr-2"></i> Eliminar
            </a>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endforeach
                @else
                  <div class="alert text-cyan border-secondary" style="background-color: rgba(6, 182, 212, 0.05);">
                    <i class="fas fa-info-circle mr-2"></i> No hay geocercas registradas. 
                    <a href="{{ route('geocercas.create') }}" class="text-white text-underline font-weight-bold ml-1">Crea tu primera geocerca aquí</a>.
                  </div>
                @endif
              </div>

              @if($geocercas->hasPages())
              <div class="card-footer border-top-0" style="background-color: transparent;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                  <div class="text-muted small">
                    Mostrando {{ $geocercas->firstItem() ?? 0 }} - {{ $geocercas->lastItem() ?? 0 }} de {{ $geocercas->total() }} geocercas
                  </div>
                  <div>
                    {{ $geocercas->appends(request()->query())->links('pagination::bootstrap-4') }}
                  </div>
                </div>
              </div>
              @endif
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

      // Toggle de estado (Activar/Desactivar)
      $(document).on('change', '.toggle-status', function() {
        var checkbox = $(this);
        var id = checkbox.data('id');
        var isChecked = checkbox.prop('checked');
        var card = checkbox.closest('.geocerca-card');
        var statusBadge = card.find('.status-badge');
        var label = checkbox.closest('.switch-container').find('.switch-label');
        
        // Deshabilitar mientras se procesa
        checkbox.prop('disabled', true);
        
        $.ajax({
          url: Url()+'api/geocercas/' + id + '/toggle-status',
          method: 'PUT',
          data: {
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            if (response.success) {
              // Actualizar badge
              statusBadge.removeClass('online offline');
              if (response.activa) {
                statusBadge.addClass('online');
                statusBadge.find('.badge-text').text('Activa');
                label.removeClass('inactive').addClass('active').text('Activa');
              } else {
                statusBadge.addClass('offline');
                statusBadge.find('.badge-text').text('Inactiva');
                label.removeClass('active').addClass('inactive').text('Inactiva');
              }
              
              showToast(response.message, 'success');
            }
          },
          error: function() {
            // Revertir el cambio si hay error
            checkbox.prop('checked', !isChecked);
            showToast('Error al cambiar el estado de la geocerca', 'error');
          },
          complete: function() {
            checkbox.prop('disabled', false);
          }
        });
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

  // Toast notifications
  function showToast(message, type) {
    var toastContainer = document.getElementById('oiion-toast-container');
    if (!toastContainer) {
      var container = document.createElement('div');
      container.id = 'oiion-toast-container';
      document.body.appendChild(container);
      toastContainer = container;
    }
    
    var toast = document.createElement('div');
    toast.className = 'oiion-toast oiion-toast-' + type;
    
    var iconMap = {
      'success': 'fa-check-circle',
      'error': 'fa-exclamation-circle',
      'warning': 'fa-exclamation-triangle',
      'info': 'fa-info-circle'
    };
    
    toast.innerHTML = `
      <i class="fas ${iconMap[type] || 'fa-info-circle'} toast-icon mr-2"></i>
      <span>${message}</span>
      <button class="oiion-toast-close" onclick="this.parentElement.remove()">
        <i class="fas fa-times"></i>
      </button>
    `;
    
    toastContainer.appendChild(toast);
    setTimeout(function() { toast.classList.add('show'); }, 10);
    setTimeout(function() {
      toast.classList.remove('show');
      setTimeout(function() { toast.remove(); }, 300);
    }, 4000);
  }
</script>

@include('administradores.footer')
</body>
</html>