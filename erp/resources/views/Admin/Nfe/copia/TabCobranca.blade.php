
<fieldset class="mt-3">
<legend class="h5 mb-0 text-left">Faturas</legend>	
	<div class="rows">																					
            <div class="col-12">             
					<div class="rows">   
						<div class="col mb-3">
							<label class="text-label">Número da fatura</label>	                   
							<input type="text" name="nFat" id="nFat" value="<?php echo $notafiscal->nFat ?>" placeholder="Digite aqui..." class="form-campo">
						</div>     
						<div class="col mb-3">
							<label class="text-label">Valor original fat.</label>	                   
							<input type="text" name="vOrig" id="vOrig" value="<?php echo $notafiscal->vOrig ?>" placeholder="Digite aqui..." class="form-campo">
						</div>     
						<div class="col mb-3">
							<label class="text-label">Valor desconto</label>	                   
							<input type="text" name="vDesc" id="vDesc" value="<?php echo $notafiscal->vDesc  ?>" placeholder="Digite aqui..." class="form-campo">
						</div>    
						<div class="col mb-3">
							<label class="text-label">Valor líquido fat.</label>	                   
							<input type="text" name="vLiq" id="vLiq" value="<?php echo $notafiscal->vLiq  ?>" placeholder="Digite aqui..." class="form-campo">
						</div>    
						
					</div>
				 </div>
            </div>		
	</fieldset>		
	
<fieldset>
<legend class="h5 mb-0 text-left">Duplicatas</legend>													
            <div class="rows pt-0">	
			<div class="col-12 mb-2">
			  <a href="javascript:;" onclick="abrirModal('#create_duplicata')" class="btn btn-roxo d-inline-block">Cadastrar duplicatas</a>
			 </div>																				
            <div class="col-12">
                <div class="caixa">
                    <div class="tabela-responsiva">
                            <table cellpadding="0" cellspacing="0"  class="table-bordered">
                                    <thead>
                                        <tr>
                                            <th align="center">ID</th>
                                            <th align="center">Vencimento</th>
                                            <th align="center">Valor</th>
                                            <th align="center">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lista_duplicata">
                                    <?php foreach($duplicatas as $duplicata){?>
                                        <tr>
                                        	<td align="center"><?php echo $duplicata->id ?></td>
                                            <td align="center"><?php echo databr($duplicata->dVenc) ?></td>
                                            <td align="center">R$ <?php echo $duplicata->vDup ?></td>
                                            <td align="center"><a href='javascript:;' onclick='excluirDuplicata(<?php echo $duplicata->id_duplicata ?>)'  class='btn btn-pequeno btn-vermelho d-inline-block' title='Excluir'><i class='fas fa-trash'></i></a></td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                            </table>
                    </div>
                </div>
				
					  

					   
            </div>
            </div>
			</fieldset>