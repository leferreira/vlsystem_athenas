@extends("template")
@section("conteudo")
<section class="pdv-livre">
<div class="conteudo">
	
		<div class="base-pdv">	
		<div class="rows">	
				<div class="col-12 d-flex m-auto">		
					<div class="caixa width-100 bg-title2 p-2 mb-1">			
						<div class="rows">
							<div class="col-12 text-center">
								<img src="{{asset('assets/pdv/img/logo.svg')}}" class="m-auto img-fluido d-block" width="250">
								<span class="h1 text-branco d-block p-2 mt-2 text-center border radius-4">CAIXA LIVRE</span> 		
								<a href="{{route('pdv.index')}}" class="d-block btn-amarelo btn btn-grande btnIni h4 mb-0"> <i class="fas fa-play icoIni"></i> Iniciar Venda</a><br>	
								<a href="{{route('resgate.index')}}" class="d-block btn-amarelo btn btn-grande btnIni h4 mb-0"> <i class="fas fa-play icoIni"></i> Resgatar Venda</a>														
							</div>
						</div>	
						<div class="barra">
							<div class="rows px-2 justify-content-space-between">
								<div class="col-3 text-left"><i class="far fa-clock float-left h2 mr-1 mb-0 text-branco"></i> <small>Horário:</small> <span>{{date('H:m')}}</span></div>
								<div class="col-3 text-left"><i class="far fa-calendar-alt float-left h2 mr-1 mb-0 text-branco"></i> <small>Data:</small> <span>{{date('d/m/Y')}}</span></div>
							</div>
						</div>		
					</div>	
				</div>						
		</div>
	</div>
</div>
</section>
@endsection