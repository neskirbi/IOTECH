<!DOCTYPE html>
<html lang="es">
<head>
  @include('administradores.header')
  <title>OIIon | Soporte Chapas y Cajas Fuertes</title>
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
      <div class="container-fluid">
        <h1 class="m-0 text-white font-weight-bold" style="font-size: 1.5rem;">Soporte Técnico de Chapas</h1>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <!-- Card Principal -->
            <div class="card card-oiion mb-4">
              <div class="card-header border-0 d-flex align-items-center justify-content-between">
                <h3 class="card-title text-white font-weight-bold">
                  <i class="fas fa-vault mr-2" style="color: var(--accent-cyan);"></i> Equipos y Cajas Fuertes
                </h3>

                <!-- Filtros -->
                <div class="card-tools ml-auto">
                  <div class="btn-group dropleft">
                    <button type="button" class="btn btn-sm text-white-50 border-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: transparent;">
                      <i class="fas fa-sliders-h text-white mr-1"></i> Filtros
                    </button>
                    <div class="dropdown-menu dropdown-menu-right p-3" style="width: 300px; background-color: var(--bg-card); border-color: var(--border-color);">
                      <form action="{{url('soporte')}}" method="GET">
                        <div class="form-group mb-3">
                          <label class="text-muted small">Número Económico</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-dark border-secondary text-cyan"><i class="fas fa-hashtag"></i></span>
                            </div>
                            <input type="text" class="form-control form-control-oiion" name="numeconomico" id="numeconomico" placeholder="Ej. 101" @if(isset($filtros->numeconomico)) value="{{$filtros->numeconomico}}" @endif>
                          </div>
                        </div>

                        <div class="dropdown-divider" style="border-color: var(--border-color);"></div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                          <a href="{{url('soporte')}}" class="btn btn-sm btn-outline-secondary">Limpiar</a>
                          <button type="submit" class="btn btn-sm btn-action">Aplicar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              </div>
              
              <div class="card-body">
                <div class="row">
                  @foreach($equipos as $equipo)
                  @php 
                    $estaActivo = ($equipo->activo == 1); 
                  @endphp
                  
                  <div class="col-xl-3 col-lg-4 col-md-6 mb-4">           
                    <div class="card card-oiion h-100" style="border: 1px solid {{ $estaActivo ? 'var(--border-color)' : 'rgba(239, 68, 68, 0.4)' }}; background-color: rgba(21, 28, 47, 0.6);">
                      <div class="card-body d-flex flex-column justify-content-between text-center p-3">
                        
                        <div>
                          <!-- Avatar de Equipo / Caja Fuerte -->
                          <div class="equipment-avatar-container" style="border: 1px solid {{ $estaActivo ? 'var(--accent-cyan)' : '#ef4444' }}; box-shadow: 0 0 15px {{ $estaActivo ? 'rgba(0, 242, 254, 0.25)' : 'rgba(239, 68, 68, 0.25)' }};">
                            
                            <!-- Indicador de punto neón -->
                            <span class="equip-status-dot" style="background-color: {{ $estaActivo ? '#10b981' : '#ef4444' }}; box-shadow: 0 0 8px {{ $estaActivo ? '#10b981' : '#ef4444' }};"></span>
                            
                            <i class="fas fa-vault equipment-icon" style="color: {{ $estaActivo ? 'var(--accent-cyan)' : '#ef4444' }}; filter: drop-shadow(0 0 8px {{ $estaActivo ? 'rgba(0, 242, 254, 0.6)' : 'rgba(239, 68, 68, 0.6)' }});"></i>
                          </div>

                          <!-- Identificador Principal -->
                          <h4 class="text-white font-weight-bold mb-1" style="font-size: 1.15rem; letter-spacing: 0.5px;">
                            {{$equipo->numeconomico}}
                          </h4>

                          <!-- Badge de Estado -->
                          @if($estaActivo)
                            <span class="badge badge-pill mb-3" style="background-color: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.4);">
                              <i class="fas fa-check-circle mr-1"></i> Activo
                            </span>
                          @else
                            <span class="badge badge-pill mb-3" style="background-color: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.4);">
                              <i class="fas fa-times-circle mr-1"></i> Inactivo
                            </span>
                          @endif
                          
                          <!-- Datos de la Chapa / Módulo -->
                          <div class="text-left text-muted small p-2 rounded mb-3" style="background-color: rgba(10, 15, 29, 0.8); border: 1px solid var(--border-color);">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                              <span style="font-size: 0.8rem;"><i class="fas fa-id-card text-muted mr-1"></i> Matrícula:</span>
                              <strong class="text-white" style="font-size: 0.85rem;">{{$equipo->matricula}}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                              <span style="font-size: 0.8rem;"><i class="fas fa-network-wired text-muted mr-1"></i> MAC:</span>
                              <strong class="{{ $estaActivo ? 'text-cyan' : 'text-danger' }} font-monospace" style="font-size: 0.8rem;">{{$equipo->mac}}</strong>
                            </div>
                          </div>
                        </div>                        
                        
                        <!-- Botón Generar Código -->
                        @if($estaActivo)
                          <button type="button" class="btn btn-action btn-block btn-sm mt-1" onclick="PreCodigo('{{$equipo->id}}','{{$equipo->numeconomico}}');" data-toggle="modal" data-target="#modalcodegen">
                            <i class="fas fa-key mr-1"></i> Generar Código
                          </button>
                        @else
                          <button type="button" class="btn btn-block btn-sm mt-1 text-muted" disabled style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); cursor: not-allowed;" title="No se pueden generar códigos para un equipo inactivo">
                            <i class="fas fa-lock mr-1"></i> Equipo Inactivo
                          </button>
                        @endif

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

<!-- Modal Generar Código (Soporte Chapa) -->
<div class="modal fade" id="modalcodegen" tabindex="-1" role="dialog" aria-labelledby="modalCodeGenTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(12px); border: 1px solid rgba(0, 242, 254, 0.3); box-shadow: 0 0 25px rgba(0, 242, 254, 0.15); border-radius: 12px;">
      
      <!-- Header -->
      <div class="modal-header border-0 pb-0" style="background: transparent;">
        <div class="d-flex align-items-center">
          <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0, 242, 254, 0.1); border: 1px solid var(--accent-cyan);">
            <i class="fas fa-terminal" style="color: var(--accent-cyan); font-size: 1.2rem;"></i>
          </div>
          <div>
            <h5 class="modal-title text-white font-weight-bold mb-0" id="modalCodeGenTitle">Generar Código de Soporte</h5>
            <small class="text-muted">Instrucción de mando para la chapa/caja</small>
          </div>
        </div>
        <button type="button" class="close text-white-50 opacity-75" data-dismiss="modal" aria-label="Close" style="outline: none;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Body -->
      <div class="modal-body py-4">
        @csrf                        
        
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

        <!-- Opciones tipo Selectors Neón -->
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

      <!-- Footer / Botón Acción -->
      <div class="modal-footer border-0 pt-0" style="background: transparent;">
        <button data-id="0" id="" onclick="GenerarCodigo(this);" class="btn btn-action btn-block bgenerar py-2 font-weight-bold" data-id_operador="{{GetId();}}" style="font-size: 1rem; border-radius: 8px;">
          <i class="fas fa-sync-alt mr-2"></i> Generar
        </button>
      </div>
    
    </div>
  </div>
</div>

@include('administradores.footer')
</body>
</html>