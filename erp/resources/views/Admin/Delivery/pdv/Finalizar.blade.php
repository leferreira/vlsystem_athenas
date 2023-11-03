@extends("pdv/template")
@section("conteudo")
<div class="Home">
	<div class="conteudo">
		<div class="rows">
			<div class="col-12 mb-3">
						<div class="migalha">
							<a href="" class="mp1 ativo"> <small><span>1</span>Nova venda</small></a>
							<a href="" class="mp1 ativo"><small><span>2</span> Pagamento</small></a>
							<a href="" class="mp1 ativo"><small><span>3</span> Finalizar venda</small></a>
						</div>
						<div class="rows">
							<div class="col-6 mb-3 d-flex">
								<div class="caixa home alt">
									<div class="titulo">Resumo</div>
									<ul class="resumo">
										<li><span>Valor Bruto</span> <span>{{$venda['total']}}</span></li>
										<li><span>Desconto</span> <span>0</span></li>
										<li><span>Recebido</span> <span>{{$pagamento['totalRecebido']}}</span></li>
										<li><span>Troco</span> <span>0</span></li>
										<li class="total"><span>Total</span> <span>{{$venda['total']}}</span></li>
									</ul>
									<div class="titulo bd-top h6 mb-0"><a href="#" class="btn btn-amarelo"><i class="fas fa-eye"></i> Pré visualizar cupom</a></div>
								</div>
							</div>
							<div class="col-6 mb-3 d-flex">
								<div class="caixa home alt">
									<div class="titulo">Campos opcionais</div>
									<div class="rows">
									<div class="col-12 mb-3">
										<input type="text" name="" placeholder="CNPJ/CPF do cliente" class="form-campo" id="Lista">
										<ul class="listaProdutos">
											<li><a href="#">157 - ADESIVO PRIMER DE CARROCERIA 250 ML</a></li>
											<li><a href="#">157 - ADESIVO PRIMER DE CARROCERIA 250 ML</a></li>
											<li><a href="#">157 - ADESIVO PRIMER DE CARROCERIA 250 ML</a></li>
											<li><a href="#">157 - ADESIVO PRIMER DE CARROCERIA 250 ML</a></li>
											<li><a href="#">157 - ADESIVO PRIMER DE CARROCERIA 250 ML</a></li>
											<li><a href="#">157 - ADESIVO PRIMER DE CARROCERIA 250 ML</a></li>
											<li><a href="#">157 - ADESIVO PRIMER DE CARROCERIA 250 ML</a></li>
											<li><a href="#">157 - ADESIVO PRIMER DE CARROCERIA 250 ML</a></li>
											<li><a href="#">157 - ADESIVO PRIMER DE CARROCERIA 250 ML</a></li>
											<li><a href="#">157 - ADESIVO PRIMER DE CARROCERIA 250 ML</a></li>
											<li><a href="#">157 - ADESIVO PRIMER DE CARROCERIA 250 ML</a></li>
										</ul>
										<a href="" class="text-azul">Ver clientes cadastrados</a>
									</div>
									<div class="col-12 mb-3">
										<input type="text" name="" placeholder="Email do cliente para envio da nota" class="form-campo" id="Lista">
									</div>
									<div class="col-12 mb-3">
										<input type="text" name="" placeholder="Vendedor" class="form-campo" id="Lista">
									</div>

									</div>
								</div>
							</div>

							<div class="col-12 mb-3">
								<div class="caixa preco">
									<div class="rows">
										<div class="col-8">
											<div class="grid-preco">
												<div>
													<small>Desconto</small>
													<h4>0,00</h4>
												</div>
												<div>
													<small>Recebido</small>
													<h4>{{$pagamento['totalRecebido']}}</h4>
												</div>
												<div>
													<small>Troca</small>
													<h4>0,00</h4>
												</div>
												<div class="total">
													<small>Total</small>
													<h4>{{$venda['total']}}</h4>
												</div>
											</div>
										</div>
										<div class="col-4 d-flex text-end align-vertical-center">
											<a href="{{route('pdv.pagamento')}}" class="btn btn-claro btn-grande"><i class="fas fa-arrow-left"></i> Voltar</a>
											<a href="#" @click="concluirVenda" class="btn btn-azul btn-grande  ml-3"> Continuar <i class="fas fa-arrow-right"></i></a>
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