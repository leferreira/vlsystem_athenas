<header class="bg-topo">
			<div class="conteudo-fluido">
			<div class="navbar">
				<!--<input type="checkbox" id="chx">
				<label for="chx" class="mobmenu"><i class="fas fa-bars"></i></label>-->
				<a href="{{route('home')}}" class="logo" alt="ERP completa"><img src="{{asset('assets/pdv/img/logo.svg')}}" class="img-fluido"></a>	
			
			@if(session()->has('usuario_pdv_logado'))		
				<ul class="menutopo">
					@if(session("usuario_pdv_logado")->num_caixa)
						<li><a href="#" class="btn btn-verde btn-pequeno"> {{ zeroEsquerda(session("usuario_pdv_logado")->num_caixa,3) }} - {{ session("usuario_pdv_logado")->descricao_caixa}}</a></li>
					@else
						<li><a href="#" class="btn btn-vermelho btn-pequeno"> Nenhum Caixa Aberto</a></li>
					@endif
									
					<li><a href="{{route('resgate.index')}}" class="btn btn-amarelo btn-pequeno"><i class="fas fa-cash-register"></i> Resgatar</a></li>
					<li><a href="{{route('pdv.index')}}" class="btn btn-amarelo btn-pequeno"><i class="fas fa-cash-register"></i> Iniciar Venda</a></li>
					
					<li class="sub">
					<span>{{session("usuario_pdv_logado")->nome}}</span>				
						<ul>
							<li><a href="{{route('login.out')}}"><i class="fas fa-sign-in-alt"></i> Sair</a></li>
						</ul>
					</li>	
				</ul>
			@endif

<!-- MENU CAIXA -->
<nav class="menuprincipal" id="principal">
	<ul class="menu-ul">
		<span class="h5 p-1 py-2 text-branco mb-0 d-block text-uppercase"><i class="icon fas fa-cubes"></i> Caixa</span>
		<li><a href="{{route('home')}}"><i class="icon fas fa-angle-right"></i> Número Caixa</a></li>
		<li><a href="{{route('caixa.create')}}"><i class="icon fas fa-angle-right"></i> Caixas</a></li>
		<li><a href="{{route('sangria.index')}}"><i class="icon fas fa-angle-right"></i> Sangria</a></li>
		<li><a href="{{route('suplemento.index')}}"><i class="icon fas fa-angle-right"></i> Suplemento</a></li>
		<li><a href="{{route('caixa.create')}}"><i class="icon fas fa-angle-right"></i> Abertura Caixa</a></li>
		<li><a href="{{route('caixa.caixasAberto')}}"><i class="icon fas fa-angle-right"></i> Fechamento</a></li>
	</ul>
</nav>


</div>
			</div>
</header>