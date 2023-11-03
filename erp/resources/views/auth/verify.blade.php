<html lang="pt-br">
	<head>
		<title>Mjailton</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="{{asset('assets/admin/img/ico-athenas.svg')}}" type="image/x-icon" rel="icon" />
		<link href="{{asset('assets/admin/img/ico-athenas.svg')}}" type="image/x-icon" rel="shortcut icon" />
		<link href="{{asset('assets/admin/img/ico-athenas.svg')}}" rel="apple-touch-icon" />
		<!--css-->		
		<link rel="stylesheet" href="{{asset('assets/admin/css/grade.css')}}">
		<link rel="stylesheet" href="{{asset('assets/admin/css/auxiliar.css')}}">
		<link rel="stylesheet" href="{{asset('assets/admin/css/style.css')}}">
		<link rel="stylesheet" href="{{asset('assets/admin/css/style-m.css')}}">
		<!--icones-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		
		 <script src="{{asset('assets/admin/js/jquery.js')}}"></script>
		
		
	</head>
	<body class="base-login">
		<div class="rows mx-0">
			<div class="caixa-login col-4 m-auto pt-4">
			<img src="{{asset('assets/admin/img/logo-login.png')}}" class="img-fluido m-auto d-block" width="250">
			<h1 class="text-center pb-2 text-uppercase">Para ter acesso ao sistema é necessário confirmar seu email</h1>
			<h2 class="text-center pb-2 text-uppercase">Caso não tenha recebido o email de confirmação clique no link abaixo</h2>
				
			@if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        Um novo link de verificação foi enviado para seu e-mail
                    </div>
                @endif	
                                
			<form action="{{ route('verification.resend') }}" method="POST" >
			@csrf	
				<input type="submit" value="Clique aqui para solicitar outro email" class="btn btn-azul width-100 h5 mt-3">				                                
                                
			</form>
			<a href="{{ route('logout') }}"  class="senha py-3 d-block text-azul" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Fazer Logout
            </a>
                                
			<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"><i class="fas fa-lock"></i> 
                @csrf
            </form>
            
			
		</div>			
			
		</div>		
		
	</body>
</html>

