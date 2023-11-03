<?php
    use App\Service\ConstanteService;
?>
<div class="window form alt" id="modalCadTipoDespesa">
<span class="d-block h4 fw-700 titulo">Cadastro de Tipo de Despesa</span>
		<a href="" class="fechar position-absolute">X</a>
		<div class="caixa mb-0 p-3"> 
     
   <div id="tabmod" class="abas py-0">
	  <div id="tabmod-1">
		<div class="p-2 mt-3 px-0">		
				
				
				<div class="rows">												
					<div class="col-6 mb-3">
							<label class="text-label"  >Nome<span class="text-vermelho">*</span></label>	
							<input type="text" id="tipo_despesa" maxlength="60" required  class="form-campo">
					</div>                                    
					<div class="col-3 mb-3" id="divFantasia">
							<label class="text-label">,</label>	
						<a href="javascript:;" onclick="salvarTipoDespesa(1)" class="btn btn-azul">Salvar Dados</a>						</div>
					
				</div>
		
	
		
		</div>
	  </div>  
	  
         
 </div>

</div>
</div>

