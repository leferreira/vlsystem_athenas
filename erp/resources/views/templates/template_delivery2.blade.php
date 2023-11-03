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
	<script>
			let prot = window.location.protocol;
			let host = window.location.host;
			const path = prot + "//" + host + "/public/delivery/";
				
			let user = $('#user').val() ? $('#user').val() : 0;
	</script>
</head>

<body>	
<div class="site">
		@include("templates.inc.cabecalho_delivery")
        <div class="conteudo">
        <div class="base-prod-home">
        <div class="rows">
			@yield("conteudo")	
		
		</div>
		</div>
	</div>
		@include("templates.inc.rodape_delivery")
	</div>
</body>

@if(isset($mapaJs))
<script src="https://maps.googleapis.com/maps/api/js?key={{getenv('API_KEY_MAPS')}}"
async defer></script>
@endif
			
@isset($jsCarrinho)
    <script src="{{asset('assets/delivery/js/carrinho.js')}}"></script>
@endisset

@isset($forma_pagamento)
    <script src="{{asset('assets/delivery/js/forma_pagamento.js')}}"></script>
@endisset

<script src="{{asset('assets/delivery/js/acompanhamento.js')}}"></script>

</html>