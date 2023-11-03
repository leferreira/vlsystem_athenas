@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
					<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de NFCEs </span>
						<div>
							<a href="{{route('admin.notanfce.create')}}" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Adicionar novo</a>
							<a href="" class="btn btn-laranja filtro mx-1 d-inline-block"><i class="fas fa-filter"></i> Filtrar</a>
						</div>
					</div>
                        
					<form name="busca" action="template_2.php?link=1" method="post">
                        
                        <div class="px-2 pt-2">
							  <div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Data 1</label>
                                            <input type="date" name="categoria" value="" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Data 2</label>
                                            <input type="date" name="categoria" value="" class="form-campo">
                                        </div>
                                        <div class="col-4">	
                                            <label class="text-label d-block text-branco">Status</label>
                                            <select class="form-campo">
												<option>Opção</option>
												<option>Opção</option>
												<option>Opção</option>
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

		<div class="col">
            <div class="px-2">
                    <div class="tabela-responsiva pb-4">
                    <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                             <tr>
                                    <th align="center" width="10">Id</th>
                                    <th align="center">Data</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Status</th>
                                    <th align="center" width="300">Opções</th>
                                    <th align="center"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total = 0; ?>
                           @foreach($lista as $c)                                      
                             <tr>
                                <td align="center">{{$c->id}}</td>
                                <td align="center">{{ databr(dataNfe($c->dhEmi))}}</td>
                                
                                <td align="center">{{ formataNumero($c->vNF)  }}	</td>
                                <td align="center"><span class="status status-azul">{{ $c->status->status}}</span></td>
                               
                                 <td align="center"> 
                                 		<a href="{{route('admin.nfce.transmitirPelaNfce', $c->id)}}" class="btn btn-azul d-inline-block" title="Imprimir NFE"><i class="far fa-share-square"></i></a>                             		                                
                                 
                                 		@if($c->status_id == config('constantes.status.AUTORIZADO'))
                                 		  <a href="javascript:;" onclick="modal_opcoes_nota({{$c->id}})" class="btn btn-azul d-inline-block" title="Opções NFce"><i class="fas fa-share-square "></i></a>
                                 		@else
                                 		  <a href="javascript:;" onclick="transmitir({{$c->id}})" class="btn btn-azul d-inline-block" title="Emitir da NFce"><i class="fas fa-paper-plane"></i></a>
                                 		@endif                                 		
                                 		<a href="{{route('admin.nfce.danfce', $c->id)}}" class="btn btn-azul d-inline-block" title="Imprimir NFE"><i class="far fa-share-square"></i></a>                             		                                
                                 		<a href="{{route('admin.nfce.baixarXML', $c->id)}}" class="btn btn-azul d-inline-block" title="Baixar XML"><i class="fas fa-eye"></i></a>
										<a href="{{route('admin.nfce.baixarPdf', $c->id)}}" class="btn btn-azul d-inline-block" title="Baixar PDF"><i class="fas fa-edit"></i></a>
										
										<a href="{{route('admin.notafiscal.excluir', $c->id)}}" class="btn btn-vermelho d-inline-block" title="Excluir"><i class="fas fa-trash"></i></a>
								   </td>
								   <td align="right"><a href="javascript:;" onclick="abrir_opcoes_nfce({{$c->id}})" ><i class="ellipsis-vertical"></i></a></td>					   
                              </tr>
                              					 
							@endforeach  
							
                             						 
                        </tbody>
                                </table>
								
                        </div>

                        </div>

                </div>
                	<div class="col-2 MostraOpcoes" id="opcoes_nfce">
							<ul class="cx-opcoes">
								<li>ID:<span id="id_nfce_"></span></li>
								<li class="edicao"><a href="javascript:;" onclick="transmitirNfe()" title="Transmitir Nota Fiscal"><i class="fas fa-scroll"></i> Transmitir Nota Fiscal</a></li>
								<li class="concreto"><a href="javascript:;" onclick="imprimirDanfce()" title="Gerar PDF"><i class="fas fa-file-pdf"></i> Visualizar PDF DANFE</a></li>
								<li class="concreto"><a href="javascript:;" onclick="baixarPdfNfe()" title="Imprimir NFe"><i class="fas fa-download"></i> Baixar PDF DANFE</a></li>
								<li class="concreto"><a href="javascript:;" onclick="baixarXmlNfe()"><i class="fas fa-download"></i> Baixar XML</a></li>
                                <li class="concreto"><a href="javascript:;" onclick="telaEmail()"><i class="fas fa-envelope"></i> Enviar por Email</a></li>
                                <li class="concreto"><a href="javascript:;" onclick="telaCancelamento()"><i class="fas fa-times"></i> Cancelar NFE</a></li>
                                <li class="concreto"><a href="javascript:;" onclick="telaCorrecao()"><i class="fas fa-clipboard-check"></i> Carta Correção</a></li>    
                                <li class="concreto"><a href="javascript:;" onclick="imprimirCce()"><i class="fas fa-download"></i> Ver Carta Correção</a></li>                            
                                <li class="concreto"><a href="javascript:;" onclick="consultarNfe()"><i class="fas fa-eye"></i> Consultar NFE</a></li>
                                <li class="concreto"><a href="javascript:;" onclick="devolucaoVendaNfe()" title="Gerar Devolução"><i class="fas fa-print"></i> Gerar Devolução Venda</a></li> 
                                <li class="concreto"><a href="javascript:;" onclick="devolucaoVendaCompra()" title="Gerar Devolução"><i class="fas fa-print"></i> Gerar Devolução Compra</a></li>
                                <li class="concreto"><a href="javascript:;" onclick="telaCorrecao()"><i class="fas fa-eye"></i> Nfe Complementar</a></li>
								<li class="edicao"><a href="javascript:;" onclick="editarNfe()" title="Editar Nota Fiscal"><i class="fas fa-scroll"></i> Editar</a></li>
								<li class="edicao"><a href="javascript:;" onclick="excluirNfe()" title="Excluir Nota Fiscal"><i class="fas fa-scroll"></i> Excluir</a></li>
								<li ><a href="javascript:;" onClick="fechar_opcoes_nfce()" title="Fechar Opções"><i class="fas fa-file-pdf"></i> Fechar Opções</a></li>									
							</ul>
					</div>
				

        </div>
</div>
<div class="window medio" id="enviarNfe">
	<div class="titulo d-flex justify-content-space-between"><b id="titulo_erro">Enviando NFE</b> <a href="" class="fechar text-vermelho">X</a></div>
	<div class="p-2 text-center mt-2">
    	<div id="gira_gira_envio">
    		<img src="{{asset('assets/admin/img/load2.gif')}}" width="60" class="m-auto">
    		<span class="text-cinza d-block mt-2 mb-2"> Aguarde Enviando...</span>
    	</div>
		<span class="msg msg-vermelho p-1" id="div_erro" >
			<i class="fas fa-bug"></i> <b id="erro_nota"></b>
		</span>
	</div>
	<div class="tfooter center" id="opcoes_nota">
		<a href="danfce()" class="btn btn-azul btn-pequeno">Imprimir NFCE</a>
		<a href="" class="btn btn-azul btn-pequeno">Outros </a>
		<a href="" class="btn btn-azul btn-pequeno">Outros </a>
		<a href="" class="btn btn-azul btn-pequeno">Outros </a>
	</div>
</div>


<div class="window medio" id="modal_opcoes_nota">
	<div class="titulo d-flex justify-content-space-between">Escolha uma Opção <a href="" class="fechar text-vermelho">X</a></div>
	<div class="p-2 text-center mt-2">
		<div id="gira_gira_opcoes">
    		<img src="{{asset('assets/admin/img/load2.gif')}}" width="60" class="m-auto">
    		<span class="text-cinza d-block mt-2 mb-2"> Aguarde Enviando...</span>
    	</div>
		<span class="msg msg-vermelho p-1" id="div_erro_opcoes" >
			<i class="fas fa-bug"></i> <b id="erro_nota_opcoes"></b>
		</span>
		<form name="correcao"  action="{{route('admin.nfce.email')}}" method="Post">
		@csrf
		<div class="rows" id="verEmail">			
			<div class="col-12">						
				<div class="rows">	
					<div class="col-3 mb-3 px-0">
						<input type="text" name="email" id="email" value="testesmjailton@gmail.com" class="form-campo" placeholder="Insira o Email">
					</div>
					<div class="col-3 mb-3">
						<input type="submit"  class="btn btn-verde btn-medio width-100" value="Enviar Email" />
						<input type="hidden" id="id_nfce" name="id_nfce">
					</div>
				</div>
			</div>			
		 </div>
		</form>			
					
	</div>
	<div class="tfooter center">
		<a href="javascript:;" onclick="danfce()" class="btn btn-azul btn-pequeno">Imprimir NFCE</a>
		<a href="javascript:;" onclick="baixarXml()" class="btn btn-azul btn-pequeno">Baixar XML </a>
		<a href="javascript:;" onclick="baixarPdf()" class="btn btn-azul btn-pequeno">Baixar PDF</a>
		<a href="" class="btn btn-azul btn-pequeno">Cancelar NFCE</a>		
		<a href="javascript:;" onclick="verEmail()" class="btn btn-azul btn-pequeno">Enviar Email</a>		
	</div>
</div>

<script>
var nfce_id = 0;
function abrir_opcoes_nfce(id){
	var status_id = $("#status_"+id).val();
	$("#id_nfce_").html(id);	
	$("#id_nfce").val(id_nfce);
	nfce_id = id;
	
	mostrar_opcoes('opcoes_nfce');
	if(status_id==4 || status_id==17 ){
		$(".edicao").hide();
		$(".concreto").show();
	}else{
		$(".edicao").show();
		$(".concreto").hide();
	}	
}

function fechar_opcoes_nfce(){
	esconder_opcoes('opcoes_nfce');
}

function imprimirDanfce(){	
	giraGira();
	window.open(base_url + 'admin/nfce/imprimirDanfcePelaNfe/'+nfce_id, '_blank');
	location.reload();	
}

function fecharModalDanfce(){
	location.reload();
}
function editarNfe(){
	giraGira();
	location.href = base_url + "admin/notafiscal/edit/" + nfce_id;	
}

function devolucaoVendaNfe(){
	giraGira();
	location.href = base_url + "admin/notafiscal/devolucaoVenda/" + nfce_id;	
}
function excluirNfe(){
	giraGira();
	location.href = base_url + "admin/notafiscal/excluir/" + nfce_id;	
}
function baixarXmlNfe(){
	$("#gira_gira_opcoes").show(); 
	window.location.href= base_url + "admin/nfce/baixarXML/" + nfce_id;
	//$("#gira_gira_opcoes").hide();
}

function baixarPdfNfe(){
	$("#gira_gira_opcoes").show(); 
	window.location.href= base_url + "admin/nfce/baixarPdf/" + nfce_id;
	//$("#gira_gira_opcoes").hide();
}

function consultarNfe(){
	$("#gira_gira_opcoes").show(); 
	window.open(base_url + 'admin/nfce/consultarNfe/'+ nfce_id, '_blank');
	location.reload();
	$("#gira_gira_opcoes").hide();
}

function telaCorrecao(){
	$("#gira_gira_correcao").hide();
	$("#div_erro_correcao").hide();	
	
	abrirModal("#telaCorrecao");
}

function transmitirNfe(){
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
		 	 	abrirModal('#telaImprimirDanfce');
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
		  url: base_url + "admin/nfce/cartaCorrecao" ,
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
	window.open(base_url + 'admin/nfce/imprimirCce/'+nfce_id, '_blank');
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
		  url: base_url + "admin/nfce/cancelarNfe" ,
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
	window.open(base_url + 'admin/nfce/imprimircancelado/'+nfce_id, '_blank');
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
		  url: base_url + "admin/nfce/email",
		  type: "POST",
		  dataType: "json",
		  data:{
			id_nfce: nfce_id,
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
		  url: base_url + "admin/nfce/verXML/" + nfce_id ,
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