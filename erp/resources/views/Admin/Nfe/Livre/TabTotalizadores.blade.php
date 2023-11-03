<div class="rows">
    <div class="col-12 my-3">            				
    </div>
</div>

		
<fieldset>
<legend class="h5 mb-0 text-left">Totalizadores</legend>										
            <div class="rows pb-4 p-3">																					
            
            <div class="col-2 mb-1">
                    <label class="text-label">Total BC ICMS</label>	
                    <input type="text" name="vBC"  id="vBCtot"value="<?php echo $notafiscal->vBC ?>"  class="form-campo mascara-float">
            </div>	
            <div class="col-2 mb-1">
                    <label class="text-label">Total ICMS</label>	
                    <input type="text" name="vICMS" id="vICMStot" value="<?php echo $notafiscal->vICMS ?>"  class="form-campo mascara-float">
            </div>	
            <div class="col-2 mb-1">
                    <label class="text-label">Total ICMS desonerado</label>	
                    <input type="text" name="vICMSDeson" value="<?php echo $notafiscal->vICMSDeson ?>" class="form-campo mascara-float">
            </div>
                
            <div class="col-2 mb-1">
                     <label class="text-label">Total do FCP</label>	
                     <input type="text" name="vFCP" id="vFCPTot"  value="<?php echo $notafiscal->vFCP ?>" class="form-campo mascara-float">
             </div>	
             <div class="col-2 mb-1">
                     <label class="text-label">Total BC ICMS ST</label>	
                     <input type="text" name="vBCST" id="vBCSTTot" value="<?php echo $notafiscal->vBCST ?>" class="form-campo mascara-float">
             </div>	
             <div class="col-2 mb-1">
                     <label class="text-label">Total ICMS ST</label>	
                     <input type="text" name="vST" id="vSTTot" value="<?php echo $notafiscal->vST ?>" class="form-campo mascara-float">
             </div>

            <div class="col-2 mb-1">
                    <label class="text-label">Total do FCPST</label>	
                    <input type="text" name="vFCPST" id="vFCPSTTot" value="<?php echo $notafiscal->vFCPST ?>" class="form-campo mascara-float">
            </div>
            <div class="col-2 mb-4">
                    <label class="text-label">Total do FCPST Ret.</label>	
                    <input type="text" name="vFCPSTRet" id="vFCPSTRetTot" value="<?php echo $notafiscal->vFCPSTRet ?>" class="form-campo mascara-float">
            </div>          

            

            <div class="col-2 mb-1">
                    <label class="text-label">Total de II</label>	
                    <input type="text" name="vII"  id="vIITot" value="<?php echo $notafiscal->vII ?>" class="form-campo  mascara-float">
            </div>
                
            <div class="col-2 mb-1">
                    <label class="text-label">Total de IPI</label>	
                    <input type="text" name="vIPI" id="vIPITot" value="<?php echo $notafiscal->vIPI ?>" class="form-campo  mascara-float">
            </div>
                
                <div class="col-2 mb-1">
                    <label class="text-label">Total de IPI Devolução</label>	
                    <input type="text" name="vIPIDevol" id="vIPIDevolTot" value="<?php echo $notafiscal->vIPIDevol ?>" class="form-campo  mascara-float">
            </div>             
                
            <div class="col-2 mb-1">
                    <label class="text-label">Total de PIS</label>	
                    <input type="text" name="vPIS" id="vPISTot" value="<?php echo $notafiscal->vPIS ?>" class="form-campo  mascara-float">
            </div>
            <div class="col-2 mb-1">
                    <label class="text-label">Total de COFINS</label>	
                    <input type="text" name="vCOFINS" id="vCOFINSTot" value="<?php echo $notafiscal->vCOFINS ?>" class="form-campo  mascara-float">
            </div>
                
            
                
            <div class="col-2 mb-1">
                    <label class="text-label">TOTAL DA NF</label>	
                    <input type="text" name="vNF" id="vNF1" value="<?php echo $notafiscal->vNF ?>" readonly class="form-campo  mascara-float">
            </div>
            <div class="col-2 mb-1">
                    <label class="text-label">Total Aproximado</label>	
                    <input type="text" name="vTotTrib"  id="vTotTrib" value="<?php echo $notafiscal->vTotTrib ?>" class="form-campo  mascara-float">
            </div>
         
                       
            </div>
		</fieldset>	
		<fieldset class="mt-3">
			<legend class="h5 mb-0 text-left">Lei da Transparência</legend>										
            
			<small class="msg msg-azul p-1 d-block"><i class="fas fa-info-circle"></i> Esta lei mostra ao cliente a quantidade de impostos que ele está pagando para o governo ao adquirir a mercadoria.</small>
			<div class="rows pb-2 p-3">	
				<div class="col">
                    <label class="text-label">Impostos federais</label>	
                    <input type="text" name="" value="" class="form-campo  mascara-float">
				</div>
				<div class="col">
                    <label class="text-label">Impostos estaduais</label>	
                    <input type="text" name="" value="" class="form-campo  mascara-float">
				</div>
				<div class="col">
                    <label class="text-label">Impostos municipais</label>	
                    <input type="text" name="" value="" class="form-campo  mascara-float">
				</div>
				<div class="col">
                    <label class="text-label">Total aproximado </label>	
                    <input type="text" name="" value="" class="form-campo  mascara-float">
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
                    <input type="text" name="ret_imp_pis" id="ret_imp_pis" value="<?php echo $notafiscal->vRetPIS ?>"  class="form-campo  mascara-float">
				</div>
				<div class="col-4 mb-1">
                    <label class="text-label">Valor retido COFINS</label>	
                    <input type="text" name="ret_imp_cofins" id="ret_imp_cofins" value="<?php echo $notafiscal->vRetCOFINS ?>"  class="form-campo  mascara-float">
				</div>
				<div class="col-4 mb-1">
                    <label class="text-label">Valor retido CSLL</label>	
                    <input type="text" name="ret_imp_csll" id="ret_imp_csll" value="<?php echo $notafiscal->vRetCSLL ?>"  class="form-campo  mascara-float">
				</div>
				<div class="col-4 mb-1">
                    <label class="text-label">BC retido IRRF</label>	
                    <input type="text" name="ret_imp_bc_irrf" id="ret_imp_bc_irrf" value="<?php echo $notafiscal->vBCIRRF ?>"  class="form-campo  mascara-float">
				</div>
				<div class="col-4 mb-1">
                    <label class="text-label">Valor retido IRRF</label>	
                    <input type="text" name="ret_imp_valor_irrf" id="ret_imp_valor_irrf" value="<?php echo $notafiscal->vIRRF ?>"  class="form-campo  mascara-float">
				</div>
				<div class="col-4 mb-1">
                    <label class="text-label">BC retido Previdência</label>	
                    <input type="text" name="ret_imp_bc_prev" id="ret_imp_bc_prev" value="<?php echo $notafiscal->vBCRetPrev ?>"  class="form-campo  mascara-float">
				</div>
				<div class="col-4 mb-1">
                    <label class="text-label">Valor retido previdência</label>	
                    <input type="text" name="ret_imp_valor_prev" id="ret_imp_valor_prev" value="<?php echo $notafiscal->vRetPrev ?>"  class="form-campo  mascara-float">
				</div>
				</div>
			</fieldset>
			</div>
			</div>