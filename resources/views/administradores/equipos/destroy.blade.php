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
              <div class="card card-danger">
                  <div class="card-header">
                      <h3 class="card-title"><i class="nav-icon fa fa-trash" aria-hidden="true"></i> Quitar Operador</h3> 
                                               
                  </div>     
                  <div class="card-body">
                    
                     
                    <div class="row">
                      <div class="col-sm-6">
                          <div class='form-group'>
                              <label for="numeconomico">Número Económico</label>
                              <input disabled type="text" class="form-control" id="numeconomico" name="numeconomico" placeholder="Número Económico" value="{{$equipo->numeconomico}}">
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class='form-group'>
                              <label for="matricula">Matrícula</label>
                              <input disabled type="text" class="form-control" id="matricula" name="matricula" placeholder="Matrícula" value="{{$equipo->matricula}}">
                          </div>
                      </div>
                  </div>
                  <div class="row">                     
                                          
                      
                      <div class="col-sm-4">
                          <div class='form-group'>
                          <label for="mac">MAC</label>
                          <input disabled type="text" class="form-control" id="mac" name="mac" placeholder="MAC" value="{{$equipo->mac}}">
                          </div>
                      </div>  
                  </div>   

                  <div class="row">
                    <div class="col-md-3">
                    <a href="{{url('equipos')}}" class="btn btn-info btn-block"><i class="nav-icon fa fa-times" aria-hidden="true"></i> Cancelar</a>                     
                    </div>

                    <div class="col-md-3">
                      
                    </div>

                    <div class="col-md-3">
                      
                    </div>

                    <div class="col-md-3">
                      <form action="{{url('equipos')}}/{{$equipo->id}}" id="Nadmin" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-block"><i class="nav-icon fa fa-times" aria-hidden="true"></i> Borrar</button>                     
                      </form>
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
@include('administradores.footer')
</body>
</html>
