<!DOCTYPE html>
<html lang="es">
<head>
  @include('header')
  <title>{{ getSiteTitle(' Gestión y Soporte de Equipos') }}</title>
  
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=drawing&callback=inicializarAplicacion" async defer></script>

  <style>
    .mapa-equipo-label {
      color: #ffffff !important;
      font-size: 11px !important;
      font-weight: bold !important;
      text-shadow:
        0 0 3px #000,
        0 0 6px #000,
        0 0 8px #000,
        1px 1px 2px #000 !important;
      padding: 2px 6px !important;
      white-space: nowrap !important;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="background-color: var(--bg-main);">
@include('toast.toasts')  
<div class="wrapper">

  @include('administradores.navbar')
  @include('administradores.sidebar')

  <div class="content-wrapper" style="background-color: var(--bg-main);">
    
    <div class="content-header">
      <div class="container-fluid d-flex align-items-center justify-content-between">
        <h1 class="m-0 text-white font-weight-bold" style="font-size: 1.5rem;">
          <i class="fas fa-microchip mr-2" style="color: var(--accent-cyan);"></i> Gestión Integral de Equipos
        </h1>
        <div class="d-flex" style="gap: 8px;">
          <button type="button" class="btn btn-outline-info btn-sm px-3 shadow-sm" data-toggle="modal" data-target="#modalExportar">
            <i class="fas fa-file-excel mr-1"></i> Descargar Reporte
          </button>
          <button type="button" class="btn btn-action btn-sm px-3 shadow-sm" data-toggle="modal" data-target="#modalRegistrarEquipo">
            <i class="fas fa-plus-circle mr-1"></i> Nuevo Equipo
          </button>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">

        <!-- CARD: MAPA GRANDE -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card card-oiion">
              <div class="card-header border-0 d-flex align-items-center justify-content-between">
                <h3 class="card-title text-white font-weight-bold m-0">
                  <i class="fas fa-map-marked-alt mr-2" style="color: var(--accent-cyan);"></i> Última Ubicación de Equipos
                </h3>
                <span class="badge badge-pill" 
                      style="background-color: rgba(34, 197, 94, 0.15); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.4);">
                  <i class="fas fa-map-pin mr-1"></i> {{ $ultimosIngresos->count() }} en mapa
                </span>
              </div>
              <div class="card-body p-3">
                <div id="mapaEquipos" class="rounded shadow-sm" 
                     style="height: 480px; width: 100%; border: 1px solid rgba(0, 242, 254, 0.3);"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- CARD: LISTADO DE EQUIPOS + BUSCADOR -->
        <div class="row">
          <div class="col-12">
            
            <div class="card card-oiion mb-4">
              <div class="card-header border-0">
                <div class="row align-items-center">
                  <div class="col-md-5">
                    <h3 class="card-title text-white font-weight-bold m-0">
                      <i class="fas fa-server mr-2" style="color: var(--accent-cyan);"></i> Listado de Equipos y Cajas Fuertes
                    </h3>
                  </div>
                  <div class="col-md-7">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text" style="background: rgba(10,15,29,0.8); border-color: var(--border-color); color: var(--accent-cyan);">
                          <i class="fas fa-search"></i>
                        </span>
                      </div>
                      <input type="text" 
                             id="buscadorEquipos" 
                             class="form-control" 
                             placeholder="Buscar por nombre de equipo o número económico..." 
                             style="background: rgba(10,15,29,0.8); border-color: var(--border-color); color: #fff;">
                      <div class="input-group-append">
                        <button type="button" class="btn btn-search" onclick="limpiarBuscador()" title="Limpiar">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="card-body">
                <div class="row" id="contenedorTarjetas">
                  @foreach($equipos as $equipo)
                  @php 
                    $estaActivo = (($equipo->activo ?? 1) == 1);
                    $tieneEstado = isset($equipo->evento) && isset($equipo->estado);
                    $evento = $tieneEstado ? $equipo->evento : 'desconocido';
                    $estado = $tieneEstado ? $equipo->estado : 'desconocido';
                    
                    $chapaClase = 'sin-estado';
                    $chapaTexto = 'Sin estado';
                    $chapaIcono = 'fa-question-circle';
                    
                    if ($tieneEstado) {
                        switch ($evento) {
                            case 'apertura':
                                $chapaClase = 'abierto';
                                $chapaTexto = 'Abierto';
                                $chapaIcono = 'fa-lock-open';
                                break;
                            case 'cierre':
                                $chapaClase = 'cerrado';
                                $chapaTexto = 'Cerrado';
                                $chapaIcono = 'fa-lock';
                                break;
                            case 'ingreso':
                                $chapaClase = 'movimiento';
                                $chapaTexto = 'Ingreso';
                                $chapaIcono = 'fa-dollar-sign';
                                break;
                            case 'movimiento':
                                $chapaClase = 'movimiento';
                                $chapaTexto = 'Movimiento';
                                $chapaIcono = 'fa-arrows-alt';
                                break;
                            default:
                                $chapaClase = 'sin-estado';
                                $chapaTexto = 'Sin estado';
                                $chapaIcono = 'fa-question-circle';
                                break;
                        }
                    }

                    $nombreEquipo = $equipo->equipo ?: $equipo->numeconomico;
                  @endphp
                  
                  <div class="col-xl-4 col-lg-4 col-md-6 mb-4 tarjeta-equipo" 
                       data-search="{{ strtolower($nombreEquipo . ' ' . $equipo->numeconomico) }}">           
                    <div class="card card-oiion h-100" 
                         data-equipo-id="{{ $equipo->id }}"
                         style="border: 1px solid {{ $estaActivo ? 'var(--border-color)' : 'rgba(239, 68, 68, 0.4)' }}; background-color: rgba(21, 28, 47, 0.6);">
                      <div class="card-body d-flex flex-column justify-content-between p-3">
                        
                        <div>
                          <div class="d-flex justify-content-between align-items-center w-100 mb-2">
                            <h4 class="card-title text-white font-weight-bold m-0" style="font-size: 1.1rem;">
                              <i class="fas fa-vault mr-1" style="color: var(--accent-cyan);"></i> {{ $nombreEquipo }}
                            </h4> 
                            
                            <div class="card-tools">
                              <div class="btn-group dropleft">
                                <button class="btn btn-sm text-white-50 border-0" type="button" id="menu_{{$equipo->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: transparent;">
                                  <i class="fas fa-ellipsis-v text-white"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" style="background-color: var(--bg-card); border-color: var(--border-color);">
                                  <a class="dropdown-item text-light" id="btn_toggle_{{$equipo->id}}" href="javascript:void(0)" onclick="ToggleEquipoStatus('{{$equipo->id}}', this)">
                                    @if($estaActivo)
                                      <i class="fas fa-power-off mr-2 text-warning"></i> Desactivar Equipo
                                    @else
                                      <i class="fas fa-check-circle mr-2 text-success"></i> Activar Equipo
                                    @endif
                                  </a>
                                  <div class="dropdown-divider" style="border-color: var(--border-color);"></div>
                                  <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="ConfirmarEliminarEquipo('{{$equipo->id}}', '{{$nombreEquipo}}')">
                                    <i class="fas fa-trash-alt mr-2"></i> Quitar Equipo
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="status-badge {{ $chapaClase }}">
                              <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                              <i class="fas {{ $chapaIcono }} ml-1" style="font-size: 0.7rem;"></i>
                              <span class="badge-text">{{ $chapaTexto }}</span>
                            </span>

                            <span id="badge_estado_{{$equipo->id}}" class="status-badge {{ $estaActivo ? 'online' : 'offline' }}">
                              <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                              <span class="badge-text">{{ $estaActivo ? 'Activo' : 'Inactivo' }}</span>
                            </span>
                          </div>
                          
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
                        
                        <div class="d-flex" style="gap: 8px;">
                          <button type="button" class="btn btn-outline-info btn-sm flex-fill" onclick="AbrirModalEditar('{{$equipo->id}}', '{{$equipo->numeconomico}}', '{{$equipo->equipo}}', '{{$equipo->matricula}}', '{{$equipo->mac}}')">
                            <i class="fas fa-edit mr-1"></i> Editar
                          </button>

                          <button type="button" class="btn btn-action btn-sm flex-fill" onclick="PreCodigo('{{$equipo->id}}','{{$equipo->numeconomico}}','{{$equipo->mac}}'); ObtenerUltimoEstadoEquipo('{{$equipo->id}}','{{$equipo->numeconomico}}','{{$equipo->mac}}');" data-toggle="modal" data-target="#modalcodegen">
                              <i class="fas fa-key mr-1"></i> Soporte
                          </button>
                        </div>

                      </div>  
                    </div>
                  </div>
                  @endforeach
                </div>

                <div id="sinResultados" class="text-center text-muted py-4" style="display: none;">
                  <i class="fas fa-search fa-2x mb-2 d-block" style="opacity: 0.4;"></i>
                  No se encontraron equipos que coincidan con la búsqueda.
                </div>

              </div>
            </div>

          </div>
        </div>

      </div>
    </section>
  </div>

  @include('footer')
</div>

<!-- ================= MODALES ================= -->

<!-- Modal Exportar Reporte -->
<div class="modal fade" id="modalExportar" tabindex="-1" role="dialog" aria-labelledby="modalExportarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content" style="background-color: var(--bg-card); border: 1px solid var(--border-color); box-shadow: 0 0 25px rgba(0, 242, 254, 0.15);">
      
      <div class="modal-header border-0">
        <h5 class="modal-title text-white font-weight-bold" id="modalExportarLabel">
          <i class="fas fa-file-excel mr-2" style="color: var(--accent-cyan);"></i> Descargar Reporte de Ingresos
        </h5>
        <button type="button" class="close text-white-50" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="formExportar" action="" method="GET">
        <div class="modal-body">
          
          <!-- Rango de fechas -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="text-muted small font-weight-bold text-uppercase">
                  <i class="fas fa-calendar-alt mr-1" style="color: var(--accent-cyan);"></i> Fecha inicio
                </label>
                <input type="date" 
                       required
                       id="export_fecha_inicio" 
                       name="fecha_inicio" 
                       class="form-control form-control-oiion"
                       style="background: rgba(10,15,29,0.8); border-color: var(--border-color); color: #fff;">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="text-muted small font-weight-bold text-uppercase">
                  <i class="fas fa-calendar-check mr-1" style="color: var(--accent-cyan);"></i> Fecha fin
                </label>
                <input type="date" 
                       required
                       id="export_fecha_fin" 
                       name="fecha_fin" 
                       class="form-control form-control-oiion"
                       style="background: rgba(10,15,29,0.8); border-color: var(--border-color); color: #fff;">
              </div>
            </div>
          </div>

          <!-- Selección de equipos -->
          <div class="form-group mt-2">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <label class="text-muted small font-weight-bold text-uppercase mb-0">
                <i class="fas fa-server mr-1" style="color: var(--accent-cyan);"></i> Equipos
              </label>
              <span class="badge badge-pill" 
                    style="background-color: rgba(6, 182, 212, 0.15); color: var(--accent-cyan); border: 1px solid rgba(6, 182, 212, 0.4);">
                <span id="export_contador_seleccionados">0</span> seleccionados
              </span>
            </div>

            <div class="p-2 rounded" 
                 style="background: rgba(10,15,29,0.8); border: 1px solid var(--border-color); max-height: 260px; overflow-y: auto;">
              
              <!-- Todos -->
              <div class="custom-control custom-checkbox mb-2 pb-2" 
                   style="border-bottom: 1px solid var(--border-color);">
                <input type="checkbox" 
                       class="custom-control-input" 
                       id="export_todos" 
                       checked>
                <label class="custom-control-label text-white font-weight-bold" for="export_todos">
                  <i class="fas fa-layer-group mr-1" style="color: var(--accent-cyan);"></i> Todos los equipos
                </label>
              </div>

              <!-- Lista de equipos -->
              @foreach($equipos as $equipo)
                @php
                  $nombreEquipoChk = $equipo->equipo ?: $equipo->numeconomico;
                @endphp
                <div class="custom-control custom-checkbox mb-1">
                  <input type="checkbox" 
                         class="custom-control-input export-equipo-check" 
                         id="export_equipo_{{ $equipo->id }}" 
                         name="equipos[]" 
                         value="{{ $equipo->mac }}">
                  <label class="custom-control-label text-white-50" for="export_equipo_{{ $equipo->id }}" style="cursor: pointer;">
                    <span class="text-white">{{ $nombreEquipoChk }}</span>
                    <small class="text-muted ml-1">({{ $equipo->mac }})</small>
                  </label>
                </div>
              @endforeach

            </div>
          </div>

          <!-- Aviso informativo -->
          <div class="d-flex align-items-start p-2 rounded mt-3" 
               style="background-color: rgba(6, 182, 212, 0.08); border: 1px solid rgba(6, 182, 212, 0.3);">
            <i class="fas fa-info-circle mr-2 mt-1" style="color: var(--accent-cyan);"></i>
            <span class="text-white-50" style="font-size: 0.78rem; line-height: 1.4;">
              El reporte incluye <b class="text-white">todos los ingresos</b> en el rango de fechas, 
              con o sin coordenadas. Si no seleccionas ningún equipo, se exportará la flotilla completa.
            </span>
          </div>

        </div>

        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-action btn-sm">
            <i class="fas fa-download mr-1"></i> Descargar Excel
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Modal Registrar -->
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
            <label class="text-muted">Nombre de Equipo</label>
            <input required type="text" class="form-control form-control-oiion" name="equipo" placeholder="Ej. Caja Principal">
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

<!-- Modal Editar -->
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
            <label class="text-muted">Nombre de Equipo</label>
            <input required type="text" class="form-control form-control-oiion" id="edit_equipo" name="equipo">
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

<!-- Modal Soporte -->
<div class="modal fade" id="modalcodegen" tabindex="-1" role="dialog" aria-labelledby="modalCodeGenTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content" style="background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(12px); border: 1px solid rgba(0, 242, 254, 0.3); box-shadow: 0 0 25px rgba(0, 242, 254, 0.15); border-radius: 12px;">
      
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

      <div class="modal-body py-4">
        @csrf                        
        <div class="row">
  
          <div class="col-md-5">
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

            <label class="text-white-50 small font-weight-bold text-uppercase mb-2">Acción a Ejecutar</label>
            <div class="row custom-oiion-radios px-2">  
              
             <div class="col-6 p-1">
                <label class="w-100 m-0">
                  <input type="radio" value="5" name="opcion" class="card-radio-input" checked>
                  <div class="card-radio-btn p-2 text-center rounded d-flex align-items-center justify-content-center">
                    <i class="fas fa-key mr-2"></i> Apertura Chapa
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

            </div>

            <div class="mt-4">
              
              <div class="p-3 rounded text-center position-relative overflow-hidden" style="background: rgba(10, 15, 29, 0.9); border: 1px dashed rgba(0, 242, 254, 0.4);">
                <span class="text-muted small font-weight-bold d-block text-uppercase mb-1" style="letter-spacing: 1px;">Respuesta del Módulo</span>
                <h2 class="m-0 font-weight-bold" style="color: #00f2fe; text-shadow: 0 0 10px rgba(0, 242, 254, 0.5); font-size: 2rem;">
                  <div id="codsal">-----</div>
                </h2>
              </div>

              <div class="d-flex justify-content-end mt-3">
                <button data-id="0" data-mac="" id="btn_generar_codigo" onclick="GenerarCodigo(this);" class="btn btn-action bgenerar py-2 font-weight-bold" data-id_operador="{{GetId();}}" style="font-size: 1rem; border-radius: 8px; min-width: 150px;">
                  <i class="fas fa-sync-alt mr-2"></i> Generar
                </button>
              </div>

            </div>

          </div>

          <div class="col-md-7 d-flex flex-column">
            
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-white-50 small font-weight-bold text-uppercase">
                <i class="fas fa-map-marker-alt text-danger mr-1"></i> Ingresos por fecha
              </span>
              <div class="d-flex align-items-center" style="gap: 8px;">
                <input type="date" 
                       id="filtro_fecha_ingresos" 
                       class="form-control form-control-sm"
                       style="background: rgba(10, 15, 29, 0.8); border: 1px solid rgba(0, 242, 254, 0.3); color: #fff; width: 160px;">
                <button type="button" 
                        class="btn btn-sm btn-action"
                        onclick="CargarIngresosPorFecha()">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-2">
              <span id="equipo_info_titulo" class="text-white font-weight-bold" style="font-size: 0.9rem;">
                <i class="fas fa-vault mr-1" style="color: var(--accent-cyan);"></i> Cargando...
              </span>
              <span id="total_ingresos_dia" class="badge badge-pill" 
                    style="background-color: rgba(34, 197, 94, 0.15); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.4);">
                <i class="fas fa-dollar-sign mr-1"></i> 0
              </span>
            </div>

            <div id="aviso_sin_coords" class="mb-2" style="display: none;">
              <div class="d-flex align-items-start p-2 rounded" 
                   style="background-color: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.4);">
                <i class="fas fa-exclamation-triangle mr-2 mt-1" style="color: #f59e0b;"></i>
                <span class="text-white-50" style="font-size: 0.78rem; line-height: 1.3;">
                  <b id="aviso_con_coords" style="color:#22c55e;">0</b> ingresos con ubicación en el mapa.
                  <b id="aviso_sin_coords_num" style="color:#f59e0b;">0</b> ingresos sin coordenadas no se reflejan en el mapa.
                </span>
              </div>
            </div>
            
            <div id="googleMap" class="rounded shadow-sm" style="min-height: 350px; width: 100%; border: 1px solid rgba(0, 242, 254, 0.3);"></div>
            
            <div class="mt-2 text-center" style="font-size: 0.9rem; display: none;">
              <i class="fas fa-lock text-muted mr-1"></i> 
              <span class="text-white-50 small font-weight-bold text-uppercase">Cerradura:</span>
              <span id="cerradura_estado" class="ml-1 font-weight-bold" style="font-size: 1rem; text-shadow: 0 0 15px currentColor;">
                <i class="fas fa-spinner fa-spin"></i> Cargando...
              </span>
            </div>
          </div>

        </div>
      </div>
      
      <div class="modal-footer border-0 pt-0" style="background: transparent; display: none;"></div>
    
    </div>
  </div>
</div>

<!-- Modal Eliminar -->
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

<!-- ============================================================ -->
<!-- DATOS PARA EL MAPA                                            -->
<!-- ============================================================ -->
<script>
  var ULTIMOS_INGRESOS = {!! json_encode($ultimosIngresos) !!};
  var EQUIPOS_DATA = {!! json_encode($equipos->map(function($e) {
      return [
          'mac' => $e->mac,
          'equipo' => $e->equipo ?: $e->numeconomico,
          'numeconomico' => $e->numeconomico,
          'matricula' => $e->matricula,
          'activo' => $e->activo ?? 1,
      ];
  })->values()) !!};
</script>

<!-- ============================================================ -->
<!-- LÓGICA DEL MAPA Y MODAL                                       -->
<!-- ============================================================ -->
<script>
  var googleMapInstance = null;
  var googleMarkers = [];
  var macActualModal = null;
  var numEconomicoActual = null;

  var MEXICO_CENTER = { lat: 23.6345, lng: -102.5528 };

  function inicializarAplicacion() {
    console.log('Google Maps API cargada correctamente');
    inicializarMapaEquipos();
  }

  // ============================================================
  // MAPA GRANDE — Último ingreso por MAC
  // ============================================================
  function inicializarMapaEquipos() {
    var mapDiv = document.getElementById('mapaEquipos');
    if (!mapDiv) {
      console.warn('No se encontró #mapaEquipos');
      return;
    }

    var mapa = new google.maps.Map(mapDiv, {
      zoom: 6,
      center: MEXICO_CENTER,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      streetViewControl: false,
      fullscreenControl: true,
      zoomControl: true
    });

    if (!ULTIMOS_INGRESOS || ULTIMOS_INGRESOS.length === 0) {
      mapa.setCenter(MEXICO_CENTER);
      mapa.setZoom(6);
      return;
    }

    var equiposPorMac = {};
    EQUIPOS_DATA.forEach(function(e) {
      equiposPorMac[e.mac] = e;
    });

    var bounds = new google.maps.LatLngBounds();
    var infoWindow = new google.maps.InfoWindow();

    ULTIMOS_INGRESOS.forEach(function(ing) {
      var lat = parseFloat(ing.latitud);
      var lng = parseFloat(ing.longitud);

      if (isNaN(lat) || isNaN(lng) || lat === 0 || lng === 0) return;

      var info = equiposPorMac[ing.mac] || {};
      var labelNombre = info.equipo || info.numeconomico || ing.mac;

      var pos = { lat: lat, lng: lng };
      bounds.extend(pos);

      var marker = new google.maps.Marker({
        position: pos,
        map: mapa,
        label: {
          text: String(labelNombre),
          color: '#ffffff',
          fontSize: '11px',
          fontWeight: 'bold',
          className: 'mapa-equipo-label'
        },
        icon: {
          url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(
            '<svg xmlns="http://www.w3.org/2000/svg" width="120" height="80" viewBox="0 0 120 80">' +
              '<circle cx="60" cy="60" r="18" fill="#22c55e" stroke="#ffffff" stroke-width="2"/>' +
              '<text x="60" y="67" font-size="20" font-weight="bold" text-anchor="middle" fill="#ffffff" font-family="Arial">$</text>' +
            '</svg>'
          ),
          scaledSize: new google.maps.Size(120, 80),
          anchor: new google.maps.Point(60, 60)
        },
        animation: google.maps.Animation.DROP
      });

      marker.addListener('click', function() {
        var contenido = '<div style="color:#000; font-size:13px; min-width:180px;">' +
                        '<b>' + (info.equipo || info.numeconomico || 'Equipo') + '</b><br>' +
                        '<span style="color:#666;">Núm. económico: ' + (info.numeconomico || '-') + '</span><br>' +
                        '<span style="color:#666;">Matrícula: ' + (info.matricula || '-') + '</span><br>' +
                        '<span style="color:#666;">MAC: ' + (ing.mac || '-') + '</span><br>' +
                        '<span style="color:#22c55e; font-weight:bold;">Último ingreso: ' + (ing.datetime || '-') + '</span>' +
                        '</div>';
        infoWindow.setContent(contenido);
        infoWindow.open(mapa, marker);
      });

      googleMarkers.push(marker);
    });

    if (googleMarkers.length > 1) {
      mapa.fitBounds(bounds);
    } else if (googleMarkers.length === 1) {
      mapa.setCenter(bounds.getCenter());
      mapa.setZoom(16);
    }

    setTimeout(function() {
      google.maps.event.trigger(mapa, 'resize');
      if (googleMarkers.length > 1) {
        mapa.fitBounds(bounds);
      }
    }, 300);
  }

  // ============================================================
  // BUSCADOR CLIENT-SIDE
  // ============================================================
  function aplicarFiltroTarjetas() {
    var texto = ($('#buscadorEquipos').val() || '').toLowerCase().trim();
    var visibles = 0;

    $('.tarjeta-equipo').each(function() {
      var contenido = ($(this).data('search') || '').toString();
      if (texto === '' || contenido.indexOf(texto) !== -1) {
        $(this).show();
        visibles++;
      } else {
        $(this).hide();
      }
    });

    if (visibles === 0 && texto !== '') {
      $('#sinResultados').show();
    } else {
      $('#sinResultados').hide();
    }
  }

  function limpiarBuscador() {
    $('#buscadorEquipos').val('');
    aplicarFiltroTarjetas();
  }

  $(document).on('input', '#buscadorEquipos', function() {
    aplicarFiltroTarjetas();
  });

  // ============================================================
  // MODAL DE EXPORTAR
  // ============================================================
  function actualizarContadorSeleccionados() {
    var total = $('.export-equipo-check:checked').length;
    $('#export_contador_seleccionados').text(total);
  }

  $(document).on('change', '#export_todos', function() {
    var marcado = $(this).is(':checked');
    $('.export-equipo-check').prop('checked', marcado);
    actualizarContadorSeleccionados();
  });

  $(document).on('change', '.export-equipo-check', function() {
    var totalChecks = $('.export-equipo-check').length;
    var marcados = $('.export-equipo-check:checked').length;
    $('#export_todos').prop('checked', totalChecks === marcados);
    actualizarContadorSeleccionados();
  });

  $(document).on('submit', '#formExportar', function(e) {
    e.preventDefault();

    var fechaInicio = $('#export_fecha_inicio').val();
    var fechaFin = $('#export_fecha_fin').val();

    if (!fechaInicio || !fechaFin) {
      alert('Selecciona ambas fechas.');
      return;
    }

    if (fechaInicio > fechaFin) {
      alert('La fecha de inicio no puede ser mayor que la fecha fin.');
      return;
    }

    var equiposSeleccionados = $('.export-equipo-check:checked').map(function() {
      return $(this).val();
    }).get();

    // Si no hay equipos seleccionados, se exporta toda la flotilla (sin el parámetro equipos[])
    var url = Url() + 'reportes/ingresos?fecha_inicio=' + encodeURIComponent(fechaInicio) +
              '&fecha_fin=' + encodeURIComponent(fechaFin);

    if (equiposSeleccionados.length > 0) {
      url += '&' + equiposSeleccionados.map(function(mac) {
        return 'equipos[]=' + encodeURIComponent(mac);
      }).join('&');
    }

    console.log('Descargando reporte:', url);

    // Descargar como archivo (el backend debe responder con Content-Disposition attachment)
    window.location.href = url;

    $('#modalExportar').modal('hide');
  });

  // Inicializar fechas por defecto al abrir el modal (mes actual)
  $('#modalExportar').on('shown.bs.modal', function() {
    if (!$('#export_fecha_inicio').val()) {
      var hoy = new Date();
      var primerDia = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
      var ultimoDia = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);

      $('#export_fecha_inicio').val(primerDia.toISOString().slice(0, 10));
      $('#export_fecha_fin').val(ultimoDia.toISOString().slice(0, 10));
    }

    actualizarContadorSeleccionados();
  });

  // ============================================================
  // MODAL DE SOPORTE
  // ============================================================
  function ObtenerUltimoEstadoEquipo(id, numeconomico, macEquipo) {
    macActualModal = macEquipo;
    numEconomicoActual = numeconomico;

    $('#equipo_info_titulo').html('<i class="fas fa-vault mr-1" style="color: var(--accent-cyan);"></i> ' + numeconomico + ' - Cargando...');

    var hoy = new Date().toISOString().slice(0, 10);
    $('#filtro_fecha_ingresos').val(hoy);

    CargarIngresosPorFecha();
  }

  function CargarIngresosPorFecha() {
    if (!macActualModal) {
      console.warn('No hay MAC en el modal');
      return;
    }

    var fecha = $('#filtro_fecha_ingresos').val();
    if (!fecha) {
      fecha = new Date().toISOString().slice(0, 10);
      $('#filtro_fecha_ingresos').val(fecha);
    }

    var url = Url() + 'api/ObtenerIngresosPorFecha/' + macActualModal + '/' + fecha;

    $('#total_ingresos_dia').html('<i class="fas fa-spinner fa-spin"></i>');
    $('#aviso_sin_coords').hide();
    LimpiarMarcadores();

    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        console.log('Ingresos recibidos:', data);

        var ingresos = data.ingresos || [];
        var totalReal = (typeof data.total !== 'undefined') ? data.total : ingresos.length;
        var totalConCoords = (typeof data.total_con_coords !== 'undefined') ? data.total_con_coords : ingresos.length;
        var totalSinCoords = (typeof data.total_sin_coords !== 'undefined') ? data.total_sin_coords : (totalReal - totalConCoords);

        $('#total_ingresos_dia').html('<i class="fas fa-dollar-sign mr-1"></i> ' + totalReal);

        if (totalSinCoords > 0) {
          $('#aviso_con_coords').text(totalConCoords);
          $('#aviso_sin_coords_num').text(totalSinCoords);
          $('#aviso_sin_coords').show();
        } else {
          $('#aviso_sin_coords').hide();
        }

        $('#equipo_info_titulo').html(
          '<i class="fas fa-vault mr-1" style="color: var(--accent-cyan);"></i> ' + 
          numEconomicoActual + ' — ' + fecha
        );

        var mapDiv = document.getElementById('googleMap');

        if (!googleMapInstance) {
          googleMapInstance = new google.maps.Map(mapDiv, {
            zoom: 6,
            center: MEXICO_CENTER,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            streetViewControl: false,
            fullscreenControl: true,
            zoomControl: true
          });
        }

        if (ingresos.length === 0) {
          googleMapInstance.setCenter(MEXICO_CENTER);
          googleMapInstance.setZoom(6);
          return;
        }

        var bounds = new google.maps.LatLngBounds();
        var infoWindow = new google.maps.InfoWindow();

        ingresos.forEach(function(ing, i) {
          var lat = parseFloat(ing.latitud);
          var lng = parseFloat(ing.longitud);

          if (isNaN(lat) || isNaN(lng) || lat === 0 || lng === 0) return;

          var pos = { lat: lat, lng: lng };
          bounds.extend(pos);

          var marker = new google.maps.Marker({
            position: pos,
            map: googleMapInstance,
            icon: {
              url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(
                '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">' +
                  '<circle cx="20" cy="20" r="18" fill="#22c55e" stroke="#ffffff" stroke-width="2"/>' +
                  '<text x="20" y="27" font-size="20" font-weight="bold" text-anchor="middle" fill="#ffffff" font-family="Arial">$</text>' +
                '</svg>'
              ),
              scaledSize: new google.maps.Size(40, 40),
              anchor: new google.maps.Point(20, 20)
            },
            title: 'Ingreso #' + (i + 1) + ' — ' + ing.datetime,
            animation: google.maps.Animation.DROP
          });

          marker.addListener('click', function() {
            var contenido = '<div style="color:#000; font-size:13px;">' +
                            '<b>Ingreso #' + (i + 1) + '</b><br>' +
                            'Fecha: ' + ing.datetime + '<br>' +
                            'Estado: ' + (ing.estado || '-') +
                            '</div>';
            infoWindow.setContent(contenido);
            infoWindow.open(googleMapInstance, marker);
          });

          googleMarkers.push(marker);
        });

        if (googleMarkers.length > 1) {
          googleMapInstance.fitBounds(bounds);
        } else if (googleMarkers.length === 1) {
          googleMapInstance.setCenter(bounds.getCenter());
          googleMapInstance.setZoom(16);
        }

        setTimeout(function() {
          if (googleMapInstance) {
            google.maps.event.trigger(googleMapInstance, 'resize');
            if (googleMarkers.length > 1) {
              googleMapInstance.fitBounds(bounds);
            }
          }
        }, 300);
      },
      error: function(err) {
        console.error('Error:', err);
        $('#total_ingresos_dia').html('<i class="fas fa-exclamation-triangle"></i> Error');
        $('#aviso_sin_coords').hide();
      }
    });
  }

  function LimpiarMarcadores() {
    googleMarkers.forEach(function(m) { m.setMap(null); });
    googleMarkers = [];
  }

  function AbrirModalEditar(id, numeconomico, equipo, matricula, mac) {
    $('#edit_numeconomico').val(numeconomico);
    $('#edit_equipo').val(equipo);
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
</script>

<!-- ============================================ -->
<!-- FIREBASE REALTIME                             -->
<!-- ============================================ -->
<script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-database.js"></script>

<script>
$(document).ready(function() {
    console.log('🚀 Iniciando Firebase...');

    const firebaseConfig = {
        apiKey: "AIzaSyDz7FUkBtpZt9PBYoLXrxyOizg7BDVOmr4",
        authDomain: "oii-on.firebaseapp.com",
        projectId: "oii-on",
        storageBucket: "oii-on.firebasestorage.app",
        messagingSenderId: "574205217743",
        appId: "1:574205217743:web:259fe9d810e921d08760ba",
        measurementId: "G-D2Y68ZNJ9D"
    };

    if (typeof firebase !== 'undefined' && !firebase.apps.length) {
        firebase.initializeApp(firebaseConfig);
        console.log('✅ Firebase inicializado correctamente');
    } else {
        console.warn('⚠️ Firebase ya estaba inicializado o no está disponible');
    }

    const database = firebase.database();

    const equiposIds = [];
    @foreach($equipos as $equipo)
        equiposIds.push('{{ $equipo->id }}');
    @endforeach

    console.log(`📋 Escuchando ${equiposIds.length} equipos:`, equiposIds);

    equiposIds.forEach(function(equipoId, index) {
        const ref = database.ref('estados/' + equipoId);
        
        ref.on('value', function(snapshot) {
            const data = snapshot.val();
            
            if (data) {
                console.log(`🔔 CAMBIO RECIBIDO para equipo: ${equipoId}`);
                actualizarEstadoEquipo(equipoId, data);
            }
        }, function(error) {
            console.error(`❌ Error escuchando /estados/${equipoId}:`, error);
        });
    });

    function actualizarEstadoEquipo(equipoId, data) {
        const $tarjeta = $(`[data-equipo-id="${equipoId}"]`);
        if ($tarjeta.length === 0) return;

        const $badge = $tarjeta.find('.status-badge:first');
        const $texto = $badge.find('.badge-text');
        const $icono = $badge.find('.fa-lock, .fa-lock-open, .fa-question-circle, .fa-dollar-sign');

        $badge.removeClass('abierto cerrado sin-estado movimiento');

        if (data.cerrado === 0) {
            $badge.addClass('abierto');
            $texto.text('Abierto');
            $icono.attr('class', 'fas fa-lock-open ml-1');
        } else if (data.cerrado === 1) {
            $badge.addClass('cerrado');
            $texto.text('Cerrado');
            $icono.attr('class', 'fas fa-lock ml-1');
        }

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