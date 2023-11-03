@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
					<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de NFcEs </span>
						<!--  <div>
						  	<a href="{{route('admin.notanfce.create')}}" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Gerar Nova Nota</a>						
						</div>
						-->
					</div>
                        
					<form name="busca" action="{{route('admin.notafiscal.filtro')}}" method="get"> 
                        
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
                                            <label class="text-label d-block text-branco">Status da Nota</label>
                                            <select class="form-campo" name="status_id">
                                            <option value="">Selecione</option>
                                            @foreach($status as $s)
												<option value="{{$s->id}}" {{( $filtro->status_id ?? null)==$s->id ? 'selected' : null}}>{{$s->status}}</option>
											@endforeach
											</select>
                                        </div>
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Num Venda</label>
                                            <input type="text" name="venda_id" value="{{$filtro->venda_id ?? null}}" class="form-campo">
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
                                    <th align="center" width="10">Id</th>
                                    <th align="left">Núm Nota</th>
                                    <th align="left">Cliente</th>
                                    <th align="center">Data</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Status</th>
                                    <th align="center">Venda</th>
                                    <th align="center" ></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total = 0; ?>
                           @foreach($lista as $c) 
                             <tr>                             
                                <td align="center">{{$c->id}}<input type="hidden" id="status_{{$c->id}}" value="{{$c->status_id}}"></td>
                                <td align="center">{{ $c->nNF }}</td>   
                                <td align="center">{{isset($c->destinatario->dest_xNome) ? substr($c->destinatario->dest_xNome, 0, 30) : null}}</td>
                                <td align="center">{{ databr(dataNfe($c->dhEmi))}}</td>                                
                                <td align="center">{{ formataNumero($c->vNF)  }}	</td>    
                                <td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>
								<td align="center">{{ $c->venda_id  }}	</td>                            
                              	<td align="right"><a href="javascript:;" onclick="abrir_opcoes_nfe({{$c->id}})" ><i class="ellipsis-vertical"></i></a></td>
                              </tr>					 
							@endforeach							
                             						 
                        </tbody>
                                </table>
								
                        </div>
					</div>
					<div class="col-2 MostraOpcoes" id="opcoes_nfe">
							<ul class="cx-opcoes">
								<li>ID:<span id="id_nfe_"></span></li>
								<li class="edicao"><a href="javascript:;" onclick="transmitirNfce()" title="Transmitir Nota Fiscal"><i class="fas fa-scroll"></i> Transmitir Nota Fiscal</a></li>
								<li class="concreto"><a href="javascript:;" onclick="imprimirDanfce()" title="Gerar PDF"><i class="fas fa-file-pdf"></i> Visualizar PDF DANFE</a></li>
								<li class="concreto"><a href="javascript:;" onclick="baixarPdfNfce()" title="Imprimir NFe"><i class="fas fa-download"></i> Baixar PDF DANFE</a></li>
								<li class="concreto"><a href="javascript:;" onclick="baixarXmlNfce()"><i class="fas fa-download"></i> Baixar XML</a></li>
                             	<li class="edicao"><a href="javascript:;" onclick="editarNfce()" title="Editar Nota Fiscal"><i class="fas fa-scroll"></i> Editar</a></li>
								<li class="edicao"><a href="javascript:;" onclick="editarLivre()" title="Editar Nota Fiscal"><i class="fas fa-scroll"></i> Edição Livre</a></li>
								<li class="edicao"><a href="javascript:;" onclick="excluirNfe()" title="Excluir Nota Fiscal"><i class="fas fa-scroll"></i> Excluir</a></li>
								<li ><a href="javascript:;" onClick="fechar_opcoes_nfe()" title="Fechar Opções"><i class="fas fa-file-pdf"></i> Fechar Opções</a></li>									
							</ul>
					</div>
						
					</div>
                        </div>

                </div>
				
        </div>
</div>
<div class="window medio" id="modal_transferirNfe">
	<div class="titulo d-flex justify-content-space-between"><b id="titulo_erro">Transferir NFE</b> </div>
	<div class="p-2 text-center mt-2">
    	<div id="gira_gira_transferir">
    		<img src="{{asset('assets/admin/img/load2.gif')}}" width="60" class="m-auto">
    		<span class="text-cinza d-block mt-2 mb-2"> Aguarde Enviando...</span>
    	</div>    	
		 
		<span class="msg msg-vermelho p-1" id="div_erro_transferir" >
			<i class="fas fa-bug"></i> <b id="mensagem_erro_transferir"></b>
		</span>
		
		<div class="tfooter center" >
    		<a href="javaScript:;" onclick="fecharModal()" class="btn btn-vermelho btn-pequeno">Fechar</a>
    	</div>
	</div>
</div>

<div class="window medio" id="telaCorrecao">
	<div class="titulo d-flex justify-content-space-between"><b id="titulo_erro">Carta de Correção</b> </div>
	<div class="p-2 text-center mt-2">
    	<div id="gira_gira_correcao">
    		<img src="{{asset('assets/admin/img/load2.gif')}}" width="60" class="m-auto">
    		<span class="text-cinza d-block mt-2 mb-2"> Aguarde Enviando...</span>
    	</div>
    	<div class="rows" id="verCorrecao">			
			<div class="col-12">						
				<div class="rows">	
					<div class="col-12 mb-3 px-0 m-auto">
						<input type="text" required name="txtCorrecao" id="txtCorrecao" placeholder="Correção minimo de 15 caracteres"  class="form-campo"  >
					</div>
					
				</div>
			</div>			
		 </div>
		 
		<span class="msg msg-vermelho p-1" id="div_erro_correcao" >
			<i class="fas fa-bug"></i> <b id="mensagem_erro_correcao"></b>
		</span>
		
		<div class="tfooter center" >
		<a href="javaScript:;" onclick="cartaCorrecao()" class="btn btn-azul btn-pequeno">Fazer Correção</a>
    		<a href="javaScript:;" onclick="fecharModal()" class="btn btn-vermelho btn-pequeno">Fechar</a>
    	</div>
	</div>
</div>

<div class="window medio" id="telaCancelamento">
	<div class="titulo d-flex justify-content-space-between"><b id="titulo_erro">Cancelar NFE</b> </div>
	<div class="p-2 text-center mt-2">
    	<div id="gira_gira_cancelamento">
    		<img src="{{asset('assets/admin/img/load2.gif')}}" width="60" class="m-auto">
    		<span class="text-cinza d-block mt-2 mb-2"> Aguarde Enviando...</span>
    	</div>    	
		 <div class="rows" id="verCancelamento">			
			<div class="col-12">						
				<div class="rows">	
					<div class="col-12 mb-3 px-0 m-auto">
						<input type="text" required name="txtCancelamento" id="txtCancelamento" placeholder="Cancelamento minimo de 15 caracteres"  class="form-campo"  >
					</div>
					
				</div>
			</div>			
		 </div>
		
		<span class="msg msg-vermelho p-1" id="div_erro_cancelamento" >
			<i class="fas fa-bug"></i> <b id="mensagem_erro_cancelamento"></b>
		</span>
		
		<div class="tfooter center" >
    		<a href="javaScript:;" onclick="fazerCancelamento()" class="btn btn-azul btn-pequeno">Cancelar NFE</a>
    		<a href="javaScript:;" onclick="fecharModal()" class="btn btn-vermelho btn-pequeno">Fechar</a>
    	</div>
	</div>
</div>

<div class="window medio" id="telaEmail">
	<div class="titulo d-flex justify-content-space-between">Enviar Email </div>
	<div class="p-2 text-center mt-2">
		<div id="gira_gira_enviar_email">
    		<img src="{{asset('assets/admin/img/load2.gif')}}" width="60" class="m-auto">
    		<span class="text-cinza d-block mt-2 mb-2"> Aguarde Enviando...</span>
    	</div>
		<div class="rows" id="verEmail">			
			<div class="col-12">						
				<div class="rows">	
					<div class="col-9 m-auto pb-3">
						<input type="text" name="email" id="email"  class="form-campo" placeholder="Insira o Email">
					</div>
					<div class="col-3 mb-3">
						<input type="hidden" id="id_nfe" name="id_nfe">
						<input type="button" onclick="enviarEmail()" class="btn btn-verde btn-medio width-100" value="Enviar Email" />						
					</div>
				</div>
			</div>			
		 </div>
		 
		 <span class="msg msg-vermelho p-1" id="div_erro_email" >
			<i class="fas fa-bug"></i> <b id="mensagem_erro_email"></b>
		</span>
						
					
	</div>
	<div class="tfooter center">		
		<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho btn-pequeno">Fechar</a>		
	</div>
</div>



<div class="window pdv medio" id="telaImprimirCce">	
	<div class="caixa mb-0 p-0">
	<span class="d-block text-center titulo pb-2 pt-2 h4 border-bottom mb-2 text-verde"><i class="fas fa-check"></i> Carta de Correção Enviada com sucesso</span>
	<div class="p-2">
		<p class="h4 text-escuro text-center"><i class="fas fa-print"></i> Deseja imprimir  ?</p>							
	</div>
	<div class="tfooter center py-3">
		<a href="javascript:;" onclick="imprimirCce()" class="btn btn-verde"><i class="fas fa-check"></i> Sim</a>							
		<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho ml-1"><i class="fas fa-times"></i> Não</a>							
	</div>	
</div>
</div>

<div class="window pdv medio" id="telaImprimirCancelamento">	
	<div class="caixa mb-0 p-0">
	<span class="d-block text-center titulo pb-2 pt-2 h4 border-bottom mb-2 text-verde"><i class="fas fa-check"></i> Nota Cancelada com sucesso</span>
	<div class="p-2">
		<p class="h4 text-escuro text-center"><i class="fas fa-print"></i> Deseja imprimir  ?</p>							
	</div>
	<div class="tfooter center py-3">
		<a href="javascript:;" onclick="imprimirCancelamento()" class="btn btn-verde"><i class="fas fa-check"></i> Sim</a>							
		<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho ml-1"><i class="fas fa-times"></i> Não</a>							
	</div>	
</div>
</div>

<div class="window pdv medio" id="telaImprimirDanfe">	
	<div class="caixa mb-0 p-0">
	<span class="d-block text-center titulo pb-2 pt-2 h4 border-bottom mb-2 text-verde"><i class="fas fa-check"></i> Nfe Gerada Sucesso</span>
	<div class="p-2">
		<p class="h4 text-escuro text-center"><i class="fas fa-print"></i> Deseja imprimir o DANFE ?</p>							
	</div>
	<div class="tfooter center py-3">
		<a href="javascript:;" onclick="imprimirDanfce()" class="btn btn-verde"><i class="fas fa-check"></i> Sim</a>							
		<a href="javascript:;" onclick="fecharModalDanfe()" class="btn btn-vermelho ml-1"><i class="fas fa-times"></i> Não</a>							
	</div>	
</div>
</div>

<script>
var nfce_id = 0;
function abrir_opcoes_nfe(id){
	var status_id = $("#status_"+id).val();
	$("#id_nfe_").html(id);	
	$("#id_nfe").val(id_nfe);
	nfce_id = id;
	
	mostrar_opcoes('opcoes_nfe');
	if(status_id==4 || status_id==17 ){
		$(".edicao").hide();
		$(".concreto").show();
	}else{
		$(".edicao").show();
		$(".concreto").hide();
	}
	
}

function fechar_opcoes_nfe(){
	esconder_opcoes('opcoes_nfe');
}

function imprimirDanfce(){	
	giraGira();
	window.open(base_url + 'admin/nfce/danfce/'+nfce_id, '_blank');
	location.reload();	
}

function baixarPdfNfce(){
	$("#gira_gira_opcoes").show(); 
	window.location.href= base_url + "admin/nfce/baixarPdf/" + nfce_id;
	//$("#gira_gira_opcoes").hide();
}


function baixarXmlNfce(){
	$("#gira_gira_opcoes").show(); 
	window.location.href= base_url + "admin/nfce/baixarXML/" + nfce_id;
	$("#gira_gira_opcoes").hide();
}

function fecharModalDanfe(){
	location.reload();
}
function editarNfce(){
	giraGira();
	location.href = base_url + "admin/notanfce/edit/" + nfce_id;	
}

function editarLivre(){
	giraGira();
	location.href = base_url + "admin/notafiscal/edicaoLivre/" + nfce_id;	
}

function devolucaoVendaNfe(){
	giraGira();
	location.href = base_url + "admin/notafiscal/devolucaoVenda/" + nfce_id;	
}
function excluirNfe(){
	giraGira();
	location.href = base_url + "admin/notafiscal/excluir/" + nfce_id;	
}




function consultarNfe(){
	$("#gira_gira_opcoes").show(); 
	window.open(base_url + 'admin/nfe/consultarNfe/'+ nfce_id, '_blank');
	location.reload();
	$("#gira_gira_opcoes").hide();
}

function telaCorrecao(){
	$("#gira_gira_correcao").hide();
	$("#div_erro_correcao").hide();	
	
	abrirModal("#telaCorrecao");
}

function transmitirNfce(){
	$("#gira_gira_transferir").show();
	$("#div_erro_transferir").hide();
	$("#mensagem_erro_transferir").html(" ");
	abrirModal('#modal_transferirNfe');
	$.ajax({
	   url: base_url + "admin/nfce/transmitirJs/" + nfce_id,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
		 	 $("#gira_gira_transferir").hide();
		 	 if(data.tem_erro==true){
		 	 	$("#div_erro_transferir").show();
		 	 	$("#mensagem_erro_transferir").html(data.erro);
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

function cartaCorrecao(){
	var txtCorrecao = $("#txtCorrecao").val();
	if(txtCorrecao=='--'){
		alert("Digite algum valor");
		return false;
	}	
	if(txtCorrecao.length < 15){
		alert("O texto precisa ter pelo menos 15 caracteres");
		return false;
	}
	 $.ajax({
		  url: base_url + "admin/nfe/cartaCorrecao" ,
		  type: "Post",
		  dataType: "json",
		  data:{
		  		id: nfce_id,
		  		correcao: txtCorrecao
		  },
		  beforeSend: function () {
	        $("#gira_gira_correcao").show();
	     },
		  success: function (data){
		    $("#gira_gira_correcao").hide();
		 	 if(data.tem_erro==true){
		 	 	$("#div_erro_correcao").show();
		 	 	$("#mensagem_erro_correcao").html(data.erro);
		 	 }
		 	 
		 	  if(data.tem_erro==false){
		 	 	abrirModal('#telaImprimirCce');
		 	 }
		  }
	});	
}

function imprimirCce(){	
	fecharModal();
	window.open(base_url + 'admin/nfe/imprimirCce/'+nfce_id, '_blank');
	location.reload();	
}

function telaCancelamento(){
	$("#gira_gira_cancelamento").hide();
	$("#div_erro_cancelamento").hide();	
	
	abrirModal("#telaCancelamento");
}




function fazerCancelamento(){
	$("#div_erro_cancelamento").hide();
	$("#mensagem_erro_cancelamento").html(" ");
		 	 	
	var txtcancelamento = $("#txtCancelamento").val();
	if(txtcancelamento=='--'){
		alert("Digite algum valor");
		return false;
	}
	
	if(txtcancelamento.length < 15){
		alert("O texto precisa ter pelo menos 15 caracteres");
		return false;
	}
	 $.ajax({
		  url: base_url + "admin/nfe/cancelarNfe" ,
		  type: "Post",
		  dataType: "json",
		  data:{
		  		id: nfce_id,
		  		justificativa: txtcancelamento
		  },
		  beforeSend: function () {
	        $("#gira_gira_cancelamento").show();
	     },
		  success: function (data){
		    $("#gira_gira_cancelamento").hide();
		 	 if(data.tem_erro==true){		 	 	
		 	 	$("#div_erro_cancelamento").show();
		 	 	$("#mensagem_erro_cancelamento").html(data.erro);
		 	 }
		 	 
		 	  if(data.tem_erro==false){
		 	 	abrirModal('#telaImprimirCancelamento');
		 	 }
		  }
	});	
}

function imprimirCancelamento(){	
	fecharModal();
	window.open(base_url + 'admin/nfe/imprimircancelado/'+nfce_id, '_blank');
	location.reload();	
}

function telaEmail(){
	$("#gira_gira_enviar_email").hide();
	$("#div_erro_email").hide();
	abrirModal("#telaEmail");
}

function enviarEmail(){
	  var email = $("#email").val();
	  $("#div_erro_email").hide();
	  $("#gira_gira_enviar_email").show();
	 $.ajax({
		  url: base_url + "admin/nfe/email",
		  type: "POST",
		  dataType: "json",
		  data:{
			id_nfe: nfce_id,
			email: email
		},
		  beforeSend: function () {
			$("#div_erro_email").hide();
	        $("#gira_gira_enviar_email").show();
	     },
		  success: function (data){
		  console.log(data);
			  if(data.tem_erro==true){
				  $("#gira_gira_enviar_email").hide();
				  $("#div_erro_email").show();
				  $("#mensagem_erro_email").html(data.erro);
			  }
			  
			  if(data.tem_erro==false){
		 	 	alert("email enviado com sucesso");
		 	 	$("#gira_gira_enviar_email").hide();
		 	 }
		  },
	        error: function() {
				$("#div_erro_email").show();
	        } 
	});	
}


function verXml(){
	 $.ajax({
		  url: base_url + "admin/nfe/verXML/" + nfce_id ,
		  type: "GET",
		  dataType: "json",
		  data:{},
		  success: function (data){
			  if(data.tem_erro){
				  alert(data.erro);
			  }
		  }
	});	
}

</script>
@endsection