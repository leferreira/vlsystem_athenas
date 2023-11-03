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
			<h1 class="text-center pb-2 text-uppercase">Digite a Nova Senha</h1>
			<form action="{{ route('password.update') }}" method="POST" name="">
			@csrf
				<input type="hidden" name="token" value="{{ $token }}">
			<input id="email" type="hidden" class="form-campo @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
				
				@error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                                
				
				<span class="label mt-2">Senha</span>	
				<input id="password" type="password" class="form-campo @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">		
				
				
				@error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                
                <span class="label mt-2">Confirmação de Senha</span>
                <input id="password-confirm" type="password" class="form-campo" name="password_confirmation" required autocomplete="new-password">			
				
				
				@error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                                
				
				<input type="submit" value="entrar" class="btn btn-azul width-100 h5 mt-3">				                                
                                
			</form>
			
			
			
		</div>
			
			
		</div>
		
		
	</body>
</html>
