<div class="rows">
    <div class="col-12 mt-4 mb-3">
                <input type="button" onclick="salvarExportacao()" value="Salvar"  class="btn btn-roxo text-uppercase" />
        </div>
</div>
	
	<div class="rows pb-4">																					
            <div class="col-12">
             <fieldset>
				<legend class="h5 mb-0 text-left">Exportação</legend>
					<div class="rows px-3">   
						<div class="col-4 mb-2">
                            <label class="text-label">UF Embarque</label>	
                            <select class="form-campo" name="UFSaidaPais" id="UFSaidaPais" >
                            <option></option>
                           
                            </select>
                            </div>     
						<div class="col-4 mb-3">
							<label class="text-label">Local Embarque</label>	                   
							<input type="text" name="xLocExporta" id="xLocExporta" value="<?php echo $notafiscal->xLocExporta ?>"  class="form-campo">
						</div>     
						<div class="col-4 mb-3">
							<label class="text-label">Local Despacho</label>	                   
							<input type="text" name="xLocDespacho" id="xLocDespacho" value="<?php echo $notafiscal->xLocDespacho ?>"  class="form-campo">
						</div>						    
						
					</div>
				</fieldset>
             <fieldset class="mt-3">
				<legend class="h5 mb-0 text-left">	Compra</legend>
					<div class="rows px-3">  
						<div class="col-4 mb-3">
							<label class="text-label">Informação da Nota de Empenho</label>	                   
							<input type="text" name="xNEmp" id="xNEmp" value="<?php echo $notafiscal->xNEmp ?>"  class="form-campo">
						</div> 
						   
						<div class="col-4 mb-3">
							<label class="text-label">Informação do Pedido</label>	                   
							<input type="text" name="xPed" id="xPed" value="<?php echo $notafiscal->xPed ?>"  class="form-campo">
						</div>     
						<div class="col-4 mb-3">
							<label class="text-label">Informação do Contrato</label>	                   
							<input type="text" name="xCont" id="xCont" value="<?php echo $notafiscal->xCont ?>"  class="form-campo">
						</div>						    
						
					</div>
				</fieldset>	
				 </div>
    </div>		
			