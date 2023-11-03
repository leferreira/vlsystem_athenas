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
				<form action="{{route('delivery.web.logar')}}" method="post">	
						@csrf
						<span class="titulo">Dados de usuário</span>
						<span class="titulo-m">cadastre seu email e senha para acesso</span>
							
							<div class="rows">
								<div class="col-12 mb-3">
								 <small>E-mail ou Telefone</small>
								 <input type="text" name="email" value=""> 
								</div>
								
								<div class="col-12 mb-3">
								 <small>Senha:</small>
								 <input type="password" name="senha" value=""> 
								 </div>
							</div>
						
						<input type="submit" value="Fazer Login" class="btn concluir entrar">
						<a href="" class="" href="">Esqueci minha senha</a><br>
						<a href="{{route('delivery.web.cadastro')}}" class="" href="">Fazer Cadastrar</a>
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
	