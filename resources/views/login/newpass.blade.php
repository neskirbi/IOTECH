<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>IOTECH | Contraseña</title>
  @include('header')
  <link rel="stylesheet" href="{{asset('css/stylelogin.css')}}">
  
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">

</head>
<body>
<!-- partial:index.partial.html -->
@include('toast.toasts')
<!-- partial -->

<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form action="{{url('savepass')}}/{{$usuario->id}}" method="post">
					@csrf
					<label for="chk" aria-hidden="true"><center>Nueva Contraseña</center></label>					
					<input class="form-control" style="width:70%;" type="password" name="pass" id="pass" placeholder="Nueva Contraseña" required onkeyup="ValidarPassRegistro();">
					<input class="form-control" style="width:70%;" type="password" name="pass2" id="pass2" placeholder="Confirmar Contraseña" required onkeyup="ValidarPassRegistro();">
					<button style="width:70%;">Entrar</button>
				</form>
			</div>

			<div class="login">
				<form action="{{url('create')}}">
					<label for="chk" aria-hidden="true">IOTECH</label>
				
				</form>
			</div>
	</div>
  
</body>
</html>
