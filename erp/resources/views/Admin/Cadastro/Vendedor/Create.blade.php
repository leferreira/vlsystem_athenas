@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" mb-0 h5"><i class="fas fa-plus-circle"></i> Cadastrar vendedors</span>
		<div>
			<a href="{{route('admin.vendedor.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>		
		</div>
	</div>                 
 @if(isset($vendedor))    
   <form action="{{route('admin.vendedor.update', $vendedor->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.vendedor.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	  <div id="tab-1">
		<div class="p-2 mt-1">
			<small class="d-block text-right text-vermelho">(*) Campos obrigatórios</small>

			<fieldset>
				<legend>Informações básicas</legend>
				
				<div class="rows">
					<div class="col-4 mb-3">
							<label class="text-label" >Nome<span class="text-vermelho">*</span></label>	
							<input type="text" name="nome" maxlength="60"  required id="nome" value="{{isset($vendedor->nome) ? $vendedor->nome: old('nome') }}" class="form-campo">
					</div> 
					
					<div class="col-4 mb-3">
							<label class="text-label">Email</label>	
							<input type="text" name="email" id="email" maxlength="60"  value="{{isset($vendedor->email) ? $vendedor->email : old('email') }}" autocomplete="new-email" class="form-campo">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label">Senha</label>	
							<input type="password" name="senha" id="senha"  value="{{isset($vendedor->senha) ? $vendedor->senha : old('senha') }}"  autocomplete="new-password" class="form-campo">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label" >CPF<span class="text-vermelho">*</span></label>	
							<input type="text" name="cpf" value="{{isset($vendedor->cpf) ? $vendedor->cpf: old('cpf') }}"  class="form-campo mascara-cpf">
					</div>
					

					<div class="col-2 mb-3">
							<label class="text-label">Fone</label>	
							<input type="text" name="telefone" maxlength="14" id="telefone" value="{{isset($vendedor->telefone) ? $vendedor->telefone : old('telefone') }}"  class="form-campo mascara-fone">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label">Celular</label>	
							<input type="text" name="celular" id="celular" value="{{isset($vendedor->celular) ? $vendedor->celular : old('celular') }}"  class="form-campo mascara-celular">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label">Comissão</label>	
							<input type="text" name="comissao"  value="{{isset($vendedor->comissao) ? $vendedor->comissao : old('comissao') }}"  class="form-campo mascara-float">
					</div>
					
				</div>
			</fieldset>
			<fieldset>
					<legend>Endereço</legend>
													
					<div class="rows">	
							<div class="col-2 mb-3">
                            <label class="text-label">Cep<span class="text-vermelho">*</span></label>	
                            <input type="text" name="cep" id="cep" required value="{{isset($vendedor->cep) ? $vendedor->cep : old('cep') }}"  class="form-campo busca_cep mascara-cep">
                            </div>
                            
                            <div class="col-4 mb-3">
                                    <label class="text-label">Logradouro<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="logradouro" maxlength="60" required id="logradouro" value="{{isset($vendedor->logradouro) ? $vendedor->logradouro : old('logradouro') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Numero<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="numero" required id="numero" value="{{isset($vendedor->numero) ? $vendedor->numero : old('numero') }}"  class="form-campo">
                            </div>
                            <div class="col-4 mb-3">
                                     <label class="text-label">Bairro<span class="text-vermelho">*</span></label>	
                                     <input type="text" name="bairro"   maxlength="60" id="bairro" value="{{isset($vendedor->bairro) ? $vendedor->bairro : old('bairro') }}"  class="form-campo bairro">
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="complemento" maxlength="60" id="complemento" value="{{isset($vendedor->complemento) ? $vendedor->complemento : old('complemento') }}"  class="form-campo">
                             </div>	                            
        						 
                             <div class="col-2 mb-2">
                                 <label class="text-label">UF<span class="text-vermelho">*</span></label>	
                                 <input type="text" name="uf" id="uf" required  value="{{isset($vendedor->uf) ? $vendedor->uf : old('uf') }}"   class="form-campo estado"> 
                             </div>                    
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade<span class="text-vermelho">*</span></label>	
                                     <input type="text" name="cidade" maxlength="60" required id="cidade" value="{{isset($vendedor->cidade) ? $vendedor->cidade : old('cidade') }}"  class="form-campo cidade">
                             </div>	
                             <div class="col-2 mb-3">
                                     <label class="text-label">Ibge</label>	
                                     <input type="text" name="ibge" required id="ibge" value="{{isset($vendedor->ibge) ? $vendedor->ibge : old('ibge') }}"  class="form-campo ibge ">
                             </div>  
					</div>
				</fieldset>
		</div>
	  </div>
         
 </div>
		<div class="col-12 text-center pb-4">	
			<input type="hidden" name="eh_modal" id="eh_modal" value="0">
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	  </div>
	
</form>



@endsection