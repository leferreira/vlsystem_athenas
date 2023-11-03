<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Sistema PDV - mjailton</title>
		<meta charset="utf-8">
		<link href="{{asset('assets/pdv/img/ico-athenas.svg')}}" type="image/x-icon" rel="icon" />
		<link href="{{asset('assets/pdv/img/ico-athenas.svg')}}" type="image/x-icon" rel="shortcut icon" />
		<link href="{{asset('assets/pdv/img/ico-athenas.svg')}}" rel="apple-touch-icon" />
		<meta name="viewport" content="width=device-width, initial-scale=1">		
		<!--css-->
		
		<link rel="stylesheet" href="{{asset('assets/pdv/js/datatables/css/jquery.dataTables.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/pdv/js/datatables/css/responsive.dataTables.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/pdv/js/datatables/css/style_dataTable.css')}}">
		<link rel="stylesheet" href="{{asset('assets/pdv/css/auxiliar.css')}}">
		<link rel="stylesheet" href="{{asset('assets/pdv/css/grade.css')}}">
		<link rel="stylesheet" href="{{asset('assets/pdv/css/style.css')}}">
		
		<!--Css Componentes-->
		<link rel="stylesheet" href="{{asset('assets/componentes/css/style_Componente.css')}}">	
		<script src="{{asset('assets/pdv/js/jquery.min.js')}}"></script>	
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="{{asset('assets/pdv/js/jquery.hotkeys.js')}}"></script>	
		
		<script>
			var base_url 		= "{{asset('')}}";
			var base_url_imagem = "{{getEnv('APP_IMAGEM_PRODUTO')}}";
			var _token   		= "{{csrf_token()}}";
		</script>
	</head>

	<body class="site bodyPdv">
		@include("Pdv.cabecalho")
    	@include('inc.erros')
        @include('inc.msg')
        <div id="mostrarErros"></div>
        <div id="mostrarUmErro"></div>
        <div id="mostrarSucesso"></div>
    
		<section class="">      
            @yield("conteudo")    
            <!--CARREGA O GIRA GIRA-->
    <div class="window load" id="giragira">
    	<span class="text-load">Carregando...</span>
    </div>   
     	</section>      	
      
      
		
		@if(isset($vendaJs))
    		<script type="text/javascript" src="{{asset('assets/pdv/js/js_venda.js')}}"></script>
    	@endif
	
		@if(isset($vendaEditJs))
    		<script type="text/javascript" src="{{asset('assets/pdv/js/js_venda_edit.js')}}"></script>
    	@endif
    	
    	@if(isset($pagamentoJs))
    		<script type="text/javascript" src="{{asset('assets/pdv/js/js_pagamento.js')}}"></script>
    	@endif
    	
		<script src="https://kit.fontawesome.com/9480317a2f.js"></script>
		<script src="{{asset('assets/pdv/js/datatables/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/pdv/js/datatables/js/dataTables.responsive.min.js')}}"></script>
		
		<script src="{{asset('assets/pdv/js/jquery.mask.js')}}"></script>
	
    	<script src="{{asset('assets/componentes/js/js_data_table.js')}}"></script>	
    	<script src="{{asset('assets/componentes/js/js_modal.js')}}"></script>
    	<script src="{{asset('assets/componentes/js/js_util.js')}}"></script>
    	<script src="{{asset('assets/componentes/js/js_mascara.js')}}"></script>
    	<script src="{{asset('assets/componentes/js/upload.js')}}"></script>
			
		
		<script>
	      $(function() {
				$( "#tabs" ).tabs();
			});
		</script>
		<div id="fundo_preto11"></div>
    </body>
</html>