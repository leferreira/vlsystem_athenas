@extends("pdv/template")
@section("conteudo")
<div class="Home">
	<div class="conteudo">
		<div class="rows">
			<div class="col-12 mb-3">
						<div class="migalha">
							<a href="" class="mp1 ativo"> <small><span>1</span>Nova venda</small></a>
							<a href="" class="mp1 ativo"><small><span>2</span> Pagamento</small></a>
							<a href="" class="mp1"><small><span>3</span> Finalizar venda</small></a>
						</div>
						<div class="rows opcao-pag">
							<div class="col-2 mb-3">
								<a href="#" class="caixa dinheiro" @click="adicionarFormaPgto($event, 0)">
                                    <i class="fas fa-dollar-sign"></i> <small>Dinheiro</small>
                                </a>
							</div>
							<div class="col-2 mb-3 px-0">
								<a href="#" class="caixa cartao" @click="adicionarFormaPgto($event, 3)">
                                    <i class="far fa-credit-card"></i> <small>Crédito</small>
                                </a>
							</div>
							<div class="col-2 mb-3 pr-0">
								<a href="#" class="caixa cartao debito" @click="adicionarFormaPgto($event, 4)">
                                    <i class="far fa-credit-card"></i> <small>Débito</small>
                                </a>
							</div>
							<div class="col-2 mb-3 pr-0">
								<a href="#" class="caixa refeicao">
                                    <i class="fas fa-mortar-pestle" @click="adicionarFormaPgto($event, 1)"></i> <small>Refeição</small>
                                </a>
							</div>
							<div class="col-2 mb-3 pr-0">
								<a href="#" class="caixa alimentacao" @click="adicionarFormaPgto($event, 2)">
                                    <i class="fas fa-utensils"></i> <small>Alimentação</small>
                                </a>
							</div>
							<div class="col-2 mb-3 ">
								<a href="javascript:;" onclick="abrirModal('#janela1')" class="caixa mais"><i class="fas fa-plus"></i> <small>Mais</small></a>
							</div>
						</div>
						<div class="rows">
							<div class="col-12 mb-3">
								<div class="caixa home">
									<h1 class="tt" v-if="nenhumPgtoSelecionado"><i class="fas fa-share h2" style="transform: rotate(267deg);"></i> Adicione um ou mais pagamentos</h1>
									<table  width="100%" cellpadding="0" cellspacing="0" class="tabela clear" v-if="!nenhumPgtoSelecionado">
										<thead>
										<tr>
											<th align="left">Pagamento</th>
											<th align="center">Valor</th>
											<th align="center">Parcelas</th>
											<th align="center">Ação</th>
										</tr>
										</thead>
										<tbody>
										<tr v-for="(p, index) in formasSelecionadas">
											<td align="center">@{{ p.nome }}</td>
											<td align="center">
                                                <input step=".01" type="number" v-model="p.valor" value="1" class="form-campo text-center">
                                            </td>
											<td align="center" width="30">@{{ p.parcelas }}</td>
											<td align="center">
												<a href="#" class="btn excluir" title="Excluir" @click="excluirFormaPagamento($event, index)">
                                                    <i class="fas fa-trash"></i>
                                                </a>
											</td>
										</tr>
									</table>

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
													<h4>@{{ totalRecebido }}</h4>
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
											<a href="{{route('pdv.index')}}" class="btn btn-claro btn-grande"><i class="fas fa-arrow-left"></i> Voltar</a>
											<a href="#" @click="salvarNaSessao" class="btn btn-azul btn-grande ml-3">Cotinuar <i class="fas fa-arrow-right"></i></a>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

			</div>
		</div>
	</div>


<div class="window medio" id="janela1">
	<div class="titulo mb-4">Mais pagamentos</div>
		<div class="p-4 pt-0">
			<div class="rows opcao-pag">
				<div class="col mb-3 pl-0">
					<a href="" class="caixa cartao"><i class="fas fa-square"></i> <small>Presente</small></a>
				</div>
				<div class="col mb-3 px-0">
					<a href="" class="caixa cartao"><i class="far fa-square"></i> <small>Loja</small></a>
				</div>
				<div class="col mb-3 pr-0">
					<a href="" class="caixa cartao"><i class="far fa-square"></i> <small>Combustivel</small></a>
				</div>
				<div class="col mb-3 pr-0">
					<a href="" class="caixa cartao"><i class="fas fa-square"></i> <small>Pix</small></a>
				</div>
			</div>
		</div>
		<div class="tfooter end">
			<button type="" class="btn btn-claro fechar">Fechar</button>
			<button type="submit" class="btn btn-azul">Finalizar</button>
		</div>
</div>

<div id="fundo_preto"></div>
@endsection