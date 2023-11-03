@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" mb-0 h5"><i class="fas fa-plus-circle"></i> Cadastrar tecnicos</span>
		<div>
			<a href="{{route('admin.tecnico.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>		
		</div>
	</div>                 
 @if(isset($tecnico))    
   <form action="{{route('admin.tecnico.update', $tecnico->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.tecnico.store')}}" method="Post">
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
							<input type="text" name="nome" maxlength="60"  required id="nome" value="{{isset($tecnico->nome) ? $tecnico->nome: old('nome') }}" class="form-campo">
					</div> 
					
					<div class="col-4 mb-3">
							<label class="text-label">Email</label>	
							<input type="text" name="email" id="email" maxlength="60"  value="{{isset($tecnico->email) ? $tecnico->email : old('email') }}" autocomplete="new-email" class="form-campo">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label">Senha</label>	
							<input type="password" name="senha" id="senha"  value="{{isset($tecnico->senha) ? $tecnico->senha : old('senha') }}"  autocomplete="new-password" class="form-campo">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label" >CPF<span class="text-vermelho">*</span></label>	
							<input type="text" name="cpf" value="{{isset($tecnico->cpf) ? $tecnico->cpf: old('cpf') }}"  class="form-campo mascara-cpf">
					</div>
					

					<div class="col-2 mb-3">
							<label class="text-label">Fone</label>	
							<input type="text" name="telefone" maxlength="14" id="telefone" value="{{isset($tecnico->telefone) ? $tecnico->telefone : old('telefone') }}"  class="form-campo mascara-fone">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label">Celular</label>	
							<input type="text" name="celular" id="celular" value="{{isset($tecnico->celular) ? $tecnico->celular : old('celular') }}"  class="form-campo mascara-celular">
					</div>
					
					
				</div>
			</fieldset>
			<fieldset>
					<legend>Endereço</legend>
													
					<div class="rows">	
							<div class="col-2 mb-3">
                            <label class="text-label">Cep<span class="text-vermelho">*</span></label>	
                            <input type="text" name="cep" id="cep" required value="{{isset($tecnico->cep) ? $tecnico->cep : old('cep') }}"  class="form-campo busca_cep mascara-cep">
                            </div>
                            
                            <div class="col-4 mb-3">
                                    <label class="text-label">Logradouro<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="logradouro" maxlength="60" required id="logradouro" value="{{isset($tecnico->logradouro) ? $tecnico->logradouro : old('logradouro') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Numero<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="numero" required id="numero" value="{{isset($tecnico->numero) ? $tecnico->numero : old('numero') }}"  class="form-campo">
                            </div>
                            <div class="col-4 mb-3">
                                     <label class="text-label">Bairro</label>	
                                     <input type="text" name="bairro"  maxlength="60" id="bairro" value="{{isset($tecnico->bairro) ? $tecnico->bairro : old('bairro') }}"  class="form-campo bairro">
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="complemento" maxlength="60" id="complemento" value="{{isset($tecnico->complemento) ? $tecnico->complemento : old('complemento') }}"  class="form-campo">
                             </div>	                            
        						 
                             <div class="col-2 mb-2">
                                 <label class="text-label">UF</label>	
                                 <input type="text" name="uf" id="uf" required  value="{{isset($tecnico->uf) ? $tecnico->uf : old('uf') }}"   class="form-campo estado"> 
                             </div>                    
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade</label>	
                                     <input type="text" name="cidade" maxlength="60" required id="cidade" value="{{isset($tecnico->cidade) ? $tecnico->cidade : old('cidade') }}"  class="form-campo cidade">
                             </div>	
                             <div class="col-2 mb-3">
                                     <label class="text-label">Ibge</label>	
                                     <input type="text" name="ibge" required id="ibge" value="{{isset($tecnico->ibge) ? $tecnico->ibge : old('ibge') }}"  class="form-campo ibge ">
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