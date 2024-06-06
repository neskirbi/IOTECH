<!DOCTYPE html>
<html lang="en">
<head>
  @include('superusuario.header')
  <title>IOTECH | Administradores</title>

  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
@include('toast.toasts')  
<div class="wrapper">

  <!-- Navbar -->
 
  @include('superusuario.navigations.navigation')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('superusuario.sidebars.sidebar')

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
              <div class="card card-danger">
                  <div class="card-header">
                      <h3 class="card-title"><i class="nav-icon fa fa-trash" aria-hidden="true"></i> Quitar Administrador</h3> 
                                               
                  </div>     
                  <div class="card-body">
                    
                     
                      <div class="row">
                          <div class="col-sm-6">
                              <div class='form-group'>
                                  <label for="nombre">Nombre(s)</label>
                                  <input disabled type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombre(s)" value="{{$administrador->nombres}}">
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class='form-group'>
                                  <label for="apellidos">Apellidos</label>
                                  <input disabled type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="{{$administrador->apellidos}}">
                              </div>
                          </div>
                      </div>

                      
                      <div class="row">                            
                          
                          <div class="col-sm-4">
                            <div class='form-group'>
                              <label for="mail">Correo</label>
                              <input onkeyup="Cambio(this,'mail');" data-valor="{{$administrador->mail}}" disabled type="mail" class="form-control" id="mail" placeholder="Correo"  value="{{$administrador->mail}}">
                            </div>
                          </div>                         
                          
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label for="empresa">Empresa</label>
                              <select disabled class="form-control" name="empresa" id="empresa">
                                <option value=" {{$administrador->empresa_id}}"> {{$administrador->empresa}}</option>
                                <optgroup></optgroup>
                              </select>                                     
                            </div> 
                          </div>
                        </div>
                      

                        <div class="row">
                          <div class="col-md-3">
                          <a href="{{url('administradores')}}" class="btn btn-info btn-block"><i class="nav-icon fa fa-times" aria-hidden="true"></i> Cancelar</a>                     
                          </div>

                          <div class="col-md-3">
                            
                          </div>

                          <div class="col-md-3">
                            
                          </div>

                          <div class="col-md-3">
                            <form action="{{url('administradores')}}/{{$administrador->id}}" id="Nadmin" method="post">
                              @csrf
                              @method('delete')
                              <button class="btn btn-danger btn-block"><i class="nav-icon fa fa-times" aria-hidden="true"></i> Borrar</button>                     
                            </form>
                          </div>
                        </div> 
                          
                          
                      </div> 
                      
                      
                  </div>
                        
              </div>                    
          </div>
        </div>

        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@include('superusuario.footer')
</body>
</html>
