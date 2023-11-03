@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
					<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de NFEs </span>
						<div>
						<!--  	<a href="{{route('admin.compra.create')}}" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Adicionar novo</a>
						-->	<a href="" class="btn btn-laranja filtro mx-1 d-inline-block"><i class="fas fa-filter"></i> Filtrar</a>
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

		<div class="col-12">
            <div class="px-2">
                    <div class="tabela-responsiva pb-4">
                    <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                             <tr>
                                    <th align="center" width="10">Id</th>
                                    <th align="left">Cliente</th>
                                    <th align="center">Data</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Status</th>
                                    <th align="center" width="300">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total = 0; ?>
                           @foreach($lista as $c) 
                           	@if($c->status_id == config("constantes.status.AUTORIZADO") || $c->status_id == config("constantes.status.CANCELADO"))                                     
                             <tr>
                                <td align="center">{{$c->id}}</td>
                                <td align="center">{{substr($c->venda->cliente->nome_razao_social, 0, 30)}}</td>
                                <td align="center">{{ databr(dataNfe($c->dhEmi))}}</td>                                
                                <td align="center">{{ formataNumero($c->vNF)  }}	</td>    
                                <td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>

                                <td align="center"> 
                                 		<a href="javascript:;" onclick="imprimirDanfe({{$c->id}})" class="btn btn-azul d-inline-block" title="Imprimir Danfe"><i class="fas fa-print"></i></a>
                                 		<a href="javascript:;" onclick="baixarXmlNfe({{$c->id}})" class="btn btn-azul d-inline-block" title="Baixar XML"><i class="fas fa-download"></i></a>
                                 		<a href="javascript:;" onclick="baixarPdfNfe({{$c->id}})" class="btn btn-azul d-inline-block" title="Baixar PDF"><i class="fas fa-file-pdf"></i></a>
                                 		<a href="javascript:;" onclick="telaCorrecao({{$c->id}})" class="btn btn-azul d-inline-block" title="Carta Correção"><i class="fas fa-clipboard-check"></i></a>
                                 		<a href="javascript:;" onclick="telaCancelamento({{$c->id}})"  class="btn btn-azul d-inline-block" title="Cancelar NFE"><i class="fas fa-times"></i></a>
                                 		<a href="javascript:;" onclick="telaEmail({{$c->id}})" class="btn btn-azul d-inline-block" title="Enviar Email"><i class="fas fa-envelope"></i></a>
                                 	</td>					   
                              </tr>	
                              @else
                              	<tr>
                                <td align="center">{{$c->id}}</td>
                                <td align="center">{{substr($c->venda->cliente->nome_razao_social, 0, 30)}}</td>
                                <td align="center">{{ databr(dataNfe($c->dhEmi))}}</td>                                
                                <td align="center">{{ formataNumero($c->vNF)  }}	</td>    
                                <td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>

                                <td align="center"> 
										<a href="{{route('admin.notafiscal.edit', $c->id)}}" class="btn btn-verde d-inline-block" title="Editar"><i class="fas fa-edit"></i></a>
                                 		<a href="javascript:;" onclick="telaEmail({{$c->id}})" class="btn btn-azul d-inline-block" title="Enviar Email"><i class="fas fa-envelope"></i></a>
                                 	</td>					   
                              </tr>
                              @endif					 
							@endforeach
							
                             						 
                        </tbody>
                                </table>
								
                        </div>

                        </div>

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


<script>
function imprimirDanfe(id_nfe){	
	giraGira();
	window.open(base_url + 'admin/nfe/imprimirDanfePelaNfe/'+id_nfe, '_blank');
	location.href = base_url + "admin/notafiscal";	
}

function baixarXmlNfe(id_nfe){
	$("#gira_gira_opcoes").show(); 
	window.location.href= base_url + "admin/nfe/baixarXML/" + id_nfe;
	//$("#gira_gira_opcoes").hide();
}

function baixarPdfNfe(id_nfe){
	$("#gira_gira_opcoes").show(); 
	window.location.href= base_url + "admin/nfe/baixarPdf/" + id_nfe;
	//$("#gira_gira_opcoes").hide();
}

function telaCorrecao(id_nfe){
	$("#id_nfe").val(id_nfe);
	$("#gira_gira_correcao").hide();
	$("#div_erro_correcao").hide();	
	
	abrirModal("#telaCorrecao");
}

function cartaCorrecao(){
	var id 			= $("#id_nfe").val();
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
		  		id: id,
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

function imprimirCce(id){
	id_nfe = (id) ? id : $("#id_nfe").val();	
	fecharModal();
	window.open(base_url + 'admin/nfe/imprimirCce/'+id_nfe, '_blank');
	location.href = base_url + "admin/notafiscal";	
}

function telaCancelamento(id_nfe){
	$("#id_nfe").val(id_nfe);
	$("#gira_gira_cancelamento").hide();
	$("#div_erro_cancelamento").hide();	
	
	abrirModal("#telaCancelamento");
}

function fazerCancelamento(){
	var id 			= $("#id_nfe").val();
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
		  		id: id,
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

function imprimirCancelamento(id){
	id_nfe = (id) ? id : $("#id_nfe").val();	
	fecharModal();
	window.open(base_url + 'admin/nfe/imprimircancelado/'+id_nfe, '_blank');
	location.href = base_url + "admin/notafiscal";	
}

function telaEmail(id_nfe){
	$("#id_nfe").val(id_nfe);
	$("#gira_gira_enviar_email").hide();
	$("#div_erro_email").hide();
	abrirModal("#telaEmail");
}

function enviarEmail(){
	  var id_nfe = $("#id_nfe").val();
	  var email = $("#email").val();
	  $("#div_erro_email").hide();
	  $("#gira_gira_enviar_email").show();
	 $.ajax({
		  url: base_url + "admin/nfe/email",
		  type: "POST",
		  dataType: "json",
		  data:{
			id_nfe: id_nfe,
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


function verXml(id_nfe){
	 $.ajax({
		  url: base_url + "admin/nfe/verXML/" + id_nfe ,
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