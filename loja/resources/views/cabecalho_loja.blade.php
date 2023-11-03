<div class="base-topo"> 
	<div class="conteudo d-flex justify-content-space-between"> 
		<ul class="menu-topo end">
			<li><a href=""><i class="ico email"></i> {{$configuracao->email ?? null}}</a></li>
			<li><a href=""><i class="ico telefone"></i> {{$configuracao->telefone ?? null}}</a></li>
		</ul>
		
		<ul class="menu-topo">
			<li><a href="{{route('home')}}">Home</a></li>
			
			@if((session('usuario_loja_logado')->nome ?? null) == null)
			<li><a href="{{route('login')}}">Login</a></li>
			<li><a href="{{route('cliente.create')}}">Cadastrar</a></li>		
			<li class="sub">
				<a href=""><i class="fas fa-user-circle"></i> Olá, Visitante</a>
			</li>
			@endif
			
			@if((session('usuario_loja_logado')->nome ?? null) != null)
			<li><a href="{{route('cliente')}}">Meus Dados</a></li>
			<li><a href="{{route('logoff')}}">Logout </a></li>	
						
			<li class="sub alt"><!--QUANDO TIVER LOGADO-->
				<a href=""><i class="fas fa-user-circle" style="color: #38f7b1"></i> Olá, {{session('usuario_loja_logado')->nome ?? null}}</a>				
			</li>
			@endif
			
			
		</ul>
	</div>
	<div class="topo">
		<div class="conteudo"> 
		<a href="" class="fas fa-bars mobmenu"></a>		
			@php $logo = $configuracao->logo ?? null @endphp		
			<a href="{{route('home')}}" class="logo"><img src="{{ getenv('APP_IMAGEM_PRODUTO') . $logo}}"></a>
			<div class="rows campo-busca">
				<div class="col-10 position-relative">
					<form action="{{route('produto.pesquisar')}}" method="get">
						<input type="text" name="q" value="{{$q ?? null}}" class="buscar">
						<input type="submit" value=""  class="btn-busca">
					</form>
				</div>
				@if(isset($mostraCarrinhoTopo))
				@if(count($itens)>0)
				<div class="col-2">
					<ul class="menu-carrinho">
						<li class="sub"><a href=""><i class="ico icarrinho"></i><span class="iten">{{count($itens)}}</span></a>
							<ul>
								@foreach($itens as $topo_carrinho)
								@php $img_top = getenv("APP_IMAGEM_PRODUTO") .$topo_carrinho->produto->imagem; @endphp
							
								<li class="width-100">
									<div class="rows itens-carrinho">
										<div class="col-4">
											<div class="thumb"><img src="{{asset($img_top)}}" class="img-fluido"></div>
										</div>
										<div class="col-8 text-left">
											<small>{{$topo_carrinho->produto->nome}}</small>
											<div class="d-flex justify-content-space-between pt-0">
												<strong class="text-verde">R$ {{number_format($topo_carrinho->valor, 2)}}</strong>												
											</div>
											<a href="javascript:;" onclick="removeItem(5)" class="ico-excluir" title="Excluir produto"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
										</div>
									</div>
								</li>
								@endforeach
								
							<!--
								<li class="width-80 p-2 border-top">
																	
								</li>
							-->
								<li class="width-20 py-2 border-top d-flex justify-content-space-between px-2">
									<a href="{{route('carrinho')}}" class="btn btn-verde d-block text-branco btn-pequeno d-inline-block">Ir para carrinho</a>
									
									<a href="{{route('carrinho.fecharSessao')}}" class="btn text-branco btn-vermelho btn-pequeno d-inline-block">Fechar sessão</a>																		
										
								</li>
							</ul>
						</li>
					</ul>
				</div>
				@endif
				@endif	
			</div>
		</div>
	</div>
</div>