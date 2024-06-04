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
          <div class="col-md-12">

            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fa fa-building" aria-hidden="true"></i> Borrar Empresa</h3>
              </div>


              
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="empresa">Empresa</label>
                        <input disabled type="text" class="form-control" id="empresa" name="empresa" placeholder="Empresa" value="{{$empresa->empresa}}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label for="razonsocial">Razon Social</label>
                        <input disabled type="text" class="form-control" id="razonsocial" name="razonsocial" placeholder="Razon Social" value="{{$empresa->razonsocial}}">
                      </div>
                    </div>
                  </div>
               



                <div class="card-footer">
                  <div class="row">
                    <div class="col-md-3">
                    <button onclick="history.back();" class="btn btn-primary btn-block"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
                    </div>
                    <div class="col-md-3">
                      
                    </div>
                    <div class="col-md-3">
                      
                    </div>
                    <div class="col-md-3">
                      <form action="{{url('empresas')}}/{{$empresa->id}}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-block" ><i class="fa fa-times" aria-hidden="true"></i> Borrar</button>  
                      </form>
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
