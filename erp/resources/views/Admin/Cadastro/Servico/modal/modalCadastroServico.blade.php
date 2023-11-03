<?php
    use App\Service\ConstanteService;
?>
<div class="window form alt" id="modalCadServico">
<form id="frmCadServico">
	<span class="d-block h4 titulo fw-700">Dados do Serviço</span>
		<a href="" class="fechar position-absolute">X</a>
	<div class="p-2 px-4">
		 <div class="rows">
								
        <div class="col-6 mb-3">
                <label class="text-label">Nome do Serviço<span class="text-vermelho">*</span></label>
                <input type="text"  maxlength="100"  required name="nome" id="nome_servico"  class="form-campo">
        </div>                         
     	 
       
        
        <div class="col-4 mb-3">
                <label class="text-label">Valor</label>
                <input type="text" name="valor_venda"  required id="valor_venda_servico" required class="form-campo mascara-float">
        </div>
     
        
        
</div>	     					           					
    	 
         </div>
   </form>
		 <div class="tfooter end">
			<a href="" class="btn btn-vermelho fechar">Fechar</a>
			<input type="hidden" name="eh_modal" id="eh_modal" value="1">
			<input type="button" onclick="salvarServico()" name="" class="btn btn-azul border-bottom" value="Cadastrar">  
		 </div>
	</div>

