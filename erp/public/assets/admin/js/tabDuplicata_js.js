function atualizarDadosPagamentos(livre){
	$.ajax({
         url: base_url + "admin/notafiscal/atualizarDadosPagamentos",
         type: "post",
         dataType:"Json",
         data:{
        	 nfe_id     	: id_nfe ,
        	 livre     		: livre,
        	 vFreteTot		: $("#vFreteTot").val() ,
        	 vSegTot		: $("#vSegTot").val(),
			 vOutroTot		: $("#vOutroTot").val(),
        	 desconto_nota	: $("#desconto_nota").val()      	
         },
         success: function(data){ 
        	fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{
				location.reload() ; 					
			}              
         },
         beforeSend: function(){           
             giraGira();
        }, error: function (e) {
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
         
     });
}
 
 function inserirDuplicata(){
	var tPag 				= $("#tPag").val();
	var forma_de_parcelar 	= $("#forma_de_parcelar").val()
	var qtde_parcela 		= $("#qtde_parcela").val();
	var valor 				= $("#vLiq").val();
	
    $.ajax({
         url: base_url + "admin/nfeduplicata/inserir",
         type: "post",
         dataType:"Json",
         data:{
        	 nfe_id     		: id_nfe ,
        	 tPag				: tPag ,
        	 forma_de_parcelar	: forma_de_parcelar,
			 qtde_parcela		: qtde_parcela,  
			 valor				: valor,  	
         },
         success: function(data){ 
			location.reload();             
         },
         beforeSend: function(){           
             
        }
         
     });
   
 } 
 
 function alterarDuplicata(id){
	var tPag 				= $("#tPag_"+id).val();
	var dVenc 				= $("#vencimento_"+id).val()
	var obs 				= $("#obs_"+id).val();
	
    $.ajax({
         url: base_url + "admin/nfeduplicata/salvarAlteracao",
         type: "post",
         dataType:"Json",
         data:{
        	 id     		: id ,
        	 tPag			: tPag ,
        	 dVenc			: dVenc,
			 obs			: obs,     	
         },
         success: function(data){ 
			  console.log(data);
        	  fecharGiraGira();              
         },
         beforeSend: function(){           
             giraGira(); 
        }
         
     });
   
 } 
 
 function lista_duplicata(data){
	    var html = "";
	    for(var i in data){
	        html += "<tr> " +
	               "<td align='center' >" + data[i].nDup + "</td>" +
	               "<td align='center' >" + data[i].dVenc + "</td>" +
	               "<td align='center' >" + data[i].vDup + "</td>" +
				   "<td align='center' >" + data[i].pagamento + "</td>" +
	               "<td align='center' ><a href='javascript:;' onclick='excluirDuplicata("+ data[i].id +")'  class='btn btn-sm btn-danger d-inline-block' title='Excluir'><i class='fas fa-trash'></i></a></td>" +
	       "</tr>"; 
	    }
	    $("#lista_duplicata").html(html);
	    
	}
 
 function excluirDuplicata(id){	
     $.ajax({
       url: base_url + "admin/nfeduplicata/excluir/" + id ,
       type: "GET",
       data: {  },
       dataType:"Json",
       success: function(data){
			//location.reload();
			fecharGiraGira();
			location.reload();
			//window.location.href = base_url + "admin/notafiscal/edit/" + id_nfe +"#tab-7" ;
    	  
       },
         beforeSend: function(){           
             giraGira(); 
        }
       
   });
}
