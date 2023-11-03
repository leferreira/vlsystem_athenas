

<fieldset class="mt-2">
<legend class="h5 mb-0 text-left">Destinatário</legend>										
        <div class="rows p-2">	
			
            <div class="col-6 mb-1">
                    <label class="text-label">Nome / Razão Social </label>	
                    <input type="text" name="cliente_nome"  id="cliente_nome" value="<?php echo isset($notafiscal) ? $notafiscal->cliente_nome : NULL ?>" class="form-campo">
            </div>
           
            
            <div class="col-3 mb-1">
                <label class="text-label">CPF </label>
                <input type="text" name="cliente_cpf" id="cliente_cpf" value="<?php echo isset($notafiscal) ? $notafiscal->cliente_cpf : NULL ?>" class="form-campo">
            </div>                     
              
            
            
            
   </div>
   </fieldset>
    

	 
 
          
