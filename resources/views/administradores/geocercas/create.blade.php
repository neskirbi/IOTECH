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
                <!-- Mapa extendido al 100% con controles personalizados -->
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
@include('administradores.footer')
<script>
  var map;
  var circle = null;
  var polygon = null;
  var polygonPath = [];
  var circleCenter = null;
  var drawingMode = null;
  var polygonClickListener = null;
  var geocoder = null;
  var markers = [];

  function inicializarAplicacion() {
    initMap();
    configurarEventos();
    agregarControlesMapa();
    configurarBuscador();
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
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: { lat: 19.4326, lng: -99.1332 },
      mapTypeId: 'roadmap',
      streetViewControl: false,
      mapTypeControl: false,
      fullscreenControl: true
    });
    
    geocoder = new google.maps.Geocoder();
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

    // Buscar al hacer clic en el botón
    searchBtn.addEventListener('click', function() {
      realizarBusqueda(searchInput.value);
    });

    // Buscar al presionar Enter
    searchInput.addEventListener('keydown', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        realizarBusqueda(searchInput.value);
      }
    });

    // Mostrar/ocultar botón de limpiar
    searchInput.addEventListener('input', function() {
      clearBtn.style.display = this.value.length > 0 ? 'block' : 'none';
      if (this.value.length === 0) {
        resultsContainer.style.display = 'none';
        limpiarMarcadores();
      }
    });

    // Limpiar búsqueda
    clearBtn.addEventListener('click', function() {
      searchInput.value = '';
      clearBtn.style.display = 'none';
      resultsContainer.style.display = 'none';
      limpiarMarcadores();
      searchInput.focus();
    });

    // Cerrar resultados al hacer clic fuera
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
    resultsContainer.innerHTML = '<div class="result-item" style="color:#999;text-align:center;">Buscando...</div>';
    resultsContainer.style.display = 'block';

    geocoder.geocode({ address: query }, function(results, status) {
      if (status === 'OK') {
        if (results.length === 0) {
          resultsContainer.innerHTML = '<div class="result-item" style="color:#999;text-align:center;">No se encontraron resultados</div>';
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
        resultsContainer.innerHTML = `<div class="result-item" style="color:#e74c3c;text-align:center;">Error: ${status}</div>`;
      }
    });
  }

  function seleccionarDireccion(result) {
    var location = result.geometry.location;
    var lat = location.lat();
    var lng = location.lng();

    // Cerrar resultados
    document.getElementById('searchResults').style.display = 'none';
    document.getElementById('searchInput').value = result.formatted_address;
    document.getElementById('clearSearch').style.display = 'block';

    // Centrar mapa en la ubicación
    map.setCenter(location);
    map.setZoom(15);

    // Limpiar marcadores anteriores
    limpiarMarcadores();

    // Agregar marcador
    var marker = new google.maps.Marker({
      position: location,
      map: map,
      title: result.formatted_address,
      animation: google.maps.Animation.DROP
    });
    markers.push(marker);

    // Si estamos en modo círculo, usar esta ubicación como centro
    if (drawingMode === 'circular') {
      circleCenter = location;
      $('#latitud').val(lat.toFixed(8));
      $('#longitud').val(lng.toFixed(8));
      dibujarCirculo();
    }
  }

  function limpiarMarcadores() {
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];
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
        limpiarMarcadores();
      } else if (tipo === 'poligono') {
        $('#default-fields-msg').hide();
        $('#circle-fields').hide();
        $('#polygon-fields').show();
        iniciarDibujoPoligono();
        limpiarMarcadores();
      } else {
        $('#default-fields-msg').show();
        $('#circle-fields').hide();
        $('#polygon-fields').hide();
        limpiarDibujo();
        limpiarMarcadores();
      }
      
      actualizarEstadoBoton();
    });

    google.maps.event.addListener(map, 'click', function(event) {
      if (drawingMode === 'circular') {
        circleCenter = event.latLng;
        $('#latitud').val(circleCenter.lat().toFixed(8));
        $('#longitud').val(circleCenter.lng().toFixed(8));
        dibujarCirculo();
        // Limpiar marcadores al hacer clic en el mapa
        limpiarMarcadores();
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