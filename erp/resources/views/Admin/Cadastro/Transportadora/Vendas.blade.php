@extends("Admin.template")
@section("conteudo")
<div class="col-12 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de Vendas: {{$transportadora->razao_social}} </span>
						<div>
			<a href="{{route('admin.transportadora.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>							
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
		</div>
					</div>
                        
					
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
										<th align="center">Valor</th>
										<th align="center">Status Venda</th>
										<th align="center">Status Financeiro</th>
										<th align="center">Nota Gerada</th>
										<th class="text-right">Obs</th>
										<th class="text-right"></th>
										<th align="center">Opções</th>
									</tr>
								</thead>
								<tbody>							
								
								<?php $total = 0; ?>
							   @foreach($lista as $c)
							   @php
							   		$temNfe = isset($c->nfe) ? "S" : "N" ;
							   @endphp                                      
								 <tr>
									<td align="center">{{$c->id}} 
										<input type="hidden" id="nfe_{{$c->id}}" value="{{$c->enviou_nfe}}">										
										<input type="hidden" id="estoque_{{$c->id}}" value="{{$c->enviou_estoque}}">
									</td>
									<td align="center">{{substr($c->cliente->nome_razao_social, 0, 30)}}</td>
									<td align="center">{{ databr($c->data_venda)}}</td>
									
									<td align="center">{{ $c->valor_venda  }}	</td>
									<td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>									
									<td align="center"><span class="{{ strtolower($c->status_financeiro->status) }}">{{ $c->status_financeiro->status }}</span></td>
								    <td align="center">{{ isset($c->nfe) ? "Sim" : "Não"  }}	</td>
								
									<td align="right">	
											<input type="hidden" id="obs_{{$c->id}}" value="{{$c->observacao}}">																
											<a href="javascript:;" onclick="verObservacao({{$c->id}})" class="btn btn-verde d-inline-block" title="Observação"><i class="fas fa-edit"></i></a>
									</td>
									
									
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
								<li>Venda:<span id="id_venda"></span></li>
								
								<li class="nfe_off"><a href="javascript:;" onClick="salvarNfePorVenda()" title="Gerar Nota Fiscal"><i class="fas fa-scroll"></i> Gerar Nota Fiscal</a></li>
								<li class="nfe_on"><a href="javascript:;" onClick="imprimirDanfe()" title="Imprimir Danfe"><i class="fas fa-file-pdf"></i> Visualizar DANFE</a></li>						
								
								<li class="financeiro_on"><a href="javascript:;" onclick="verContaReceber()" class="" title="Visualizar Contas a Receber"><i class="fas fa-dollar-sign"></i> Ver Contas a Receber</a></li>
									
								<li class="estoque_off"><a href="javascript:;" onclick="lancarEstoque()" class="" title="Visualizar Contas a Receber"><i class="fas fa-dollar-sign"></i> Lançar Estoque</a></li>
								<li class="estoque_on"><a href="javascript:;" onclick="estornarEstoque()" class="" title="Visualizar Contas a Receber"><i class="fas fa-dollar-sign"></i> Estornar Estoque</a></li>
								<li class="concreto"><a href="javascript:;" onclick="abrirModal('#telaCancelarVenda')" class="" title="Cancelar a Venda"><i class="fas fa-trash-alt"></i> Cancelar Venda</a></li>
								<li class="concreto"><a href="javascript:;" onclick="verDetalhe()"><i class="fas fa-eye"></i> Ver Detalhes</a></li>
								<li class="concreto"><a href="javascript:;" onclick="verPdf()" title="Gerar PDF"><i class="fas fa-file-pdf"></i> Visualizar PDF</a></li>
								<li class="concreto"><a href="javascript:;" onclick="verCupom()" title="Imprimir Cupom"><i class="fas fa-print"></i> Visualizar cupom</a></li>
							  	<li class="concreto"><a href="javascript:;" onClick="clonarVenda()" title="Clonar Venda"><i class="fas fa-file-pdf"></i> Clonar Venda</a></li>
								<!-- ><li class="concreto"><a href="javascript:;" onClick="enviarPorEmail()" title="Enviar por Email"><i class="fas fa-file-pdf"></i> Enviar por Email</a></li>								
								<li class="concreto"><a href="javascript:;" onClick="enviarPorEmail()" title="Enviar por WhatsApp"><i class="fas fa-file-pdf"></i> Enviar por Whatsapp</a></li>								
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
var venda_id = 0;
function abrir_opcoes_venda(id){
	var status_id 	= $("#status_"+id).val();
	var nfe 		= $("#nfe_"+id).val();
	var estoque		= $("#estoque_"+id).val();
	var financeiro	= $("#financeiro_"+id).val();	
	
	$("#id_venda").html(id);
	venda_id = id;
	mostrar_opcoes('opcoes_venda');
	
	if(nfe=='S' ){
		$(".nfe_on").show();
		$(".nfe_off").hide();
	}else if(nfe=='N' ){
		$(".nfe_on").hide();
		$(".nfe_off").show();
	}
	
	if(estoque=='S' ){
		$(".estoque_on").show();
		$(".estoque_off").hide();
	}else if(estoque=='N' ){
		$(".estoque_on").hide();
		$(".estoque_off").show();
	}	
	
}

function fechar_opcoes_venda(){
	venda_id = 0;
	esconder_opcoes('opcoes_venda');
}

function verObservacao(id){
	abrirModal("#telaObservacao");
	$("#obsVenda").html($("#obs_"+id).val());
}

function lancarEstoque(){
	giraGira();
	location.href = base_url + "admin/venda/lancarEstoque/" + venda_id;	
}

function estornarEstoque(){
	giraGira();
	location.href = base_url + "admin/venda/estornarEstoque/" + venda_id;	
}

function cancelarVenda(){
	giraGira();
	location.href = base_url + "admin/venda/cancelarVenda/" + venda_id;	
}

function verContaReceber(){
	giraGira();
	location.href = base_url + "admin/venda/financeiro/" + venda_id;	
}

function verDetalhe(){
	giraGira();
	location.href = base_url + "admin/venda/detalhe/" + venda_id;	
}

function verPdf(){
	giraGira();
	location.href = base_url + "admin/venda/pdf/" + venda_id;	
}

function verCupom(){
	giraGira();
	location.href = base_url + "admin/venda/cupom/" + venda_id;	
}

function clonarVenda(){
	giraGira();
	location.href = base_url + "admin/venda/clonarVenda/" + venda_id;	
}

function enviarPorEmail(){
	giraGira();
	location.href = base_url + "admin/venda/cupom/" + venda_id;	
}

function enviarPorWhatsApp(){
	giraGira();
	location.href = base_url + "admin/venda/cupom/" + venda_id;	
}

function salvarNfePorVenda(){
	giraGira();
	location.href = base_url + "admin/notafiscal/salvarNfePorVenda/" + venda_id;	
}

function transmitirNfePelaVenda(id_venda){
	$("#id_venda").val(id_venda);
	$("#giragira_venda").show();
	$("#div_retorno_negativo").hide();
	$("#div_retorno_positivo").hide();
	abrirModal('#modal_imprimir_nfe');
	$.ajax({
		url: base_url + "admin/venda/gerarNfePelaVenda/" + id_venda,
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
	id_venda = (id) ? id : $("#id_venda").val();	
	fecharModal();
	window.open(base_url + 'admin/nfe/imprimirDanfePelaVenda/'+id_venda, '_blank');
	location.href = base_url + "admin/venda";	
}
</script>
