@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Pedidos do Cliente </span>
						<div>
						
							<a href="" class="btn btn-roxo filtro ml-1 d-inline-block" title="Filtrar"><i class="fas fa-filter"></i> </a>
						</div>
					</div>
                        
					<form name="busca" action="{{route('admin.pedidocliente.filtro')}}" method="get">                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data 1</label>
                                            <input type="date" name="data1" value="{{$filtro->data1 ?? null}}" class="form-campo">
                                        </div>
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data 2</label>
                                            <input type="date" name="data2" value="{{$filtro->data2 ?? null}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Status </label>
                                            <select class="form-campo" name="status_id">
                                            <option value="">Selecione</option>
                                            @foreach($status as $s)
												<option value="{{$s->id}}" {{( $filtro->status_id ?? null)==$s->id ? 'selected' : null}}>{{$s->status}}</option>
											@endforeach
											</select>
                                        </div>
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Cliente</label>
                                            <select class="form-campo" name="cliente_id">
                                            <option value="">Selecione</option>
                                            @foreach($clientes as $c)
												<option value="{{$c->id}}" {{($filtro->cliente_id ?? null)==$c->id ? 'selected' : null}}>{{$c->nome_razao_social}}</option>
											@endforeach
											</select>
                                        </div>
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="Pesquisar" class="btn btn-roxo text-uppercase">
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
                                    <th align="center">Hora</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Data Atendimento</th>
                                    <th align="center">Status</th>
                                    <th align="center">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total = 0; ?>
                           @foreach($lista as $c)                                      
                             <tr>
                                <td align="center">{{$c->id}}</td>
                                <td align="center">{{$c->cliente->nome_razao_social}}</td>
                                <td align="center">{{ databr($c->data_venda)}}</td>
                                <td align="center">{{ $c->hora_pedido  }}	</td>
                                <td align="center">{{ $c->total  }}	</td>
                                <td align="center">{{($c->data_atendimento) ? databr($c->data_atendimento) : '--'}}</td>
                                <td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>                               
                               
                                <td align="center"> 
                                 		<a href="{{route('admin.pedidocliente.show', $c->id)}}" class="d-inline-block btn btn-roxo btn-pequeno" title="Visualizar Pedido"><i class="fas fa-eye"></i> </a>
                                 		@if($c->venda_id)
                                 			<a href="{{route('admin.venda.detalhe', $c->venda_id)}}" class="d-inline-block btn btn-roxo btn-pequeno" title="Visualizar Venda"><i class="fas fa-paper-plane"></i> </a>
                               			@endif
                               			
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
@endsection