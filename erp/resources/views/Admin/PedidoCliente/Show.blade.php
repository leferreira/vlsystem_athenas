@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase  justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Detalhe do Pedido: <b class="text-vermelho">{{$pedido->id}}</b></span>
	<div class="d-flex">
		<a href="{{route('admin.pedidocliente.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	</div>
</span>
<div class="rows">
	<div class="col-12">
            <div class="rows">
            <div class="col-12">
				<div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
				</div>
                    <div class="py-4 px-4">
                        <div class="rows text-escuro">										
										<div class="col-3 px-1 d-flex">
												<div class="px-3 py-4 border radius-4 width-100">
                                                <i class="fas fa-users pequeno-font float-left mr-1 text-azul"></i>
                                                <small>Nome do Cliente</small>
                                                <h4 style="line-height:1rem">{{$pedido->cliente->nome_razao_social}}</h4>
                                        </div>
										</div>
                                       <div class="col d-flex">
                                            <div class="px-3 py-4 border radius-4 width-100">
                                                    <i class="fas fa-calendar-alt pequeno-font float-left mr-1 text-azul"></i>
                                                    <small>Data</small>
                                                    <h4>{{databr($pedido->data_pedido)}}</h4>
                                            </div>
                                       </div>
                                       <div class="col d-flex">
                                            <div class="px-3 py-4 border radius-4 width-100">
                                                    <i class="far fa-clock pequeno-font float-left mr-1 text-azul"></i>
                                                    <small>Hora</small>
                                                    <h4>{{$pedido->hora_pedido}}</h4>
                                            </div>
                                       </div>
                                       <div class="col d-flex">
                                            <div class="px-3 py-4 border radius-4 width-100">
                                                    <i class="fas fa-dollar-sign pequeno-font float-left mr-1 text-azul"></i>
                                                    <small>Total</small>
                                                    <h4>R$ {{$pedido->total}}</h4>
                                            </div>
                                       </div>
                                       <div class="col d-flex">
                                            <div class="px-3 py-4 border radius-4 width-100">
													<i class="fas fa-info-circle  pequeno-font float-left mr-1 text-azul"></i>
                                                    <small>Status</small>
                                                    <h4>{{$pedido->status->status}}</h4>
                                            </div>
                                       </div>
						</div>
                    </div>
            </div>
        </div>
    </div>


       <div class="col-12 px-4">
   
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
                                            <td align="left">{{$i->produto->nome}}</td>
                                            <td align="center">R$ {{$i->produto->valor_venda}}</td>
                                            <td align="center">{{$i->qtde}}</td>                                                                       
                                            <td align="center">R$ {{$i->subtotal}}</td>	
                                    </tr>
                                @endforeach   
                                        <tr>
                                            <td align="right" colspan="8" ><b>Total:</b> <span class="text-verde minimo-font">R$ 120</span></td>
                                        </tr>	
                                    </tbody>
                            </table>
                          
                    </div>
                    
                 @if(!$pedido->venda_id )   
                    <div class="caixa p-2">
                   
                        <div class="caixa-rodape">
                        <a href="{{route('admin.pedidocliente.recusar', $pedido->id)}}" class="btn btn-amarelo btn-medio d-inline-block">Recusar</a>
                        <a href="{{route('admin.pedidocliente.excluir', $pedido->id)}}" class="btn btn-vermelho btn-medio d-inline-block">Excluir</a>
                        <a href="{{route('admin.pedidocliente.gerarVendaPeloPedido', $pedido->id)}}" class="btn btn-verde btn-medio d-inline-block">Transformar em Venda</a>
                     </div>
                   </div>
                 @endif   
                 
                    </div>
		
                   
            </div>

    </div>
</div>


@endsection