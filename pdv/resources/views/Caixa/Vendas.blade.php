@extends("template")
@section("conteudo")

<div class="conteudo">
			<div class="caixa">
			<div class="caixa-titulo py-1 d-flex justify-content-space-between center-middle">
                <span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Lista de Vendas</span>
				<a href="{{route('caixa.caixasAberto')}}" class="btn btn-pequeno btn-azul"><i class="fas fa-arrow-left"></i> Voltar</a>				
             </div>
			 
	<div class="rows">	
		<div class="col-12">
            <div class="col-12 mt-3 mb-3">    				
				<div class="radius-4 p-2 mostraFiltro bg-padrao">    				
					<form action="" method="">
						<div class="rows px-2 pb-3">  	
							<div class="col-9">
								<label class="text-label text-branco">Empresa</label>	
								 <input type="text" value="" name="razao_social" placeholder="Digite aqui..." class="form-campo">
							</div>
							<div class="col-3 mt-4">	
								<input type="submit" value="Pesquisar" class="btn btn-verde width-100 text-uppercase">
							</div>
						</div> 
					</form>
				</div>               
			</div>               
			<div class="col-12">
					<div class="tabela-responsiva px-0">
				
						<table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                                <tr>
                                    <th align="left">Id</th>
                                    <th align="left">Data</th>
                                    <th align="left">Total</th>
                                    <th align="left">Desconto</th>
                                    <th align="left">Valor a Receber</th>
                                    <th align="left">Detalhes</th>
								</tr>
                            </thead>
                            <tbody> 
                           @if($lista)
                            @foreach($lista as $v)                           
                             <tr>
								<td align="center">{{ $v->id }}</td>
								<td align="center">{{ dataBr($v->data_venda) }}</td>
								<td align="center">{{ ($v->valor_venda) ? moedaBr($v->valor_venda) : 0 }}</td>
								<td align="center">{{ moedaBr($v->valor_desconto)  }}</td>
								<td align="center">{{ moedaBr($v->valor_liquido) }}</td>
								<td align="center">
								<a href="{{ route('venda.detalhes', $v->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno img-fluido">
								<i class="fas fa-eye"></i> Detalhes</a>                              </td>									
								
							</tr>   
							@endforeach                          
                          @endif                           
                                                   						
                        </tbody>
                    </table>
					</div>
				</div> 
		
    </div>
   </div>
   </div>
   </div>

@endsection