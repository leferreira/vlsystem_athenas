<?php
use App\Service\ConstanteService;
?>

<fieldset class="mt-3">
<legend class="h5 mb-0 text-left">Faturas</legend>	
	<div class="rows">																					
            <div class="col-12">             
					<div class="rows">
                        <div class="col-4 mb-3 position-relative">
                            <label class="text-label">Meio de Pagamento</label>
                            <select class="form-campo" name="tPag" id="tPag">
                            @foreach(ConstanteService::tiposPagamento() as $chave=>$valor)
                    			<option value="01" {{ ($notafiscal->tPag ?? null ) == $chave ? 'selected' : null }} > {{$valor}}</option>
                    		@endforeach
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
                </div>
				 </div>
            </div>		
	</fieldset>		
	
<fieldset>
<legend class="h5 mb-0 text-left">Duplicatas</legend>													
            <div class="rows pt-0">	
																							
            <div class="col-12">
                <div class="caixa">
                    <div class="tabela-responsiva">
                            <table cellpadding="0" cellspacing="0"  class="table-bordered">
                                    <thead>
                                        <tr>
                                            <th align="center">ID</th>
                                            <th align="center">Vencimento</th>
                                            <th align="center">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lista_duplicata">
                                    <?php foreach($duplicatas as $duplicata){?>
                                        <tr>
                                        	<td align="center"><?php echo $duplicata->id ?></td>
                                            <td align="center"><?php echo databr($duplicata->dVenc) ?></td>
                                            <td align="center">R$ <?php echo $duplicata->vDup ?></td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                            </table>
                    </div>
                </div>
				
					  

					   
            </div>
            </div>
			</fieldset>