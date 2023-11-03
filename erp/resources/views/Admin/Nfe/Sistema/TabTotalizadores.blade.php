<div class="rows">
    <div class="col-12 my-3">            				
    </div>
</div>
<fieldset>
<legend class="h5 mb-0 text-left">Cálculo do Imposto</legend>										
            <div class="rows pb-4 p-3">																					
            <div class="col-2 mb-1">
                    <label class="text-label">Total dos Produto</label>	
                    <input type="text" name="vProd" value="<?php echo $notafiscal->vProd ?>" readonly="true" class="form-campo">
            </div>	
            <div class="col-2 mb-1">
                    <label class="text-label">Total de frete</label>	
                    <input type="text" name="vFrete" value="<?php echo $notafiscal->vFrete ?>" readonly="true" class="form-campo">
            </div>	
            <div class="col-2 mb-1">
                    <label class="text-label">Total de seguro</label>	
                    <input type="text" name="vSeg" value="<?php echo $notafiscal->vSeg ?>" readonly="true" class="form-campo">
            </div>
            <div class="col-2 mb-1">
                    <label class="text-label">Total Outras Despesas</label>	
                    <input type="text" name="vOutro" value="<?php echo $notafiscal->vOutro ?>" readonly="true" class="form-campo">
            </div>
                
            <div class="col-2 mb-1">
                    <label class="text-label">Total de desconto</label>	
                    <input type="text" name="vDesc" value="<?php echo $notafiscal->vDesc ?>" readonly="true" class="form-campo">
            </div>	
            
           		
             <div class="col-2 mb-1">
                     <label class="text-label">Total da Nota</label>	
                     <input type="text" name="vST" value="<?php echo $notafiscal->vST ?>" readonly="true" class="form-campo">
             </div>

                       
            </div>
		</fieldset>	
		
<fieldset>
<legend class="h5 mb-0 text-left">Totalizadores</legend>										
            <div class="rows pb-4 p-3">																					
            
            <div class="col-2 mb-1">
                    <label class="text-label">Total BC ICMS</label>	
                    <input type="text" name="vBC" value="<?php echo $notafiscal->vBC ?>" readonly="true"  class="form-campo">
            </div>	
            <div class="col-2 mb-1">
                    <label class="text-label">Total ICMS</label>	
                    <input type="text" name="vICMS" value="<?php echo $notafiscal->vICMS ?>" readonly="true"  class="form-campo">
            </div>	
            <div class="col-2 mb-1">
                    <label class="text-label">Total ICMS desonerado</label>	
                    <input type="text" name="vICMSDeson" value="<?php echo $notafiscal->vICMSDeson ?>" readonly="true" class="form-campo">
            </div>
                
            <div class="col-2 mb-1">
                     <label class="text-label">Total do FCP</label>	
                     <input type="text" name="vFCP" value="<?php echo $notafiscal->vFCP ?>" readonly="true"class="form-campo">
             </div>	
             <div class="col-2 mb-1">
                     <label class="text-label">Total BC ICMS ST</label>	
                     <input type="text" name="vBCST" value="<?php echo $notafiscal->vBCST ?>" readonly="true" class="form-campo">
             </div>	
             <div class="col-2 mb-1">
                     <label class="text-label">Total ICMS ST</label>	
                     <input type="text" name="vST" value="<?php echo $notafiscal->vST ?>" readonly="true" class="form-campo">
             </div>

            <div class="col-2 mb-1">
                    <label class="text-label">Total do FCPST</label>	
                    <input type="text" name="vFCPST" value="<?php echo $notafiscal->vFCPST ?>" readonly="true" class="form-campo">
            </div>
            <div class="col-2 mb-4">
                    <label class="text-label">Total do FCPST Ret.</label>	
                    <input type="text" name="vFCPSTRet" value="<?php echo $notafiscal->vFCPSTRet ?>" readonly="true" class="form-campo">
            </div>          

            

            <div class="col-2 mb-1">
                    <label class="text-label">Total de II</label>	
                    <input type="text" name="vII" value="<?php echo $notafiscal->vII ?>" readonly="true"class="form-campo">
            </div>
                
            <div class="col-2 mb-1">
                    <label class="text-label">Total de IPI</label>	
                    <input type="text" name="vIPI" value="<?php echo $notafiscal->vIPI ?>" readonly="true" class="form-campo">
            </div>
                
                <div class="col-2 mb-1">
                    <label class="text-label">Total de IPI Devolução</label>	
                    <input type="text" name="vIPIDevol" value="<?php echo $notafiscal->vIPIDevol ?>" readonly="true" class="form-campo">
            </div>             
                
            <div class="col-2 mb-1">
                    <label class="text-label">Total de PIS</label>	
                    <input type="text" name="vPIS" value="<?php echo $notafiscal->vPIS ?>" readonly="true" class="form-campo">
            </div>
            <div class="col-2 mb-1">
                    <label class="text-label">Total de COFINS</label>	
                    <input type="text" name="vCOFINS" value="<?php echo $notafiscal->vCOFINS ?>" readonly="true" class="form-campo">
            </div>
                
            
                
            <div class="col-2 mb-1">
                    <label class="text-label">TOTAL DA NF</label>	
                    <input type="text" name="vNF" value="<?php echo $notafiscal->vNF ?>" readonly="true" class="form-campo">
            </div>
            <div class="col-2 mb-1">
                    <label class="text-label">Total Aproximado</label>	
                    <input type="text" name="vTotTrib" value="<?php echo $notafiscal->vTotTrib ?>" readonly="true" class="form-campo">
            </div>
         
                       
            </div>
		</fieldset>	
		<fieldset class="mt-3">
			<legend class="h5 mb-0 text-left">Lei da Transparência</legend>										
            
			<small class="msg msg-azul p-1 d-block"><i class="fas fa-info-circle"></i> Esta lei mostra ao cliente a quantidade de impostos que ele está pagando para o governo ao adquirir a mercadoria.</small>
			<div class="rows pb-2 p-3">	
				<div class="col">
                    <label class="text-label">Impostos federais</label>	
                    <input type="text" name="" value="" readonly="true" class="form-campo">
				</div>
				<div class="col">
                    <label class="text-label">Impostos estaduais</label>	
                    <input type="text" name="" value="" readonly="true" class="form-campo">
				</div>
				<div class="col">
                    <label class="text-label">Impostos municipais</label>	
                    <input type="text" name="" value="" readonly="true" class="form-campo">
				</div>
				<div class="col">
                    <label class="text-label">Total aproximado </label>	
                    <input type="text" name="" value="" readonly="true" class="form-campo">
				</div>
			</div>

		<!--mostra mais opções ocultas -->
			<div class="pt-0 item limpo"> 
				<div class="p-3 check on"><label class="text-verde h5 mb-0 filtro"><input type="checbox" class="d-none"> Informar retenções de impostos</label></div>
				
				<div class="mostraFiltro px-2">
				<fieldset class="p-2 mb-2">
				<div class="rows">
				<div class="col-4 mb-1">
                    <label class="text-label">Valor retido PIS</label>	
                    <input type="text" name="ret_imp_pis" id="ret_imp_pis" value="<?php echo $notafiscal->vRetPIS ?>"  class="form-campo">
				</div>
				<div class="col-4 mb-1">
                    <label class="text-label">Valor retido COFINS</label>	
                    <input type="text" name="ret_imp_cofins" id="ret_imp_cofins" value="<?php echo $notafiscal->vRetCOFINS ?>"  class="form-campo">
				</div>
				<div class="col-4 mb-1">
                    <label class="text-label">Valor retido CSLL</label>	
                    <input type="text" name="ret_imp_csll" id="ret_imp_csll" value="<?php echo $notafiscal->vRetCSLL ?>"  class="form-campo">
				</div>
				<div class="col-4 mb-1">
                    <label class="text-label">BC retido IRRF</label>	
                    <input type="text" name="ret_imp_bc_irrf" id="ret_imp_bc_irrf" value="<?php echo $notafiscal->vBCIRRF ?>"  class="form-campo">
				</div>
				<div class="col-4 mb-1">
                    <label class="text-label">Valor retido IRRF</label>	
                    <input type="text" name="ret_imp_valor_irrf" id="ret_imp_valor_irrf" value="<?php echo $notafiscal->vIRRF ?>"  class="form-campo">
				</div>
				<div class="col-4 mb-1">
                    <label class="text-label">BC retido Previdência</label>	
                    <input type="text" name="ret_imp_bc_prev" id="ret_imp_bc_prev" value="<?php echo $notafiscal->vBCRetPrev ?>"  class="form-campo">
				</div>
				<div class="col-4 mb-1">
                    <label class="text-label">Valor retido previdência</label>	
                    <input type="text" name="ret_imp_valor_prev" id="ret_imp_valor_prev" value="<?php echo $notafiscal->vRetPrev ?>"  class="form-campo">
				</div>
				</div>
			</fieldset>
			</div>
			</div>