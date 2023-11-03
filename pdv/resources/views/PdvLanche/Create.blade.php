@extends("PdvLanche.template")
@section("conteudo")

<section class="conteudo-fluido">
	
		<div class="base-pdv caixa p-1">
			<div class="rows ordems">
				<div class="col-5 alt d-flex">
					<div class="caixa">
						<div class="rows">
							<div class="col-12 py-1 px-4">
								<div class="group round-left width-100">
									<input type="text" name="" class="form-campo grande" placeholder="Pesquisar por cliente">
									<button type="submit" class="btn btn-azul btn-medio"><i class="fas fa-search"></i></button>
								</div>
								<!--Aqui aquela listinha-->
									<div class="listaProdutos border-0" style="top:100%!important;display:none">
										<ul>
											<li><a href="">Cliente 01</a></li>
											<li><a href="">Cliente 01</a></li>
											<li><a href="">Cliente 01</a></li>
										</ul>
									</div>
							</div>
							<div class="col-12 py-1 px-4">
								<div class="cupom p-0 scroll border-bottom">			
									<table cellpadding="0" cellspacing="0" class="prod" id="prod">
										<thead>
											<tr>
												<th width="40%" class="border-bottom border-top">Produto</th>
												<th width="20%" class="border-bottom border-top">Preço</th>
												<th width="15%" class="border-bottom border-top">Quant.</th>
												<th width="10%" class="border-bottom border-top">SubTotal</th>
												<th width="20%"  class="border-bottom border-top">Ação</th>
											</tr>
										</thead>       
									 
										<tbody>
										<tr>
											<td align="center"><span>Camisa Algodão - Vermelho / 37</span></td>
											<td align="center"><span>1,00</span></td>
											<td align="center"><span><input type="number"  class="form-campo width-100" value="1"></span></td>
											<td align="center"><span>80,00</span></td>
											<td align="center">
												<span><a class="link-verde btn-pequeno d-inline-block h5 mb-0" href="javascript:;" onclick="abrirModal('#editProd')" title="Editar"><i class="fas fa-edit" aria-hidden="true"></i></a></span>
												<span><a class="link-vermelho btn-pequeno d-inline-block h5 mb-0" href="#" title="Excluir"><i class="fas fa-trash" aria-hidden="true"></i></a></span>
											</td>
										</tr>
										<tr>
											<td align="center"><span>Camisa Algodão - Vermelho / 37</span></td>
											<td align="center"><span>1,00</span></td>
											<td align="center"><span><input type="number" class="form-campo width-100" value="1"></span></td>
											<td align="center"><span>80,00</span></td>
											<td align="center">
												<span><a class="link-verde btn-pequeno d-inline-block h5 mb-0" href="javascript:;" onclick="abrirModal('#editProd')" title="Editar"><i class="fas fa-edit" aria-hidden="true"></i></a></span>
												<span><a class="link-vermelho btn-pequeno d-inline-block h5 mb-0" href="#" title="Excluir"><i class="fas fa-trash" aria-hidden="true"></i></a></span>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
							
							<div class="col-12 px-4 ">
								<div class="caixa p-0 mb-0  border-0">
									<div class="rows">									
										<div class="col-12">
											<div class="rows">
												<div class="col">
													<small class="text-label mt-0 pb-0 text-uppercase mb-0">Volumes</small>
													<input type="text" name="volume" id="" value="0,00" class="form-campo  mascara-float text-left " placeholder="0,00" maxlength="22">
													
												</div>
												<div class="col">
													<small class="text-label mt-0 pb-0 mb-0 text-uppercase text-left">Desconto</small>
													<input type="text" name="" id=""  value="0" class="form-campo  fw-700 text-right mascara-float" placeholder="0,00" maxlength="22">
												</div>
												<div class="col">
													<small class="text-label mt-0 pb-0 mb-0 text-uppercase text-left">Imposto</small>
													<input type="text" name=""  value="0" class="form-campo  fw-700 text-right mascara-float" placeholder="0,00" maxlength="22">
												</div>	
												<div class="col">
													<small class="text-label mt-0 pb-0 mb-0 text-uppercase text-left">Total</small>
													<input type="text" name=""  value="0" class="form-campo  fw-700 text-right mascara-float" placeholder="0,00" maxlength="22">
												</div>					
											</div>					
										</div>					
									
										<div class="col-12 mt-1 pt-1">
											<a href="" class="d-inline-block btn btn-vermelho"><i class="fas fa-times" aria-hidden="true"></i> Cancelar</a>
											<a href="javascript:;" onclick="abrirModal('#finalizar')" class="d-inline-block btn btn-verde"><i class="fas fa-cash-register" aria-hidden="true"></i> Finalizar Venda</a>
										</div>
									</div>										
								</div>					
							</div>
						</div>
					</div>
				</div>
				
				
				
				<div class="col d-flex">
					<div class="caixa">
						<div class="rows">
							<div class="col py-1 px-4">
								<a href="#" class="btn btn-azul d-inline-block open"><i class="fas fa-layer-group"></i> Lista de categorias</a>
							</div>
							<!--<div class="col py-1 px-4 text-right">
								<a href="" class="btn btn-verde d-inline-block">Outra função</a>
							</div>-->
						</div>
							
						<div class="rows">
							<div class="col-12 py-1 px-4">
								<div class="group round-left width-100">
									<input type="text" name="" class="form-campo grande" placeholder="Pesquise o produto por nome ou código">
									<button type="submit" class="btn btn-azul btn-medio"><i class="fas fa-search"></i></button>
								</div>
									<!--Aqui aquela listinha-->
									<div class="listaProdutos border-0" style="top:100%!important;display:none">
										<ul>
											<li><a href="">Cliente 01</a></li>
											<li><a href="">Cliente 01</a></li>
											<li><a href="">Cliente 01</a></li>
										</ul>
									</div>
							</div>
							
							<div class="col-12 py-1 px-4">
								<div class="scroll-valores">
									<div class="rows cx-prod-valores">
									@foreach($produtos as $produto)
										<a href="" class="col-5 cinco">
											<div class="border">
												<div class="thumb">											
													<small class="kg">00,00kg</small>
												<img src="{{getenv('APP_IMAGEM_PRODUTO'). $produto->imagem}}">
												</div>
												<div class="p-2 pb-4">
													<strong>{{$produto->nome}}</strong>
													<small>{{$produto->sku}}</small>
													<small class="preco">R$ {{$produto->valor_venda}}</small>
												</div>
											</div>
										</a>
									@endforeach
									
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
<!--Lista de categorias-->
<div class="lista-Categorias">
	<span class="titulo d-flex justify-content-space-between"><i class="fas fa-layer-group"></i> Lista de categorias <a href="" class="open text-branco">X</a></span>
	<div class="scroll-valores">
	<div class="rows cx-prod-valores px-3">
		<a href="" class="col-5 cinco">
			<div class="border">
				<div class="thumb">					
					<img src="https://athenas-pdv.flexnfe.com.br/assets/pdv/img/naoencontrado.png">
				</div>
				<div class="p-2 pb-4 text-center text-escuro">
					<small>Categoria Sem produto</small>
				</div>
			</div>
		</a>
		<a href="" class="col-5 cinco">
			<div class="border">
				<div class="thumb">					
					<img src="https://athenas-pdv.flexnfe.com.br/assets/pdv/img/naoencontrado.png">
				</div>
				<div class="p-2 pb-4  text-center text-escuro">
					<small>Categoria Sem produto</small>
				</div>
			</div>
		</a>
	
		<a href="" class="col-5 cinco">
			<div class="border">
				<div class="thumb">					
					<img src="https://athenas-pdv.flexnfe.com.br/assets/pdv/img/naoencontrado.png">
				</div>
				<div class="p-2 pb-4 text-center text-escuro">
					<small>Categoria Sem produto</small>
				</div>
			</div>
		</a>
		<a href="" class="col-5 cinco">
			<div class="border">
				<div class="thumb">					
					<img src="https://athenas-pdv.flexnfe.com.br/assets/pdv/img/naoencontrado.png">
				</div>
				<div class="p-2 pb-4  text-center text-escuro">
					<small>Categoria Sem produto</small>
				</div>
			</div>
		</a>
	
		<a href="" class="col-5 cinco">
			<div class="border">
				<div class="thumb">					
					<img src="https://athenas-pdv.flexnfe.com.br/assets/pdv/img/naoencontrado.png">
				</div>
				<div class="p-2 pb-4 text-center text-escuro">
					<small>Categoria Sem produto</small>
				</div>
			</div>
		</a>
		<a href="" class="col-5 cinco">
			<div class="border">
				<div class="thumb">					
					<img src="https://athenas-pdv.flexnfe.com.br/assets/pdv/img/naoencontrado.png">
				</div>
				<div class="p-2 pb-4  text-center text-escuro">
					<small>Categoria Sem produto</small>
				</div>
			</div>
		</a>
	
		<a href="" class="col-5 cinco">
			<div class="border">
				<div class="thumb">					
					<img src="https://athenas-pdv.flexnfe.com.br/assets/pdv/img/naoencontrado.png">
				</div>
				<div class="p-2 pb-4 text-center text-escuro">
					<small>Categoria Sem produto</small>
				</div>
			</div>
		</a>
		<a href="" class="col-5 cinco">
			<div class="border">
				<div class="thumb">					
					<img src="https://athenas-pdv.flexnfe.com.br/assets/pdv/img/naoencontrado.png">
				</div>
				<div class="p-2 pb-4  text-center text-escuro">
					<small>Categoria Sem produto</small>
				</div>
			</div>
		</a>
	</div>
	</div>
</div>
</section>



<!--modal finalizar vendas-->

<div class="window form z-index" id="finalizar">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Criar pagamento</h4>
	<div class="rows">
		<div class="col-6">
			<div class="rows">
				<div class="col-6">
					<div class="caixa border-0 p-0 mb-1">
						<small class="text-label text-uppercase mt-0">Valor recebido </small>
						<input type="text" name="desconto_percentual_total" id="desconto_percentual_total" value="{{$venda->desconto_per ?? 0}}"  class="form-campo grande text-left tecla mascara-float" >
					</div>					
				</div>
				<div class="col-6">
					<div class="caixa border-0 p-0 mb-1">
						<small class="text-label text-uppercase mt-0">Valor a pagar </small>
						<input type="text" name="desconto_por_valor_total" id="desconto_por_valor_total" value="{{$venda->desconto_valor ?? 0}}"  class="form-campo grande text-left tecla mascara-float" >
					</div>					
				</div>
				
				<div class="col-6">
					<div class="caixa border-0 p-0 mb-1">
						<small class="text-label text-uppercase mt-0">Alterar retorno </small>
						<input type="text" name="acrescimo_percentual_total" id="acrescimo_percentual_total" value="{{$venda->acrescimo_per ?? 0}}"  class="form-campo grande text-left tecla mascara-float" >
					</div>					
				</div>

				<div class="col-6">
					<div class="caixa border-0 p-0 mb-1">
						<small class="text-label text-uppercase mt-0">Opção de pagamento </small>
						<select class="form-campo grande text-left tecla mascara-float">
							<option>Dinheiro</option>
							<option>Cartçao de crédito</option>
							<option>Cartçao de débito</option>
							<option>Pix</option>
						</select>				
					</div>					
				</div>

				<div class="col-12">
					<div class="caixa border-0 p-0 mb-1">
						<small class="text-label text-uppercase mt-0">Notas de pagamento </small>
						<textarea type="text"  class="form-campo grande text-left tecla mascara-float" rows="4"></textarea>
					</div>					
				</div>

				<div class="col-12">
					<div class="caixa border-0 p-0 mb-1">
						<small class="text-label text-uppercase mt-0">Notas de vendas </small>
						<textarea type="text"  class="form-campo grande text-left tecla mascara-float" rows="4"></textarea>
					</div>					
				</div>
			</div>	
		</div>	

		<div class="col-6">
			<div class="border radius-4">
				<div class="caixa border-0 p-0 mb-1">
					<div class="d-flex justify-content-space-between p-1 px-4 border-bottom" style="align-items:center">
						<small class="text-label text-uppercase mt-0 pb-0">Produtos gerais </small>
						<small class="bg-padrao radius-circulo text-branco" style="padding:.2rem .5rem">2</small>
					</div>
					<div class="d-flex justify-content-space-between p-1 px-4 border-bottom" style="align-items:center">
						<small class="text-label text-uppercase mt-0 pb-0">Imposto de pedido</small>
						<small><b>R$ 0,00 (0%)</b></small>
					</div>
					<div class="d-flex justify-content-space-between p-1 px-4 border-bottom" style="align-items:center">
						<small class="text-label text-uppercase mt-0 pb-0">Desconto</small>
						<small><b>R$ 0,00</b></small>
					</div>
					<div class="d-flex justify-content-space-between p-1 px-4 border-bottom" style="align-items:center">
						<small class="text-label text-uppercase mt-0 pb-0">Envio</small>
						<small><b>R$ 0,00</b></small>
					</div>
					<div class="d-flex justify-content-space-between p-1 px-4" style="align-items:center">
						<small class="text-label text-uppercase mt-0 pb-0">Total a pagar</small>
						<small><b>R$ 0,00</b></small>
					</div>
				</div>					
			</div>

		</div>	
		<div class="text-right base-botoes radius-0 mt-0 p-1 col-12">	
				<a href="javascript:;" onclick="limparDesconto()" class="btn btn-vermelho d-inline-block">Cancelar</a>					
				<a href="javascript:;" onclick="enviarDescontoAcrescimento()" class="btn btn-verde d-inline-block">Confirmar</a>
		</div>						
		
	</div>	
</div>


<!--modal editar produto-->
<div class="window medio z-index" id="editProd">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Produto - abacate</h4>
	<div class="rows">
		<div class="col-6">
			<div class="rows">
				<div class="col-12">
					<div class="caixa border-0 p-0 mb-1">
						<small class="text-label text-uppercase mt-0">Preço produto * </small>
						<input type="text" name="desconto_percentual_total" id="desconto_percentual_total" value="{{$venda->desconto_per ?? 0}}"  class="form-campo grande text-left tecla mascara-float" >
					</div>					
				</div>
				<div class="col-12">
					<div class="caixa border-0 p-0 mb-1">
						<small class="text-label text-uppercase mt-0">Imposto * </small>
						<input type="text" name="desconto_por_valor_total" id="desconto_por_valor_total" value="{{$venda->desconto_valor ?? 0}}"  class="form-campo grande text-left tecla mascara-float" >
					</div>					
				</div>
				
				<div class="col-12">
					<div class="caixa border-0 p-0 mb-1">
						<small class="text-label text-uppercase mt-0">Desconto * </small>
						<input type="text" name="acrescimo_percentual_total" id="acrescimo_percentual_total" value="{{$venda->acrescimo_per ?? 0}}"  class="form-campo grande text-left tecla mascara-float" >
					</div>					
				</div>
			</div>	
		</div>	

		<div class="col-6">
			<div class="rows">
				<div class="col-12">
					<div class="caixa border-0 p-0 mb-1">
						<small class="text-label text-uppercase mt-0">Tipo de imposto * </small>
						<input type="text" name="desconto_percentual_total" id="desconto_percentual_total" value="{{$venda->desconto_per ?? 0}}"  class="form-campo grande text-left tecla mascara-float" >
					</div>					
				</div>
				<div class="col-12">
					<div class="caixa border-0 p-0 mb-1">
						<small class="text-label text-uppercase mt-0">Tipo de desconto * </small>
						<input type="text" name="desconto_por_valor_total" id="desconto_por_valor_total" value="{{$venda->desconto_valor ?? 0}}"  class="form-campo grande text-left tecla mascara-float" >
					</div>					
				</div>
				
				<div class="col-12">
					<div class="caixa border-0 p-0 mb-1">
						<small class="text-label text-uppercase mt-0">Unidade de venda * </small>
						<input type="text" name="acrescimo_percentual_total" id="acrescimo_percentual_total" value="{{$venda->acrescimo_per ?? 0}}"  class="form-campo grande text-left tecla mascara-float" >
					</div>					
				</div>
			</div>

		</div>	
		<div class="text-right base-botoes radius-0 mt-0 p-1 col-12">	
				<a href="javascript:;" onclick="limparDesconto()" class="btn btn-vermelho d-inline-block">Cancelar</a>					
				<a href="javascript:;" onclick="enviarDescontoAcrescimento()" class="btn btn-verde d-inline-block">Enviar</a>
		</div>						
		
	</div>	
</div>

<div id="fundo_preto"></div>

@endsection

