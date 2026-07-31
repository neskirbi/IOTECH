<!DOCTYPE html>
<html lang="en">
<head>
  @include('administradores.header')
  <title>IOTECH | Operadores</title>

  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
@include('toast.toasts')  
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
     
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fa fa-group" aria-hidden="true"></i> Operadores</h3>

                <div class="card-tools">
                  <!--
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Filtros <i class="fa fa-sliders" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" style="width:300px;">
                      <form class="px-4 py-3" action="{{url('generadorasoc')}}" method="GET">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-building"></i></span>
                          </div>
                          <input type="text" class="form-control" name="generador" id="generador" placeholder="Generador" @if(isset($filtros->generador)) value="{{$filtros->generador}}" @endif >
                        </div>

                        <div class="dropdown-divider"></div>
                        <a href="generadorasoc" class="btn btn-default btn-sm">Limpiar</a>
                        <button type="submit" class="btn btn-info btn-sm float-right">Aplicar</button>
                        
                      </form>
                      
                    </div>
                  </div>                 
                -->
                </div>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow-x: scroll;">

              @foreach($operadores as $operador)

              <div class="row">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title"><i class="nav-icon fa fa-user" aria-hidden="true"></i> Operador</h3> 
                            <div class="card-tools">
                                <div class="btn-group dropleft">
                                    <button class="btn btn-default " type="button" id="menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="menu">
                                        <a class="dropdown-item" href="{{url('BorrarOperador').'/'.$operador->id}}"><i class="fa fa-trash" aria-hidden="true"></i> Quitar</a>
                                    </div>
                                </div>
                            </div>                           
                        </div>     
                        <div class="card-body">
                          <form action="{{url('operadores')}}/{{$operador->id}}" id="Nadmin" method="post">
                            @csrf                            
                            @method('put')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class='form-group'>
                                        <label for="nombre">Nombre(s)</label>
                                        <input required type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombre(s)" value="{{$operador->nombres}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class='form-group'>
                                        <label for="apellidos">Apellidos</label>
                                        <input required type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="{{$operador->apellidos}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">                     
                                                   
                               
                               <div class="col-sm-4">
                                   <div class='form-group'>
                                       <label for="mail">Correo</label>
                                       <input onkeyup="Cambio(this,'mail');" data-valor="{{$operador->mail}}" required type="mail" class="form-control" id="mail" placeholder="Correo"  value="{{$operador->mail}}">
                                   </div>
                               </div> 
                               
                               
                               <!-- Para cualquier tipo de usuario - Mismo código para todos -->
                                <div class="col-sm-4">
                                    <div class='form-group'>
                                        <label>Contraseña Temporal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend" style="cursor:pointer;" onclick="GenerarPass('{{$operador->id}}');">
                                                <span class="input-group-text"><i class="fa fa-recycle"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="temp_{{ $operador->id }}" 
                                                  name="temp" value="{{ $operador->temp }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                            <button type="submit" class="btn btn-info float-right">Guardar</button>                     
                          </form>
                        </div>
                             
                    </div>                    
                </div>
              </div>
                
              @endforeach

              <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Agregar Operador</h3>                            
                        </div>                        
                        @csrf
                        <div class="card-body">
                          <form action="{{url('operadores')}}" id="Nadmin" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class='form-group'>
                                        <label for="nombre">Nombre(s)</label>
                                        <input required type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombre(s)">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class='form-group'>
                                        <label for="apellidos">Apellidos</label>
                                        <input required type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos">
                                    </div>
                                </div>
                            </div>
                            <div class="row">                            
                               
                               <div class="col-sm-4">
                                   <div class='form-group'>
                                       <label for="mail">Correo</label>
                                       <input required type="mail" class="form-control" id="mail" name="mail" placeholder="Correo">
                                   </div>
                               </div>            
                               
                            
                             
                               
                            </div>   
                            <button type="submit" class="btn btn-info float-right">Guardar</button>                     
                          </form>
                        </div>
                             
                    </div>                    
                </div>
              </div>
                


              
                
              </div>
              <div class="card-footer">
             
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@include('administradores.footer')
</body>
</html>
