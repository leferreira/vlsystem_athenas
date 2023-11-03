<?php
use App\Service\ConstanteService;
?>
<div class="window form alt" id="modalCadTecnico">
<span class="d-block h4 fw-700 titulo">Cadastro de Técnico</span>
		<a href="" class="fechar position-absolute">X</a>
		<div class="caixa mb-0 p-3">

    <input type="hidden" name="_token" value="HyqwkJzIzCTlOwEYbDBLYUyvJVW09v9kR9qo1hao">    

<form id="frmCadTecnico">	
<div class="scroll-modal">     
   <div id="tabmod" class="abas py-0">	    
	  <div id="tabmod-1">
		<div class="p-2 mt-3 px-0">			
				
			<fieldset>
				<legend>Dados Pessais</legend>	
				<div class="rows">
					<div class="col-4 mb-3">
							<label class="text-label" >Nome<span class="text-vermelho">*</span></label>	
							<input type="text" name="tecnico_nome" maxlength="60"  required id="tecnico_nome" value="{{isset($tecnico->nome) ? $tecnico->nome: old('nome') }}" class="form-campo">
					</div> 
					
					<div class="col-4 mb-3">
							<label class="text-label">Email</label>	
							<input type="text" name="email" id="tecnico_email" maxlength="60"  value="{{isset($tecnico->email) ? $tecnico->email : old('email') }}" autocomplete="new-email" class="form-campo">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label">Senha</label>	
							<input type="password" name="tecnico_senha" id="tecnico_senha"  value="{{isset($tecnico->senha) ? $tecnico->senha : old('senha') }}"  autocomplete="new-password" class="form-campo">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label" >CPF<span class="text-vermelho">*</span></label>	
							<input type="text" name="tecnico_cpf" id="tecnico_cpf" value="{{isset($tecnico->cpf) ? $tecnico->cpf: old('cpf') }}"  class="form-campo mascara-cpf">
					</div>
					

					<div class="col-2 mb-3">
							<label class="text-label">Fone</label>	
							<input type="text" name="tecnico_telefone" maxlength="14" id="tecnico_telefone" value="{{isset($tecnico->telefone) ? $tecnico->telefone : old('telefone') }}"  class="form-campo mascara-fone">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label">Celular</label>	
							<input type="text" name="tecnico_celular" id="tecnico_celular" value="{{isset($tecnico->celular) ? $tecnico->celular : old('celular') }}"  class="form-campo mascara-celular">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label">Comissão</label>	
							<input type="text" name="tecnico_comissao"  id="tecnico_comissao" value="{{isset($tecnico->comissao) ? $tecnico->comissao : old('comissao') }}"  class="form-campo mascara-float">
					</div>
				</div>
   
</fieldset>
	
		<fieldset>
				<legend>Endereço</legend>	
				<div class="rows">	
							<div class="col-2 mb-3">
                            <label class="text-label">Cep<span class="text-vermelho">*</span></label>	
                            <input type="text" name="tecnico_cep" id="tecnico_cep" required value="{{isset($tecnico->cep) ? $tecnico->cep : old('cep') }}"  class="form-campo busca_cep mascara-cep">
                            </div>
                            
                            <div class="col-4 mb-3">
                                    <label class="text-label">Logradouro<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="tecnico_logradouro" maxlength="60" required id="tecnico_logradouro" value="{{isset($tecnico->logradouro) ? $tecnico->logradouro : old('logradouro') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Numero<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="tecnico_numero" required id="tecnico_numero" value="{{isset($tecnico->numero) ? $tecnico->numero : old('numero') }}"  class="form-campo">
                            </div>
                            <div class="col-4 mb-3">
                                     <label class="text-label">Bairro</label>	
                                     <input type="text" name="tecnico_bairro"  maxlength="60" id="tecnico_bairro" value="{{isset($tecnico->bairro) ? $tecnico->bairro : old('bairro') }}"  class="form-campo bairro">
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="tecnico_complemento" maxlength="60" id="tecnico_complemento" value="{{isset($tecnico->complemento) ? $tecnico->complemento : old('complemento') }}"  class="form-campo">
                             </div>	                            
        						 
                             <div class="col-2 mb-2">
                                 <label class="text-label">UF</label>	
                                 <input type="text" name="tecnico_uf" id="tecnico_uf" required  value="{{isset($tecnico->uf) ? $tecnico->uf : old('uf') }}"   class="form-campo estado"> 
                             </div>                    
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade</label>	
                                     <input type="text" name="tecnico_cidade" maxlength="60" required id="tecnico_cidade" value="{{isset($tecnico->cidade) ? $tecnico->cidade : old('cidade') }}"  class="form-campo cidade">
                             </div>	
                             <div class="col-2 mb-3">
                                     <label class="text-label">Ibge</label>	
                                     <input type="text" name="tecnico_ibge" required id="tecnico_ibge" value="{{isset($tecnico->ibge) ? $tecnico->ibge : old('ibge') }}"  class="form-campo ibge ">
                             </div>  
					</div>  

		</fieldset>
		</div>
	  </div>
	 
         
 </div>

</div>
		
		<div class="col-12 text-center pb-0 tfooter end">
			<input type="button" class="btn btn-vermelho fechar" value="Fechar">
			<a href="javascript:;" onclick="salvarTecnico()" class="btn btn-azul">Salvar Dados</a>			
		</div>	
	
</form>
			
		</div>
	</div>
	
