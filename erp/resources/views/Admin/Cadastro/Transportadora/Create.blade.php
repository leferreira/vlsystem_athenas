@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase  d-flex justify-content-space-between center-middle">
		<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Cadastrar transportadoraes</span>
		<div>
			<a href="{{route('admin.transportadora.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>							
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
		</div>
	</div>                 
 @if(isset($transportadora))    
   <form action="{{route('admin.transportadora.update', $transportadora->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.transportadora.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	  <ul>
		<li><a href="#tab-1">Dados Pessoais</a></li>
		<li><a href="#tab-2">Endereço</a></li>
	  </ul>
	  <div id="tab-1">
		<div class="p-2 mt-1">
			<small class="d-block text-right text-vermelho">(*) Campos obrigatórios</small>
			<fieldset style="background: #f3f3f3;">
				<legend>Pesquisar Por CNPJ</legend>
				<div class="rows">
					<div class="col-6">
						<div class="grupo-form-btn">
							<input type="text" id="codigocnpj" {{isset($transportadora->cnpj) ? $transportadora->cnpj : old('cnpj') }}   class="form-campo">
							<input type="button" onclick="pesquisarCnpj()" value="Pesquisar CNPJ" class="btn btn-azul d-block m-auto">
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Informações básicas</legend>
				
				<div class="rows">												
					<div class="col-6 mb-3">
							<label class="text-label">Razão Social<span class="text-vermelho">*</span></label>	
							<input type="text" name="razao_social" maxlength="60" id="razao_social" value="{{isset($transportadora->razao_social) ? $transportadora->razao_social : old('razao_social') }}" class="form-campo">
					</div>                                    
					<div class="col-6 mb-3">
							<label class="text-label">Nome Fantasia</label>	
							<input type="text" name="nome_fantasia"  maxlength="60" id="nome_fantasia" value="{{isset($transportadora->nome_fantasia) ? $transportadora->nome_fantasia : old('nome_fantasia') }}" class="form-campo">
					</div>				
					
					<div class="col-3 mb-3">
							<label class="text-label">CNPJ<span class="text-vermelho">*</span></label>	
							<input type="text" name="cnpj" id="cnpj" value="{{isset($transportadora->cnpj) ? $transportadora->cnpj : old('cnpj') }}"  class="form-campo">
					</div>				
					<div class="col-3 mb-3">
							<label class="text-label">Email</label>	
							<input type="text" name="email" id="email" maxlength="60" value="{{isset($transportadora->email) ? $transportadora->email : old('email') }}"  class="form-campo">
					</div>
					<div class="col-3 mb-3">
							<label class="text-label">Fone</label>	
							<input type="text" name="telefone" maxlength="14" id="telefone" value="{{isset($transportadora->telefone) ? $transportadora->telefone : old('telefone') }}"  class="form-campo mascara-fone">
					</div>
					<div class="col-3 mb-3">
							<label class="text-label">Celular</label>	
							<input type="text" name="celular" maxlength="14" id="celular" value="{{isset($transportadora->celular) ? $transportadora->celular : old('celular') }}"  class="form-campo mascara-celular">
					</div>				
					
				</div>
			</fieldset>
		</div>
	  </div>
	  
	  
	  <div id="tab-2">
		<div class="p-2 mt-4">									
				<fieldset>
					<legend>Endereço</legend>
													
					<div class="rows">	
							<div class="col-2 mb-3">
                            <label class="text-label">Cep<span class="text-vermelho">*</span></label>	
                            <input type="text" name="cep" id="cep" value="{{isset($transportadora->cep) ? $transportadora->cep : old('cep') }}"  class="form-campo busca_cep">
                            </div>
                            
                            <div class="col-4 mb-3">
                                    <label class="text-label">Logradouro<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="logradouro" id="logradouro" value="{{isset($transportadora->logradouro) ? $transportadora->logradouro : old('logradouro') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Numero<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="numero" id="numero" value="{{isset($transportadora->numero) ? $transportadora->numero : old('numero') }}"  class="form-campo">
                            </div>
                            <div class="col-4 mb-3">
                                     <label class="text-label">Bairro<span class="text-vermelho">*</span></label>	
                                     <input type="text" name="bairro" id="bairro" value="{{isset($transportadora->bairro) ? $transportadora->bairro : old('bairro') }}"  class="form-campo bairro">
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="complemento" id="complemento" value="{{isset($transportadora->complemento) ? $transportadora->complemento : old('complemento') }}"  class="form-campo">
                             </div>	                            
        						 
                             <div class="col-2 mb-2">
                                 <label class="text-label">UF<span class="text-vermelho">*</span></label>	
                                 <input type="text" name="uf" id="uf" value="{{isset($transportadora->uf) ? $transportadora->uf : old('uf') }}"   class="form-campo estado"> 
                             </div>                    
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade<span class="text-vermelho">*</span></label>	
                                     <input type="text" name="cidade" id="cidade" value="{{isset($transportadora->cidade) ? $transportadora->cidade : old('cidade') }}"  class="form-campo cidade">
                             </div>	
                             <div class="col-2 mb-3">
                                     <label class="text-label">Ibge</label>	
                                     <input type="text" name="ibge" id="ibge" value="{{isset($transportadora->ibge) ? $transportadora->ibge : old('ibge') }}"  class="form-campo ibge ">
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
@endsection