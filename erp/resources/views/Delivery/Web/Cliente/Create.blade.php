@extends("Delivery.Web.template")
@section("conteudo")

<div class="conteudo">
<div class="base-prod-home">		


<div class="carrinho">
<div class="base-detalhes">
	<div class="base-carrinho">				
		<div class="caixa-carrinho">
			<div class="caixa-entrega">	
			<div class="col-6 m-auto">	

@if ($errors)				
	{{ $errors }}	
@endif
			
				<form action="{{route('delivery.web.cliente.salvar')}}" method="post">	
						@csrf
						<span class="titulo">Dados de usuário</span>
						<span class="titulo-m">cadastre seu email e senha para acesso</span>
							
							<div class="rows">
								<div class="col-12 mb-3">
								 	<small>Nome</small>
								 	<input type="text" name="nome_razao_social" value="{{old('nome_razao_social')}}"> 
								</div>
								
								<div class="col-12 mb-3">
								 	<small>Cpf</small>
								 	<input type="text" name="cpf_cnpj" value="{{old('cpf_cnpj')}}"> 
								</div>
								
								<div class="col-12 mb-3">
								 	<small>Celular</small>
								 	<input type="text" name="celular" value="{{old('celular')}}"> 
								</div>
								
								<div class="col-12 mb-3">
								 	<small>E-mail:</small>
								 	<input type="email" name="email" value="{{old('email')}}"> 
								</div>
								<div class="col-12 mb-3">
								 	<small>Senha:</small>
								 	<input type="password" name="password" value="{{old('password')}}"> 
								 </div>								 
								 
							</div>
							
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
					
						<input type="submit" value="cadastrar contato" class="btn concluir entrar">
						<a href="" class="" href="">Esqueci minha senha</a>
			</form>										
		</div>
		</div>
							
		</div>
		</div>
	</div>
	</div>
</div>
</div>


@endsection
	