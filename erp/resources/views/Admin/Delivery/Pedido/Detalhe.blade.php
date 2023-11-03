@extends("templates.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">
	<div class="col-12">
            <div class="rows">
            <div class="col-12">
				<div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
                <span class="d-flex center-middle">	<i class="fas fa-search mr-1"></i> Dados do Pedido: {{$pedido->id}}	</span>
				<a href="{{route('pedidoloja')}}" class="btn btn-verde btn-pequeno float-right "><i class="fas fa-arrow-left mb-0"></i> Voltar</a>
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
            
            
        <div class="col-12 px-4">
       <form action="{{ route('pedidoloja')}}" method="Post">
       @csrf
                    <div class="caixa border radius-4">
					<span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Dados Gerais</span>
                    <div class="tabela-responsiva">
                            <table cellpadding="0" cellspacing="0" class="table-bordered">
                                    <thead>
                                            <tr>
                                                    <th align="center">Valor de Entrega</th>
                                                    <th align="left" width="290">Total Pedido</th>
                                                    <th align="center">Total Itens</th>
                                                    <th align="center">Forma Pagamento</th>                                                       
                                                    <th align="center">Observação</th>
                                                    <th align="center">Troco para</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                 
                                    <tr>
                                            <td align="center">{{number_format($pedido->calculaFrete(), 2 , ',', '.')}}</td>	
                                            <td align="left">{{number_format($pedido->valor_total,2 , ',', '.')}}</td>
                                            <td align="center">{{count($pedido->itens)}}</td>
                                            <td align="center">{{strtoupper($pedido->forma_pagamento)}}</td>
                                            <td align="center">{{$pedido->observacao}}</td> 
                                            <td align="center">{{$pedido->troco_para}}</td>                                                                       

                                    </tr>
                          
                                       	
                                    </tbody>
                            </table>
                          
                    </div>
                    
                    
                    <div class="caixa p-2">
                   
                        <div class="caixa-rodape">
                        <a href="{{route('pedidoloja.nfe', $pedido->id)}}" class="btn btn-amarelo btn-medio d-inline-block">Recusado</a>
                        <a href="{{route('pedidoloja.nfe', $pedido->id)}}" class="btn btn-amarelo btn-medio d-inline-block">Reprovado</a>
                        <a href="{{route('pedidoloja.nfe', $pedido->id)}}" class="btn btn-amarelo btn-medio d-inline-block">Aprovado</a>
                        <a href="<?php echo "pedido/excluir/"  ?>" class="btn btn-vermelho btn-medio d-inline-block">Imprimir Pedido</a>
                        <a href="<?php echo "pedido/excluir/"  ?>" class="btn btn-vermelho btn-medio d-inline-block">Enviar SMS</a>
                        <input type="hidden" name="id_pedido" value="{{$pedido->id}}">                   
                    </div>
                    </div>
                    
                 
                    </div>
		</form>
                   
            </div>

    </div>
</div>


@endsection