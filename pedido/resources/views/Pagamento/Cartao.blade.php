@extends("template2")
@section("conteudo")
<div class="central">
	<div class="conteudo">
		<div class="rows">
			<div class="col-12 m-auto text-center pt-4">
				<span class="d-block text-center h4 text-escuro mt-1">Pagamento <span class="text-azul">via Cartão</span> </span>
			</div>
		</div>
		
		<div class="card pag1">
		<input type="hidden"  id="cliente_id" value="<?php echo $cobranca->cliente_id ?? null ?>" > 
		<input type="hidden"  id="cobranca_id" value="<?php echo $cobranca->id ?? null ?>" >
		<input type="hidden"  id="empresa_id" value="<?php echo $cobranca->empresa_id ?? null ?>" >
		
		<div class="col-12 mb-3">
				<span class="titulo mb-0">Cobrança Num: {{$cobranca->id}} - Status: <strong>{{$cobranca->status_financeiro->status}}</strong></span>
			<div class="caixa alt bg-cinza">						
						<div class="dados-pedido">									
							<div class="rows justify-content-space-between">
									<div class="col-2 text-center">
										<i class="far fa-calendar"></i>
										<small>Descrição</small>
										<h3>{{$cobranca->descricao}}</h3>
									</div>
									<div class="col-2 text-center">
										<i class="far fa-calendar"></i>
										<small>Data Pedido</small>
										<h3>{{databr($cobranca->data_cadastro)}}</h3>
									</div>
									<div class="col-2 text-center">
										<i class="far fa-calendar"></i>
										<small>Data Pagamento</small>
										<h3>{{($cobranca->data_pagamento) ? databr($cobranca->data_pagamento) : '00/00/0000'}}</h3>
									</div>
									<div class="col-2 text-center">
										<i class="far fa-clock"></i>
										<small>Data Vencimento</small>
										<h3>{{ databr($cobranca->data_vencimento) }}</h3>
									</div>
									<div class="col-2 text-center">
										<i class="fas fa-dollar-sign"></i>
										<small>valor</small>
										<h3 id="total">R$ {{$cobranca->valor}}</h3>
									</div>
											
							</div>		
						</div>
			</div>			
			</div>
			
		<form id="form-checkout" >
		<div class="p-3 px-md">
		
    		<div class="rows">
        		<div class="col-4 mb-3">
        				<strong class="text-label">Número do cartão:</strong>
        			   <input type="text" name="cardNumber" id="form-checkout__cardNumber" class="form-campo"/>
        		</div>
        		<div class="col-2 mb-3">
        				<strong class="text-label">Validade(MM/YYYY)</strong>
    			   <input type="text" name="cardExpirationDate" id="form-checkout__cardExpirationDate"  class="form-campo"/>
    		  </div>
    		  <div class="col-6 mb-3">
        				<strong class="text-label">Titular do cartão:</strong>
    			   <input type="text" name="cardholderName" id="form-checkout__cardholderName"class="form-campo"/>
    		  </div>
    		  <div class="col-6 mb-3">
        				<strong class="text-label">Email</strong>
    			   <input type="email" name="cardholderEmail" id="form-checkout__cardholderEmail"  class="form-campo"/>
    		 </div>
    		 <div class="col-3 mb-3">
        				<strong class="text-label">Cód Segurança</strong>
    			   <input type="text" name="securityCode" id="form-checkout__securityCode"  class="form-campo"/>
    	     </div>
    	   		<select name="issuer" id="form-checkout__issuer" class="form-campo" style="display:none"></select>
    		
    		<div class="col-3 mb-3">
        				<strong class="text-label">Tipo Documento</strong>
    			   <select name="identificationType" id="form-checkout__identificationType" class="form-campo"></select>
    	    </div>
    	    <div class="col-6 mb-3">
        				<strong class="text-label">Número do Documento:</strong>
    			   <input type="text" name="identificationNumber" id="form-checkout__identificationNumber" class="form-campo" />
    	    </div>
    	    <div class="col-6 mb-3">
        			<strong class="text-label">Parcelas</strong>
    			   <select name="installments" id="form-checkout__installments" class="form-campo"></select>
    		</div>
    	    <div class="col-12">
				<progress value="0" class="progress-bar" style="width:100%">Carregando...</progress>
    		</div>
    			   
    		</div>
		</div>
		<div class="tfooter end">
    			<button type="submit" id="form-checkout__submit" class="btn btn-verde"><span id="btnSalvar"> Pagar</span></button>
				<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho fechar">Fechar</a>
    		</div>
		
		</form>
	</div>
	
	</div>

  
</div>




@endsection

