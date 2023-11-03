@extends("templates.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">
	<div class="col-12">	
   
    <div class="rows">	
        <div class="col-12">
            <div class="caixa">
				<div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle"><i class="fas fa-search mr-1"></i> Ordem de Compra: {{$ordem_compra->id}} </span>			
                    <a href="<?php echo "pedido" ?>" class="btn btn-verde btn-pequeno float-right "><i class="fas fa-arrow-left mb-0"></i> Voltar</a>
                </div>
                </div>
                    <div class="py-4 px-4">
                        <div class="rows text-escuro">										
								<div class="col-3 px-1 d-flex">
									<div class="px-3 py-4 border radius-4 width-100">
											<i class="fas fa-users pequeno-font float-left mr-1 text-padrao"></i>
											<small>Nome do Fornecedor</small>
											<h4 style="line-height:1rem">{{$ordem_compra->fornecedor->razao_social}}</h4>
									</div>
								</div>
                               <div class="col d-flex">
                                    <div class="px-3 py-4 border radius-4 width-100">
                                            <i class="fas fa-calendar-alt pequeno-font float-left mr-1 text-padrao"></i>
                                            <small>Data Emissão</small>
                                            <h4>{{databr($ordem_compra->data_emissao)}}</h4>
                                    </div>
                               </div>
                             
                               <div class="col d-flex">
                                    <div class="px-3 py-4 border radius-4 width-100">
                                            <i class="fab fa-bitcoin pequeno-font float-left mr-1 text-padrao"></i>
                                            <small>Total</small>
                                            <h4>R$ {{$ordem_compra->valor_total}}</h4>
                                    </div>
                               </div>
                               <div class="col d-flex">
                                    <div class="px-3 py-4 border radius-4 width-100">
											<i class="fas fa-map-marker-alt  pequeno-font float-left mr-1 text-padrao"></i>
                                            <small>Status</small>
                                            <h4>{{$ordem_compra->status->status_ordem_compra}}</h4>
                                    </div>
                               </div>
						</div>
                    </div>
            </div>
        </div>   
        
            <div class="col-12">
                    <div class="caixa border radius-4">
                    <span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Itens do Pedido</span>
                    <div class="tabela-responsiva">
                            <table cellpadding="0" cellspacing="0" class="table-bordered">
                                    <thead>
                                            <tr>
                                                    <th align="center">ID</th>
                                                    <th align="left" width="380">Produto</th>
                                                    <th align="center">Preço</th>
                                                    <th align="center">Qtde</th>                                                    
                                                    <th align="center">Subtotal</th> 
                                                    
                                            </tr>
                                    </thead>
                                    <tbody>
                              @foreach($itens as $i)    
                                   
                                    <tr>
                                            <td align="center">{{$i->id}}</td>	
                                            <td align="left">{{$i->produto->nome}}</td>
                                            <td align="center">R$ {{$i->valor}}</td>
                                            <td align="center">{{$i->qtde}}</td>  
                                            <td align="center">R$ {{$i->subtotal}}</td>
                              @endforeach
                                     <tr>
                                            <td align="right" colspan="9" ><b>Total:</b> <span class="text-verde minimo-font">R$ 100,00</span></td>
                                    </tr>	
                             
                                    </tbody>
                            </table>
                          
                    </div>
                    
                     <div class="caixa p-2">                   
                        <div class="caixa-rodape">
							<a href="#" class="btn btn-amarelo btn-medio d-inline-block">Recusar</a>
							<a href="#" class="btn btn-vermelho btn-medio d-inline-block">Excluir</a>                        
							<a href="{{route('ordemcompra.aprovarOrdemCompra',$ordem_compra->id)}}" class="btn btn-verde btn-medio d-inline-block"> Aprovar Ordem de Compra </a>
						</div>
                    </div>

                   
            </div>

    </div>
    

    </div>
   
</div>
</div>

@endsection
