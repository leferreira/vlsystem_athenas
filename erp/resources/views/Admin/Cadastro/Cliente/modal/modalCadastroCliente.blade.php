<?php
    use App\Service\ConstanteService;
?>
<div class="window form alt" id="modalCadCliente">
<span class="d-block h4 fw-700 titulo">Cadastro de Cliente</span>
		<a href="" class="fechar position-absolute">X</a>
		<div class="caixa mb-0 p-3">

    <input type="hidden" name="_token" value="HyqwkJzIzCTlOwEYbDBLYUyvJVW09v9kR9qo1hao">    
   <div class="p-0 px-2 mt-0">
		<fieldset class="mt-0">		
    		<legend>Pesquisar Por CNPJ</legend>
				<div class="rows">
				<div class="col-4 mb-3">
							<label class="text-label">Tipo Cliente</label>	
							<select  name="tipo_cliente" id="tipo_cliente" class="form-campo" onchange ="tipoCliente()"  >
								<option value="J">Juridica</option>
								<option value="F">Física</option>
															
							</select>
					</div>
					
					<div class="col-8" id="div_pesquisar">
						<label class="text-label">Pesquisa CNPJ</label>
						<div class="grupo-form-btn">
							<input type="text" id="codigocnpj" class="form-campo mascara-cnpj">
							<input type="button" onclick="pesquisarCnpjCliente(1)" value="Pesquisar CNPJ" class="btn btn-azul d-block m-auto">
						</div>
					</div>
				</div>
		</fieldset>
	</div>
<form id="frmCadCliente">	
<div class="scroll-modal">     
   <div id="tabmod" class="abas py-0">
	    <ul class="tabmod">
            <li><a href="#tabmod-1" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-9">Dados Pessoais </a></li>
            <li><a href="#tabmod-2" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-10">Endereço</a></li>
         </ul>
	  <div id="tabmod-1">
		<div class="p-2 mt-3 px-0">			
				
			<fieldset>
				<legend>Dados Pessais</legend>	
				<div class="rows">
					<div class="col-4 mb-3">
							<label class="text-label" id="lblRazaoSocial">Razão Social<span class="text-vermelho">*</span></label>	
							<input type="text" name="nome_razao_social" id="nome_razao_social" maxlength="60"  required id="razao_social" value="{{isset($cliente->nome_razao_social) ? $cliente->nome_razao_social : old('nome_razao_social') }}" class="form-campo">
					</div> 
					
					<div class="col-4 mb-3">
							<label class="text-label">Email<span class="text-vermelho">*</span></label>	
							<input type="text" name="email" id="email" maxlength="60" required value="{{isset($cliente->email) ? $cliente->email : old('email') }}"  class="form-campo">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label">Senha<span class="text-vermelho">*</span></label>	
							<input type="password" name="senha" id="senha" required value="{{isset($cliente->senha) ? $cliente->senha : old('senha') }}"  class="form-campo">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label" id="lblCnpj">CNPJ<span class="text-vermelho">*</span></label>	
							<input type="text" name="cpf_cnpj" id="cnpj" required value="{{isset($cliente->cpf_cnpj) ? $cliente->cpf_cnpj : old('cpf_cnpj') }}"  class="form-campo">
					</div>
																	
					                                   
					<div class="col-3 mb-3" id="divFantasia">
							<label class="text-label" >Nome Fantasia</label>	
							<input type="text" name="nome_fantasia" id="nome_fantasia" maxlength="60" id="nome_fantasia" value="{{isset($cliente->nome_fantasia) ? $cliente->nome_fantasia : old('nome_fantasia') }}" class="form-campo">
					</div>					
					
						
					<div class="col-3 mb-3" id="div_tipo_contribuinte">
							<label class="text-label">Tipo de Contribuinte</label>	
							<select  name="tipo_contribuinte" id="tipo_contribuinte" class="form-campo">
								<option value="1">Contribuinte ICMS</option>
								<option value="9">Não Contribuinte</option>								
								<option value="2">Contribuinte Isento</option>
							</select>
					</div>
					
					<div class="col-2 mb-3" >
							<label class="text-label">Consumidor Final</label>	
							<select  name="indFinal" id="indFinal" class="form-campo">
								<option value="0" {{($cliente->indFinal ?? null) == '0' ? 'selected' : null }}>Não</option>	
								<option value="1" {{($cliente->indFinal ?? null) == '1' ? 'selected' : null }}>Sim</option>	
																						
							</select>
					</div>
					
					<div class="col-2 mb-3" >
							<label class="text-label" id="lblInscEstadual">Inscrição Estadual</label>	
							<input type="text" name="rg_ie" maxlength="14" id="rg_ie" value="{{isset($cliente->rg_ie) ? $cliente->rg_ie : old('rg_ie') }}"  class="form-campo">
					</div>
					
					<div class="col-2 mb-3" id="divIscMunicipal">
							<label class="text-label">Insc. Municipal</label>	
							<input type="text" name="im" id="im" maxlength="15" value="{{isset($cliente->im) ? $cliente->im : old('im') }}"  class="form-campo">
					</div>
					
					<div class="col-3 mb-3" id="divSuframa">
							<label class="text-label">Suframa</label>	
							<input type="text" name="suframa" id="suframa" value="{{isset($cliente->suframa) ? $cliente->suframa : old('suframa') }}"  class="form-campo">
					</div>
					
					<div class="col-3 mb-3" id="idestrangeiro">
							<label class="text-label">Doc. Estrangeiro</label>	
							<input type="text" name="idestrangeiro" maxlength="20" id="idestrangeiro" value="{{$cliente->idestrangeiro ?? old('idestrangeiro') }}"  class="form-campo">
					</div>					
								

					<div class="col-2 mb-3">
							<label class="text-label">Fone</label>	
							<input type="text" name="telefone" maxlength="14" id="telefone" value="{{isset($cliente->telefone) ? $cliente->telefone : old('telefone') }}"  class="form-campo mascara-fone">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label">Celular</label>	
							<input type="text" name="celular" id="celular" value="{{isset($cliente->celular) ? $cliente->celular : old('celular') }}"  class="form-campo mascara-celular">
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