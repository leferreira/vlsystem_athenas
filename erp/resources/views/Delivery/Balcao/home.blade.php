@extends("Delivery.Balcao.template")
@section("conteudo")
<div class="col-12 pedido-home">
<div class="caixa mb-2 px-3 btn-pedidos">
	<div class="rows">
		<a href="{{route('delivery.balcao.novo')}}" class="col-2 p-1 border-right bt add"><i class="fas fa-plus"></i> Novo pedido</a>
		<a href="" class="col-2 p-1 border-right bt"><i class="fas fa-plus"></i> outro aqui</a>
		<a href="" class="col-2 p-1 border-right bt"><i class="fas fa-plus"></i> outro</a>
	</div>
</div>
<div class="caixa">
<div class="rows">

	<div class="col-12 p-4 pb-1">			
		<div class="caixa mb-2 px-3 btn-pedidos">
        	<div class="rows">
    			<div class="col-3 mb-1">
					<span class="text-label">Buscar Cliente(nome)</span>
					<select name="cliente_id"  class="form-campo">
						<option value="">Selecione um Valor</option>
						@foreach($clientes as $c)
							<option value="{{$c->id}}">{{$c->nome}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-3 mb-1">
					<span class="text-label">Data Inicial</span>
					<input type="date" name="data1"  class="form-campo">
				</div>
				
				<div class="col-3 mb-1">
					<span class="text-label">Data Final</span>
					<input type="date" name="data2"  class="form-campo">
				</div>
				
				<div class="col-2 mb-1">
					<span class="text-label">Status</span>
					<select name="status_id"  class="form-campo">
						<option value="">Selecione um Valor</option>
						@foreach($status as $s)
							<option value="{{$s->id}}">{{$s->status}}</option>
						@endforeach
					</select>
				</div>
				
				<div class="col-1 mb-1">
					<span class="text-label">.</span>
					<input type="submit"  value="ok" class="btn btn-verde form-campo">
				</div>	
        		
        	</div>
        </div>
		<div class="rows">
		@foreach($pedidos as $p)
			<div class="col-4 d-flex mb-3">
				<div class="caixa">
					<div class="itens-cli border-bottom justify-content-space-between text-uppercase bg-normal p-1"><b>Pedido {{$p->id}}</b> <span class="status status-verde">{{$p->status->status}}</span></div>
					<div class="itens-cli d-block p-1"><small class="">Cliente:</small> <span><b>{{$p->cliente->nome}}</b></span></div>
					<div class="itens-cli border-top align-vertical-center justify-space-evenly py-1">
						<span class="text-center"><small>Total Itens:</small> <b>R$ {{$p->valor_total}}</b>	</span><br>
						<span class="text-center"><small>Troco Para:</small> <b class="text-vermelho">R$ {{$p->troco_para}}</b>	</span><br>
						<span class="text-center"><small>Forma Pagto:</small> <b>{{$p->forma_pagamento}}</b>	</span><br>
					</div>
					<div class="tfooter end">
					@if($p->status_id==config('constantes.status.DIGITACAO'))						
							<a href="{{route('delivery.balcao.edit', $p->id)}}" class="btn btn-gra-amarelo btn-min"><i class="fas fa-arrow-right"></i> Atender</a>
					@elseif($p->status_id==config('constantes.status.NOVO'))
							<a href="{{route('delivery.balcao.verPedido', $p->id)}}" class="btn btn-azul2 btn-min"><i class="fas fa-eye"></i> Ver pedidos</a>	
							
							<a href="{{route('delivery.balcao.imprimirPedido', $p->id)}}" class="btn btn-verde2 btn-min"><i class="fas fa-edit"></i> Imprimir</a>				
							<a href="index.php?link=2" class="btn btn-gra-amarelo btn-min"><i class="fas fa-arrow-right"></i> Atender</a>
						@endif	
							
					</div>
				</div>
			</div>
			</div>	
		@endforeach			
				
				
		</div>

	</div>
</div>
</div>
</div>
	
		
		
@endsection
	