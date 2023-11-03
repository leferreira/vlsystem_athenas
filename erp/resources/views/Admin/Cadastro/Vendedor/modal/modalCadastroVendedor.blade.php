<?php
    use App\Service\ConstanteService;
?>
<div class="window form alt" id="modalCadVendedor">
<span class="d-block h4 fw-700 titulo">Cadastro de Vendedor</span>
		<a href="" class="fechar position-absolute">X</a>
		<div class="caixa mb-0 p-3">

    <input type="hidden" name="_token" value="HyqwkJzIzCTlOwEYbDBLYUyvJVW09v9kR9qo1hao">    

<form id="frmCadVendedor">	
<div class="scroll-modal">     
   <div id="tabmod" class="abas py-0">	    
	  <div id="tabmod-1">
		<div class="p-2 mt-3 px-0">			
				
			<fieldset>
				<legend>Dados Pessais</legend>	
				<div class="rows">
					<div class="col-4 mb-3">
							<label class="text-label" >Nome<span class="text-vermelho">*</span></label>	
							<input type="text" name="vendedor_nome" maxlength="60"  required id="vendedor_nome" value="{{isset($vendedor->nome) ? $vendedor->nome: old('nome') }}" class="form-campo">
					</div> 
					
					<div class="col-4 mb-3">
							<label class="text-label">Email</label>	
							<input type="text" name="email" id="vendedor_email" maxlength="60"  value="{{isset($vendedor->email) ? $vendedor->email : old('email') }}" autocomplete="new-email" class="form-campo">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label">Senha</label>	
							<input type="password" name="vendedor_senha" id="vendedor_senha"  value="{{isset($vendedor->senha) ? $vendedor->senha : old('senha') }}"  autocomplete="new-password" class="form-campo">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label" >CPF<span class="text-vermelho">*</span></label>	
							<input type="text" name="vendedor_cpf" id="vendedor_cpf" value="{{isset($vendedor->cpf) ? $vendedor->cpf: old('cpf') }}"  class="form-campo mascara-cpf">
					</div>
					

					<div class="col-2 mb-3">
							<label class="text-label">Fone</label>	
							<input type="text" name="vendedor_telefone" maxlength="14" id="vendedor_telefone" value="{{isset($vendedor->telefone) ? $vendedor->telefone : old('telefone') }}"  class="form-campo mascara-fone">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label">Celular</label>	
							<input type="text" name="vendedor_celular" id="vendedor_celular" value="{{isset($vendedor->celular) ? $vendedor->celular : old('celular') }}"  class="form-campo mascara-celular">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label">Comissão</label>	
							<input type="text" name="vendedor_comissao"  id="vendedor_comissao" value="{{isset($vendedor->comissao) ? $vendedor->comissao : old('comissao') }}"  class="form-campo mascara-float">
					</div>
				</div>
   
</fieldset>
	
		<fieldset>
				<legend>Endereço</legend>	
				<div class="rows">	
							<div class="col-2 mb-3">
                            <label class="text-label">Cep<span class="text-vermelho">*</span></label>	
                            <input type="text" name="vendedor_cep" id="vendedor_cep" required value="{{isset($vendedor->cep) ? $vendedor->cep : old('cep') }}"  class="form-campo busca_cep mascara-cep">
                            </div>
                            
                            <div class="col-4 mb-3">
                                    <label class="text-label">Logradouro<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="vendedor_logradouro" maxlength="60" required id="vendedor_logradouro" value="{{isset($vendedor->logradouro) ? $vendedor->logradouro : old('logradouro') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Numero<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="vendedor_numero" required id="vendedor_numero" value="{{isset($vendedor->numero) ? $vendedor->numero : old('numero') }}"  class="form-campo">
                            </div>
                            <div class="col-4 mb-3">
                                     <label class="text-label">Bairro</label>	
                                     <input type="text" name="vendedor_bairro"  maxlength="60" id="vendedor_bairro" value="{{isset($vendedor->bairro) ? $vendedor->bairro : old('bairro') }}"  class="form-campo bairro">
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="vendedor_complemento" maxlength="60" id="vendedor_complemento" value="{{isset($vendedor->complemento) ? $vendedor->complemento : old('complemento') }}"  class="form-campo">
                             </div>	                            
        						 
                             <div class="col-2 mb-2">
                                 <label class="text-label">UF</label>	
                                 <input type="text" name="vendedor_uf" id="vendedor_uf" required  value="{{isset($vendedor->uf) ? $vendedor->uf : old('uf') }}"   class="form-campo estado"> 
                             </div>                    
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade</label>	
                                     <input type="text" name="vendedor_cidade" maxlength="60" required id="vendedor_cidade" value="{{isset($vendedor->cidade) ? $vendedor->cidade : old('cidade') }}"  class="form-campo cidade">
                             </div>	
                             <div class="col-2 mb-3">
                                     <label class="text-label">Ibge</label>	
                                     <input type="text" name="vendedor_ibge" required id="vendedor_ibge" value="{{isset($vendedor->ibge) ? $vendedor->ibge : old('ibge') }}"  class="form-campo ibge ">
                             </div>  
					</div>  

		</fieldset>
		</div>
	  </div>
	 
         
 </div>

</div>
		
		<div class="col-12 text-center pb-0 tfooter end">
			<input type="button" class="btn btn-vermelho fechar" value="Fechar">
			<a href="javascript:;" onclick="salvarVendedor()" class="btn btn-azul">Salvar Dados</a>			
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