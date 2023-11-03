@extends("admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco justify-content-space-between d-flex">
	<span><i class="fas fa-plus-circle"></i> Nova Ordem de Compra </span>
	<a href="{{route('admin.ordemcompra.index')}}" class="btn btn-azul btn-pequeno"><i class="fas fa-arrow-left"></i> Voltar</a> 
</span>	
   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2">
			<div class="rows">	
			
			<div class="col-12">
                <div class="caixa"> 
                    <div class="pt-0">
						 <div class=" mt-2">							  
							<fieldset>
							<legend>Dados da Ordem</legend>
							 <div class="rows">
							 			<div class="col-3 mb-3">	
                                            <label class="text-label d-block ">Data Emissão</label>
                                            <input type="date" name="data_emissao" id="data_emissao" value="{{hoje()}}" class="form-campo">
                                        </div>
                                        
							  			<div class="col-6 mb-3">	
                                            <label class="text-label d-block">Fornecedor</label>
                                            <select id="fornecedor_id" name="fornecedor_id" class="form-campo fornecedor">
												<option value="--">Selecione o fornecedor</option>
												@foreach($fornecedores as $f)
												<option value="{{$f->id}}">{{$f->razao_social}} ({{$f->cnpj}})</option>
												@endforeach
											</select>
                                        </div>
                                        
                                        <div class="col-3 mb-3">	
                                            <label class="text-label d-block ">Prazo Recebimento</label>
                                            <input type="date" name="prazo_recebimento" id="prazo_recebimento"  class="form-campo">
                                        </div>                                       
                               
                                </div>
                            </fieldset>  
							
                            <fieldset class="mt-4 p-2">
							<legend>Itens da Ordem de Compra</legend>
							 <div class="rows">	
                                        <div class="col-4">	
                                            <label class="text-label d-block ">produto</label>
                                            <select   id="produto_id" class="form-campo select2 produto">
                                            	<option value="--">Selecione o Produto</option>
												@foreach($produtos as $p)
													<option value="{{$p->id}}">{{$p->id}} - {{$p->nome}}</option>
												@endforeach
											</select>
                                        </div>
                                        
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Qtde</label>
                                            <input type="text"  id="quantidade" value="1" class="form-campo">
                                            <input type="hidden" id="desc_produto">
                                        </div>
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Val Unit</label>
                                            <input type="text" name="valor" disabled value="0" id="valor" class="form-campo">
                                        </div>
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Subtotal</label>
                                            <input type="text" name="subtotal" disabled value="0" id="subtotal" class="form-campo">
                                        </div>
                                        
                                        <div class="col-2 mt-1">
                                        	<a style="margin-top: 11px;" id="addProd" class="btn btn-roxo text-uppercase">
														Adicionar
											</a>
                                        </div>
										
									<div class="col-12">
										<div class="tabela-responsiva pb-4 prod prod table border-top mt-4 border-left border-bottom border-right" style="background: #f3f3f3;">
											<table cellpadding="0" cellspacing="0" id="" width="100%">
												<thead>
												 <tr>
														<th align="center">#</th>
														<th align="center">Código</th>
														<th align="center">Nome</th>
														<th align="center">Quantidade</th>
														<th align="center">Valor Unit</th>
														<th align="center">Subtotal</th>
														<th align="center">Ação</th>
													</tr>
												</thead>
												<tbody class="datatable-body"></tbody>
											</table>								
										</div>									
									</div>									
                    		
                                </div>
                             </fieldset>
                             
                        </div>
                    
                </div>
                </div>
                
                


			</div>
			
			<div class="col-12">
          
             <fieldset class="mt-3 p-2">	
				<legend>Observações</legend>
				<div class="rows">	
             			<div class="col-12 mb-3">
								<label class="text-label">Observação </label>	
								<input type="text" name="observacao" value="" id="observacao" class="form-campo">
						</div>
						<div class="col-12 text-center pb-4 m-auto">							
                			<button type="button"  id="salvar-venda" class="btn btn-azul m-auto" href="#" onclick="salvarCompra()"><i class="fas fa-check"></i> Finalizar</button>
                		</div>
				</div>
				</fieldset>
			</div>
			
		</div>
	  </div>
	  </div>
  
	  <input type="hidden" id="_token" value="{{ csrf_token() }}">  
      
 </div>
</div>
@endsection