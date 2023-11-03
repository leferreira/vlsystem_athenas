@extends("Delivery.Balcao.template")
@section("conteudo")


<div class="col-12 m-auto">			
<div class="pedido border p-1 radius-4 bg-branco">		
	<div class="error">   
	<ul>   
		@foreach($errors->all() as $error)     
		<li>{{ $error }}</li>  
		 @endforeach   
		</ul> 
	</div>
	
	<div class="rows">	
		<div class="col-12">		
			<div class="p-0">		
			<div class="rows">		
			<div class="col-9">		
			
			
			<fieldset class="scroll mb-1 border bg-branco p-2">	
				<legend class="h6 mb-0 p-1">Dados do Cliente</legend>
				<div class="rows">
				
					<div class="col-8 mb-1">
						<span class="text-label">Nome: {{$pedido->cliente->nome }}</span>
					</div>
					<div class="col-4 mb-1">
						<span class="text-label">Celular: {{$pedido->cliente->celular}}</span>
					</div>
					@if($pedido->endereco_id)
    					<div class="col-5 mb-1">
    						<span class="text-label">Endereço: {{$pedido->endereco->rua}}, {{$pedido->endereco->numero}}</span>
    						
    					</div>
    					<div class="col-5 mb-1">
    						<span class="text-label">Bairro: {{$pedido->endereco->bairroComValor()}}</span>
    						
    					</div>	
    					<div class="col-5 mb-1">
    						<span class="text-label">Referência: {{$pedido->endereco->referencia}}</span>
    						
    					</div>
    				@else
    					<div class="col-5 mb-1">
    						<span class="text-label">Endereço: Balcão </span>    						
    					</div>			
					@endif
					
				</div>
			</fieldset>	
		
		<fieldset class="scroll mb-1 border bg-branco p-2">	
				<legend class="h6 mb-0 p-1">Dados do Pedido</legend>
				<div class="rows">
				
					<div class="col-3 mb-1">
						<span class="text-label">Pedido Núm:: {{$pedido->id }}</span>
					</div>
					<div class="col-3 mb-1">
						<span class="text-label">Horário: {{ \Carbon\Carbon::parse($pedido->data_registro)->format('H:i:s')}}</span>
					</div>
					
					<div class="col-3 mb-1">
						<span class="text-label">Status: {{$pedido->status->status}}</span>    						
					</div>
					<div class="col-3 mb-1">
						<span class="text-label">Total Geral: {{number_format($pedido->valor_total,2 , ',', '.')}}</span>
					</div>	
					<div class="col-3 mb-1">
						<span class="text-label">Valor de Entrega: {{number_format($pedido->calculaFrete(), 2 , ',', '.')}}</span>
					</div>
					<div class="col-3 mb-1">
						<span class="text-label">Total de Itens: {{count($pedido->itens)}}</span>
					</div>
					<div class="col-3 mb-1">
						<span class="text-label">Forma de Pagamento: {{strtoupper($pedido->forma_pagamento)}}</span>
					</div>
					@if($pedido->troco_para > 0)
					<div class="col-3 mb-1">
						<span class="text-label">Troco Para: {{$pedido->troco_para}}</span>
					</div>
					@endif
					
					@if($pedido->observacao != '')
					<div class="col-12 mb-1">
						<span class="text-label">Observação: {{$pedido->observacao}}</span>
					</div>
					@endif
    			
    			
					
				</div>
			</fieldset>	
			
	
			
			<div class="scroll-130 border bg-normal px-0">		
				<table class="tabela" width="100%" cellpadding="0" cellspacing="0">
					<thead>
						<tr> 
                			<th align="center">Cód.</th>
                			<th align="center">Produto</th> 									  
                			<th align="center">Tamanho Pizza</th> 									  
                			<th align="center">Sabores</th> 									  
                			<th align="center">Adicionais</th> 	
                			<th align="center">Status</th> 
                			<th align="center">Quantidade</th> 
                			<th align="center">Subtotal+adicional</th> 
                			<th align="center">Observação</th> 
                			<th align="center">Ações</th>								  
                		</tr>
					</thead>
						<?php $finalizado = 0; $pendente = 0; ?>
						<?php $soma = 0; ?>
						@if(isset($pedido))
						<tbody>
						@foreach($pedido->itens as $i)
						<?php $temp = $i; ?>
							<tr class="bg-branco"> 
								<td align="center">1</td>
								<td align="center">{{$i->produto->produto->nome}}</td> 									  
								<td align="center">
									@if(!empty($i->tamanho))
										<label>{{$i->tamanho->nome}}</label>
									@else
										<label>--</label>
									@endif
								</td> 									  
								<td align="center">
								@if(count($i->sabores) > 0)
									<label>
										@foreach($i->sabores as $key => $s)
										{{$s->produto->produto->nome}}
										@if($key < count($i->sabores)-1)
										| 
										@endif
										@endforeach
									</label>
									@else
									<label>--</label>
									@endif
								</td> 									  
								<td align="center">
								<span class="codigo" style="width: 100px;">
									<?php $somaAdicionais = 0; ?>
									@if(count($i->itensAdicionais) > 0)
									<label>
										@foreach($i->itensAdicionais as $key => $a)
										{{$a->adicional->nome()}}
										<?php $somaAdicionais += $a->adicional->valor * $i->quantidade?>
										@if($key < count($i->itensAdicionais)-1)
										| 
										@endif
										@endforeach
									</label>
									@else
									<label>--</label>
									@endif
								</span>
								
								</td> 
								<td align="center">
    								<span class="codigo" style="width: 100px;">
    									@if($i->status)
    									<span class="label label-xl label-inline label-light-success">OK</span>
    									@else
    									<span class="label label-xl label-inline label-light-danger">PENDENTE</span>
    									@endif
    								</span>								
								</td>
								<?php 
									$valorVenda = 0;
									$valorVenda = $i->valorProduto();
									?>
									<?php $soma += $i->quantidade * $valorVenda; ?>
										
								<td align="center">
									<span style="width: 100px;">
										{{$temp->quantidade}}
									</span>
								</td> 									  
								<td align="center">
									<span style="width: 100px;">
										{{number_format((($valorVenda * $i->quantidade)), 2, ',', '.')}}
									</span>
								</td> 									  
								<td align="center">
									<span class="codigo" style="width: 100px;">
										<a href="#!" onclick='swal("", "{{$i->observacao}}", "info")' class="btn btn-light-info @if(!$i->observacao) disabled @endif">
											Ver
										</a>
									</span>
											
								</td> 									  
								<td align="center">
									<span class="codigo" style="width: 180px;">
										<a onclick='swal("Atenção!", "Deseja excluir este registro do pedido?", "warning").then((sim) => {if(sim){ location.href="/pedidosDelivery/deleteItem/{{$i->id}}" }else{return false} })' href="#!" class="btn btn-danger">
											<i class="la la-trash"></i>				
										</a>

									</span>
								</td> 									  
							</tr>
							<?php 
								if($i->status) $finalizado++;
								else $pendente++;
								?>
									
							@endforeach
						</tbody>
						@endisset
				</table>
			</div>
				<h3>TOTAL: <strong class="text-info">R$ {{number_format($soma, 2)}}</strong></h3>
			</div>
			
		<div class="col-3 d-flex">		
			<div class="caixa">		
				<div class="thumb">		
					<img src="{{asset('storage/upload/imagens_produtos/pizza2.png')}}" class="img-fluido">
				</div>
				<span class="tt" >Pizza 1</span>
				<span class="tt2" >Valor: 19,90</span>
				<div class="botoes border-top alt">
					<a href="javascript:;" onclick="abrirModal('#add')" class="btn btn-azul2"><i class="fas fa-plus-circle"></i> Adicional</a>
					<a href="index.php?link=1" class="btn btn-verde2 d-block"><i class="fas fa-arrow-left"></i> Novo</a>
				</div>
			</div>
		</div>	
			
			
			</div>
			
			</div>
		</div>	
				
	</div>

</div>
</div>
	





<div class="window menor" id="novo">
	<div class="px-4 px-ms-4 pb-3 width-100 d-inline-block">
		<span class="d-block text-center h4 mb-0 p-2">Adicionar nova categoria</span>
		<span class="text-label">Nome</span>
		<input type="text" class="form-campo p-2 mb-3">
		
	</div>
	<div class="tfooter end">
		<a href="" class="fechar btn btn-neutro">Fechar</a>
		<input type="submit" class="btn btn-gra-amarelo" value="Adicionar">
	</div>
</div>




<div id="fundo_preto"></div>	
	
		
		
@endsection
	