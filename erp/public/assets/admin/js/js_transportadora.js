$(function(){	
	$("#transportadoraPesquisado").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return false;
	   }
	   $.ajax({
		   url: base_url + "admin/transportadora/pesquisa",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   $("#transportadoraPesquisado").after('<div class="listaTransportadoraPesquisado"></div>');
			   html="";
			   for(var i in data){
				   html +='<div class="si"><a href="javascript:;" onclick="selecionarTransportadoraPesquisado(this)" ' +						
				   		  	'data-id ="' + data[i].id +
							'" data-nome = "' + data[i].razao_social + '">' +	data[i].razao_social +  '</a></div>';
			   }
			   $(".listaTransportadoraPesquisado").html(html);
			   $(".listaTransportadoraPesquisado").show();
		   }
	   });
   })

});


function selecionarTransportadoraPesquisado(obj){
	var id					= $(obj).attr('data-id');
	var nome				= $(obj).attr('data-nome');	

	$(".listaTransportadoraPesquisado").hide();	
	$("#transportadora_id").val(id);
	$("#transportadoraPesquisado").val(nome);		
}

function salvarTransportadora(eh_modal){ 
        $.ajax({
         url: base_url + "admin/transportadora",
         type: "POST",
         data:$("#frmCadTransportadora").serialize(),
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
function pesquisarCnpjTransportadora(eh_modal){
	var cnpj = tira_mascara($("#transp_codigocnpj").val());		
	 $.ajax({
		  url: base_url + "admin/util/buscarCNPJ/" + cnpj,
		  type: "GET",
		  dataType: "json",
		  data:{},
		  success: function (data){
			  fecharGiraGira(eh_modal);
			  if(data.tem_erro==false){
				preencherModalTransportadora(data.retorno);
			  }
			  
		  },
		  beforeSend: function () {
			giraGira();
	     },
	  });	
}



function preencherModalTransportadora(data){
	$("#transp_razao_social").val(data.razao_social);
	$("#transp_nome_fantasia").val(data.nome_fantasia);
	$("#transp_numero").val(data.numero);
	$("#transp_bairro").val(data.bairro);
	$("#transp_complemento").val(data.complemento);
	$("#transp_cnpj").val(data.cnpj);
	$("#transp_cep").val(data.cep);
	$("#transp_logradouro").val(data.logradouro);
	$("#transp_cidade").val(data.cidade);
	$("#transp_bairro").val(data.bairro);
	$("#transp_uf").val(data.uf);
	$("#transp_ibge").val(data.ibge);
	$("#transp_telefone").val(data.telefone);
	$("#transp_email").val(data.email);
	$("#transp_ultima_atualizacao").val(data.ultima_atualizacao);
	$("#transp_data_criacao").val(data.abertura)
}

function limpar(){	
	$("#produto").val("");
	$("#preco").val("");
	$("#qtde").val(1);
	$("#produto").focus();
	$("#id_produto").val("");
}

