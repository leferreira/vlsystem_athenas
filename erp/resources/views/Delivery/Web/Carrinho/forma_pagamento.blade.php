@extends("Delivery.Web.template")
@section("conteudo")

<style type="text/css">

.pulsate {
	-webkit-animation: pulsate 3s ease-out;
	-webkit-animation-iteration-count: infinite; 
	opacity: 0.5;
}
@-webkit-keyframes pulsate {
	0% { 
		opacity: 0.5;
	}
	50% { 
		opacity: 1.0;
	}
	100% { 
		opacity: 0.5;
	}
}
#map{
	width: 100%;
	height: 500px;
	background: #999;
}

.margin{
	margin-top: 10px;
}



@media only screen and (max-width: 400px) {
	#endereco-modal{
		width: 100%; height: 100%; margin-left: 0px;
	}

	.modal-body { height: 500px; margin-left: 0px;}
	.popup{
		margin-left: 0px;
	}
}
@media only screen and (min-width: 401px) and (max-width: 1699px){
	#endereco-modal{
		width: 100%;
	}

	.modal-body{
		height: 600px;
		overflow-y: auto;
		width: 380px;
		margin-left: 0px;

	}

}


</style>

<div class="conteudo">
<div class="base-prod-home">
<div class="carrinho">
<div class="base-detalhes">
	<div class="base-carrinho">
			<span class="etapas etapa02"></span>
			<span class="ttd">
			<small>CATEGORIA</small>
			<small>URSO PRINCÍPE</small>
			<small class="ativo">carrinho</small>
			</span>
				
	 <div class="caixa-carrinho">
	<dl> 					  
				 <div class="caixa-entrega mb-1">
					<span class="titulo mb-4">Escolha a Forma de pagamento</span>
					
					<div class="rows formulario">
					<dt><a href=""><i class="ico ipagseguro"></i><span>Selecione seu Endereço</span></a></dt>
					
				<input type="hidden" id="_token" value="{{ csrf_token() }}">
				<input type="hidden" id="cliente_id" value="{{$cliente->id}}">
				<input type="hidden" id="lat_padrao" value="{{getenv('LATITUDE_PADRAO')}}">
				<input type="hidden" id="lng_padrao" value="{{getenv('LONGITUDE_PADRAO')}}">
				<input type="hidden" id="usar_bairros" value="{{$usar_bairros}}">
				
				<input type="hidden" id="pedido_id" value="{{$pedido->id}}">
				<input type="hidden" id="total-init" value="{{$total}}">
			
			
				<dd style=""><h3>Informações de Pagamento</h3>
							<span class="titulo-m">Preencha os campus com os dados do titular do cartão</span>
								<div class="rows">								
					@foreach($enderecos as $e)
        				<div class="col-lg-4 col-md-6" onclick="set_endereco({{$e->id}})">        
        					<div id="endereco_select_{{$e->id}}" class="card border-0 med-blog">
        
        						<div class="card-body border border-top-0">
        							<h5 class="blog-title card-title m-0">
        								{{$e->rua}}, {{$e->numero}}
        							</h5>
        							<h5>{{$e->bairro}}</h5>
        							<p>Referencia: {{$e->referencia}}</p>
        						</div>
        					</div>
        				</div>        
        				@endforeach
        				
        				<div class="col-lg-4 col-md-6" onclick="set_endereco('balcao')">
    					<div id="endereco_select_balcao" class="card border-0 med-blog">
    
    						<div class="card-body border border-top-0">
    							<h5 class="blog-title card-title m-0">
    								Retirar no Balcão
    							</h5>
    
    						</div>
    					</div>
    				</div>
					</div>
						<div class="rows">	
							<div class="form-group">
                			<div class="col-lg-4 col-md-6 col-10">
                				<label class="mb-2">Celular para contato</label>
                				<input type="text" value="{{$ultimoPedido != null ? $ultimoPedido->telefone : $cliente->celular}}" class="form-control" id="telefone" required="">
                			</div>
                		</div>

            		<div class="form-group">
            			<div class="col-lg-12 col-md-12 col-12">
            				<label class="mb-2">Observação do Pedido (opcional)</label>
            				<input type="text" class="form-control" id="observacao" required="">
            			</div>
            		</div>
            
            		<br>
            		<div class="form-group">
            			<div class="col-lg-4 col-md-4 col-8">
            				<label style="color: red" class="mb-2">Cupom de Desconto (opcional)</label>
            				<input type="text" class="form-control" id="cupom" value="{{$cupom > 0 ? $cupom : ''}}" required="">
            			</div>
            		</div>
            		<div id="desconto" style="display: none" class="col-lg-4 col-md-4 col-8">
            			<h4>Valor do cupom: <strong style="color: green" id="valor-cupom"></strong></h4><br>
            		</div>
            
            		<div id="cupom-invalido" style="display: none" class="col-lg-4 col-md-4 col-8">
            			<h4 style="color: red">Cupom inválido</h4><br>
            		</div>
		
		
		
							<div class="col-12 mt-4  text-center">
							<a href="#gal2" id="novo-endereco" class="btn btn-success btn-lg">Novo Endereço</a>
							</div>	
					</div>
					
					<a href="#!" type="button" id="finalizar-venda" class="btn btn-success btn-lg btn-block">
                		<span class="fa fa-check mr-2"></span> FINALIZAR <strong id="total"></strong>
                	</a>
                </dd>
					</div>	
					</div>				
				
				
				<div class="caixa-entrega  mb-1">
						<div class="rows formulario">
						<dt><a href=""><i class="ico ideposito"></i><span>Forma de Pagamento</span></a></dt>
							<dd >
							<h3>Pagamento via depósito ou transferencia</h3>
							<span class="titulo-m">Escolha uma das contas disponíveis abaixo para transferencia ou deposito</span>
							
								<div class="rows">
									<section class="blog_w3ls py-5">
		<div class="container pb-xl-5 pb-lg-3">
			<div class="title-section text-center mb-md-5 mb-4">
				<h3 class="w3ls-title mb-3">Forma de Pagamento</h3>

			</div>
			<div class="container">

				<fieldset class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-check">

								<input class="form-check-input" type="radio" name="gridRadios" id="maquineta" value="maquineta">
								<label class="form-check-label" for="maquineta">
									Maquina de cartão Crédito/Débito
								</label>

							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="gridRadios" id="dinheiro" value="dinheiro">
								<label class="form-check-label" for="dinheiro">
									Dinheiro
								</label>

								<div id="div_do_troco" style="display: none" class="form-group">
									<label class="mb-2">Troco Para</label>
									<div class="col-sm-3">
										<input type="text" placeholder="Ex:  {{ $total%10 == 0 ? $total : ((int)($total/10) +1)*10}},00" class="form-control" id="troco_para">

									</div>
								</div>
							</div>

							@if($pagseguroAtivado == true)
							<div class="form-check">
								<input class="form-check-input" type="radio" name="gridRadios" id="pagseguro" value="pagseguro">
								<label class="form-check-label" for="debito">
									Cartão de Crédito
								</label>

							</div>
							@endif

						</div>
					</div>
				</fieldset>

			</div>

		</div>
	</section>
									
								</div>
								<div class="mt-3 col-12  text-center">
									<a href="index2.php?link=4" class="btn deposito">Finalizar compra</a>
								</div>
							</dd>
						</div>	
				</div>	
															
				</dl></div>			 
		
			</div>
		 
			
	</div>
</div>
</div>
</div>

	
	
	
	<div id="gal2" class="pop-overlay">
	<div id="endereco-modal" class="popup">

		<div id="info-mapa">
			<p>Deslize o pino até sua localização!</p>
			<div id="map">	
			</div>
			<a style="color: #fff" id="btn-end-map" class="btn btn-success btn-block mb-4">Pronto</a>
		</div>

		<div id="form-endereco" style="display: none">
			
			<a style="color: #fff" id="abrir-mapa" class="btn btn-success btn-block mb-4">Abrir Mapa</a>



			<input type="hidden" id="_token" value="{{ csrf_token() }}">
			<input type="hidden" id="cliente_id" value="{{$cliente->id}}">
			
			<div class="form-group">
				<label>Rua</label>
				<input type="text" class="form-control fr" id="rua" placeholder="" required="">
			</div>

			<div class="form-group">
				<label class="mb-2">Número</label>
				<input type="text" class="form-control fr" id="numero" required="true">
			</div>


			@if($usar_bairros == 1)

			<div class="form-group">
				<label class="mb-2">Bairro</label>
				<select id="bairro" class="form-control">
					<option value="" disabled selected hidden>Selecione o bairro...</option>
					@foreach($bairros as $b)
					<option value="id:{{$b->id}}">{{$b->nome}} - R$ {{number_format($b->valor_entrega, 2)}}</option>
					@endforeach
				</select>
			</div>

			@else
			<div class="form-group">
				<label class="mb-2">Bairro</label>
				<input type="text" class="form-control fr" id="bairro" required="true">
			</div>
			@endif

			<div class="form-group">
				<label class="mb-2">Referencia ou apartamento</label>
				<input type="text" class="form-control fr" id="referencia" required="">
			</div>
			<a href="#!" id="salvar_endereco" class="btn btn-danger btn-block mb-4 disabled">Salvar</a>


		</div>
		<a class="close" href="#!">×</a>
	</div>
</div>

@endsection
	