<html>
<head>
<meta charset="utf-8">
<title>mjailton erp pedido</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="{{asset('assets/delivery/css/grade.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/delivery/css/auxiliar.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/delivery/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/delivery/css/style-m.css')}}">

	<script type="text/javascript" src="{{asset('assets/delivery/js/jquery-3.2.1.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/delivery/js/js.js')}}"></script>
</head>

<body>	
<div class="site">
		@include("templates.inc.cabecalho_delivery")
<div class="conteudo">
<div class="base-prod-home">
<div class="rows">
			@include("templates.inc.menu_delivery")	
			@yield("conteudo")	
		
		</div>
		</div>
	</div>
		@include("templates.inc.rodape_delivery")
	</div>
</body>
</html>