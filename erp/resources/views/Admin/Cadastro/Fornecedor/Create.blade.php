@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" h5 mb-0 "><i class="fas fa-plus-circle"></i> Cadastrar fornecedores</span>
		<div>
			<a href="{{route('admin.fornecedor.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>	
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>			
		</div>
	</div>                 
 @if(isset($fornecedor))    
   <form action="{{route('admin.fornecedor.update', $fornecedor->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.fornecedor.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2 mt-1">
			<small class="d-block text-right text-vermelho">(*) Campos obrigatórios</small>
			<fieldset style="background: #f3f3f3;">
				<legend>Pesquisar Por CNPJ</legend>
				<div class="rows">
					<div class="col-2 mb-3">
							<label class="text-label">Tipo Cliente</label>	
							<select  name="tipo_cliente" id="tipo_cliente" class="form-campo" onchange ="tipoCliente()"  >
								<option value="J">Juridica</option>
								<option value="F">Física</option>
															
							</select>
					</div>
					
					<div class="col-6" id="div_pesquisar">
						<label class="text-label">Pesquisa CNPJ</label>
						<div class="grupo-form-btn">
							<input type="text" id="codigocnpj"   class="form-campo mascara-cnpj">
							<input type="button" onclick="pesquisarCnpj()" value="Pesquisar CNPJ" class="btn btn-azul d-block m-auto">
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Informações básicas</legend>
				
				<div class="rows">												
					<div class="col-6 mb-3">
							<label class="text-label"  id="lblRazaoSocial">Razão Social<span class="text-vermelho">*</span></label>	
							<input type="text" name="razao_social" maxlength="60" required id="razao_social" value="{{isset($fornecedor->razao_social) ? $fornecedor->razao_social : old('razao_social') }}" class="form-campo">
					</div>                                    
					<div class="col-3 mb-3" id="divFantasia">
							<label class="text-label">Nome Fantasia</label>	
							<input type="text" name="nome_fantasia" maxlength="60" id="nome_fantasia" value="{{isset($fornecedor->nome_fantasia) ? $fornecedor->nome_fantasia : old('nome_fantasia') }}" class="form-campo">
					</div>
					<div class="col-3 mb-3">
							<label class="text-label"  id="lblCnpj">CNPJ<span class="text-vermelho">*</span></label>	
							<input type="text" name="cnpj" required id="cnpj" value="{{isset($fornecedor->cnpj) ? $fornecedor->cnpj : old('cnpj') }}"  class="form-campo">
					</div>
									
					
					<div class="col-4 mb-3">
							<label class="text-label">Email</label>	
							<input type="text" name="email" maxlength="60" id="email" value="{{isset($fornecedor->email) ? $fornecedor->email : old('email') }}"  class="form-campo">
					</div>
											
					
					<div class="col-3 mb-3" id="div_tipo_contribuinte">
							<label class="text-label">Tipo de Contribuinte</label>	
							<select  name="tipo_contribuinte" class="form-campo">
								<option value="1">Contribuinte ICMS</option>
								<option value="9">Não Contribuinte</option>									
								<option value="2">Contribuinte Isento</option>
															
							</select>
					</div>				
					
					<div class="col-3 mb-3" >
							<label class="text-label" id="lblInscEstadual">Inscrição Estadual</label>	
							<input type="text" name="rg_ie" id="rg_ie" value="{{isset($fornecedor->rg_ie) ? $fornecedor->rg_ie : old('rg_ie') }}"  class="form-campo">
					</div>
					
					<div class="col-2 mb-3" id="divIscMunicipal">
							<label class="text-label">Insc. Municipal</label>	
							<input type="text" name="im" id="im" value="{{isset($fornecedor->im) ? $fornecedor->im : old('im') }}"  class="form-campo">
					</div>				
					
					<div class="col-3 mb-3">
							<label class="text-label">Fone</label>	
							<input type="text" name="telefone" maxlength="14" id="telefone" value="{{isset($fornecedor->telefone) ? $fornecedor->telefone : old('telefone') }}"  class="form-campo mascara-fone">
					</div>
					
					<div class="col-3 mb-3">
							<label class="text-label">Celular</label>	
							<input type="text" name="celular" id="celular" value="{{isset($fornecedor->celular) ? $fornecedor->celular : old('celular') }}"  class="form-campo mascara-fone">
					</div>
					
				</div>
			</fieldset>
			
			<fieldset>
					<legend>Endereço</legend>
													
					<div class="rows">	
							<div class="col-2 mb-3">
                            <label class="text-label"  >Cep<span class="text-vermelho">*</span></label>	
                            <input type="text" name="cep" required id="cep" value="{{isset($fornecedor->cep) ? $fornecedor->cep : old('cep') }}"  class="form-campo busca_cep mascara-cep">
                            </div>
                            
                            <div class="col-4 mb-3">
                                    <label class="text-label"  >Logradouro</label>	
                                    <input type="text" required name="logradouro" maxlength="60" id="logradouro" value="{{isset($fornecedor->logradouro) ? $fornecedor->logradouro : old('logradouro') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label"  >Numero<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="numero" required id="numero" value="{{isset($fornecedor->numero) ? $fornecedor->numero : old('numero') }}"  class="form-campo">
                            </div>
                            <div class="col-4 mb-3">
                                     <label class="text-label" >Bairro</label>	
                                     <input type="text" name="bairro" maxlength="60" required id="bairro" value="{{isset($fornecedor->bairro) ? $fornecedor->bairro : old('bairro') }}"  class="form-campo bairro">
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="complemento" maxlength="60" id="complemento" value="{{isset($fornecedor->complemento) ? $fornecedor->complemento : old('complemento') }}"  class="form-campo">
                             </div>	                            
        						 
                             <div class="col-2 mb-2">
                                 <label class="text-label" >UF</label>	
                                 <input type="text" name="uf" id="uf" required="required" value="{{isset($fornecedor->uf) ? $fornecedor->uf : old('uf') }}"   class="form-campo estado"> 
                             </div>                    
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade</label>	
                                     <input type="text" name="cidade" maxlength="60" required id="cidade" value="{{isset($fornecedor->cidade) ? $fornecedor->cidade : old('cidade') }}"  class="form-campo cidade">
                             </div>	
                             <div class="col-2 mb-3">
                                     <label class="text-label">Ibge</label>	
                                     <input type="text" name="ibge" id="ibge" value="{{isset($fornecedor->ibge) ? $fornecedor->ibge : old('ibge') }}"  class="form-campo ibge ">
                             </div>  
					</div>
				</fieldset>
		</div>
	  </div>
	  
	  
	
	  


         
 </div>
		<div class="col-12 text-center pb-4">
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	  </div>
	
</form>
</div>

<script>
	function tipoCliente(){
		var tp = $("#tipo_cliente").val();
		
		if(tp=="F"){
			$("#div_pesquisar").hide();
            $("#div_tipo_contribuinte").hide();
            $("#divIscEstadual").hide();
            $("#divSuframa").hide();
            $("#divFantasia").hide();
            
            $("#lblInscEstadual").html("RG");
            $("#lblCnpj").html('CPF');
            $("#lblRazaoSocial").html('Nome');
            $("#cnpj").mask('000.000.000-00', {reverse: true});
       
            
		}else{
			$("#div_pesquisar").show();
            $("#div_tipo_contribuinte").show();
            $("#divIscEstadual").show();
            $("#divSuframa").show();
            $("#divFantasia").show();
            
            $("#lblInscEstadual").html("Inscrição Estadual");
            $("#lblCnpj").html('CNPJ');
            $("#lblRazaoSocial").html('Razão Social');
            $("#cnpj").mask('00.000.000/0000-00', {reverse: true});
          
		}
	}
</script>
@endsection