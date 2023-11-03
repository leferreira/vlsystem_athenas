@extends("template")
@section("conteudo")
<div class="caixa">
		<div class="thead between mb-0">
			<h1 class="titulo mb-0"><strong>Dados do Pedido: {{$pedido->identificador}}</strong></h1>		
			<a href="{{route('home')}}" class="btn btn-azul"><i class="fas fa-arrow-left"></i> Voltar</a>	
		</div>
		<div class="p-2">
		<div class="rows">
			<div class="col-12 mb-3">
			<div class="caixa alt bg-cinza">						
						<div class="dados-pedido">									
							<div class="rows justify-content-space-between">
									<div class="col-4 text-center">
										<i class="fas fa-user"></i>
										<small>Cliente</small>
										<h3 id="cli">{{auth()->user()->nome_razao_social}}</h3>
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
										<input type="hidden"  id="produto_id" />
										<input type="text" id="produto"  class="form-campo produto"/>
										
									</div>								
									<div class="col-2">
										<small class="text-label">Valor</small>
										<input type="text" value="" name="preco" id="preco"  class="form-campo mascara-dinheiro">
									</div>								
									<div class="col-2">
										<small class="text-label">Quantidade</small>
										<input type="number" min="1" value="1" name="qtde" id="qtde"  class="form-campo">											 
									</div>	
									<div class="col-2">
										<small class="text-label">Subtotal</small>
										<input type="text" value="1" name="subtotal" id="subtotal"  class="form-campo mascara-dinheiro">											 
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
												<th width="2%" align="center">Id</th>
												<th width="48%" align="left">Produto</th>
												<th width="16%" align="center">Preço</th>
												<th width="8%" align="center">Quantidade</th>							
												<th width="15%" align="center">Subtotal</th>
												<th width="15%" align="center">Excluir</th>
										  </tr>
								  </thead>
								  <tbody>
								  @foreach($pedido->itens as $item)  
								  	<tr class='datatable-row' style='left: 0px;'>
                            			<td class='datatable-cell'><span class='' style='width: 60px'>{{$item->id}}</span></td>
                            			<td class='datatable-cell'><span class='' style='width: 120px'>{{$item->produto->nome}}</span></td>
                            			<td class='datatable-cell'><span class='' style='width: 80px'>{{$item->valor}}</span></td>
                            			<td class='datatable-cell'><span class='' style='width: 100px'>{{$item->qtde}}</span></td>
                            	    	<td class='datatable-cell'><span class='' style='width: 80px'> {{$item->subtotal}}</span></td>
                            	    	<td class='datatable-cell text-center'><span class='svg-icon svg-icon-danger' style='width: 80px'><a class='btn btn-vermelho btn-pequeno d-inline-block' href='#prod tbody' onclick='excluirItem({{$item->id}})'>
										<i class='fas fa-trash'></i></a></span></td>
                            		</tr>
									@endforeach
								  
								   </tbody>
								</table>								
									<div class="botoes" id="botoes" style="justify-content:center">
											<button class="btn btn-vermelho"><i class="fas fa-trash"></i> Excluir Pedido</button>
									</div>
							</div>
						</div>
				</div>	
            </div>
	
</div>
</div>

 
	</div>
	@endsection