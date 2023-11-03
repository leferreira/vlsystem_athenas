@extends("templates.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">
	<div class="col-12">
            <div class="rows">
            <div class="col-12">
				<div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
                <span class="d-flex center-middle">	<i class="fas fa-search mr-1"></i> Dados da Compra: {{$compra->id}}	</span>
				<a href="{{route('compra.index')}}" class="btn btn-verde btn-pequeno float-right "><i class="fas fa-arrow-left mb-0"></i> Voltar</a>
				</div>
                    <div class="py-4 px-4">
                        <div class="rows text-escuro">	
                        		<div class="col d-flex">
                                    <div class="col-sm-12 col-lg-12 col-md-6 col-xl-6">

                					<h4>Código: <strong>{{$compra->id}}</strong></h4>
                					<h4>Nº NF-e Importada: <strong>{{$compra->nf > 0 ? $compra->nf : '*'}}</strong></h4>
                					<h4>Nº NF-e Emitida: <strong>{{$compra->numero_emissao > 0 ? $compra->numero_emissao : '*'}}</strong></h4>
                
                
                					<h5>Usuário: <strong>{{$compra->usuario->nome}}</strong></h5>
                					<h5>Estado: 
                						@if($compra->estado == 'NOVO')
                						<span class="label label-xl label-inline label-light-primary">Disponível</span>
                
                						@elseif($compra->estado == 'APROVADO')
                						<span class="label label-xl label-inline label-light-success">Aprovado</span>
                						@elseif($compra->estado == 'CANCELADO')
                						<span class="label label-xl label-inline label-light-danger">Cancelado</span>
                						@else
                						<span class="label label-xl label-inline label-light-warning">Rejeitado</span>
                						@endif
                					</h5>
                				</div>
                               </div>
                               
                               <div class="col d-flex">
                                    <div class="col-sm-12 col-lg-12 col-md-6 col-xl-6">

                					<h5>Fornecedor: <strong>{{$compra->fornecedor->razao_social}}</strong></h5>
                					<h5>Data: <strong>{{ \Carbon\Carbon::parse($compra->created_at)->format('d/m/Y H:i:s')}}</strong></h5>
                
                					<h5>Observação: <strong>{{$compra->observacao}}</strong></h5>
                
                					@if($compra->numero_emissao > 0)
                					<h5>Data de Emissão: <strong>{{ \Carbon\Carbon::parse($compra->updated_at)->format('d/m/Y H:i:s')}}</strong></h5>
                
                					@endif
                				</div>
                               </div>
						</div>
						
						
                    </div>
                    
                    
            </div>
        </div>
    </div>


       <div class="col-12 px-4">
                    <div class="caixa border radius-4">
					<span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Itens da Compra</span>
                    <div class="tabela-responsiva">
                            <table cellpadding="0" cellspacing="0" class="table-bordered">
                                    <thead>
                                            <tr>
                                                    <th align="center">ID</th>
                                                    <th align="left" >Produto</th>
                                                    <th align="center">Valor</th>
                                                    <th align="center">Validade</th>
                                                    <th align="center">Qtde</th>                                                       
                                                    <th align="center">Subtotal</th>
                                                    
                                            </tr>
                                    </thead>
                                    <tbody>
                                  @foreach($compra->itens as $i)       
                                    <tr>
                                            <td align="center">{{$i->id}}</td>	
                                            <td align="left">{{$i->produto->produto}}</td>
                                            <td align="center">R$ {{ number_format($i->valor_unitario, 2, ',', '.') }}</td>
                                            <td align="center">{{\Carbon\Carbon::parse($i->validade)->format('d/m/Y')}}</td> 
                                            <td align="center">{{$i->quantidade}}</td>                                                                      
                                            <td align="center">R$ {{ number_format(($i->valor_unitario * $i->quantidade), 2, ',', '.') }}</td>	                                            

                                    </tr>
                                @endforeach 	
                                    </tbody>
                            </table>
                          
                    </div>                   
                    </div>	
                    
					<div class="card-body">
					<div class="row">
						<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
							<div class="card card-custom gutter-b example example-compact">
								<div class="card-header">

									<div class="card-body">
										<h4>Fatura</h4>
										<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">
											<table class="datatable-table" style="max-width: 100%; overflow: scroll">
												<thead class="datatable-head">
													<tr class="datatable-row" style="left: 0px;">
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Vencimento</span></th>
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>

													</tr>
												</thead>


												@if(sizeof($compra->fatura) > 0)
												<tbody class="datatable-body">
													@foreach($compra->fatura as $f)
													<tr class="datatable-row" style="left: 0px;">
														<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ \Carbon\Carbon::parse($f->data_vencimento)->format('d/m/Y')}}
														</span></td>
														<td class="datatable-cell"><span class="codigo" style="width: 100px;">
															{{number_format(($f->valor_integral), 2, ',', '.')}}
														</span></td>

													</tr>
													@endforeach
												</tbody>
												@else
												<tbody class="datatable-body">
													<tr class="datatable-row" style="left: 0px;">
														<td class="datatable-cell"><span class="codigo" style="width: 80px;">
															{{ \Carbon\Carbon::parse($compra->created_at)->format('d/m/Y')}}
														</span></td>
														<td class="datatable-cell"><span class="codigo" style="width: 80px;">
															{{number_format(($compra->valor), 2, ',', '.')}}
														</span></td>

													</tr>
												</tbody>
												@endif


											</table>
										</div>



									</div>



								</div>
							</div>
						</div>

						<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
							<div class="card card-custom gutter-b example example-compact">
								<div class="card-header">

									<div class="card-body">

										<div class="form-group validated">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Natureza de Operação</label>

											<select class="custom-select form-control" id="natureza" name="natureza">
												@foreach($naturezas as $n)
												<option value="{{$n->id}}">{{$n->natureza}} - {{$n->CFOP_entrada_estadual}}/{{$n->CFOP_entrada_inter_estadual}}</option>
												@endforeach
											</select>

										</div>

										<div class="form-group validated">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Tipo de Pagamento</label>

											<select class="custom-select form-control" id="tipo_pagamento" name="tipo_pagamento">
												@foreach($tiposPagamento as $key => $t)

												<option value="{{$key}}">{{$key}} - {{$t}}</option>
												@endforeach
											</select>

										</div>
									</div>
								</div>
							</div>
						</div>


						<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">

							<div class="card card-custom gutter-b example example-compact">
								<div class="card-header">

									<div class="card-body">
										<h3 class="card-title">Total: R$ <strong class="red-text">{{number_format($compra->somaItems(), 2, ',', '.')}}</strong></h3>

										@if($compra->chave != '')

										@if($compra->estado != 'CANCELADO')


										<a target="_blank" class="navi-text" href="/compras/imprimir/{{$compra->id}}">
											<span class="label label-xl label-inline label-light-success">Imprimir</span>
										</a>

										<a target="_blank" class="navi-text" href="/compras/downloadXml/{{$compra->id}}">
											<span class="label label-xl label-inline label-light-warning">Downlaod XML</span>
										</a>

										<a href="#!" class="navi-text" data-toggle="modal" data-target="#modal-cancelar">
											<span class="label label-xl label-inline label-light-danger">Cancelar</span>
										</a>


										@else

										<a target="_blank"  class="navi-text" href="/compras/downloadXmlCancela/{{$compra->id}}">
											<span class="label label-xl label-inline label-light-danger">Downlaod XML Cancelamento</span>
										</a>
										@endif

										@else


										<a onclick="enviar({{$compra->id}})" type="button" id="btn-enviar-nfe" class="btn btn-success spinner-white spinner-right">
											Transmitir para Sefaz
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


@endsection