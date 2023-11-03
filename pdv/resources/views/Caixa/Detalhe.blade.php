@extends("template")
@section("conteudo")

<div class="conteudo">
		<div class="rows">	
			<div class="col-12">
				<div class="caixa">
					<div class="caixa-titulo py-1  d-flex width-100 justify-content-space-between center-middle">
						<span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Detalhes do Caixa</span>
						<a href="{{route('caixa.caixasAberto')}}" class="btn btn-azul btn-pequeno"><i class="fas fa-arrow-left mb-0"></i> Voltar</a>
					</div>
					
				
					<div class="pt-2 px-2 pb-5 width-100 d-inline-block">
					<div class="rows">
						<div class="col-4">
						<div class="border">
							<strong class="d-block p-1 border-bottom mb-0 text-center text-uppercase">Resumo de caixa</strong>
							 <div class="rows p-0 cupom alt">
									<div class="col-12  d-flex justify-content-space-between">
										<div class="cxvalor width-100">
												<label class="text-label text-branco">Faturamento</label>
												<input type="text" readonly value="{{ moedaBr($detalhe->caixa->valor_vendido) }}" name="faturamento"  class="clear text-right form-campo width-30 neutro fw-700 h5 mb-0 text-branco">
										</div>
									</div>
									<div class="col-12 d-flex justify-content-space-between">
										<div class="cxvalor troco width-100">
											<label class="text-label text-branco">Troco no Caixa</label>
											<input type="text" readonly value="{{ moedaBr($detalhe->valores->troco) }}" name="troco"  class="clear text-right form-campo neutro  width-30 fw-700 h5 mb-0 text-azul">
										</div>                             
									</div>                             
									<div class="col-12 d-flex justify-content-space-between">
										<div class="cxvalor retirada width-100">
											<label class="text-label text-branco">Retirada </label>
											<input type="text" name="sangria" readonly value="{{ moedaBr($detalhe->valores->sangria)}}"  class="clear text-right form-campo neutro  width-30 fw-700 h5 mb-0 text-vermelho">
										</div>
									</div>
									<div class="col-12 d-flex justify-content-space-between">
										<div class="cxvalor total total_1 width-100">
											<label class="text-label text-branco">Suplemento</label>
											<input type="text" name="suplemento" readonly value="{{ moedaBr($detalhe->valores->suplemento) }}"  class="clear text-right form-campo neutro  width-30 fw-700 h5 mb-0 text-verde">
										</div>
									</div>
									<div class="col-12 d-flex justify-content-space-between">
										<div class="cxvalor total width-100">
											<label class="text-label text-branco">Total em Caixa</label>
											<input type="text" name="total_em_caixa" readonly value="{{ moedaBr($detalhe->caixa->total_em_caixa) }}"  class="clear text-right form-campo neutro  width-30 fw-700 h5 mb-0 text-verde">
										</div>
									</div>
																					
							</div>				
						</div>
					</div>
				
				
			
				<div class="col-8 d-flex">
					<div class="border mb-0 width-100 fechamento"  style="background: #f6f6f6;">
						<strong class="d-block p-1 border-bottom mb-0 text-center text-uppercase">Formas de pagamento	</strong>
					<div class="tabela-responsiva px-0 fechamento">
					
						<table cellpadding="0" cellspacing="0"  >
                            <thead>
                                <tr>
                                    <th align="left">Id</th>
                                    <th align="left" >Forma de Pagamento</th>
                                    <th align="left" >Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            foreach ($detalhe->formas as $f){ ?>                      
								<tr>
									<td align="left"><?php echo $f->id  ?></td>
									<td align="left"><?php echo $f->forma_pagto ?></td>
									<td align="left"><?php echo moedaBr($f->total) ?></td>	
																
								</tr>                    
							<?php } ?>	             
							</tbody>
						</table>
					</div>
				</div>
				</div>
				
				<div class="col-12  mt-4">
				<div class="border">
					<strong class="d-block p-1 h5 border-bottom mb-0">Lista de Vendas</strong>
                         <div class="col-12">
							<div class="tabela-responsiva px-0">
							
								<table cellpadding="0" cellspacing="0" id="dataTable">
									<thead>
										<tr>
											<th align="left">Id</th>
											<th align="left" >Data</th>
											 <th align="left" >Total Bruto</th>
											<th align="left">Desconto</th>
											<th align="left">Total Líquido</th>
											<th align="center">Detalhes</th>
										</tr>
									</thead>
									<tbody>
									<?php 
									foreach ($detalhe->vendas as $v){ ?>                      
										<tr>
											<td align="left"><?php echo $v->id  ?></td>
											<td align="left"><?php echo databr($v->data_venda) ?></td>
											<td align="left">{{ ($v->valor_venda) ? moedaBr($v->valor_venda) : 0 }}</td>	
											<td align="left"><?php echo moedaBr($v->valor_desconto) ?></td>
											<td align="left"><?php echo moedaBr($v->valor_liquido) ?></td>	
											<td align="center">
												<a href="{{route('venda.detalhes', $v->id)}}" class="d-inline-block btn btn-outline-verde btn-pequeno"><i class="fas fa-eye"></i> Detalhes</a>
											</td>							
										</tr>                    
									<?php } ?>	             
									</tbody>
								</table>
							</div>
						</div>				
				</div>
				</div>
			</div>
	
			</div>
		</div>
	</div>
	</div>

@endsection