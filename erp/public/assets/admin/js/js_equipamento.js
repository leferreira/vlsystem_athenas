$(function(){
	
});



function salvarEquipamento(eh_modal){	
        $.ajax({
         url: base_url + "admin/equipamento",
         type: "POST",
         data:{
				"cliente_id"	: $(".cliente_id").val(),
				"equipamento"	: $("#equipamento").val(),
				"num_serie"		: $("#num_serie").val(),
				"logradouro"	: $("#equipamento_logradouro").val(),
				"modelo"		: $("#modelo").val(),
				"cor"			: $("#cor").val(),
				"descricao"		: $("#descricao").val(),
				"tensao"		: $("#tensao").val(),
				"potencia"		: $("#potencia").val(),
				"voltagem"		: $("#voltagem").val(),
				"data_fabricacao": $("#data_fabricacao").val(),
				"eh_modal"		: 1
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
					  html +="<option value='"+ lista[i].id +"'>" + lista[i].equipamento + "</option>";
				}
				 
				 $("#equipamento_id").html(html);
			 				
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



function limpar(){	
	$("#produto").val("");
	$("#preco").val("");
	$("#qtde").val(1);
	$("#produto").focus();
	$("#id_produto").val("");
}

