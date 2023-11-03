<?php
    use App\Service\ConstanteService;
?>
<div class="window form alt" id="modalCadTransportadora">
<span class="d-block h4 titulo fw-700">Cadastro de Transportadora</span>
		<a href="" class="fechar position-absolute">X</a>
		<div class="caixa mb-0 p-3">

   <div class="p-0 px-2 mt-0">
		<fieldset class="mt-0">		
    		<legend>Pesquisar Por CNPJ</legend>
				<div class="rows">
					
					<div class="col-8" id="div_pesquisar">
						<label class="text-label">Pesquisa CNPJ</label>
						<div class="grupo-form-btn">
							<input type="text" id="transp_codigocnpj" class="form-campo mascara-cnpj">
							<input type="button" onclick="pesquisarCnpjTransportadora(1)" value="Pesquisar CNPJ" class="btn btn-azul d-block m-auto">
						</div>
					</div>
				</div>
		</fieldset>
	</div>
<form id="frmCadTransportadora">	
<div class="scroll-modal">     
   <div id="tabmod2" class="abas py-0">
	    <ul class="tabmod">
            <li><a href="#tabmod-1" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-9">Dados Pessoais </a></li>
            <li><a href="#tabmod-2" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-10">Endereço</a></li>
         </ul>
	  <div id="tabmod-1">
		<div class="p-2 mt-3 px-0">			
				
			<fieldset>
				<legend>Dados Pessais</legend>	
				<div class="rows">												
					<div class="col-6 mb-3">
							<label class="text-label">Razão Social<span class="text-vermelho">*</span></label>	
							<input type="text" name="razao_social" maxlength="60" id="transp_razao_social" value="{{isset($transportadora->razao_social) ? $transportadora->razao_social : old('razao_social') }}" class="form-campo">
					</div>                                    
					<div class="col-6 mb-3">
							<label class="text-label">Nome Fantasia</label>	
							<input type="text" name="nome_fantasia"  maxlength="60" id="transp_nome_fantasia" value="{{isset($transportadora->nome_fantasia) ? $transportadora->nome_fantasia : old('nome_fantasia') }}" class="form-campo">
					</div>				
					
					<div class="col-3 mb-3">
							<label class="text-label">CNPJ<span class="text-vermelho">*</span></label>	
							<input type="text" name="cnpj" id="transp_cnpj" value="{{isset($transportadora->cnpj) ? $transportadora->cnpj : old('cnpj') }}"  class="form-campo">
					</div>				
					<div class="col-3 mb-3">
							<label class="text-label">Email</label>	
							<input type="text" name="email" id="transp_email" maxlength="60" value="{{isset($transportadora->email) ? $transportadora->email : old('email') }}"  class="form-campo">
					</div>
					<div class="col-3 mb-3">
							<label class="text-label">Fone</label>	
							<input type="text" name="telefone" maxlength="14" id="transp_telefone" value="{{isset($transportadora->telefone) ? $transportadora->telefone : old('telefone') }}"  class="form-campo mascara-fone">
					</div>
					<div class="col-3 mb-3">
							<label class="text-label">Celular</label>	
							<input type="text" name="celular" maxlength="14" id="transp_celular" value="{{isset($transportadora->celular) ? $transportadora->celular : old('celular') }}"  class="form-campo mascara-celular">
					</div>				
					
				</div>
   
</fieldset>
	
		
		</div>
	  </div>
	  
	  
  <div id="tabmod-2">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>Endereço</legend>	
				<div class="rows">	
							<div class="col-2 mb-3">
                            <label class="text-label">Cep<span class="text-vermelho">*</span></label>	
                            <input type="text" name="cep" id="transp_cep" value="{{isset($transportadora->cep) ? $transportadora->cep : old('cep') }}"  class="form-campo busca_cep">
                            </div>
                            
                            <div class="col-4 mb-3">
                                    <label class="text-label">Logradouro<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="logradouro" id="transp_logradouro" value="{{isset($transportadora->logradouro) ? $transportadora->logradouro : old('logradouro') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Numero<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="numero" id="transp_numero" value="{{isset($transportadora->numero) ? $transportadora->numero : old('numero') }}"  class="form-campo">
                            </div>
                            <div class="col-4 mb-3">
                                     <label class="text-label">Bairro<span class="text-vermelho">*</span></label>	
                                     <input type="text" name="bairro" id="transp_bairro" value="{{isset($transportadora->bairro) ? $transportadora->bairro : old('bairro') }}"  class="form-campo bairro">
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="complemento" id="transp_complemento" value="{{isset($transportadora->complemento) ? $transportadora->complemento : old('complemento') }}"  class="form-campo">
                             </div>	                            
        						 
                             <div class="col-2 mb-2">
                                 <label class="text-label">UF<span class="text-vermelho">*</span></label>	
                                 <input type="text" name="uf" id="transp_uf" value="{{isset($transportadora->uf) ? $transportadora->uf : old('uf') }}"   class="form-campo estado"> 
                             </div>                    
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade<span class="text-vermelho">*</span></label>	
                                     <input type="text" name="cidade" id="transp_cidade" value="{{isset($transportadora->cidade) ? $transportadora->cidade : old('cidade') }}"  class="form-campo cidade">
                             </div>	
                             <div class="col-2 mb-3">
                                     <label class="text-label">Ibge</label>	
                                     <input type="text" name="ibge" id="transp_ibge" value="{{isset($transportadora->ibge) ? $transportadora->ibge : old('ibge') }}"  class="form-campo ibge ">
                             </div>  
					</div> 

		</fieldset>	
		
		</div>
	  </div>
         
 </div>

</div>
		
		<div class="col-12 text-center pb-0 tfooter end">
			<input type="button" class="btn btn-vermelho fechar" value="Fechar">
			<input type="hidden" name="eh_modal" id="eh_modal" value="1">
			<a href="javascript:;" onclick="salvarTransportadora(1)" class="btn btn-azul">Salvar Dados</a>			
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