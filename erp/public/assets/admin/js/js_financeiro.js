var eh_modal = 0;
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});
$(function () {

		
});



$("#btnInserirPrevisao").on("click", function(){
		var conta_receber_id	= $("#conta_receber_id").val();
		var data_previsao 		= $("#data_previsao").val();
		var historico 			= $("#historico").val();	
		if(data_previsao==""){
			alert("Selecionar a data de Previsão primeiramente");
			return;
		}
		
		if(historico==""){
			alert("Selecionar uma observação primeiramente");
			return;
		}	
	
		
		$.ajax({
			url: base_url + "admin/contareceberprevisao",
		   type: "POST",
		   dataType: "json",
		   data:{	
		   		conta_receber_id	: conta_receber_id,
		   		data_previsao		: data_previsao,
		   		historico			: historico
		   	},
			 success: function(data){
				 lista_previsao_pagamento(data.retorno);
			 }
			
		});
	});




function lista_previsao_pagamento(data){
	html = "<tr>";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="left">' + dataBr(data[i].data_previsao) + '</td>' + 
        '<td align="left">' + data[i].historico + '</td>' +
       	'<td align="center"><a href="javascript:;" onclick="excluirProdutoTributacao('+ data[i].id +')"  class="btn btn-outline-vermelho btn-pequeno fas fa-trash" title="Excluir"></a></td></tr>'
	}
	$("#lista_previsao_pagamento").html(html);
}

function excluirProdutoTributacao(id){
       $.ajax({
         url: base_url + "admin/contareceberprevisao"  + id ,
         type: "DELETE",
         data: {  },
         dataType:"Json",
         success: function(data){
             lista_previsao_pagamento(data.retorno);
         }
         
     });
}

