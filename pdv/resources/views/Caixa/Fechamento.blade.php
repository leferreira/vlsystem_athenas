
@extends("template")
@section("conteudo")
<div class="conteudo">
<div class="caixa">
		<div class="rows">	
			<div class="col-12">
					<div class="caixa-titulo py-1 d-flex width-100 justify-content-space-between center-middle">
						<span class="h4 text-amarelo text-left pt-1 mb-0 d-block"><i class="far fa-list-alt"></i> Fechamento do Caixa</span>
						<a href="{{route('caixa.caixasAberto')}}" class="btn btn-pequeno btn-azul"><i class="fas fa-arrow-left"></i> Voltar</a>
					</div>
					<input type="hidden" id="caixa_id" value="{{$detalhe->caixa->id ?? null}}">
				<form action="" method="POST">	
				
				@csrf	
					<div class="pt-2 px-2 pb-5 width-100 d-inline-block">
					<div class="rows">
						<div class="col-4 mb-2 d-flex">
							<div class="border mb-0 radius-4">

							<strong class="d-block p-1 border-bottom mb-0 text-center text-uppercase">Resumo de caixa</strong>
								 <div class="rows p-0 cupom">
										<div class="col-12 mb-0 d-flex justify-content-space-between">
											<div class="cxvalor width-100">
													<label class="text-label text-end text-branco">Faturamento</label>
													<input type="text" readonly value="{{ moedaBr($detalhe->caixa->valor_vendido ?? 0)}}" name="faturamento"  class="form-campo width-30 clear text-branco text-right h5 mb-0">
											</div>
										</div>
										<div class="col-12 mb-0 d-flex justify-content-space-between">
											<div class="cxvalor troco width-100">
												<label class="text-label text-branco">Troco no Caixa</label>
												<input type="text" readonly value="{{ moedaBr($detalhe->valores->troco ?? 0) }}" name="troco"  class="form-campo width-30 clear text-azul text-right h5 mb-0">
											</div>                             
										</div>                             
										<div class="col-12 mb-0 d-flex justify-content-space-between">
											<div class="cxvalor width-100">
												<label class="text-label text-branco">Sangria</label>
												<input type="text" name="sangria" readonly value="{{ moedaBr($detalhe->valores->sangria ?? 0) }}"  class="form-campo width-30 clear  text-branco text-right h5 mb-0">
											</div>
										</div>
										<div class="col-12 mb-0 d-flex justify-content-space-between">
											<div class="cxvalor supl width-100">
												<label class="text-label text-branco">Suplemento</label>
												<input type="text" name="suplemento" readonly value="{{ moedaBr($detalhe->valores->suplemento ?? 0) }}"  class="form-campo width-30 clear  text-branco text-right h5 mb-0">
											</div>
										</div>
										<div class="col-12 mb-0 d-flex justify-content-space-between">
											<div class="cxvalor total total_1 width-100">
												<label class="text-label text-branco">Total na Gaveta</label>
												<input type="text" name="dinheiro_gaveta" readonly value="{{ moedaBr($detalhe->caixa->dinheiro_gaveta ?? 0) }}"  class="form-campo width-30 clear text-verde text-right h5 mb-0">
											</div>
										</div>
										
										<div class="col-12 mb-0 d-flex justify-content-space-between">
											<div class="cxvalor total width-100">
												<label class="text-label text-branco">Total Geral</label>
												<input type="text" name="total_em_caixa" readonly value="{{ moedaBr($detalhe->caixa->total_em_caixa ?? 0) }}"  class="form-campo width-30 clear text-verde text-right h5 mb-0">
											</div>

										</div>
																						
								</div>
						
							</div>
						</div>
				
			
				<div class="col-8 mb-2  d-flex">
					<div class="border mb-0 width-100 fechamento"  style="background: #f6f6f6;">
						<strong class="d-block p-1 border-bottom mb-0 text-center text-uppercase">Formas de pagamento	</strong>							
						<div class="tabela-responsiva p-0 cx">
					
							<table cellpadding="0" cellspacing="0" class="mb-0">
								<thead>
									<tr>
										<th align="center" 	style="background:#fff" width="60">Id</th>
										<th align="left"  	style="background:#fff" width="180">Forma de Pagamento</th>
										<th align="center"  style="background:#fff" width="100">Total</th>
									</tr>
								</thead>
								<tbody>
							@isset($detalhe->formas)
								<?php 
								    foreach ($detalhe->formas as $f){ 
								        if($f->total > 0){
								 ?>                      
									<tr>
										<td align="center"><?php echo $f->id  ?></td>
										<td align="left"><?php echo $f->forma_pagto ?></td>
										<td align="center"><?php echo moedaBr($f->total) ?></td>
									</tr>                    
								<?php } } ?>	       
							@endisset      
								</tbody>
							</table>
						</div>
						 <div class="border-top mt-0" style="background: #f6f6f6;">			
							 <div class="rows px-2 text-end" style="justify-content:end">									
									<div class="col-4 mt-3  pb-3">   									  
										<a href="javascript:;" onclick="abrirModal('#verTelaSangria')" class="btn btn-azul d-block width-100"><i class="fas fa-check"></i> Fazer sangria</a>                                
									</div>
									<div class="col-4 mt-3  pb-3"> 
										<a href="{{route('caixa.fechar', $detalhe->caixa->id)}}" class="btn btn-verde d-block width-100"><i class="fas fa-check"></i> Fechar Caixa</a>                                
									</div>
								<!--  	<div class="col-3 mt-4  pb-3">   
										<a href="{{route('caixa.contagem', $detalhe->caixa->id)}}" class="btn btn-verde d-block width-100">Conferência de Caixa</a>                                
									</div>
								-->													
							</div>
							
						</div>
						
					</div>
				</div>
				
				<div class="col-12">
				<div class="border radius-4 fechamento">
					<strong class="d-block p-1 h5 border-bottom mb-0">Lista de Vendas</strong>
                     <div class="tabela-responsiva px-1">
						<table cellpadding="0" cellspacing="0" class="table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th align="center">Id</th>
                                    <th align="center">Data</th>
                                     <th align="center">Total</th>
                                    <th align="center">Desconto</th>
                                    <th align="center">Total Líquido</th>
                                    <th align="center">Detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($detalhe->vendas as $v){ ?>
                            	<tr>
                                    <td align="center"><?php echo $v->id?></td>
                                    <td align="center"><?php echo databr($v->data_venda) ?></td>
                                    <td align="center">{{ ($v->valor_venda) ? moedaBr($v->valor_venda) : 0 }}</td>
                                    <td align="center"><?php echo moedaBr($v->valor_desconto) ?></td>
                                    <td align="center"><?php echo moedaBr($v->valor_liquido) ?></td>
                                    <td align="center"><a href="{{route('venda.detalhes', $v->id)}}" class="d-inline-block btn btn-azul btn-pequeno">Detalhes</a></td>
                                
                                </tr>  
                               <?php }?>  
								
							</tbody>
						</table>
					</div>
				
				</div>
				</div>
				
				
				
                                
				</div>
              
			</div>
		 </form>
			</div>
		</div>
	</div>
	</div>

<div class="window pdv" id="verTelaSangria">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Sangria</h4>
	<div class="rows">
		<div class="col-3">
			<label class="text-label">Valor</label>			
			<input type="text" required id="valor_sangria"  class="form-campo mascara-float">
		</div>
		<div class="col-9">
			<label class="text-label">Descrição</label>			
			<input type="text" required id="desc_sangria"  class="form-campo">
		</div>
		<div class="text-right base-botoes radius-0 mt-0 p-1">	
				<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho d-inline-block">Fechar</a>					
				<a href="javascript:;" onclick="confirmarSangria()" class="btn btn-verde d-inline-block">Confirmar</a>
		</div>
	</div>
</div>

<script>
function confirmarSangria(){
	var caixa_id 	  = $("#caixa_id").val();	
	var valor_sangria = $("#valor_sangria").val();
	var desc_sangria  = $("#desc_sangria").val();
	
	if(valor_sangria.length<=0){
		alert("Por favor, insira um valor antes");	
		return false;
	}
	
	if(desc_sangria.length<=0){
		alert("Por favor, insira uma descrição antes");	
		return false;
	}
	$.ajax({
		url: base_url + "sangria/salvarJs" ,
		type: "POST",
		data: {
			caixa_id :caixa_id,
			valor: valor_sangria,
			descricao: desc_sangria
		},
		dataType:"json",
		beforeSend: function (){
		   giraGira();
	   },
		success: function(data){			
			fecharModal();
			if(data.tem_erro == true){
				alert(data.erro);
			}else{
				location.reload();
			}
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
}

</script>
@endsection