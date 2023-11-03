@extends("Admin.template")
@section("conteudo")
<div class="base-banner">
<div class="central">
	<div class="p-3">
		<div class="rows">
			<div class="col-12 m-auto text-center">
				<span class="d-block text-center h3 text-escuro mt-1">Escolha um <span class="text-azul">plano ideal</span> para sua empresa</span>
				
				
				<span class="d-block text-center pb-2">Escolha um periodo abaixo:</span>
				<div class="group-btn center-middle justify-content-center mb-3">											
					<a href="{{route('admin.meus_planos.assinar')}}" class="{{config('constantes.tipo_recorrencia.MENSAL') == $id ? 'btn btn-padrao btn-min ativo' : 'btn btn-outline-azul btn-min '}}">Mensal</a>
					<a href="{{route('admin.meus_planos.assinar', config('constantes.tipo_recorrencia.TRIMESTRAL'))}}" class="{{config('constantes.tipo_recorrencia.TRIMESTRAL') == $id ? 'btn btn-padrao btn-min ativo' : 'btn btn-outline-azul btn-min '}}">Trimestral</a>
					<a href="{{route('admin.meus_planos.assinar', config('constantes.tipo_recorrencia.SEMESTRAL'))}}" class="{{config('constantes.tipo_recorrencia.SEMESTRAL') == $id ? 'btn btn-padrao btn-min ativo' : 'btn btn-outline-azul btn-min '}}">Semestral</a>
					<a href="{{route('admin.meus_planos.assinar', config('constantes.tipo_recorrencia.ANUAL'))}}" class="{{config('constantes.tipo_recorrencia.ANUAL') == $id ? 'btn btn-padrao btn-min ativo' : 'btn btn-outline-azul btn-min '}}">Anual</a>
				</div>
				
				
			</div>
		</div>
		<div class="rows text-center mt-2">
		@foreach($planos as $plano)
		
		
		@php 
		
		  $usuario = ($plano->limite_usuario==1) ? "01 Usuário" : $plano->limite_usuario . " Usuários" ; 
		  $nota    = ($plano->limite_nfe>0) ? $plano->limite_nfe ." Nota fiscais de produto" :  "Nota fiscal Não permitida" ;  
		
		@endphp
			<div class="col d-flex mb-3">
				<div class="caixa {{($plano->plano->destaque=='S') ? 'plano3' : 'plano1'}}">
					<strong class="h5 d-block mb-3 text-uppercase text-azul">{{$plano->plano->nome}}</strong>
					<p class="h5 mb-1 text-vermelho"><strike>De {{$plano->preco_de}}</strike></p>
					<p class=""><span class="text-escuro">Por apenas</span> <strong class="d-block  h4"><small style="font-weight: 100">R$</small> {{$plano->preco}}</strong></p>
					<ul class="mb-3">
						<li><i class="fas fa-check"></i> {{$usuario}}            </li>
						<li><i class="fas fa-check"></i> {{ ($plano->limite_nfe == -1) ? " Nfe Ilimitado " : $nota }}  </li>
						<li><i class="fas fa-check"></i> Loja Virtual        </li>
						<li><i class="fas fa-check"></i> Sistema Completo        </li>
						<li><i class="fas fa-check"></i> Suporte Gratuito        </li>
						<li><i class="fas fa-check"></i> Atualizações Gratuitas	</li>
					</ul>
					<a href="{{route('admin.meus_planos.pagamento', $plano->id)}}" class="btn btn-azul d-table m-auto scroll-page">Adquirir Plano</a>
				</div>
			</div>
			
		@endforeach				
			
		</div>
	</div>
</div>
</div>

@endsection