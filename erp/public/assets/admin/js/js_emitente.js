
$(function(){

});

function pesquisarCnpj(){
	var cnpj = tira_mascara($("#codigocnpj").val());
	if(cnpj==""){
		return false;
	}
	 $.ajax({
		  url: base_url + "admin/util/buscarCNPJ/" + cnpj,
		  type: "GET",
		  dataType: "json",
		  data:{},
		  success: function (data){
			if(data.tem_erro ==true){
				fecharGiraGira();
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				fecharModal();
				preencher(data.retorno);
				fecharGiraGira();
			}			  
		  },
		  beforeSend: function () {
			giraGira();
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

