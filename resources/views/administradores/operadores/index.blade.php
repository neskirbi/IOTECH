<!DOCTYPE html>
<html lang="es">
<head>
  @include('header')
  <title>{{ getSiteTitle('Operadores') }}</title>
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
        <h1 class="m-0 text-white font-weight-bold" style="font-size: 1.5rem;">
          <i class="fas fa-users mr-2" style="color: var(--accent-cyan);"></i>Gestión de Operadores
        </h1>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <!-- Card Principal de Operadores Registrados -->
            <div class="card card-oiion mb-4">
              <div class="card-header border-0 d-flex align-items-center justify-content-between">
                <h3 class="card-title text-white font-weight-bold">
                  <i class="fas fa-users mr-2" style="color: var(--accent-cyan);"></i> Operadores Activos
                </h3>
              </div>
              
              <div class="card-body">

                @foreach($operadores as $operador)
                <div class="card card-oiion mb-3" style="border: 1px solid var(--border-color);">
                  <div class="card-header border-0 d-flex justify-content-between align-items-center w-100" style="background-color: rgba(255, 255, 255, 0.02);">
  
                  <!-- Lado Izquierdo: Título + Badge Parpadeante -->
                  <div class="d-flex align-items-center" style="gap: 12px;">
                    <h4 class="card-title text-white font-weight-bold m-0" style="font-size: 1rem;">
                      <i class="fas fa-user-shield mr-2" style="color: var(--accent-green);"></i> {{$operador->nombres}} {{$operador->apellidos}}
                    </h4> 
                    
                    <!-- Badge de Estado con punto parpadeante -->
                    <span id="badge_estado_{{$operador->id}}" class="status-badge {{ ($operador->activo ?? 1) == 1 ? 'online' : 'offline' }}">
                      <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                      <span class="badge-text">{{ ($operador->activo ?? 1) == 1 ? 'Activo' : 'Inactivo' }}</span>
                    </span>
                  </div>

                  <!-- Lado Derecho: Menú de opciones de tres puntos -->
                  <div class="card-tools ml-auto">
                    <div class="btn-group dropleft">
                      <button class="btn btn-sm text-white-50 border-0" type="button" id="menu_{{$operador->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: transparent;">
                        <i class="fas fa-ellipsis-v text-white"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right" style="background-color: var(--bg-card); border-color: var(--border-color);">
                        
                        <!-- Alternar Estado -->
                        <a class="dropdown-item text-light" id="btn_toggle_{{$operador->id}}" href="javascript:void(0)" onclick="ToggleOperadorStatus('{{$operador->id}}', this)">
                          @if(($operador->activo ?? 1) == 1)
                            <i class="fas fa-user-slash mr-2 text-warning"></i> Desactivar Operador
                          @else
                            <i class="fas fa-user-check mr-2 text-success"></i> Activar Operador
                          @endif
                        </a>

                        <div class="dropdown-divider" style="border-color: var(--border-color);"></div>

                        <!-- Eliminar Operador -->
                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="ConfirmarEliminarOperador('{{$operador->id}}', '{{$operador->nombres}} {{$operador->apellidos}}')">
                          <i class="fas fa-trash-alt mr-2"></i> Quitar Operador
                        </a>
                      </div>
                    </div>
                  </div>                           

                </div>   
                  
                  <div class="card-body">
                    <form action="{{url('operadores')}}/{{$operador->id}}" method="post">
                      @csrf                            
                      @method('put')
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="text-muted">Nombre(s)</label>
                            <input required type="text" class="form-control form-control-oiion" name="nombres" placeholder="Nombre(s)" value="{{$operador->nombres}}">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="text-muted">Apellidos</label>
                            <input required type="text" class="form-control form-control-oiion" name="apellidos" placeholder="Apellidos" value="{{$operador->apellidos}}">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="text-muted">Correo Electrónico</label>
                            <input onkeyup="Cambio(this,'mail');" data-valor="{{$operador->mail}}" required type="email" class="form-control form-control-oiion" placeholder="Correo" value="{{$operador->mail}}">
                          </div>
                        </div> 
                         
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="text-muted">Contraseña Temporal</label>
                            <div class="input-group">
                              <div class="input-group-prepend" style="cursor:pointer;" onclick="GenerarPass('{{$operador->id}}');">
                                <span class="input-group-text bg-dark border-secondary text-cyan"><i class="fas fa-sync-alt"></i></span>
                              </div>
                              <input type="text" class="form-control form-control-oiion" id="temp_{{ $operador->id }}" name="temp" value="{{ $operador->temp }}" readonly>
                            </div>
                          </div>
                        </div>
                      </div>   

                      <button type="submit" class="btn btn-action float-right mt-2">Guardar Cambios</button>                     
                    </form>
                  </div>
                </div>
                @endforeach

              </div>
            </div>

            <!-- Card Agregar Nuevo Operador -->
            <div class="card card-oiion">
              <div class="card-header border-0">
                <h3 class="card-title text-white font-weight-bold">
                  <i class="fas fa-user-plus mr-2" style="color: var(--accent-cyan);"></i> Registrar Nuevo Operador
                </h3>                            
              </div>                        
              
              <div class="card-body">
                <form action="{{url('operadores')}}" method="post">
                  @csrf
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="text-muted">Nombre(s)</label>
                        <input required type="text" class="form-control form-control-oiion" name="nombres" placeholder="Ej. Juan">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="text-muted">Apellidos</label>
                        <input required type="text" class="form-control form-control-oiion" name="apellidos" placeholder="Ej. Pérez">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="text-muted">Correo Electrónico</label>
                        <input required type="email" class="form-control form-control-oiion" name="mail" placeholder="correo@ejemplo.com">
                      </div>
                    </div>            
                  </div>   

                  <button type="submit" class="btn btn-action float-right mt-2">Registrar Operador</button>                     
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Modal de Confirmación para Eliminar Operador -->
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
        <p class="mb-2">¿Estás seguro de que deseas eliminar al operador <b id="nombre_operador_eliminar" class="text-white"></b>?</p>
        <p class="text-muted small mb-0">Esta acción no se puede deshacer y el operador perderá acceso al sistema inmediatamente.</p>
      </div>

      <div class="modal-footer border-0" style="background-color: rgba(255, 255, 255, 0.02);">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
          <i class="fas fa-times mr-1"></i> Cancelar
        </button>
        
        <form id="formEliminarOperador" action="" method="post" class="d-inline">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-sm" style="background-color: var(--accent-red); color: #fff; font-weight: 600;">
            <i class="fas fa-trash-alt mr-1"></i> Quitar Operador
          </button>
        </form>
      </div>

    </div>
  </div>
</div>
  @include('footer')
</div>
@include('administradores.footer')
</body>
</html>