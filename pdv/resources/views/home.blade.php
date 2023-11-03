@extends("template")
@section("conteudo")
<section class="pdv-livre">
<div class="conteudo">
	
		<div class="base-pdv">	
		<div class="rows">	
				<div class="col-12 d-flex m-auto">		
					<div class="caixa width-100 bg-title2 p-2 mb-1 iciniarCaixa" style="height:auto">			
						<div class="rows">
							<!--<div class="col-12 text-center mb-2">
								<a href="{{route('pdv.index')}}" class="caixa alt">
									<span class="tt"><i class="fas fa-arrow-right"></i> Ir para PDV</span>
								</a>															
							</div>-->
							
							<div class="col-6 text-center mb-2">
								<a href="{{route('caixa.caixasAberto')}}"  class="caixa">
									<i class="icones Icaixa"></i>
									<span class="tt">Ver Caixa</span> 
								</a>	
							</div>
							<div class="col-6 text-center  mb-2">
								<a href="{{route('caixa.create')}}"  class="caixa">
									<i class="icones Iabrircaixa"></i>
									<span class="tt">Abrir Caixa</span> 
								</a>		
							</div>
							<div class="col-6 text-center mb-2">
								<a href="{{route('caixa.ver')}}" class="caixa">
									<i class="icones Ifecharcaixa"></i>
									<span class="tt">Fechar Caixa</span> 
								</a>		
							</div>
							<div class="col-6 text-center mb-2">
								<a href="{{route('venda.ver')}}" class="caixa">
									<i class="icones Ivenda"></i>
										<span class="tt">Vendas</span> 
								</a>	
							</div>
							
							<div class="col-6 text-center mb-2">
								<a href="{{route('sangria.ver')}}" class="caixa">
									<i class="icones Isangria"></i>
									<span class="tt">Sangrias</span>
								</a>			
							</div>
							<div class="col-6 text-center mb-2">							
								<a href="{{route('suplemento.ver')}}" class="caixa">
									<i class="icones Isuplemento"></i>
									<span class="tt">Suplementos</span>
								</a>									
							</div>
							
						</div>	
								
					</div>	
				</div>						
		</div>
	</div>
</div>
</section>
@endsection