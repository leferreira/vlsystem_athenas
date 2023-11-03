<div class="rows">
        <div class="col-12 mt-4 mb-3">
             <input type="button" onclick="salvarAdicionais()" value="Salvar"  class="btn btn-roxo text-uppercase" />
        </div>
</div>
<fieldset class="mt-0">
<legend class="h5 mb-0 text-left">Informações Adicionais</legend>	
        <div class="rows p-2">																					
            <div class="col-12">
					<div class="rows">  
						<div class="col mb-6">
							<label class="text-label">Informações para o Fisco</label>	                   
							<textarea rows="5" name="infadfisco" id="infadfisco"  placeholder="Informações complementares" class="form-campo"><?php echo $notafiscal->infAdFisco  ?></textarea>
						</div>
								 
						<div class="col mb-6">
							<label class="text-label">Informações complementares interesse contribuinte</label>	                   
							<textarea rows="5" name="infcpl" id="infcpl"  placeholder="Informações complementares" class="form-campo"><?php echo $notafiscal->infCpl  ?></textarea>
						</div>
						    
					</div>
				</div>
		 </div>
		</fieldset>		
		
<fieldset class="mt-2">
<legend class="h5 mb-0 text-left">Observações do contribuinte</legend>		
		<div class="rows p-2">   
			<div class="col-6 mb-3">
				<label class="text-label">Nome do Campo</label>	                   
				<input type="text" name="campo_obs_contribuinte" value="<?php echo $notafiscal->xCampo1  ?>" id="campo_obs_contribuinte" value="" placeholder="Digite aqui..." class="form-campo">
			</div>     
			<div class="col-6 mb-3">
				<label class="text-label">Observaçao</label>	                   
				<input type="text" name="obs_contribuinte" id="obs_contribuinte" value="<?php echo $notafiscal->xTexto1  ?>" placeholder="Digite aqui..." class="form-campo">
			</div> 
		</div>
</fieldset>			

<fieldset class="mt-2">
<legend class="h5 mb-0 text-left">Observações do Fisco</legend>		
					<div class="rows p-2">   
						<div class="col-6 mb-3">
							<label class="text-label">Nome do Campo</label>	                   
							<input type="text" name="campo_obs_fisco" id="campo_obs_fisco" value="<?php echo $notafiscal->xCampo2  ?>" placeholder="Digite aqui..." class="form-campo">
						</div>     
						<div class="col-6 mb-3">
							<label class="text-label">Observaçao</label>	                   
							<input type="text" name="obs_fisco" id="obs_fisco" value="<?php echo $notafiscal->xTexto2  ?>" placeholder="Digite aqui..." class="form-campo">
						</div> 
					</div>
	</fieldset>		
	<fieldset class="mt-2">
		<legend class="h5 mb-0 text-left">Processo referenciado</legend>			
					<div class="rows p-2">   
						<div class="col mb-3">
							<label class="text-label">Identificador do Processo</label>	                   
							<input type="text" name="identificador_processo" id="identificador_processo" value="<?php echo $notafiscal->nProc  ?>" placeholder="Digite aqui..." class="form-campo">
						</div>   
						  
						<div class="col mb-3">
							<label class="text-label">Origem do Processo</label>
							<select class="form-campo" name="origem_processo" id="origem_processo">
                                <option value="0" <?php echo ($notafiscal->indProc =="0") ? "selected" : NULL ?>>Sefaz</option> 
                                <option value="1" <?php echo ($notafiscal->indProc =="1") ? "selected" : NULL ?> >Justiça Federal</option> 
                                <option value="2" <?php echo ($notafiscal->indProc =="2") ? "selected" : NULL ?> >Justiça Estadual</option> 
                                <option value="3" <?php echo ($notafiscal->indProc =="3") ? "selected" : NULL ?>>Secex/RFB</option> 
                                <option value="9" <?php echo ($notafiscal->indProc =="9") ? "selected" : NULL ?> >Outros</option>
                                
                            </select>                	                   
						</div> 
					</div>
			</fieldset>		   
    