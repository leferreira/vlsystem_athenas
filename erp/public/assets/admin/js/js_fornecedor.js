
$(function(){

});

function pesquisarCnpj(eh_modal){	
	var cnpj = tira_mascara($("#codigocnpj").val());	
	 $.ajax({
		  url: base_url + "admin/util/buscarCNPJ/" + cnpj,
		  type: "GET",
		  dataType: "json",
		  data:{},
		  success: function (data){
			if(data.tem_erro ==true){
				fecharGiraGira(eh_modal);
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				//fecharModal();
				preencherFornecedorModal(data.retorno);
				fecharGiraGira(eh_modal);
			} 			
						   
		  },
		  beforeSend: function () {
			giraGira();
	     },
	   });	
	

}

function salvarFornecedor(eh_modal){ 
        $.ajax({
         url: base_url + "admin/fornecedor",
         type: "POST",
         data:$("#frmCadFornecedor").serialize(),
         dataType:"Json",
         success: function(data){			
			if(data.tem_erro ==true){
				fecharGiraGira(eh_modal);
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				fecharModal();
				$("#mostrarUmErro").html(MostrarUmaMsgSucesso(" Registro Inserido com Sucesso"));
			}             
         },
		  beforeSend: function () {
			giraGira();
	     },error: function (data) {
			fecharGiraGira(eh_modal);
			if(data.status== 422){
				var errors = $.parseJSON(data.responseText);
				$('#listaErroModal').html('');					
	        	$.each(errors.errors, function (key, erro) {					 
					 $('#listaErroModal').append('<li>' + erro + '</li>');
					 abrirModalLivre("#modalLivreListaComErros");
	        	});
			}else{
				
			}	        
		}        
     })
}
function preencherFornecedorModal(data){	
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

function adicionaZero(numero){
    if (numero <= 9) 
        return "0" + numero;
    else
        return numero; 
}

function formatarData(dat){
		var data = new Date(dat);
        var dia  = (data.getDate()+1).toString();
        var diaF = (dia.length == 1) ? '0' + dia : dia;

        var mes  = (data.getMonth()+1).toString(); //+1 pois no getMonth() Janeiro começa com zero.
        var mesF = (mes.length == 1) ? '0' + mes : mes;
        var anoF = data.getFullYear();
	return diaF + "/" + mesF + "/" + anoF ;

}