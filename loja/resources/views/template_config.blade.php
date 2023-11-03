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
	
		<!--Css Componentes-->
		<link rel="stylesheet" href="{{asset('assets/componentes/css/style_Componente.css')}}">
		
		<script src="{{asset('assets/loja/js/jquery.min.js')}}"></script>		
		<script src="{{asset('assets/loja/js/jquery-ui.js')}}"></script>	
		<script src="https://kit.fontawesome.com/9480317a2f.js"></script>
			
	
	<script>
			var base_url = "{{asset('')}}";
			var _token   = "{{csrf_token()}}";				
				
			let prot = window.location.protocol;
			let host = window.location.host;
			const path = prot + "//" + host + "/public/loja/";				
			let user = $('#user').val() ? $('#user').val() : 0;
			
			window.MP_PUBLIC_KEY = "{{env('MP_PUBLIC_KEY')}}";
	</script>
		
	
</head>
<body>


	@include("cabecalho_config")
	@include('inc.erros')
    @include('inc.msg')
    <div id="mostrarErros"></div>
    <div id="mostrarUmErro"></div>
    <div id="mostrarSucesso"></div>


<div class="produtos {{(isset($tem_banner)) ? '' : 'sem-banner'}}  {{($pag) ?? NULL}}">
	<div class="conteudo">
		<div class="rows">			
			@yield("conteudo")
			
				<!--CARREGA O GIRA GIRA-->
    <div class="window load" id="giragira">
    	<span class="text-load">Carregando...</span>
    </div>
			
	</div>
</div>
</div>
        
		<script src="{{asset('assets/loja/js/datatables/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/loja/js/datatables/js/dataTables.responsive.min.js')}}"></script>			
	
    	<script src="{{asset('assets/loja/js/jquery.mask.js')}}"></script>
    	
    	<script src="{{asset('assets/componentes/js/js_data_table.js')}}"></script>	
    	<script src="{{asset('assets/componentes/js/js_modal.js')}}"></script>
    	<script src="{{asset('assets/componentes/js/js_util.js')}}"></script>
    	<script src="{{asset('assets/componentes/js/js_mascara.js')}}"></script>
    	<script src="{{asset('assets/componentes/js/upload.js')}}"></script>

		<script src="{{asset('assets/loja/js/lightslider.js')}}"></script>			
		<script src="{{asset('assets/loja/js/lightslider-mob.js')}}"></script>		
		
		  <!--Fundo Preto-->
<div id="fundo_preto"></div>
</body>
</html>