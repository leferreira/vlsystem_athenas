
<!doctype html>
<html>
<head>
<meta charset="utf-8">
	<title> mjailton loja virtual</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		<link href="{{asset('assets/img/ico-athenas.svg')}}" type="image/x-icon" rel="icon" />
		<link href="{{asset('assets/img/ico-athenas.svg')}}" type="image/x-icon" rel="shortcut icon" />
		<link rel="stylesheet" href="{{asset('assets/img/ico-athenas.svg')}}" rel="apple-touch-icon" />
		
		<link rel="stylesheet" href="{{asset('assets/css/grade.css')}}">
  		<link rel="stylesheet" href="{{asset('assets/css/auxiliar.css')}}">		
  		<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">		
  		<link rel="stylesheet" href="{{asset('assets/css/style-m.css')}}">		
        
        <link rel="stylesheet" href="{{asset('assets/componentes/css/style_Componente.css')}}">
        
        <script type="text/javascript" src="{{asset('assets/s/jquery-3.2.1.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/js/js.js')}}"></script>
		
			
       
</head>
<body class="base-login">
	<div id="mostrarErros"></div>
    <div id="mostrarUmErro"></div>
    <div id="mostrarSucesso"></div>
    
		<div class="conteudo">
		<div class="rows">
			<div class="col-4 m-auto">
			<div class="caixa-login">
				<img src="{{asset('assets/img/logo2.svg')}}" width="200" class="m-auto d-block">
				<h1 class="text-center">Logar</h1>
				<form action="{{route('login.in')}}" method="POST">
				@csrf
				<div class="rows">
					<div class="col-12"><span class="text-label">Login</span><input type="text" name="email" placeholder="insira se login" class="form-campo"></div>
					<div class="col-12 mt-2"><span class="text-label">Senha</span><input type="password" name="password" placeholder="insira sua senha" class="form-campo"></div>
					<div class="col-12 mt-3 text-center"><input type="submit" value="entrar" class="btn btn-azul m-auto"> </div>
				</div>
				</form>
				
			</div>
			</div>
		</div>
		</div>
</body>
</html>