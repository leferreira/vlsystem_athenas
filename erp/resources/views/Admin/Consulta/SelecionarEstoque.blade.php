@extends("Admin.template")
@section("conteudo")
<div class="col-12 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Consultas Estoque </span>
						<div>
							<a href="{{route('admin.venda.create')}}" class="btn btn-azul ml-1 d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
						
						</div>
					</div>
                        
					<form name="busca"  method="get">                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">							  			
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data 1</label>
                                            <input type="date" name="data1"   class="form-campo">
                                        </div>
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data 2</label>
                                            <input type="date" name="data2"    class="form-campo">
                                        </div>
                                        
                                        
                                        
                                       
                                </div>
                                </div>
                        </div>
                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Produto</label>
                                            <select class="form-campo" name="produto_id">
                                            <option value="">Selecione</option>
                                            @foreach($produtos as $p)
												<option value="{{$p->id}}" {{( $filtro->produto_id ?? null)==$p->id ? 'selected' : null}}>{{$p->id}} - {{$p->nome}}</option>
											@endforeach
											</select>
                                        </div>
                                        
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Tipo de Relatório</label>
                                            <select class="form-campo" name="tipo_relatorio">
                                            	<option value="listagem">Listagem </option>
                                            	<option value="historico" >Histórico do Produto</option>
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


<div class="col-12 mt-3">
            <div class="px-2">
				<div class="d-flex mb-2 justify-content-space-between center-middle">
					<div class="d-flex radius-4 col-2 state-movi">
						<span><i class="ientrada"><i class="fas fa-arrow-right"></i></i>  Entrada</span>
						<span class=""><i class="isaida"><i class="fas fa-arrow-left"></i></i> Saída</span>
					</div>					
				</div>
                <div class="tabela-responsiva pb-4 table table-bordered">
                      <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                               <tr>
                                  <th align="center">Id</th>
                                  <th align="center">Data</th>
                                  <th align="left">Produto</th>
                                  <th align="center">Valor</th>
                                  <th align="center">qtde</th>
                                  <th align="center">Subtotal</th>
                                  <th align="center">Tipo</th>
                                  <th align="center">Descrição</th>
                                </tr>
                            </thead>
                            <tbody> 
                           @foreach($lista as $m)                                     
                             <tr>
									<td align="center">{{$m->id}}</td>
									<td align="center"><i class="{{($m->ent_sai=='E') ? 'ientrada fas fa-arrow-right' : 'isaida fas fa-arrow-left'}}"></i>{{databr($m->data_movimento)}}</td>
									<td align="center">{{$m->produto->nome ?? "--"}}</td> 
									<td align="center">{{$m->valor_movimento}}</td>											
									<td align="center">{{$m->qtde_movimento}}</td>											
									<td align="center">{{$m->subtotal_movimento}}</td>											
									<td align="center">{{$m->tipoMovimento->tipo_movimento ?? "--"}}</td>											
									<td align="center">{{$m->descricao}}</td>
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
		
<
