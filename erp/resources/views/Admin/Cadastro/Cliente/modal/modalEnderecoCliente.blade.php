<?php
    use App\Service\ConstanteService;
?>
<div class="window form alt" id="modalCadEndereco">
<span class="d-block h4 fw-700 titulo">Cadastro de Endereço</span>
		<a href="" class="fechar position-absolute">X</a>
 
<div class="caixa mb-0 p-3">

 <form id="frmCadEnderecoCliente" > 

   
   <div id="tabmod" class="abas py-0">	    

	  
		  
  <div id="tabmod-2">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>Endereço</legend>	
				<div class="rows">	
							<div class="col-2 mb-3">
                            <label class="text-label">Cep<span class="text-vermelho">*</span></label>	
                            <input type="text" name="cep" id="cep"  class="form-campo busca_cep mascara-cep">
                            </div>
                            
                            <div class="col-4 mb-3">
                                    <label class="text-label">Logradouro<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="logradouro"  required id="logradouro"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Numero<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="numero" required id="numero"   class="form-campo">
                            </div>
                            <div class="col-4 mb-3">
                                     <label class="text-label">Bairro</label>	
                                     <input type="text" name="bairro"  maxlength="60" id="bairro"  class="form-campo bairro">
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="complemento" maxlength="60" id="complemento"   class="form-campo">
                             </div>	                            
        						 
                             <div class="col-2 mb-2">
                                 <label class="text-label">UF</label>	
                                 <input type="text" name="uf" id="uf" required    class="form-campo estado"> 
                             </div>                    
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade</label>	
                                     <input type="text" name="cidade" maxlength="60" required id="cidade"   class="form-campo cidade">
                             </div>	
                             <div class="col-2 mb-3">
                                     <label class="text-label">Ibge</label>	
                                     <input type="text" name="ibge"  id="ibge"  class="form-campo ibge ">
                             </div>  
					</div>  

		</fieldset>	
		
		</div>
	  </div>
         
 </div>


		
		<div class="col-12 text-center pb-0 tfooter end">
			<input type="hidden" id="cliente_id" name="cliente_id" >
			<input type="hidden" id="endereco_id" name="endereco_id" >
			<input type="button" class="btn btn-vermelho fechar" value="Fechar">
			<a href="javascript:;" onclick="salvarEnderecoCliente(1)" class="btn btn-azul">Salvar Dados</a>			
		</div>	
	
</form>
			
		</div>
</div>
	
