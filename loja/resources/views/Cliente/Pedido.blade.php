@extends("template_loja")
@section("conteudo")
<div class="col-12 produtos alt" style="margin-top: 0.5rem;">
				<div class="carrinho">
					<div class="titulo" style="border-top:0">						
						<div><span>Detalhes do pedido <i class="fas fa-angle-double-right"></i></span> </div>
					</div>
					<div class="rows mt-4">
						<div class="col-6 mb-3">
						<div class="tabela-responsiva">
							<table cellpadding="0" cellspacing="0" border="0" class="table">             
								<thead>
									<tr>
										<th align="center" width="10">Item</th>
										<th align="left"width="200">Titulo</th>
										<th align="center" width="100">Preço</th>
										<th align="center" width="50">Qtde</th>
										<th align="center" width="100">Total</th>
									</tr>
								</thead>
								<tbody>
								
								@if($pedido)
								@foreach($itens as $item)
							
									@php 
										$img = getenv("APP_IMAGEM_PRODUTO") .$item->produto->imagem;
									@endphp
															
									   <tr>
										<td align="center">
											<div class="thumb"><img src="{{$img}}" class="img-fluido"></div>																				
										</td>
										<td align="left"><span class="produto">{{$item->produto->nome}}</span></td>
										<td align="center">R$ {{$item->valor}}</td>
										<td align="center">{{$item->quantidade}} </td>
										<td align="center">R$ {{number_format($item->subtotal, 2)}} </td>
																				
									</tr>
									
								@endforeach 
								@endif														
                				</tr>
									
							   </tbody>
						 </table>
						</div>
						</div>
						<div class="col-6 mb-3">
							<div class="rows">
								<div class="col-12 mb-3 d-flex">
									<div class=" bg-title3 p-2 radius-4 width-100">
										<table cellpadding="0" cellspacing="0" border="0" class="table limpa" width="100%">             
											<thead>
												<tr>
													<th class="text-left border-bottom" colspan="2">Endereço</th>
												</tr>
											</thead>            
											<tbody>
											
												<tr><th class="text-left" style="font-size:.8rem" width="40">End.</th><td>{{$pedido->endereco->logradouro ?? null}} , {{ $pedido->endereco->numero ?? null}}</td></tr>
												<tr><th class="text-left" style="font-size:.8rem">Bairro.</th><td>{{$pedido->endereco->bairro ?? null }}</td></tr>
												<tr><th class="text-left" style="font-size:.8rem">Cidade.</th><td>{{$pedido->endereco->cidade  ?? null }}</td></tr>
												<tr><th class="text-left" style="font-size:.8rem">Cep.</th><td>{{$pedido->endereco->cep  ?? null }}</td></tr>
											</tbody>
										</table>
									</div>		
								</div>
								<div class="col-12 mb-3 d-flex">
								<div class=" bg-title3 p-2 radius-4 width-100">
									<table cellpadding="0" cellspacing="0" border="0" class="table limpa" width="100%">             
										<thead>
											<tr>
												<th class="text-left border-bottom" colspan="4">Total</th>
											</tr>
										</thead>            
										<tbody>
											<tr>
											<td class="text-left" style="font-size:.8rem">Itens. <b>{{count($itens)}}</b></td> 
											<td class="text-left" style="font-size:.8rem">Frete. <b class="text-vermelho">{{number_format($pedido->valor_frete, 2, ',', '.')}}</b></td>
											<td class="text-left" style="font-size:.8rem">Subtotal. <b>{{number_format($pedido->valor_venda, 2, ',', '.')}} </b></td>
											<td class="text-left" style="font-size:.8rem">Total. <b>{{number_format($pedido->valor_venda + $pedido->valor_frete, 2, ',', '.')}} </b></td>
											</tr>
										</tbody>
									</table>
								</div>		
								</div>
							</div>
						</div>
						
				</div>				
			</div>
			
			
		</div>
@endsection
	