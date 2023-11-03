@extends("template")
@section("conteudo")
<div class="conteudo">
<div class="caixa">
		<div class="rows">	
			<div class="col-12">
				<div class="caixa-titulo py-1 d-flex width-100 justify-content-space-between center-middle">
					<span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Resgatar Venda</span>
					<a href="{{route('pdv.livre')}}" class="btn btn-pequeno btn-azul"><i class="fas fa-arrow-left"></i> Voltar</a>
				</div>
				
				<div id="tabs" class="px-3">
					<ul class="tabs"> 
						<li><a href="#aba-01">Balcão</a></li>
						<li><a href="#aba-02">Venda do Caixa</a></li>
						<li><a href="#aba-03">Loja</a></li>
						<li><a href="#aba-04">Venda</a></li>
						<li><a href="#aba-05">Orçamento</a></li>
						<li><a href="#aba-06">Ordem Serviço</a></li>
						<li><a href="#aba-07">Recorrência</a></li>
					</ul>
					
					<div id="aba-01">
					<div class="card px-2 mt-3 pb-4">
						<div class="rows">		
							<div class="col-12 mb-3 thead titulo h6 text-capitalize">
								<div class="mt-3">
									<h3> Venda Balcão</h3>
								</div>
							</div>	
							<div class="col-12 px-3">
							<div class="rows">
							@foreach($lista->balcao as $v)
								<div class="col-4 mb-3">
									<div class=" bg-title3 p-2 radius-4 width-100">
										<table cellpadding="0" cellspacing="0" border="0" class="limpa width-100">             
											<thead>
												<tr>
													<th class="text-left border-bottom">Num</th>
													<th class="text-left border-bottom">Data</th>
													<th class="text-right border-bottom">Total</th>
												</tr>
											</thead>            
											<tbody>
												<tr>
													<td class="text-left" style="padding:.5rem 0">{{$v->id}}</td>
													<td class="text-left" style="padding:.5rem 0">{{databr($v->data_venda)}}</td>
													<td class="text-right" style="padding:.5rem 0">R$ {{$v->valor_liquido}}</td>
												</tr>
											</tbody>
										</table>
										<a href="javascript:;" onclick="resgatar('balcao',{{$v->id}})" class="btn btn-verde btn-pequeno mt-3 d-inline-block"><i class="fas fa-eye"></i> Pagar</a>
										<a href="{{route('resgate.excluirBalcao', $v->id)}}" class="btn btn-vermelho btn-pequeno mt-3 d-inline-block"><i class="fa fa-arrow-right"></i> Excluir</a> 
									</div>		
								</div>
							@endforeach
									
							</div>		
							</div>		
						</div>
					</div>
				</div>
					
				<div id="aba-02">
					<div class="card px-2 mt-3 pb-4">
						<div class="rows">		
							<div class="col-12 mb-3 thead titulo h6 text-capitalize">
								<div class="mt-3">
									<h3> Venda do Caixa</h3>
								</div>
							</div>	
							<div class="col-12 px-3">
							<div class="rows">
								@foreach($lista->pdvVenda as $v)
								<div class="col-4 mb-3">
									<div class=" bg-title3 p-2 radius-4 width-100">
										<table cellpadding="0" cellspacing="0" border="0" class="limpa width-100">             
											<thead>												
												
												<tr>
												<th class="text-left border-bottom">Num</th>
													<th class="text-left border-bottom"colspan="2">Título</th>
												</tr>
											</thead>            
											<tbody>
												<tr>
												<td class="text-left" style="padding:.5rem 0">{{$v->id}}</td>
													<td class="text-left" style="padding:.5rem 0">{{$v->titulo}}</td>
												</tr>
											</tbody>
										</table>
										<a href="{{route('pdv.pagamento', $v->id)}}" class="btn btn-verde btn-pequeno mt-3 d-inline-block"><i class="fas fa-eye"></i> Pagar</a>
										<a href="{{route('resgate.excluirPdvVenda', $v->id)}}" class="btn btn-vermelho btn-pequeno mt-3 d-inline-block"><i class="fa fa-arrow-right"></i> Excluir</a> 
										<a href="javascript:;" onclick="gerarLinkDoCaixa('{{$v->uuid}}')" class="btn btn-laranja btn-pequeno mt-3 d-inline-block"><i class="fa fa-arrow-right"></i> Gerar Link</a> 
									</div>		
								</div>
							@endforeach
								
									
							</div>		
							</div>		
						</div>
					</div>
				</div>
					
				<div id="aba-03">
					<div class="card px-2 mt-3 pb-4">
						<div class="rows">		
							<div class="col-12 mb-3 thead titulo h6 text-capitalize">
								<div class="mt-3">
									<h3> Venda da Loja</h3>
								</div>
							</div>	
							<div class="col-12 px-3">
							<div class="rows">
								@foreach($lista->loja as $v)
								<div class="col-4 mb-3">
									<div class=" bg-title3 p-2 radius-4 width-100">
										<table cellpadding="0" cellspacing="0" border="0" class="limpa width-100">             
											<thead>
												<tr>
													<th class="text-left border-bottom">Data</th>
													<th class="text-right border-bottom">Total</th>
												</tr>
											</thead>            
											<tbody>
												<tr>
													<td class="text-left" style="padding:.5rem 0">{{databr($v->data_pedido)}}</td>
													<td class="text-right" style="padding:.5rem 0">R$ {{$v->valor_liquido}}</td>
												</tr>
											</tbody>
										</table>
										<a href="javascript:;" onclick="resgatar('loja',{{$v->id}})" class="btn btn-verde btn-pequeno mt-3 d-inline-block"><i class="fas fa-eye"></i> Pagar</a>
										<a href="" class="btn btn-vermelho btn-pequeno mt-3 d-inline-block"><i class="fa fa-arrow-right"></i> Excluir</a> 
										<a href="javascript:;" onclick="gerarLinkDaLoja('{{$v->uuid}}')" class="btn btn-laranja btn-pequeno mt-3 d-inline-block"><i class="fa fa-arrow-right"></i> Ver Link</a> 
									</div>		
								</div>
							@endforeach
								
										
							</div>		
							</div>		
						</div>
					</div>
				</div>
				
				
				<div id="aba-04">
					<div class="card px-2 mt-3 pb-4">
						<div class="rows">		
							<div class="col-12 mb-3 thead titulo h6 text-capitalize">
								<div class="mt-3">
									<h3> Venda</h3>
								</div>
							</div>	
							<div class="col-12 px-3">
							<div class="rows">
								@foreach($lista->venda as $v)
								<div class="col-4 mb-3">
									<div class=" bg-title3 p-2 radius-4 width-100">
										<table cellpadding="0" cellspacing="0" border="0" class="limpa width-100">             
											<thead>
												<tr>
													<th class="text-left border-bottom">Data</th>
													<th class="text-right border-bottom">Total</th>
												</tr>
											</thead>            
											<tbody>
												<tr>
													<td class="text-left" style="padding:.5rem 0">{{databr($v->data_venda)}}</td>
													<td class="text-right" style="padding:.5rem 0">R$ {{$v->valor_liquido}}</td>
												</tr>
											</tbody>
										</table>
										<a href="javascript:;" onclick="resgatar('venda',{{$v->id}})" class="btn btn-verde btn-pequeno mt-3 d-inline-block"><i class="fas fa-eye"></i> Pagar</a>
										 
									</div>		
								</div>
							@endforeach
								
										
							</div>		
							</div>		
						</div>
					</div>
				</div>
				
				<div id="aba-05">
					<div class="card px-2 mt-3 pb-4">
						<div class="rows">		
							<div class="col-12 mb-3 thead titulo h6 text-capitalize">
								<div class="mt-3">
									<h3> Orçamento</h3>
								</div>
							</div>	
							<div class="col-12 px-3">
							<div class="rows">
								@foreach($lista->orcamento as $v)
								<div class="col-4 mb-3">
									<div class=" bg-title3 p-2 radius-4 width-100">
										<table cellpadding="0" cellspacing="0" border="0" class="limpa width-100">             
											<thead>
												<tr>
													<th class="text-left border-bottom">Data</th>
													<th class="text-right border-bottom">Total</th>
												</tr>
											</thead>            
											<tbody>
												<tr>
													<td class="text-left" style="padding:.5rem 0">{{databr($v->data_orcamento)}}</td>
													<td class="text-right" style="padding:.5rem 0">R$ {{$v->valor_liquido}}</td>
												</tr>
											</tbody>
										</table>
										<a href="javascript:;" onclick="resgatar('orcamento',{{$v->id}})" class="btn btn-verde btn-pequeno mt-3 d-inline-block"><i class="fas fa-eye"></i> Pagar</a>
									</div>		
								</div>
							@endforeach
								
										
							</div>		
							</div>		
						</div>
					</div>
				</div>
				
				<div id="aba-06">
					<div class="card px-2 mt-3 pb-4">
						<div class="rows">		
							<div class="col-12 mb-3 thead titulo h6 text-capitalize">
								<div class="mt-3">
									<h3> Ordem de Serviço</h3>
								</div>
							</div>	
							<div class="col-12 px-3">
							<div class="rows">
								@foreach($lista->os as $v)
								<div class="col-4 mb-3">
									<div class=" bg-title3 p-2 radius-4 width-100">
										<table cellpadding="0" cellspacing="0" border="0" class="limpa width-100">             
											<thead>
												<tr>
													<th class="text-left border-bottom">Data</th>
													<th class="text-right border-bottom">Total</th>
												</tr>
											</thead>            
											<tbody>
												<tr>
													<td class="text-left" style="padding:.5rem 0">{{databr($v->data_abertura)}}</td>
													<td class="text-right" style="padding:.5rem 0">R$ {{$v->valor_liquido}}</td>
												</tr>
											</tbody>
										</table>
										<a href="javascript:;" onclick="resgatar('os',{{$v->id}})" class="btn btn-verde btn-pequeno mt-3 d-inline-block"><i class="fas fa-eye"></i> Pagar</a>
										
									</div>		
								</div>
							@endforeach
								
										
							</div>		
							</div>		
						</div>
					</div>
				</div>
				
				<div id="aba-07">
					<div class="card px-2 mt-3 pb-4">
						<div class="rows">		
							<div class="col-12 mb-3 thead titulo h6 text-capitalize">
								<div class="mt-3">
									<h3> Recorrência</h3>
								</div>
							</div>	
							<div class="col-12 px-3">
							<div class="rows">
								@foreach($lista->recorrente as $v)
								<div class="col-4 mb-3">
									<div class=" bg-title3 p-2 radius-4 width-100">
										<table cellpadding="0" cellspacing="0" border="0" class="limpa width-100">             
											<thead>
												<tr>
													<th class="text-left border-bottom">Data</th>
													<th class="text-right border-bottom">Total</th>
												</tr>
											</thead>            
											<tbody>
												<tr>
													<td class="text-left" style="padding:.5rem 0">30/11/2022 17:53</td>
													<td class="text-right" style="padding:.5rem 0">R$ 25,00</td>
												</tr>
											</tbody>
										</table>
										<a href="javascript:;" onclick="resgatar('os',{{$v->id}})" class="btn btn-verde btn-pequeno mt-3 d-inline-block"><i class="fas fa-eye"></i> Pagar</a>
									</div>		
								</div>
							@endforeach
								
										
							</div>		
							</div>		
						</div>
					</div>
				</div>
				
				</div>
		</div>
</div>
</div>
<div class="window pdv" id="verTelaResgate">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Link de Pagamento</h4>
	<div class="rows">
		<div class="col-12">
			<label class="text-label">Link de Pagamento</label>			
			<input type="text" id="link_unico"  class="form-campo mascara-float">
		</div>
		
	
		
		<div class="text-right base-botoes radius-0 mt-0 p-1">	
				<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho d-inline-block">fechar</a>					
		</div>						
	</div>	
</div>
<script>
	var link_loja = '{{$lista->configuracao->url}}';
</script>
@endsection