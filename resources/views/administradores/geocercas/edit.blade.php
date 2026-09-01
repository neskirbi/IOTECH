<!DOCTYPE html>
<html lang="es">
<head>
  @include('header')
  <title>{{ getSiteTitle('Editar Geocerca') }}</title>
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
    /* Estilos para el control de mapa personalizado */
    .custom-map-control {
      background: white;
      border-radius: 4px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.3);
      padding: 4px;
      margin: 10px;
      display: flex;
      flex-direction: column;
    }
    .custom-map-control button {
      background: white;
      border: none;
      border-radius: 2px;
      padding: 8px 12px;
      cursor: pointer;
      font-size: 12px;
      font-weight: 500;
      color: #333;
      transition: all 0.2s;
      min-width: 80px;
      text-align: center;
    }
    .custom-map-control button:hover {
      background: #f0f0f0;
    }
    .custom-map-control button.active {
      background: #1a73e8;
      color: white;
    }
    .custom-map-control button:first-child {
      border-bottom: 1px solid #e0e0e0;
    }

    /* Estilos para el buscador de direcciones */
    .search-box {
      position: absolute;
      top: 10px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 5;
      width: 90%;
      max-width: 500px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
      padding: 8px 12px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .search-box input {
      flex: 1;
      border: none;
      outline: none;
      padding: 8px 0;
      font-size: 14px;
      background: transparent;
      color: #333;
    }
    .search-box input::placeholder {
      color: #999;
    }
    .search-box button {
      background: #1a73e8;
      border: none;
      border-radius: 6px;
      color: white;
      padding: 6px 14px;
      cursor: pointer;
      font-weight: 500;
      font-size: 13px;
      transition: background 0.2s;
    }
    .search-box button:hover {
      background: #1557b0;
    }
    .search-box .clear-btn {
      background: transparent;
      color: #999;
      padding: 4px 6px;
      font-size: 18px;
      cursor: pointer;
      display: none;
    }
    .search-box .clear-btn:hover {
      color: #333;
    }
    .search-results {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: white;
      border-radius: 0 0 8px 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      max-height: 200px;
      overflow-y: auto;
      display: none;
      z-index: 10;
    }
    .search-results .result-item {
      padding: 10px 14px;
      cursor: pointer;
      border-bottom: 1px solid #f0f0f0;
      font-size: 13px;
      color: #333;
    }
    .search-results .result-item:hover {
      background: #f5f5f5;
    }
    .search-results .result-item:last-child {
      border-bottom: none;
    }
    .search-results .result-item .main-text {
      font-weight: 500;
    }
    .search-results .result-item .sub-text {
      font-size: 12px;
      color: #777;
    }
    .search-results .error-item {
      padding: 12px 14px;
      color: #e74c3c;
      text-align: center;
      font-size: 13px;
    }
    .search-results .loading-item {
      padding: 12px 14px;
      color: #999;
      text-align: center;
      font-size: 13px;
    }
    .search-results .no-results {
      padding: 12px 14px;
      color: #999;
      text-align: center;
      font-size: 13px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="background-color: var(--bg-main);">
@include('toast.toasts')
<div class="wrapper">

  <!-- Navbar y Sidebar -->
  @include('administradores.navbar')
  @include('administradores.sidebar')

  <div class="content-wrapper" style="background-color: var(--bg-main);">
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center">
          <div class="col-sm-6">
            <h1 class="m-0 text-white font-weight-bold" style="font-size: 1.5rem;">
              <i class="fas fa-edit mr-2" style="color: var(--accent-cyan);"></i> Editar Geocerca
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('operadores') }}" class="text-cyan">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{ route('geocercas.index') }}" class="text-cyan">Geocercas</a></li>
              <li class="breadcrumb-item active text-muted">Editar</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-12 mb-4">
            <div class="card card-oiion">
              
              <div class="card-header border-0 d-flex align-items-center justify-content-between w-100">
                <h3 class="card-title text-white font-weight-bold m-0">
                  <i class="fas fa-map-marked-alt mr-2" style="color: var(--accent-cyan);"></i> Ubicación y Configuración
                </h3>
              </div>
              
              <div class="card-body p-3">
                
                <!-- Mapa con buscador -->
                <div class="position-relative mb-4">
                  <div id="map"></div>
                  
                  <!-- Buscador de Direcciones -->
                  <div class="search-box" id="searchBox">
                    <i class="fas fa-search text-muted"></i>
                    <input type="text" id="searchInput" placeholder="Buscar dirección, ciudad o lugar..." autocomplete="off">
                    <button id="searchBtn" class="search-btn">Buscar</button>
                    <span class="clear-btn" id="clearSearch">×</span>
                    <div class="search-results" id="searchResults"></div>
                  </div>
                </div>

                <!-- Formulario -->
                <form action="{{ route('geocercas.update', $geocerca->id) }}" method="POST" id="geocerca-form">
                  @csrf
                  @method('PUT')
                  
                  <input type="hidden" name="tipo" value="{{ $geocerca->tipo }}">

                  <div class="row align-items-start">
                    
                    <!-- Columna 1: Datos Generales -->
                    <div class="col-md-5 mb-3">
                      <div class="form-group mb-3">
                        <label for="nombre" class="text-white font-weight-bold">Nombre de la Geocerca *</label>
                        <input type="text" class="form-control form-control-oiion" id="nombre" name="nombre" required value="{{ $geocerca->nombre }}">
                      </div>

                      <div class="form-group mb-3">
                        <label for="descripcion" class="text-white font-weight-bold">Descripción</label>
                        <textarea class="form-control form-control-oiion" id="descripcion" name="descripcion" rows="2">{{ $geocerca->descripcion }}</textarea>
                      </div>
                    </div>

                    <!-- Columna 2: Parámetros del Trazo -->
                    <div class="col-md-4 mb-3">
                      @if($geocerca->tipo == 'circular')
                        <small class="text-cyan d-block mb-2"><i class="fas fa-mouse-pointer mr-1"></i> Clic en el mapa o busca una dirección para reposicionar el centro.</small>
                        <div class="form-group mb-3">
                          <label for="radio" class="text-white font-weight-bold">Radio (metros) *</label>
                          <input type="number" class="form-control form-control-oiion" id="radio" name="radio" min="10" step="1" required value="{{ $geocerca->radio }}">
                        </div>
                        <div class="form-row">
                          <div class="col-6">
                            <div class="form-group mb-0">
                              <label for="latitud" class="text-white font-weight-bold small">Latitud *</label>
                              <input type="text" class="form-control form-control-oiion" id="latitud" name="latitud" required value="{{ $geocerca->latitud }}">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group mb-0">
                              <label for="longitud" class="text-white font-weight-bold small">Longitud *</label>
                              <input type="text" class="form-control form-control-oiion" id="longitud" name="longitud" required value="{{ $geocerca->longitud }}">
                            </div>
                          </div>
                        </div>
                        <input type="hidden" id="coordenadas" name="coordenadas" value="">
                      @else
                        <small class="text-cyan d-block mb-2"><i class="fas fa-hand-pointer mr-1"></i> Arrastra los vértices en el mapa para editarlos.</small>
                        <input type="hidden" id="coordenadas" name="coordenadas" value="{{ $geocerca->coordenadas }}">
                        <input type="hidden" id="latitud" name="latitud" value="">
                        <input type="hidden" id="longitud" name="longitud" value="">
                        <input type="hidden" id="radio" name="radio" value="">
                        
                        <div class="p-3 border rounded text-center" style="background: var(--bg-main); border-color: var(--border-color) !important;">
                          <i class="fas fa-draw-polygon text-cyan fa-2x mb-2"></i>
                          <div class="text-muted small">Modo Polígono Activo</div>
                        </div>
                      @endif
                    </div>

                    <!-- Columna 3: Color y Botones -->
                    <div class="col-md-3 mb-3">
                      <div class="form-group mb-4">
                        <label for="color" class="text-white font-weight-bold d-block">Color del Área</label>
                        <div class="color-picker-wrapper">
                          <input type="color" id="color" name="color" value="{{ $geocerca->color ?? '#3B82F6' }}">
                          <span class="small text-muted">Personalizar trazo</span>
                        </div>
                      </div>

                      <div class="form-group mb-0 pt-2">
                        <button type="submit" class="btn btn-action btn-block font-weight-bold py-2 mb-2">
                          <i class="fas fa-save mr-1"></i> Guardar Cambios
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
@include('administradores.footer')

<script>
  var map;
  var circle = null;
  var polygon = null;
  var geocoder = null;
  var markers = [];
  var geocodingError = false;

  function inicializarAplicacion() {
    initMap();
    configurarEventos();
    agregarControlesMapa();
    configurarBuscador();
    
    // Verificar si el Geocoder está disponible
    if (typeof google !== 'undefined' && google.maps && google.maps.Geocoder) {
      try {
        geocoder = new google.maps.Geocoder();
        // Probar si funciona con una búsqueda simple
        geocoder.geocode({ address: 'Mexico' }, function(results, status) {
          if (status === 'OK') {
            console.log('Geocoding API funcionando correctamente');
          } else {
            console.warn('Geocoding API no disponible o no activada:', status);
            geocodingError = true;
            mostrarErrorGeocoding();
          }
        });
      } catch (e) {
        console.warn('Error al inicializar Geocoder:', e);
        geocodingError = true;
        mostrarErrorGeocoding();
      }
    } else {
      geocodingError = true;
      mostrarErrorGeocoding();
    }
  }

  function mostrarErrorGeocoding() {
    var resultsContainer = document.getElementById('searchResults');
    if (resultsContainer) {
      resultsContainer.innerHTML = `
        <div class="error-item">
          <i class="fas fa-exclamation-triangle mr-2"></i>
          La búsqueda de direcciones no está disponible. 
          <br><small>Habilita la Geocoding API en la consola de Google Cloud.</small>
        </div>
      `;
    }
  }

  function cargarGoogleMaps() {
    if (typeof google !== 'undefined' && google.maps) {
      inicializarAplicacion();
      return;
    }
    
    var script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=drawing,geometry,places&callback=inicializarAplicacion';
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

  // Función para agregar controles personalizados de mapa y satélite
  function agregarControlesMapa() {
    var controlDiv = document.createElement('div');
    controlDiv.className = 'custom-map-control';
    
    var btnMapa = document.createElement('button');
    btnMapa.textContent = '🌍 Mapa';
    btnMapa.className = 'active';
    btnMapa.addEventListener('click', function() {
      map.setMapTypeId('roadmap');
      btnMapa.className = 'active';
      btnSatelite.className = '';
    });
    
    var btnSatelite = document.createElement('button');
    btnSatelite.textContent = '🛰️ Satélite';
    btnSatelite.addEventListener('click', function() {
      map.setMapTypeId('satellite');
      btnSatelite.className = 'active';
      btnMapa.className = '';
    });
    
    controlDiv.appendChild(btnMapa);
    controlDiv.appendChild(btnSatelite);
    
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);
  }

  // ========== CONFIGURACIÓN DEL BUSCADOR ==========
  function configurarBuscador() {
    var searchInput = document.getElementById('searchInput');
    var searchBtn = document.getElementById('searchBtn');
    var clearBtn = document.getElementById('clearSearch');
    var resultsContainer = document.getElementById('searchResults');

    searchBtn.addEventListener('click', function() {
      realizarBusqueda(searchInput.value);
    });

    searchInput.addEventListener('keydown', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        realizarBusqueda(searchInput.value);
      }
    });

    searchInput.addEventListener('input', function() {
      clearBtn.style.display = this.value.length > 0 ? 'block' : 'none';
      if (this.value.length === 0) {
        resultsContainer.style.display = 'none';
        limpiarMarcadores();
      }
    });

    clearBtn.addEventListener('click', function() {
      searchInput.value = '';
      clearBtn.style.display = 'none';
      resultsContainer.style.display = 'none';
      limpiarMarcadores();
      searchInput.focus();
    });

    document.addEventListener('click', function(e) {
      var searchBox = document.getElementById('searchBox');
      if (!searchBox.contains(e.target)) {
        resultsContainer.style.display = 'none';
      }
    });
  }

  function realizarBusqueda(query) {
    if (!query.trim()) return;

    var resultsContainer = document.getElementById('searchResults');
    
    if (geocodingError) {
      resultsContainer.innerHTML = `
        <div class="error-item">
          <i class="fas fa-exclamation-triangle mr-2"></i>
          Servicio de búsqueda no disponible. 
          <br><small>Por favor, haz clic directamente en el mapa para ubicar el punto.</small>
        </div>
      `;
      resultsContainer.style.display = 'block';
      return;
    }

    resultsContainer.innerHTML = '<div class="loading-item"><i class="fas fa-spinner fa-spin mr-2"></i>Buscando...</div>';
    resultsContainer.style.display = 'block';

    try {
      geocoder.geocode({ address: query }, function(results, status) {
        if (status === 'OK') {
          if (results.length === 0) {
            resultsContainer.innerHTML = '<div class="no-results">No se encontraron resultados</div>';
            return;
          }

          resultsContainer.innerHTML = '';
          results.forEach(function(result) {
            var item = document.createElement('div');
            item.className = 'result-item';
            item.innerHTML = `
              <div class="main-text">${result.formatted_address}</div>
              <div class="sub-text">${result.types.join(', ')}</div>
            `;
            item.addEventListener('click', function() {
              seleccionarDireccion(result);
            });
            resultsContainer.appendChild(item);
          });
        } else {
          var errorMsg = '';
          switch(status) {
            case 'ZERO_RESULTS':
              errorMsg = 'No se encontraron resultados para esta búsqueda.';
              break;
            case 'OVER_QUERY_LIMIT':
              errorMsg = 'Demasiadas solicitudes. Por favor, espera un momento.';
              break;
            case 'REQUEST_DENIED':
              errorMsg = 'La API no está activada o la clave es inválida.';
              break;
            default:
              errorMsg = 'Error en la búsqueda: ' + status;
          }
          resultsContainer.innerHTML = `<div class="error-item"><i class="fas fa-exclamation-triangle mr-2"></i>${errorMsg}</div>`;
          console.warn('Geocoding error:', status);
        }
      });
    } catch (e) {
      console.warn('Error en búsqueda:', e);
      resultsContainer.innerHTML = `
        <div class="error-item">
          <i class="fas fa-exclamation-triangle mr-2"></i>
          Error al realizar la búsqueda. Por favor, intenta de nuevo.
        </div>
      `;
    }
  }

  function seleccionarDireccion(result) {
    var location = result.geometry.location;
    var lat = location.lat();
    var lng = location.lng();

    document.getElementById('searchResults').style.display = 'none';
    document.getElementById('searchInput').value = result.formatted_address;
    document.getElementById('clearSearch').style.display = 'block';

    map.setCenter(location);
    map.setZoom(15);

    limpiarMarcadores();

    var marker = new google.maps.Marker({
      position: location,
      map: map,
      title: result.formatted_address,
      animation: google.maps.Animation.DROP
    });
    markers.push(marker);

    // Si estamos en modo círculo, usar esta ubicación como centro
    @if($geocerca->tipo == 'circular')
      if (circle) {
        circle.setCenter(location);
        $('#latitud').val(lat.toFixed(8));
        $('#longitud').val(lng.toFixed(8));
      }
    @endif
  }

  function limpiarMarcadores() {
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];
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
      limpiarMarcadores();
    });

    google.maps.event.addListener(map, 'click', function(e) {
      if (circle) {
        circle.setCenter(e.latLng);
        $('#latitud').val(e.latLng.lat().toFixed(8));
        $('#longitud').val(e.latLng.lng().toFixed(8));
        limpiarMarcadores();
      }
    });
  }

  function dibujarPoligonoExistente() {
    @php
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

      var path = polygon.getPath();
      google.maps.event.addListener(path, 'set_at', actualizarCoordenadasPoligono);
      google.maps.event.addListener(path, 'insert_at', actualizarCoordenadasPoligono);
      google.maps.event.addListener(path, 'remove_at', actualizarCoordenadasPoligono);
      
      google.maps.event.addListener(polygon, 'dragend', function() {
        actualizarCoordenadasPoligono();
      });
      
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
      coordinates.push([
        parseFloat(point.lat().toFixed(8)), 
        parseFloat(point.lng().toFixed(8))
      ]);
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

    @if($geocerca->tipo == 'circular')
      $('#latitud, #longitud, #radio').on('input', function() {
        if (!circle) return;
        var lat = parseFloat($('#latitud').val());
        var lng = parseFloat($('#longitud').val());
        var radio = parseFloat($('#radio').val());

        if (!isNaN(lat) && !isNaN(lng)) {
          var newCenter = new google.maps.LatLng(lat, lng);
          circle.setCenter(newCenter);
          map.panTo(newCenter);
          limpiarMarcadores();
        }
        
        if (!isNaN(radio) && radio > 0) {
          circle.setRadius(radio);
        }
      });
    @endif
  }

  $(document).ready(function() {
    cargarGoogleMaps();
  });
</script>
</body>
</html>