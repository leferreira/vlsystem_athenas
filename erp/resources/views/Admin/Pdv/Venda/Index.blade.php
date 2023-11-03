@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de Vendas - PDV</span>
						<div>
							<!-- <a href="{{route('admin.pdvvenda.create')}}" class="btn btn-azul ml-1 d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
						 -->
							<a href="" class="btn btn-laranja filtro ml-1 d-inline-block" title="Filtrar"><i class="fas fa-filter"></i> </a>
						</div>
					</div>
                        
					<form name="busca" action="{{route('admin.pdvvenda.filtro')}}" method="get">                        
                        <div class="px-2 pt-2">
							  <div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data 1</label>
                                            <input type="date" name="data1" value="{{$filtro->data1 ?? null}}" class="form-campo">
                                        </div>
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data 2</label>
                                            <input type="date" name="data2" value="{{$filtro->data2 ?? null}}" class="form-campo">
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
                                    <th align="center">Data</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Desconto</th>
                                    <th align="center">Líquido</th>
                                    <th align="center">Cliente</th>
                                    <th align="center">Status</th>
                                    <th class="text-right"></th>
									</tr>
								</thead>
								<tbody>
							
								
								<?php $total = 0; ?>
							   @foreach($lista as $c)                                      
								 <tr>
									<td align="center">{{$c->id}} 
										<input type="hidden" id="nfe_{{$c->id}}" value="{{$c->enviou_nfe}}">										
										<input type="hidden" id="estoque_{{$c->id}}" value="{{$c->enviou_estoque}}">
									</td>
									<td align="center">{{ databr($c->data_venda)}}</td>                                
                                    <td align="center">{{ $c->valor_total  }}	</td>
                                    <td align="center">{{ $c->valor_desconto  }}	</td>
                                    <td align="center">{{ $c->valor_liquido  }}	</td>
                                    <td align="center">{{ $c->cliente_nome}}</td>
									<td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>	
									
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
								<li class="nfe_off"><a href="javascript:;" onClick="abrirModalNaturezaOperacao()" title="Gerar Nota Fiscal"><i class="fas fa-scroll"></i> Gerar NFCE</a></li>
								<li class="concreto"><a href="javascript:;" onclick="editarVenda()"><i class="fas fa-eye"></i> Ver/Editar</a></li>
								<li class="nfe_off"><a href="javascript:;" onClick="verDetalhes()" title="Gerar Nota Fiscal"><i class="fas fa-scroll"></i> Visualizar Detalhes</a></li>
								<li class="nfe_on"><a href="javascript:;" onClick="imprimirDanfce()" title="Imprimir Danfe"><i class="fas fa-file-pdf"></i> Visualizar DANFCE</a></li>						
								
								<!--  <li class="financeiro_on"><a href="javascript:;" onclick="verContaReceber()" class="" title="Visualizar Contas a Receber"><i class="fas fa-dollar-sign"></i> Ver Contas a Receber</a></li>
									
								<li class="estoque_off"><a href="javascript:;" onclick="lancarEstoque()" class="" title="Visualizar Contas a Receber"><i class="fas fa-dollar-sign"></i> Lançar Estoque</a></li>
								<li class="estoque_on"><a href="javascript:;" onclick="estornarEstoque()" class="" title="Visualizar Contas a Receber"><i class="fas fa-dollar-sign"></i> Estornar Estoque</a></li>
								<li class="concreto"><a href="javascript:;" onclick="abrirModal('#telaCancelarVenda')" class="" title="Cancelar a Venda"><i class="fas fa-trash-alt"></i> Cancelar Venda</a></li>
								<li class="concreto"><a href="javascript:;" onclick="verDetalhe()"><i class="fas fa-eye"></i> Ver Detalhes</a></li>
								<li class="concreto"><a href="javascript:;" onclick="verPdf()" title="Gerar PDF"><i class="fas fa-file-pdf"></i> Visualizar PDF</a></li>
								<li class="concreto"><a href="javascript:;" onclick="verCupom()" title="Imprimir Cupom"><i class="fas fa-print"></i> Visualizar cupom</a></li>
							  	<li class="concreto"><a href="javascript:;" onClick="clonarVenda()" title="Clonar Venda"><i class="fas fa-file-pdf"></i> Clonar Venda</a></li>
								<li class="concreto"><a href="javascript:;" onClick="enviarPorEmail()" title="Enviar por Email"><i class="fas fa-file-pdf"></i> Enviar por Email</a></li>								
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

<div class="window  medio" id="SelecionarNaturezaOperacional">
	<span class="d-block titulo mb-0"><i class="fas fa-plus-circle"></i> Gerar NFCE</span>
	
		<div class="p-3">
			<div class="rows">
                <div class="col-8">	
                    <label class="text-label d-block">Selecione a Natureza de Operação </label>
                    <select class="form-campo" id="natureza_operacao_id">
                		@foreach($naturezas as $natureza)
                			<option value="{{$natureza->id}}" {{$natureza->padrao==config('constantes.padrao_natureza.PDV') ? 'selected' : ''}}>{{$natureza->descricao}}</option>
                		@endforeach
                	</select>
                </div> 
			</div>
		</div>
		<div class="tfooter end">
			<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho " >Cancelar</a>
            <input type="button"  onclick="salvarNfcePorPdvVenda()" value="Gerar Nota Fiscal" class="btn btn-azul text-uppercase">
		</div>	

</div>

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

function abrirModalNaturezaOperacao(){	
	abrirModal("#SelecionarNaturezaOperacional");
}

function salvarNfcePorPdvVenda(){
	var natureza_id = $("#natureza_operacao_id").val();
	giraGira();
	location.href = base_url + "admin/pdvvenda/salvarNfcePorPdvVenda/" + venda_id + "/" + natureza_id ;	
}

function editarVenda(){
	giraGira();
	location.href = base_url + "admin/pdvvenda/edit/" + venda_id;	
}

function verDetalhes(){
	giraGira();
	location.href = base_url + "admin/pdvvenda/" + venda_id;	
}

function imprimirDanfce(){	
	fecharModal();
	window.open(base_url + 'admin/nfce/imprimirDanfcePelaVenda/'+ venda_id , '_blank');
	location.href = base_url + "admin/pdvvenda";	
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