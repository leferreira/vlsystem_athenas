@extends("template")
@section("conteudo")
<div class="caixa">
		<div class="thead between mb-0">
			<h1 class="titulo mb-0"><strong>Pedidos</strong></h1>		
			<a href="{{route('home')}}" class="btn btn-azul"><i class="fas fa-arrow-left"></i> Voltar</a>	
		</div>
		<div class="p-2">
		<div class="rows">
			<div class="col-12 mb-3">
				<span class="titulo mb-0"><strong>Dados do Pedido</strong></span>
			<div class="caixa alt bg-cinza">						
						<div class="dados-pedido">									
							<div class="rows justify-content-space-between">
									<div class="col-4 text-center">
										<i class="fas fa-user"></i>
										<small>Cliente</small>
										<h3 id="cli">{{session("usuario_logado")->nome}}</h3>
									</div>
									<div class="col-2 text-center">
										<i class="far fa-calendar"></i>
										<small>Data</small>
										<h3>{{databr(hoje())}}</h3>
									</div>
									<div class="col-2 text-center">
										<i class="far fa-clock"></i>
										<small>Hora</small>
										<h3>{{agora()}}</h3>
									</div>
									<div class="col-2 text-center">
										<i class="fas fa-dollar-sign"></i>
										<small>total</small>
										<h3 id="total">R$ 0,00</h3>
									</div>
											
							</div>		
						</div>
			</div>			
			</div>			
										
				<div class="col-12 mb-3">		
						<div class="caixa alt">
						<div class="p-2 border-bottom pb-4">
							<span class="titulo"><strong>Itens do pedido</strong> </span>
								<div class="rows">
									<div class="col-4">
										<small class="text-label">Titulo</small>
										<input type="hidden"  id="produto_uuid" />
										<input type="text" id="produto"  class="form-campo produto"/>										
									</div>								
									<div class="col-2">
										<small class="text-label">Valor</small>
										<input type="text" readonly="readonly" name="preco" id="preco"  class="form-campo mascara-float">
									</div>								
									<div class="col-2">
										<small class="text-label">Quantidade</small>
										<input type="text"  value="1" name="qtde" id="qtde"  class="form-campo mascara-float">											 
									</div>	
									<div class="col-2">
										<small class="text-label">Subtotal</small>
										<input type="text" readonly="readonly" name="subtotal" id="subtotal"  class="form-campo mascara-float">											 
									</div>	
													 
									<div class="col-2 mt-1 pt-1">
										<input type="button" class="btn btn-azul width-100" value="Inserir " id="addProd">
									</div>
								</div>
						</div>
							
						<div class="p-2 mt-3 pt-0">
							<div class="tabela-responsiva">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabela prod">
								  <thead>
										   <tr>
												<th width="2%" align="center">Item</th>
												<th width="48%" align="left">Produto</th>
												<th width="16%" align="center">Preço</th>
												<th width="8%" align="center">Quantidade</th>							
												<th width="15%" align="center">Subtotal</th>
												<th width="15%" align="center">Excluir</th>
										  </tr>
								  </thead>
								  <tbody> </tbody>
								</table>								
									<div class="botoes" id="botoes" style="justify-content:end">
											<button class="btn btn-vermelho"><i class="fas fa-trash"></i> limpar</button>
											<button type="button" onclick="salvarPedido()"  class="btn btn-verde"><i class="fas fa-check"></i> Finalizar Venda</button>
									</div>
							</div>
						</div>
				</div>	
            </div>
	
</div>
</div>

 
	</div>
	@endsection