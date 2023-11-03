
	<div class="base-topo">
		<a href="" class="mobile"></a>
		<div class="barra-topo">		
			<div class="conteudo">
				<div class="rows">
					<ul class="col-12">
							<li><a href="{{route('delivery.home')}}">Home</a></li>
							<li><a href="{{route('delivery.cadastro')}}">cadastro</a></li>
							<li><a href="{{route('delivery.login')}}">login</a></li>
							<li class="usuario"><a href=""><i class="icouser"></i>
							{{(session('cliente_delivery_log')['nome']) ?? "não logado" }}</a>
								<ul>
									<li><a href="">área do cliente</a></li>
									<li><a href="{{route('delivery.logoff')}}">Sair</a></li>
								</ul>
							</li>
					</ul>
				</div>
			</div>
		</div>

	<div class="conteudo">
		<div class="rows">
			<div class="col-3">
				<a href="index.php?link=1" class="logo"></a>
			</div>
			<div class="col-9">
				<div class="rows text-end">
					<div class="carrinho-topo col-6">
						<ul>
							<li class="carr"><span class="tt">MEU CARRINHO</span>
								<div class="qtd"><b>1</b></div>
							</li>
							<div id="vercarrinho">
								<div class="cx-carrinho">
									<ol>
										<div class="thumb"><img src="{{asset('assets/loja/upload/PANELA_LARANJA.jpg')}}"></div>
										<p>Panela laranja</p>
										<span class="preco">R$ 150,00</span>
									</ol>
									<a href="index2.php?link=2" class="btn">Ir para o carrinho</a>
									
								</div>
							</div>
							
							<!--carrinho vazio
							<div id="vercarrinho">
								<div class="cx-carrinho">
									 <ol class="vazio">
										<div class="thumb"><img src="img/icon-vazio.png"></div>
											 <p> Sem produto no carrinho </p>
									 </ol>
									<a href="carrinho.html" class="btn">Ir para o carrinho</a>
									
								</div>
							</div>
							-->
						</ul>
					</div>
				</div>
			</div>
		</div>
</div>
</div>
<!--
<div id="menumobile">
	<div class="menu-topo">
		<ul>
			<li><a href="index.php?link=2">Panela</a></li>
			<li><a href="index.php?link=2">Frigideira</a></li>
			<li><a href="index.php?link=2">Leiteira</a></li>
			<li><a href="index.php?link=2">Cuzcuseira</a></li>
			<li><a href="index.php?link=20">Copo</a></li>
			<li><a href="index.php?link=2">Bacia</a></li>
			<li><a href="index.php?link=2">Balde</a></li>
			
		</ul>
		<ul class="area-usuario">
			<span class="titulo">área do cliente</span>
			<li><a href="index.php?link=9">cliente</a></li>
			<li><a href="logoff">Sair</a></li>
		</ul>
	</div>	
</div>-->	