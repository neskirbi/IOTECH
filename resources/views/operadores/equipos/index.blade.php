<!DOCTYPE html>
<html lang="en">
<head>
  @include('operadores.header')
  <title>IOTECH | Equipos</title>

  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
@include('toast.toasts')  
<div class="wrapper">

  <!-- Navbar -->
 
  @include('operadores.navigations.navigation')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('operadores.sidebars.sidebar')

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
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title"> Vehículos</h5>
                <div class="card-tools">
                  
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Filtros <i class="fa fa-sliders" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" style="width:300px;">
                      <form class="px-4 py-3" action="{{url('equiposop')}}" method="GET">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-truck"></i></span>
                          </div>
                          <input type="text" class="form-control" name="numeconomico" id="numeconomico" placeholder="Número Económico" @if(isset($filtros->numeconomico)) value="{{$filtros->numeconomico}}" @endif >
                        </div>

                        <div class="dropdown-divider"></div>
                        <a href="equiposop" class="btn btn-default btn-sm">Limpiar</a>
                        <button type="submit" class="btn btn-info btn-sm float-right">Aplicar</button>
                        
                      </form>
                      
                    </div>
                  </div>                 
                
                </div>
              </div>

              <div class="card-body">
                <div class="col-md-12">        
                  <div class="row">
                  @foreach($equipos as $equipo)
                    <div class="col-md-3">           
                      <div class="card">
                        <img src="{{asset('images/iconos/vehiculo.png')}}" class="card-img-top" alt="...">
                        <div class="card-body">
                          
                          <center>
                            <font style="font-size:15px; "><b>{{$equipo->numeconomico}}</b></font><br>
                            <b>Matrícula:</b> <font style="font-size:15px; ">{{$equipo->matricula}}</font><br>
                            <b>MAC:</b> <font style="font-size:13px; ">{{$equipo->mac}}</font><br>
                          </center>                        
                          
                          <div class="row" > 
                            <div class="col-md-12"> 
                              <button type="button" class="btn btn-info btn-block" onclick="PreCodigo('{{$equipo->id}}','{{$equipo->numeconomico}}');" data-toggle="modal" data-target="#modalcodegen" >
                                <i class="fa fa-terminal" aria-hidden="true"></i> Generar
                              </button>
                            </div>

                        
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

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);

 
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App, funcion de sidebar -->
<script src="dist/js/adminlte.js"></script>
@include('operadores.equipos.modals.modalcodegen')
</body>
</html>
