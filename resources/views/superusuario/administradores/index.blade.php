<!DOCTYPE html>
<html lang="en">
<head>
  @include('header')
  <title>{{ getSiteTitle('Administradores') }}</title>
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="background-color: var(--bg-main);">
@include('toast.toasts')  
<div class="wrapper">

  <!-- Navbar -->
  @include('superusuario.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('superusuario.sidebar')

  <!-- Content Wrapper -->
  <div class="content-wrapper" style="background-color: var(--bg-main);">
    <!-- Content Header -->
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0 text-white font-weight-bold" style="font-size: 1.5rem;">
          <i class="fas fa-user-shield mr-2" style="color: var(--accent-cyan);"></i> Gestión de Administradores
        </h1>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <!-- Card Principal -->
            <div class="card card-oiion mb-4">
              <div class="card-header border-0">
                <h3 class="card-title text-white font-weight-bold">
                  <i class="fas fa-users-cog mr-2" style="color: var(--accent-cyan);"></i> Administradores Registrados
                </h3>
              </div>
              
              <div class="card-body">

                @foreach($administradores as $administrador)
                <div class="card card-oiion mb-3" style="border: 1px solid var(--border-color);">
                  <div class="card-header border-0 d-flex justify-content-between align-items-center w-100" style="background-color: rgba(255, 255, 255, 0.02);">
                    
                    <!-- Título -->
                    <h4 class="card-title text-white font-weight-bold m-0" style="font-size: 1rem;">
                      <i class="fas fa-user-shield mr-2" style="color: var(--accent-cyan);"></i> {{$administrador->nombres}} {{$administrador->apellidos}}
                    </h4>

                    <!-- Menú -->
                    <div class="card-tools">
                      <div class="btn-group dropleft">
                        <button class="btn btn-sm text-white-50 border-0" type="button" data-toggle="dropdown" style="background: transparent;">
                          <i class="fas fa-ellipsis-v text-white"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" style="background-color: var(--bg-card); border-color: var(--border-color);">
                          <a class="dropdown-item text-danger" href="{{url('BorrarAdmin').'/'.$administrador->id}}">
                            <i class="fas fa-trash-alt mr-2"></i> Quitar Administrador
                          </a>
                        </div>
                      </div>
                    </div>

                  </div>   
                  
                  <div class="card-body">
                    <form action="{{url('administradores')}}/{{$administrador->id}}" method="post">
                      @csrf                            
                      @method('put')
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="text-muted">Nombre(s)</label>
                            <input required type="text" class="form-control form-control-oiion" name="nombres" placeholder="Nombre(s)" value="{{$administrador->nombres}}">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="text-muted">Apellidos</label>
                            <input required type="text" class="form-control form-control-oiion" name="apellidos" placeholder="Apellidos" value="{{$administrador->apellidos}}">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label class="text-muted">Correo Electrónico</label>
                            <input onkeyup="Cambio(this,'mail');" data-valor="{{$administrador->mail}}" required type="email" class="form-control form-control-oiion" name="mail" placeholder="Correo" value="{{$administrador->mail}}">
                          </div>
                        </div> 
                        
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label class="text-muted">Empresa</label>
                            <select required class="form-control form-control-oiion" name="empresa">
                              <option value="{{$administrador->empresa_id}}">{{$administrador->empresa}}</option>
                              <optgroup></optgroup>
                              @foreach($empresas as $empresa)
                              <option value="{{$empresa->id}}">{{$empresa->empresa}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                         
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label class="text-muted">Contraseña Temporal</label>
                            <div class="input-group">
                              <div class="input-group-prepend" style="cursor:pointer;" onclick="GenerarPass('{{$administrador->id}}');">
                                <span class="input-group-text bg-dark border-secondary" style="color: var(--accent-cyan);"><i class="fas fa-sync-alt"></i></span>
                              </div>
                              <input type="text" class="form-control form-control-oiion" id="temp_{{$administrador->id}}" name="temp" value="{{$administrador->temp}}" readonly>
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

            <!-- Card Agregar Nuevo -->
            <div class="card card-oiion">
              <div class="card-header border-0">
                <h3 class="card-title text-white font-weight-bold">
                  <i class="fas fa-user-plus mr-2" style="color: var(--accent-cyan);"></i> Registrar Nuevo Administrador
                </h3>                            
              </div>                        
              
              <div class="card-body">
                <form action="{{url('administradores')}}" method="post">
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
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="text-muted">Empresa</label>
                        <select required class="form-control form-control-oiion" name="empresa">
                          <option value="">--Seleccione Opción--</option>
                          @foreach($empresas as $empresa)
                          <option value="{{$empresa->id}}">{{$empresa->empresa}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>   

                  <button type="submit" class="btn btn-action float-right mt-2">Registrar Administrador</button>                     
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

</body>
</html>