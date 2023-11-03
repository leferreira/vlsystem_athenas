@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="h5 mb-0 d-flex center-middle">	<i class="fas fa-search mr-1"></i> Dados do Pedido: {{$pedido->id}}	</span>
					<div class="d-flex">
						<a href="{{route('admin.lojapedido.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left mb-0"></i> </a>
						<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
					</div>
				</div>
<div class="py-4 px-4">
<div class="rows">
	<div class="col-12 mb-4">
            <div class="rows">
            <div class="col-12">
				
                        <div class="rows text-escuro">	
                        			<div class="col-2 d-flex">
                                            <div class="px-3 py-4 border radius-4 width-100">
                                                    <i class="fas fa-calendar-alt pequeno-font float-left mr-1 text-azul"></i>
                                                    <small class="d-block">Data</small>
                                                    <h4>{{databr($pedido->data_pedido)}}</h4>
                                            </div>
                                       </div>
                                       									
										<div class="col-2 px-1 d-flex">
												<div class="px-3 py-4 border radius-4 width-100">
                                                <i class="fas fa-user pequeno-font float-left mr-1 text-azul"></i>
                                                <small class="d-block">Nome do Cliente</small>
                                                <h4 style="line-height:1rem">{{($pedido->cliente) ? $pedido->cliente->nome: '--'}}</h4>
                                        </div>
										</div>
                                       
                                     <div class="col d-flex">
                                     @if(isset($pedido->endereco))
                                            <div class="px-3 py-4 border radius-4 width-100">
													<i class="fas fa-map-marker-alt  pequeno-font float-left mr-1 text-azul"></i>
                                                    <small class="d-block">Endereço</small>
                                                    <small class="opacity-70">
                        								<b>{{$pedido->endereco->rua}}, {{$pedido->endereco->numero}} - {{$pedido->endereco->bairro}}</b>
                        							</small>
                        							<small class="opacity-70">
                        								<b>{{$pedido->endereco->cidade}} ({{$pedido->endereco->uf}}) | {{$pedido->endereco->cep}}</b>
                        							</small>
                                            </div>
                                          @else                                          
                                          <div class="px-3 py-4 border radius-4 width-100">
													<i class="fas fa-map-marker-alt  pequeno-font float-left mr-1 text-azul"></i>
                                                    <small class="d-block">Endereço</small>
                                                    <small class="opacity-70">
                        								<b>--</b>
                        							</small>                        							
                                            </div>
                                        @endif  
                                       </div>
                                       
                                       <div class="col-2 d-flex">
                                            <div class="px-3 py-4 border radius-4 width-100">
													<i class="fas fa-map-marker-alt  pequeno-font float-left mr-1 text-azul"></i>
                                                    <small class="d-block">Valor</small>
                                                    <small class="opacity-70">
                        								<b>R$ {{$pedido->valor_total}}</b>
                        							</small>
                        							
                                            </div>
                                       </div>                                      
                                       
                                       <div class="col-2 d-flex">
                                            <div class="px-3 py-4 border radius-4 width-100">
													<i class="fas fa-map-marker-alt  pequeno-font float-left mr-1 text-azul"></i>
                                                    <small class="d-block">Status</small>
                                                    <small class="opacity-70">
                        								<b>{{$pedido->status->status}}</b>
                        							</small>
                                            </div>
                                       </div>
						</div>
                    </div>
            </div>
    </div>


       <div class="col-12 mb-4">
       <form action="" method="Post">
       @csrf
             <fieldset class="p-1">
					<legend><i class="far fa-list-alt"></i> Itens do Pedido</legend>
                    <div class="tabela-responsiva">
                            <table cellpadding="0" cellspacing="0" class="table-bordered table">
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
                                            <td align="left">{{$i->produto->nome}}</td>
                                            <td align="center">R$ {{ number_format($i->valor, 2, ',', '.') }}</td>
                                            <td align="center">{{$i->quantidade}}</td>                                                                      
                                            <td align="center">R$ {{ number_format($i->quantidade*$i->valor, 2, ',', '.') }}</td>	                                            

                                    </tr>
                                @endforeach 	
                                    </tbody>
                            </table>
                          
                    </div>                   
               </fieldset>
		</form>
                   
            </div>            
            
            
        <div class="col-12 mb-4">
       <form action="" method="Post">
       @csrf
            <fieldset class="p-1">
					<legend><i class="far fa-list-alt"></i> Dados Gerais</legend>
                    <div class="tabela-responsiva">
                            <table cellpadding="0" cellspacing="0" class="table-bordered table">
                                    <thead>
                                            <tr>
                                                    <th align="center">Forma de Pagamento</th>
                                                    <th align="left" width="290">Código Rastreio</th>
                                                    <th align="center">Código Transação</th>
                                                    <th align="center">Hash</th>                                                       
                                                    <th align="center">Link Boleto</th>
                                                    
                                            </tr>
                                    </thead>
                                    <tbody>
                                 
                                    <tr>
                                            <td align="center">{{($pedido->forma_pagamento) ? $pedido->forma_pagamento->forma_pagto: '--'}}</td>	
                                            <td align="center">
                                                {{$pedido->codigo_rastreio}}
											</td>
                                            <td align="center">
													{{$pedido->transacao_id}}
											</td>
                                            <td align="center">{{ $pedido->link_boleto}}</td>                                                                      

                                    </tr>
                          
                                       	
                                    </tbody>
                            </table>
                          
                    </div>
                    
                    
                    <div class="caixa p-2">
                   
                        <div class="caixa-rodape">  
                       @if($pedido->status_id == config('constantes.status.ABERTO'))                      
                        <a href="{{route('admin..lojapedido.excluir', $pedido->id)}}" class="btn btn-vermelho btn-medio d-inline-block">Excluir Pedido</a>
                      @endif
	                       @if(!$pedido->venda_id)
                        	<a href="{{route('admin.lojapedido.nfe', $pedido->id)}}" class="btn btn-verde btn-medio d-inline-block">Transformar em Venda</a>
                       @endif 
                        <input type="hidden" name="id_pedido" value="{{$pedido->id}}">                   
                    </div>
                    </div>
                    
                 
             </fieldset>
		</form>
                   
            </div>

    </div>
    </div>
</div>


@endsection