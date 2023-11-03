<html lang="pt-br">
	<head>
		<title>Mjailton</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--css-->		
		<link rel="stylesheet" href="{{asset('assets/pdv/css/grade.css')}}">
		<link rel="stylesheet" href="{{asset('assets/pdv/css/auxiliar.css')}}">
		<link rel="stylesheet" href="{{asset('assets/pdv/css/style.css')}}">
		<link rel="stylesheet" href="{{asset('assets/pdv/css/style-m.css')}}">
		<!--icones-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		
		 <script src="{{asset('assets/pdv/js/jquery.min.js')}}"></script>
		<script>
			$(function(){
				$('.senha').click (function(){
				$('.mostraCampo').slideToggle();
				$(this).toggleClass('active');
					return false;
				});
			
			});
		</script>
		
	</head>
	<body class="base-login">
	<div class="conteudo">
		<div class="rows mx-0">
			<div class="alt col-4 m-auto text-center pb-4">
				<img src="{{asset('assets/pdv/img/logo.svg')}}" class="img-fluido m-auto d-block" width="400">
			</div>
			<div class="caixa-login col-4 m-auto">
			<h2 class="text-center h2 mb-0 text-uppercase">Login</h2>
			<span class="text-center d-block pb-2 text-uppercase">Entre com seu login</span>
			<form action="{{route('login.in')}}" method="POST" name="">
			@csrf
				<span class="text-label">Login</span>
				<input type="email" name="email" class="form-campo">
				
				<span class="text-label mt-2">Senha</span>				
				<input type="password" name="password" class="form-campo">
				
				<input type="submit" value="entrar" class="btn btn-azul width-100 h5 mt-3">
				<a href="" class="senha py-3 d-block text-azul">Esqueci minha senha</a>
			</form>
			
			<div class="mostraCampo">
				<span class="senha">X</span>
				<h1 class="text-center pt-2 pb-0">Esqueci minha senha</h1>
				<p class="text-center mb-3">Digite seu email no campo abaixo para recuperar sua senha</p>
				<form action="" method="POST" name="">
					<span class="text-label">Email</span>
					<input type="text" placeholder="Insira seu login" class="form-campo">
					<input type="submit" value="Enviar email" class="btn btn-azul width-100 h5 mt-3">
				</form>
			</div>
			
		</div>
			
			
		</div>
		</div>
		
	</body>
</html>