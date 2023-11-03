@extends("admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">

                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de solicitação </span>
                       <div>
							<a href="#addnovo" rel="modal" class="btn btn-verde mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Adicionar novo</a>
						</div> 
					</div> 
                        
					
                        
                   
                </div>
                </div>

		<div class="col-12">
		<form name="busca"  id="busca" action="{{route('admin.cotacao.em_massa')}}" method="post">
		@csrf	
            <div class="px-2">
                    <div class="tabela-responsiva pb-4">
                    <table cellpadding ="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                                <tr>
									<th align="center">Marcar</th>
									<th align="center">Id</th>
									<th align="left">Produto</th>
									<th align="center">Data Solicitação</th>
									<th align="center">Status</th>
									<th align="center">Qtde</th>
									<th align="center">Excluir</th>
								</tr>
                            </thead>
                            <tbody>
                     
                         @foreach($solicitacoes as $solicitacao)                                    
                             <tr>
                                <td align="center"><input type="checkbox" name="idSolicitacao[]" value="{{ $solicitacao->id }}"></td>
                                <td align="center">{{$solicitacao->id}}</td>
								<td align="left">{{$solicitacao->produto->nome}}</td>                             											
								<td align="center">{{databr($solicitacao->data_solicitacao)}}</td>                                											
								<td align="center">{{$solicitacao->status->status_solicitacao}}</td>                                											
								<td align="center">{{$solicitacao->qtde}}</td>                                      											
                                 <td align="center">
                              
                              </tr>
                           @endforeach  
                                     						
                        </tbody>
                                </table>
								
                        </div>

					<div class="px-2 pt-2">
							<div class="d-flex text-end">
								<button class="btn btn-roxo mx-1 text-branco" type="submit"><i class="fas fa-arrow-alt-circle-right"></i> Fazer cotação em massa</button>
								
							</div>	
					
                        </div>
                        </div>
            </form>
                        
                        </div>

              			     
                 
                </div>
	
        </div>



	<div class="window" id="addnovo">
		<div class="caixa mb-0">
			<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco position-relative">
				<i class="far fa-arrow-alt-circle-right"></i> CADASTRAR NOVA SOLICITAÇÃO
				<a href="" class="fechar">x</a>
			</span>
			<div class="p-5">
                            <form name="salvarSolicitacao" id="salvarSolicitacao" action="{{route('solicitacao.store')}}" method="POST">
                            @csrf	
                            <div class="rows  py-3 px-5">							
                                    <div class="col-12">
                                        <label class="text-label">Produto</label>
                                        <select class="form-campo" name="produto_id" id="produto_id">
                                            @foreach($insumos as $produto)
                								<option value='{{$produto->id}}'>{{$produto->nome}}</option>
                							@endforeach
                                         </select>
                                    </div>
                                    <div class="col-8">
                                            <label class="text-label">Data da Entrega</label>
                                            <input type="date"  name="data_entrega" id="data_entrega" value="{{date('Y-m-d')}}" placeholder="Digite aqui..." class="form-campo">
                                    </div>


                                    <div class="col-4">
                                       <label class="text-label"  >Qtde</label>
                                       <input type="text" name="qtde" value="1" id="qtde" placeholder="Digite aqui..." class="form-campo">
                                    </div>                               
                                    <div class="col-12 mt-4">
                                    	<input type="hidden" name="data_solicitacao"  value="{{date('Y-m-d')}}" />
                                    	<input type="hidden" name="hora_solicitacao"  value="{{date('H:i:s')}}" />
                                    	<input type="hidden" name="status_solicitacao_id"  value="1" />
                                        <input type="submit" value="Salvar alterações" id="btnInserir" class="btn btn-verde btn-medio d-block m-auto">
                                   </div>

                            </div>
                        </form>		
			</div>
		</div>
	</div>
	
<div id="mascara"></div>
@endsection