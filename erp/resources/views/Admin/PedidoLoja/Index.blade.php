@extends("templates.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de pedidos </span>
						<div>
							<a href="" class="btn btn-laranja filtro mx-1 d-inline-block"><i class="fas fa-filter"></i> Filtrar</a>
						</div>
					</div>
                        
					<form name="busca" action="template_2.php?link=1" method="post">
                        
                        <div class="px-2 pt-2">
							  <div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Data 1</label>
                                            <input type="date" name="categoria" value="" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Data 2</label>
                                            <input type="date" name="categoria" value="" class="form-campo">
                                        </div>
                                        <div class="col-4">	
                                            <label class="text-label d-block text-branco">Status</label>
                                            <select class="form-campo">
												<option>Opção</option>
												<option>Opção</option>
												<option>Opção</option>
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
                                    <th align="center">Forma de Pagamento</th>
                                    <th align="center">Estado Pagamento</th>
                                    <th align="center">Estado Envio</th>
                                    <th align="center">NFE</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Frete</th>
                                    <th align="center">Valor Total</th>
                                    <th align="center">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total = 0; ?>
                           @foreach($lista as $p)                                      
                             <tr>
                                <td align="center">{{$p->id}}</td>
                                <td align="center">{{$p->cliente->nome}} {{$p->cliente->sobre_nome}}</td>
                                <td align="center">{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y H:i:s')}}</td>
                                <td align="center">{{$p->forma_pagamento}}</td>
                                <td align="center">
									<span class="codigo" style="width: 100px;" id="id">
										@if($p->status_pagamento == 'pending')
										<span class="label label-xl label-inline label-light-warning">Pendente</span>

										@elseif($p->status_pagamento == 'approved')
										<span class="label label-xl label-inline label-light-success">Aprovado</span>

										@else
										<span class="label label-xl label-inline label-light-danger">Rejeitado</span>
										@endif
									</span>
								</td>
                                <td align="center">
                                <span class="codigo" style="width: 100px;" id="id">
									@if($p->status_preparacao == 0)

									<span class="label label-xl label-inline label-light-info">Novo</span>
									@elseif($p->status_preparacao == 1)
									<span class="label label-xl label-inline label-light-primary">Aprovado</span>
									@elseif($p->status_preparacao == 2)
									<span class="label label-xl label-inline label-light-danger">Cancelado</span>
									@elseif($p->status_preparacao == 3)
									<span class="label label-xl label-inline label-light-warning">Aguardando Envio</span>
									@elseif($p->status_preparacao == 4)
									<span class="label label-xl label-inline label-light-dark">Enviado</span>
									@else
									<span class="label label-xl label-inline label-light-success">Entregue</span>
									@endif
								</span>
                                
                                </td>
                               
                                <td align="center">{{$p->numero_nfe > 0 ? $p->numero_nfe : '--'}}</td>
                                <td align="center">{{number_format($p->valor_total - $p->valor_frete, 2, ',', '.')}}</td>
                                <td align="center">{{number_format($p->valor_frete, 2, ',', '.')}}</td>
                                <td align="center">{{number_format($p->valor_total, 2, ',', '.')}}</td>
                                <td align="center">
									<a href="{{route('pedidoloja.detalhe', $p->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno"><i class="fas fa-edit"></i> Detalhar</a>
                                </td>
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