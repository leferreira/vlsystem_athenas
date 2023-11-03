@extends("template_loja")
@section("conteudo")

<div class="col-10">
				<!---categorias -->
				<div class="categorias">
				   	<div class="titulo">
						<div><span>Categoria <i class="fas fa-angle-double-right"></i></span> <span class="migalha">{{$subcategoria->subcategoria}}</span></div>
						
					</div>
					<div class="rows">
			@if($produtos)
					@foreach($produtos as $p)
						<div class="col-3">
							<div class="caixa-prod">
								<div class="thumb-prod">
									@php $img = getenv("APP_IMAGEM_PRODUTO") .$p->imagem; @endphp
									<img src="{{asset($img)}}" class="img-fluido">
								</div>
	
								<span>{{$p->nome}}</span>
								<strong>R${{$p->valor_venda}}</strong>
								<div class="guardar">
									<ul class="favorito">
										<li><a href=""><i class="fas fa-star"></i></a></li>
										<li><a href=""><i class="fas fa-star"></i></a></li>
										<li><a href=""><i class="fas fa-star"></i></a></li>
										<li><a href=""><i class="far fa-star"></i></a></li>
										<li><a href=""><i class="far fa-star"></i></a></li>
									</ul>
									<ul class="gostei">
										<li><a href="" title="Meu favorito"><i class="fas fa-heart"></i></a></li>
										<li><a href="" title="Minha lista"><i class="fas fa-align-left"></i></a></li>
										<li><a href="{{route('produto.detalhe',$p->uuid)}}" title="Colocar no carrinho"><i class="fas fa-shopping-cart"></i></a></li>
									</ul>
								</div>
								<div class="btn-comprar">
									<a href="{{route('produto.detalhe',$p->id)}}" class="btn btn-vermelho">Detalhes</a>
								</div>
							</div>
						</div>
						@endforeach
				@endif	
					
				</div>				
				<!---categorias -->
			</div>
			

		</div>
		
	
		
@endsection
	
<!--CARREGA O GIRA GIRA-->
<div class="window load" id="carregar">
	<span class="text-load">Carregando...</span>
</div>

<!--Fundo Preto-->
<div id="fundo_preto"></div>