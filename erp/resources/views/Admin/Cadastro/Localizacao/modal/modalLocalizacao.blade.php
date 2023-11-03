<div class="window form alt" id="modalCadLocalizacao">
<form id="frmCadLocalizacao">
	<span class="d-block h4 titulo fw-700">Dados do Localizacao</span>
		<a href="" class="fechar position-absolute">X</a>
	<div class="p-2 px-4">
		 <div class="rows">								
                <div class="col-6 mb-3">
                        <label class="text-label">Localização <span class="text-vermelho">*</span></label>
                        <input type="text"  maxlength="100"  required name="localizacao" id="localizacao"  class="form-campo">
                </div>                       
             	 
         </div>	     					           					
    	 
         </div>
   </form>
		 <div class="tfooter end">
			<a href="" class="btn btn-vermelho fechar">Fechar</a>
			<input type="hidden" name="eh_modal" id="eh_modal" value="1">
			<input type="button" onclick="salvarLocalizacao()" name="" class="btn btn-azul border-bottom" value="Cadastrar">  
		 </div>
	</div>
