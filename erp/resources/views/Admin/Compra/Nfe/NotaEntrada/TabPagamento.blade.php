<fieldset class="mt-4">
	<legend class="h5 mb-0 text-left">Pagamento </legend>
    <div class="rows pb-4">
			 <div class="col-12">
                <div class="rows">
                        <div class="col-4 mb-3 position-relative">
                            <label class="text-label">Meio de Pagamento</label>
                            <select class="form-campo" name="tPag" id="tPag">
                    			<option value="01" <?php ($notafiscal->tPag=='1') ? 'selected' : null?>>01 - Dinheiro</option>
                    			<option value="02" <?php ($notafiscal->tPag=='2') ? 'selected' : null?>>02 - Cheque</option>
                    			<option value="03" <?php ($notafiscal->tPag=='3') ? 'selected' : null?>>03 - Cartão Crédito</option>
                    			<option value="04" <?php ($notafiscal->tPag=='4') ? 'selected' : null?>>04 - Cartão Débito</option>
                    			<option value="05" <?php ($notafiscal->tPag=='5') ? 'selected' : null?>>05 - Crédito Loja</option>
                    			<option value="10" <?php ($notafiscal->tPag=='10') ? 'selected' : null?>>10 - Vale Alimentação</option>
                    			<option value="11" <?php ($notafiscal->tPag=='11') ? 'selected' : null?>>11 - Vale Refeição</option>
                    		</select>
						</div>                        
                       	
                        <div class="col-3 mb-3">
                                 <label class="text-label">Valor Pagamento</label>
                                 <input type="text" name="vPag" id="vPag"  value="<?php echo $notafiscal->vPag ?>"  class="form-campo">
                        </div>
                        	
                        <div class="col-3 mb-3">
                                 <label class="text-label">Forma de Pagamento</label>
                                 <select class="form-campo" name="indPag" id="indPag">
                        			<option value="0" <?php ($notafiscal->indPag=='0') ? 'selected' : null?>>Pagamento à Vista</option>
                        			<option value="1" <?php ($notafiscal->indPag=='1') ? 'selected' : null?>>Pagamento à Prazo</option>
                        		</select>
                        </div>
                   				
                        <div class="col-2 mt-1 pt-1"> 
                        <input type="button" onclick="inserirPagamento()" value="Inserir" class="btn btn-azul width-100" />                              
                        
                        </div>                                                                                                                    
                </div>
            </div>
            <div class="col-12">
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0"  class="table-bordered">
                            <thead>
                                    <tr>
                                        <th align="center">ID</th>
                                        <th align="center">Meio de Pagamento</th>
                                        <th align="center">Valor</th>
                                        <th align="center">Forma de Pagamento</th>
                                        <th align="center">Excluir</th>
                                  </tr>
                            </thead>
                           <tbody id="lista_pagamento">
                               <?php foreach($pagamentos as $item){ ?>
                                <tr>
                                    <td align="center">{{ $item->id  }}</td>
                                    <td align="center">{{ $item->tPag }}</td>
                                    <td align="center">{{ $item->vPag }}</td>
                                    <td align="center">{{ $item->indPag }}</td>
                                    <td align="center"><a href="javascript:;" onclick="excluirPagamento(<?php echo $item->id_pagamento ?>)" class="btn btn-vermelho btn-pequeno d-inline-block" title="Excluir"><i class="fas fa-trash"></i></a></td>
                                </tr>
                               <?php } ?>							   
                       		</tbody>
                    </table>
                  
            </div>
            </div>
  
            </div>
 
 
<fieldset class="mt-3">
<legend class="h5 mb-0 text-left">Pagamento</legend>	
	<div class="rows">																					
            <div class="col-12">                         
					<div class="rows">
                        <div class="col-3 mb-3 position-relative">
                            <label class="text-label">Meio de Pagamento</label>
                            <select class="form-campo" name="tPag" id="tPag">
                            @foreach(ConstanteService::tiposPagamento() as $chave=>$valor)
                    			<option value="{{$chave}}" {{ ($notafiscal->tPag ?? null ) == $chave ? 'selected' : null }} > {{$valor}}</option>
                    		@endforeach
                    		</select>
						</div>                     
                       	
                        <div class="col-3 mb-3">
                                 <label class="text-label">Forma de Pagamento</label>
                                 <select class="form-campo" name="indPag" id="indPag">
                        			<option value="0" <?php ($notafiscal->indPag=='0') ? 'selected' : null?>>Pagamento à Vista</option>
                        			<option value="1" <?php ($notafiscal->indPag=='1') ? 'selected' : null?>>Pagamento à Prazo</option>
                        		</select>
                        </div>
                        <div class="col-2 mb-3">
                                 <label class="text-label">Valor Pagamento</label>
                                 <input type="text" name="vPag" id="vPag"  value="<?php echo $notafiscal->vPag ?>"  class="form-campo mascara-float">
                        </div>
                        
                        <div class="col-4 mb-3 position-relative">
                            <label class="text-label">Bandeira</label>
                            <select class="form-campo" name="tBand" id="tBand">
                            	<option value=""> Selecione</option>
                                @foreach(ConstanteService::bandeiras() as $chave=>$valor)
                        			<option value="{{$chave}}" {{ ($notafiscal->tBand ?? null ) == $chave ? 'selected' : null }} > {{$valor}}</option>
                        		@endforeach
                    		</select>
						</div>
						<div class="col-2 mb-3">
                                 <label class="text-label">CNPJ Credenciadora</label>
                                 <input type="text" name="CNPJ" id="CNPJ"  value="<?php echo $notafiscal->CNPJ ?>"  class="form-campo">
                        </div>
                        
                        <div class="col-3 mb-3">
                             <label class="text-label">Tipo Integração</label>
                             <select class="form-campo" name="tpIntegra" id="tpIntegra">
                    			<option value="1" <?php ($notafiscal->tpIntegra=='1') ? 'selected' : null?>>Pagamento integrado</option>
                    			<option value="2" <?php ($notafiscal->tpIntegra=='2') ? 'selected' : null?>>Pagamento não integrado</option>
                    		</select>
                        </div>
                        
                        
                        
                        <div class="col-3 mb-3">
                                 <label class="text-label">Num. Autorização</label>
                                 <input type="text" name="cAut" id="cAut"  value="<?php echo $notafiscal->cAut ?>"  class="form-campo">
                        </div>
                        
                        <div class="col-2 mb-3">
                                 <label class="text-label">Troco</label>
                                 <input type="text" name="vTroco" id="vTroco"  value="<?php echo $notafiscal->vPag ?>"  class="form-campo">
                        </div>
                        <div class="col-2 mt-1 pt-1"> 
                        	<input type="button" onclick="inserirPagamento()" value="Inserir" class="btn btn-azul width-100" />                              
                        </div>                    		                                                                                                                   
                </div>
                
                <div class="col-12">
                <div class="tabela-responsiva">
                        <table cellpadding="0" cellspacing="0"  class="table-bordered">
                                <thead>
                                        <tr>
                                            <th align="center">ID</th>
                                            <th align="center">Meio de Pagamento</th>
                                            <th align="center">Valor</th>
                                            <th align="center">Forma de Pagamento</th>
                                            <th align="center">Excluir</th>
                                      </tr>
                                </thead>
                               <tbody id="lista_pagamento">
                                   <?php foreach($pagamentos as $item){ ?>
                                    <tr>
                                        <td align="center">{{ $item->id  }}</td>
                                        <td align="center">{{ $item->pagamento }}</td>
                                        <td align="center">{{ $item->vPag }}</td>
                                        <td align="center">{{ $item->tipo_pagto }}</td>
                                        <td align="center"><a href="javascript:;" onclick="excluirPagamento(<?php echo $item->id ?>)" class="btn btn-vermelho btn-pequeno d-inline-block" title="Excluir"><i class="fas fa-trash"></i></a></td>
                                    </tr>
                                   <?php } ?>
    							   
                           </tbody>
                        </table>
                      
                </div>
                </div>
                    
				 </div>
            </div>		
	</fieldset>		
	
<fieldset>
<legend class="h5 mb-0 text-left">Duplicatas</legend>													
            <div class="rows pt-0">	
																							
            <div class="col-12">
                <div class="caixa">
                <div class="rows">                        
                        <div class="col-3 mb-3">
        					<label class="text-label">Vencimento</label>	                   
        					<input type="date" name="dVenc" id="dVenc"  class="form-campo">
        				</div>    		
        				<div class="col-3 mb-3">
        					<label class="text-label">Valor</label>	                   
        					<input type="text" name="vDup" id="vDup"  class="form-campo">
        				</div> 
                        <div class="col-2 mt-1 pt-1">
                        		<input type="button" onclick="salvarDuplicata()" value="salvarDuplicata" id="btnInserirProduto" class="btn btn-azul width-100">
                        </div>                                                                                                                    
                </div>
                
                    <div class="tabela-responsiva">
                            <table cellpadding="0" cellspacing="0"  class="table-bordered">
                                    <thead>
                                        <tr>
                                            <th align="center">ID</th>
                                            <th align="center">Vencimento</th>
                                            <th align="center">Valor</th>
                                            <th align="center">Excluir</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lista_duplicata">
                                    <?php foreach($duplicatas as $duplicata){?>
                                        <tr>
                                        	<td align="center"><?php echo $duplicata->id ?></td>
                                            <td align="center"><?php echo databr($duplicata->dVenc) ?></td>
                                            <td align="center">R$ <?php echo $duplicata->vDup ?></td>
                                            <td align='center' >
                                            	<a href='javascript:;' onclick='excluirDuplicata({{$duplicata->id}})'  class='btn btn-sm btn-danger d-inline-block' title='Excluir'>
                                            <i class='fas fa-trash'></i></a></td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                            </table>
                    </div>
                </div>
				
					  

					   
            </div>
            </div>
			</fieldset>