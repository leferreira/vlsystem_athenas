<?php
use App\Service\AssinaturaService;
use App\Models\Assinatura;

    $assinatura     = Assinatura::orderBy("id", "desc")->first(); 
?>
@extends("Admin.template")
@section("conteudo")

<div class="col-9 central mb-3">
<div class="card-body p-3">
	<div class=" p-3">
	@if($empresa->mostrar_pendencia !='N')
@can('menu_nfe')
	<div class="msg width-100 msg-azul pt-2 mt-3 mb-4" style="box-shadow: 0 3px 7px 0 #206a988c;">					
	<div class="rows">					
					<div class="col-12">
					<span class="titulo pb-1 h5 mb-1 border-0">Ações pendentes<br><small class="fw-100" style="text-transform:capitalize;">Veja todas sua ações pendentes ante de começar</small></span> 
					<a href="javascript:;" onclick="esconderPendencia()" class="sair">Não Mostrar</a></div>
					<div class="col-6 mb-3">
						<div class="card">
						
							<div class=" px-0">
								<div class="table-responsive">
									<table cellpadding="0" cellspacing="0" class="table table-sm table-zebrado">
										<thead>
											<!--<tr>
												<th align="left">Tipo</th>
												<th align="left">Pendência</th>
												<th align="center">Ver</th>
											</tr>-->
										</thead>
										<tbody>
											<tr>
												<td align="left" style="padding: 0.7rem 1rem;">
												<small style="font-size: larger;" class="text-escuro">Tipo: Geral</small><br>
												<b class="h5 mb-0">Dados da Empresa</b>
												</td>
												<td align="right" style="padding: 0.7rem 1rem;">
												@if($empresa->configurado=='N')
													<a href="{{route('admin.empresa.index')}}" class="btn btn-azul text-branco btn-medio d-inline-block"><i class ="fas fa-fa-cog"></i> Configurar</a>
												@else
													<span class="btn-disabled btn btn-verde text-branco btn-medio d-inline-block"><i class ="fas fa-check"></i></span>
												@endif
												</td>
											</tr>									
											

											<tr>
												<td align="left" style="padding: 0.7rem 1rem;">
												<small style="font-size: larger;" class="text-escuro">Tipo: Nota Fiscal</small><br>
												<b class="h5 mb-0">Dados do Emitente</b>
												</td>

												<td align="right" style="padding: 0.7rem 1rem;">
												@if(!$empresa->emitente->cnpj)
													<a href="{{route('admin.emitente.index')}}" class="btn btn-azul btn-medio d-inline-block"><i class ="fas fa-cog"></i> Configurar</a>
												@else
													<span class="btn-disabled btn btn-verde text-branco btn-medio d-inline-block"><i class ="fas fa-check"></i></span>
												@endif
												</td>

											</tr>
											<tr>
												<td align="left" style="padding: 0.7rem 1rem;">
												<small style="font-size: larger;" class="text-escuro">Tipo: Nota Fiscal</small><br>
												<b class="h5 mb-0">Certificado Digital</b>
												</td>
												<td align="right" style="padding: 0.7rem 1rem;">
												@if(($certificado_arquivo_binario == null ) || ($certificado_senha == null))
													<a href="{{route('admin.certificadodigital.index')}}" class="btn btn-azul btn-medio d-inline-block"><i class ="fas fa-cog"></i> Configurar</a>
												@else
													<span class="btn-disabled btn btn-verde text-branco btn-medio d-inline-block"><i class ="fas fa-check"></i></span>
												@endif
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
										<thead>
											<!--<tr>
												<th align="left">Tipo</th>
												<th align="left">Pendência</th>
												<th align="center">Ver</th>
											</tr>-->
										</thead>
										<tbody>											
											
											<tr>
												<td align="left" style="padding: 0.7rem 1rem;">
												<small style="font-size: larger;" class="text-escuro">Tipo: Nota Fiscal</small><br>
												<b class="h5 mb-0">Natureza da Operação</b>
												</td>
												<td align="right" style="padding: 0.7rem 1rem;">
												@if(!$naturezaoperacao)
													<a href="{{route('admin.naturezaoperacao.index')}}" class="btn btn-azul btn-medio d-inline-block"><i class ="fas fa-cog"></i> Configurar</a>
												@else
													<span class="btn-disabled btn btn-verde text-branco btn-medio d-inline-block"><i class ="fas fa-check"></i></span>
												@endif
												</td>												
											</tr>
											<tr>
												<td align="left" style="padding: 0.7rem 1rem;">
												<small style="font-size: larger;" class="text-escuro">Tipo: Venda/Compra</small><br>
												<b class="h5 mb-0">Cadastro de Produto</b>
												</td>
												<td align="right" style="padding: 0.7rem 1rem;">
												@if(!$produto)
													<a href="{{route('admin.produto.index')}}" class="btn btn-azul btn-medio d-inline-block"><i class ="fas fa-cog"></i> Configurar</a>
												@else
													<span class="btn-disabled btn btn-verde text-branco btn-medio d-inline-block"><i class ="fas fa-check"></i></span>
												@endif
												</td>												
											</tr>
										
											<tr>
												<td align="left" style="padding: 0.7rem 1rem;">
												<small style="font-size: larger;" class="text-escuro">Tipo: Sistema</small><br>
												<b class="h5 mb-0">Testar API</b>
												</td>
												<td align="right" style="padding: 0.7rem 1rem;">												
													<a href="{{route('admin.testeapi')}}" class="btn btn-azul btn-medio d-inline-block"><i class ="fas fa-cog"></i> Verificar se API está ativa</a>
												
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
	@endcan	
		
	@endif	
				<div class="rows">
				<!--<div class="col-12">
					<a href="#" class="abrirMOdal btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
				</div>-->
					
					<div class="col-4">						
						<div class="card">
						<div class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><h5><i class="fas fa-chart-pie"></i> Gráfico de Entradas/Saídas Mensal</h5></div>
							<canvas class="mt-4" id="myChart" width="400" height="250"></canvas>
							<!--<img src="img/img-grafico01.png" class="img-fluido">-->
						</div>
					</div>
					<div class="col-4">
						<div class="card">
						<div class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><h5><i class="fas fa-chart-pie"></i> Gráfico de Entradas Diárias</h5></div>
							<canvas class="mt-4" id="myChart2" width="400" height="250"></canvas>
							<!--<img src="img/img-grafico02.png" class="img-fluido">-->
						</div>
					</div>
				
				<div class="col-4">
				<div class="rows">					
					<div class="col-12 mb-2">
						<div class="card bg-azul width-100 mb-0">
							<div class=" rows p-2 min-height" style="align-items: center;">
								<div class="col-4 col-ms-12 text-center">
									<i class="far fa-calendar text-azul h1 mb-0" style="font-size: 4.5rem!important;"></i>
									<span class="alert">1</span>
								</div>
							
								@php
									if($assinatura->eh_teste == "S"){
										$url_pagamento = route('admin.assinatura.assinar');
										$plano = $assinatura->planopreco->plano->nome . "(Demo)";
									}else{
    									if($fatura_aberta){
    										$url_pagamento = route('admin.fatura.confirmarPagamento', $fatura_aberta->id);
    									}else{
    										$url_pagamento ="#";
    									} 
    									   									
    									$plano = $assinatura->planopreco->plano->nome;
									} 
									
									$data_vencimento = AssinaturaService::data_vencimento()
								@endphp
								<div class="col-md-8 col-ms-12">
									<span class="d-block text-escuro mb-2">Meu plano - <b>{{ $plano }}</b></span>
									<span class="d-block text-escuro">Vecimento</span>
									<span class="h4 float-left text-escuro mb-0"><strong>{{ databr($data_vencimento)}}</strong>- <a href="{{$url_pagamento}}">Pagar</a> </span>
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
									<span class="d-block text-branco">Pagamentos (hoje)</span>
									<span class="h4 float-left text-branco mb-0"><strong>R$ {{ formataNumeroBr($pagamentos) }} </strong></span>
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
									<span class="d-block text-branco">Recebimentos (hoje)</span>
									<span class="h4 float-left text-branco mb-0"><strong>R$ {{ formataNumeroBr($recebimentos) }}</strong></span>
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
												<th align="left">Cliente</th>
												<th align="left">Total</th>
												<th align="center">Ver</th>
											</tr>
										</thead>
										<tbody>
										@foreach($pedidos_pendentes as $ped)
											<tr>
												<td align="left">{{databr($ped->data_pedido)}}</td>
												<td align="left">{{($ped->cliente) ? $ped->cliente->nome_razao_social: '--'}}</td>
												<td align="left">{{formataNumeroBr($ped->total)}}</td>
												<td align="center"><a href="{{route('admin.pedidocliente.show', $ped->id)}}" class="btn btn-azul btn-pequeno d-inline-block">Ver Pedido</a></td>
											</tr>
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
							<h5> Pedidos da Loja Virtual</h5>
						</div>
							<div class=" p-1">
								<div class="table-responsive">
									<table cellpadding="0" cellspacing="0" class="table table-sm table-zebrado">
										<thead>
											<tr>
												<th align="left">Data</th>
												<th align="left">Cliente</th>
												<th align="left">Valor</th>
												<th align="left">Frete</th>
												<th align="left">Líquido</th>
												<th align="center">Ver</th>
											</tr>
										</thead>
										<tbody>
											@foreach($pedidos_loja as $ped)
    											<tr>
    												<td align="left">{{ \Carbon\Carbon::parse($ped->created_at)->format('d/m/Y H:i:s')}}</td>
    												<td align="left">{{($ped->cliente) ? $ped->cliente->nome_razao_social: '--'}} </td>
    												<td align="left">{{formataNumeroBr($ped->valor_venda)}}</td>
    												<td align="left">{{formataNumeroBr($ped->valor_frete)}}</td>
    												<td align="left">{{formataNumeroBr($ped->valor_liquido)}}</td>
    												<td align="center"><a href="{{route('admin.lojapedido.edit', $ped->id)}}" class="btn btn-azul btn-pequeno d-inline-block">Ver Pedido</a></td>
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
var entradas = <?php echo json_encode(array_values($entradas)) ?>;
var saidas 	 = <?php echo json_encode(array_values($saidas)) ?>;
var diarios	 = <?php echo json_encode(array_values($diarias)) ?>;
function esconderPendencia(){
	 $.ajax({
		  url: base_url + "admin/empresa/esconderPendencia",
		  type: "GET",
		  dataType: "json",
		  data:{},
		  success: function (){
			  location.reload();
		  }
	   });	
}
</script>
@endsection