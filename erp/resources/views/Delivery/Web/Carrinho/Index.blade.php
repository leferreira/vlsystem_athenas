@extends("Delivery.Web.template")
@section("conteudo")
<div class="carrinho col-12">
<div class="base-detalhes">
	<div class="base-carrinho">
		<span class="etapas etapa01"></span>
		<span class="ttd">
		<small>CATEGORIA</small>
		<small>URSO PRINCÍPE</small>
		<small class="ativo">carrinho</small>
		</span>
		
		<div class="caixa-carrinho">
		<span class="titulo">Seu carrinho atual</span>
		
		<table cellpadding="0" cellspacing="0" border="0" class="tabela-border">             
			<thead>
				<tr>
					<th align="left" width="40%">itens</th>
					<th align="center">PREÇO</th>
					<th align="center">QUANTIDADE</th>
					<th align="center">total</th>
					<th align="center">Ação</th>
				</tr>
			</thead>
			<tbody>
			<?php $geral = 0; ?>
				@foreach($pedido->itens as $i)							
                   <tr>
					<td align="left">
						<div class="thumb"><img src="{{asset('assets/loja/upload/PANELA_LONGA.jpg')}}"></div>
						<h4 class="nomargin">{{$i->produto->nome}}</h4>
						<?php $total = $i->produto->valor * $i->quantidade; ?>
						<span>Adicionais: 
							@if(count($i->itensAdicionais)>0)
							@foreach($i->itensAdicionais as $a)
							<strong>{{$a->adicional->nome()}}</strong>
							<?php  $total += $i->quantidade * $a->adicional->valor ?>
							@endforeach
							@else
							<label>Nenhum adicional</label>
							@endif
						</span>

						@if($i->observacao != '')
						<br>
						<span>Observação: {{$i->observacao}}
						</span>
						@endif

						@if(count($i->sabores) > 0)
						<br>
						<span>Sabores: 
							@foreach($i->sabores as $key => $s)
							<strong>{{$s->produto->produto->nome}}</strong>
							{{($key+1 >= count($i->sabores) ? '' : '|')}}

							@endforeach
						</span><br>
						<span>Total de sabores: <strong>{{count($i->sabores)}}</strong></span>
						<span>| Tamanho <strong>{{$i->tamanho->nome()}}</strong></span>
						@endif
						<br>
						
					</td>
					@if(count($i->sabores) > 0)
					<?php 
						$maiorValor = 0; 
						$somaValores = 0;
						foreach($i->sabores as $it){
							$v = $it->maiorValor($it->produto->id, $i->tamanho_id);
							$somaValores += $v;
							if($v > $maiorValor) $maiorValor = $v;
						}


						if(getenv("DIVISAO_VALOR_PIZZA") == 1){
							$maiorValor = $somaValores/sizeof($i->sabores);
						}

						foreach($i->itensAdicionais as $a){
							$maiorValor += $a->adicional->valor;
						}
						$total = number_format($maiorValor * $i->quantidade, 2);
					?>
						<td align="center" data-th="Preço">R${{number_format($maiorValor, 2)}}</td>

					@else
					<td align="center" data-th="Preço">R${{number_format($total, 2)}}</td>
					@endif
					
					<td align="center">
					<input type="number" id="qtd_item_{{$i->id}}" value="{{(int)$i->quantidade}}" class="qtd"> </td>
					<td align="center">R$ {{number_format($total, 2, ',', '.')}} </td>
					<td align="center">
						<a href="javascript:;" onclick="atualizar({{$i->id}})" class="atualizar"></a>
						
						<a href="javascript:;" onclick="removeItem({{$i->id}})" class="excluir"></a>
					</td>
					
				</tr>
				<?php $geral += $total; ?>
               @endforeach 
               <tr class="visible-xs">
					<td class="text-center"><strong>Total {{number_format($geral, 2, ',', '.')}}</strong></td>
				</tr>            				
				<tr>					
                    <td align="left" colspan="3"><a href="{{route('delivery.web.home')}}" class="btn voltar">Continuar Comprando</a><a></a></td>                               
					<td align="right" colspan="2"><a href="{{route('delivery.web.carrinho.forma_pagamento')}}" class="btn">Finalizar Carrinho</a><a></a></td>  
										
				</tr>
				
		   </tbody>
     </table>
	 
	 
	<div class="rows">	
				
		
		 <div class="col-3" style="float:none; margin:0 auto">
		 	<form method="get" action="{{route('delivery.web.carrinho.checkout')}}">
                <input type="hidden" id="tp_frete" value="" name="tp_frete">
                <button class="btn finaliza">Finalizar Compra</button>
            </form>
		 </div>
									
			
		</div>
	 
	</div>
	        	
	</div>
	</div>
</div>

@endsection
	