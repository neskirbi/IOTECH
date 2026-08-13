<!DOCTYPE html>
<html lang="es">
<head>
  @include('header')
  <title>OIIon | Gestión y Soporte de Equipos</title>
  
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=drawing&callback=inicializarAplicacion" async defer></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="background-color: var(--bg-main);">
@include('toast.toasts')  
<div class="wrapper">

  <!-- Navbar -->
  @include('administradores.navbar')

  <!-- Main Sidebar Container -->
  @include('administradores.sidebar')

  <!-- Content Wrapper -->
  <div class="content-wrapper" style="background-color: var(--bg-main);">
    
    <div class="content-header">
      <div class="container-fluid d-flex align-items-center justify-content-between">
        <h1 class="m-0 text-white font-weight-bold" style="font-size: 1.5rem;">
          <i class="fas fa-microchip mr-2" style="color: var(--accent-cyan);"></i> Gestión Integral de Equipos
        </h1>
        <!-- Botón para abrir el Modal de Nuevo Equipo -->
        <button type="button" class="btn btn-action btn-sm px-3 shadow-sm" data-toggle="modal" data-target="#modalRegistrarEquipo">
          <i class="fas fa-plus-circle mr-1"></i> Nuevo Equipo
        </button>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <!-- Card Principal de Equipos Registrados -->
            <div class="card card-oiion mb-4">
              <div class="card-header border-0 d-flex align-items-center justify-content-between">
                <h3 class="card-title text-white font-weight-bold">
                  <i class="fas fa-server mr-2" style="color: var(--accent-cyan);"></i> Listado de Equipos y Cajas Fuertes
                </h3>
              </div>
              
              <div class="card-body">
                <div class="row">
                  @foreach($equipos as $equipo)
                  @php 
                    // ============================================
                    // 1. ESTADO DEL EQUIPO (Activo/Inactivo)
                    //    Viene de equipos.activo
                    // ============================================
                    $estaActivo = (($equipo->activo ?? 1) == 1);
                    
                    // ============================================
                    // 2. ESTADO DE LA CHAPA (Abierto/Cerrado)
                    //    Viene de equipo_estados.cerrado (último registro)
                    // ============================================
                    $tieneEstado = isset($equipo->cerrado);
                    $chapaAbierta = $tieneEstado && $equipo->cerrado == 0;
                    $chapaCerrada = $tieneEstado && $equipo->cerrado == 1;
                    
                    // Variables para el badge de la chapa (izquierda)
                    $chapaClase = 'sin-estado';
                    $chapaTexto = 'Sin estado';
                    $chapaIcono = 'fa-question-circle';
                    
                    if ($chapaAbierta) {
                        $chapaClase = 'abierto';
                        $chapaTexto = 'Abierto';
                        $chapaIcono = 'fa-lock-open';
                    } elseif ($chapaCerrada) {
                        $chapaClase = 'cerrado';
                        $chapaTexto = 'Cerrado';
                        $chapaIcono = 'fa-lock';
                    }
                  @endphp
                  
                  <div class="col-xl-4 col-lg-4 col-md-6 mb-4">           
                    <div class="card card-oiion h-100" 
                         data-equipo-id="{{ $equipo->id }}"
                         style="border: 1px solid {{ $estaActivo ? 'var(--border-color)' : 'rgba(239, 68, 68, 0.4)' }}; background-color: rgba(21, 28, 47, 0.6);">
                      <div class="card-body d-flex flex-column justify-content-between p-3">
                        
                        <div>
                          <!-- Cabecera de la tarjeta con Estado y Opciones -->
                          <div class="d-flex justify-content-between align-items-center w-100 mb-2">
                            <h4 class="card-title text-white font-weight-bold m-0" style="font-size: 1.1rem;">
                              <i class="fas fa-vault mr-1" style="color: var(--accent-cyan);"></i> {{$equipo->numeconomico}}
                            </h4> 
                            
                            <!-- Menú de opciones de tres puntos -->
                            <div class="card-tools">
                              <div class="btn-group dropleft">
                                <button class="btn btn-sm text-white-50 border-0" type="button" id="menu_{{$equipo->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: transparent;">
                                  <i class="fas fa-ellipsis-v text-white"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" style="background-color: var(--bg-card); border-color: var(--border-color);">
                                  
                                  <!-- Alternar Estado del Equipo (Activo/Inactivo) -->
                                  <a class="dropdown-item text-light" id="btn_toggle_{{$equipo->id}}" href="javascript:void(0)" onclick="ToggleEquipoStatus('{{$equipo->id}}', this)">
                                    @if($estaActivo)
                                      <i class="fas fa-power-off mr-2 text-warning"></i> Desactivar Equipo
                                    @else
                                      <i class="fas fa-check-circle mr-2 text-success"></i> Activar Equipo
                                    @endif
                                  </a>

                                  <div class="dropdown-divider" style="border-color: var(--border-color);"></div>

                                  <!-- Eliminar -->
                                  <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="ConfirmarEliminarEquipo('{{$equipo->id}}', '{{$equipo->numeconomico}}')">
                                    <i class="fas fa-trash-alt mr-2"></i> Quitar Equipo
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- ============================================ -->
                          <!-- BADGE IZQUIERDA: ESTADO DE LA CHAPA (Abierto/Cerrado) -->
                          <!-- ============================================ -->
                          <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="status-badge {{ $chapaClase }}">
                              <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                              <i class="fas {{ $chapaIcono }} ml-1" style="font-size: 0.7rem;"></i>
                              <span class="badge-text">{{ $chapaTexto }}</span>
                            </span>

                            <!-- ============================================ -->
                            <!-- BADGE DERECHA: ESTADO DEL EQUIPO (Activo/Inactivo) -->
                            <!-- ============================================ -->
                            <span id="badge_estado_{{$equipo->id}}" class="status-badge {{ $estaActivo ? 'online' : 'offline' }}">
                              <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                              <span class="badge-text">{{ $estaActivo ? 'Activo' : 'Inactivo' }}</span>
                            </span>
                          </div>
                          
                          <!-- Datos del Equipo -->
                          <div class="text-left text-muted small p-2 rounded mb-3" style="background-color: rgba(10, 15, 29, 0.8); border: 1px solid var(--border-color);">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                              <span style="font-size: 0.8rem;"><i class="fas fa-id-card text-muted mr-1"></i> Matrícula:</span>
                              <strong class="text-white" style="font-size: 0.85rem;">{{$equipo->matricula}}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                              <span style="font-size: 0.8rem;"><i class="fas fa-network-wired text-muted mr-1"></i> MAC:</span>
                              <strong class="text-white" style="font-size: 0.8rem;">{{$equipo->mac}}</strong>
                            </div>
                            @if(isset($equipo->datetime))
                            <div class="d-flex justify-content-between align-items-center mt-1">
                              <span style="font-size: 0.7rem;"><i class="fas fa-clock text-muted mr-1"></i> Última actualización:</span>
                              <span class="text-muted" style="font-size: 0.7rem;">{{ \Carbon\Carbon::parse($equipo->datetime)->diffForHumans() }}</span>
                            </div>
                            @endif
                          </div>
                        </div>         
                        
                        <!-- Botones de Acción Rápida (Editar y Soporte) -->
                        <div class="d-flex" style="gap: 8px;">
                          <!-- Botón Editar -->
                          <button type="button" class="btn btn-outline-info btn-sm flex-fill" onclick="AbrirModalEditar('{{$equipo->id}}', '{{$equipo->numeconomico}}', '{{$equipo->matricula}}', '{{$equipo->mac}}')">
                            <i class="fas fa-edit mr-1"></i> Editar
                          </button>

                          <!-- Botón Soporte / Generar Código (SIEMPRE HABILITADO) -->
                          <button type="button" class="btn btn-action btn-sm flex-fill" onclick="PreCodigo('{{$equipo->id}}','{{$equipo->numeconomico}}','{{$equipo->mac}}'); ObtenerUltimoEstadoEquipo('{{$equipo->id}}','{{$equipo->numeconomico}}','{{$equipo->mac}}');" data-toggle="modal" data-target="#modalcodegen">
                              <i class="fas fa-key mr-1"></i> Soporte
                          </button>
                        </div>

                      </div>  
                    </div>
                  </div>
                  @endforeach
                </div>         
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>

  <footer class="main-footer border-top-0 text-muted" style="background-color: var(--bg-card); font-size: 0.85rem;">
    <div class="float-right d-none d-sm-inline">
      OIIon Security Platform
    </div>
    <strong>Copyright &copy; OIIon.</strong> Todos los derechos reservados.
  </footer>
</div>

<!-- ================= MODALES ================= -->

<!-- Modal Registrar Nuevo Equipo -->
<div class="modal fade" id="modalRegistrarEquipo" tabindex="-1" role="dialog" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color: var(--bg-card); border: 1px solid var(--border-color); box-shadow: 0 0 25px rgba(0, 242, 254, 0.15);">
      <div class="modal-header border-0">
        <h5 class="modal-title text-white font-weight-bold" id="modalRegistrarLabel">
          <i class="fas fa-plus-circle mr-2" style="color: var(--accent-cyan);"></i> Registrar Nuevo Equipo
        </h5>
        <button type="button" class="close text-white-50" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{url('equipos')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label class="text-muted">Número Económico</label>
            <input required type="text" class="form-control form-control-oiion" name="numeconomico" placeholder="Ej. EQ-101">
          </div>
          <div class="form-group">
            <label class="text-muted">Matrícula</label>
            <input required type="text" class="form-control form-control-oiion" name="matricula" placeholder="Ej. ABC-123">
          </div>
          <div class="form-group">
            <label class="text-muted">Dirección MAC</label>
            <input required type="text" class="form-control form-control-oiion" name="mac" placeholder="Ej. 00:1B:44:11:3A:B7">
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-action btn-sm">Registrar Equipo</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Editar Equipo -->
<div class="modal fade" id="modalEditarEquipo" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color: var(--bg-card); border: 1px solid var(--border-color); box-shadow: 0 0 25px rgba(0, 242, 254, 0.15);">
      <div class="modal-header border-0">
        <h5 class="modal-title text-white font-weight-bold" id="modalEditarLabel">
          <i class="fas fa-edit mr-2" style="color: var(--accent-cyan);"></i> Editar Equipo
        </h5>
        <button type="button" class="close text-white-50" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formEditarEquipo" action="" method="post">
        @csrf                                   
        @method('put')
        <div class="modal-body">
          <div class="form-group">
            <label class="text-muted">Número Económico</label>
            <input required type="text" class="form-control form-control-oiion" id="edit_numeconomico" name="numeconomico">
          </div>
          <div class="form-group">
            <label class="text-muted">Matrícula</label>
            <input required type="text" class="form-control form-control-oiion" id="edit_matricula" name="matricula">
          </div>
          <div class="form-group">
            <label class="text-muted">Dirección MAC</label>
            <input required type="text" class="form-control form-control-oiion" id="edit_mac" name="mac">
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-action btn-sm">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ============================================================ -->
<!-- MODAL DE SOPORTE CON ESTILOS DEL ORIGINAL Y MAPA GRANDE       -->
<!-- ============================================================ -->
<div class="modal fade" id="modalcodegen" tabindex="-1" role="dialog" aria-labelledby="modalCodeGenTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content" style="background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(12px); border: 1px solid rgba(0, 242, 254, 0.3); box-shadow: 0 0 25px rgba(0, 242, 254, 0.15); border-radius: 12px;">
      
      <!-- Header -->
      <div class="modal-header border-0 pb-0" style="background: transparent;">
        <div class="d-flex align-items-center">
          <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0, 242, 254, 0.1); border: 1px solid var(--accent-cyan);">
            <i class="fas fa-terminal" style="color: var(--accent-cyan); font-size: 1.2rem;"></i>
          </div>
          <div>
            <h5 class="modal-title text-white font-weight-bold mb-0" id="modalCodeGenTitle">Generar Código de Soporte</h5>
            <small class="text-muted" id="modal_subt_equipo">Instrucción de mando para la chapa/caja</small>
          </div>
        </div>
        <button type="button" class="close text-white-50 opacity-75" data-dismiss="modal" aria-label="Close" style="outline: none;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Body -->
      <div class="modal-body py-4">
        @csrf                        
        <div class="row">
          
          <!-- Columna Izquierda: Comandos y Generador -->
          <div class="col-md-5">
            <!-- Campo Código Entrada -->
            <div class="form-group mb-4">              
              <label for="codent" class="text-white-50 small font-weight-bold text-uppercase mb-2">Código Entrada</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text border-right-0" style="background: rgba(10, 15, 29, 0.8); border-color: rgba(0, 242, 254, 0.3); color: var(--accent-cyan);">
                    <i class="fas fa-barcode"></i>
                  </span>
                </div>
                <input type="text" class="form-control text-center font-weight-bold text-white border-left-0" id="codent" name="codent" placeholder="000000" style="background: rgba(10, 15, 29, 0.8); border-color: rgba(0, 242, 254, 0.3); font-size: 1.3rem; letter-spacing: 3px; color: #00f2fe !important;">
              </div>
            </div>

            <!-- Opciones tipo Selectors Neón (estilo original) -->
            <label class="text-white-50 small font-weight-bold text-uppercase mb-2">Acción a Ejecutar</label>
            <div class="row custom-oiion-radios px-2">
              
              <div class="col-6 p-1">
                <label class="w-100 m-0">
                  <input type="radio" value="1" name="opcion" class="card-radio-input" checked>
                  <div class="card-radio-btn p-2 text-center rounded d-flex align-items-center justify-content-center">
                    <i class="fas fa-bolt mr-2"></i> Activar Motor
                  </div>
                </label>
              </div>
            
              <div class="col-6 p-1">
                <label class="w-100 m-0">
                  <input type="radio" value="2" name="opcion" class="card-radio-input">
                  <div class="card-radio-btn p-2 text-center rounded d-flex align-items-center justify-content-center">
                    <i class="fas fa-lock mr-2"></i> Chapa
                  </div>
                </label>
              </div>
           
              <div class="col-6 p-1">
                <label class="w-100 m-0">
                  <input type="radio" value="3" name="opcion" class="card-radio-input">
                  <div class="card-radio-btn p-2 text-center rounded d-flex align-items-center justify-content-center">
                    <i class="fas fa-redo mr-2"></i> Reset
                  </div>
                </label>
              </div>
           
              <div class="col-6 p-1">
                <label class="w-100 m-0">
                  <input type="radio" value="4" name="opcion" class="card-radio-input">
                  <div class="card-radio-btn p-2 text-center rounded d-flex align-items-center justify-content-center">
                    <i class="fas fa-key mr-2"></i> Apertura Chapa
                  </div>
                </label>
              </div>

            </div>

            <!-- Pantalla de Resultado Código Salida -->
            <div class="mt-4 p-3 rounded text-center position-relative overflow-hidden" style="background: rgba(10, 15, 29, 0.9); border: 1px dashed rgba(0, 242, 254, 0.4);">
              <span class="text-muted small font-weight-bold d-block text-uppercase mb-1" style="letter-spacing: 1px;">Respuesta del Módulo</span>
              <h2 class="m-0 font-weight-bold" style="color: #00f2fe; text-shadow: 0 0 10px rgba(0, 242, 254, 0.5); font-size: 2rem;">
                <div id="codsal">-----</div>
              </h2>
            </div>
          </div>

          <!-- Columna Derecha: Google Maps (MÁS GRANDE) -->
          <div class="col-md-7 d-flex flex-column">
            <!-- Título del equipo encima del mapa -->
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-white-50 small font-weight-bold text-uppercase">
                <i class="fas fa-map-marker-alt text-danger mr-1"></i> Última Posición GPS
              </span>
              <span id="equipo_info_titulo" class="text-white font-weight-bold" style="font-size: 0.9rem;">
                <i class="fas fa-vault mr-1" style="color: var(--accent-cyan);"></i> Cargando...
              </span>
            </div>
            
            <!-- Mapa más grande -->
            <div id="googleMap" class="rounded shadow-sm" style="min-height: 350px; width: 100%; border: 1px solid rgba(0, 242, 254, 0.3);"></div>
            
            <!-- Estado de Cerradura (Neón) -->
            <div class="mt-2 text-center" style="font-size: 0.9rem;">
              <i class="fas fa-lock text-muted mr-1"></i> 
              <span class="text-white-50 small font-weight-bold text-uppercase">Cerradura:</span>
              <span id="cerradura_estado" class="ml-1 font-weight-bold" style="font-size: 1rem; text-shadow: 0 0 15px currentColor;">
                <i class="fas fa-spinner fa-spin"></i> Cargando...
              </span>
            </div>
          </div>

        </div>
      </div>

      <!-- Footer / Botón Acción -->
      <div class="modal-footer border-0 pt-0" style="background: transparent;">
        <button data-id="0" data-mac="" id="btn_generar_codigo" onclick="GenerarCodigo(this);" class="btn btn-action btn-block bgenerar py-2 font-weight-bold" data-id_operador="{{GetId();}}" style="font-size: 1rem; border-radius: 8px;">
          <i class="fas fa-sync-alt mr-2"></i> Generar
      </button>
      </div>
    
    </div>
  </div>
</div>

<!-- Modal de Confirmación para Eliminar Equipo -->
<div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color: var(--bg-card); border: 1px solid rgba(239, 68, 68, 0.4); box-shadow: 0 0 20px rgba(239, 68, 68, 0.2);">
      <div class="modal-header border-0" style="background-color: rgba(239, 68, 68, 0.08);">
        <h5 class="modal-title text-white font-weight-bold" id="modalEliminarLabel">
          <i class="fas fa-exclamation-triangle mr-2" style="color: var(--accent-red);"></i> Confirmar Eliminación
        </h5>
        <button type="button" class="close text-white-50" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-light py-4">
        <p class="mb-2">¿Estás seguro de que deseas eliminar el equipo <b id="nombre_equipo_eliminar" class="text-white"></b>?</p>
        <p class="text-muted small mb-0">Esta acción no se puede deshacer.</p>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancelar</button>
        <form id="formEliminarEquipo" action="" method="post" class="d-inline">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-sm" style="background-color: var(--accent-red); color: #fff; font-weight: 600;">Quitar Equipo</button>
        </form>
      </div>
    </div>
  </div>
</div>

@include('administradores.footer')

<script>
  var googleMapInstance = null;
  var googleMarkerInstance = null;

  // Coordenadas de la República Mexicana (centro)
  var MEXICO_CENTER = { lat: 23.6345, lng: -102.5528 };

  function ObtenerUltimoEstadoEquipo(id, numeconomico, macEquipo) {
    var url = Url() + 'api/ObtenerUltimoEstadoEquipo/' + macEquipo;

    // Resetear estado de cerradura
    $('#cerradura_estado').html('<i class="fas fa-spinner fa-spin"></i> Cargando...').css('color', '#6c757d');
    $('#equipo_info_titulo').html('<i class="fas fa-vault mr-1" style="color: var(--accent-cyan);"></i> ' + numeconomico + ' - Cargando...');

    // Limpiar marcador anterior
    if (googleMarkerInstance) {
        googleMarkerInstance.setMap(null);
        googleMarkerInstance = null;
    }

    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        console.log('Datos recibidos:', data);
        
        // Verificar si hay datos de ubicación
        var tieneUbicacion = data && data.latitud && data.longitud && data.latitud != 0 && data.longitud != 0;
        
        // Estado de la chapa
        var cerrado = data.cerrado;
        var estadoTexto = '';
        var estadoColor = '';
        
        // ============================================
        // ACTUALIZAR ESTADO DE CERRADURA (NEÓN)
        // ============================================
        if (data && typeof data.cerrado !== 'undefined') {
            if (data.cerrado == 1) {
                estadoTexto = 'Cerrado';
                estadoColor = '#ef4444';
                $('#cerradura_estado')
                    .html('<i class="fas fa-lock"></i> Cerrado')
                    .css('color', '#ef4444')
                    .css('text-shadow', '0 0 20px rgba(239, 68, 68, 0.8), 0 0 40px rgba(239, 68, 68, 0.4)');
            } else if (data.cerrado == 0) {
                estadoTexto = 'Abierto';
                estadoColor = '#10b981';
                $('#cerradura_estado')
                    .html('<i class="fas fa-lock-open"></i> Abierto')
                    .css('color', '#10b981')
                    .css('text-shadow', '0 0 20px rgba(16, 185, 129, 0.8), 0 0 40px rgba(16, 185, 129, 0.4)');
            }
        } else {
            estadoTexto = 'Sin estado';
            estadoColor = '#6c757d';
            $('#cerradura_estado')
                .html('<i class="fas fa-question-circle"></i> Sin estado')
                .css('color', '#6c757d')
                .css('text-shadow', 'none');
        }
        
        // Actualizar título del equipo con estado
        $('#equipo_info_titulo').html(
            '<i class="fas fa-vault mr-1" style="color: ' + estadoColor + ';"></i> ' + 
            numeconomico 
        );
        
        var lat = tieneUbicacion ? parseFloat(data.latitud) : MEXICO_CENTER.lat;
        var lng = tieneUbicacion ? parseFloat(data.longitud) : MEXICO_CENTER.lng;

        // ============================================
        // INICIALIZAR / ACTUALIZAR MAPA Y MARCADOR
        // ============================================
        var myLatlng = { lat: lat, lng: lng };
        var mapDiv = document.getElementById('googleMap');
        
        // --- FUNCIÓN PARA CREAR ÍCONO PERSONALIZADO ---
        function crearIconoCajaFuerte(abierta) {
            var color = abierta ? '#10b981' : '#ef4444';
            // SVG más simple y compatible
            return {
                path: 'M 12 2 C 8 2 4 4 4 8 L 4 16 C 4 18 6 20 8 20 L 16 20 C 18 20 20 18 20 16 L 20 8 C 20 4 16 2 12 2 Z M 8 6 L 16 6 C 18 6 18 8 18 8 L 6 8 C 6 8 6 6 8 6 Z M 12 10 C 13.1 10 14 10.9 14 12 C 14 13.1 13.1 14 12 14 C 10.9 14 10 13.1 10 12 C 10 10.9 10.9 10 12 10 Z M 6 10 L 18 10 L 18 16 C 18 17.1 17.1 18 16 18 L 8 18 C 6.9 18 6 17.1 6 16 L 6 10 Z',
                fillColor: color,
                fillOpacity: 1,
                strokeColor: '#ffffff',
                strokeWeight: 2,
                scale: 1.8,
                anchor: new google.maps.Point(12, 12)
            };
        }

        // --- VERIFICAR SI EL MAPA YA EXISTE ---
        if (!googleMapInstance) {
            // Crear mapa por primera vez
            googleMapInstance = new google.maps.Map(mapDiv, {
                zoom: tieneUbicacion ? 16 : 6,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: [
                    { elementType: "geometry", stylers: [{ color: "#1d2c4d" }] },
                    { elementType: "labels.text.fill", stylers: [{ color: "#8ec3b9" }] },
                    { elementType: "labels.text.stroke", stylers: [{ color: "#1a3646" }] },
                    { featureType: "administrative.country", elementType: "geometry.stroke", stylers: [{ color: "#4b6878" }] },
                    { featureType: "poi", elementType: "geometry", stylers: [{ color: "#283955" }] },
                    { featureType: "road", elementType: "geometry", stylers: [{ color: "#304a7d" }] },
                    { featureType: "water", elementType: "geometry", stylers: [{ color: "#0e1626" }] }
                ]
            });

            // Crear marcador si hay ubicación
            if (tieneUbicacion) {
                var icono = crearIconoCajaFuerte(cerrado == 0);
                googleMarkerInstance = new google.maps.Marker({
                    position: myLatlng,
                    map: googleMapInstance,
                    icon: icono,
                    title: numeconomico + ' - ' + estadoTexto,
                    animation: google.maps.Animation.DROP
                });
                
                // Agregar label por separado para mejor compatibilidad
                var label = new google.maps.Marker({
                    position: myLatlng,
                    map: googleMapInstance,
                    label: {
                        text: numeconomico,
                        color: '#ffffff',
                        fontSize: '11px',
                        fontWeight: 'bold'
                    },
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 0
                    }
                });
                // Guardar referencia al label
                googleMarkerInstance._label = label;
            }
        } else {
            // Actualizar mapa existente
            googleMapInstance.setCenter(myLatlng);
            googleMapInstance.setZoom(tieneUbicacion ? 16 : 6);
            
            if (tieneUbicacion) {
                var icono = crearIconoCajaFuerte(cerrado == 0);
                    
                if (!googleMarkerInstance) {
                    // Crear nuevo marcador
                    googleMarkerInstance = new google.maps.Marker({
                        position: myLatlng,
                        map: googleMapInstance,
                        icon: icono,
                        title: numeconomico + ' - ' + estadoTexto,
                        animation: google.maps.Animation.DROP
                    });
                    
                    var label = new google.maps.Marker({
                        position: myLatlng,
                        map: googleMapInstance,
                        label: {
                            text: numeconomico,
                            color: '#ffffff',
                            fontSize: '11px',
                            fontWeight: 'bold'
                        },
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 0
                        }
                    });
                    googleMarkerInstance._label = label;
                } else {
                    // Actualizar marcador existente
                    googleMarkerInstance.setPosition(myLatlng);
                    googleMarkerInstance.setTitle(numeconomico + ' - ' + estadoTexto);
                    googleMarkerInstance.setIcon(icono);
                    googleMarkerInstance.setMap(googleMapInstance);
                    
                    // Actualizar label
                    if (googleMarkerInstance._label) {
                        googleMarkerInstance._label.setPosition(myLatlng);
                        googleMarkerInstance._label.setMap(googleMapInstance);
                        googleMarkerInstance._label.setLabel({
                            text: numeconomico,
                            color: '#ffffff',
                            fontSize: '11px',
                            fontWeight: 'bold'
                        });
                    }
                }
            } else {
                // No hay ubicación, eliminar marcador
                if (googleMarkerInstance) {
                    if (googleMarkerInstance._label) {
                        googleMarkerInstance._label.setMap(null);
                    }
                    googleMarkerInstance.setMap(null);
                    googleMarkerInstance = null;
                }
            }
        }
        
        // Forzar resize y centrado del mapa
        setTimeout(function() {
            if (googleMapInstance) {
                google.maps.event.trigger(googleMapInstance, 'resize');
                googleMapInstance.setCenter(myLatlng);
                if (tieneUbicacion) {
                    googleMapInstance.setZoom(16);
                }
            }
        }, 300);
      },
      error: function(error) {
        console.error('Error:', error);
        $('#cerradura_estado')
            .html('<i class="fas fa-exclamation-triangle"></i> Error')
            .css('color', '#ef4444');
        $('#equipo_info_titulo').html('<i class="fas fa-vault mr-1" style="color: #ef4444;"></i> ' + numeconomico + ' - Error');

        // Centrar en México sin marcador
        var myLatlng = MEXICO_CENTER;
        var mapDiv = document.getElementById('googleMap');
        
        if (!googleMapInstance) {
            googleMapInstance = new google.maps.Map(mapDiv, {
                zoom: 6,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: [
                    { elementType: "geometry", stylers: [{ color: "#1d2c4d" }] },
                    { elementType: "labels.text.fill", stylers: [{ color: "#8ec3b9" }] },
                    { elementType: "labels.text.stroke", stylers: [{ color: "#1a3646" }] },
                    { featureType: "administrative.country", elementType: "geometry.stroke", stylers: [{ color: "#4b6878" }] },
                    { featureType: "poi", elementType: "geometry", stylers: [{ color: "#283955" }] },
                    { featureType: "road", elementType: "geometry", stylers: [{ color: "#304a7d" }] },
                    { featureType: "water", elementType: "geometry", stylers: [{ color: "#0e1626" }] }
                ]
            });
            googleMarkerInstance = null;
        } else {
            googleMapInstance.setCenter(myLatlng);
            googleMapInstance.setZoom(6);
            if (googleMarkerInstance) {
                if (googleMarkerInstance._label) {
                    googleMarkerInstance._label.setMap(null);
                }
                googleMarkerInstance.setMap(null);
                googleMarkerInstance = null;
            }
        }
        
        setTimeout(function() {
            if (googleMapInstance) {
                google.maps.event.trigger(googleMapInstance, 'resize');
                googleMapInstance.setCenter(myLatlng);
            }
        }, 300);
      }
    });
  }

  function AbrirModalEditar(id, numeconomico, matricula, mac) {
    $('#edit_numeconomico').val(numeconomico);
    $('#edit_matricula').val(matricula);
    $('#edit_mac').val(mac);
    $('#formEditarEquipo').attr('action', Url() + 'equipos/' + id);
    $('#modalEditarEquipo').modal('show');
  }

  function ConfirmarEliminarEquipo(id, numeconomico) {
    $('#nombre_equipo_eliminar').text(numeconomico);
    $('#formEliminarEquipo').attr('action', Url() + 'equipos/' + id);
    $('#modalConfirmarEliminar').modal('show');
  }

  function inicializarAplicacion() {
    console.log('Google Maps API cargada correctamente');
    // Aquí puedes inicializar cosas si es necesario
  }

</script>

<!-- ============================================ -->
<!-- FIREBASE REALTIME - LECTURA EN TIEMPO REAL   -->
<!-- ============================================ -->
<script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-database.js"></script>

<script>
$(document).ready(function() {
    console.log('🚀 Iniciando Firebase...');

    // Configuración de Firebase
    const firebaseConfig = {
        apiKey: "AIzaSyDz7FUkBtpZt9PBYoLXrxyOizg7BDVOmr4",
        authDomain: "oii-on.firebaseapp.com",
        projectId: "oii-on",
        storageBucket: "oii-on.firebasestorage.app",
        messagingSenderId: "574205217743",
        appId: "1:574205217743:web:259fe9d810e921d08760ba",
        measurementId: "G-D2Y68ZNJ9D"
    };

    // Inicializar Firebase
    if (typeof firebase !== 'undefined' && !firebase.apps.length) {
        firebase.initializeApp(firebaseConfig);
        console.log('✅ Firebase inicializado correctamente');
    } else {
        console.warn('⚠️ Firebase ya estaba inicializado o no está disponible');
    }

    const database = firebase.database();

    // IDs de equipos desde la vista
    const equiposIds = [];
    @foreach($equipos as $equipo)
        equiposIds.push('{{ $equipo->id }}');
    @endforeach

    console.log(`📋 Escuchando ${equiposIds.length} equipos:`, equiposIds);

    // Escuchar cambios por cada equipo
    equiposIds.forEach(function(equipoId, index) {
        const ref = database.ref('estados/' + equipoId);
        
        ref.on('value', function(snapshot) {
            const data = snapshot.val();
            
            if (data) {
                console.log(`🔔 CAMBIO RECIBIDO para equipo: ${equipoId}`);
                console.log(`📦 Datos:`, data);
                
                // Actualizar la UI
                actualizarEstadoEquipo(equipoId, data);
            }
        }, function(error) {
            console.error(`❌ Error escuchando /estados/${equipoId}:`, error);
        });
    });

    // ============================================
    // FUNCIÓN PARA ACTUALIZAR SOLO EL ESTADO
    // ============================================
    function actualizarEstadoEquipo(equipoId, data) {
        const $tarjeta = $(`[data-equipo-id="${equipoId}"]`);
        if ($tarjeta.length === 0) {
            console.warn(`⚠️ Tarjeta no encontrada para ${equipoId}`);
            return;
        }

        // Badge de chapa (el primero)
        const $badge = $tarjeta.find('.status-badge:first');
        const $texto = $badge.find('.badge-text');
        const $icono = $badge.find('.fa-lock, .fa-lock-open, .fa-question-circle');

        // Quitar todas las clases de estado
        $badge.removeClass('abierto cerrado sin-estado');

        if (data.cerrado === 0) {
            // Abierto - solo agrega la clase
            $badge.addClass('abierto');
            $texto.text('Abierto');
            $icono.attr('class', 'fas fa-lock-open ml-1');
            
        } else if (data.cerrado === 1) {
            // Cerrado - solo agrega la clase
            $badge.addClass('cerrado');
            $texto.text('Cerrado');
            $icono.attr('class', 'fas fa-lock ml-1');
        }

        // Si el modal está abierto, actualizar también
        if ($('#modalcodegen').hasClass('show')) {
            const $estado = $('#cerradura_estado');
            if (data.cerrado === 0) {
                $estado.html('<i class="fas fa-lock-open"></i> Abierto')
                    .css('color', '#10b981')
                    .css('text-shadow', '0 0 20px rgba(16, 185, 129, 0.8), 0 0 40px rgba(16, 185, 129, 0.4)');
            } else if (data.cerrado === 1) {
                $estado.html('<i class="fas fa-lock"></i> Cerrado')
                    .css('color', '#ef4444')
                    .css('text-shadow', '0 0 20px rgba(239, 68, 68, 0.8), 0 0 40px rgba(239, 68, 68, 0.4)');
            }
        }
    }

    console.log('✅ Firebase escuchando cambios en tiempo real');
});
</script>

</body>
</html>