@extends("template")
@section("conteudo")
<div class="caixa">
	<div class="thead between mb-3">
			<h1 class="titulo mb-0"><strong>Pedido</strong> <small class="mig">Veja seus pedidos abaixo</small></h1>		
			<a href="{{route('create')}}" class="btn btn-azul"><i class="fas fa-plus-circle"></i> Adicionar Pedido</a>	
	</div>
	
	<div class="p-2">
	<div class="caixa">
	<div  class="p-2 alt mb-3 border-bottom bg-cinza">
		<form name="busca" action="{{route('home')}}" method="get">
			<div class="rows">
				<div class="col-3">
					<label class="text-label"><small> por data 1:</small><input type="date" name="data1" value="{{$filtro->data1 ?? null}}" class="form-campo"></label>
				</div>
				<div class="col-3">
					<label class="text-label"><small>por data 2:</small><input type="date" name="data2" value="{{$filtro->data2 ?? null}}" class="form-campo"></label>
				</div>			
				
			<div class="col-2  mt-1 pt-1">					
				<input type="submit" value="pesquisar" class="btn btn-roxo width-100">
			</div>
			</div>	
		</form>
</div>	
	
	<div class="p-2">
	<div class="base-lista">
			<div class="caixa alt">
		<div class="titulo mb-0 px-2 border-bottom"><i class="fas fa-list"></i> Minhas Assinaturas </div>
			<div class="tabela-responsiva">
				<table width="100%" cellpadding="0" cellspacing="0" class="tabela" id="">			
					
					<thead>
					<tr>
						<th width="3%" align="center">ID:</th>
						<th width="10%">Data Início:</th>
						<th width="10%">Data Fim:</th>
						<th width="10%">Valor Contrato:</th>
						<th width="2%" >Valor Recorrente</th>
						<th colspan="2" width="10%">Ver Cobranças</th>
					</tr>
					</thead>
					<tbody>
					@foreach($assinaturas as $a)										
						 <tr class="ativo">
							<td align="center">{{$a->id}}</td>
							<td align="center">{{databr($a->data_inicio)}}</td>									
							<td align="center">{{($a->data_fim) ? databr($p->data_fim) : '--'}}</td>	
							<td align="center">R$ {{$a->valor_liquido}}</td>
							<td align="center">R$ {{$a->valor_recorrente}}</td>
							<td align="center"><a href="{{route('assinatura.cobrancas', $a->id)}}" class="btn btn-azul"><i class="fas fa-eye"></i> Ver Cobranças</a></td>
						 	
						  </tr>
					@endforeach											
						 
					  
					</tbody>
					
				</table>
		</div>					
	</div>
	</div>

</div>

<div class="p-2">
	<div class="base-lista">
			<div class="caixa alt">
		<div class="titulo mb-0 px-2 border-bottom"><i class="fas fa-list"></i> LISTA DE PEDIDOS </div>
			<div class="tabela-responsiva">
				<table width="100%" cellpadding="0" cellspacing="0" class="tabela" id="">			
					
					<thead>
					<tr>
						<th width="3%" align="center">ID:</th>
						<th width="10%">Data:</th>
						<th width="10%">Total(R$):</th>
						<th width="10%">Data Atendimento</th>
						<th width="2%" >Status:</th>
						<th colspan="2" width="10%">Editar</th>
					</tr>
					</thead>
					<tbody>
					@foreach($pedidos as $p)										
						 <tr class="ativo">
							<td align="center">{{$p->identificador}}</td>
							<td align="center">{{databr($p->data_pedido)}}</td>
							<td align="center">R$ {{$p->total}}</td>		
							<td align="center">{{($p->data_atendimento) ? databr($p->data_atendimento) : '--'}}</td>					
							<td align="center">{{$p->status->status}}</td>
							<td align="center"><a href="{{route('pedido.detalhe', $p->identificador)}}" class="btn btn-azul"><i class="fas fa-eye"></i> Detalhes</a></td>
						 	
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