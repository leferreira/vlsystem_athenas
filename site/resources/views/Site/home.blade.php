@extends("Site.template")
@section("conteudo")
@include("Site.cabecalho")


<div class="base-banner-top">
	<div class="rows">
		<div class="col-6">
			<h1>Sistema de gestão de empresas</h1>
			<h5 class="mb-3">Gerencie seu negócio e empresa com nosso sistema de gestão completo e fácil de usar!</h5>
		<div class="d-flex but">
			<a href="{{route('planos')}}" class="btn btn-verde">Quero testar grátis</a>
			<a href="{{route('planos')}}" class="btn btn-outline-verde">Conversar com um operador</a>
		</div>
		</div>
	</div>
	<i class="fas fa-angle-down ico-centro"></i>
</div>
<div class="dobra_um">
	<div class="conteudo">
		<div class="rows">
			<div class="col-12 text-center">
				<span class="h2 mb-1 text-azul fw-700">Gerencie sua empresa</span>
				<span class="h5 text-escuro mb-5">Com o sistema Athenas você vai poder gerenciar as seguintes funções</span>
			</div>
			<div class="col-4 mb-3 d-flex">
				<div class="caixa">
					<i class="icos ico-venda"></i>
					<span class="d-block h4 text-azul text-center text-uppercase">Vendas</span>
					<p>Gerencie suas vendas, comissionamentos e envio de orçamentos</p>
				</div>
			</div>
			
			<div class="col-4 mb-3 d-flex">
				<div class="caixa">
					<i class="icos ico-cadastro"></i>
					<span class="d-block h4 text-azul text-center text-uppercase">Cadastro</span>
					<p>Cadastre usuários, clientes, fornecedores e vendedores e organize seu empreendimento</p>
				</div>
			</div>
			
			<div class="col-4 mb-3 d-flex">
				<div class="caixa">
					<i class="icos ico-estoque"></i>
					<span class="d-block h4 text-azul text-center text-uppercase">Estoque</span>
					<p>Cadastre, controle e organize as informações e os produtos do seu estoque</p>
				</div>
			</div>
			
			<div class="col-4 mb-3 d-flex">
				<div class="caixa">
					<i class="icos ico-nota"></i>
					<span class="d-block h4 text-azul text-center text-uppercase">Nota fiscal</span>
					<p>Emita notas fiscais com praticidade! Emita NF-e NFS-e NFCE</p>
				</div>
			</div>
			
			<div class="col-4 mb-3 d-flex">
				<div class="caixa">
					<i class="icos ico-financeiro"></i>
					<span class="d-block h4 text-azul text-center text-uppercase">Financeiro</span>
					<p>Controle e organize suas contas, facilitando a gestão financeira do seu negócio. Controle suas contas a pagar, contas a receber, faturamento dos pedidos, emissão de NF-e, fluxo de caixa.</p>
				</div>
			</div>
			
			<div class="col-4 mb-3 d-flex">
				<div class="caixa">
					<i class="icos ico-loja"></i>
					<span class="d-block h4 text-azul text-center text-uppercase">Loja virtual</span>
					<p>Controle e organize suas contas, facilitando a gestão financeira do seu negócio. Controle suas contas a pagar, contas a receber, faturamento dos pedidos, emissão de NF-e, fluxo de caixa.</p>
				</div>
			</div>
			
		</div>
	</div>
</div>


<div class="dobra_dois base-banner">
	<div class="conteudo">
		<div class="rows rows2 text-center mt-2">		
			<div class="col-12 text-center pb-3">
				<span class="d-block text-center h3 text-branco mt-1">Escolha um <span class="text-amarelo">plano ideal</span> para sua empresa</span>
			</div>
			<div class="rows text-center mt-2">
		@foreach($planos as $plano)
		
		
		@php 
		
		  $usuario = ($plano->limite_usuario==1) ? "01 Usuário" : $plano->limite_usuario . " Usuários" ; 
		  $nota    = ($plano->limite_nfe>0) ? $plano->limite_nfe ." Nota fiscais de produto" :  "Nota fiscal Não permitida" ;  
		
		@endphp
			<div class="col d-flex mb-3">
				<div class="caixa plano1">
					<strong class="h5 d-block mb-0 text-uppercase">{{$plano->nome}}</strong>
					<small Class="mb-3 d-block"><b>Qualquer curso </b>(individual)</small>
					<p class="h5"><span class="text-escuro">Por apenas</span> <strong class="d-block  h4">R$ {{$plano->valor}}</strong></p>
					<ul>
						<li><i class="fas fa-check"></i> {{$usuario}}            </li>
						<li><i class="fas fa-check"></i> {{ ($plano->limite_nfe == -1) ? " Nfe Ilimitado " : $nota }}  </li>
						<li><i class="fas fa-check"></i> Loja Virtual        </li>
						<li><i class="fas fa-check"></i> Sistema Completo        </li>
						<li><i class="fas fa-check"></i> Suporte Gratuito        </li>
						<li><i class="fas fa-check"></i> Atualizações Gratuitas	</li>
					</ul>
					<a href="{{route('cadastro', $plano->id)}}" class="btn btn-verde d-table m-auto scroll-page"><i class="fas fa-arrow-right"></i> Quero testar</a>
				</div>
			</div>
			
		@endforeach	
			
		</div>
		</div>
	</div>
</div>


@include('Site.rodape')


@endsection