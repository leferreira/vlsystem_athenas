 
  function inserirAutorizado(){
    $.ajax({
         url: base_url + "admin/notafiscal/inserirReferenciado",
         type: "post",
         dataType:"Json",
         data:{
        	 nfe_id   				: id_nfe,
        	 tipo_nota_referenciada	: $("#tipo_nota_referenciada").val(), 
        	 ref_NFe				: $("#ref_NFe").val(),     
			 ref_ano_mes			: $("#ref_ano_mes").val(), 
			 ref_num_nf				: $("#ref_num_nf").val(), 
			 ref_serie				: $("#ref_serie").val(),  	
         },
         success: function(data){ 
			$("#tipo_nota_referenciada").val(' ');
			$("#ref_NFe").val(' ');
			$("#ref_ano_mes").val(' ');
			$("#ref_num_nf").val(' ');
			$("#ref_serie").val(' ');
        	 lista_referenciado(data);
             fecharModal();                 
             
         },
         beforeSend: function(){           
            giraGira(); 
        }
         
     });
   
 } 
 
 function lista_referenciado(data){
	    var html = "";
	    for(var i in data){
	        html += "<tr> " +
	               "<td align='center' >" + data[i].id + "</td>" +
	               "<td align='center' >" + data[i].ref_NFe + "</td>" +
					"<td align='center' >" + data[i].ref_ano_mes + "</td>" +
					"<td align='center' >" + data[i].ref_num_nf + "</td>" +
					"<td align='center' >" + data[i].ref_serie + "</td>" +
	               "<td align='center' ><a href='javascript:;' onclick='excluirReferenciado("+ data[i].id +")'  class='btn btn-sm btn-danger d-inline-block' title='Excluir'><i class='fas fa-trash'></i></a></td>" +
	       "</tr>"; 
	    }
	    $("#lista_referenciado").html(html);
	    
	}
 
 function excluirReferenciado(id){
     $.ajax({
       url: base_url + "admin/notafiscal/excluirReferenciado/" + id ,
       type: "GET",
       data: {  },
       dataType:"Json",
       success: function(data){
    	   lista_referenciado(data);
			
       }
       
   });
}