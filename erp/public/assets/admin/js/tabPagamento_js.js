 
 function inserirPagamento(){
    $.ajax({
         url: base_url + "admin/nfepagamento",
         type: "post",
         dataType:"Json",
         data:{
        	 nfe_id     : id_nfe ,
        	 tPag		: $("#tPag").val() ,
        	 vPag		: $("#vPag").val(),
        	 indPag		: $("#indPag").val(),  
        	 CNPJ		: $("#CNPJ").val(),
        	 cAut 		: $("#cAut").val(),
        	 tpIntegra	: $("#tpIntegra").val()     	
         },
         success: function(data){
			fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));				
			}else{
				lista_pagamento(data.retorno);	
				$("#mostrarUmErro").html(MostrarUmaMsgSucesso(" Registro Inserido com Sucesso"));			
			} 
			                   
         },
         beforeSend: function(){           
            giraGira();
        },error: function (data) {
			fecharGiraGira(0);
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
         
     });
   
 } 
 
 function lista_pagamento(data){
	    var html = "";
	    for(var i in data){
	        html += "<tr> " +
	               "<td align='center' >" + data[i].id + "</td>" +
	               "<td align='center' >" + data[i].pagamento + "</td>" +
	               "<td align='center' >" + data[i].vPag + "</td>" +
	               "<td align='center' >" + data[i].tipo_pagto + "</td>" +
	               "<td align='center' ><a href='javascript:;' onclick='excluirPagamento("+ data[i].id +")'  class='btn btn-sm btn-danger d-inline-block' title='Excluir'><i class='fas fa-trash'></i></a></td>" +
	       "</tr>"; 
	    }
	    $("#lista_pagamento").html(html);
	    
	}
 
 function excluirPagamento(id){
     $.ajax({
       url: base_url + "admin/nfepagamento/" + id ,
       type: "DELETE",
       data: {  },
       dataType:"Json",
       success: function(data){
    	   lista_pagamento(data.retorno);
       }
       
   });
}
