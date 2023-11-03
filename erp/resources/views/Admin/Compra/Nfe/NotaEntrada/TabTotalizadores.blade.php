<div class="rows">
    <div class="col-12 my-3">            				
    </div>
</div>

		
<fieldset>
<legend class="h5 mb-0 text-left">Totalizadores</legend>										
            <div class="rows pb-4 p-3">																					
            
            <div class="col-2 mb-1">
                    <label class="text-label">Total BC ICMS</label>	
                    <input type="text" name="vBC"  id="vBCtot"value="<?php echo $notafiscal->vBC ?>" readonly="true"  class="form-campo">
            </div>	
            <div class="col-2 mb-1">
                    <label class="text-label">Total ICMS</label>	
                    <input type="text" name="vICMS" id="vICMStot" value="<?php echo $notafiscal->vICMS ?>" readonly="true"  class="form-campo">
            </div>	
            <div class="col-2 mb-1">
                    <label class="text-label">Total ICMS desonerado</label>	
                    <input type="text" name="vICMSDesonTot" value="<?php echo $notafiscal->vICMSDeson ?>" readonly="true" class="form-campo">
            </div>
                
            <div class="col-2 mb-1">
                     <label class="text-label">Total do FCP</label>	
                     <input type="text" name="vFCP" id="vFCPTot"  value="<?php echo $notafiscal->vFCP ?>" readonly="true"class="form-campo">
             </div>	
             <div class="col-2 mb-1">
                     <label class="text-label">Total BC ICMS ST</label>	
                     <input type="text" name="vBCST" id="vBCSTTot" value="<?php echo $notafiscal->vBCST ?>" readonly="true" class="form-campo">
             </div>	
             <div class="col-2 mb-1">
                     <label class="text-label">Total ICMS ST</label>	
                     <input type="text" name="vST" id="vSTTot" value="<?php echo $notafiscal->vST ?>" readonly="true" class="form-campo">
             </div>

            <div class="col-2 mb-1">
                    <label class="text-label">Total do FCPST</label>	
                    <input type="text" name="vFCPST" id="vFCPSTTot" value="<?php echo $notafiscal->vFCPST ?>" readonly="true" class="form-campo">
            </div>
            <div class="col-2 mb-4">
                    <label class="text-label">Total do FCPST Ret.</label>	
                    <input type="text" name="vFCPSTRet" id="vFCPSTRetTot" value="<?php echo $notafiscal->vFCPSTRet ?>" readonly="true" class="form-campo">
            </div>          

            

            <div class="col-2 mb-1">
                    <label class="text-label">Total de II</label>	
                    <input type="text" name="vII"  id="vIITot" value="<?php echo $notafiscal->vII ?>" readonly="true"class="form-campo">
            </div>
                
            <div class="col-2 mb-1">
                    <label class="text-label">Total de IPI</label>	
                    <input type="text" name="vIPI" id="vIPITot" value="<?php echo $notafiscal->vIPI ?>" readonly="true" class="form-campo">
            </div>
                
                <div class="col-2 mb-1">
                    <label class="text-label">Total de IPI Devolução</label>	
                    <input type="text" name="vIPIDevol" id="vIPIDevolTot" value="<?php echo $notafiscal->vIPIDevol ?>" readonly="true" class="form-campo">
            </div>             
                
            <div class="col-2 mb-1">
                    <label class="text-label">Total de PIS</label>	
                    <input type="text" name="vPIS" id="vPISTot" value="<?php echo $notafiscal->vPIS ?>" readonly="true" class="form-campo">
            </div>
            <div class="col-2 mb-1">
                    <label class="text-label">Total de COFINS</label>	
                    <input type="text" name="vCOFINS" id="vCOFINSTot" value="<?php echo $notafiscal->vCOFINS ?>" readonly="true" class="form-campo">
            </div>
                
            
                
            <div class="col-2 mb-1">
                    <label class="text-label">TOTAL DA NF</label>	
                    <input type="text" name="vNF" id="vNF1" value="<?php echo $notafiscal->vNF ?>" readonly class="form-campo">
            </div>
            <div class="col-2 mb-1">
                <label class="text-label">Impostos federais</label>	
                <input type="text" id="nacionalfederal" value="<?php echo $notafiscal->nacionalfederal ?>" readonly="true" class="form-campo">
			</div>
			<div class="col-2 mb-1">
                <label class="text-label">Impostos estaduais</label>	
                <input type="text" id="estadual" value="<?php echo $notafiscal->estadual ?>" readonly="true" class="form-campo">
			</div>
			<div class="col-2 mb-1">
                <label class="text-label">Impostos municipais</label>	
                <input type="text" id="municipal" value="<?php echo $notafiscal->municipal ?>" readonly="true" class="form-campo">
			</div>
			<div class="col-2 mb-1">
                    <label class="text-label">Total Aproximado</label>	
                    <input type="text" name="vTotTrib"  id="vTotTrib" value="<?php echo $notafiscal->vTotTrib ?>" readonly="true" class="form-campo">
            </div>
         
                       
            </div>
		</fieldset>	
	

		<!--mostra mais opções ocultas -->
			<div class="pt-0 item limpo"> 
				
				<div class=" px-2">
				<fieldset class="p-2 mb-2">
				<legend class="h5 mb-0 text-left">Valores Retidos</legend>	
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