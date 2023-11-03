<html>
<head>
<meta charset="utf-8">
<title>mjailton loja virtual</title>
	<meta name="viewport" content="width=device-width, initial-scale =1">
		<link href="{{asset('assets/loja/img/ico-athenas.svg')}}" type="image/x-icon" rel="icon" />
		<link href="{{asset('assets/loja/img/ico-athenas.svg')}}" type="image/x-icon" rel="shortcut icon" />
		<link href="{{asset('assets/loja/img/ico-athenas.svg')}}" rel="apple-touch-icon" />
		
	<link rel="stylesheet" type="text/css" href="{{asset('assets/loja/css/lightslider.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/loja/css/style-slider.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/loja/css/auxiliar.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/loja/css/grade.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/loja/css/style.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/loja/css/style-m.css')}}">	
	<script type="text/javascript" src="{{asset('assets/loja/js/jquery.min.js')}}"></script>
	
		<!--Css Componentes-->
		<link rel="stylesheet" href="{{asset('assets/Componentes/css/style_Componente.css')}}">
	
	<script>
			let prot = window.location.protocol;
			let host = window.location.host;
			const path = prot + "//" + host + "/public/loja/";				
			let user = $('#user').val() ? $('#user').val() : 0;
	</script>
		
	
</head>
<body>

		<div class="col-12 m-auto py-5">
			<div class="iniciar_loja text-center">
				<span class="h4 text-center">Loja Não configurada!!</span>
				<span class="h5 text-center">É necessário configura a loja antes de utilizar</span>				
			</div>
		</div>
</body>
</html>