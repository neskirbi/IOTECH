<!DOCTYPE html>
<html lang="es">
<head>
    @include('header')
    <title>{{Empresa()}} | Operadores</title>

    
    <!-- Estilos personalizados -->
    <style>
       
    </style>
</head>
<body>
    <div class="main-container">
        @include('toast.toasts')

        @include('administradores.sidebar')
        

        <!-- Contenido principal -->
        <main class="main-content" id="mainContent">
            @include('administradores.navbar')

            <!-- Área de contenido -->
            <div class="content-area">

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
                                        <label for="nombre">Nombre(s)</label>
                                        <input disabled type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombre(s)" value="{{$operador->nombres}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class='form-group'>
                                        <label for="apellidos">Apellidos</label>
                                        <input disabled type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="{{$operador->apellidos}}">
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">                            
                                
                                <div class="col-sm-4">
                                    <div class='form-group'>
                                    <label for="mail">Correo</label>
                                    <input onkeyup="Cambio(this,'mail');" data-valor="{{$operador->mail}}" disabled type="mail" class="form-control" id="mail" placeholder="Correo"  value="{{$operador->mail}}">
                                    </div>
                                </div>                         
                                
                                
                                </div>
                            

                                <div class="row">
                                <div class="col-md-3">
                                <a href="{{url('operadores')}}" class="btn btn-info btn-block"><i class="nav-icon fa fa-times" aria-hidden="true"></i> Cancelar</a>                     
                                </div>

                                <div class="col-md-3">
                                    
                                </div>

                                <div class="col-md-3">
                                    
                                </div>

                                <div class="col-md-3">
                                    <form action="{{url('operadores')}}/{{$operador->id}}" id="Nadmin" method="post">
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
              
                
            </div>
        </main>
    </div>

    @include('footer')
</body>
</html>