@extends("Admin.template")
@section("conteudo")
<div class="col-12 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Consultas Loja Virtual </span>
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
                                            <label class="text-label d-block text-branco">Cliente</label>
                                            <select class="form-campo" name="cliente_id">
                                            <option value="">Selecione</option>
                                            @foreach($clientes as $c)
												<option value="{{$c->id}}" {{( $filtro->cliente_id ?? null)==$c->id ? 'selected' : null}}>{{$c->nome_razao_social}}</option>
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
                    <div class="tabela-responsiva pb-4">
                    <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                             <tr>
                                    <th align="center">Id</th>
                                    <th align="left">Cliente</th>
                                    <th align="center">Data</th>
                                    <th align="center">Forma de Pagamento</th>
                                    <th align="center">Status</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Frete</th>                                    
                                    <th align="center">Valor Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total = 0; ?>
                           @foreach($lista as $p)                                      
                             <tr>
                                <td align="center">{{$p->id}}</td>
                                <td align="center">{{($p->cliente) ? $p->cliente->nome_razao_social: '--'}} </td>
                                <td align="center">{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y H:i:s')}}</td>
                                <td align="center">{{($p->forma_pagamento) ? $p->forma_pagamento->forma_pagto  : '--'}}</td>
                        		<td align="center">{{$p->status->status}}</td>                              
                               
                                <td align="center">{{$p->valor_venda}}</td>
                                <td align="center">{{$p->valor_frete}}</td>
                                <td align="center">{{$p->valor_liquido}}</td>
                                
                             </tr>
                             <?php 
								$total += $p->valor_total;
								?>
                         @endforeach                   						
                        </tbody>
                                </table>
								
                        </div>

                        </div>

                </div>
			
        </div>
</div>

        @endsection
		
<
