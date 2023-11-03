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
				<legend class="h6 mb-0 p-1">Dados do pedido</legend>
				<div class="rows">
				
					<div class="col-8 mb-1">
						<span class="text-label">Nome</span><br>
						<span class="text-label">{{$pedido->cliente->nome }}</span>
					</div>
					<div class="col-4 mb-1">
						<span class="text-label">Celular</span><br>
						<span class="text-label">{{$pedido->cliente->celular}}</span>
					</div>
					<div class="col-5 mb-1">
						<span class="text-label">Endereço</span>
						<span class="text-label">{{$pedido->cliente->referencia}}</span>
					</div>
					<div class="col-5 mb-1">
						<span class="text-label">Referencia</span>
						<span class="text-label">{{$pedido->cliente->referencia}}</span>
					</div>					
					
					
				</div>
			</fieldset>	
			
			<fieldset class="scroll mb-1 border bg-branco p-2">
				<legend class="h6 mb-0 p-1">Endereço</legend>
				<div class="rows">	
					<div class="col-1 mb-1">
    					<a href="javascript:;" onclick="abrirModal('#addnovo')" class="btn btn-azul d-block" title="Adicionar novo"><i class="fas fa-plus-circle h6 mb-0"></i></a>
    				</div>					
				</div>			
				<div class="rows rows2">
					<div class="col radio">
						<label class="bg-normal p-1"><b>Balcão</b>
							<input type="radio" id="endereco_id_0" onclick="selecionarEndereco(null)" name="endereco" value="Null" {{($pedido->endereco_id==NULL) ? "checked" : ""}}>
						</label>
					</div>
					@foreach($pedido->cliente->enderecos as $e)
    					<div class="col radio">				
    						<label class="bg-normal p-1"><b>{{$e->rua}}, {{$e->numero}} - {{$e->bairro()}}</b>
    							<input type="radio" onclick="selecionarEndereco({{$e->id}})"  id="endereco_id_{{$e->id}}" {{($pedido->endereco_id == $e->id) ? "checked" : ""}} name="endereco" value="{{$e->id}}">
    						</label>
    					</div>	
					@endforeach
				</div>
				
			</fieldset>
			
			<fieldset class="scroll mb-1 border bg-branco p-2">	
				<legend class="h6 mb-0 p-1">Produto</legend>	
				<div id="tabs">
					<ul>
					@foreach($categorias as $c)
						@if(count($c->produtos)>0)
							<li><a href="#tabs-{{$c->id}}">{{$c->nome}} </a></li>
						@endif
					@endforeach
					</ul>
					
					@foreach($categorias as $c)
						@if(count($c->produtos)>0)
    					<div id="tabs-{{$c->id}}">
    						<div class="rows">
    						@foreach($c->produtos as $p)
    							<div class="col-3">
    								@if($p->produto->imagem)
    									<img src="{{asset('storage/upload/imagens_produtos/'. $p->produto->imagem)}}" class="img-fluido">
    								@else
    									<img src="{{asset('storage/upload/imagens_produtos/'. $p->produto->imagem)}}" class="img-fluido">
    								@endif
    								<span class="d-block text-center p-1 fw-600">{{$p->produto->nome}}</span>
    								<span class="d-block text-center pt-0 fw-600 pb-1" style="color: var(--blue-grey-400);">R$ {{$p->produto->valor_venda}}</span>
    								<a href="javascript:;" onclick="addItem({{$p->id}})" class="btn btn-azul btn-min">Inserir</a>
    							</div>
    						@endforeach	
    						</div>
    					</div>
    					@endif
					@endforeach					
					
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
			
			<div class="col-12">
		<form id="formPedido" method="post" name="formPedido" action="{{route('delivery.balcao.finalizar')}}">		
			@csrf
			<div class="border mt-1 p-1 din">
				<div class="cx-valor col-2">
					<strong class="text-label ">Taxa de Entrega</strong>
					<input type="text" id="taxa_entrega" name="taxa_entrega" value="{{$pedido->endereco_id != NULL ? $valorEntrega : 0 }}" class="form-campo valor text-azul" >
				</div>
				<div class="cx-valor col-2">
					<strong class="text-label ">Telefone</strong>
					<input type="text" id="telefone" name="telefone" value="{{$pedido->cliente->celular}}" class="form-campo valor text-vermelho" >
				</div>
				<div class="cx-valor col-2">
					<strong class="text-label ">Troco Para</strong>
					<input type="text" id="troco_para" name="troco_para" class="form-campo valor text-verde" >
				</div>
				<div class="cx-valor col-4">
					<strong class="text-label ">Observação</strong>
					<input type="text" id="observacao_pedido" name="observacao_pedido" class="form-campo valor text-verde" >
				</div>
							
				<div class="fim col">
					<input type="hidden" value="{{$pedido->id}}" name="pedido_id">					
					<button  id="btn-salvar" class="btn btn-gra-amarelo width-100" type="button" @if(!isset($pedido) || sizeof($pedido->itens) == 0) disabled @endif class="btn btn-lg btn-success">Salvar</button>
				</div>
			</div>
			</form>
			</div>
			</div>
			
			</div>
		</div>	
				
	</div>

</div>
</div>
	

<div class="window form" id="add">
<form action="{{route('delivery.balcao.inserirItem')}}" method="Post">
@csrf
	<div class="px-4 px-ms-4 width-100 d-inline-block">
		<span class="d-block text-center h4 mb-0 p-2">Adicionar Item</span>
		<div class="border mb-4 adicional">
			<div class="rows">
				<div class="col-4">
					<div class="thumb">		
						<img src="{{asset('storage/upload/imagens_produtos/pizza2.png')}}" class="img-fluido">
					</div>	
				</div>
				<div class="col-8">
					<div class="rows pt-2 border-left">		
						<div class="col-6">		
							<span class="text-label" >Produto</span>
							<strong class="text-label h6"id='nomeProduto'>Pizza 1</strong>
						</div>		
						<div class="col-3">		
							<span class="text-label">Valor</span>							
							<strong class="text-label h6" id='valorProduto'>39,00</strong>
						</div>	
						<div class="col-3">		
							<span class="text-label">Qtde</span>
							<input type="number" class="form-campo text-azul" value="1" name="quantidade" id="quantidade">							
						</div>
					</div>
					
					<div class="rows pt-2 pb-3 border-left">		
						<div class="col-12">		
							<span class="text-label" >Observação</span>
							<textarea class="form-campo valor text-azul" name="observacao"></textarea>
						</div>	
						
					</div>
					
					<div class="rows pt-2 border-top border-left pb-2">	
						<div class="col-12 mt-3">		
							<div class="caixa">		
								<strong class="text-label p-1 border-bottom bg-normal"><i class="fas fa-plus-circle"></i> Adicionar opicional</strong>
							
								<div class="rows rows2 py-1 px-2 scroll-130" id="lista_adicionais">									
									<div class="col-4 d-flex">
										<div class="bg-op p-1 width-100 d-block check"><label><b>aqui texto</b><input type="checkbox" name=""  ></label></div>
									</div>							
								</div>
						
							</div>	
						</div>	
						<input type="text" value="0" name="valor"  id="valor"/>
    					<input type="hidden" name="tamanho_pizza_id" id="tamanho_pizza_id">
    					<input type="hidden" name="sabores_escolhidos" id="sabores_escolhidos">
    					<input type="hidden" name="produto_id" id="produto_id">
    					<input type="hidden" value="{{$pedido->id}}" name="pedido_id">
    					<input type="hidden" name="adicioanis_escolhidos" id="adicioanis_escolhidos">	
						
					</div>	
				</div>
			</div>
		</div>
	</div>
	
	<div class="tfooter end">
		<a href="" class="fechar btn btn-neutro">Fechar</a>
		<input type="submit" class="btn btn-verde2" value="Inserir Item">
	</div>
	</form>
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



<div class="window medio" id="addnovo">
<form action="{{route('delivery.balcao.inserirEnderecoCliente')}}" method="post">
	<div class="px-4 px-ms-4 pb-3 width-100 d-inline-block">
		<span class="d-block text-center h4 mb-0 p-2">Adicionar Endereço</span>
			
		<div class="rows">				
			@csrf
					<input type="hidden" id="pedido_id" name="pedido_id" value="{{{ isset($pedido) ? $pedido->id : 0 }}}">
				
					<div class="col-9 mb-1">
						<span class="text-label">Rua</span>
						<input type="text" name="rua" value="" class="form-campo maior">
					</div>
					<div class="col-3 mb-1">
						<span class="text-label">Número</span>
						<input type="text" id="numero" name="numero"  class="form-campo maior">
					</div>
					@if($config->usar_bairros)
    					<div class="col-12 mb-1">
    						<span class="text-label">Bairro</span>
    						<select name="bairro_id" class="form-campo maior">
    							@foreach($bairros as $b)
    								<option value="{{$b->id}}">{{$b->nome}} R$ {{$b->valor_entrega}}</option>  
    							@endforeach  							
    						</select>
    					</div>
    				@else
    					<div class="col-12 mb-1">
    						<span class="text-label">Bairro</span>
    						<input type="text" name="bairro" id="bairro" class="form-campo maior">
    					</div>
					@endif
					
					<div class="col-12 mb-1">
						<span class="text-label">Referência</span>
						<input type="text" id="referencia" name="referencia" value="" class="form-campo maior">
					</div>
				
					
				</div>		
	</div>
	<div class="tfooter end">
		<a href="" class="fechar btn btn-neutro">Fechar</a>
		<input type="submit" class="btn btn-gra-amarelo" value="Salvar">
	</div>
</form>	
</div>


<div id="fundo_preto"></div>	
	
		
		
@endsection
	