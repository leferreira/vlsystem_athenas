@extends("Delivery.Web.template")
@section("conteudo")
<div class="conteudo">
<div class="detalhe-prod">    		
<div class="rows">
<div class="col-12">
<div class="base-detalhes">
	<span class="ttd"><small>CATEGORIA</small><small class="ativo">Cuscuzeira Laranja</small></span>
	<div class="rows caixa-produto">
	<div class="col-4">
		<div class="caixa-prod">
			<img src="{{ asset($produto->imagem)}}">
		</div>
		<div class="rows min-thumbs">         
             				
		</div> 
	</div>
	<div class="col-8">
		<div class="caixa-titulo">
			<h1>{{$produto->nome}}</h1>
			
		</div>
		<div class="caixa-del rows">	
		<div class="col-6">
					<div class="caracteristicas">
					<span span="" class="ttd">Descrição</span>
					<p>{{$produto->descricao}} </p>
					
					<span class="ttd">Ingredientes</span>
					<p>{{$produto->ingredientes}}</p>
							
				</div>
			</div>
					
			<div class="col-6">				
				R$ <span class="preco" id="valor_produto">{{$produto->valor_venda}}</span><br>				
				
                <form method="post"  action="{{route('delivery.web.carrinho.add')}}">
                    @csrf
                    
                    Qtde: <input type="number" name="quantidade" id="quantidade" value="1" class="form-campo"><br>
                    Observação: <input type="text" name="observacao" id="observacao"  class="form-campo"><br>
                                                               
                    <input type="hidden" name="preco" value="100"> 
                    <button onclick="adicionar()" type="button" class="btn btn-warning btn-lg btn-block">
						<span class="fa fa-cart-plus mr-2"></span> ADICIONAR 
					</button>					                                          
					
					
					<input type="hidden" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="produto_id" id="produto_id" value="{{$produto->id}}">
					<input type="hidden" id="whats_delivery" value="{{ getenv('WHATSAPP_DELIVERY') }}">
					<input type="hidden" id="total_init" value="{{ $produto->valor }}">
					<input type="hidden" id="maximo_adicionais" value="{{$config->maximo_adicionais}}" name="">
					<input type="hidden" value="{{json_encode($adicionais)}}" id="adicionais" name="">
					<input type="hidden" value="{{json_encode($categorias)}}" id="categorias" name="">
                </form> 
                <span class="tt3">Total: <strong id="valor_total">{{$produto->valor}}</strong> </span>
			</div>
					
			<div class="col-6">
			@foreach($categorias as $key => $c)
					<div class="caracteristicas">
					<span span="" class="ttd">{{$c->nome}}</span>
					@foreach($c->adicionais as $a)
    					@if(in_array($a->id, $adicionaisTemp))
    					<div class="col-12">
    
    						<input id="sl_{{$a->id}}" value="{{$a}}" class="select-add" type="checkbox" name="">
    						<label>{{$a->nome}} 
    							@if($a->valor > 0)
    							- R$ {{number_format($a->valor, 2, ',', '.')}}
    
    							@endif
    						</label>
    					</div>
    					@endif
					@endforeach
							
				</div>
			@endforeach
			</div>		
			
		</div>
		
		
	</div>
	</div>
</div>
</div>



</div>
</div>
</div>
@endsection
	