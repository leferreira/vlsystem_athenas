<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Compra</span>
	<div class="d-flex">
		<a href="{{route('admin.compra.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	
	</div>
</span>                      


			<div class="p-2 pb-0">
			<div class="rows">	
		
			
			<div class="col-12">
                <div class="caixa"> 
                    <fieldset class="pt-0 bg-padrao mb-0">
						 <div class="">							  
							<span class="titulo text-branco px-0">Dados da Compra </span>
							<div class="mt-2 radius-4">
							 <div class="rows">								 	
                                        
							 		  	<div class="col-3">	
                                            <label class="text-label d-block text-branco">Data Compra</label>
                                            <input type="date" name="data_compra" id="data_compra" value="{{$compra->data_compra ?? hoje()}}" class="form-campo ">
                                        </div>                                       
                                        <div class="col-6">
                                            <label class="text-label d-block text-branco">Fornecedor</label>
                                            <div class="group-btn">	                                
                                                <input type="text" name="desc_fornecedor" id="desc_fornecedor" value="{{$fornecedor->razao_social ?? null}}" class="form-campo">
                                                <input type="hidden" name="fornecedor_id" value="{{$fornecedor->id ?? null}}"  id="fornecedor_id" >       
                							</div>                               
                                        </div>
                                      <div class="col-2">	
                                         <label class="text-label d-block text-branco">Total da Compra</label>
                                         <input type="text" name="totalcompra" disabled  id="totalcompra" value="{{($compra->valor_total) ?? old('valor_total')}}" class="form-campo">
                                     </div>
                							  			                                        
                                </div>
                                </div>
							</div>
                        </fieldset>   
					             
                </div>
			</div>
		</div>
	  </div>
   <div id="tab">
	  <ul>
		<li><a href="#tab-1">Itens</a></li>
		<li><a href="#tab-2">Pagamento</a></li>
	  </ul>
	 
	   <div id="tab-1">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">		

                <fieldset class="mt-3 mb-0">                 
				<legend>Itens da Compra</legend>
                   
                
                <div class="tabela-responsiva pb-4 prod table border-top mt-4 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" id="" width="100%">
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th align="center">Nome</th>
                                    <th align="center">Unidade</th>
                                    <th align="center">Quantidade</th>
                                    <th align="center">Valor Unit</th>
                                    <th align="center">Subtotal</th>
                                    <th align="center">Desconto (unit)</th>
                                    <th align="center">Desconto (total)</th>
                                    <th align="center">Líquido</th>
                                    <th align="center">Situação</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($compra->itens as $v)
                            	<tr>
                            		<td align="center">{{$v->id}}</td>
                            		<td align="center">{{$v->produto->nome}}</td>
                            		<td align="center">{{$v->produto->unidade}}</td>
                            		<td align="center">{{$v->quantidade}}</td>
                            		<td align="center">{{formataNumeroBr($v->valor)}}</td>
                            		<td align="center">{{formataNumeroBr($v->subtotal)}}</td>
                            		<td align="center">{{formataNumeroBr($v->desconto_por_unidade)}}</td>
                            		<td align="center">{{formataNumeroBr($v->total_desconto_item)}}</td>
                            		<td align="center">{{formataNumeroBr($v->subtotal_liquido)}}</td>                            		
                            		@if($v->produto->usa_grade=="S")
                            			<td align="center">
                            				@if(validarGrade($v->quantidade, 'item_compra_id', $v->id ))
                            					ok
                                         	@else
                                     		  <a href="javascript:;" onclick="abrirGradeProduto({{$v->id }}, {{$v->produto_id }}, 'item_compra_id')" title="Excluir">Ajustar Grade</a>
                                         	@endif
                                         </td>
                            		@else
                            			<td align="center">ok</td>
                            		@endif
                            				
                            	</tr>
                            @endforeach
                           
							</tbody>
                            </table>
								
                   </div>

                </fieldset>

            	 
	
			</div>
		</div>
	  </div>
	  </div>
	  
	  <div id="tab-2">
		<div class="p-2">
	
				
          <fieldset class="mt-3 mb-0"> 
			<div class="rows">
			<div class="col-12">		
             <fieldset class="p-2">
				<legend class="h5 mb-0 text-left">Dados de Pagamento </legend>
			 
            <div class="caixa px-2">
            <div class="rows">
            	<div class="col-4 mb-3" id="ver_combo_notar_refereciada">
                 	<label class="text-label">Forma de Pagamento</label>	
               	 	<select class="form-campo" id="tPag" >		
            			 @foreach(ConstanteService::tiposPagamento() as $chave=>$valor)
                			<option value="{{$chave}}" {{ ($notafiscal->tPag ?? null ) == $chave ? 'selected' : null }} >{{$chave}} - {{$valor}}</option>
                		 @endforeach
            		</select>	
                </div>
                <div class="col-3 mb-3" >
                 	<label class="text-label">Forma de Parcelar</label>	
               	 	<select class="form-campo" id="forma_de_parcelar" onchange="mudarTipoInput()">		
            			<option value="1">1 - Número de Parcelas</option>
                		<option value="2">2 - Condições especiais</option>
            		</select>	
                </div>
                
            	<div class="col-2 mb-3" >
                 	<label class="text-label">Parcelas</label>	
               	 	<input type="number"  class="form-campo " value="1" id="qtde_parcela">	
                </div>
                
                
              
                <div class="col-1 mt-1 pt-1">
                	<input type="hidden" id="compra_id" value="{{$compra->id}}">
                	<input type="button" onclick="inserirDuplicata()" value="Ok" class="btn btn-azul width-100" />                              
                </div> 
                
            </div>
            
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0" class="table table-bordered menor fatura" width="100%">
                    <thead>
						<tr>
                            <th align="center">Id</th>
                            <th align="center">Data</th>
                            <th align="center">Forma Pagto</th>
                            <th align="center">Valor</th>     
                            <th align="center">Observação</th>                       
                            <th align="center">Salvar</th>
                             <th align="center">Excluir</th>
                        </tr>
                    </thead>
                    <tbody id="lista_duplicata">
                  @foreach($duplicatas as $duplicata)
                            <tr>
                            	<td align="center">{{$duplicata->nDup}}</td>
                                <td align="center" width="10%"><input type="date" value="{{$duplicata->dVenc}}" id="vencimento_{{$duplicata->id}}" class="form-campo" onchange="alterarDuplicata({{$duplicata->id}})" ></td>
                                
                                <td align="center" width="25%">
                                    <select class="form-campo" name="tPag" id="tPag_{{$duplicata->id}}" onchange="alterarDuplicata({{$duplicata->id}})">		
                            			 @foreach(ConstanteService::tiposPagamento() as $chave=>$valor)
                                			<option value="{{$chave}}" {{ ($duplicata->tPag ?? null ) == $chave ? 'selected' : null }} >{{$chave}} - {{$valor}}</option>
                                		 @endforeach
                            		</select>
        						</td>
                                <td align="center" width="15%"><input type="text" readonly="readonly" value="{{ $duplicata->vDup }}" name="primeiro_vencimento"  class="form-campo"></td>
                                <td align="center" width="35%"><input type="text"  id="obs_{{$duplicata->id}}" value="{{ $duplicata->obs }}" class="form-campo"></td>
                                <td align="center"><a href="javascript:;" onclick="alterarDuplicata({{$duplicata->id}})"   class="btn btn-outline-verde d-inline-block  btn-pequeno" title="Detalhes">Salvar </a></td>
                                
                                <td align='center' >
                                	<a href='javascript:;' onclick='excluirDuplicata({{$duplicata->id}})'  class='btn btn-sm btn-danger d-inline-block' title='Excluir'>
                                <i class='fas fa-trash'></i></a></td>
                            </tr>
                     @endforeach
                    </tbody>
           </table>	
                  
            </div>

		
            </div>
			
     
		</fieldset>
			</div>
			   
			</div>
		</fieldset>
	
	
		
	
	
    </div>  
 </div>
 

	<fieldset class="mt-4">
    	<legend>Finalizar</legend>	   
    				<div class="rows">	
    					<div class="col-12">
    					</div>		
    						
    						<div class="col-12 text-center pb-4">
                    			<button type="button" class="btn btn-azul m-auto d-block" id="salvar-compra" href="#" onclick="abrirModalFinalizarCompra()"><i class="fas fa-check"></i> Finalizar Compra</button>                		
                    		</div>
    				</div>
    	</fieldset>
 </div>  
		
</div>


<div class="window medio" id="modal_finalizar_compra">
	<div class="p-2 px-4">
			<span class="pt-4 d-block h3 border-bottom fw-700">Finalizar Compra</span>
		<div class="rows">
             <div class="col-12 mb-3">
                   <span class="text-label fw-700 h5 mb-1">Selecione as opções desejadas</span>
                    <div class="width-100 border radius-4">
                        <div class="check radio p-4 d-block">							
        					<label class="d-flex mb-1"><input type="checkbox"  id="lancar_estoque" name="lancar_estoque" checked value="S"> Lançar estoque</label>
        					<label class="d-flex mb-1"><input type="checkbox"  id="lancar_financeiro" name="lancar_financeiro" checked value="S" > Gerar Financeiro</label>
        				</div>        			
    				</div>
    				  
             </div>                                 
         </div>
		 <div class="tfooter border-0 between">
			<div class="d-flex">
				<a href="javascript:;" onClick="finalizarCompra({{$compra->id}})" class="btn btn-verde border-bottom" >Finalizar Compra</a>
		 </div>
			<a href="" class="btn btn-vermelho fechar">Fechar</a>
		 </div>
	</div>
</div>





<script>
	var TOTAL = "{{$compra->valor_total}}";
	var TOTAL_VENDA = "{{$compra->valor_compra}}";
	
	function mudarTipoInput(){
		var tipo = $("#forma_de_parcelar").val();
		if(tipo=="1"){
			$("#qtde_parcela").val("1");
			$("#qtde_parcela").prop("type", "number")
		}else{
			$("#qtde_parcela").val("");
			$("#qtde_parcela").prop("type", "text")
		}
		
	}
</script>
   @include ("Admin.Cadastro.Produto.modal.modalListaGrade")
@endsection