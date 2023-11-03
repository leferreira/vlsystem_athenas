@extends("template_loja")
@section("conteudo")
<div class="col-12">
				<div class="carrinho">
					<div class="d-block pb-3">						
						<div class="broad"><span><img src="{{asset('assets/loja/img/etapas.png')}}" class="img-fluido m-auto d-block"></span></div>
					</div>
					<div class="titulo" style="border-top:0">						
						<div><span>Meu carrinho <i class="fas fa-angle-double-right"></i></span></div>
						<div><small class="h6 mb-0 fw-100 text-cinza">Home <i class="fas fa-angle-double-right text-escuro"></i> Camiseta <i class="fas fa-angle-double-right text-escuro"></i> Carrinho </small></div>
					</div>
					<div class="rows">
						<div class="col-12">
						<div class="tabela-responsiva">
							<table cellpadding="0" cellspacing="0" border="0" class="table">             
								<thead>
									<tr>
										<th align="center" width="48">Item</th>
										<th align="left"width="200">Titulo</th>
										<th align="center" >Preço</th>
										<th align="center" >Qtde</th>
										<th align="center" >Subtotal Líquido</th>
										<th align="center" >Ação</th>
									</tr>
								</thead>
								<tbody>
						
							@if($carrinho)
							@foreach($itens as $item)	
							<?php $total = $item->valor * $item->quantidade; ?>	
									@php 
										$img = getenv("APP_IMAGEM_PRODUTO") .$item->produto->imagem;
									@endphp
													
								   <tr>
										<td align="center">
											<div class="thumb"><img src="{{asset($img)}}" class="img-fluido"></div>																				
										</td>
										<td align="left"><span class="produto"><a href="{{route('produto.detalhe', $item->produto->id)}}">{{$item->produto->nome}}</a></span></td>
										<td align="center">
										@if($item->cupom_desconto_id)
											<div class="mr-3">
        										<small> R$ {{number_format($item->valor - $item->desconto_por_unidade, 2)}}</small> <br>
        										<strong class="text-vermelho" style="opacity: .6;"><strike>R$ {{number_format($item->valor,2,",",".")}} </strike></strong>
        									</div>
										@else
											R$ {{number_format($item->valor, 2)}} 
										@endif
										</td>
										<td align="center"><input type="number" id="qtd_item_{{$item->id}}" value="{{$item->quantidade}}" class="form-campo"> </td>
										<td align="center">R$ {{number_format($item->subtotal_liquido, 2)}} </td>
										<td align="center">
											<a href="javascript:;" onclick="refresh({{$item->id}})" class="icoAcao atualizar" title="Atualizar"><i class="fas fa-redo-alt"></i></a>
											<a href="javascript:;" onclick="removeItem({{$item->id}})"  class="icoAcao excluir" title="Excluir produto"><i class="fas fa-trash-alt"></i></a>
										</td>										
									</tr>
									
								@endforeach 
								@endif														
                				</tr>
										
							   </tbody>
						 </table>
						</div>
						</div>
						<div class="col-6 mt-3 d-flex">
							<div class="border caixa width-100">
								<table cellpadding="0" cellspacing="0" border="0" class="table"> 
									<thead>
										<th colspan="4"><h3>Aplicar código de cupom</h3></th>
									</thead>			
									<tbody>
									<tr>
										<td align="center" colspan="3">
											<form method="POST" action="{{route('carrinho.aplicarCupom')}}" >
											@csrf
												<div class="rows">                                                                       
													<div class="col">
														<div class="grupo-form-btn">
															<input type="hidden" name="pedido_id" value="{{$carrinho->id}}">
															<input type="text" name="codigo_cupom" placeholder="Digite o código" class="form-campo">
															<input type="submit" value="APLICAR" class="btn btn-verde">
														</div>
													</div>
													
												</div>
											</form>
										</td>
										
									</tr>
								  <tr>
								 @if($cupom) 
								  <td>
										
										<div class="cupomaplicado mr-3">
											<small>O código de cupom <b>{{$cupom->codigo}}</b> foi aplicado <a href="{{route('excluirCupom', $carrinho->id)}}">Excluir</a></small>
										</div>
										
									</td>
    								@endif	
    								</tr>
									
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-6 mt-3 d-flex">
						<div class="border caixa width-100">
								<div class="caixa">
                    			<table cellpadding="0" cellspacing="0" border="0" class="table"> 
                    							<thead>
                    								<th colspan="4"><h3>Carrinho Total</h3></th>
                    							</thead>			
                    							<tbody>
                    							<tr>								
                    								<th class="linhas  border-right" width="190">
                    									<span class="tt1">Subtotal</span>
													</th>
													<td>
                    									<span class="tt2"><span class="result text-vermelho">{{number_format($carrinho->valor_venda, 2, ',', '.')}}</span></span>
                    								</td>
												</tr>											
												<tr>								
                    								<th class="linhas  border-right" width="190">
                    									<span class="tt1">Desconto</span>
													</th>
													<td>
                    									<span class="tt2"><span class="result text-vermelho">{{number_format($carrinho->valor_desconto_cupom, 2, ',', '.')}}</span></span>
                    								</td>
												</tr>
												
												<tr>								
                    								<th class="linhas  border-right" width="190">
                    									<span class="tt1">Frete</span>
													</th>
													<td>
                    									<span class="tt2"><span class="result text-vermelho">{{number_format($carrinho->valor_frete, 2, ',', '.')}}</span></span>
                    								</td>
												</tr>
												
												<tr>
                    								<th class="linhas border-right">
                    									<span class="tt1">Total</span>
													</th>
													<td>
                    									<span class="tt2"><span class="result fw-600 text-verde">{{number_format($carrinho->valor_liquido, 2, ',', '.')}}</span></span>
                    								</td>                 								
                    								
                    							</tr>   
                    							
                    						</tbody>
                    				</table>
                    			</div>								
							</div>
						</div>
						
						<div class="col-12 mt-4 mb-4 text-center">
							<form method="get" action="{{route('checkout')}}">
                                <input type="hidden" id="tp_frete" value="" name="tp_frete">
                                <button class="btn btn-grande btn-vermelho d-inline-block"><i class="fas fa-check"></i> Finalizar Compra</button>
                            </form> 
						</div>

				</div>				
			</div>
			
			
		</div>
@endsection


	