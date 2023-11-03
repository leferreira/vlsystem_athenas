@extends("Pdv.template")
@section("conteudo")
<?php
use App\Service\ConstanteService;
?>
<section class="conteudo-fluido">
	
		<input type="hidden" id="payerFirstName" value="Manoel">
		<input type="hidden" id="payerLastName" value="Jailton Sousa">
		<input type="hidden" id="docNumber" value="78589452387">
		<input type="hidden" id="payerEmail" value="mjailton@gmail.com">
	
		<input type="hidden" id="caixa_id" value="{{$caixa_id ?? null}}">
		<input type="hidden" id="venda_id" value="{{$venda->id ?? null }}">
		<input type="hidden" id="cliente_id" value="{{($venda->cliente_consumidor ?? null) == 'N' ? $venda->cliente_id : null }}">
		<input type="hidden" id="limite_cliente" value="{{$venda->limite}}" class="mascara-float">
		<input type="hidden" id="credito_liberado" value="{{$venda->situacao}}" >
		<input type="hidden" id="tem_pendencia" value="{{$tem_pendencia ?? null }}">
				
		<div class="base-pdv">	
		<div id="tabs">
		
		<div id="tab-1">
		<div class="caixa px-4 mb-1 border-0">
			@if($tem_pendencia)
				<b class="h5 text-verde d-block mb-1 pt-1 text-center" id="descricao">Atenção! Ao finalizar a venda não será possível a emissão da NFCE por existirem configurações pendentes, caso queira vê-las,<a href="{{route('erros')}}" target="_blank">clique aqui</a></b>
			@else
				@if($transmite_nfce=="S")
					<b class="h4 text-verde d-block mb-1 pt-1 text-center" id="descricao">Opções de pagamento</b>
				@else
					<b class="h4 text-verde d-block mb-1 pt-1 text-center" id="descricao">O opção de Enviar NFCE está desabilitada, portanto não será possível a emissão de NFCE</b>
				@endif
			@endif
		</div>
		<div class="caixa p-3 pt-4">
			<div class="rows p-0">
				<div class="col-12 mb-3">
					<div class="d-flex">
						<div class="">
							<a href="javascript:;" onclick="selecionarFormaPagamento(1,'Dinheiro');	" class="btn btn-azul d-flex center-middle radius-10 px-4 pl-3 width-100 frmPagto " id="frm1"><i class="icobut icodin"></i> <span class="text-left"><small class="text-amarelo">Dinheiro</small> <span class="d-block h5 mb-0">(F3)</span><span></span></span></a>	
						</div>
						<div class="ml-1">
							<a href="javascript:;" onclick="selecionarFormaPagamento(17,'Pix')" class="btn btn-azul d-flex center-middle radius-10 px-4 pl-3  width-100 frmPagto" id="frm17"><i class="icobut icopix"></i> <span class="text-left"><small class="text-amarelo"> PIX </small><span class="d-block h5 mb-0"> (F4)</span></span></a>	
						</div>
						<div class="ml-1">
							<a href="javascript:;" onclick="selecionarFormaPagamento(16,'Transferência')" class="btn btn-azul d-flex center-middle radius-10 px-4 pl-3  width-100 frmPagto" id="frm16"><i class="icobut icotransf"></i> <span class="text-left"><small class="text-amarelo">Transferência </small><span class="d-block h5 mb-0"> (F5)</span></span></a>	
						</div>
						<div class="ml-1">
							<a href="javascript:;" onclick="selecionarFormaPagamento(3,'Cartão Crédito');" class="btn btn-azul d-flex center-middle radius-10 px-4  pl-3 width-100 frmPagto" id="frm3"><i class="icobut idocredito"></i> <span class="text-left"><small class="text-amarelo">Crédito</small><span class="d-block h5 mb-0">  (F6)</span></span></a>	
						</div>
						<div class="ml-1">
							<a href="javascript:;" onclick="selecionarFormaPagamento(4,'Cartão Débito')" class="btn btn-azul d-flex center-middle radius-10 px-4  pl-3 width-100 frmPagto" id="frm4"><i class="icobut icodebito"></i> <span class="text-left"><small class="text-amarelo">Débito </small><span class="d-block h5 mb-0"> (F7)</span></span></a>	
						</div>
						<div class="ml-1">
							<a href="javascript:;" onclick="selecionarFormaPagamento(5,'Crediário')" class="btn btn-azul d-flex center-middle radius-10 px-4  pl-3 width-100 frmPagto" id="frm5"><i class="icobut icodebito"></i> <span class="text-left"><small class="text-amarelo">Crediário </small><span class="d-block h5 mb-0"> (F8)</span></span></a>	
						</div>
						
						
					</div> 
				</div>
				<div class="col-8 ativados">		
					<div class="rows bloquear" id="form_entrada_pagamento">			
					<div class="col-12">
					
							
					<div class="rows bg-title2 mx-0" id="pnInserirPagamentoDinheiro" >			
							<input type="hidden" id="id_forma_pagamento" class="form-campo">
									
							<div class="col-4">
							<div class="cx">
								<label class="text-label">Total a Pagar </label>
								<input type="text" id="valor_pago" class="form-campo mascara-float tecla"  maxlength="22">
							</div>					
							</div>
						
							<div class="col-3" id="txtTroco"  >
							<div class="cx">
								<label class="text-label">Troco</label>
								<input type="text" id="valor_troco" readonly="readonly" class="form-campo mascara-float tecla" placeholder="0,00" maxlength="22">
							</div>
							</div>
							
							
						
							<div class="col-3 ">
							<div class="cx">	
								<label class="text-label">Confirmar</label>							
								<input type="button" id="btInserirPagamento" onclick="inserirDuplicata()" value="Inserir" class="tecla btn btn-verde ">
							</div>
							</div>							
					</div>
					
					
					
						
					</div>	
					</div>	
						<div class="rows">
											
							<div class="col-12 mt-2">
							<div class="suspenso" style="display:none">
                				<div class="window load d-block">
                					<span class="text-load">Aguarde...</span>
                				</div>  
                			</div>
								<div class="tabela-responsiva radius-0 mb-3 p-0 caixa">
									<div class="rolagem-116">
									<table cellpadding="0" cellspacing="0" width="100%" id="">
										<thead>
											<tr>
												<th>#</th>
												<th>Forma de pagamento</th>
												<th>Data</th>
												<th>Valor</th>
												<th></th>
											</tr>
										</thead>
										<tbody id="lista_pagamento">
    									@foreach($venda->duplicatas as $dup)
    										<tr>
    											<td class="text-center">{{$dup->id}}</td> 
                                				<td class="text-center">{{$dup->pagto->forma_pagto}}</td> 
                                				<td class="text-center">{{databr($dup->dVenc)}}</td> 
                                				<td class="text-center">{{$dup->vDup}}</td>
                                				<td class""><a class="btn btn-vermelho btn-pequeno d-inline-block"" href="#prod tbody" onclick="excluirDuplicata({{$dup->id}})">
                                				<i class="fas fa-trash"></i></a></td>
    									@endforeach
										</tr>
										</tbody>
									</table>
									</div>								
								</div>
								
							</div>
							<div class="col-12">
								<div class="atalhos">
									<a href="javascript:;" onclick="abrirModal('#verTelaDescontoDaVenda')"><b>F4</b> - Desconto</a>
									<a href="javascript:;" onclick="pagarComPix()"><b>F2</b> - Checkout Pix</a>
									<a href="javascript:;" onclick="abrirModal('#telaArmazendarVenda')"><b>Ctrl+2</b> - Armazenar</a>
									@if($venda->cliente_consumidor !="S")
										<a href="javascript:;" onclick="abrirModal('#telaPesquisaCliente')"><span id="nome_cliente_selecionado">Nome: {{$venda->nome_cliente ?? ""}} </span> - 
											<span id="nome_cliente_selecionado">Limite: {{$venda->limite ?? ""}}</span>	</a>
									@else
										<a href="javascript:;" onclick="abrirModal('#telaPesquisaCliente')">Selecionar Cliente</a>									
									@endif							
								</div>
							</div>
						</div>
					
				</div>
				<div class="col-4 d-flex">
					<div class="width-100 border">
						<div class="pdv_valores">
								<div class="border-bottom p-3 text-azul">Total venda</div>
								<div class="border-bottom p-3 text-right text-azul vlr"><span id="lbl_total_vendido">{{formataNumeroBr($venda->valor_venda)}}</span></div>
						</div>
						<div class="pdv_valores ">
								<div class="border-bottom p-3 text-azul">Desconto</div>
								<div class="border-bottom p-3 text-right text-azul vlr"><span id="lbl_desconto">{{formataNumeroBr($venda->valor_desconto)}}</span></div>
						</div>
						<div class="pdv_valores ">
								<div class="border-bottom p-3 text-azul">Acrescimo</div>
								<div class="border-bottom p-3 text-right text-azul vlr"><span id="lbl_acrescimo">{{formataNumeroBr($venda->valor_acrescimo)}}</span></div>
						</div>
						<div class="pdv_valores">
								<div class="border-bottom p-3 text-azul">Valor Líquido</div>
								<div class="border-bottom p-3 text-right text-azul vlr"><span id="lbl_total_geral">{{formataNumeroBr($venda->valor_liquido)}}</span></div>
						</div>
						<div class="pdv_valores">
								<div class="border-bottom p-3 text-verde">Total recebido</div>
								<div class="border-bottom p-3 text-right text-verde vlr"><span id="lbl_total_recebido">{{formataNumeroBr($venda->valor_pago)}}</span></div>
						</div>
						<div class="pdv_valores">
								<div class="border-bottom p-3 text-vermelho">Restante</div>
								<div class="border-bottom p-3 text-right text-vermelho vlr"><span id="lbl_total_restante">{{formataNumeroBr($venda->valor_restante)}}</span></div>
						</div>
						<div class="d-flex p-1 py-3 justify-content-space-between">									
							<a href="javascript:;" onclick="cancelarVenda()" class="btn btn-vermelho d-inline-block"><i class="fas fa-times" aria-hidden="true"></i> Cancelar (ESC)</a>	
							<a href="javascript:;" onclick="salvarVenda()" class="btn btn-verde d-inline-block"><i class="fas fa-check" aria-hidden="true"></i> Finalizar (F10)</a>					
						</div>
					</div>
				
				
				</div>
			
		
	</div>
	</div>
	</div>
		
	<!-- TAB 2--->	
	

</div>
</div>





<!--pesquisar produto-->
<div class="window" id="pesquisa">
	<span class="fechar">X</span>
	<h4 class="d-block text-center">Pesquisar produto</h4>
	<div class="rows p-1">
		<div class="tabela-responsiva px-0">
			<table cellpadding="0" cellspacing="0" id="" width="100%">
				<thead>
					<tr>
						<th align="center">Id</th>
						<th class="text-left" width="25%">Nome</th>
						<th align="center" width="25%">Valor</th>
						<th align="center">Ação</th>
					</tr>
				</thead>
				<tbody>                      
					<tr>
						<td align="center">1</td>
						<td align="left">Panela de pressão </td>
						<td align="center">R$80,00</td>										
						<td align="center">
							<a href="#" class="d-inline-block btn btn-outline-roxo btn-pequeno">Selecionar</a>
						</td>
					</tr>                     
					<tr>
						<td align="center">1</td>
						<td align="left">Panela de pressão </td>
						<td align="center">R$80,00</td>										
						<td align="center">
							<a href="#" class="d-inline-block btn btn-outline-roxo btn-pequeno">Selecionar</a>
						</td>
					</tr>				
				</tbody>
			</table>								
		</div>		
	</div>
</div>

<!--identificar cliente-->
<div class="window medio" id="modal_tipo_cupom" style="padding:0!important">
<h4 class="d-block text-center pb-1 border-bottom mb-2 h4 p-3">Venda Finalizada com Sucesso!!</h4>
	<div class="p-2 text-center mt-2" id="giragira_pdv">
		<img src="{{asset('assets/pdv/img/load2.gif')}}" width="60" class="m-auto">
		<span class="text-cinza d-block mt-2 mb-2"> Aguarde carregando...</span>
	</div>
	
	<div class="p-2 text-center mt-2" id="div_retorno_pdv">
		<span class="msg msg-vermelho p-1 text-left">
			<span class="d-block text-center mb-0"> Erro: <b id="mensagem_erro_pdv"></b></span>
			
		</span>
	</div>		
		
	<div class="text-right base-botoes radius-0 mt-0 p-1 border-top py-3 ">	
			<a href="javascript:;" onclick="imprimirCupomFiscal()" class="btn btn-azul d-inline-block btn-medio"><i class="fas fa-scroll"></i>Imprimir Cupom Fiscal (Nfce)</a>					
			<a href="javascript:;" onclick="fecharTela()" class="btn btn-vermelho d-inline-block btn-medio"><i class="fas fa-times"></i> Fechar</a>
	</div>
	
</div>

<!--cancelar venda-->
<div class="window pdv" id="imprimirCupom">	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Venda Finalizada com Sucesso!!</h4>
	<div >
		<p><i class="fas fa-exclamation-triangle"></i> Deseja imprimir o Cupom Fiscal ?</p>							
	</div>
	<div class="border-top p-2 px-0 d-flex">
		<input type="hidden" id="chaveNfe" >
		<a href="javascript:;" onclick="imprimirCupomFiscal()" class="btn btn-verde"><i class="fas fa-check"></i> Sim</a>							
		<a href="{{route('pdv.index')}}" class="btn btn-vermelho ml-1"><i class="fas fa-times"></i> Não</a>							
	</div>	
</div>

<!--identificar cliente-->
<div class="window pdv" id="verTelaFormaPagtoCrediario">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Parcelar Crediário</h4>
	<div class="rows">
		<div class="col-6 postion-relative">
			<label class="text-label">Valor</label>
			<input type="text" id="valor_pagamento_parcela"  class="form-campo mascara-float">
		</div>
		
		<div class="col-6 postion-relative">
			<label class="text-label">Data Inicial</label>
			<input type="date" id="data_pagamento_parcela" value="{{hoje()}}" class="form-campo ">
		</div>
		
		<div class="col-6">
			<label class="text-label">Forma de Parcelar</label>			
			<select class="form-campo" id="forma_de_parcelar_crediario" onchange="mudarTipoInput()">		
    			<option value="1">1 - Número de Parcelas</option>
        		<option value="2">2 - Condições especiais</option>
    		</select>
		</div>
		<div class="col-6 mb-3" >
         	<label class="text-label" id="lbl_parcelas">Parcelas</label>	
       	 	<input type="number"  class="form-campo " value="1" id="qtde_parcela_crediario">	
        </div>
		
		
		<div class="text-right base-botoes radius-0 mt-0 p-1">	
				<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho d-inline-block">Cancelar</a>					
				<a href="javascript:;" onclick="gerarCrediario()" class="btn btn-verde d-inline-block">Confirmar</a>
		</div>
	</div>
</div>



<div class="window pdv" id="verTelaFormaPagtoCartaoCredito">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Pagar com Cartão de  Credito</h4>
	<div class="rows">
		<div class="col-6 postion-relative">
			<label class="text-label">Valor</label>
			<input type="text" id="valor_pagamento_cartao"  class="form-campo mascara-float">
		</div>
		
		
		<div class="col-6 postion-relative">
			<label class="text-label">Data Inicial</label>
			<input type="date" id="data_pagamento_cartao" value="{{hoje()}}" class="form-campo ">
		</div>
		
		<div class="col-6">
			<label class="text-label">Bandeira</label>			
			<select class="form-campo" id="bandeira_id" >		
    			<option value="1">1 - Mastercard</option>
        		<option value="2">2 - Visa</option>
        		<option value="3">3 - Elo</option>
        		<option value="4">4 - American Express</option>
        		<option value="5">5 - Hipercard</option>
    		</select>
		</div>
		<div class="col-6 mb-3" >
         	<label class="text-label">Parcelas</label>	
       	 	<input type="number"  class="form-campo " value="1" min="1"  id="qtde_parcela_cartao">	
        </div>
		
		
		<div class="text-right base-botoes radius-0 mt-0 p-1">	
				<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho d-inline-block">Cancelar</a>					
				<a href="javascript:;" onclick="gerarPagamentoCartao()" class="btn btn-verde d-inline-block">Confirmar</a>
		</div>
	</div>
</div>


<div class="window pdv" id="verTelaFormaPagtoCartaoDebito">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Pagar com Cartão de  Débito</h4>
	<div class="rows">
		<div class="col-3 postion-relative">
			<label class="text-label">Data Inicial</label>
			<input type="date" id="data_pagamento_cartao" value="{{hoje()}}" class="form-campo ">
		</div>
		
		<div class="col-6">
			<label class="text-label">Bandeira</label>			
			<select class="form-campo" id="bandeira_id" >		
    			<option value="1">Visa</option>
        		<option value="2">Mastercard</option>
        		<option value="6">Elo</option>
        		<option value="3">American Express</option>
        		<option value="7">Hipercard</option>
        		<option value="8">Aura</option>
        		<option value="5">Diners Club</option>
    		</select>
		</div>	
		
		<div class="text-right base-botoes radius-0 mt-0 p-1">	
				<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho d-inline-block">Cancelar</a>					
				<a href="javascript:;" onclick="gerarPagamentoCartaoDebito()" class="btn btn-verde d-inline-block">Confirmar</a>
		</div>
	</div>
</div>

<div class="window pdv" id="verTelaCpf">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Identificar cliente</h4>
	<div class="rows">
		<div class="col-4">
			<label class="text-label">CPF</label>			
			<input type="text" id="cliente_cpf" value="{{$venda->cliente_cpf ?? null}}"  class="form-campo mascara-cpf">
		</div>
		<div class="col-8 postion-relative">
			<label class="text-label">CNPJ</label>
			<input type="text" id="cliente_cnpj" value="{{$venda->cliente_cnpj ?? null}}" class="form-campo mascara-cnpj">
		</div>
		
		
		<div class="text-right base-botoes radius-0 mt-0 p-1">	
				<a href="javascript:;" onclick="limparCliente()" class="btn btn-vermelho d-inline-block">Cancelar</a>					
				<a href="javascript:;" onclick="fecharModal()" class="btn btn-verde d-inline-block">Confirmar</a>
		</div>
	</div>
</div>

<div class="window pdv" id="verTelaSuplemento">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Reforço do Caixa</h4>
	<div class="rows">
		<div class="col-3">
			<label class="text-label">Valor</label>			
			<input type="text" required id="valor_suplemento"  class="form-campo mascara-float">
		</div>
		<div class="col-9">
			<label class="text-label">Descrição</label>			
			<input type="text" required id="desc_suplemento"  class="form-campo">
		</div>
		<div class="text-right base-botoes radius-0 mt-0 p-1">	
				<a href="javascript:;" onclick="limparSuplemento()" class="btn btn-vermelho d-inline-block">Cancelar</a>					
				<a href="javascript:;" onclick="confirmarSuplemento()" class="btn btn-verde d-inline-block">Confirmar</a>
		</div>
	</div>
</div>

<div class="window pdv" id="telaArmazendarVenda">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Armazenar Venda</h4>
	<form action="{{route('venda.armazenarVenda')}}" method="post">
	 @csrf
    	<div class="rows">
    		<div class="col-12">
    			<label class="text-label">Digite um título</label>			
    			<input type="text" required name="titulo_venda"  class="form-campo">
    		</div>
    		
    		<div class="text-right base-botoes radius-0 mt-0 p-1">	
    			<input type="hidden" name="venda_id"  value="{{$venda->id}}" class="form-campo">
    			<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho d-inline-block">Cancelar</a>	
    			<input type="submit" class="btn btn-verde d-inline-block" value="Armazenar">
    								
    		</div>
    	</div>
    </form>
</div>




<!--seleciona vendedor-->
<div class="window pdv" id="vendedor">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Selecionar vendedor</h4>
	<div class="tabela-responsiva px-0">
			<table cellpadding="0" cellspacing="0" id="" width="100%">
				<thead>
					<tr>
						<th align="center">Id</th>
						<th class="text-left">Vendedor</th>
						<th class="text-left">Ação</th>
					</tr>
				</thead>
				<tbody>                      
					<tr>
						<td align="center">1</td>
						<td align="left">Nome do vendedor </td>									
						<td align="center">
							<a href="#" class="d-inline-block btn btn-outline-roxo btn-pequeno">Selecionar</a>
						</td>
					</tr>      			
				</tbody>
			</table>								
		</div>	
</div>




<!--cancelar item-->
<div class="window pdv" id="cancelaritem">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Cancelar item</h4>
	<div class="rows">
		<div class="col-6">
			<label class="text-label">Login</label>			
			<input type="text" id="login_gerente" placeholder="Digite um login" class="form-campo">
		</div>
		<div class="col-6">
			<label class="text-label">Senha</label>			
			<input type="text" id="senha_gerente" placeholder="Digite uma senha" class="form-campo">
		</div>	
		
		<div class="col-2 mt-2">
			<input type="text" id="id_item" >		
			<input type="button" onclick="cancelarItem()" value="Confirmar" class="btn btn-roxo">
		</div>							
	</div>	
</div>





<div class="window pdv" id="verTelaDescontoDaVenda">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Desconto / Acréscimo</h4>
	<div class="rows">
		<div class="col-3">
			<div class="caixa border-0 p-0 mb-1">
				<small class="text-label text-uppercase mt-0">Desconto Perc (%) </small>
				<input type="text" name="desconto_percentual_total" id="desconto_percentual_total" value="{{$venda->desconto_per ?? 0}}"  class="form-campo grande text-left tecla mascara-float" >
			</div>					
		</div>

		<div class="col-3">
			<div class="caixa border-0 p-0 mb-1">
				<small class="text-label text-uppercase mt-0">Desconto Valor (R$) </small>
				<input type="text" name="desconto_por_valor_total" id="desconto_por_valor_total" value="{{$venda->desconto_valor ?? 0}}"  class="form-campo grande text-left tecla mascara-float" >
			</div>					
		</div>
		
		<div class="col-3">
			<div class="caixa border-0 p-0 mb-1">
				<small class="text-label text-uppercase mt-0">Acréscimo Perc (%) </small>
				<input type="text" name="acrescimo_percentual_total" id="acrescimo_percentual_total" value="{{$venda->acrescimo_per ?? 0}}"  class="form-campo grande text-left tecla mascara-float" >
			</div>					
		</div>

		<div class="col-3">
			<div class="caixa border-0 p-0 mb-1">
				<small class="text-label text-uppercase mt-0">Acréscimo Valor (R$) </small>
				<input type="text" name="acrescimo_por_valor_total" id="acrescimo_por_valor_total" value="{{$venda->acrescimo_valor ?? 0}}"  class="form-campo grande text-left tecla mascara-float" >
			</div>					
		</div>
		
		<div class="text-right base-botoes radius-0 mt-0 p-1">	
				<a href="javascript:;" onclick="limparDesconto()" class="btn btn-vermelho d-inline-block">Cancelar</a>					
				<a href="javascript:;" onclick="enviarDescontoAcrescimento()" class="btn btn-verde d-inline-block">Confirmar</a>
		</div>						
	</div>	
</div>

<!--cancelar venda-->
<div class="window pdv" id="cancelarvenda">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Cancelar venda confirmação</h4>
	<div >
		<p><i class="fas fa-exclamation-triangle"></i> Confirmar cancelamento desta venda?</p>							
	</div>
	<div class="border-top p-2 px-0 d-flex">
		<a href="{{route('home')}}" class="btn btn-verde"><i class="fas fa-check"></i> Sim</a>							
		<a href="javascript:;" onclick="fecharTela()" class="btn btn-vermelho ml-1"><i class="fas fa-times"></i> Não</a>							
	</div>	
</div>

<!--cqancelamento de nota-->
<div class="window" id="telaPesquisaProduto">
	<span class="fechar">X</span>
	<h4 class="d-block text-center">Buscar Produto</h4>
	<div class="rows p-1">		
			<div class="col-6 mt-2">
				<label class="text-label">Pesquisa Por Descrição</label>			
				<input type="text" id="pesquisaProduto"  class="form-campo">
			</div>	
		</div>
		
		<div class="tabela-responsiva px-0 rolagem-290">
			<table cellpadding="0" cellspacing="0"  width="100%">
				<thead>
					<tr>						
						<th align="center">ID</th>
						<th class="text-left">Código Barra</th>
						<th align="center">Descrição</th>
						<th align="center">Unidade</th>
						<th align="center">Preço</th>
						<th align="center">Opção</th>
					</tr>
				</thead>
				<tbody id="listaProduto"></tbody>
			</table>
		</div>
						
				
	</div>

<div class="window" id="telaPesquisaCliente">
	<span class="fechar">X</span>
	<h4 class="d-block text-center">Buscar Cliente</h4>
	<div class="rows p-1">		
			<div class="col-4 mt-2">
				<label class="text-label">Selecione o Campo</label>	
				<select id="campo_busca_cliente" class="form-campo" >					
					<option value="cpf_cnpj">CPF/CNPJ</option>
					<option value="nome_razao_social">Nome do Cliente</option>
					<option value="id">Código do Cliente</option>
										
				</select>		
			</div>
			<div class="col-8 mt-2">
				<label class="text-label">Digite o Valor</label>			
				<input type="text" id="valor_busca_cliente"  class="form-campo">
			</div>	
		</div>
		
		<div class="tabela-responsiva px-0 rolagem-290">
			<table cellpadding="0" cellspacing="0"  width="100%">
				<thead>
					<tr>						
						<th align="center">ID</th>
						<th class="text-left">Nome</th>
						<th align="center">CPF/CNPJ</th>
						<th align="center">Email</th>
						<th align="center">Fone</th>
						<th align="center">Opção</th>
					</tr>
				</thead>
				<tbody id="listaCliente"></tbody>
			</table>
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
	

<div id="modalSucesso" class="modal verde">
<div class="text-center box">
 <a href="#fechar" title="Fechar" class="fecharModal">x</a>
	<!-- ESTE QUANDO SUCESSO --->
	<i class="fas fa-check h1" aria-hidden="true"></i> 
	<span class="d-block h5"><b>Parabens!</b> Sua venda foi completada com sucesso</span>
</div>
</div>

<div id="modalErro" class="modal vermelho">
<div class="text-center box">
 <a href="#fechar" title="Fechar" class="fecharModal">x</a>
	<i class="fas fa-bug h1 " aria-hidden="true"></i> 
	<span class="d-block h5"><b>Ops!</b> Por favor, insira algum item antes</span>
	
</div>
</div>
</div>

</section>

<script>
	var TOTAL_RESTANTE 	= "{{$venda->valor_restante}}";
	
	function mudarTipoInput(){
		var tipo = $("#forma_de_parcelar_crediario").val();
		if(tipo=="1"){
			$("#lbl_parcelas").html("Parcelas");
			$("#qtde_parcela_crediario").val("1");
			$("#qtde_parcela_crediario").prop("type", "number")
		}else{
		$("#lbl_parcelas").html("Parcelas (exemplo: 20-30-40)");
			
			$("#qtde_parcela_crediario").val("");
			$("#qtde_parcela_crediario").prop("type", "text")
		}		
	}	
</script>
@endsection
<div id="fundo_preto"></div>
