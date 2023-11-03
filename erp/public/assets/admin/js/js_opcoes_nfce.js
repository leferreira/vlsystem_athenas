$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});
$(function(){

});


function transmitirNfce(id_nfce){
	 abrirModal("#enviarNfce"); 
	 
	 $.ajax({
		  url: base_url + "admin/nfce/transmitir/" + id_nfce,
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

function modal_opcoes_nota(id_nfce){
	abrirModal("#modal_opcoes_nota"); 
	$("#verEmail").hide();
	$("#gira_gira_opcoes").hide();
	$("#div_erro_opcoes").hide();
	$("#id_nfce").val(id_nfce);
		 
}

function danfce(){	
	var id_nfce = $("#id_nfce").val();
	$("#gira_gira_opcoes").show(); 
	window.location.href= base_url + "admin/nfce/danfce/" + id_nfce;
}

function baixarXml(){
	var id_nfce = $("#id_nfce").val();
	$("#gira_gira_opcoes").show(); 
	window.location.href= base_url + "admin/nfce/baixarXML/" + id_nfce;
	$("#gira_gira_opcoes").hide();
}

function baixarPdf(){
	var id_nfce = $("#id_nfce").val();
	$("#gira_gira_opcoes").show(); 
	window.location.href= base_url + "admin/nfce/baixarPdf/" + id_nfce;
	$("#gira_gira_opcoes").hide();
}

function verEmail(){
	$("#verEmail").show();
}

function enviarEmail(){
	 var id_nfce = $("#id_nfce").val();
	  var email = $("#email").val();

	 $.ajax({
		  url: base_url + "admin/nfce/email",
		  type: "POST",
		  dataType: "json",
		  data:{
			id_nfce: id_nfce,
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


function verXml(id_nfce){
	 $.ajax({
		  url: base_url + "admin/nfce/verXML/" + id_nfce ,
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

