<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - Sign up / Login Form</title>
  <link rel="stylesheet" href="{{asset('css/stylelogin.css')}}">

</head>
<body>
<!-- partial:index.partial.html -->
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form action="{{url('ingresar')}}" method="post">
					<label for="chk" aria-hidden="true">Ingresar</label>
					<input type="email" name="email" placeholder="Correo" required>
					<input type="password" name="pass" placeholder="Contraseña" required>
					<button>Entrar</button>
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
<!-- partial -->
  
</body>
</html>
