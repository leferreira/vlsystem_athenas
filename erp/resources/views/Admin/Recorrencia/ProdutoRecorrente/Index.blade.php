@extends("Admin.template")
@section("conteudo")
<div class="col-12 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de Recorrências </span>
						<div>
							<a href="{{route('admin.produtorecorrente.create')}}" class="btn btn-azul ml-1 d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
						
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
										<th align="left">Descrição</th>
										<th align="center">Valor Produto</th>
										<th align="center">Valor Serviço</th>
										<th align="center">Valor recorrência</th>
										<th class="text-right"></th>
									</tr>
								</thead>
								<tbody>
							
								
								<?php $total = 0; ?>
							   @foreach($lista as $c)
							                                    
								 <tr>
									<td align="center">{{$c->id}}</td>
									<td align="center">{{$c->descricao}}</td>
									<td align="center">{{$c->valor_produto}}</td>
									<td align="center">{{$c->valor_servico}}</td>
									<td align="center">{{ $c->valor }}	</td>
																	
									
									<td align="right">
										<a href="javascript:;" onclick="abrir_opcoes_produtorecorrente({{$c->id}})" ><i class="ellipsis-vertical"></i></a>
									</td>
								 </tr>
								 
							@endforeach  								
				 
							</tbody>
							 </table>
									
							</div>
						</div>						
						<!-- MOSTRA AS OPÇÕES  MostraOpcoes --->
						<div class="col-2 MostraOpcoes" id="opcoes_produtorecorrente">
							<ul class="cx-opcoes" >
								<li>Ordem de Serviço:<span id="id_produtorecorrente"></span></li>
								
								<li class="concreto"><a href="javascript:;" onclick="editarVenda()"><i class="fas fa-eye"></i> Ver/Editar</a></li>
							
							</ul>
						</div>
						
						
					</div>
                </div>
			</div>
			
        </div>
</div>

        @endsection
		


<script>
var produtorecorrente_id = 0;
let produtorecorrente_nova    = new Object(); 
function abrir_opcoes_produtorecorrente(id){
	$("#id_produtorecorrente").html(id);
	produtorecorrente_id = id;
	mostrar_opcoes('opcoes_produtorecorrente');
	
}

function buscarVenda(){
	alert(base_url + "admin/produtorecorrente/buscar/" + produtorecorrente_id);
	$.ajax({
	   url: base_url + "admin/produtorecorrente/buscar/" + produtorecorrente_id,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
		 	 produtorecorrente_nova = data.retorno;		 	 
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
	location.href = base_url + "admin/notafiscal/salvarNfePorVenda/" + produtorecorrente_id + "/" + natureza_id ;	
}

function abrirModalNaturezaOperacaoNFCE(){	
	abrirModal("#SelecionarNaturezaOperacionalNFCE");
}

function salvarNfcePelaVenda(){
	var natureza_id = $("#natureza_operacao_id_nfce").val();
	giraGira();
	location.href = base_url + "admin/notafiscal/salvarNfcePelaVenda/" + produtorecorrente_id + "/" + natureza_id ;	
}

function fechar_opcoes_produtorecorrente(){
	produtorecorrente_id = 0;
	esconder_opcoes('opcoes_produtorecorrente');
}

function verObservacao(id){
	abrirModal("#telaObservacao");
	$("#obsVenda").html($("#obs_"+id).val());
}

function lancarEstoque(){
	giraGira();
	location.href = base_url + "admin/produtorecorrente/lancarEstoque/" + produtorecorrente_id;	
}



function estornarEstoque(){
	if (confirm("Tem Certeza que deseja Estornar do Estoque ?") == true) {
      	giraGira();
		location.href = base_url + "admin/produtorecorrente/estornarEstoque/" + produtorecorrente_id;
    }
		
}

function estornarContaReceber(){
	if (confirm("Tem Certeza que deseja Estornar o Financeiro ?") == true) {
      	giraGira();
		location.href = base_url + "admin/produtorecorrente/estornarContaReceber/" + produtorecorrente_id;
    }
		
}

function cancelarVenda(){
	giraGira();
	location.href = base_url + "admin/produtorecorrente/cancelarVenda/" + produtorecorrente_id;	
}

function verContaReceber(){
	giraGira();
	location.href = base_url + "admin/produtorecorrente/financeiro/" + produtorecorrente_id;	
}

function verDetalhe(){
	giraGira();
	location.href = base_url + "admin/produtorecorrente/detalhe/" + produtorecorrente_id;	
}

function verPdf(){
	giraGira();
	location.href = base_url + "admin/produtorecorrente/pdf/" + produtorecorrente_id;	
}

function verCupom(){
	giraGira();
	location.href = base_url + "admin/produtorecorrente/cupom/" + produtorecorrente_id;	
}

function clonarVenda(){
	giraGira();
	location.href = base_url + "admin/produtorecorrente/clonarVenda/" + produtorecorrente_id;	
}

function editarVenda(){
	giraGira();
	location.href = base_url + "admin/produtorecorrente/" + produtorecorrente_id + "/edit";	
}

function excluirVenda(){
	if (confirm("Tem Certeza que deseja Excluir ?") == true) {
      	giraGira();
		location.href = base_url + "admin/produtorecorrente/excluir/" + produtorecorrente_id;
    }	
}

function enviarPorEmail(){
	giraGira();
	location.href = base_url + "admin/produtorecorrente/cupom/" + produtorecorrente_id;	
}

function enviarPorWhatsApp(){
	giraGira();
	location.href = base_url + "admin/produtorecorrente/cupom/" + produtorecorrente_id;	
}




function transmitirNfePelaVenda(id_produtorecorrente){
	$("#id_produtorecorrente").val(id_produtorecorrente);
	$("#giragira_produtorecorrente").show();
	$("#div_retorno_negativo").hide();
	$("#div_retorno_positivo").hide();
	abrirModal('#modal_imprimir_nfe');
	$.ajax({
		url: base_url + "admin/produtorecorrente/gerarNfePelaVenda/" + id_produtorecorrente,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
		 	 $("#giragira_produtorecorrente").hide();
		 	 if(data.tem_erro==true){
		 	 	$("#div_retorno_negativo").show();
		 	 	$("#mensagem_erro_produtorecorrente").html(data.erro);
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
	id_produtorecorrente = (id) ? id : $("#id_produtorecorrente").val();	
	fecharModal();
	window.open(base_url + 'admin/nfe/imprimirDanfePelaVenda/'+id_produtorecorrente, '_blank');
	location.href = base_url + "admin/produtorecorrente";	
}
</script>
