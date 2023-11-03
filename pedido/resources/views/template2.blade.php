<!doctype html>
<html>
<head>
		<meta charset="utf-8">
		<title> mjailton - pedido</title>  			
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		<link href="{{asset('assets/img/ico-athenas.svg')}}" type="image/x-icon" rel="icon" />
		<link href="{{asset('assets/img/ico-athenas.svg')}}" type="image/x-icon" rel="shortcut icon" />
		<link rel="stylesheet" href="{{asset('assets/img/ico-athenas.svg')}}" rel="apple-touch-icon" />
		
		<link rel="stylesheet" href="{{asset('assets/css/datatables.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/style_datatables.css')}}">
		
        <link rel="stylesheet" href="{{asset('assets/css/grade.css')}}">
  		<link rel="stylesheet" href="{{asset('assets/css/auxiliar.css')}}">		
  		<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">		
  		<link rel="stylesheet" href="{{asset('assets/css/style-m.css')}}">		
        
        <!--Css Componentes-->
		<link rel="stylesheet" href="{{asset('assets/componentes/css/style_Componente.css')}}">
		
        <script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
        <script>
			var base_url = "{{asset('')}}";
			var _token   = "{{csrf_token()}}";	
			window.MP_PUBLIC_KEY = "{{$cobranca->mercadopago_public_key ?? "" }}";	
			
		</script>
	
</head>
<body class="site">
	<div id="mostrarErros"></div>
    <div id="mostrarUmErro"></div>
    <div id="mostrarSucesso"></div>
    
    <!--CARREGA O GIRA GIRA-->
    <div class="window load fechar_giragira" id="giragira">
    	<span class="text-load">Carregando...</span>
    </div>
    
	<div class="cabecalho">
		<div class="conteudo">
			<a href="{{route('home')}}" class="logo"><img src="{{asset('assets/img/logo.svg')}}"></a>			
			<ul class="menu-topo-text">	
				<li><a href="{{route('cobranca.index')}}">Cobranças</a></li>
											
				<li><a href=""></a></li>	
				<li>							
					<a href="{{route('login.out')}}"><i class="ico sair"></i>Sair</a>
				</li>		
			</ul>
		</div>		
</div>		

<section>
	<div class="conteudo">
	 <div class="base-centro">	
		@yield('conteudo')
		 
	</div>
</div>
</section>
		<script src="https://kit.fontawesome.com/9480317a2f.js"></script>
		
        <script src="{{asset('assets/js/datatables/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/js/datatables/js/dataTables.responsive.min.js')}}"></script>	
		
		<script src="{{asset('assets/js/jquery.mask.js')}}"></script>		
		
	
    	<script src="{{asset('assets/componentes/js/js_data_table.js')}}"></script>	
    	<script src="{{asset('assets/componentes/js/js_modal.js')}}"></script>
    	<script src="{{asset('assets/componentes/js/js_util.js')}}"></script>
    	<script src="{{asset('assets/componentes/js/js_mascara.js')}}"></script>
    	<script src="{{asset('assets/componentes/js/upload.js')}}"></script>
	
        
    
        <script src="https://sdk.mercadopago.com/js/v2"></script>

        <script type="text/javascript">
            const mp = new MercadoPago(MP_PUBLIC_KEY);
        </script>
        
        <script src="{{asset('assets/js/js_mercadopago.js')}}"></script>
     
		
		
</body>
</html>
