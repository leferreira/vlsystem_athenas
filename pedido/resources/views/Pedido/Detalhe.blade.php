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
				<span class="titulo mb-0">Pedido Num: {{$pedido->identificador}} - Status: <strong>{{$pedido->status->status}}</strong></span>
			<div class="caixa alt bg-cinza">						
						<div class="dados-pedido">									
							<div class="rows justify-content-space-between">
									
									<div class="col-2 text-center">
										<i class="far fa-calendar"></i>
										<small>Data Pedido</small>
										<h3>{{databr($pedido->data_pedido)}}</h3>
									</div>
									<div class="col-2 text-center">
										<i class="far fa-calendar"></i>
										<small>Data Atendimento</small>
										<h3>{{($pedido->data_atendimento) ? databr($pedido->data_atendimento) : '00/00/0000'}}</h3>
									</div>
									<div class="col-2 text-center">
										<i class="far fa-clock"></i>
										<small>Hora</small>
										<h3>{{$pedido->hora_pedido}}</h3>
									</div>
									<div class="col-2 text-center">
										<i class="fas fa-dollar-sign"></i>
										<small>total</small>
										<h3 id="total">R$ {{$pedido->total}}</h3>
									</div>
											
							</div>		
						</div>
			</div>			
			</div>			
										
				<div class="col-12 mb-3">		
						<div class="caixa alt">
					
							
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
	@endsection