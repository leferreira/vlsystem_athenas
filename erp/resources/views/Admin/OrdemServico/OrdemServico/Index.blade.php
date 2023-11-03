@extends("Admin.template")
@section("conteudo")
<div class="col-12 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de Ordem Serviço </span>
						<div>
							<a href="{{route('admin.ordemservico.create')}}" class="btn btn-azul ml-1 d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
						
						</div>
					</div>
                        
					<form name="busca" action="{{route('admin.ordemservico.filtro')}}" method="get">                        
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
										<th align="center">Valor</th>
										<th align="center">Status Financeiro</th>
										<th align="center">Nota Gerada</th>
										<th class="text-right">Obs</th>
										<th class="text-right"></th>
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
									<td align="center">{{ databr($c->data_ordemservico)}}</td>
									
									<td align="center">{{ $c->valor_os  }}	</td>
									<td align="center"><span class="{{ strtolower($c->status_financeiro->status) }}">{{ $c->status_financeiro->status }}</span></td>
								    <td align="center">{{ isset($c->nfe) ? "Sim" : "Não"  }}	</td>
								
									<td align="right">	
											<input type="hidden" id="obs_{{$c->id}}" value="{{$c->observacao}}">																
											<a href="javascript:;" onclick="verObservacao({{$c->id}})" class="btn btn-verde d-inline-block" title="Observação"><i class="fas fa-edit"></i></a>
									</td>
									
									
									<td align="right">
										<a href="javascript:;" onclick="abrir_opcoes_ordemservico({{$c->id}})" ><i class="ellipsis-vertical"></i></a>
									</td>
								 </tr>
								 
							@endforeach  								
				 
							</tbody>
							 </table>
									
							</div>
						</div>						
						<!-- MOSTRA AS OPÇÕES  MostraOpcoes --->
						<div class="col-2 MostraOpcoes" id="opcoes_ordemservico">
							<ul class="cx-opcoes" >
								<li>Ordem de Serviço:<span id="id_ordemservico"></span></li>
								
								<li class="concreto"><a href="javascript:;" onclick="editarVenda()"><i class="fas fa-eye"></i> Ver/Editar</a></li>
							
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
	<div class="p-2 text-center mt-2" id="giragira_ordemservico">
		<img src="{{asset('assets/admin/img/load2.gif')}}" width="60" class="m-auto">
		<span class="text-cinza d-block mt-2 mb-2"> Aguarde carregando...</span>
	</div>
	
	<div class="p-2 text-center mt-2" id="div_retorno_negativo">
		<span class="msg msg-vermelho p-1 text-left">
			<span class="d-block text-center mb-0"> Erro: <b id="mensagem_erro_ordemservico"></b></span>			
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

<!--cancelar ordemservico -->
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
            <input type="button"  onclick="salvarNfePorVenda()" value="Gerar Nota Fiscal" class="btn btn-azul text-uppercase">
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
		<p class="mb-3">Tem certeza que deseja cancelar esta ordemservico ? </p>
	</div>
	
	<div class="tfooter end">
		<a href="" class="btn btn-vermelho fechar">Não</a> 
		<a href="javascript:;" onclick="cancelarVenda()" class="btn btn-verde">Sim</a> 
	</div>
</div>

<script>
var ordemservico_id = 0;
let ordemservico_nova    = new Object(); 
function abrir_opcoes_ordemservico(id){
	$("#id_ordemservico").html(id);
	ordemservico_id = id;
	mostrar_opcoes('opcoes_ordemservico');
	
}

function buscarVenda(){
	alert(base_url + "admin/ordemservico/buscar/" + ordemservico_id);
	$.ajax({
	   url: base_url + "admin/ordemservico/buscar/" + ordemservico_id,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
		 	 ordemservico_nova = data.retorno;		 	 
		}, error: function (e) {
			var response = e.responseText;	
			console.log(response.erro);			
		}
		
	});
}

function abrirModalNaturezaOperacao(){	
	abrirModal("#SelecionarNaturezaOperacional");
}

function salvarNfePorVenda(){
	var natureza_id = $("#natureza_operacao_id").val();
	giraGira();
	location.href = base_url + "admin/notafiscal/salvarNfePorVenda/" + ordemservico_id + "/" + natureza_id ;	
}

function abrirModalNaturezaOperacaoNFCE(){	
	abrirModal("#SelecionarNaturezaOperacionalNFCE");
}

function salvarNfcePelaVenda(){
	var natureza_id = $("#natureza_operacao_id_nfce").val();
	giraGira();
	location.href = base_url + "admin/notafiscal/salvarNfcePelaVenda/" + ordemservico_id + "/" + natureza_id ;	
}

function fechar_opcoes_ordemservico(){
	ordemservico_id = 0;
	esconder_opcoes('opcoes_ordemservico');
}

function verObservacao(id){
	abrirModal("#telaObservacao");
	$("#obsVenda").html($("#obs_"+id).val());
}

function lancarEstoque(){
	giraGira();
	location.href = base_url + "admin/ordemservico/lancarEstoque/" + ordemservico_id;	
}



function estornarEstoque(){
	if (confirm("Tem Certeza que deseja Estornar do Estoque ?") == true) {
      	giraGira();
		location.href = base_url + "admin/ordemservico/estornarEstoque/" + ordemservico_id;
    }
		
}

function estornarContaReceber(){
	if (confirm("Tem Certeza que deseja Estornar o Financeiro ?") == true) {
      	giraGira();
		location.href = base_url + "admin/ordemservico/estornarContaReceber/" + ordemservico_id;
    }
		
}

function cancelarVenda(){
	giraGira();
	location.href = base_url + "admin/ordemservico/cancelarVenda/" + ordemservico_id;	
}

function verContaReceber(){
	giraGira();
	location.href = base_url + "admin/ordemservico/financeiro/" + ordemservico_id;	
}

function verDetalhe(){
	giraGira();
	location.href = base_url + "admin/ordemservico/detalhe/" + ordemservico_id;	
}

function verPdf(){
	giraGira();
	location.href = base_url + "admin/ordemservico/pdf/" + ordemservico_id;	
}

function verCupom(){
	giraGira();
	location.href = base_url + "admin/ordemservico/cupom/" + ordemservico_id;	
}

function clonarVenda(){
	giraGira();
	location.href = base_url + "admin/ordemservico/clonarVenda/" + ordemservico_id;	
}

function editarVenda(){
	giraGira();
	location.href = base_url + "admin/ordemservico/" + ordemservico_id + "/edit";	
}

function excluirVenda(){
	if (confirm("Tem Certeza que deseja Excluir ?") == true) {
      	giraGira();
		location.href = base_url + "admin/ordemservico/excluir/" + ordemservico_id;
    }	
}

function enviarPorEmail(){
	giraGira();
	location.href = base_url + "admin/ordemservico/cupom/" + ordemservico_id;	
}

function enviarPorWhatsApp(){
	giraGira();
	location.href = base_url + "admin/ordemservico/cupom/" + ordemservico_id;	
}




function transmitirNfePelaVenda(id_ordemservico){
	$("#id_ordemservico").val(id_ordemservico);
	$("#giragira_ordemservico").show();
	$("#div_retorno_negativo").hide();
	$("#div_retorno_positivo").hide();
	abrirModal('#modal_imprimir_nfe');
	$.ajax({
		url: base_url + "admin/ordemservico/gerarNfePelaVenda/" + id_ordemservico,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
		 	 $("#giragira_ordemservico").hide();
		 	 if(data.tem_erro==true){
		 	 	$("#div_retorno_negativo").show();
		 	 	$("#mensagem_erro_ordemservico").html(data.erro);
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
	id_ordemservico = (id) ? id : $("#id_ordemservico").val();	
	fecharModal();
	window.open(base_url + 'admin/nfe/imprimirDanfePelaVenda/'+id_ordemservico, '_blank');
	location.href = base_url + "admin/ordemservico";	
}
</script>
