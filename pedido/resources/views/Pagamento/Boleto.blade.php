@extends("template2")
@section("conteudo")
<div class="central">
	<div class="conteudo">
		<div class="rows">
			<div class="col-12 m-auto text-center pt-4">
				<span class="d-block text-center h4 text-escuro mt-1">Pagamento <span class="text-azul">via Boleto</span> </span>
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
			
	
		<div class="p-3 px-md">
		
    		<div class="rows">
				<div class="col-3 mb-3">
					<strong class="text-label">Nome:</strong>
					<input type="text" name="payerFirstName" id="nome" value="<?php echo primeiroNome($cobranca->cliente->nome) ?? null ?>" class="form-campo"> 
				</div>
				<div class="col-4 mb-3">
					<strong class="text-label">Sobrenome:</strong>
					<input type="text" name="payerLastName" id="sobrenome" value="<?php echo ultimoNome($cobranca->cliente->nome) ?? null ?>" class="form-campo"> 
				</div>
				
				<div class="col-2 mb-3">
					<strong class="text-label">CPF</strong>
					<input type="text" name="docNumber" id="cpf" value="<?php echo $cobranca->cliente->cpf_cnpj ?? null ?>" class="form-campo"> 
				</div>
				<div class="col-3 mb-3">
					<strong class="text-label">Email:</strong>
					<input type="text" name="payerEmail" id="email" value="<?php echo $cobranca->cliente->email ?? null ?>" class="form-campo"> 
				</div>
					
					
        		<div class="col-2 mb-3">
        				<strong class="text-label">Cep:</strong>
        			   <input type="text" name="cardNumber" id="cep" value="<?php echo $cobranca->cliente->cep ?? null ?>" class="form-campo"/>
        		</div>
        		<div class="col-4 mb-3">
        				<strong class="text-label">Logradouro</strong>
    			   <input type="text" name="cardExpirationDate" id="logradouro" value="<?php echo $cobranca->cliente->logradouro ?? null ?>" class="form-campo"/>
    		  </div>
    		  <div class="col-2 mb-3">
        				<strong class="text-label">Número</strong>
    			   <input type="text" name="cardholderName" id="numero" value="<?php echo $cobranca->cliente->numero ?? null ?>" class="form-campo"/>
    		  </div>
    		  <div class="col-4 mb-3">
        				<strong class="text-label">Complemento</strong>
    			   <input type="email" name="cardholderEmail" id="complemento" value="<?php echo $cobranca->cliente->complemento ?? null ?>" class="form-campo"/>
    		 </div>
    		 <div class="col-4 mb-3">
        				<strong class="text-label">Cidade</strong>
    			   <input type="text" name="securityCode" id="cidade" value="<?php echo $cobranca->cliente->cidade ?? null ?>" class="form-campo"/>
    	     </div>
    	   	
    	    <div class="col-2 mb-3">
        				<strong class="text-label">UF</strong>
    			   <input type="text" name="identificationNumber" id="uf" value="<?php echo $cobranca->cliente->uf ?? null ?>" class="form-campo" />
    	    </div>
    	      	    
    			   
    		</div>
		</div>
		<div class="tfooter end">
			<a href="javascript:;" onclick="pagarComBoleto()" class="btn btn-verde" id="btnPagarBoleto">Pagar</a>
			<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho fechar">Fechar</a>
		</div>
		
	</div>
	
	</div>

  
</div>




@endsection

