@extends("Site.template")
@section("conteudo")
@include("Site.cabecalho")
<div class="base-banner">
	<div class="conteudo">
		<div class="rows">
			<div class="col-12 m-auto text-center">
				<span class="d-block text-center h4 text-escuro mt-1">Escolha um <span class="text-azul">plano ideal</span> para sua empresa</span>
			</div>
		</div>
		<div class="rows text-center mt-2">
		@foreach($planos as $plano)
			<div class="col d-flex mb-3">
				<div class="caixa plano1">
					<strong class="h5 d-block mb-3 text-uppercase">Plano semanal</strong>
					<p class="h5"><b>Qualquer curso </b>(individual)<br></p>
					<p class="h5"><span class="text-escuro">Por apenas</span> <strong class="d-block  h4">R$ 97,00</strong></p>
					<ul>
						<li><i class="fas fa-check"></i> 1 usuário               </li>
						<li><i class="fas fa-check"></i> Multiempresa            </li>
						<li><i class="fas fa-check"></i> Boletos ilimitados      </li>
						<li><i class="fas fa-check"></i> Nota fiscal de produto  </li>
						<li><i class="fas fa-check"></i> Nota fiscal de serviço  </li>
						<li><i class="fas fa-check"></i> Sistema Completo        </li>
						<li><i class="fas fa-check"></i> Suporte Gratuito        </li>
						<li><i class="fas fa-check"></i> Atualizações Gratuitas	</li>
					</ul>
					<a href="{{route('assinar')}}" class="btn btn-verde d-table m-auto scroll-page">Quero testar</a>
				</div>
			</div>
		@endforeach				
			
		</div>
	</div>
</div>


@include('Site.rodape')




@endsection