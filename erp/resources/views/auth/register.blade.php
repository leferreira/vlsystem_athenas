@extends("Site.template")
@section("conteudo")
@include("Site.cabecalho")

<div class="base-banner-top cadastro">
<div class="cadastro">
	<div class="conteudo">
		<div class="rows">
			
			<div class="col-4 m-auto text-center d-flex">			
    			<div class="caixa border">
    				<img src="{{asset('assets/site/img/logo-athenas-2.png')}}" width="100">				
    				<h3 class="h3 text-center text-azul mt-4">Cadastre-se</h3>
    				<p class="text-cinza">Preencha os campos ao lado e cadastre-se gratuitamente.</p>
    				<p class="py-4 text-cinza">ou</p>
    				<a href="{{route('login')}}" class="btn btn-azul d-inline-block">Faça Seu Login</a>			
    			</div>		
			</div>		
			
			<div class="col-8 m-auto">
			<div class="caixa border">
				<form action="{{ route('register') }}" method="post">			
				 @csrf
					<h3 class="h3 text-center text-azul">Experimente agora</h3>
					<div class="rows">					
						
						<div class="col-12 mb-3">
							<label class="text-label">Empresa</label>
							<input type="text" name="empresa" value="{{old('empresa')}}" required class="form-campo" required >
						</div>
						
						<div class="col-12 mb-3">
							<label class="text-label">Nome completo</label>
							<input type="text" name="name" value="{{old('name')}}" required class="form-campo" required >
						</div>
						<div class="col-6 mb-3">
							<label class="text-label">Email Profissional</label>
							<input type="email" name="email" value="{{old('email')}}" required class="form-campo" required >
						</div>
					
					<div class="col-6">
						<div class=" mb-3">
						<label class="text-label">Celular/Whatsapp</label>
						<input type="text" name="celular" value="{{old('celular')}}" required minlength="10" maxlength="17"  class="mascara_tel form-campo mascara-fone required">
						</div>
					</div>
					
					<div class="col-6">
						<div class="mb-3">
						<label class="text-label">Crie sua senha de acesso</label>
						<input id="password" type="password" class="form-campo @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
						</div>
					</div>
					<div class="col-6">
						<div class="mb-3">
						<label class="text-label">Confirme a Senha</label>
						 <input id="password-confirm" type="password" class="form-campo" name="password_confirmation" required autocomplete="new-password">
						</div>
					</div>
					
					<div class="col-12">
						
						<div class=" mb-3">
    						<label class="text-label">Como nos Conheceu?</label>
    						<select class="form-campo" name="conheceu" required>
    						<option value="">Selecione uma opção</option>
    						<option value="busca">Busca na Internet</option>
    						<option value="anuncio">Anúncio na Internet</option>
    						<option value="indicacao">Indicação de Amigo</option>
    						<option value="influenciadores">Influenciadores ou Redes Sociais </option>
    						<option value="google">Google</option>
    						<option value="facebook">Facebook</option>
    						<option value="outro">Outro</option>
						</select>
						</div>

					</div>
					<div class="col-12 text-center mt-3 mb-3">
						<input type="hidden" name="plano_preco_id" value="{{ session('plano_id') }}">
						<input type="submit" class="btn btn-azul m-auto" value="Cadastrar">
					</div>
					</div>
					</form>
			
			</div>
			</div>
		</div>
	</div>
	</div>
	</div>

@include('Site.rodape')


@endsection