@extends("template_loja")
@section("conteudo")

<div class="col-12">
				<div class="carrinho finalizar produtos">
					
					<div class="rows">
						
						<div class="col-6 m-auto">		
							<div class="border caixa">	
								<div class="thead between">
									<h5 class="">Ainda não é cadastrado?</h5>
									<a href="{{route('cliente.create')}}" class="btn btn-azul">Clique aqui para Cadastrar</a>
								</div>								
							<div class=" p-4 px-md">					
								
								<form action="{{route('logar')}}" method="post">
								@csrf
								<div class="rows">
									
									<div class="col-12 mb-3 mt-3">
										<h4 class="pb-1">Entre com seu login e senha</h4>
									</div>   
									<div class="col-12 mb-3">
										<small class="text-label">E-mail:<small style="color:red"> *</small></small>
										<input type="email" required name="email" value="" class="form-campo">
									</div>
									<div class="col-12 mb-3">
										<small class="text-label">Senha:<small style="color:red"> *</small></small>
										<input type="password" required name="senha" value="" class="form-campo">
									</div>
									
									<div class="col-12 mb-3">
										<small class="d-block"><a href="" class="text-azul senha">Esqueci minha senha</a></small>
									</div>
									
									
									<div class="col-3 m-auto text-center pt-2">
										<input type="submit" name="" value="Logar" class="btn btn-vermelho d-block btn-medio w-100">
									</div>
								</div>
							</form>
							
							</div>
							</div>
							
							<div class="esquecisenha">
								<span class="senha">X</span>
								<h1 class="text-center pt-2 pb-0">Esqueci minha senha</h1>
								<p class="text-center mb-3">Digite seu email no campo abaixo para recuperar sua senha</p>
								<form action="" method="POST" name="">
									<span class="label">Email</span>
									<input type="text" placeholder="Insira seu login" class="form-campo mb-3">
									<input type="submit" value="Enviar email" class="btn btn-vermelho h5 m-auto">
								</form>
							</div>
						</div>
						
					
						<div id="fundo_preto"></div>
				</div>				
			</div>
			
			
		</div>


@endsection
	