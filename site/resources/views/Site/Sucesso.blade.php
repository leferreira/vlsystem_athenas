@extends("Site.template")
@section("conteudo")
@include("Site.cabecalho")

<div class="cadastro processar_cadastro">
	<div class="conteudo">
		<div class="rows">			
			<div class="col-6 m-auto text-center radius-10">
				<div class="caixa pb-5">
					<i class="far fa-check-circle mb-1 mt-4" aria-hidden="true"></i>				
					<h3 class="h3 text-center">Parabéns!</h3>
					<p class="text-cinza">Seu cadastro foi concluído.</p>
					<p class="text-cinza mb-4">Clique no botão abaixo para acessar sua área</p>
					<a href="" class="btn btn-azul d-inline-block">Acessar minha área</a>
					
				</div>		
			</div>		
		</div>		
	</div>		
</div>
@include('Site.rodape')
@endsection