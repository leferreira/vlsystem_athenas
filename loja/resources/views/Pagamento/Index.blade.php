@extends("template_loja")
@section("conteudo")

<div class="conteudo">
<div class="produtos">
<div class="det_prod">

		<input type="hidden" id="pedido_id" value="<?php echo $carrinho->id ?>">				
		<input type="hidden" id="cliente_id" value="<?php echo $cliente->id ?>">
		
	<div class="col-12 produtos alt" style="margin-top: 0.5rem;">
				<div class="carrinho">
					<div class="titulo" style="border-top:0">						
						<div><span>Confira seu pedido <i class="fas fa-angle-double-right"></i></span>  </div>
					</div>
					<div class="rows mt-4">
						<div class="col-6 mb-3">
						<div class="tabela-responsiva">
							<table cellpadding="0" cellspacing="0" border="0" class="table">             
								<thead>
									<tr>
										<th align="center" width="10">Item</th>
										<th align="left"width="200">Titulo</th>
										<th align="center" width="100">Preço</th>
										<th align="center" width="50">Qtde</th>
										<th align="center" width="100">Total</th>
									</tr>
								</thead>
								<tbody>
								
								@if($pedido)
								@foreach($itens as $item)
							
									@php 
										$img = getenv("APP_IMAGEM_PRODUTO") .$item->produto->imagem;
									@endphp
															
									   <tr>
										<td align="center">
											<div class="thumb"><img src="{{$img}}" class="img-fluido"></div>																				
										</td>
										<td align="left"><span class="produto">{{$item->produto->nome}}</span></td>
										<td align="center">R$ {{$item->valor}}</td>
										<td align="center">{{$item->quantidade}} </td>
										<td align="center">R$ {{number_format($item->subtotal, 2)}} </td>
																				
									</tr>
									
								@endforeach 
								@endif														
                				</tr>
									
							   </tbody>
						 </table>
						</div>
						</div>
						<div class="col-6 mb-3">
							<div class="rows">
								<div class="col-12 mb-3 d-flex">
									<div class=" bg-title3 p-2 radius-4 width-100">
										<table cellpadding="0" cellspacing="0" border="0" class="table limpa" width="100%">             
											<thead>
												<tr>
													<th class="text-left border-bottom" colspan="2">Dados Pessoais (<a href="{{route('carrinho.endereco')}}">Alterar</a>)</th>
												</tr>
											</thead>            
											<tbody>
												<tr><th class="text-left" style="font-size:.8rem" width="40">Nome.</th><td>{{$cliente->nome_razao_social ?? null}} </td></tr>												
												<tr><th class="text-left" style="font-size:.8rem" width="40">End.</th><td>{{$endereco->logradouro ?? null}} , {{ $endereco->numero ?? null}}</td></tr>
												<tr><th class="text-left" style="font-size:.8rem">Bairro.</th><td>{{$endereco->bairro ?? null }}</td></tr>
												<tr><th class="text-left" style="font-size:.8rem">Cidade.</th><td>{{$endereco->cidade  ?? null }}</td></tr>
												<tr><th class="text-left" style="font-size:.8rem">Cep.</th><td>{{$endereco->cep  ?? null }}</td></tr>
											</tbody>
										</table>
									</div>		
								</div>
								<div class="col-12 mb-3 d-flex">
								<div class=" bg-title3 p-2 radius-4 width-100">
									<table cellpadding="0" cellspacing="0" border="0" class="table limpa" width="100%">             
										<thead>
											<tr>
												<th class="text-left border-bottom" colspan="4">Total Pedido Nº {{$pedido->id}}</th>
											</tr>
										</thead>            
										<tbody>
											<tr>
											<td class="text-left" style="font-size:.8rem">Itens. <b>{{count($itens)}}</b></td> 
											<td class="text-left" style="font-size:.8rem">Frete. <b class="text-vermelho">{{number_format($pedido->valor_frete, 2, ',', '.')}}</b></td>
											<td class="text-left" style="font-size:.8rem">Subtotal. <b>{{number_format($pedido->valor_venda, 2, ',', '.')}} </b></td>
											<td class="text-left" style="font-size:.8rem">Total. <b>{{number_format($pedido->valor_venda + $pedido->valor_frete, 2, ',', '.')}} </b></td>
											</tr>
										</tbody>
									</table>
								</div>		
								</div>
							</div>
						</div>
						
				</div>				
			</div>
			
			
		</div>	
						
	 <div class="forma-pagamento">	 					  
				 <div class="caixa-entrega mb-1">
					<span class="titulo mb-1">Escolha a Forma de pagamento</span>		
					<div class="rows my-5">
						<div class="col d-flex mb-3">
							<a href="{{route('pix.ver', $pedido->uuid)}}" class="card width-100 p-2 radius-50" style="border-color: #32bcad;border-width:2px">
								<div class="d-flex py-3">
									<img src="{{asset('assets/loja/img/logo-pix.svg')}}" width="100">
									<div class="ml-3 text-center">
									<span class="h5 mb-1 d-block fw-700 text-left" style="color:#222;font-weight:700">Pagamento via pix</span>
									<small class="mb-3 d-block text-escuro text-left">Clique aqui para pagamento via pix</small>
									<span class="btn btn-verde d-inline-block">pagar com pix</span>
									</div>						
								</div>
							</a>
						</div>
						<div class="col d-flex mb-3">
	

							<a href="{{route('cartao.ver', $pedido->uuid)}}" class="card width-100 p-2 radius-50" style="border-color: #146fb2;border-width:2px">
								<div class="d-flex py-3">
									<img src="{{asset('assets/loja/img/logo-cartao.svg')}}" width="100">
									<div class="ml-3 text-center">
									<span class="h5 mb-1 d-block fw-700  text-left" style="color:#222;font-weight:700">Pagamento por cartão</span>
									<small class="mb-3 d-block text-escuro text-left">Clique aqui para pagamento via cartão de crédito</small>
									<span class="btn btn-azul d-inline-block">pagar com cartão</span>
									</div>						
								</div>
							</a>
						</div>
						<div class="col-4 d-flex mb-3">
							<a href="{{route('boleto.ver', $pedido->uuid)}}" class="card width-100 p-2 radius-50" style="border-color: #8d74d9;border-width:2px">
								<div class="d-flex py-3">
									<img src="{{asset('assets/loja/img/ico-banco.svg')}}" width="100">
									<div class="ml-3 text-center">
									<span class="h5 mb-1 d-block fw-700 text-left" style="color:#222;font-weight:700">Pagamento por Boleto</span>
									<small class="mb-3 d-block text-escuro text-left">Clique aqui para pagamento Por Boleto</small>
									<span class="btn btn-roxo d-inline-block text-branco">Pagar com Boleto</span>
									</div>						
								</div>
							</a>
						</div>
					</div>
					
					
					
	<!-- modal pix --->
	
	<div id="dadosPix" class="window form">					
		<div class="card pag1">
		<span class="tacord"><i class="ico ipagseguro"></i><span>Pagamento pelo pix</span></span>
		<div class="p-3 px-md">					
			<p  class="mb-2 pt-3">Preencha os campus com os dados do titular</p>
				<div class="rows">								
					<div class="col-6 mb-3">
						<strong class="text-label">Nome:</strong>
						<input type="text" name="payerFirstName" id="payerFirstName" value="<?php echo primeiroNome($cliente->nome_razao_social) ?? null ?>" class="form-campo"> 
					</div>
					<div class="col-6 mb-3">
						<strong class="text-label">Sobrenome:</strong>
						<input type="text" name="payerLastName" id="payerLastName" value="<?php echo ultimoNome($cliente->nome_razao_social) ?? null ?>" class="form-campo"> 
					</div>
					
					<div class="col-3 mb-3">
						<strong class="text-label">CPF</strong>
						<input type="text" name="docNumber" id="docNumber" value="<?php echo $cliente->cpf_cnpj ?? null ?>" class="form-campo"> 
					</div>
					<div class="col-6 mb-3">
						<strong class="text-label">Email:</strong>
						<input type="text" name="payerEmail" id="payerEmail" value="<?php echo $cliente->email ?? null ?>" class="form-campo"> 
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
	
				
	<!--modal catão-->
	<div id="cartao" class="window form">
	<div class="card pag1">
		<span class="tacord"><i class="fas fa-"></i><span>Pagamento com cartão</span></span>
		<div class="p-3 px-md">
		<form id="form-checkout" >
    		<div class="rows">
        		<div class="col-4 mb-3">
        				<strong class="text-label">Número do cartão:</strong>
        			   <input type="text" name="cardNumber" id="form-checkout__cardNumber" value="5502096551067143" class="form-campo"/>
        		</div>
        		<div class="col-2 mb-3">
        				<strong class="text-label">Validade</strong>
    			   <input type="text" name="cardExpirationDate" id="form-checkout__cardExpirationDate" value="11/2028" class="form-campo"/>
    		  </div>
    		  <div class="col-6 mb-3">
        				<strong class="text-label">Titular do cartão:</strong>
    			   <input type="text" name="cardholderName" id="form-checkout__cardholderName" value="Manoel Nascimento" class="form-campo"/>
    		  </div>
    		  <div class="col-6 mb-3">
        				<strong class="text-label">Email</strong>
    			   <input type="email" name="cardholderEmail" id="form-checkout__cardholderEmail" value="mjailton@gmail.com" class="form-campo"/>
    		 </div>
    		 <div class="col-3 mb-3">
        				<strong class="text-label">Cód Segurança</strong>
    			   <input type="text" name="securityCode" id="form-checkout__securityCode" value="622" class="form-campo"/>
    	     </div>
    	   		<select name="issuer" id="form-checkout__issuer" class="form-campo" style="display:none"></select>
    		
    		<div class="col-3 mb-3">
        				<strong class="text-label">Tipo Documento</strong>
    			   <select name="identificationType" id="form-checkout__identificationType" class="form-campo"></select>
    	    </div>
    	    <div class="col-6 mb-3">
        				<strong class="text-label">Número do Documento:</strong>
    			   <input type="text" name="identificationNumber" id="form-checkout__identificationNumber" value="78589452387" class="form-campo" />
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
    			<button type="submit" id="form-checkout__submit" class="btn btn-verde">Pagar</button>
				<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho fechar">Fechar</a>
    		</div>
		
		</form>
	</div>
	</div>
				
				<!-- modal contas -->
				<div id="transferencia" class="window form">
					<a href="" class="tacord"><i class="ico ipagseguro"></i><span>Por Depósito/Transferência</span></a>
					<div class="card">
					<div class="p-3 px-md">
							<p class="mb-2 pt-3">Escolha uma das contas disponíveis abaixo para transferencia ou deposito</p>
							
								<div class="rows pagamento">
									<div class="col-4 text-center">
										<img src="{{asset('assets/loja/img/img-bb.png')}}">
										<strong class="text-label">BANCO DO BRASIL</strong>
										<span>Agência: 0000-1         </span>
										<span>Conta: 111112-1         </span>
										<span>CPF: 123.456.789-00</span>	
										<span>Manoel jailton sousa do nascimento</span>	
									</div>
									<div class="col-4 text-center">
										<img src="{{asset('assets/loja/img/img-bbd.png')}}">
										<strong class="text-label">BANCO DO BRADESCO</strong>
										<span>Operação: 0123              </span>
										<span>Agência: 0000-1             </span>
										<span>Poupança: 111112-1          </span>
										<span>CPF:  123.456.789-00</span>	
										<span>Manoel jailton sousa do nascimento</span>
									</div>
									<div class="col-4 text-center">
										<img src="{{asset('assets/loja/img/img-bc.png')}}">
										<strong class="text-label">BANCO DA CAIXA</strong>
										<span>Operação: 0123                  </span>
										<span>Agência: 0000-1                  </span>
										<span>Poupança: 111112-1              </span>
										<span>CPF: 123.456.789-00</span>	
										<span>Manoel jailton sousa do nascimento</span>
									</div>
									
								</div>
							</dd>
						</div>
						
						<div class="tfooter end">
							<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho fechar">Fechar</a>
							<a href="{" class="btn btn-verde">Finalizar compra</a>
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
	
	 
			
	</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		//Definimos que todos as tags dd terão display:none menos o primeiro filho
		$('dd:visible(:first)').hide();
		//Ao clicar no link, executamos a funcao
		$('dt a').click(function(){
			//As tags dd's visíveis agora ficam com display:none
			$("dd:visible").slideUp("slow");
			//Apos, a funcao é transferida para seu pai, que procura o proximo irmao no codigo o tonando visível
			$(this).parent().next().slideDown("slow");
			return false;
		});
	});
</script>	

@endsection
	