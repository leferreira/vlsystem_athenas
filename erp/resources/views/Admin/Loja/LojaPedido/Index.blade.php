@extends("Admin.template")
@section("conteudo")
<div class="col-12 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de pedidos da Loja Virtual </span>
						
					</div>
                        
					<form name="busca" action="{{route('admin.venda.filtro')}}" method="get">                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data 1</label>
                                            <input type="date" name="data1" value="{{$filtro->data1 ?? null}}" class="form-campo">
                                        </div>
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data 2</label>
                                            <input type="date" name="data2" value="{{$filtro->data2 ?? null}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Status da Venda</label>
                                            <select class="form-campo" name="status_id">
                                            <option value="">Selecione</option>
                                            @foreach($status as $s)
												<option value="{{$s->id}}" {{( $filtro->status_id ?? null)==$s->id ? 'selected' : null}}>{{$s->status}}</option>
											@endforeach
											</select>
                                        </div>
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Status Financeiro</label>
                                            <select class="form-campo" name="status_financeiro_id">
                                            <option value="">Selecione</option>
                                            @foreach($status_financeiro as $s)
												<option value="{{$s->id}}" {{($filtro->status_financeiro_id ?? null)==$s->id ? 'selected' : null}}>{{$s->status}}</option>
											@endforeach
											</select>
                                        </div>
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="Pesquisar" class="btn btn-roxo text-uppercase">
                                        </div>
                                </div>
                                </div>
                        </div>
                    </form>
                </div>
                </div>

		<div class="col-12">

				<div class="px-2">
					<div class="rows">
					<div class="col">
						<div class="tabela-responsiva pb-4">
						<table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
								<thead>
								 <tr>
										<th align="center">Id</th>
                                        <th align="left">Cliente</th>
                                        <th align="center">Data</th>
                                        <th align="center">Forma de Pagamento</th>
                                        <th align="center">Status</th>
                                        <th align="center">Status Financeiro</th>
                                        <th align="center">Valor</th>
                                        <th align="center">Frete</th>
                                        <th align="center">Desconto</th>
                                        <th align="center">Valor Líquido</th>
                                        <th align="center">Ação</th>
									</tr>
								</thead>
								<tbody>
							
								
								<?php $total = 0; ?>
                          		 @foreach($lista as $c)                                     
								 <tr>
									<td align="center">{{$c->id}}</td> 
									<td align="center">{{ substr($c->cliente->nome_razao_social ?? '', 0, 30)}}</td>
									<td align="center">{{ databr($c->data_pedido)}}</td>
									 <td align="center">{{($c->forma_pagamento) ? $c->forma_pagamento->forma_pagto  : '--'}}</td>
									 
									<td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>									
									<td align="center"><span class="{{ strtolower($c->status_financeiro->status) }}">{{ $c->status_financeiro->status }}</span></td>
									<td align="center">{{ $c->valor_venda  }}	</td>
								    <td align="center">{{ $c->valor_frete  }}	</td>
									<td align="center">{{ $c->valor_desconto  }}	</td>
									<td align="center">{{ $c->valor_liquido  }}	</td>
									<td align="right">
										<a href="javascript:;" onclick="abrir_opcoes_venda({{$c->id}})" ><i class="ellipsis-vertical"></i></a>
									</td>
								 </tr>
								 
							@endforeach  								
				 
							</tbody>
							 </table>
									
							</div>
						</div>						
						<!-- MOSTRA AS OPÇÕES  MostraOpcoes --->
						<div class="col-2 MostraOpcoes" id="opcoes_venda">
							<ul class="cx-opcoes" >
								<li>Venda:<span id="id_pedido"></span></li>
								
								<li class="nfe_off"><a href="javascript:;" onClick="abrirModalNaturezaOperacao()" title="Gerar Nota Fiscal"><i class="fas fa-scroll"></i> Gerar Nota Fiscal</a></li>
							<!--	<li class="nfe_off"><a href="javascript:;" onClick="abrirModalNaturezaOperacaoNFCE()" title="Gerar Nota Fiscal"><i class="fas fa-scroll"></i> Gerar NFCE</a></li>
								 --><li class="concreto"><a href="javascript:;" onclick="editarVenda()"><i class="fas fa-eye"></i> Ver/Editar</a></li>
								<li class="financeiro_on"><a href="javascript:;" onclick="verContaReceber()" class="" title="Visualizar Contas a Receber"><i class="fas fa-dollar-sign"></i> Ver Contas a Receber</a></li>
								<!--   <li class="estoque_on"><a href="javascript:;" onclick="estornarContaReceber()" class="" title="Estornar Estoque"><i class="fas fa-dollar-sign"></i> Estornar Contas a Receber</a></li>
								<li class="estoque_off"><a href="javascript:;" onclick="lancarEstoque()" class="" title="Lançar Estoque"><i class="fas fa-dollar-sign"></i> Lançar Estoque</a></li>
								<li class="estoque_on"><a href="javascript:;" onclick="estornarEstoque()" class="" title="Estornar Estoque"><i class="fas fa-dollar-sign"></i> Estornar Estoque</a></li>
								<li class="concreto"><a href="javascript:;" onClick="excluirVenda()" title="Excluir Venda"><i class="fas fa-file-pdf"></i> Excluir Venda</a></li>
								--><li class="concreto"><a href="javascript:;" onClick="fechar_opcoes_venda()" title="Fechar Opções"><i class="fas fa-file-pdf"></i> Fechar Opções</a></li>								
							
							</ul>
						</div>
						
						
					</div>
                </div>
			</div>
			
        </div>
</div>

        @endsection
		
<!--identificar cliente-->
<div class="window medio" id="modal_imprimir_nfe" style="padding:0!important">
<h4 class="d-block text-center pb-1 border-bottom mb-2 h4 p-3">Transmitir NFE</h4>
	<div class="p-2 text-center mt-2" id="giragira_venda">
		<img src="{{asset('assets/admin/img/load2.gif')}}" width="60" class="m-auto">
		<span class="text-cinza d-block mt-2 mb-2"> Aguarde carregando...</span>
	</div>
	
	<div class="p-2 text-center mt-2" id="div_retorno_negativo">
		<span class="msg msg-vermelho p-1 text-left">
			<span class="d-block text-center mb-0"> Erro: <b id="mensagem_erro_venda"></b></span>			
		</span>
	</div>	
	<div class="p-2 text-center mt-2" id="div_retorno_positivo">
		<span class="msg msg-verde p-1 text-left">
			<span class="d-block text-center mb-0"> Operação Realizada com Sucesso!!</span>			
		</span>
	</div>	
		
	<div class="text-right base-botoes radius-0 mt-0 p-1 border-top py-3 ">	
			<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho d-inline-block btn-medio"><i class="fas fa-times"></i> Fechar</a>
	</div>
</div>

<!--cancelar venda -->
<div class="window pdv medio" id="telaImprimirDanfe">	
	<div class="caixa mb-0 p-0">
	<span class="d-block text-center titulo pb-2 pt-2 h4 border-bottom mb-2 text-verde"><i class="fas fa-check"></i> Nfe Gerada Sucesso</span>
	<div class="p-2">
		<p class="h4 text-escuro text-center"><i class="fas fa-print"></i> Deseja imprimir o DANFE ?</p>							
	</div>
	<div class="tfooter center py-3">
		<a href="javascript:;" onclick="imprimirDanfe()" class="btn btn-verde"><i class="fas fa-check"></i> Sim</a>							
		<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho ml-1"><i class="fas fa-times"></i> Não</a>							
	</div>	
</div>
</div>

<div class="window menor" id="telaObservacao">
	<span class="tmodal msg msg-verde"><i class="fas fa-check"></i> <b>Observação</b></span>
	<div class="p-3 text-center">
		<p class="mb-3" id="obsVenda"></p>		 
	</div>
	
	<div class="tfooter end">
		<a href="" class="btn btn-neutro fechar p-0">Fechar</a> 
	</div>
</div>

<div class="window  medio" id="SelecionarNaturezaOperacional">
	<span class="d-block titulo mb-0"><i class="fas fa-plus-circle"></i> Gerar Nota Fiscal</span>
	
		<div class="p-3">
			<div class="rows">
                <div class="col-8">	
                    <label class="text-label d-block">Selecione a Natureza de Operação </label>
                    <select class="form-campo" id="natureza_operacao_id">
                		@foreach($naturezas as $natureza)
                			<option value="{{$natureza->id}}" {{$natureza->padrao==config('constantes.padrao_natureza.VENDA') ? 'selected' : ''}}>{{$natureza->descricao}}</option>
                		@endforeach
                	</select>
                </div> 
			</div>
		</div>
		<div class="tfooter end">
			<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho " >Cancelar</a>
            <input type="button"  onclick="salvarNfePeloPedidoLoja()" value="Gerar Nota Fiscal" class="btn btn-azul text-uppercase">
		</div>	

</div>

<div class="window  medio" id="SelecionarNaturezaOperacionalNFCE">
	<span class="d-block titulo mb-0"><i class="fas fa-plus-circle"></i> Gerar NFCE</span>
	
		<div class="p-3">
			<div class="rows">
                <div class="col-8">	
                    <label class="text-label d-block">Selecione a Natureza de Operação </label>
                    <select class="form-campo" id="natureza_operacao_id_nfce">
                		@foreach($naturezas as $natureza)
                			<option value="{{$natureza->id}}" {{$natureza->padrao==config('constantes.padrao_natureza.VENDA') ? 'selected' : ''}}>{{$natureza->descricao}}</option>
                		@endforeach
                	</select>
                </div> 
			</div>
		</div>
		<div class="tfooter end">
			<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho " >Cancelar</a>
            <input type="button"  onclick="salvarNfcePelaVenda()" value="Gerar NFCE" class="btn btn-azul text-uppercase">
		</div>	

</div>

<div class="window menor" id="telaCancelarVenda">
	<span class="tmodal msg msg-vermelho text-branco"><i class="fas fa-trash"></i> <b>Cancelar Venda</b></span>
	<div class="p-3 text-center">
		<p class="mb-3">Tem certeza que deseja cancelar esta venda ? </p>
	</div>
	
	<div class="tfooter end">
		<a href="" class="btn btn-vermelho fechar">Não</a> 
		<a href="javascript:;" onclick="cancelarVenda()" class="btn btn-verde">Sim</a> 
	</div>
</div>

<script>
var pedido_id = 0;
let venda_nova    = new Object(); 
function abrir_opcoes_venda(id){
	$("#id_pedido").html(id);
	pedido_id = id;
	mostrar_opcoes('opcoes_venda');
	
}

function buscarVenda(){
	alert(base_url + "admin/venda/buscar/" + pedido_id);
	$.ajax({
	   url: base_url + "admin/venda/buscar/" + pedido_id,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
		 	 venda_nova = data.retorno;		 	 
		}, error: function (e) {
			var response = e.responseText;	
			console.log(response.erro);			
		}
		
	});
}

function abrirModalNaturezaOperacao(){	
	abrirModal("#SelecionarNaturezaOperacional");
}

function salvarNfePeloPedidoLoja(){
	var natureza_id = $("#natureza_operacao_id").val();
	giraGira();
	location.href = base_url + "admin/notafiscal/salvarNfePorPedidoLoja/" + pedido_id + "/" + natureza_id ;	
}

function abrirModalNaturezaOperacaoNFCE(){	
	abrirModal("#SelecionarNaturezaOperacionalNFCE");
}

function salvarNfcePelaVenda(){
	var natureza_id = $("#natureza_operacao_id_nfce").val();
	giraGira();
	location.href = base_url + "admin/notafiscal/salvarNfcePelaVenda/" + pedido_id + "/" + natureza_id ;	
}

function fechar_opcoes_venda(){
	pedido_id = 0;
	esconder_opcoes('opcoes_venda');
}

function verObservacao(id){
	abrirModal("#telaObservacao");
	$("#obsVenda").html($("#obs_"+id).val());
}

function lancarEstoque(){
	giraGira();
	location.href = base_url + "admin/venda/lancarEstoque/" + pedido_id;	
}



function estornarEstoque(){
	if (confirm("Tem Certeza que deseja Estornar do Estoque ?") == true) {
      	giraGira();
		location.href = base_url + "admin/venda/estornarEstoque/" + pedido_id;
    }
		
}

function estornarContaReceber(){
	if (confirm("Tem Certeza que deseja Estornar o Financeiro ?") == true) {
      	giraGira();
		location.href = base_url + "admin/venda/estornarContaReceber/" + pedido_id;
    }
		
}

function cancelarVenda(){
	giraGira();
	location.href = base_url + "admin/venda/cancelarVenda/" + pedido_id;	
}

function verContaReceber(){
	giraGira();
	location.href = base_url + "admin/venda/financeiro/" + pedido_id;	
}

function verDetalhe(){
	giraGira();
	location.href = base_url + "admin/venda/detalhe/" + pedido_id;	
}

function verPdf(){
	giraGira();
	location.href = base_url + "admin/venda/pdf/" + pedido_id;	
}

function verCupom(){
	giraGira();
	location.href = base_url + "admin/venda/cupom/" + pedido_id;	
}

function clonarVenda(){
	giraGira();
	location.href = base_url + "admin/venda/clonarVenda/" + pedido_id;	
}

function editarVenda(){
	giraGira();
	location.href = base_url + "admin/lojapedido/" + pedido_id + "/edit";	
}

function excluirVenda(){
	if (confirm("Tem Certeza que deseja Excluir ?") == true) {
      	giraGira();
		location.href = base_url + "admin/venda/excluir/" + pedido_id;
    }	
}

function enviarPorEmail(){
	giraGira();
	location.href = base_url + "admin/venda/cupom/" + pedido_id;	
}

function enviarPorWhatsApp(){
	giraGira();
	location.href = base_url + "admin/venda/cupom/" + pedido_id;	
}




function transmitirNfePelaVenda(id_pedido){
	$("#id_pedido").val(id_pedido);
	$("#giragira_venda").show();
	$("#div_retorno_negativo").hide();
	$("#div_retorno_positivo").hide();
	abrirModal('#modal_imprimir_nfe');
	$.ajax({
		url: base_url + "admin/venda/gerarNfePelaVenda/" + id_pedido,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
		 	 $("#giragira_venda").hide();
		 	 if(data.tem_erro==true){
		 	 	$("#div_retorno_negativo").show();
		 	 	$("#mensagem_erro_venda").html(data.erro);
		 	 }
		 	 
		 	  if(data.tem_erro==false){
		 	 	abrirModal('#telaImprimirDanfe');
		 	 }
		}, error: function (e) {
			var response = e.responseText;	
			console.log(response.erro);			
		}
		
	});
	
}


function imprimirDanfe(id){
	id_pedido = (id) ? id : $("#id_pedido").val();	
	fecharModal();
	window.open(base_url + 'admin/nfe/imprimirDanfePelaVenda/'+id_pedido, '_blank');
	location.href = base_url + "admin/venda";	
}
</script>
