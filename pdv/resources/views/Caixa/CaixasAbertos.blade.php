@extends("template")
@section("conteudo")

<div class="conteudo">
			<div class="caixa">
			<div class="caixa-titulo py-1 d-flex justify-content-space-between">
                <span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Detalhes do Caixa</span>				
             </div>
			 
	<div class="rows">	
		<div class="col-12">
            <div class="col-12 mt-3 mb-3">    				
				<div class="radius-4 p-2 mostraFiltro bg-padrao">    				
					<form action="" method="">
						<div class="rows px-2 pb-3">  	
							<div class="col-9">
								<label class="text-label text-branco">Empresa</label>	
								 <input type="text" value="" name="razao_social" placeholder="Digite aqui..." class="form-campo">
							</div>
							<div class="col-3 mt-4">	
								<input type="submit" value="Pesquisar" class="btn btn-verde width-100 text-uppercase">
							</div>
						</div> 
					</form>
				</div>               
			</div>     
			
			<div class="col-12 m-auto pb-3 caixaAberto alt">
				<div class="border radius-4">
					<div class="rows">					
						<div class="col-12">					
							<div class="cx border-bottom pt-3 p-3">
								<div class="d-flex btnFlex pl-2 limpo">
																
									<div class="caixa co2 btn-verde text-branco btn" style="justify-content:end">
										<small>Data da abertura</small>
										<h4 class="text-right h5 mb-0">{{  databr($caixa->data_abertura) }}</h4>
									</div>	
									<div class="caixa co2 btn-verde text-branco btn" style="justify-content:end">
										<small>Valor da abertura</small>
										<h4 class="text-right h5 mb-0">R$ {{  $caixa->valor_abertura }}</h4>
									</div>
								
									<div class="caixa co2 btn-verde text-branco btn" style="justify-content:end">
										<small>Data da fechamento</small>
										<h4 class="text-right h5 mb-0">{{  ($caixa->data_fechamento) ? databr($caixa->data_fechamento) : '00/00/0000' }}</h4>
									</div>
									<div class="caixa co2 btn-verde text-branco btn" style="justify-content:end">
										<small>Valor da vendido</small>
										<h4 class="text-right h5 mb-0">R$ {{  ($caixa->valor_vendido) ? moedaBr($caixa->valor_vendido): null }}</h4>
									</div>
								
									<div class="caixa co5 btn-verde text-branco btn" style="justify-content:center">
										<small> status</small>
										<h4 class="text-right h5 mb-0">{{  $caixa->status->status }}</h4>
									</div>	
									
								</div>
																
								
								<div class="p-2">	
									<span class="d-block text-left h5 mb-0 pt-1">Opções</span>										
									<div class="d-flex btnFlex alt">	
										<a href="{{route('caixa.venda', $caixa->id)}}" class="caixa btn text-center d-flex" title="Ver vendas"> <img src="https://athenas-pdv.flexnfe.com.br/assets/pdv/img/ico-vendas.svg" height="40"> Vendas</a>
																			
										<a href="{{route('caixa.detalhes', $caixa->id)}}" class="caixa btn text-center d-flex" title="Ver detalhes"><img src="https://athenas-pdv.flexnfe.com.br/assets/pdv/img/ico-caixa.svg" height="40"> Ver detalhes</a>
										<a href="{{route('caixa.sangria', $caixa->id)}}" class="caixa btn text-center d-flex" title="Ver sangria"><img src="https://athenas-pdv.flexnfe.com.br/assets/pdv/img/ico-sangria2.svg" height="40"> Sangria</a>
										<a href="{{route('caixa.suplemento', $caixa->id)}}" class="caixa btn text-center d-flex" title="Ver suplemento"><img src="https://athenas-pdv.flexnfe.com.br/assets/pdv/img/ico-suplemento.svg" height="40"> Suplementos</a>
										<a href="{{route('caixa.fechamento', $caixa->id)}}" class="caixa btn text-center d-flex" title="Fechar caixa"><img src="https://athenas-pdv.flexnfe.com.br/assets/pdv/img/ico-fechar-caixa2.svg" height="40"> Fechar caixa</a>
									</div>	
								</div>
								
								<div class="p-2">	
									<span class="d-block text-left h5 mb-0 pt-1">Atalho</span>										
									<div class="d-flex btnFlex btnFlex2 alt">					
										<a href="{{route('home')}}" class="btn btn-verde px-4"><i class="fas fa-arrow-left"></i> Voltar</a>
									</div>	
								</div>
							
							</div>				
						</div>	
						
						<div class="col-12 iniciarCaixa">
							
						</div>
					</div>
				</div>
			</div>
				
		
		
    </div>
   </div>
   </div>
   </div>

