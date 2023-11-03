@extends("Admin.template_admin")
@section("conteudo")

<div class="col-9 central mb-3">
<div class="card-body p-3">
	<div class=" p-3">
				<div class="rows">
					<div class="col-4">
						<div class="card">
						<div class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><h5><i class="fas fa-chart-pie"></i> Gráfico de vendas no mês</h5></div>
							<canvas class="mt-4" id="myChart" width="400" height="250"></canvas>
							<!--<img src="img/img-grafico01.png" class="img-fluido">-->
						</div>
					</div>
					<div class="col-4">
						<div class="card">
						<div class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><h5><i class="fas fa-chart-pie"></i> Gráfico de vendas no mês</h5></div>
							<canvas class="mt-4" id="myChart2" width="400" height="250"></canvas>
							<!--<img src="img/img-grafico02.png" class="img-fluido">-->
						</div>
					</div>
				
				<div class="col-4">
				<div class="rows">
					<div class="col-12 mb-2">
						<div class="card bg-padrao">
							<div class=" rows p-2 min-height">
								<div class="col-4 col-ms-12 text-center">
									<i class="fas fa-share text-verde h1 mb-0"></i>
								</div>
								<div class="col-md-8 col-ms-12">
									<span class="d-block text-branco">Entrada</span>
									<span class="h4 float-left text-branco mb-0"><strong>R$ 250.000,00</strong></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 mb-2">
						<div class="card bg-padrao">
							<div class=" rows p-2 min-height">
								<div class="col-4 col-ms-12 text-center">
									<i class="fas fa-reply text-vermelho h1 mb-0"></i>
								</div>
								<div class="col-md-8 col-ms-12">
									<span class="d-block text-branco">Saída</span>
									<span class="h4 float-left text-branco mb-0"><strong>R$ 250.000,00</strong></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 mb-2">
						<div class="card bg-padrao">
							<div class=" rows p-2 min-height">
								<div class="col-4 col-ms-12 text-center">
									<i class="fas fa-dollar-sign text-amarelo h1 mb-0"></i>
								</div>
								<div class="col-md-8 col-ms-12">
									<span class="d-block text-branco">Despesas</span>
									<span class="h4 float-left text-branco mb-0"><strong>R$ 250.000,00</strong></span>
								</div>
							</div>
						</div>
					</div>
				</div>	
				</div>	
				</div>
				<div class="rows mt-3">
					<div class="col-6 mb-3">
						<div class="card">
						<div class="bg-title p-2 h4 text-branco mb-0 text-uppercase text-left">
							<h5> Pedidos pendentes</h5>
						</div>
							<div class=" p-1">
								<div class="table-responsive">
									<table cellpadding="0" cellspacing="0" class="table table-sm table-zebrado">
										<thead>
											<tr>
												<th align="left">Data</th>
												<th align="left">Produto</th>
												<th align="center">Ver</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td align="left">19/05/17</td>
												<td align="left">Panela cabo grande...</td>
												<td align="center"><a href="" class="btn btn-azul btn-pequeno d-inline-block">Ver produto</a></td>
											</tr>
											<tr>
												<td align="left">19/05/17</td>
												<td align="left">Panela cabo grande...</td>
												<td align="center"><a href="" class="btn btn-azul btn-pequeno d-inline-block">Ver produto</a></td>
											</tr>
											<tr>
												<td align="left">19/05/17</td>
												<td align="left">Panela cabo grande...</td>
												<td align="center"><a href="" class="btn btn-azul btn-pequeno d-inline-block">Ver produto</a></td>
											</tr>
											<tr>
												<td align="left">19/05/17</td>
												<td align="left">Panela cabo grande...</td>
												<td align="center"><a href="" class="btn btn-azul btn-pequeno d-inline-block">Ver produto</a></td>
											</tr>
											<tr>
												<td align="left">19/05/17</td>
												<td align="left">Panela cabo grande...</td>
												<td align="center"><a href="" class="btn btn-azul btn-pequeno d-inline-block">Ver produto</a></td>
											</tr>								
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-6 mb-3">
						<div class="card">
						<div class="bg-title p-2 h4 text-branco mb-0 text-uppercase text-left">
							<h5> Pedidos finalizados</h5>
						</div>
							<div class=" p-1">
								<div class="table-responsive">
									<table cellpadding="0" cellspacing="0" class="table table-sm table-zebrado">
										<thead>
											<tr>
												<th align="left">Data</th>
												<th align="left">Produto</th>
												<th align="center">Ver</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td align="left">19/05/17</td>
												<td align="left">Panela cabo grande...</td>
												<td align="center"><a href="" class="btn btn-azul btn-pequeno d-inline-block">Ver produto</a></td>
											</tr>
											<tr>
												<td align="left">19/05/17</td>
												<td align="left">Panela cabo grande...</td>
												<td align="center"><a href="" class="btn btn-azul btn-pequeno d-inline-block">Ver produto</a></td>
											</tr>
											<tr>
												<td align="left">19/05/17</td>
												<td align="left">Panela cabo grande...</td>
												<td align="center"><a href="" class="btn btn-azul btn-pequeno d-inline-block">Ver produto</a></td>
											</tr>
											<tr>
												<td align="left">19/05/17</td>
												<td align="left">Panela cabo grande...</td>
												<td align="center"><a href="" class="btn btn-azul btn-pequeno d-inline-block">Ver produto</a></td>
											</tr>
											<tr>
												<td align="left">19/05/17</td>
												<td align="left">Panela cabo grande...</td>
												<td align="center"><a href="" class="btn btn-azul btn-pequeno d-inline-block">Ver produto</a></td>
											</tr>								
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

@endsection