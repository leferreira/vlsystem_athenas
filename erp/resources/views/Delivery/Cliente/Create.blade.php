@extends("templates.template_delivery")
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
			
				<form action="{{route('delivery.cliente.salvar')}}" method="post">	
						@csrf
						<span class="titulo">Dados de usuário</span>
						<span class="titulo-m">cadastre seu email e senha para acesso</span>
							
							<div class="rows">
								<div class="col-12 mb-3">
								 	<small>Nome</small>
								 	<input type="text" name="nome" value="{{old('nome')}}"> 
								</div>
								
								<div class="col-12 mb-3">
								 	<small>SobreNome</small>
								 	<input type="text" name="sobre_nome" value="{{old('sobre_nome')}}"> 
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
								 	<input type="password" name="senha" value="{{old('password')}}"> 
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
	