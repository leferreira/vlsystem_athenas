@extends("template_loja")
@section("conteudo")
<div class="central">
	<div class="conteudo">
		<div class="rows">
			<div class="col-12 m-auto">
				<div class="titulo" style="justify-content: left;">
					<span>Pagamento</span>  <i class="fas fa-angle-double-right pl-3 text-laranja"></i><span class="text-azul migalha" style="padding-left: 0.3rem;"> via Boleto Bancário</span> </div>
				</div>
		</div>
		
		<input type="hidden"  id="cliente_id" value="<?php echo $pedido->cliente_id ?? null ?>" > 
		<input type="hidden"  id="pedido_id" value="<?php echo $pedido->id ?? null ?>" >
		<input type="hidden"  id="empresa_id" value="<?php echo $pedido->empresa_id ?? null ?>" >
		
		<div class="card pag1">
		<form id="form-checkout" >
		<div class="p-3 px-md">		
    		<div class="rows">
				<div class="col-12">	
					<div class="rows">
				<div class="col-3 mb-3">
					<strong class="text-label">Nome:</strong>
					<input type="text" name="payerFirstName" id="nome" value="<?php echo primeiroNome($pedido->cliente->nome_razao_social) ?? null ?>" class="form-campo"> 
				</div>
				<div class="col-4 mb-3">
					<strong class="text-label">Sobrenome:</strong>
					<input type="text" name="payerLastName" id="sobrenome" value="<?php echo ultimoNome($pedido->cliente->nome_razao_social) ?? null ?>" class="form-campo"> 
				</div>
				
				<div class="col-2 mb-3">
					<strong class="text-label">CPF</strong>
					<input type="text" name="docNumber" id="cpf" value="<?php echo $pedido->cliente->cpf_cnpj ?? null ?>" class="form-campo"> 
				</div>
				<div class="col-3 mb-3">
					<strong class="text-label">Email:</strong>
					<input type="text" name="payerEmail" id="email" value="<?php echo $pedido->cliente->email ?? null ?>" class="form-campo"> 
				</div>
					
					
        		<div class="col-2 mb-3">
        				<strong class="text-label">Cep:</strong>
        			   <input type="text" name="cardNumber" id="cep" value="<?php echo $pedido->cliente->cep ?? null ?>" class="form-campo"/>
        		</div>
        		<div class="col-4 mb-3">
        				<strong class="text-label">Logradouro</strong>
    			   <input type="text" name="cardExpirationDate" id="logradouro" value="<?php echo $pedido->cliente->logradouro ?? null ?>" class="form-campo"/>
    		  </div>
    		  <div class="col-2 mb-3">
        				<strong class="text-label">Número</strong>
    			   <input type="text" name="cardholderName" id="numero" value="<?php echo $pedido->cliente->numero ?? null ?>" class="form-campo"/>
    		  </div>
    		  <div class="col-4 mb-3">
        				<strong class="text-label">Complemento</strong>
    			   <input type="email" name="cardholderEmail" id="complemento" value="<?php echo $pedido->cliente->complemento ?? null ?>" class="form-campo"/>
    		 </div>
    		 <div class="col-4 mb-3">
        				<strong class="text-label">Cidade</strong>
    			   <input type="text" name="securityCode" id="cidade" value="<?php echo $pedido->cliente->cidade ?? null ?>" class="form-campo"/>
    	     </div>
    	   	
    	    <div class="col-2 mb-3">
        				<strong class="text-label">UF</strong>
    			   <input type="text" name="identificationNumber" id="uf" value="<?php echo $pedido->cliente->uf ?? null ?>" class="form-campo" />
    	    </div>
    	      	    
    			   
    		</div>
				</div>
			
				
    		</div>
		</div>
		<div class="tfooter center">
    			<a href="javascript:;" onclick="pagarComBoleto()" class="btn btn-verde fechar">Gerar Boleto</a>
				<a href="{{route('pagamento.escolher', $pedido->uuid)}}" class="btn btn-vermelho ">Voltar</a>
    		</div>
		
		</form>
	</div>
	
	</div>

  
</div>




@endsection

