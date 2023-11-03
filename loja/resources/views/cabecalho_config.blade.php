<div class="base-topo"> 
	<div class="conteudo d-flex justify-content-space-between"> 
		<ul class="menu-topo end">
			<li><a href=""><i class="ico email"></i> {{session("loja_configuracao")->email ?? null}}</a></li>
			<li><a href=""><i class="ico telefone"></i> {{session("loja_configuracao")->telefone ?? null}}</a></li>
		</ul>
		
		<ul class="menu-topo">
			<li><a href="{{route('home')}}">Home</a></li>			
			
		</ul>
	</div>
	<div class="topo">
		<div class="conteudo"> 
		<a href="" class="fas fa-bars mobmenu"></a>		
					
			<a href="{{route('home')}}" class="logo"><img src="{{asset('storage/logo/logo.png')}}"></a>
			
		</div>
	</div>
</div>