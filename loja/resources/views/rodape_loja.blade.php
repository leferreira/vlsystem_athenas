<div class="rodape">
	<div class="sub">
		<div class="conteudo">
			<a href=""><img src="{{asset('assets/loja/img/logo-footer.png')}}" class="img-fluido"></a>
			<ul class="menu-topo">
				<li><a href="{{route('home')}}">Home</a></li>
			
			@if((session('usuario_loja_logado')->nome ?? null) == null)
			<li><a href="{{route('login')}}">Login</a></li>
			<li><a href="{{route('cliente.create')}}">Cadastrar</a></li>	
			@endif
			</ul>
		</div>
	</div>
	
	<div class="conteudo">
		<div class="rows">
			<div class="col-10">
				<strong>ATENDIMENTO</strong>
				<ul class="atendimento">
					<li><a href=""><i class="fas fa-envelope"></i> {{$configuracao->email ?? null }}</a></li>
					<li><a href=""><i class="fas fa-phone-alt"></i> {{$configuracao->telefone ?? null }}</a></li>
					<li><i class="fas fa-map-marker-alt"></i> Endereço: {{$configuracao->rua ?? null }} <br>Bairro: {{$configuracao->bairro ?? null }}</br>CEP: {{$configuracao->cep ?? null}}</br></li>
				</ul>
			</div>	
			<div class="col-2">
				<strong>Siga-nos</strong>
				<ul class="siga">
					<li><a href="{{$configuracao->link_facebook ?? null }}"><i class="fab fa-facebook"></i> Facebook</a></li>
					<li><a href="{{$configuracao->link_twiter ?? null }}"><i class="fab fa-youtube"></i>  Youtube</a></li>
					<li><a href="{{$configuracao->link_instagram ?? null }}"><i class="fab fa-instagram"></i>  Instagram</a></li>
					<li><a href="{{$configuracao->link_twiter ?? null }}"><i class="fab fa-twitter"></i>  Twitter</a></li>
				</ul>
			</div>	
		</div>	
	</div>	
</div>