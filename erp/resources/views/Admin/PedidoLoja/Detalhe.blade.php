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
                                                    <h4>{{databr($pedido->data_pedido)}}</h4>
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
                                                    <small>Endereço</small>
                                                    <span class="opacity-70">
                        								{{$pedido->endereco->rua}}, {{$pedido->endereco->numero}} - {{$pedido->endereco->bairro}}
                        							</span>
                        							<span class="opacity-70">
                        								{{$pedido->endereco->cidade}} ({{$pedido->endereco->uf}}) | {{$pedido->endereco->cep}}
                        							</span>
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
                                                    <th align="center">ID</th>
                                                    <th align="left" width="290">Produto</th>
                                                    <th align="center">Preço</th>
                                                    <th align="center">Qtde</th>                                                       
                                                    <th align="center">Subtotal</th>
                                                    
                                            </tr>
                                    </thead>
                                    <tbody>
                                  @foreach($pedido->itens as $i)       
                                    <tr>
                                            <td align="center">{{$i->id}}</td>	
                                            <td align="left">{{$i->produto->produto}}</td>
                                            <td align="center">R$ {{ number_format($i->produto->valor_loja, 2, ',', '.') }}</td>
                                            <td align="center">{{$i->quantidade}}</td>                                                                      
                                            <td align="center">R$ {{ number_format($i->quantidade*$i->produto->valor_loja, 2, ',', '.') }}</td>	                                            

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
                                                    <th align="center">Forma de Pagamento</th>
                                                    <th align="left" width="290">Status Pagamento</th>
                                                    <th align="center">Status Preparação</th>
                                                    <th align="center">Frete</th>                                                       
                                                    <th align="center">Total</th>
                                                    
                                            </tr>
                                    </thead>
                                    <tbody>
                                 
                                    <tr>
                                            <td align="center">{{$pedido->forma_pagamento}}</td>	
                                            <td align="left">
                                                @if($pedido->status_pagamento ==  'pending')
        										<span class="text-warning">PENDENTE</span>
        										@elseif($pedido->status_pagamento == 'approved')
        										<span class="text-success">APROVADO</span>
        										@else
        										<span class="text-danger">CANCELANDO/REJEITADO</span>
        										@endif
											</td>
                                            <td align="center">

												<span class="codigo" style="width: 100px;" id="id">
        											@if($pedido->status_preparacao == 0)
        
        											<span class="label label-xl label-inline label-light-info">Novo</span>
        											@elseif($pedido->status_preparacao == 1)
        											<span class="label label-xl label-inline label-light-primary">Aprovado</span>
        											@elseif($pedido->status_preparacao == 2)
        											<span class="label label-xl label-inline label-light-danger">Cancelado</span>
        											@elseif($pedido->status_preparacao == 3)
        											<span class="label label-xl label-inline label-light-warning">Aguardando Envio</span>
        											@elseif($pedido->status_preparacao == 4)
        											<span class="label label-xl label-inline label-light-dark">Enviado</span>
        											@else
        											<span class="label label-xl label-inline label-light-success">Entregue</span>
        											@endif
        
        											<a style="margin-left: 10px;" data-toggle="modal" data-target="#modal-status">
        												<i class="la la-refresh text-danger"></i>
        											</a>
        										</span>
										
											</td>
                                            <td align="center">R$ {{ number_format($pedido->valor_total, 2, ',', '.')}}</td>                                                                      

                                    </tr>
                          
                                       	
                                    </tbody>
                            </table>
                          
                    </div>
                    
                    
                    <div class="caixa p-2">                   
                        <div class="caixa-rodape">
                        <a href="{{route('pedidoloja.nfe', $pedido->id)}}" class="btn btn-amarelo btn-medio d-inline-block">Gerar NFE</a>
                        @if(!$pedido->venda_id)
                        <a href="<?php echo "pedido/excluir/"  ?>" class="btn btn-vermelho btn-medio d-inline-block">Imprimir Pedido</a>
                        @endif                
                    </div>
                    </div>
                    
                 
                    </div>
		</form>
                   
            </div>

    </div>
</div>


@endsection