@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
              <div class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
                <span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i>  FILTRAR ENTRADA </span>
				 <div class="d-flex">
					<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
				</div>
			</div>	
          								
                <div class="rows">	  	

                    <div class="col-12 mb-3">
						                      
                        <div class="px-3">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <form name="busca" action="{{route('admin.entrada.filtro')}}" method="get"> 
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
                                            <label class="text-label d-block text-branco">Produtos</label>
                                            <select class="form-campo" name="produto_id">
                                            <option value="">Selecione</option>
                                            @foreach($produtos as $p)
												<option value="{{$p->id}}" {{( $filtro->produto_id ?? null)==$p->id ? 'selected' : null}}>{{$p->nome}}</option>
											@endforeach
											</select>
                                        </div>
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="Pesquisar" class="btn btn-roxo text-uppercase">
                                        </div>
                                </div>
                                </form>
                                </div>
							</div>
					
					</div>
					
					
                    <div class="col-12">   
                        <div class="px-3">
                        <div class="caixa mb-3 mt-3">
							<fieldset class="p-1 pt-3">
							 <legend> Itens do pedido </legend>
                            		   
                            <div class="col-12 mb-3">
							  
								<div class="pb-2">
									<div class="rows">
										<div class="col-6 position-relative mb-3">
											<label class="text-label">Produto</label>
											<div class="group-btn">	  
												<input type="text" name="produtoentreda" id="produtoentreda" class="form-campo">
												<a href="{{route('admin.produto.create')}}"  class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
    										</div>											
										</div>
										<div class="col-2">	
                                            <label class="text-label d-block ">Unidade</label>
                                            <select id="unidade_entrada" name="unidade" class="form-campo" onchange="selecionarUnidade()"></select>
                                        </div>
                                        
										<div class="col-2 mb-3">
											<label class="text-label">Valor</label>
											<input type="text" id="preco" name="preco" value="" class="form-campo mascara-float">
										</div>
										<div class="col-2 mb-3">
											<label class="text-label">Qtde</label>
											<input type="text" name="qtde" id="qtde" value=""  class="form-campo mascara-float">
										</div>
										<div class="col-2 mb-3">
											<label class="text-label">Subtotal</label>
											<input type="text" name="subtotal" id="subtotal" value="" class="form-campo mascara-float">
										</div>
										
										<div class="col-6">
											<label class="text-label">Observação</label>
											<input type="text" name="observacao" id="observacao" value="" class="form-campo">
										</div>
										
										<div class="col-2 mt-1 pt-1">
										   <input type="hidden" id="produto_id" name="produto_id">
										   <input type="hidden" id="usa_grade" name="usa_grade">
										   <input type="hidden" id="estoque" >
										   <input type="hidden" id="estoque_grade" >
										   <a href="javascript:;" onclick="verificarInserirEntrada('entrada')" class="btn btn-azul width-100"> Inserir</a>
										</div>
									</div>
									</div>
								
                            </div>
							<div class="col-12 mb-3">
								<div class="border radius-4 pb-4">
									<div class="tabela-responsiva sm tborder tborder pb-3">  
											<table cellpadding="0" cellspacing="0" class="mb-0 table-bordered">
												<thead>
												   <tr>
													  <th align="center">Item</th>
													  <th align="center">Data</th>
													  <th align="left" width="290">Produto</th>
													  <th align="center">Qtde</th>     
													  <th align="center">Unidade</th> 
													  <th align="center">Valor</th>      
													  <th align="center">Subtotal</th> 
													</tr>
												</thead>
												<tbody id="lista_entradas"> 
													@foreach($lista as $entrada)
													@php
														$descricao = isset($entrada->grade) ? $entrada->produto->nome . " " .$entrada->grade->descricao : $entrada->produto->nome;  
													@endphp
													 <tr> 
															<td align="center">{{$entrada->id}}</td>
															<td align="center">{{databr($entrada->data_entrada)}}</td>
															<td align="left">{{ $descricao }}</td>
															<td align="center">{{$entrada->qtde_entrada}}</td>
															<td align="center">{{$entrada->unidade}}</td>
															<td align="center">R$ {{$entrada->valor_entrada}}</td>
															<td align="center">R$ {{$entrada->subtotal_entrada}}</td>                                                   
													</tr>
													@endforeach
													 <tr> 
														 <td align="right" colspan="7"><b>Total:</b> <span class="text-verde minimo-font" id="total_entrada">R$ {{$soma}}</span></td>                                                 
													</tr>    	
												</tbody>
											</table>
									</div>	            
								</div>	            
                            </div>
							</fieldset>							
                        </div>            
                    </div>
                    </div>
                </div>
        	
</div>
@include ("Admin.Cadastro.Produto.modal.modalGradeParaEntradaSaida")
@endsection
