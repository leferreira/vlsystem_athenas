
@extends("Admin.template")
@section("conteudo")

<div class="col-9 central mb-3">
<div class="card-body p-3">
	<div class=" p-3">

	<div class="msg width-100 msg-azul pt-2 mt-3 mb-4" style="box-shadow: 0 3px 7px 0 #206a988c;">					
	<div class="rows">					
					<div class="col-12">
					<span class="titulo pb-1 h5 mb-1 border-0">Ações </span>
					</div>
					<div class="col-6 mb-3">
						<div class="card">
						
							<div class=" px-0">
								<div class="table-responsive">
									<table cellpadding="0" cellspacing="0" class="table table-sm table-zebrado">
										
										<tbody>
											<tr>
												<td align="left" style="padding: 0.7rem 1rem;">
												<small style="font-size: larger;" class="text-escuro">Cadastro de Produto</small><br>
												<b class="h5 mb-0">Quantidade produto: </b>
												</td>
												<td align="right" style="padding: 0.7rem 1rem;">
											
													<a href="{{route('admin.produtorecorrente.index')}}" class="btn btn-azul text-branco btn-medio d-inline-block"><i class ="fas fa-fa-cog"></i> Novo Produto</a>
												
												</td>
											</tr>									
											
																		
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-6 mb-3">
						<div class="card">
						
							<div class=" p-0">
								<div class="table-responsive">
									<table cellpadding="0" cellspacing="0" class="table table-sm table-zebrado">
									
										<tbody>											
											
											<tr>
												<td align="left" style="padding: 0.7rem 1rem;">
												<small style="font-size: larger;" class="text-escuro">Venda</small><br>
												<b class="h5 mb-0">Fazer Nova venda</b>
												</td>
												<td align="right" style="padding: 0.7rem 1rem;">
													<a href="{{route('admin.vendarecorrente.index')}}" class="btn btn-azul btn-medio d-inline-block"><i class ="fas fa-cog"></i> Nova Venda</a>
												
												</td>												
											</tr>
										
																	
										</tbody>
									</table>
								</div>
						</div>
					</div>
					</div>
				
		</div>
		</div>

				<div class="rows">
				<!--<div class="col-12">
					<a href="#" class="abrirMOdal btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
				</div>-->
					
					<div class="col-4">						
						<div class="card">
						<div class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><h5><i class="fas fa-chart-pie"></i> Cobranças Vencidas</h5></div>
							<div class="table-responsive">
									<table cellpadding="0" cellspacing="0" class="table table-sm table-zebrado">
										<thead>
											<tr>
												<th align="left">ID</th>
												<th align="left">Vencimento</th>
												<th align="left">Cliente</th>
												<th align="left">Valor</th>
												<th align="center">Ver</th>
											</tr>
										</thead>
										<tbody>
										@foreach($vencidos as $cob)
											<tr>
												<td align="left">{{$cob->id}}</td>
												<td align="left">{{databr($cob->data_vencimento)}}</td>
												<td align="left">{{$cob->cliente->nome_razao_social}}</td>
												<td align="left">{{$cob->valor}}</td>
												<td align="center"><a href="{{route('admin.cobranca.edit', $cob->id)}}" class="btn btn-azul btn-pequeno d-inline-block">Ver</a></td>
											</tr>
    									@endforeach							
										</tbody>
									</table>
								</div>
						</div>
					</div>
					<div class="col-4">
						<div class="card">
						<div class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><h5><i class="fas fa-chart-pie"></i> Vencimento Próximo (05 dias)</h5></div>
							<div class="table-responsive">
									<table cellpadding="0" cellspacing="0" class="table table-sm table-zebrado">
										<thead>
											<tr>
												<th align="left">ID</th>
												<th align="left">Vencimento</th>
												<th align="left">Cliente</th>
												<th align="left">Valor</th>
												<th align="center">Ver</th>
											</tr>
										</thead>
										<tbody>
										@foreach($vencimentos_proximo as $cob)
											<tr>
												<td align="left">{{$cob->id}}</td>
												<td align="left">{{databr($cob->data_vencimento)}}</td>
												<td align="left">{{$cob->cliente->nome_razao_social}}</td>
												<td align="left">{{$cob->valor}}</td>
												<td align="center"><a href="{{route('admin.cobranca.edit', $cob->id)}}" class="btn btn-azul btn-pequeno d-inline-block">Ver</a></td>
											</tr>
    									@endforeach							
										</tbody>
									</table>
								</div>
						</div>
					</div>
				
				<div class="col-4">
						<div class="card">
						<div class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><h5><i class="fas fa-chart-pie"></i> Recebimentos</h5></div>
							<div class="table-responsive">
									<table cellpadding="0" cellspacing="0" class="table table-sm table-zebrado">
										<thead>
											<tr>
												<th align="left">ID</th>
												<th align="left">Data</th>
												<th align="left">Cliente</th>
												<th align="left">Valor</th>
												<th align="center">Ver</th>
											</tr>
										</thead>
										<tbody>
										@foreach($rececimentos as $rec)
											<tr>
												<td align="left">{{$rec->id}}</td>
												<td align="left">{{databr($rec->data_recebimento)}}</td>
												<td align="left">{{$rec->conta_receber->cliente->nome_razao_social ?? "----"}}</td>
												<td align="left">{{$rec->valor_recebido}}</td>
												<td align="center"><a href="{{route('admin.recebimento.show', $rec->id)}}" class="btn btn-azul btn-pequeno d-inline-block">Ver</a></td>
											</tr>
    									@endforeach							
										</tbody>
									</table>
								</div>
						</div>
					</div>	
				</div>
				<div class="rows mt-3">					
					<div class="col-6 mb-3">
						<div class="card">
						<div class="bg-title p-2 h4 text-branco mb-0 text-uppercase text-left">
							<h5> Clientes</h5>
						</div>
							<div class=" p-1">
								<div class="table-responsive">
									<table cellpadding="0" cellspacing="0" class="table table-sm table-zebrado">
										<thead>
											<tr>
												<th align="left">ID</th>
												<th align="left">Cliente</th>
												<th align="left">Total</th>
												<th align="center">Ver</th>
											</tr>
										</thead>
										<tbody>
										@foreach($clientes as $c)
											@if($c->cliente->eh_consumidor!="S")
    											<tr>
    												<td align="left">{{$c->cliente->id}}</td>
    												<td align="left">{{$c->cliente->nome_razao_social}}</td>
    												<td align="left">{{$c->cliente->email}}</td>
    												<td align="center"><a href="" class="btn btn-azul btn-pequeno d-inline-block">Ver Pedido</a></td>
    											</tr>
    										@endif
										@endforeach
											
																			
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-6 mb-3">
						<div class="card">
						<div class="bg-title p-2 h4 text-branco mb-0 text-uppercase text-left">
							<h5> Últimas Vendas</h5>
						</div>
							<div class=" p-1">
								<div class="table-responsive">
									<table cellpadding="0" cellspacing="0" class="table table-sm table-zebrado">
										<thead>
											<tr>
												<th align="left">ID</th>
												<th align="left">Data</th>
												<th align="left">Cliente</th>
												<th align="left">Primeira Parcela</th>
												<th align="left">Valor Recorrente</th>
												<th align="center">Ver</th>
											</tr>
										</thead>
										<tbody>
										@foreach($vendas as $venda)
											<tr>
												<td align="left">{{$venda->id}}</td>
												<td align="left">{{databr($venda->data_contrato)}}</td>
												<td align="left">{{$venda->cliente->nome_razao_social}}</td>
												<td align="left">{{$venda->valor_primeira_parcela}}</td>
												<td align="left">{{$venda->valor_recorrente}}</td>
												<td align="center"><a href="{{route('admin.vendarecorrente.edit', $venda->id)}}" class="btn btn-azul btn-pequeno d-inline-block">Ver Pedido</a></td>
											</tr>
    									@endforeach							
										</tbody>
									</table>
								</div>
						</div>
					</div>
					</div>
				
		</div>
	</div>
	</div>
</div>

<!--Modal teste-->
<div id="modal-promocao" class="modal-container">
		<div class="caixaModal">
				<a href="#" class="BtnFecharModal">X</a>
			<div class="p-2">
				<span class="d-block h3 border-bottom fw-700">Dados do Produto</span>
				 <div class="rows">
					<div class="col-4"><label class="text-label">Categoria Principal<span class="text-vermelho">*</span></label><input type="text" class="form-campo"></div>
					<div class="col-4"><label class="text-label">SubCategoria 1</label><input type="text" class="form-campo"></div>
					<div class="col-4"><label class="text-label">SubCategoria 2</label><input type="text" class="form-campo"></div>
				 </div>
			</div>
			<div class="tfooter end">
			 </div>
		</div>
</div>

	

<script>

</script>
@endsection