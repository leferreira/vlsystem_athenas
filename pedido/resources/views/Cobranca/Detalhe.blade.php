@extends("template2")
@section("conteudo")
<div class="caixa">
		<div class="thead between mb-0">
			<h1 class="titulo mb-0"><strong>Pedidos</strong></h1>		
			<a href="{{route('home')}}" class="btn btn-azul"><i class="fas fa-arrow-left"></i> Voltar</a>	
		</div>
		
		<input type="hidden"  id="cliente_id" value="<?php echo $cobranca->cliente_id ?? null ?>" > 
		<input type="hidden"  id="cobranca_id" value="<?php echo $cobranca->id ?? null ?>" >
		<input type="hidden"  id="empresa_id" value="<?php echo $cobranca->empresa_id ?? null ?>" >
		<div class="p-2">
		<div class="rows">
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
			
			<div class="central">
	<div class="conteudo">
		<div class="rows">
			<div class="col-12 m-auto text-center pt-4">
				<span class="d-block text-center h4 text-escuro mt-1">Escolha uma <span class="text-azul">forma de pagamento</span> </span>
			</div>
		</div>
		
		<div class="p-3 px-4 mb-3">
		<div class="rows mt-2">
			<div class="col-4 d-flex mb-3" :class="carregandoPix ? 'desabilitado' : ''">
				<a href="{{route('pix.ver', $cobranca->uuid)}}" class="card width-100 p-2 radius-50" style="border-color: #32bcad;border-width:2px">
					<div class="d-flex py-3">
						<div class="ml-3">
						<span class="h5 mb-1 d-block fw-700" style="color:#222;font-weight:700">Pagamento via pix</span>
						</div>
					</div>
					
						<span class="btn btn-verde btn-medio"> Pix</span>
				</a>
			</div>
			
		  	<div class="col d-flex mb-3">
				<a href="{{route('cartao.ver', $cobranca->uuid)}}"  class="card pagamento width-100 p-2">
					<div class="d-flex py-3">
						<div class="ml-3">
						<span class="h5 mb-1 d-block fw-700" style="color:#222;font-weight:700">cartão</span>
						</div>
					</div>					
					<span class="btn btn-azul btn-medio">pagar com cartão</span>
				</a>
			</div>
			
			<div class="col d-flex mb-3">
				<a href="{{route('boleto.ver', $cobranca->uuid)}}" class="card pagamento width-100 p-2">
					<div class="d-flex py-3">
						<div class="ml-3">
						<span class="h5 mb-1 d-block fw-700" style="color:#222;font-weight:700"> boleto</span>
						</div>
					</div>
						<span class="btn btn-roxo btn-medio">pagar com boleto</span>
				</a>
			</div>
			
			
		</div>
		</div>
	</div>

    
</div>
	
</div>
</div>

 
	</div>
	
	
	<div id="dadosPix" class="window form">					
		<div class="card pag1">
		<span class="tacord"><i class="ico ipagseguro"></i><span>Pagamento pelo pix</span></span>
		<div class="p-3 px-md">					
			<p  class="mb-2 pt-3">Preencha os campus com os dados do titular</p>
				<div class="rows">								
					<div class="col-6 mb-3">
						<strong class="text-label">Nome:</strong>
						<input type="text" name="payerFirstName" id="payerFirstName" value="<?php echo primeiroNome($cobranca->cliente->nome) ?? null ?>" class="form-campo"> 
					</div>
					<div class="col-6 mb-3">
						<strong class="text-label">Sobrenome:</strong>
						<input type="text" name="payerLastName" id="payerLastName" value="<?php echo ultimoNome($cobranca->cliente->nome) ?? null ?>" class="form-campo"> 
					</div>
					
					<div class="col-3 mb-3">
						<strong class="text-label">CPF</strong>
						<input type="text" name="docNumber" id="docNumber" value="<?php echo $cobranca->cliente->cpf_cnpj ?? null ?>" class="form-campo"> 
					</div>
					<div class="col-6 mb-3">
						<strong class="text-label">Email:</strong>
						<input type="text" name="payerEmail" id="payerEmail" value="<?php echo $cobranca->cliente->email ?? null ?>" class="form-campo"> 
					</div>
					<div class="col-3 m-auto text-center ">										
						
					</div>	
			
		</div>
		</div>
		
		<div class="tfooter end">
			<input type="hidden" name="transactionAmount" id="transactionAmount" >		
			<input type="hidden" name="productDescription" id="productDescription" value="Nome do Produto">				
			<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho fechar">Fechar</a>
			<a href="javascript:;" onclick="pagarComPix()"  class="btn btn-verde">Gerar QrCode</a>					
		</div>
		</div>
	</div>
	
	
		<div class="window form" id="pix">
			<span class="tacord">Pague com Pix e receba a confirmação imediata do seu pagamento</span>
	<div class="card pag1">
		<div class="p-3 px-md">
			<div class="rows">
				<ul class="col-8 mt-4"> 
					<li class="d-block mb-1"><span>1 - Abra o aplicativo do seu banco de preferência</span></li>
					<li class="d-block mb-1"><span>2 - Selecione a opção pagar com Pix</span></li>
					<li class="d-block mb-1"><span>3 - Leia o QR code ou copie o código abaixo e cole no campo de pagamento</span></li>
				</ul>
				<div class="col-4">
					<img src="" id="imageQRCode" class="img-fluido">
				</div>
				<div class="col-6 grupo-form-btn">
					<input type="text" class="form-campo" id="codigoPix" style="">
				</div>
			</div>
		</div>
		<div class="tfooter end">
			<a href="" class="fechar btn btn-vermelho ">Fechar</a>
		</div>
		</div>
	</div>
	
	@endsection