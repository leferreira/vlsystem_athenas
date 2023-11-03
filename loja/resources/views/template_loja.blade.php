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
	</script>
	
	@isset($pagamentoJs)	
			<script>window.MP_PUBLIC_KEY = "{{$pedido->empresa->parametro->mercadopago_public_key ?? "" }}";	</script>			
	 @endisset	
	
</head>
<body>


	@include("cabecalho_loja")
	@include('inc.erros')
    @include('inc.msg')
    <div id="mostrarErros"></div>
    <div id="mostrarUmErro"></div>
    <div id="mostrarSucesso"></div>

@isset($banner)
    @if(count($lista_banner) > 0)
    @php $tem_banner = true; @endphp
        <div class="base-banner">
        	<div class="area">
        		<a id="prev" class="prevBtn qq" href="javascript:void(0)"></a>
        		<a id="next" class="nextBtn qq" href="javascript:void(0)"></a>
        		<div id="js" class="js">
        			<div class="box01">
            			@foreach($lista_banner as $ban) 
            			          			
            				@php $img_banner = getenv("APP_IMAGEM_PRODUTO") .$ban->path; @endphp       			
            			
            			@if($ban->produto_id)
            				<img onClick="location.href='{{route('produto.detalhe',$ban->produto_id)}}'" src="{{$img_banner}}" class="img-fluido">
            			@else
            				<img onClick="location.href='#'" src="{{$img_banner}}" class="img-fluido">
            			@endif
            			
            			@endforeach
        			</div>
        			<div id="jsNav" class="jsNav">
        				@foreach($lista_banner as $bn)		
        					<a class="trigger {{($bn->id==$ban->id) ? 'imgSelected' : '' }}" href="javascript:void(0)"><i class="fas fa-circle"></i> </a>
        				@endforeach        			
        			</div>
        		</div>
        	</div>
        </div>
    @endif
@endisset
<div class="produtos {{(isset($tem_banner)) ? '' : 'sem-banner'}}  {{($pag) ?? NULL}}">
	<div class="conteudo">
		<div class="rows">
			<div class="col-2">			
			<!---menu laterall-->
			@isset($mostraMenu)
				@include("menu_loja")
			@endisset
			<!---menu laterall-->
			</div>
			@yield("conteudo")
			
				<!--CARREGA O GIRA GIRA-->
    <div class="window load" id="giragira">
    	<span class="text-load">Carregando...</span>
    </div>
			
	</div>
</div>
</div>
        @isset($jsCarrinho)
            <script src="{{asset('assets/loja/js/carrinho.js')}}"></script>
        @endisset        
       
        
        @isset($jsProduto)
            <script src="{{asset('assets/loja/js/produtoJs.js')}}"></script>
        @endisset

		@include("rodape_loja")

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
		
		 @isset($pagamentoJs)
            <script src="https://sdk.mercadopago.com/js/v2"></script>

            <script type="text/javascript">
                const mp = new MercadoPago(MP_PUBLIC_KEY);
            </script>
            
            <script src="{{asset('assets/loja/js/pagamentoJs.js')}}"></script>
        @endisset
        
		  <!--Fundo Preto-->
<div id="fundo_preto"></div>

</body>
</html>