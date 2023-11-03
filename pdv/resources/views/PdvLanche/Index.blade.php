@extends("Pdv.template")
@section("conteudo")

<section class="conteudo-fluido">
	
		<div class="base-pdv">	
		<div class="rows">	
			<div class="col-12">
				<div class="caixa  border-0">
					<div class="caixa px-4 mb-0 border-0">
					<b class="h4 text-verde d-block mb-1 pt-1 text-center" id="descricao">Selecione um Produto</b>
					</div>
				</div>
			</div>
			<input type="hidden" id="caixa_id" value="{{$caixa->id}}">
			<input type="hidden" id="venda_id" value="{{$venda->id}}">
			<input type="hidden" id="id_venda" value="{{$venda->id}}">
			<div class="col-6 d-flex">
				
				<!--pode colocar dentro de qualquer uma das class *col-1,2,3,4,5,6,7,8,9,10,12* -->				
				<div class="suspenso" style="display:none">
					<div class="window load d-block">
						<span class="text-load">Carregando...</span>
					</div>  
				</div>  
			
				<div class="caixa width-100  border-0 mb-1">
				<div class="width-100 border-0">
				<div class="rows">
				<!--pode colocar dentro de qualquer uma das class *col-1,2,3,4,5,6,7,8,9,10,12* -->				
				<div class="suspenso" style="display:none">
					<div class="window load d-block">
						<span class="text-load">Aguarde...</span>
					</div>  
				</div> 
				
					<div class="col-12 postion-relative mb-3">
						<div class="caixa p-1 mb-0" style="">
							<div class="rows"  style="justify-content:center;align-items:center">								
								
								<div class="col-8">								
									<!--<small class="text-label mt-0">Código</small>-->
									<input id="codigo_produto" name="codigo_produto"  class="form-campo grande tecla" placeholder="Código">
								</div>
								<div class="col-4 radio">								
									<!--<small class="text-label mt-0">Código</small>-->
									<div class="d-flex width-100">
										<div class="d-flex"  style="align-items: center;"><input type="radio" id="porCodigo" value="id" name="tipo_pesquisa" {{$caixa->num_pdv->padrao_busca=="id" ? "checked": "" }}  class="form-campo  tecla" placeholder="Código"> <label>Cód. Produto</label></div>
										<div class="d-flex"  style="align-items: center;"><input type="radio" id="porBarra" value="barra" name="tipo_pesquisa"  {{$caixa->num_pdv->padrao_busca=="barra" ? "checked": "" }} class="form-campo  tecla" placeholder="Código"> <label>Cód. Barra </label></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-12">
					<div class="rows">
						<div class="col-8 d-flex pl-4">
							<div class="caixa p-1 radius-4 text-center area-prod">
								<div class="tmb-prog">
									<img src="{{asset('assets/pdv/img/naoencontrado.png')}}" name="imagem" id="imagem" class="img-fluido">
								</div>
							</div>
						</div>
						<div class="col-4 mb-2 pr-4">
							<div class="rows">
							<div class="col-12">
								<div class="caixa border-0 p-0 mb-1">
									<small class="text-label text-uppercase mt-0">Quantidade</small>
									<input type="text" name="qtde" id="qtde" value="1" class=" form-campo grande text-left tecla mascara-float" >
								</div>
							</div>
						
							<div class="col-12">
								<div class="caixa border-0 p-0 mb-1">
									<small class="text-label text-uppercase mt-0">Unitário</small>
									<input type="text" name="preco" id="preco"  class="form-campo grande text-left tecla mascara-float" >
								</div>					
							</div>	
							<div class="col-12">
                    			<label class="text-label">Tipo Desc</label>			
                    			<select id="tipo_desconto_item" class="form-campo tecla">
                    				<option value="desc_perc">Porcentagem(%)</option>
                    				<option value="desc_valor">Valor(R$)</option>
                    				
                    			</select>
                    		</div>
		
							<div class="col-12">
								<div class="caixa border-0 p-0 mb-1">
									<small class="text-label text-uppercase mt-0">Desc. Unit <span id="tip_des_unit"></span></small>
									<input type="text" name="valor_desconto_item" id="valor_desconto_item" value="0"  class="form-campo grande text-left tecla mascara-float" >
								</div>					
							</div>
											
							<div class="col-12">
								<div class="caixa border-0 p-0 mb-1">
									<small class="text-label text-uppercase mt-0">Total</small>
									<input type="text" name = "subtotal" id="subtotal" class="form-campo grande text-left tecla mascara-float" >
									<input type="hidden" name="id_produto" id="id_produto"  >
								</div>
							</div>
							
							
							</div>
						</div>
					  </div>
					  </div>
				  </div>				
					
			</div>
			</div>
		</div>
	
	<div class="col-6 d-flex listaProd">		
	<div class="caixa width-100  border-0 mb-1">		
	<div class="width-100 border-0 mb-1">
		<!--<span class="h5 border-bottom d-block p-1 text-center">DESCRIÇÃO DA COMPRA</span> -->
		<div class="">
		<div class="base-lista">			
			<div class="scroll border-0 px-0" >	
				
			<div class="cupom p-0">			
				<div class="border-bottom-dashed"><b class="d-block h5 text-center mb-3 mt-3">Descrição</b></div>
				<table cellpadding="0" cellspacing="0" class="prod" id="prod">
					<thead>
						<tr>
							<th width="5%">Item</th>
							<th width="30%" align="left">Descrição</th>
							<th width="5%">Quant.</th>
							<th width="5%">Preço</th>
							<th width="5%">Desconto</th>
							<th width="5%">Total</th>
							<th width="5%">Excluir</th>
						</tr>
					</thead>       
				 
					<tbody role="alert" aria-live="polite" aria-relevant="all" id="itensDaVenda">						
					</tbody>
				</table>
				</div>
			</div>
			</div>
			
		</div>
		
			
		</div>
		
		<div class="">
			<div class="fechar_total border-top"  >
				<div class="rows">
					<!--<div class="col-6 d-flex justify-content-center pl-4 center-middle">					
					<div class="mt-2 d-flex justify-content-center aberto width-100 center-middle">					
							<b class="h4 d-block mb-1 text-center" id="descricao"> Caixa aberto</b>
					</div>
					</div>
					-->
					<div class="col-8">
						<div class="caixa border-0 p-1 mb-0">
							<div class="rows">
								<div class="col-6">
									<small class="text-label mt-0 pb-0 text-uppercase mb-0">Volumes</small>
									<input type="text" name = "volume" id="volume" readonly="readonly" class="form-campo  text-left mascara-float">
									
								</div>
								<div class="col-6">
									<small class="text-label mt-0 pb-0 mb-0 text-uppercase text-left">Total</small>
									<input type="text" name="total_geral" id="total_geral" readonly="readonly"   class="form-campo  fw-700 text-right mascara-float">
								</div>					
							</div>					
						</div>					
					</div>
					<div class="col-4 mt-1 pt-1">
						<a href="javascript:;"  onclick="salvarItensDaVendaNoBanco()"   class="d-inline-block btn btn-verde"><i class="fas fa-cash-register"></i> Finalizar Venda</a>
					</div>
				</div>					
			</div>
			
			
		
		<!--<div class="base-botoes alt p-1 text-right mb-0 caixa border-0 mt-0" style="border-radius:0;border-top:solid 1px #ddd!important">  
			
		</div>-->
		</div>	
	</div>	
						
	</div>
	<div class="col-12">				
				<div class="base-botoes fixed mt-0 radius-4 p-1 border-0  text-center mb-0 caixa bg-title2 mostraFiltro">  
						<a href="javascript:;" onclick="abrirModal('#cliente')" class=""><i class="ico user-cliente"></i> <span>Identificar cliente</span></a>
						<a href="javascript:;" onclick="abrirModal('#suplemento')" class=""><i class="ico suplemento"></i> <span>Suplemento </span></a>
						<a href="javascript:;" onclick="abrirModal('#sangria')" class=""><i class="ico sangria"></i> <span>Sangria </span></a>
						<a href="javascript:;" onclick="abrirModal('#cancelarvenda')" class=""><i class="ico cancel"></i> <span>Cancelar venda </span></a>
						<a href="javascript:;" onclick="abrirModal('#fecharCaixa')" class="fechar_caixa"><i class="ico fechar-venda"></i> <span>Fechar Caixa </span></a>
				</div>	
		
	</div>
	
	<div class="col-12">
			<div class="atalhos">
				<a href="javascript:;" onclick="abrirModal('#telaPesquisaProduto')"><b>F1</b> - Pesquisar Produto</a>
				<a href="javascript:;" onclick="salvarItensDaVendaNoBanco()"><b>F2</b> - Finalizar Venda</a>
				<a href="javascript:;" onclick="telaQtdeDesconto()"><b>Ctrl+1</b> - Desconto</a>
				<a href="javascript:;" onclick="abrirModal('#verTelaSangria')"><b>Ctrl+2</b> - Sangria</a>
				<a href="javascript:;" onclick="abrirModal('#verTelaSuplemento')"><b>Ctrl+3</b> - Suplemento</a>
				<a href="javascript:;" onclick="telaCliente()"><b>Ctrl+C</b> - Inserir CPF</a>
				<a href="javascript:;" onclick="abrirModal('#fecharCaixa')"><b>Ctrl+F</b> - Fechar Caixa</a>
				<a href="javascript:;" onclick="abrirModal('#sairPdv')"><b>Ctrl+S</b> - Sair do PDV</a>
			</div>
		</div>	
</div>
</div>




<!--Efetuar Pagamento -->
<div class="window pdv2" id="encerrar">
	<span class="fechar">X</span>
	<h4 class="d-block text-center pb-1 border-bottom mb-2">Efetuar pagamento</h4>
	<div class="rows p-0">
	<div class="col-12 mb-3">
		<div class="d-flex">
			<div class="">
				<a href="javascript:;" onclick="selecionarFormaPagamento(1,'Dinheiro');	" class="btn btn-azul d-flex center-middle radius-10 px-4 pl-3 width-100"><i class="icobut icodin"></i> <span class="text-left"><small class="text-amarelo">Dinheiro</small> <span  class="d-block h5 mb-0">(F3)</span><span></a>	
			</div>
			<div class="ml-1">
				<a href="javascript:;" onclick="selecionarFormaPagamento(17,'Pix')" class="btn btn-azul d-flex center-middle radius-10 px-4 pl-3  width-100"><i class="icobut icopix"></i> <span class="text-left"><small class="text-amarelo"> PIX </small><span  class="d-block h5 mb-0"> (F4)</span></a>	
			</div>
			<div class="ml-1">
				<a href="javascript:;" onclick="selecionarFormaPagamento(16,'Transferência')" class="btn btn-azul d-flex center-middle radius-10 px-4 pl-3  width-100"><i class="icobut icotransf"></i> <span class="text-left"><small class="text-amarelo">Transferência </small><span  class="d-block h5 mb-0"> (F5)</span></a>	
			</div>
			<div class="ml-1">
				<a href="javascript:;" onclick="selecionarFormaPagamento(3,'Cartão Crédito');" class="btn btn-azul d-flex center-middle radius-10 px-4  pl-3 width-100"><i class="icobut idocredito"></i> <span class="text-left"><small class="text-amarelo">Cartão Crédito</small><span  class="d-block h5 mb-0">  (F6)</span></a>	
			</div>
			<div class="ml-1">
				<a href="javascript:;" onclick="selecionarFormaPagamento(4,'Cartão Débito')" class="btn btn-azul d-flex center-middle radius-10 px-4  pl-3 width-100"><i class="icobut icodebito"></i> <span class="text-left"><small class="text-amarelo">Cartão Débito </small><span  class="d-block h5 mb-0"> (F7)</span></a>	
			</div>
			
		</div> 
	</div>
		<div class="col-8 ativados">		
			<div class="rows bloquear" id="form_entrada_pagamento" >			
			<div class="col-12" >			
			<div class="rows bg-title2 mx-0" >			
					<div class="col-4">
    					<div class="cx">
    						<label class="text-label">Forma de pagamento</label>
    						<input type="text" id="txt_forma_pagamento" readonly   class="form-campo tecla">
    						<input type="hidden" id="id_forma_pagamento"  class="form-campo">						
    					</div>
					</div>
					<div class="col-4" id="parcelas" >
						<div class="cx" >
							<label class="text-label">Qtde parcela</label>
							<input type="number" id="qtde_vezes" min="1" value="1" class="form-campo tecla" onchange="calculaParcela()">
							
						</div>						
					</div>				
					<div class="col-4">
					<div class="cx">
						<label class="text-label">Total a Pagar</label>
						<input type="text" id="valor_pago"  class="form-campo mascara-float tecla" >
					</div>					
					</div>
					<div class="col-4">
					<div class="cx">
						<label class="text-label">Valor Recebido</label>
						<input type="text" id="valor_recebido"  class="form-campo mascara-float tecla" >
					</div>
					</div>
					<div class="col-4">
					<div class="cx">
						<label class="text-label">Troco</label>
						<input type="text" id="valor_troco" readonly="readonly" class="form-campo mascara-float tecla" >
					</div>
					</div>
					<div class="col-4 mt-3 pt-1">
					<div class="cx">
						
						<input type="button" id="btInserirPagamento" onclick="inserirPagamento()" value="Inserir Pagamento" class="tecla btn btn-verde " >
					</div>
					</div>
			</div>	
			</div>	
			</div>	
				<div class="rows" >
									
					<div class="col-12 mt-2">
						<div class="tabela-responsiva radius-0 mb-3 p-0 caixa">
							<div class="rolagem-116">
							<table cellpadding="0" cellspacing="0" width="100%" id="">
								<thead>
									<tr>
										<th>#</th>
										<th>Forma de pagamento</th>
										<th>Parcelas</th>
										<th>Valor</th>
										<th></th>
									</tr>
								</thead>
								<tbody id="lista_pagamento">
									
								</tbody>
							</table>
							</div>
						
						</div>
						<div class="caixa  border-0 text-left base-botoes radius-0 mt-0 p-1">					
								<div class="rows  ">
									<div class="col-12" style="padding:0 .5rem">
									<div class="rows mx-0">
										<div class="col-3 ">
												<small class="text-label mt-0 mb-0 text-uppercase text-right">Tipo Acréscimo </small>
												<select class="form-campo input_acrescimo tecla" id="tipo_acrescimo">
													<option value='sem'>Sem Acréscimo </option>
													<option value='perc'>Percentual (%) </option>
													<option value='valor'>Valor(R$) </option>
												</select>
											</div>
										
										<div class="col-3 ">
												<small class="text-label mt-0 mb-0 text-uppercase text-right">Acréscimo (ctrl + a)</small>
												<input type="text"  id="acrescimo_perc"   value="0" class="form-campo input_acrescimo tecla fw-700 text-right mascara-float">
											</div>
								
											
										<div class="col-3 ">
												<small class="text-label mt-0 mb-0 text-uppercase text-right">Tipo Desconto </small>
												<select class="form-campo input_desconto tecla" id="tipo_desconto">
													<option value='sem'>Sem Desconto </option>
													<option value='perc'>Percentual (%) </option>
													<option value='valor'>Valor(R$) </option>
												</select>
										</div>
										
										<div class="col-3 ">
												<small class="text-label mt-0 mb-0 text-uppercase text-right">Desconto (ctrl + d)</small>
												<input type="text"  id="desconto_perc"   value="0" class="form-campo  input_desconto fw-700 text-right mascara-float tecla">
											</div>							
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>
			
		</div>
		<div class="col-4 d-flex">
			<div class="width-100 border">
				<div class="pdv_valores">
						<div class="border-bottom p-3 text-azul">Total venda</div>
						<div class="border-bottom p-3 text-right text-azul vlr"><span id="lbl_total_vendido"></span></div>
				</div>
				<div class="pdv_valores ">
						<div class="border-bottom p-3 text-azul">Desconto</div>
						<div class="border-bottom p-3 text-right text-azul vlr"><span id="lbl_desconto"></span></div>
				</div>
				<div class="pdv_valores ">
						<div class="border-bottom p-3 text-azul">Acrescimo</div>
						<div class="border-bottom p-3 text-right text-azul vlr"><span id="lbl_acrescimo"></span></div>
				</div>
				<div class="pdv_valores">
						<div class="border-bottom p-3 text-azul">Total a receber</div>
						<div class="border-bottom p-3 text-right text-azul vlr"><span id="lbl_total_geral"></span></div>
				</div>
				<div class="pdv_valores">
						<div class="border-bottom p-3 text-verde">Total recebido</div>
						<div class="border-bottom p-3 text-right text-verde vlr"><span id="lbl_total_recebido"></span></div>
				</div>
				<div class="pdv_valores">
						<div class="border-bottom p-3 text-vermelho">Restante</div>
						<div class="border-bottom p-3 text-right text-vermelho vlr"><span id="lbl_total_restante"></span></div>
				</div>
				<div class="d-flex p-1 py-3 justify-content-space-between">									
					<a href="javascript:;" onclick="cancelarVenda()" class="btn btn-vermelho d-inline-block"><i class="fas fa-times"></i> Cancelar (ESC)</a>	
					<!-- <a href="#modalSucesso" class="btn btn-verde d-inline-block"><i class="fas fa-check"></i> Finalizar (F10)</a>					
					<a href="#modalErro" class="btn btn-verde d-inline-block"><i class="fas fa-check"></i> Finalizar (F10)</a>
					 -->					
					<a href="javascript:;" onclick="salvarVenda()" class="btn btn-verde d-inline-block"><i class="fas fa-check"></i> Finalizar (F10)</a>					
				</div>
			</div>
		
			<!--<div class="tabela-responsiva zebrado tb-g border p-0">
				<table cellpadding="0" cellspacing="0" width="100%" class="mb-0">
					<tbody>
						<tr>
							<td class="text-azul">Total venda</td>
							<td class="text-azul text-right"><span id="lbl_total_vendido"></span></td>
						</tr>
					
						<tr>
							<td class="text-azul">Desconto</td>
							<td class="text-azul text-right"><span id="lbl_desconto"></span></td>
						</tr>
						<tr>
							<td class="text-azul">Acrescimo</td>
							<td class="text-azul text-right"><span id="lbl_acrescimo"></span></td>
						</tr>
						<tr>
							<td class="text-azul">Total a receber</td>
							<td class="text-azul text-right"><span id="lbl_total_geral"></span></td>
						</tr>
						<tr>
							<td class="text-verde">Total recebido</td>
							<td class="text-verde text-right"><span id="lbl_total_recebido"></span></td>
						</tr>
						<tr>
							<td class="text-vermelho">Restante</td>
							<td class="text-vermelho text-right"><span id="lbl_total_restante"></span></td>
						</tr>
						<tr>
							<td colspan="2" class="p-0 ">									
							<div class="d-flex p-1 py-2">									
								<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho d-inline-block"><i class="fas fa-times"></i> Cancelar</a>	
								<a href="javascript:;" onclick="salvarVenda()" class="btn btn-verde d-inline-block"><i class="fas fa-check"></i> Finalizar</a>					
							</div>

							</td>
						</tr>						
					</tbody>
				</table>
			</div>-->
		</div>
		<!--<div class="col-12">
			<div class="atalhos">
				<span><b>F2</b> (Pag/dinheiro)</span>
				<span><b>F3</b> (Pag/Pix)</span>
				<span><b>F4</b> (Pag/Transferência)</span>
				<span><b>F5</b> (cartão/crédito)</span>
				<span><b>F6</b> (cartão/débito)</span>
				<span><b>Ctrl + A</b> (Acréscimo)</span>
				<span><b>Ctrl + D</b> (Desconto)</span>
				<span><b>Esc</b> (cancelar)</span>
				<span><b>F10</b> (Finalizar)</span>
			</div>
		</div>-->
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
<h4 class="d-block text-center pb-1 border-bottom mb-2">Cupom Gerado com Sucesso</h4>
	<div >
		<p><i class="fas fa-exclamation-triangle"></i> Deseja imprimir o Cupom Fiscal ?</p>							
	</div>
	<div class="border-top p-2 px-0 d-flex">
		<a href="javascript:;" onclick="imprimirCupomFiscal()" class="btn btn-verde"><i class="fas fa-check"></i> Sim</a>							
		<a href="javascript:;" onclick="fecharTela()" class="btn btn-vermelho ml-1"><i class="fas fa-times"></i> Não</a>							
	</div>	
</div>

<!--identificar cliente-->
<div class="window pdv" id="verTelaCpf">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Identificar cliente</h4>
	<div class="rows">
		<div class="col-4">
			<label class="text-label">CPF</label>			
			<input type="text" id="cliente_cpf"  class="form-campo mascara-cpf">
		</div>
		<div class="col-8 postion-relative">
			<label class="text-label">CNPJ</label>
			<input type="text" id="cliente_cnpj"  class="form-campo mascara-cnpj">
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
				<a href="javascript:;" onclick="limparSangria()" class="btn btn-vermelho d-inline-block">Cancelar</a>					
				<a href="javascript:;" onclick="confirmarSangria()" class="btn btn-verde d-inline-block">Confirmar</a>
		</div>
	</div>
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

<!--cancelar venda-->
<div class="window pdv" id="fecharCaixa">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Fechar Caixa</h4>
	<div >
		<p><i class="fas fa-exclamation-triangle"></i> Tem certeza que deseja Fecha o Caixa ?</p>							
	</div>
	<div class="border-top p-2 px-0 d-flex">
		<a href="{{route('caixa.fechamento', $caixa->id)}}" class="btn btn-verde"><i class="fas fa-check"></i> Sim</a>							
		<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho ml-1"><i class="fas fa-times"></i> Não</a>							
	</div>	
</div>

<!--cancelar venda-->
<div class="window pdv" id="sairPdv">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Fechar Caixa</h4>
	<div >
		<p><i class="fas fa-exclamation-triangle"></i> Tem certeza que deseja Fecha o Caixa ?</p>							
	</div>
	<div class="border-top p-2 px-0 d-flex">
		<a href="{{route('caixa.index')}}" class="btn btn-verde"><i class="fas fa-check"></i> Sim</a>							
		<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho ml-1"><i class="fas fa-times"></i> Não</a>							
	</div>	
</div>

<!--Desconto acrescimo-->
<div class="window pdv" id="verTelaQtdeDesconto">
<span class="fechar">X</span>	
<h4 class="d-block text-center pb-1 border-bottom mb-2">Qtde e Desconto</h4>
	<div class="rows">
		<div class="col-4">
			<label class="text-label">Quantidade</label>			
			<input type="text" id="qtde_produto_antecipado"  class="form-campo mascara-float">
		</div>
		
		<div class="col-4">
			<label class="text-label">Tipo Desconto</label>			
			<select id="tipo_desconto_item_antecipado" class="form-campo">
				<option value="desc_perc">Porcentagem(%)</option>
				<option value="desc_valor">Valor(R$)</option>				
			</select>
		</div>	
		<div class="col-4">
			<label class="text-label">Desconto</label>			
			<input type="text" id="valor_desconto_item_antecipado" val="0"  class="form-campo mascara-float">
		</div>
		
	
		
		<div class="text-right base-botoes radius-0 mt-0 p-1">	
				<a href="javascript:;" onclick="limparDesconto()" class="btn btn-vermelho d-inline-block">Cancelar</a>					
				<a href="javascript:;" onclick="confirmarQtdeDesconto()" class="btn btn-verde d-inline-block">Confirmar</a>
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

</section>
<script>
	var TIPO_BUSCA ="{{$caixa->num_pdv->padrao_busca}}"	
</script>
@endsection
<div id="fundo_preto"></div>