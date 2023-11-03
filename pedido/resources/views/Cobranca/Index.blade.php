@extends("template")
@section("conteudo")
<div class="caixa">
	<div class="thead between mb-3">
			<h1 class="titulo mb-0"><strong>Cobranças</strong> <small class="mig">Veja seus pedidos abaixo</small></h1>		
			<a href="{{route('home')}}" class="btn btn-azul"><i class="fas fa-plus-circle"></i> Volta</a>	
	</div>
	
	<div class="p-2">
	<div class="caixa">
	
	<div class="p-2">
	<div class="base-lista">
			<div class="caixa alt">
		<div class="titulo mb-0 px-2 border-bottom"><i class="fas fa-list"></i> LISTA DE Cobrancas </div>
			<div class="tabela-responsiva">
				<table width="100%" cellpadding="0" cellspacing="0" class="tabela" id="">			
					
					<thead>
					<tr>
						<th width="3%" align="center">#</th>
						<th width="10%">Descrição</th>
						<th width="10%">Data Cadastro:</th>
						<th width="10%">Total(R$):</th>
						<th width="10%">Data Vencimento</th>
						<th width="10%">Data Pagamento</th>
						<th width="2%" >Status:</th>
						<th colspan="2" width="10%">Editar</th>
					</tr>
					</thead>
					<tbody>
					@foreach($lista as $p)										
						 <tr class="ativo">
							<td align="center">{{$p->id}}</td>
							<td align="center">{{$p->descricao}}</td>
							<td align="center">{{databr($p->data_cadastro)}}</td>
							<td align="center">R$ {{$p->valor}}</td>		
							<td align="center">{{databr($p->data_vencimento)}}</td>		
							<td align="center">{{($p->data_pagamento) ? databr($p->data_pagamento) : '--'}}</td>				
							<td align="center">{{$p->status_financeiro->status}}</td>
							<td align="center"><a href="{{route('detalhe', $p->uuid)}}" class="btn btn-azul"><i class="fas fa-eye"></i> Detalhes</a></td>
						 	
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