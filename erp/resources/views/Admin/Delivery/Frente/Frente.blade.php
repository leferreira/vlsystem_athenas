@extends("templates.template_admin")
@section("conteudo")

<style type="text/css">
	.ativo{
		background-color: #55C6BD;
		color: #fff;
	}
	.desativo{
		background-color: #EBEDF3;
		color: #000;
	}
	.img-prod{
		height: 120px;
		border-radius: 50%;
		margin-top: 5px;
		margin-left: auto;
		margin-right: auto;
		display: block;
	}
	#atalho_add:hover{
		cursor: pointer;
	}
</style>

<div class="col-9 central mb-3">                      

   <div id="tab">
	  <div id="tab-2">
		<div class="p-2">
			<div class="rows">
			
			<div class="col-12">
            <div class="rows">
            <div class="col-12">
				<div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
                <span class="d-flex center-middle">	<i class="fas fa-search mr-1"></i> Dados do Pedido: {{$pedido->id}}	</span>
				<a href="{{route('frentedelivery.index')}}" class="btn btn-verde btn-pequeno float-right "><i class="fas fa-arrow-left mb-0"></i> Voltar</a>
				</div>
                    <div class="py-4 px-4">
                        <div class="rows text-escuro">	
                        			<div class="col d-flex">
                                            <div class="px-3 py-4 border radius-4 width-100">
                                                    <i class="fas fa-calendar-alt pequeno-font float-left mr-1 text-padrao"></i>
                                                    <small>Data</small>
                                                    <h4>{{dataHoraBr($pedido->data_pedido)}}</h4>
                                            </div>
                                       </div>
                                       									
										<div class="col-3 px-1 d-flex">
												<div class="px-3 py-4 border radius-4 width-100">
                                                <i class="fas fa-users pequeno-font float-left mr-1 text-padrao"></i>
                                                <small>Nome do Cliente</small>
                                                <h4 style="line-height:1rem">{{$pedido->cliente->nome}}</h4>
                                        </div>
										</div>
                                       
                                    
                                       
                                       <div class="col d-flex">
                                            <div class="px-3 py-4 border radius-4 width-100">
													<i class="fas fa-map-marker-alt  pequeno-font float-left mr-1 text-padrao"></i>
                                                    <small>Fone:</small>
                                                <h4 style="line-height:1rem">{{$pedido->telefone}}</h4>
                        							
                                            </div>
                                       </div>
						</div>
                    </div>
            </div>
        </div>
    </div>
			
			
					
			<div class="col-12">
                <div class="caixa">                    
                        
                        <div class="px-2 pt-2">
							  <div class="border mt-2 p-2 radius-4">
							  <form action="{{route('frentedelivery.inserirProduto')}}" method="POST">
							  @csrf
							  <div class="rows">
							  			<div class="col-4">	
                                            <label class="text-label d-block ">Produto</label>
                                            <select id="produto_id" name="produto_id" class="form-campo">
												<option value="">Selecione o Produto</option>
											@foreach($produtos as $p)
												<option value="{{$p->id}}">{{$p->id}} - {{$p->produto->nome}} - R$ {{number_format($p->valor, 2, ',', '.')}}</option>
											@endforeach	
											</select>
                                        </div> 
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Qtde</label>
                                            <input type="text" name="quantidade" id="quantidade" value="1" class="form-campo">
                                        </div>  
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Valor</label>
                                            <input type="text" name="preco"  id="preco" class="form-campo">
                                        </div> 
                                        <div class="col-3">	
                                            <label class="text-label d-block ">Observação</label>
                                            <input type="text" name="observacao" id="observacao" value="1" class="form-campo">
                                        </div>                                 
                                        
                                        <div class="col-1 mt-1">
                                        	<input type="hidden" name="pedido_id" value="{{$pedido->id}}" >
                                        	<input type="hidden" name="status" value="0" >
                                       	 	<input type="submit"  value="ADD" class="btn btn-roxo text-uppercase">
                                        </div>
                                         <div class="col-1 mt-1" id="btn-add-adicional">
                                        	<a style="margin-top: 11px;" id="add-pag" class="btn btn-roxo text-uppercase">
														+
											</a>
                                        </div>                                    
                                        
                                </div>
                                </form>
                                </div>
                        </div>
                  
                </div>
                </div>
             
            
            <input type="hidden" name="tamanho_pizza_id" id="tamanho_pizza_id">
			<input type="hidden" name="sabores_escolhidos" id="sabores_escolhidos">
			<input type="hidden" name="adicioanis_escolhidos" id="adicioanis_escolhidos">
										
										
										 
             <div class="col-12">
                <div class="caixa">                    
                        
                        <div class="px-2 pt-2">
							  <div class="border mt-2 p-2 radius-4">
							  <div class="rows">
							  		@foreach($adicionais as $a)
							  			<div class="col-3">	                                           
                                            <input type="checkbox" name="adicional_{{$a->id}}" id="adicional_{{$a->id}}"  class="form-campo">{{$a->nome}}
                                        </div>
							  		@endforeach 
                                 </div>
                                </div>
                        </div>
                  
                </div>
                </div>
             
                
                
         
         
            <div class="col-12 px-4">
       <form action="{{ route('pedidoloja')}}" method="Post">
       @csrf
                    <div class="caixa border radius-4">
					<span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Itens do Pedido</span>
                    <div class="tabela-responsiva">
                            <table cellpadding="0" cellspacing="0" class="table-bordered">
                                    <thead>
                                            <tr>
                                                    <th align="center">#</th>
                                                    <th align="left">Produto</th>
                                                    <th align="center">Qtde</th>
                                                    <th align="center">Sabores</th>                                                       
                                                    <th align="center">Valor Unit</th>
                                                    <th align="center">Status</th>
                                                    <th align="center">Adicionais</th>
                                                    <th align="center">SubTotal</th>
                                                    <th align="center">SubTotal + Adicional</th>
                                                    <th align="center">Ações</th>
                                                    
                                            </tr>
                                    </thead>
                                    <tbody>
                                  @foreach($pedido->itens as $i)       
                                    <tr>
                                            <td align="center">{{$i->id}}</td>	
                                            <td align="left">{{$i->produto->produto->nome}}</td>
                                            <td align="center">{{$i->quantidade}}</td>
                                            <td align="center"><span class="codigo" style="width: 100px;" id="id">
													@if(count($i->sabores) > 0)
													@foreach($i->sabores as $s)
													{{$s->produto->produto->nome}}<br>

													@endforeach
													<label>Tamanho: {{$i->tamanho->nome()}} - {{$i->tamanho->pedacos}} pedaços</label>
													@else
													--
													@endif
												</span> 
											</td>
                                            <td align="center"><span class="codigo" style="width: 100px;" id="id">
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
														$maiorValor = number_format(($somaValores/sizeof($i->sabores)),2);
													}


													?>
													{{number_format($maiorValor, 2, ',', '.')}}
													@else
													{{number_format($i->produto->valor, 2, ',', '.')}}
													@endif
												</span>
											</td>
                                            <td align="center">
                                            <span class="codigo" style="width: 100px;" id="id">
													@if($i->status)
													<span class="label label-xl label-inline label-light-success">OK</span>
													@else
													<span class="label label-xl label-inline label-light-danger">Pendente</span>
													@endif
												</span>
												 </td>
                                            <td align="center">
                                            <span class="codigo" style="width: 100px;" id="id">
													@if(count($i->itensAdicionais) > 0)

													@foreach($i->itensAdicionais as $key => $ad)
													{{$ad->adicional->nome()}} 
													@if($key < count($i->itensAdicionais)-1)
													|
													@endif
													@endforeach

													@else
													Nenhum 
													@endif
												</span>
											</td>
											<?php  
											if(sizeof($i->sabores) > 0){
												$subTotal = $subComAdicional = $maiorValor * $i->quantidade;
											}else{
												$subTotal = $subComAdicional = $i->produto->valor * $i->quantidade;
											}
											foreach($i->itensAdicionais as $a){
												$subComAdicional += $i->quantidade * $a->adicional->valor;
											}
											?>
                                            <td align="center">
                                            	<span class="codigo" style="width: 100px;" id="id">
													{{number_format($subTotal, 2, ',', '.')}}
												</span> 
											</td>
                                            <td align="center">
                                            	<span class="codigo" style="width: 100px;" id="id">
													{{number_format($subComAdicional, 2, ',', '.')}}
												</span>
                                             </td>
                                            <td align="center">
                                            <span class="codigo" style="width: 120px;" id="id">


													<a class="btn btn-danger" onclick='swal("Atenção!", "Deseja excluir este item do pedido?", "warning").then((sim) => {if(sim){ location.href="/pedidosDelivery/deleteItem/{{ $i->id }}" }else{return false} })' href="#!">
														<i class="la la-trash"></i>				
													</a>

													@if(!$i->status)
													<a class="btn btn-success" onclick='swal("Atenção!", "Deseja marcar este item como concluido?", "warning").then((sim) => {if(sim){ location.href="/pedidosDelivery/alterarStatus/{{ $i->id }}" }else{return false} })' href="#!">
														<i class="la la-check"></i>				
													</a>
													@endif


												</span>
											 </td>                                           
                                                                                                                  

                                    </tr>
                                @endforeach 	
                                    </tbody>
                            </table>
                          
                    </div>                   
                    </div>
		</form>
                   
            </div> 
            
                
           
               

			</div>
		</div>
	
	</div>  
	  <input type="hidden" id="_token" value="{{ csrf_token() }}"> 
   <form action="{{route('frentedelivery.finalizarPedidofrente')}}" method="POST">
						  @csrf
	<div class="col-12 px-4">
          <div class="caixa border radius-4 p-2">	
				<div class="rows">	
					<div class="col-12">
						<h5>Valor Total R$ <strong id="total" class="cyan-text">0,00</strong></h5><br>	
					</div>
             					
						<div class="col-2 mb-3">
								<label class="text-label">Taxa de Entrega</label>	
								<input type="text" name="taxa_entrega" id="taxa_entrega" value=""  class="form-campo">
						</div>
						<div class="col-2 mb-3">
								<label class="text-label">Telefone</label>	
								<input type="text" name="telefone" id="telefone" value="{{$pedido->cliente->celular}}"  class="form-campo">
						</div>
						
						<div class="col-2 mb-3">
								<label class="text-label">Troca Para</label>	
								<input type="text" name="troco_para" id="troco_para"  class="form-campo">
						</div>
						<div class="col-4 mb-3">
								<label class="text-label">Observação</label>	
								<input type="text" name="observacao_pedido" value="" id="observacao_pedido" class="form-campo">
						</div>
						<div class="col-2 text-center pb-4">
							<input type="hidden" value="{{$pedido->id}}" name="pedido_id">
                			<input type="submit" class="btn btn-azul m-auto" value="Finalizar" >
                		
                		</div>
				</div>
				
	  </div>
	</div> 
   </form>   
 </div>
		
</div>
	
@endsection