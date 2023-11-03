@extends("template_loja")
@section("conteudo")

<div class="col-12 m-auto acompanhamento pb-4">
	<div class="titulo" style="justify-content:left"> Acompanhamento <span><i class="fas fa-angle-double-right" aria-hidden="true" style="top: -12px;"></i></span> </div> 
	<div class="border">
		<div class="rows">
			<div class="col text-center">
				<div class="border-right p-1">
					<strong class="h5 mb-1">Data</strong>
					<span class="d-block">{{databr($pedido->data_pedido)}}</span>
				</div>
			</div>
			<div class="col text-center">
				<div class="border-right p-1">
					<strong class="h5 mb-1">Pedido</strong>
					<span class="d-block">{{zeroEsquerda($pedido->id, 5)}}</span>
				</div>
			</div>
			<div class="col text-center">
				<div class="border-right p-1">
					<strong class="h5 mb-1">Valor Total</strong>
					<span class="d-block">R$ {{$pedido->valor_liquido}}</span>
				</div>
			</div>
			<div class="col text-center">
				<div class=" p-1">
					<strong class="h5 mb-1">Status</strong>
					<span class="d-block">{{$pedido->status_entrega->status ?? null}}</span>
				</div>
			</div>
		</div>
		<!--  <div class="rows">
			<div class="col-12 text-center">
				<div class=" border-top p-3 pt-4 pb-3 d-flex" style="justify-content: flex-end;align-items:center">
					<a href="" class="btn btn-azul">Comprar novamente</a>
				</div>
			</div>
		</div>
		-->
		<div class="rows">
			<div class="col-12 p-2 px-4">
				<div class="border radius-4 prog-pedido p-3">
					<div class="pCol ativo"><i class="target"></i><span>Pedido efetuado em {{databr($pedido->data_pedido)}}</span></div>
					
					@if($pedido->data_pagamento)
						<div class="pCol ativo"><i class="target"></i><span>Pagamento confirmado em {{databr($pedido->data_pagamento)}}</span></div>
					@else
						<div class="pCol "><i class="target"></i><span>Pagamento confirmado</span></div>
					@endif
					
					@if($pedido->data_separacao)
						<div class="pCol ativo"><i class="target"></i><span>Em separação em {{databr($pedido->data_separacao)}}</span></div>
					@else
						<div class="pCol "><i class="target"></i><span>Em separação </span></div>
					@endif
										
					@if($pedido->data_envio)
						<div class="pCol ativo"><i class="target"></i><span>Enviado em {{databr($pedido->data_envio)}}</span></div>
					@else
						<div class="pCol "><i class="target"></i><span>Em transporte</span></div>
					@endif
					
					@if($pedido->data_entrega)
						<div class="pCol ativo"><i class="target"></i><span>Produto entregue em {{databr($pedido->data_entrega)}}</span></div>
					@else
						<div class="pCol "><i class="target"></i><span>Entregue</span></div>
					@endif
					
				</div>
			</div>
		</div>
		<div class="rows">
			<div class="col-12 p-2 px-4">
				<div class="border radius-4 p-3 width-100">
					<div class="rows">
						<div class="col-4 d-flex">
							<div class="border width-100">
									<strong class="d-inline-block width-100 border-bottom mb-2 p-1">Endereço de Entrega</strong>
									<small class="d-block mb-1 px-1">A/C {{$cliente->nome_razao_social  ?? null }}</small>			
									<small class="d-block mb-1 px-1">Endereço de Entrega</small>
									<small class="d-block mb-1 px-1">{{$endereco->logradouro ?? null }}, {{$endereco->numero ?? null }} , {{$endereco->complemento ?? null }} </small>
									<small class="d-block mb-1 px-1">{{$endereco->bairro ?? null }}, {{$endereco->cidade ?? null }} - {{$endereco->uf ?? null }}</small>
									<small class="d-block mb-1 px-1">{{$endereco->cep ?? null }}</small>								
							</div>
						</div>
						<div class="col-4  d-flex">
							<div class="border width-100">
							<strong class="d-inline-block width-100 border-bottom mb-2 p-1">Código Restreamento</strong>
								<small class="d-block mb-1 px-1">{{$pedido->codigo_rastreio ?? "--"}}</small><br>
								<strong class="d-inline-block width-100 border-bottom mb-2 p-1">Forma de Pagamento</strong>
								<small class="d-block mb-1 px-1">{{$pedido->forma_pagamento->forma_pagto ?? "--"}}</small>
								
							</div>
						</div>
						<div class="col-4  d-flex">
							<div class="border width-100">
								<strong class="d-inline-block width-100 border-bottom mb-2 p-1">Resumo</strong>
								<small class="d-block mb-1 px-1">Subtotal: R$ {{$pedido->valor_venda ?? null }}</small>
								<small class="d-block mb-1 px-1">Descontos (-): R$ {{$pedido->valor_desconto ?? null }}</small>
								<small class="d-block mb-1 px-1">Frete (+): R$ {{$pedido->valor_frete ?? null }}</small>
								<small class="d-block mb-1 px-1"><b>Total: R$ {{$pedido->valor_liquido ?? null }}</b></small>								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="rows">
			<div class="col-12 p-2 px-4 mb-4">
				<table class="table table-bordered" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th align="left">#</th>
							<th align="left">Produto</th>
							<th align="center">Quantidade</th>
							<th align="center">Preço Unitário</th>
							<th align="center">Total</th>
						</tr>
					</thead>
					<tbody>
					@php
						$i=1;
					@endphp
					
					@foreach($itens as $item)
					
						<tr>
							<td align="left">{{$i++}}</td>
							<td align="left">{{$item->produto->nome ?? ""}}</td>
							<td align="center">{{$item->quantidade}}</td>
							<td align="center">R$ {{formataNumeroBr($item->valor)}}</td>
							<td align="center">R$ {{formataNumeroBr($item->subtotal)}}</td>
						</tr>
					@endforeach
						<tr>							
							<td align="Right" colspan="4">total </td>
							<td align="center">R$ {{formataNumeroBr($pedido->valor_venda ?? 0)}}</td>
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>
		
		
		
		
	</div>
</div>

@endsection
	