@extends("Site.template")
@section("conteudo")
@include("Site.cabecalho")
<div class="base-banner pg">
	<div class="conteudo">
		<div class="rows">
			<div class="col-12 m-auto text-center">
				<span class="d-block text-center h4 text-escuro mt-1">Escolha um <span class="text-azul">plano ideal</span> para sua empresa</span>
				
				<span class="d-block text-center pb-2 text-escuro">Escolha um periodo abaixo:</span>
				<div class="group-btn center-middle justify-content-center mb-3">											
					<a href="{{route('planos')}}" class="{{config('constantes.tipo_recorrencia.MENSAL') == $id ? 'btn btn-padrao btn-min ativo' : 'btn btn-outline-azul btn-min '}}">Mensal</a>
					<a href="{{route('recorrencia', config('constantes.tipo_recorrencia.TRIMESTRAL'))}}" class="{{config('constantes.tipo_recorrencia.TRIMESTRAL') == $id ? 'btn btn-padrao btn-min ativo' : 'btn btn-outline-azul btn-min '}}">Trimestral</a>
					<a href="{{route('recorrencia', config('constantes.tipo_recorrencia.SEMESTRAL'))}}" class="{{config('constantes.tipo_recorrencia.SEMESTRAL') == $id ? 'btn btn-padrao btn-min ativo' : 'btn btn-outline-azul btn-min '}}">Semestral</a>
					<a href="{{route('recorrencia', config('constantes.tipo_recorrencia.ANUAL'))}}" class="{{config('constantes.tipo_recorrencia.ANUAL') == $id ? 'btn btn-padrao btn-min ativo' : 'btn btn-outline-azul btn-min '}}">Anual</a>
				</div>
			</div>
		</div>
		<div class="rows rows2 text-center mt-2">
		@foreach($planos as $plano)
			
		@php		
		  $usuario = ($plano->limite_usuario==1) ? "01 Usuário" : $plano->limite_usuario . " Usuários" ; 
		  $nota    = ($plano->limite_nfe>0) ? $plano->limite_nfe ." Nota fiscais de produto" :  "Nota fiscal Não permitida" ;  
		  $total   = $plano->preco + $plano->plano->valor_setup;
		@endphp
			<div class="col d-flex mb-3">
				<div class="caixa {{($plano->plano->destaque=='S') ? 'plano3' : 'plano1'}}">
					<strong class="h5 d-block mb-3 text-uppercase">{{$plano->plano->nome}}</strong>
					
					<p class="h5 mb-1 text-vermelho"><strike>De {{$plano->preco_de}}</strike></p>
					<p class="h5"><span class="text-escuro">Por apenas</span> <strong class="d-block  h4">R$ {{$plano->preco}}</strong></p>+ setup {{$plano->plano->valor_setup}}</p>
					<p class=""><span class="text-escuro">Total: </span> <strong class="d-block  h4"><small style="font-weight: 100">R$</small> {{ formataNumeroBr($total) }}</strong> </p>
					<ul>
						<li><i class="fas fa-check"></i> {{$usuario}}            </li>
						<li><i class="fas fa-check"></i> {{ ($plano->limite_nfe == -1) ? " Nfe Ilimitado " : $nota }}  </li>
						<li><i class="fas fa-check"></i> Loja Virtual        </li>
						<li><i class="fas fa-times"></i> Sistema Completo        </li>
						<li><i class="fas fa-times"></i> Suporte Gratuito        </li>
						<li><i class="fas fa-times"></i> Atualizações Gratuitas	</li>
					</ul>
					
					<a href="{{route('cadastro',$plano->id )}}" class="btn btn-verde d-table m-auto scroll-page"><i class="fas fa-arrow-right"></i> Quero testar</a>
				</div>
			</div>
		
		@endforeach					
			
		</div>
	</div>
</div>


@include('Site.rodape')




@endsection