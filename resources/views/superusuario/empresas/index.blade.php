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
          <div class="col-md-3 col-sm-6 col-12">
            <a href="{{url('empresas/create')}}">
              <div class="info-box shadow-none">
                <span class="info-box-icon bg-info"><i class="fa fa-plus"></i></span>
                <div class="info-box-content">
                  <span style="color:#000;" class="info-box-text">Agregar</span>
                  <span style="color:#000;" class="info-box-number">Empresa</span>
                </div>
              </div>
            </a>
          </div>
          
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline card-outline-tabs">
              <div class="card-header">
              <h3 class="card-title"> <i class="nav-icon fa fa-building" aria-hidden="true"></i> Empresas</h3>
                <div class="card-tools">
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Filtros <i class="fa fa-sliders" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" style="width:300px;">
                      <form class="px-4 py-3" action="{{url('empresas')}}" method="GET">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                          </div>
                          <input type="text" class="form-control" name="empresa" id="empresa" placeholder="Empresa" @if(isset($filtros->empresa)) value="{{$filtros->empresa}}" @endif >
                        </div>
                        


                        <div class="dropdown-divider"></div>
                        <a href="{{url('empresas')}}" class="btn btn-default btn-sm">Limpiar</a>
                        <button type="submit" class="btn btn-info btn-sm float-right">Aplicar</button>
                        
                      </form>
                      
                    </div>
                  </div>                
                </div>              

                
              </div>
              <div class="card-body">
              @if(count($empresas))
                @foreach($empresas as $empresa)

                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12">
                              <h5 class="card-title" title="{{$empresa->empresa}}"><b>{{strlen($empresa->empresa)<81 ? $empresa->empresa : mb_substr($empresa->empresa,0,80,"UTF-8").'...'}}</b></h5>
                              <br>
                              <h5 class="card-title" title="{{$empresa->razonsocial}}">{{strlen($empresa->razonsocial)<81 ? $empresa->razonsocial : mb_substr($empresa->razonsocial,0,80,"UTF-8").'...'}}</h5>
                              
                             
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">                           
                            <br>
                            </div>
                          </div>
                          
                          
                          <div class="row">
                                                    
                            <div class="col-md-3" >
                              <a href="{{url('empresas')}}/{{$empresa->id}}" class="btn btn-info btn-block" ><i class="fa fa-eye" aria-hidden="true"></i> Editar</a>
                            </div>   

                            <div class="col-md-3" > 
                           
                            </div> 
                            <div class="col-md-3" >                       
                            </div>        

                            <div class="col-md-3" >
                              <a href="{{url('BorrarEmpresa')}}/{{$empresa->id}}" class="btn btn-danger btn-block"><i class="fa fa-times" aria-hidden="true"></i> Borrar</a>
                              
                            </div>                          
                          
                          </div>

                          <hr>

                          <div class="row">

                          <div class="col-md-3" >
                              @if($empresa->mailrepre!='' && $empresa->contrato==0)
                              <small class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i> Contrato Ok</small>
                              @endif
                            </div>  


                                                    
                            <div class="col-md-3" > 
                            </div>   

                            <div class="col-md-3" >                            
                            </div> 

                            <div class="col-md-3" >                       
                            </div>        

                                                    
                          
                          </div>
                          @if($empresa->alerta!='')
                          
                          <?php
                          $alertas = explode(',',$empresa->alerta);
                          ?>
                          
                          <div class="row">
                            <div class="col-md-12">
                              <hr>
                              @foreach($alertas as $alerta)
                              <small class="badge badge-danger"><i class="fa fa-check" aria-hidden="true"></i> {{$alerta}}</small>
                              @endforeach
                              <!--<p style="font-size:12px; color:#949494;">Cargar los documentos y guardar la obra de nuevo.</p>-->
                              
                            </div>
                          </div>
                          @endif
                      </div>
                    </div>
                  </div>
                </div>

                @endforeach
              @endif


                
              </div>

              <div class="card-footer">
              {{ $empresas->appends($_GET)->links('pagination::bootstrap-4') }}
              </div>
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
