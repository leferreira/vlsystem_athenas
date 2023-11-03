<header class="cabecalho">
			<div class="conteudo">
				<a href="" class="mobmenu"><i class="fas fa-bars"></i></a>
				<a href="index.html" class="logo"><img src="{{asset('assets/gestor/img/logo.svg')}}"></a>
				<nav class="menu-topo-text">
					<ul>
						<li><a href="{{route('home')}}"><i class="ico home"></i>Home</a></li>
						<li><a href="{{route('empresa.index')}}"><i class="ico cad"></i>Empresas</a></li>
						<li><a href="{{route('plano.index')}}"><i class="ico lista"></i>Planos</a></li> 
						
						<li><a href="{{route('modulo.index')}}"><i class="ico lista"></i>Módulo</a></li>
						<li><a href="{{route('pagar.index')}}"><i class="ico lista"></i>Contas a Pagar</a></li>
						<li><a href="{{route('receber.index')}}"><i class="ico lista"></i>Contas a Receber</a></li>
						<li><a href="{{route('fornecedor.index')}}"><i class="ico lista"></i>Fornecedor</a></li>
						<li class="sub"><a href=""><i class="ico lista"></i>ACL</a> 
							<ul>
								<li><a href="{{route('perfil.index')}}"><i class="ico lista"></i>Perfil</a></li>
								<li><a href="{{route('permissao.index')}}"><i class="ico lista"></i>Permissão</a></li>
								<li><a href="{{route('usuario.index')}}"><i class="ico lista"></i>Usuário</a></li>
							</ul>
						</li>
						<li class="sub alt ml-3">
							<div class="thumb">
								<img src="{{asset('assets/gestor/img/img-usuario.png')}}" class="img-fluido">
							</div>
							<ul>
								
								
								<li>							
									<a href="{{route('home')}}">{{session("usuario_logado")->nome}}</a>
								</li>
								<li>							
									<a href="{{route('login.out')}}"><i class="ico sair"></i>LogOff</a>
								</li>
							</ul>
						</li>
					</ul>
				</nav>				
			</div>
		</header>