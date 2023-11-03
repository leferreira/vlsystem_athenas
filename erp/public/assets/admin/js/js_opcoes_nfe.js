$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});
$(function(){

});


function transmitir(id_nfe){
	 abrirModal("#enviarNfe"); 
	 
	 $.ajax({
		  url: base_url + "admin/nfe/transmitir/" + id_nfe,
		  type: "GET",
		  dataType: "json",
		  data:{},
		  beforeSend: function () {
			$("#div_erro").hide();
			$("#opcoes_nota").hide();
	        $("#gira_gira_envio").show();
	     },
		  success: function (data){
			  if(data.tem_erro){
				  $("#gira_gira_envio").hide();
				  $("#div_erro").show();
				  $("#titulo_erro").html(data.titulo);
				  $("#erro_nota").html(data.erro);
			  }else{
				  $("#opcoes_nota").hide();
			  }
		  },
	        error: function() {
			    $("#gira_gira_envio").hide();
				$("#div_erro").show();
	            $("#titulo_erro").html("Erro Desconhecido");
				$("#titulo_erro").html("Erro no Envio da Nota");
	        } 
	});	
}

function modal_opcoes_nota(id_nfe){
	abrirModal("#modal_opcoes_nota"); 
	$("#verEmail").hide();
	$("#gira_gira_opcoes").hide();
	$("#div_erro_opcoes").hide();
	$("#id_nfe").val(id_nfe);
		 
}

function danfe(){	
	var id_nfe = $("#id_nfe").val();
	$("#gira_gira_opcoes").show(); 
	window.location.href= base_url + "admin/nfe/danfe/" + id_nfe;
}

function baixarXml(){
	var id_nfe = $("#id_nfe").val();
	$("#gira_gira_opcoes").show(); 
	window.location.href= base_url + "admin/nfe/baixarXML/" + id_nfe;
	$("#gira_gira_opcoes").hide();
}

function baixarPdf(){
	var id_nfe = $("#id_nfe").val();
	$("#gira_gira_opcoes").show(); 
	window.location.href= base_url + "admin/nfe/baixarPdf/" + id_nfe;
	$("#gira_gira_opcoes").hide();
}

function verEmail(){
	$("#verEmail").show();
}

function enviarEmail(){
	 var id_nfe = $("#id_nfe").val();
	  var email = $("#email").val();

	 $.ajax({
		  url: base_url + "admin/nfe/email",
		  type: "POST",
		  dataType: "json",
		  data:{
			id_nfe: id_nfe,
			email: email
		},
		  beforeSend: function () {
			$("#div_erro").hide();
			$("#opcoes_nota").hide();
	        $("#gira_gira_envio").show();
	     },
		  success: function (data){
			  if(data.tem_erro){
				  $("#gira_gira_envio").hide();
				  $("#div_erro").show();
				  $("#titulo_erro").html(data.titulo);
				  $("#erro_nota").html(data.erro);
			  }else{
				  $("#opcoes_nota").hide();
			  }
		  },
	        error: function() {
			    $("#gira_gira_envio").hide();
				$("#div_erro").show();
	            $("#titulo_erro").html("Erro Desconhecido");
				$("#titulo_erro").html("Erro no Envio da Nota");
	        } 
	});	
}


function verXml(id_nfe){
	 $.ajax({
		  url: base_url + "admin/nfe/verXML/" + id_nfe,
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


function preencher(data){	
	$("#razao_social").val(data.razao_social);
	$("#nome_fantasia").val(data.nome_fantasia);
	$("#numero").val(data.numero);
	$("#bairro").val(data.bairro);
	$("#complemento").val(data.complemento);
	$("#cnpj").val(data.cnpj);
	$("#cep").val(data.cep);
	$("#logradouro").val(data.logradouro);
	$("#cidade").val(data.cidade);
	$("#bairro").val(data.bairro);
	$("#uf").val(data.uf);
	$("#ibge").val(data.ibge);
	$("#telefone").val(data.telefone);
	$("#email").val(data.email);
	$("#ultima_atualizacao").val(data.ultima_atualizacao);
	$("#data_criacao").val(data.abertura)
}

function limpar(){	
	$("#produto").val("");
	$("#preco").val("");
	$("#qtde").val(1);
	$("#produto").focus();
	$("#id_produto").val("");
}

