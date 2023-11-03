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
			<form action="{{ route('password.email') }}" method="POST" name="">
			@csrf
			 		@if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
				<span class="label">Email</span>
				<input type="email" name="email" id="email"  value="{{ old('email') }}" required autocomplete="email" autofocus class="form-campo">
				
				<input type="submit" value="entrar" class="btn btn-azul width-100 h5 mt-3">
			</form>
			@error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
			
			
		</div>
			
			
		</div>
		
		
	</body>
</html>


