@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">
	<div class="col-12">
		<div class="p-2 py-1 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
                <span class="d-flex center-middle h5 mb-0">	<i class="fas fa-search mr-1"></i> Dados da Compra: <strong class="text-azul ml-1">Código:{{$compra->id}}</strong></span>
				<div>
					<a href="{{route('admin.compra.index')}}" class="btn btn-azul btn-pequeno d-inline-block" title="Volta"><i class="fas fa-arrow-left"></i></a>
					<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
				</div>				
		</div>
		
        <div class="p-3">
        <div class="rows">
            <div class="col-12 mb-3">
                <div class="p-0">	
                		<div class="px-5 py-4 pb-3 border radius-4 width-100">
                            <div class="rows">
								<!--<div class="col-2 mb-3">
									<div class="border radius-4 p-1">
										<h4>Código: <strong class="text-azul">{{$compra->id}}</strong></h4>
									</div>
								</div>-->
                        		
									@if($compra->nf > 0)
									<div class="col mb-3">
										<div class="border radius-4 p-1">
											<h4>NF-e: <strong class="text-azul">{{$compra->nf ?? '*'}}</strong></h4>
										</div>
									</div>
                        			@endif
								
								<div class="col mb-3">
									<div class="border radius-4 p-1">
										<h5>Usuário: <span style="color: #7c7c7c;font-weight: 400;">{{$compra->usuario->name}}</span></h5>
									</div>
								</div>
								
                        			@if($compra->nf)									
									<div class="col mb-3">
										<div class="border radius-4 p-1">	
											<h5>Chave: <span style="color: #7c7c7c;font-weight: 400;">{{$compra->chave}}</span></h5>
										</div>
									</div>
                        			@endif
                        								
									<div class="col-6 mb-3">
										<div class="border radius-4 p-1">	
											<h5>Fornecedor: <span style="color: #7c7c7c;font-weight: 400;">{{$compra->fornecedor->razao_social}}</span></h5>
										</div>
                        			</div>
									<div class="col-3 mb-3">
										<div class="border radius-4 p-1">	
											<h5>Data: <span style="color: #7c7c7c;font-weight: 400;">{{ \Carbon\Carbon::parse($compra->created_at)->format('d/m/Y H:i:s')}}</span></h5>
										</div>
                        			</div>
                        			<div class="col-3 mb-3">
										<div class="border radius-4 p-1">	
											<h5>Status: <span style="color: #7c7c7c;font-weight: 400;">{{$compra->status->status}}</span></h5>
										</div>
                        			</div>
									<div class="col-6 mb-3">	
										<div class="border radius-4 p-1">
											<h5>Oservação: <span style="color: #7c7c7c;font-weight: 400;">{{$compra->observacao}}</span></h5>
										</div>
									</div>
									<div class="col-3 mb-3">	
										<div class="border radius-4 p-1">
											<h5>Valor Total: <span style="color: #7c7c7c;font-weight: 400;">{{$compra->valor_total}}</span></h5>
										</div>
									</div>
									<div class="col-3 mb-3">	
										<div class="border radius-4 p-1">
											<h5>Valor Frete: <span style="color: #7c7c7c;font-weight: 400;">{{$compra->valor_frete}}</span></h5>
										</div>
									</div>
									<div class="col-3 mb-3">	
										<div class="border radius-4 p-1">
											<h5>Valor Despesas: <span style="color: #7c7c7c;font-weight: 400;">{{$compra->despesas_outras}}</span></h5>
										</div>
									</div>
									<div class="col-3 mb-3">	
										<div class="border radius-4 p-1">
											<h5>Valor Desconto: <span style="color: #7c7c7c;font-weight: 400;">{{$compra->valor_desconto}}</span></h5>
										</div>
									</div>
									
									<div class="col-3 mb-3">	
										<div class="border radius-4 p-1">
											<h5>Valor Líquido: <span style="color: #7c7c7c;font-weight: 400;">{{$compra->valor_compra}}</span></h5>
										</div>
									</div>
                            </div>
                       </div>
				</div>
            </div>

       <div class="col-12 mb-3">
         <div class="caixa border radius-4 width-100">
					<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="far fa-list-alt"></i> Itens da Compra</span>
                    <div class="tabela-responsiva">
                            <table cellpadding="0" cellspacing="0"  width="100%" id="dataTable" class="contas">
                                    
                                    <tbody>
                                  @foreach($compra->itens as $i) 
										<tr style="background: #00000014;">
                                                    <th align="center">ID</th>
                                                    <th align="left" >Produto</th>
                                                    <th align="center">Valor Unit</th>
                                                    <th align="center">Desconto P/ Unit</th>
                                                    <th align="center">Qtde</th>                                                       
                                                    <th align="center">Subtotal</th>
                                                    <th align="center">Desconto total</th>
                                                    <th align="center">Líquido</th>
                                                    
                                            </tr>								  
										<tr>
                                            <td align="center">{{$i->id}}</td>	
                                            <td align="left">{{$i->produto->nome}}</td>
                                            <td align="center">R$ {{ number_format($i->valor_unitario, 2, ',', '.') }}</td>
                                            <td align="center">{{$i->desconto_por_unidade}}</td>
                                            <td align="center">{{$i->quantidade}}</td>                                                                      
                                            <td align="center">R$ {{ $i->subtotal }}</td>
                                            <td align="center">R$ {{ $i->total_desconto_item }}</td>
                                            <td align="center">R$ {{ $i->subtotal_liquido }}</td>
                       @if($i->produto->usa_grade =="S")          
                                  
                                <tr>                                   
                                       <td colspan="8" align="center">
											<table cellpadding="0" cellspacing="0" class="table table-bordered menor fatura m-auto" style="width:95%">
												<thead>
													<tr>
													   <th align="center" colspan="11"><span  class="h6 mb-0 text-uppercase">Movimentos da GRADE</span></th>
													 </tr>
													<tr>
														<th align="center">Id</th>
                                                           <th class="center">Código Barra</th>
                                                           <th align="center">Linha</th>
                                                           <th align="center">Coluna</th>
                                                           <th align="center">Descrição</th>
                                                           <th align="center">Qtde</th>  
													</tr>
												</thead>
												 <tbody>
												 
												 @foreach($i->movimetosGrade() as $m)
													<tr>
                                                       <td align="center">{{$m->id}}</td>
                                                       <td align="center">{{$m->grade->codigo_barra ?? null}}</td>
                    									<td align="center">{{$m->grade->linha->valor ?? null}}</td>
                    									<td align="center">{{$m->grade->coluna->valor ?? null}}</td>
                    									<td align="center">{{$m->grade->descricao}}</td> 																				
                    									<td align="center">{{moedaBr($m->qtde_movimento)}}</td>
                                                    </tr>
													@endforeach
												</tbody>                
											</table>
									   </td>                                   
							
                                </tr>

							@endif                                                  
									</tr>
                                @endforeach 	
                                    </tbody>
                            </table>
                          
                    </div> 
					<div class="p-2">
						<div class="rows">
							<div class="col-12">
								<div class="card-custom gutter-b example example-compact">
									<div class="card-header">
										<div class="card-body text-end d-flex">
											<h3 class="card-title">Total: <strong class="text-verde">R$ {{number_format($compra->somaItems(), 2, ',', '.')}}</strong></h3>

											@if($compra->xml_path != '')
											<a target="_blank" class="btn btn-azul" href="/compras/downloadXml/{{$compra->id}}">
												<span class="label label-xl label-inline label-light-success">
													Downlaod XML
												</span>
											</a>
											@endif

										</div>


									</div>
								</div>
							</div>


						</div>
					</div>						
                    </div>	
                    
					
                   
            </div>  
				
				
				
       <div class="col-12">
         <div class="caixa border radius-4 width-100">
					<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="far fa-list-alt"></i> Conta a Pagar</span>
                    <div class="tabela-responsiva">
                             <table cellpadding="0" cellspacing="0"  width="100%" id="dataTable" class="contas dataTable">
                                    
                                    <tbody>
                                  @foreach($compra->faturas as $i)  
									<tr style="background: #00000014;">
                                         <th align="center">ID</th>
                                         <th align="left" >Descrição</th>
                                         <th align="center">Valor</th>
                                         <th align="center">Vencimento</th>
                                         <th align="center">Status</th>                                                       
                                                    
                                    </tr>								  
                                    <tr>
                                            <td align="center">{{$i->id}}</td>	
                                            <td align="left">{{$i->descricao}}</td>
                                            <td align="center">R$ {{ number_format($i->valor, 2, ',', '.') }}</td>
                                            <td align="center">{{\Carbon\Carbon::parse($i->data_vencimento)->format('d/m/Y')}}</td> 
                                            <td align="center">{{$i->status->status}}</td>
                                                                                                           
													@if(count($i->pagamentos) > 0)           
                                  
                                    <tr>
                                                                          
                                           <td colspan="5" align="center">
    											<table cellpadding="0" cellspacing="0" class="table table-bordered menor fatura" style="width:95%">
    												<thead>
    													<tr>
    													   <th align="center" colspan="11"><span  class="h6 mb-0">PAGAMENTOS</span></th>
    													 </tr>
    													<tr>
    														<th align="center">Id</th>
                                                               <th class="text-left">Descrição</th>
                                                               <th align="center">Data Pagamento</th>
                                                               <th align="center">Número</th>
                                                               <th align="center">Valor Original</th>
                                                               <th align="center">Juros</th>
                                                               <th align="center">Desconto</th>
                                                               <th align="center">Multa</th>
                                                               <th align="center">Valor Pago</th>
                                                               <th align="center">Forma Pagto</th>
                                                               <th align="center">Opções</th>  
    													</tr>
    												</thead>
    												 <tbody>
    												 @foreach($i->pagamentos as $pag)
    													<tr>
                                                           <td align="center">{{ $pag->id }}</td>
                                                           <td align="left">{{ $pag->descricao_pagamento }} </td>
                                                           <td align="center">{{ databr($pag->data_pagamento) }}</td>
                                                           <td align="center">{{ $pag->numero_documento }}</td>
                                                           <td align="center">{{ formataNumeroBr($pag->valor_original) }}</td>
                                                           <td align="center">{{ formataNumeroBr($pag->juros) }}</td>
                                                           <td align="center">{{ formataNumeroBr($pag->desconto) }}</td>
                                                           <td align="center">{{ formataNumeroBr($pag->multa) }}</td>
                                                           <td align="center">{{ formataNumeroBr($pag->valor_pago) }}</td>
                                                           <td align="center">{{ $pag->forma_pagto->forma_pagto }}</td>
                                                           <td align="center">
                    											<a href="{{route('admin.pagamento.show', $pag->id)}}" class="btn btn-roxo d-inline-block"><i class="fas fa-eye" title="Visualizar"></i></a>
                    											 
                    									   </td>
                                                        </tr>
    													@endforeach
    												</tbody>                
    											</table>
    									   </td>                                   
    							
                                    </tr>
    
    					@endif
                                    </tr>
                                @endforeach 	
                                    </tbody>
                            </table>
                          
                    </div>
				<div class="p-2">
						<div class="rows">
							<div class="col-12">
								<div class="card-custom gutter-b example example-compact">
									<div class="card-header">

										<div class="card-body text-end d-flex">
											<h3 class="card-title">Total: <strong class="text-verde">R$ {{number_format($compra->somaItems(), 2, ',', '.')}}</strong></h3>

											@if($compra->xml_path != '')
											<a target="_blank" class="btn btn-azul" href="/compras/downloadXml/{{$compra->id}}">
												<span class="label label-xl label-inline label-light-success">
													Downlaod XML
												</span>
											</a>
											@endif

										</div>


									</div>
								</div>
							</div>


						</div>
					</div>						
                    </div>	
                    
					
                   
            </div> 
            
			</div>          
        </div>    
      

    </div>
</div>
</div>


@endsection