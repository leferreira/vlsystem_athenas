$(function(){
	
	$("#tecnicoPesquisado").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return;
	   }
	   $.ajax({
		   url: base_url + "admin/tecnico/pesquisa",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   $("#tecnicoPesquisado").after('<div class="listaTecnicos"></div>');
			   html="";
			   for(var i in data){
				   html +='<div class="si"><a href="javascript:;" onclick="selecionarTecnicoPesquisado(this)" ' +						
				   		  	'data-id ="'+data[i].id +
							'" data-nome = "' + data[i].nome_razao_social + '">' +	data[i].nome_razao_social +  '</a></div>';
			   }
			   
			   $(".listaTecnicos").html(html);
			   $(".listaTecnicos").show();
		   }
	   });
   })
});

function selecionarTecnicoPesquisado(obj){
	var id					= $(obj).attr('data-id');
	var nome				= $(obj).attr('data-nome');	

	$(".listaTecnicos").hide();	
	$("#tecnico_id").val(id);
	$("#tecnicoPesquisado").val(nome);
		
}

function pesquisarCnpjTecnico(eh_modal){	
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
				preencherTecnicoModal(data.retorno);
				fecharGiraGira(eh_modal);
			} 			
						   
		  },
		  beforeSend: function () {
			giraGira();
	     },
	   });	
}

function salvarTecnico(eh_modal){		 
        $.ajax({
         url: base_url + "admin/tecnico",
         type: "POST",
         data:{
				"nome": $("#tecnico_nome").val(),
				"cpf": $("#tecnico_cpf").val(),
				"logradouro": $("#tecnico_logradouro").val(),
				"numero": $("#tecnico_numero").val(),
				"bairro": $("#tecnico_bairro").val(),
				"uf": $("#tecnico_uf").val(),
				"complemento": $("#tecnico_complemento").val(),
				"telefone": $("#tecnico_telefone").val(),
				"celular": $("#tecnico_celular").val(),
				"email": $("#tecnico_email").val(),
				"cep": $("#tecnico_cep").val(),
				"cidade": $("#tecnico_cidade").val(),
				"comissao": $("#tecnico_comissao").val(),
				"senha": "mudar123",
				"eh_modal": 1
			},
         dataType:"Json",
         success: function(data){			
			if(data.tem_erro ==true){
				fecharGiraGira(eh_modal);
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				fecharModal();
				$("#mostrarUmErro").html(MostrarUmaMsgSucesso(" Registro Inserido com Sucesso"));
				var lista = data.retorno;
				html = "<option value=''>selecione</option>";
				for (i = 0; i < lista.length; i++) {	
					  html +="<option value='"+ lista[i].id +"'>" + lista[i].nome + "</option>";
				}
				 
				 $("#tecnico_id").html(html);
			 				
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

function preencherTecnicoModal(data){	
	$("#nome_razao_social").val(data.razao_social);
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

