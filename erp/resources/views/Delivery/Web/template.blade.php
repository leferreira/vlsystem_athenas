<html>
<head>
<meta charset="utf-8">
<title>mjailton erp pedido</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="{{asset('assets/delivery/web/css/grade.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/delivery/web/css/auxiliar.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/delivery/web/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/delivery/web/css/style-m.css')}}">

	<script type="text/javascript" src="{{asset('assets/delivery/web/js/jquery-3.2.1.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/delivery/web/js/js.js')}}"></script>
	<script>
			var base_url = "{{asset('')}}";
			let prot = window.location.protocol;
			let host = window.location.host;
			const path = prot + "//" + host + "/public/web/";
				
			let user = $('#user').val() ? $('#user').val() : 0;
	</script>
</head>

<body>	
<div class="site">
		@include("Delivery.Web.cabecalho")
        <div class="conteudo">
        <div class="base-prod-home">
        <div class="rows">
			@yield("conteudo")	
		
		</div>
		</div>
	</div>
		@include("Delivery.Web.rodape")
	</div>
</body>
<script src="{{asset('assets/admin/js/jquery.mask.js')}}"></script>
<script src="{{asset('assets/componentes/js/js_mascara.js')}}"></script>
@if(isset($mapaJs))
<script src="https://maps.googleapis.com/maps/api/js?key={{getenv('API_KEY_MAPS')}}"
async defer></script>
@endif
			
@isset($jsCarrinho)
    <script src="{{asset('assets/delivery/web/js/carrinho.js')}}"></script>
@endisset

@isset($forma_pagamento)
    <script src="{{asset('assets/delivery/web/js/forma_pagamento.js')}}"></script>
@endisset

<script src="{{asset('assets/delivery/web/js/acompanhamento.js')}}"></script>

</html>