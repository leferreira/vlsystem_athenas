@extends("template_loja")
@section("conteudo")

<div class="col-12">
				<div class="carrinho finalizar">
					
					<div class="rows">						
						<div class="col">
							<div class="border caixa p-4">
								<form action="{{route('cliente.salvar')}}" method="post">
								@csrf
								<div class="rows">	
									<div class="col-12 mb-3 thead between">
										<div>
											<small style="color:red">(*) campo obrigatório</small>
											<h3>Dados Pessoais</h3>
										</div>
									<a href="{{route('login')}}" class="btn btn-azul">Fazer Login</a>
									</div>	
									<div class="col-12 mb-3">
										<small class="text-label">Nome:<small style="color:red"> *</small></small>
										<input type="text" required name="nome" value="{{old('nome')}}"  class="form-campo"> 
									</div>									
													
									<div class="col-6 mb-3">
										 <small class="text-label">CPF:<small style="color:red"> *</small></small>
										 <input type="text" required name="cpf" value="{{old('cpf')}}"  class="form-campo mascara-cpf"> 
									</div>
									<div class="col-6 mb-3">
										 <small class="text-label">Celular<small style="color:red"> *</small></small>
										 <input type="text" required name="telefone" value="{{old('telefone')}}" class="form-campo mascara-celular"> 
									</div>
									
									<div class="col-6 mb-3">
										<small class="text-label">E-mail:<small style="color:red"> *</small></small>
										<input type="email" required name="email" value="{{old('email')}}"  class="form-campo"> 
									</div>
									<div class="col-6 mb-3">
										<small class="text-label">Senha:<small style="color:red"> *</small></small>
										<input type="password" required name="senha" value="{{old('senha')}}"  class="form-campo"> 
									</div>
									
									<div class="col-12 mb-3 mt-3">
										<h3 class="pb-1 border-bottom">Informações de Endereço</h3>
									</div>   
									<div class="col-3 mb-3">
										<small class="text-label">CEP:</small>
										<input type="text" required name="cep" value="{{old('cep')}}" class="form-campo mascara-cep busca_cep">
									</div>
											
									<div class="col-6 mb-3">
										<small class="text-label">Rua:</small>
										<input type="text" required name="rua" value="{{old('rua')}}" class="form-campo rua">
									</div>
											
									<div class="col-2 mb-3">
										<small class="text-label">Número:</small>
										<input type="text" required name="numero" value="{{old('numero')}}"  class="form-campo">
									</div>
										   
									<div class="col-1 mb-3">
										<small class="text-label">Estado:</small>
										<input type="text" required name="uf" value="{{old('uf')}}"  class="form-campo estado">						
									</div>
									  
									<div class="col-4 mb-3"> 
										 <small class="text-label">Complemento:</small>
										 <input type="text" name="complemento" value="{{old('complemento')}}" class="form-campo">
									</div>
									<div class="col-3 mb-3">
										<small class="text-label">Bairro:</small>
										 <input type="text" required name="bairro" value="{{old('bairro')}}" class="form-campo bairro">
									</div>
									<div class="col-3 mb-3">
										 <small class="text-label">Cidade:</small>
										 <input type="text" required name="cidade" value="{{old('cidade')}}" class="form-campo cidade">
									</div>
									<div class="col-2 mb-3">
										 <small class="text-label">IBGE:</small>
										 <input type="text"  name="ibge" value="{{old('ibge')}}" class="form-campo ibge">
									</div>
									<div class="col-3 m-auto text-center pt-4">
										<input type="hidden" id="pedido_id" name="pedido_id" >
										<input type="submit"  value="Cadastrar" class="btn btn-vermelho d-block btn-medio w-100">
									</div>
								</div>
							</form>
							
							</div>
						</div>
						
						<div id="fundo_preto"></div>
				</div>				
			</div>
			
			
		</div>
		
@endsection


	