@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" mb-0 h5"><i class="fas fa-plus-circle"></i> Cadastrar clientes</span>
		<div>
			<a href="{{route('admin.cliente.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>		
		</div>
	</div>                 
 @if(isset($aluno))    
   <form action="{{route('ead.aluno.update', $aluno->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('ead.aluno.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	  <div id="tab-1">
		<div class="p-2 mt-1">
			<small class="d-block text-right text-vermelho">(*) Campos obrigatórios</small>
			<fieldset style="background: #f3f3f3;">
				<legend>Dados do Cliente</legend>
				<div class="rows">
				<div class="col-6 mb-3">
							<label class="text-label" id="lblRazaoSocial">Nome do Cliente<span class="text-vermelho">*</span></label>	
							<input type="text" name="nome"   required value="{{isset($aluno->nome) ? $aluno->nome : old('nome_razao_social') }}" class="form-campo">
					</div> 
					
					<div class="col-4 mb-3">
							<label class="text-label">Email<span class="text-vermelho">*</span></label>	
							<input type="text" name="email" required value="{{isset($aluno->email) ? $aluno->email : old('email') }}"  class="form-campo">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label">Senha<span class="text-vermelho">*</span></label>	
							<input type="password" name="senha" id="senha"  value="{{isset($aluno->senha) ? $aluno->senha : old('senha') }}"  class="form-campo">
					</div>
				</div>
			</fieldset>
			
			<fieldset>
					<legend>Endereço</legend>
													
					<div class="rows">	
							<div class="col-2 mb-3">
                            <label class="text-label">Cep<span class="text-vermelho">*</span></label>	
                            <input type="text" name="cep" id="cep"  value="{{isset($aluno->cep) ? $aluno->cep : old('cep') }}"  class="form-campo busca_cep mascara-cep">
                            </div>
                            
                            <div class="col-4 mb-3">
                                    <label class="text-label">Logradouro<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="logradouro" maxlength="60"  id="logradouro" value="{{isset($aluno->logradouro) ? $aluno->logradouro : old('logradouro') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Numero<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="numero"  id="numero" value="{{isset($aluno->numero) ? $aluno->numero : old('numero') }}"  class="form-campo">
                            </div>
                            <div class="col-4 mb-3">
                                     <label class="text-label">Bairro</label>	
                                     <input type="text" name="bairro"  maxlength="60" id="bairro" value="{{isset($aluno->bairro) ? $aluno->bairro : old('bairro') }}"  class="form-campo bairro">
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="complemento" maxlength="60" id="complemento" value="{{isset($aluno->complemento) ? $aluno->complemento : old('complemento') }}"  class="form-campo">
                             </div>	                            
        						 
                             <div class="col-2 mb-2">
                                 <label class="text-label">UF</label>	
                                 <input type="text" name="uf" id="uf"   value="{{isset($aluno->uf) ? $aluno->uf : old('uf') }}"   class="form-campo estado"> 
                             </div>                    
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade</label>	
                                     <input type="text" name="cidade"   id="cidade" value="{{isset($aluno->cidade) ? $aluno->cidade : old('cidade') }}"  class="form-campo cidade">
                             </div>	
                             <div class="col-2 mb-3">
                                     <label class="text-label">Nascimento</label>	
                                     <input type="date" name=nascimento value="{{isset($aluno->nascimento) ? $aluno->nascimento : old('nascimento') }}"  class="form-campo  ">
                             </div>
                             
                             <div class="col-2 mb-3">
        							<label class="text-label" id="lblCnpj">CPF</label>	
        							<input type="text" name="cpf"   value="{{isset($aluno->cpf) ? $aluno->cpf : old('cpf') }}"  class="form-campo">
        					</div>	
        
        					<div class="col-2 mb-3">
        							<label class="text-label">Fone</label>	
        							<input type="text" name="telefone" maxlength="14" id="telefone" value="{{isset($aluno->telefone) ? $aluno->telefone : old('telefone') }}"  class="form-campo mascara-fone">
        					</div>
        					<div class="col-2 mb-3">
        							<label class="text-label">Celular</label>	
        							<input type="text" name="celular" id="celular" value="{{isset($aluno->celular) ? $aluno->celular : old('celular') }}"  class="form-campo mascara-celular">
        					</div>
					  
					</div>
				</fieldset>
				
			
			
		</div>
	  </div>
         
 </div>
		<div class="col-12 text-center pb-4">	
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
		</form>
	  </div>
	



@endsection