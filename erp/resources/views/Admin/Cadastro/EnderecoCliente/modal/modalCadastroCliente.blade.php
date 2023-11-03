<?php
    use App\Service\ConstanteService;
?>
<div class="window form alt" id="modalCadCliente">
<span class="d-block h4 fw-700 titulo">Cadastro de Cliente</span>
		<a href="" class="fechar position-absolute">X</a>
		<div class="caixa mb-0 p-3">

    <input type="hidden" name="_token" value="HyqwkJzIzCTlOwEYbDBLYUyvJVW09v9kR9qo1hao">    
  
<form id="frmCadCliente">	
<div class="scroll-modal">     
   <div id="tabmod" class="abas py-0">	  
	  
  <div id="tabmod-2">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>Endereço</legend>	
				<div class="rows">	
							<div class="col-2 mb-3">
                            <label class="text-label">Cep<span class="text-vermelho">*</span></label>	
                            <input type="text" name="cep" id="cep" required value="{{isset($cliente->cep) ? $cliente->cep : old('cep') }}"  class="form-campo busca_cep mascara-cep">
                            </div>
                            
                            <div class="col-4 mb-3">
                                    <label class="text-label">Logradouro<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="logradouro" maxlength="60" required id="logradouro" value="{{isset($cliente->logradouro) ? $cliente->logradouro : old('logradouro') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Numero<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="numero" required id="numero" value="{{isset($cliente->numero) ? $cliente->numero : old('numero') }}"  class="form-campo">
                            </div>
                            <div class="col-4 mb-3">
                                     <label class="text-label">Bairro</label>	
                                     <input type="text" name="bairro"  maxlength="60" id="bairro" value="{{isset($cliente->bairro) ? $cliente->bairro : old('bairro') }}"  class="form-campo bairro">
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="complemento" maxlength="60" id="complemento" value="{{isset($cliente->complemento) ? $cliente->complemento : old('complemento') }}"  class="form-campo">
                             </div>	                            
        						 
                             <div class="col-2 mb-2">
                                 <label class="text-label">UF</label>	
                                 <input type="text" name="uf" id="uf" required  value="{{isset($cliente->uf) ? $cliente->uf : old('uf') }}"   class="form-campo estado"> 
                             </div>                    
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade</label>	
                                     <input type="text" name="cidade" maxlength="60" required id="cidade" value="{{isset($cliente->cidade) ? $cliente->cidade : old('cidade') }}"  class="form-campo cidade">
                             </div>	
                             <div class="col-2 mb-3">
                                     <label class="text-label">Ibge</label>	
                                     <input type="text" name="ibge" required id="ibge" value="{{isset($cliente->ibge) ? $cliente->ibge : old('ibge') }}"  class="form-campo ibge ">
                             </div>  
					</div>  

		</fieldset>	
		
		</div>
	  </div>
         
 </div>

</div>
		
		<div class="col-12 text-center pb-0 tfooter end">
			<input type="button" class="btn btn-vermelho fechar" value="Fechar">
			<a href="javascript:;" onclick="salvarCliente()" class="btn btn-azul">Salvar Dados</a>			
		</div>	
	
</form>
			
		</div>
	</div>
	
<script>
	
	function tipoCliente(){
		var tp = $("#tipo_cliente").val();
		
		if(tp=="F"){
			$("#div_pesquisar").hide();
            $("#divIscEstadual").hide();
            $("#divSuframa").hide();
            $("#divFantasia").hide();
            
            $("#lblInscEstadual").html("RG");
            $("#lblCnpj").html('CPF');
            $("#lblRazaoSocial").html('Nome');
            $("#cnpj").mask('000.000.000-00', {reverse: true});
            $("#indFinal option:contains(Sim)").attr('selected', true);
            $("#tipo_contribuinte option:contains(Não)").attr('selected', true);
        }else{
			$("#div_pesquisar").show();
            $("#divIscEstadual").show();
            $("#divSuframa").show();
            $("#divFantasia").show();
            
            $("#lblInscEstadual").html("Inscrição Estadual");
            $("#lblCnpj").html('CNPJ');
            $("#lblRazaoSocial").html('Razão Social');
            $("#cnpj").mask('00.000.000/0000-00', {reverse: true});
          	
          	$("#lblCnpj").html('CNPJ');
          	$("#indFinal option:contains(Não)").attr('selected', true);
          	$("#tipo_contribuinte option:contains(ICMS)").attr('selected', true);
          	
		}
	}
</script>