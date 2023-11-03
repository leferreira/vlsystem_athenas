@extends("template_config")
@section("conteudo")

<div class="col-12">
				<div class="carrinho finalizar produtos">
					
					<div class="rows">
						
						<div class="col-6 m-auto">		
							<div class="border caixa">																	
							<div class=" p-4 px-md">					
								
								<form action="{{route('configuracao.login')}}" method="post">
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
										<input type="password" required name="password"  class="form-campo">
									</div>
																		
									<div class="col-3 m-auto text-center pt-2">
										<input type="submit" value="Logar" class="btn btn-vermelho d-block btn-medio w-100">
									</div>
								</div>
							</form>
							
							</div>
							</div>						
							
						</div>
						
					
						<div id="fundo_preto"></div>
				</div>				
			</div>
			
			
		</div>


@endsection
	