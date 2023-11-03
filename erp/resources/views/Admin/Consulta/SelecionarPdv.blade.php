@extends("Admin.template")
@section("conteudo")
<div class="col-12 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Consultas PDV </span>
						<div>
							<a href="{{route('admin.venda.create')}}" class="btn btn-azul ml-1 d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
						
						</div>
					</div>
                        
					<form name="busca"  method="get">                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">						  			
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Uuid</label>
                                            <input type="text" name="uuid" value="{{$filtro->uuid ?? ''}}"   class="form-campo">
                                        </div>
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data 1</label>
                                            <input type="date" name="data1" value="{{$filtro->data1 ?? ''}}"   class="form-campo">
                                        </div>
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data 2</label>
                                            <input type="date" name="data2"  value="{{$filtro->data1 ?? ''}}"   class="form-campo">
                                        </div>
                                        
                                        
                                        
                                       
                                </div>
                                </div>
                        </div>
                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Vendedor</label>
                                            <select class="form-campo" name="vendedor_id">
                                            <option value="">Selecione</option>
                                            @foreach($vendedores as $c)
												<option value="{{$c->id}}" {{( $filtro->vendedor_id ?? null)==$c->id ? 'selected' : null}}>{{$c->nome}}</option>
											@endforeach
											</select>
                                        </div>
                                        
                                     
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Status</label>
                                            <select class="form-campo" name="status_id">
                                            <option value="">Selecione</option>
                                            @foreach($status as $c)
												<option value="{{$c->id}}" {{( $filtro->status_id ?? null)==$c->id ? 'selected' : null}}>{{$c->status}}</option>
											@endforeach
											</select>
                                        </div>
                                        
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Usuario</label>
                                            <select class="form-campo" name="usuario_id">
                                            <option value="">Selecione</option>
                                            @foreach($usuarios as $s)
												<option value="{{$s->id}}" {{( $filtro->usuario_id ?? null)==$s->id ? 'selected' : null}}>{{$s->name}}</option>
											@endforeach
											</select>
                                        </div>
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Tipo de Relatório</label>
                                            <select class="form-campo" name="tipo_relatorio">
                                            	<option value="listagem">Listagem de Vendas</option>
                                            	<option value="resumo_diario" >Resumo Diário</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Tipo de Saída</label>
                                            <select class="form-campo" name="tipo_saida">
                                            	<option value="tela">Visualizar na Tela</option>
                                            	<option value="pdf">Gerar PDF</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="Filtrar" class="btn btn-roxo text-uppercase">
                                        </div>
                                </div>
                                </div>
                        </div>
                    </form>
                </div>
                </div>

			<div class="col-12">

				<div class="px-2">
					<div class="rows">
					<div class="col">
						<div class="tabela-responsiva pb-4">
						<table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
								<thead>
								 <tr>
										<th align="center">Id</th>
                                    <th align="center">Data</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Desconto</th>
                                    <th align="center">Líquido</th>
                                    <th align="center">Cliente</th>
                                    <th align="center">Status</th>
                                    <th align="center">Uuid</th>
									</tr>
								</thead>
								<tbody>
							
								
								<?php $total = 0; ?>
							   @foreach($lista as $c)                                      
								 <tr>
									<td align="center">{{$c->id}} </td>
									<td align="center">{{ databr($c->data_venda)}}</td>                                
                                    <td align="center">{{ $c->valor_venda  }}	</td>
                                    <td align="center">{{ $c->valor_desconto  }}	</td>
                                    <td align="center">{{ $c->valor_liquido  }}	</td>
                                    <td align="center">{{ $c->cliente_nome}}</td>
									<td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>	
									<td align="center">{{ $c->uuid}}</td>
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
		
<
