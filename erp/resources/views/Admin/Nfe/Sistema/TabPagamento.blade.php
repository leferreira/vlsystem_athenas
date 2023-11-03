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
                                    <td align="center"><?php echo $item->id_pagamento  ?></td>
                                    <td align="center"><?php echo $item->tPag ?></td>
                                    <td align="center"><?php echo $item->vPag ?></td>
                                    <td align="center"><?php echo $item->indPag ?></td>
                                    <td align="center"><a href="javascript:;" onclick="excluirPagamento(<?php echo $item->id_pagamento ?>)" class="btn btn-vermelho btn-pequeno d-inline-block" title="Excluir"><i class="fas fa-trash"></i></a></td>
                                </tr>
                               <?php } ?>
							   
                       </tbody>
                    </table>
                  
            </div>
            </div>
  
            </div>