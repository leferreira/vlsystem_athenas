<html>
<head>
<meta charset="utf-8">
<title>Planos mjailton</title>
    	<link href="{{asset('assets/admin/img/ico-athenas.svg')}}" type="image/x-icon" rel="icon" />
    	<link href="{{asset('assets/admin/img/ico-athenas.svg')}}" type="image/x-icon" rel="shortcut icon" />
    	<link href="{{asset('assets/admin/img/ico-athenas.svg')}}" rel="apple-touch-icon" />
    	
    	<meta name="viewport" content="width=device-width, initial-scale =1">
    	<link rel="stylesheet" type="text/css" href="{{asset('assets/site/css/auxiliar.css')}}">
    	<link rel="stylesheet" type="text/css" href="{{asset('assets/site/css/grade.css')}}">
    	<link rel="stylesheet" type="text/css" href="{{asset('assets/site/css/style.css')}}">
	
	   <!--Css Componentes-->
		<link rel="stylesheet" href="{{asset('assets/componentes/css/style_Componente.css')}}">
		
		<!--font icones-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<script src="{{asset('assets/site/js/jquery.min.js')}}"></script>	
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		<script>
				var base_url = "{{asset('')}}";
				var _token   = "{{csrf_token()}}";
			
		</script>
</head>

<body>

	@include('inc.erros')
    @include('inc.msg')
    <div id="mostrarErros"></div>
    <div id="mostrarUmErro"></div>
    <div id="mostrarSucesso"></div>
    
	@yield("conteudo")
	<!--CARREGA O GIRA GIRA-->
    <div class="window load" id="giragira">
    	<span class="text-load">Carregando...</span>
    </div>
    
    <a href="" class="suport-whats"></a>
     <script src="https://kit.fontawesome.com/9480317a2f.js"></script>
    		
	
	<script src="{{asset('assets/site/js/jquery.mask.js')}}"></script>
	
	<script src="{{asset('assets/componentes/js/js_modal.js')}}"></script>
	<script src="{{asset('assets/componentes/js/js_util.js')}}"></script>
	<script src="{{asset('assets/componentes/js/js_mascara.js')}}"></script>
	<script src="{{asset('assets/componentes/js/upload.js')}}"></script> 
    
   
   
   
</body>
</html>