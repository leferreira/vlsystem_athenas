
@if(session()->has('dias_restante'))
<span class="text-center msg msg-amarelo position-fixed right top tempo">
	<span>
		<small>Seu plano de demonstração acaba em <b>{{ session('dias_restante')}} dias</b>  <a href="{{route('admin.assinatura.assinar')}}" class="btn btn-outline-azul btn-pequeno d-inline-block"> Quero Assinar</a></small>
	</span>	
 </span> 
@endif

<div class="topo d-flex justify-content-space-between center-middle">
	<a href="" class="mobmenu alt"><i class="fas fa-bars"></i></a>
	<a href="" class="icouser fas fa-user-circle"></a>
	@php 
		$imgPerfil = (Auth::user()->foto) ?? "";
	@endphp
	<a href="{{route('admin.index')}}" class="logo"><img src="{{asset('assets/admin/img/logo.png')}}" class="d-inline-block img-fluido"></a>
	
	<ul class="menu-topo">
		<li><a href="{{route('admin.chamado.index')}}" class="btn btn-outline-branco"><i class="fas fa-lock-open"></i> Chamados</a></li>
		
		<li class="sub">
		@if($imgPerfil)
			<img src="{{ url($imgPerfil) }}" class="img-user">
		@else
			<img src="{{asset('assets/admin/img/img-usuario.svg')}}" class="img-user">
		@endif
			<span class="text-branco">{{Auth::user()->name}}</span>
			<ul>
			
				<li><a href="{{route('admin.usuario.index')}}" class=""><i class="fas fa-lock"></i> Usuário</a></li>
		
				<li><a href="{{route('admin.funcao.index')}}" class=""><i class="fas fa-lock"></i> Funções</a></li>
		
			<li>
			<a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-lock"></i>LogOff
            </a>
            <li>                        
			<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"><i class="fas fa-lock"></i> 
                @csrf
            </form>
			
		</li>
	</ul>
</div>