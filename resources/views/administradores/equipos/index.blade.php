<!DOCTYPE html>
<html lang="es">
<head>
  @include('administradores.header')
  <title>OIIon | Equipos</title>
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
        <h1 class="m-0 text-white font-weight-bold" style="font-size: 1.5rem;">Gestión de Equipos</h1>
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
                  <i class="fas fa-microchip mr-2" style="color: var(--accent-cyan);"></i> Equipos Registrados
                </h3>
              </div>
              
              <div class="card-body">

                @foreach($equipos as $equipo)
                <div class="card card-oiion mb-3" style="border: 1px solid var(--border-color);">
                  <div class="card-header border-0 d-flex justify-content-between align-items-center w-100" style="background-color: rgba(255, 255, 255, 0.02);">
  
                    <!-- Lado Izquierdo: Título con Número Económico + Badge Parpadeante -->
                    <div class="d-flex align-items-center" style="gap: 12px;">
                      <h4 class="card-title text-white font-weight-bold m-0" style="font-size: 1rem;">
                        <i class="fas fa-server mr-2" style="color: var(--accent-cyan);"></i> {{$equipo->numeconomico}}
                      </h4> 
                      
                      <!-- Badge de Estado de Equipo -->
                      <span id="badge_estado_{{$equipo->id}}" class="status-badge {{ ($equipo->activo ?? 1) == 1 ? 'online' : 'offline' }}">
                        <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                        <span class="badge-text">{{ ($equipo->activo ?? 1) == 1 ? 'Activo' : 'Inactivo' }}</span>
                      </span>
                    </div>

                    <!-- Lado Derecho: Menú de opciones de tres puntos -->
                    <div class="card-tools ml-auto">
                      <div class="btn-group dropleft">
                        <button class="btn btn-sm text-white-50 border-0" type="button" id="menu_{{$equipo->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: transparent;">
                          <i class="fas fa-ellipsis-v text-white"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" style="background-color: var(--bg-card); border-color: var(--border-color);">
                          
                          <!-- Alternar Estado (Activar/Desactivar) -->
                          <a class="dropdown-item text-light" id="btn_toggle_{{$equipo->id}}" href="javascript:void(0)" onclick="ToggleEquipoStatus('{{$equipo->id}}', this)">
                            @if(($equipo->activo ?? 1) == 1)
                              <i class="fas fa-power-off mr-2 text-warning"></i> Desactivar Equipo
                            @else
                              <i class="fas fa-check-circle mr-2 text-success"></i> Activar Equipo
                            @endif
                          </a>

                          <div class="dropdown-divider" style="border-color: var(--border-color);"></div>

                          <!-- Eliminar Equipo -->
                          <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="ConfirmarEliminarEquipo('{{$equipo->id}}', '{{$equipo->numeconomico}}')">
                            <i class="fas fa-trash-alt mr-2"></i> Quitar Equipo
                          </a>
                        </div>
                      </div>
                    </div>                           

                  </div>   
                  
                  <div class="card-body">
                    <form action="{{url('equipos')}}/{{$equipo->id}}" method="post">
                      @csrf                            
                      @method('put')
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="text-muted">Número Económico</label>
                            <input required type="text" class="form-control form-control-oiion" name="numeconomico" placeholder="Número Económico" value="{{$equipo->numeconomico}}">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="text-muted">Matrícula</label>
                            <input required type="text" class="form-control form-control-oiion" name="matricula" placeholder="Matrícula" value="{{$equipo->matricula}}">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="text-muted">Dirección MAC</label>
                            <input required type="text" class="form-control form-control-oiion" name="mac" placeholder="MAC" value="{{$equipo->mac}}">
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

            <!-- Card Agregar Nuevo Equipo -->
            <div class="card card-oiion">
              <div class="card-header border-0">
                <h3 class="card-title text-white font-weight-bold">
                  <i class="fas fa-plus-circle mr-2" style="color: var(--accent-cyan);"></i> Registrar Nuevo Equipo
                </h3>                            
              </div>                        
              
              <div class="card-body">
                <form action="{{url('equipos')}}" method="post">
                  @csrf
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="text-muted">Número Económico</label>
                        <input required type="text" class="form-control form-control-oiion" name="numeconomico" placeholder="Ej. EQ-101">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="text-muted">Matrícula</label>
                        <input required type="text" class="form-control form-control-oiion" name="matricula" placeholder="Ej. ABC-123">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="text-muted">Dirección MAC</label>
                        <input required type="text" class="form-control form-control-oiion" name="mac" placeholder="Ej. 00:1B:44:11:3A:B7">
                      </div>
                    </div>            
                  </div>   

                  <button type="submit" class="btn btn-action float-right mt-2">Registrar Equipo</button>                     
                </form>
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
        <p class="text-muted small mb-0">Esta acción no se puede deshacer y el equipo será removido del sistema.</p>
      </div>

      <div class="modal-footer border-0" style="background-color: rgba(255, 255, 255, 0.02);">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
          <i class="fas fa-times mr-1"></i> Cancelar
        </button>
        
        <form id="formEliminarEquipo" action="" method="post" class="d-inline">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-sm" style="background-color: var(--accent-red); color: #fff; font-weight: 600;">
            <i class="fas fa-trash-alt mr-1"></i> Quitar Equipo
          </button>
        </form>
      </div>

    </div>
  </div>
</div>

@include('administradores.footer')

<script>
  function ConfirmarEliminarEquipo(id, numeconomico) {
    document.getElementById('nombre_equipo_eliminar').innerText = numeconomico;
    document.getElementById('formEliminarEquipo').action = "{{ url('equipos') }}/" + id;
    $('#modalConfirmarEliminar').modal('show');
  }

  
</script>

</body>
</html>