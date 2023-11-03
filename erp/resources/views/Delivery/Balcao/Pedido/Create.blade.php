@extends("Delivery.Balcao.template")
@section("conteudo")


<div class="col-12 m-auto">			
<div class="pedido border p-1 radius-4 bg-branco">		
	
	<div class="rows">	
		<div class="col-12">		
			<div class="p-0">		
			<div class="rows">		
			<div class="col-9">		
			<div class="scroll mb-1 border bg-branco p-2">		
				<div class="rows">
					<div class="col-6 mb-1">
						<span class="text-label">Buscar Cliente(nome)</span>
						<input type="text" id="nomePesq"  class="form-campo">
					</div>
					<div class="col-3 mb-1">
						<span class="text-label">Celular </span>
						<input type="text" id="celular"  class="form-campo">
					</div>
					
					<div class="col-3 mb-1">
    					<a href="javascript:;" onclick="abrirModal('#addnovoCliente')" class="btn btn-verde2 d-block">Novo</a>
    				</div>
    				  				
    				
					
				</div>
			</div>
			
				
			<div class="scroll-130 border bg-normal px-0">		
				<table class="tabela" width="100%" cellpadding="0" cellspacing="0">
					<thead>
						<tr> 
                			<th align="center">Cód.</th>
                			<th align="center">Nome</th> 									  
                			<th align="center">Fone</th> 									  
                			<th align="center">Email</th> 									  
                			<th align="center">Referência</th> 	
                			<th align="center">Fazer Pedido</th>								  
                		</tr>
					</thead>
						<tbody id="lista_clientes">
						@foreach($clientes as $cliente)
							<tr class="bg-branco"> 
								<td align="center">{{$cliente->id}}</td>
								<td align="center">{{$cliente->nome}}</td> 									  
								<td align="center">{{$cliente->celular}}</td> 									  
								<td align="center">{{$cliente->email}}</td> 									  
								<td align="center">{{$cliente->referencia}}</td> 	
								<td align="center"><a href="{{route('delivery.balcao.abrirPedido',$cliente->id)}}">Pedir</a></td>
							</tr>
						@endforeach
						</tbody>
				</table>
			</div>
			
			</div>
			
		<div class="col-3 d-flex">		
			<div class="caixa">		
				<div class="thumb">		
					<img src="{{asset('storage/upload/imagens_produtos/pizza2.png')}}" class="img-fluido">
				</div>
				<span class="tt">Pizza 1</span>
				<span class="tt2">Valor: 19,90</span>
				<div class="botoes border-top alt">
					<a href="javascript:;" onclick="abrirModal('#add')" class="btn btn-azul2"><i class="fas fa-plus-circle"></i> Adicional</a>
					<a href="index.php?link=1" class="btn btn-verde2 d-block"><i class="fas fa-arrow-left"></i> Novo</a>
				</div>
			</div>
		</div>	
			
			
			</div>
			
			</div>
		</div>	
				
	</div>

</div>
</div>
	

<div class="window form" id="add">
	<div class="px-4 px-ms-4 width-100 d-inline-block">
		<span class="d-block text-center h4 mb-0 p-2">Acrescentar opções</span>
		<div class="border mb-4 adicional">
			<div class="rows">
				<div class="col-4">
					<div class="thumb">		
						<img src="{{asset('storage/upload/imagens_produtos/pizza2.png')}}" class="img-fluido">
					</div>	
				</div>
				<div class="col-8">
					<div class="rows pt-2 border-left">		
						<div class="col-6">		
							<span class="text-label">Produto</span>
							<strong class="text-label h6">Pizza 1</strong>
						</div>		
						<div class="col-3">		
							<span class="text-label">Valor</span>
							<strong class="text-label h6">39,00</strong>
						</div>	
						<div class="col-3">		
							<span class="text-label">Qtde</span>
							<strong class="text-label h6">1</strong>
						</div>
					</div>
					<div class="rows pt-2 border-top border-left pb-2">	
						<div class="col-6 mt-3">		
							<div class="caixa">		
								<strong class="text-label p-1 border-bottom bg-normal"><i class="fas fa-plus-circle"></i> Adicionar</strong>
								<div class="p-1">
									<select class="form-campo">
										<option selected>Selecione</option>
										<option>Com borda (+5,50)</option>
										<option>Com recheio (+5,50)</option>
										<option>Com queijo (+5,50)</option>
									</select>
								</div>
								<div class="p-1 position-relative">
									<a href="javascript:;" onclick="abrirModal('#novo')" class="link-laranja filtro"><i class="fas fa-plus"></i> Cadastrar novo</a>
								</div>	
							</div>	
						</div>	
						<div class="col-6 mt-3">		
							<div class="caixa">		
								<strong class="text-label p-1 border-bottom bg-red-18"><i class="fas fa-minus-circle"></i> Remover</strong>
								<div class="p-1">
									<select class="form-campo">
										<option selected>Selecione</option>
										<option>Sem borda (0,00)</option>
										<option>Sem recheio (0,00)</option>
										<option>Sem queijo (0,00)</option>
									</select>
								</div>
								<div class="p-1">
									<a href="javascript:;" onclick="abrirModal('#novo')"  class="link-vermelho"><i class="fas fa-plus"></i> Cadastrar novo</a>
								</div>
							</div>	
						</div>
						<div class="col-12 mt-3">
							<table class="tabela border" width="100%" cellpadding="0" cellspacing="0">
									<thead>
										<tr class="bg-branco"> 
											<th align="left">Adicionado</td>								  
											<th align="right">Valor total</td>								  
										</tr>
									</thead>
									<tbody>
										<tr class="bg-branco"> 
											<td class="text-left"  colspan="2"><span class="text-left text-vermelho h6 mb-0">Pizza 1 <strong>(Com borda)<strong></td>								  
										</tr>
										<tr class="bg-branco">
											<td align="center" colspan="2"><span class="text-right text-vermelho h4 mb-0">24,00<strong></td>								  
										</tr>
									</tbody>
							</table>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
	
	<div class="tfooter end">
		<a href="" class="fechar btn btn-neutro">Fechar</a>
		<input type="submit" class="btn btn-verde2" value="Salvar alteração">
	</div>
</div>



<div class="window medio" id="addnovoCliente">
<form action="{{route('delivery.balcao.inserirClienteNoPedido')}}" method="post">
	<div class="px-4 px-ms-4 pb-3 width-100 d-inline-block">
		<span class="d-block text-center h4 mb-0 p-2">Adicionar Cliente</span>			
		<div class="rows">				
			@csrf				
					<div class="col-4 mb-1">
						<span class="text-label">Nome</span>
						<input type="text" required name="nome" value="" class="form-campo maior">
					</div>
					
					<div class="col-8 mb-1">
						<span class="text-label">Sobrenome</span>
						<input type="text" required id="sobre_nome" name="sobre_nome"  class="form-campo maior">
					</div>
					
					
					<div class="col-4 mb-1">
						<span class="text-label">Celular</span>
						<input type="text" required id="celular" name="celular" value="" class="form-campo maior">
					</div>
					
					<div class="col-4 mb-1">
						<span class="text-label">Senha</span>
						<input type="text" required id="senha" name="senha" value="" class="form-campo maior">
					</div>
					
									
					
				</div>		
	</div>
	<div class="tfooter end">
		<input type="submit"  value="Salvar" class="btn btn-gra-amarelo">
	</div>
</form>	
</div>
<div id="fundo_preto"></div>	
	
		
		
@endsection
	