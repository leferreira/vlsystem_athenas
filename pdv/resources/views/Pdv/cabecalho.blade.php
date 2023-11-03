<header class="bg-topo">
	<div class="conteudo">		
		<a href="{{route('home')}}" class="logo" alt="ERP completa"><img src="{{asset('assets/pdv/img/logo.svg')}}" class="img-fluido"></a>	
		<div class="op_topo">
			<span><small>Num. cupom</small> <b>{{zeroEsquerda($venda->id ?? 0,5)}}</b></span>
			<span><small>Operador</small>  <b>{{session("usuario_pdv_logado")->nome}}</b></span>
			<span><small>Caixa</small>  <b>{{ zeroEsquerda(session("usuario_pdv_logado")->num_caixa,3) }} - {{ session("usuario_pdv_logado")->descricao_caixa}}</b></span>
			<span><small>Data e hora</small> <b>{{ databr(hoje())}} - {{agora()}}</b></span>
		</div>
		
	</div>
</header>