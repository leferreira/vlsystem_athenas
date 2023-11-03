@extends("template")
@section("conteudo")

<div class="conteudo-fluido">
			<div class="caixa">
			<div class="caixa-titulo py-1 d-flex justify-content-space-between">
                <span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Lista de Caixas</span>
				<div>
					<a href="<?php echo "produto/create"?>" class="btn btn-verde  d-inline-block"><i class="fas fa-plus-circle mb-0"></i> Adicionar novo</a>
					<a href="" class="btn btn-amarelo filtro mx-1 d-inline-block"><i class="fas fa-filter"></i> Filtrar</a>
				</div>
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
						<table cellpadding="0" cellspacing="0" id="dataTable">
                            <thead>
                                <tr>
                                    <th align="center">Id</th>
                                    <th align="left" >Data Abertura</th>
                                    <th align="center" >Valor Abertura</th>
                                    <th align="center">Data Fechamento</th>
                                    <th align="center">Valor Vendido</th>
                                    <th align="center">Status</th>
                                    <th align="center">Detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                         
                            @foreach ($lista as $cx)                                               
								<tr>
									<td align="center">{{ $cx->id  }}</td>
									<td align="center">{{  databr($cx->data_abertura) }}</td>
									<td align="center">{{  $cx->valor_abertura }}</td>
									<td align="center">{{  ($cx->data_fechamento) ? databr($cx->data_fechamento) : '00/00/0000' }}</td>
									<td align="center">{{  ($cx->valor_vendido) ? moedaBr($cx->valor_vendido): null }}</td>
									<td align="center">{{  $cx->status_id }}</td>
									<td align="center">
										<a href="{{route('caixa.detalhes', $cx->id)}}" class="d-inline-block btn btn-outline-verde btn-pequeno"><i class="fas fa-edit"></i> Detalhes</a>
									</td>
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

@endsection