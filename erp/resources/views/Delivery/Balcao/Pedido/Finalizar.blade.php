@extends("Delivery.Balcao.template")
@section("conteudo")


<div class="col-12"><div class="h4 mb-1">CONFIRMAR PEDIDO</div></div>	
<div class="col-12 m-auto">			
	<div class="pedido border p-1 radius-4 bg-branco">	
		<div class="rows">		
			<div class="col-12"><div class="h5">DADOS DO PEDIDO</div></div>	
			<div class="col-12">		
			<div class="rows">		
			<div class="col-12">	
			<div class="border bg-normal px-0 fim-pedido">		
				<table class="tabela" width="100%" cellpadding="0" cellspacing="0">
					<thead>
						<tr> 
                			<th align="center">Cód.</th>
                			<th align="center">Descrição</th> 									  
                			<th align="center">Valor</th> 									  
                			<th align="center">Qtde</th> 									  
                			<th align="center">total</th> 									  
                		</tr>
					</thead>
						<tbody>
							<tr class="bg-branco"> 
								<td align="center">1</td>
								<td align="center">Pizza 1 (com borda)</td> 									  
								<td align="center">19,90</td> 									  
								<td align="center">1</td> 									  
								<td align="center">19,90</td> 									  
							</tr>
						</tbody>
				</table>
			</div>			
			</div>
			<div class="col-12 mt-2">
			<div class="caixa p-1 bg-normal">
				<div class="rows">
					<div class="col-8">
						<div class="rows">
							<div class="col-6 mb-3">
								<span class="text-label">Cliente</span>
								<strong>Gidalto goes dos santos</strong>
							</div>
							<div class="col-3 mb-3">
								<span class="text-label">Celular</span>
								<strong>98 982536066</strong>
							</div>
							<div class="col-3 mb-3">
								<span class="text-label">Forma de pagamento</span>							
								<strong>Débito</strong>
							</div>
							<div class="col-6 mb-3">
								<span class="text-label">Endereço</span>						
								<strong>Rua 02 Q02</strong>
							</div>
							<div class="col-3 mb-3">
								<span class="text-label">Bairro</span>						
								<strong>Pq horizonte</strong>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="caixa p-2">
							<strong class="text-label h6">Dados do Entregadoor</strong>
							<div class="rows">
								<div class="col-6 mb-3">
									<span class="text-label">Entregadoor</span>
									<strong class="text-vermelho">Antônio</strong>
								</div>
								<div class="col-6 mb-3">
									<span class="text-label">Tempo estimado</span>
									<strong class="text-vermelho">15min</strong>
								</div>
								<div class="col-6 mb-3">
									<span class="text-label">Veículo</span>
									<strong class="text-vermelho">Motocicleta</strong>
								</div>
								<div class="col-6 mb-3">
									<span class="text-label">Placa</span>
									<strong class="text-vermelho">xyz0213</strong>
								</div>
							</div>
						</div>
					</div>
				</div>
					
				</div>
			</div>
			</div>			
			
			<div class="col-12">
			<div class="tfooter end">
				<a href="index.php?link=2" class="fechar btn btn-azul"><i class="fas fa-edit"></i> Editar pedido</a>
				<a href="" class="fechar btn btn-verde2"><i class="fas fa-print"></i> Imprimir</a>
				<a href="index.php?link=4"  class="btn btn-gra-amarelo"><i class="fas fa-check"></i> Finalizar</a>
			</div>
		</div>
			
			</div>
			</div>	
					
		</div>
	</div>
</div>
	
		
		
@endsection
	