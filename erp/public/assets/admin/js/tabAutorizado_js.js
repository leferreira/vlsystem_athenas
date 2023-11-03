 
  function inserirAutorizado(){
    $.ajax({
         url: base_url + "admin/notafiscal/inserirAutorizado",
         type: "post",
         dataType:"Json",
         data:{
        	 nfe_id   				: id_nfe,
        	 aut_contato			: $("#aut_contato").val(), 
        	 aut_cnpj				: $("#aut_cnpj").val(),      	
         },
         success: function(data){ 
			$("#aut_contato").val(' ');
			$("#aut_cnpj").val(' ');
        	 lista_autorizado(data);
             fecharModal();                 
             
         },
         beforeSend: function(){           
            giraGira(); 
        }
         
     });
   
 } 
 
 function lista_autorizado(data){
	    var html = "";
	    for(var i in data){
	        html += "<tr> " +
	               "<td align='center' >" + data[i].id + "</td>" +
	               "<td align='center' >" + data[i].aut_contato + "</td>" +
	               "<td align='center' >" + data[i].aut_cnpj + "</td>" +
	               "<td align='center' ><a href='javascript:;' onclick='excluirAutorizado("+ data[i].id +")'  class='btn btn-sm btn-danger d-inline-block' title='Excluir'><i class='fas fa-trash'></i></a></td>" +
	       "</tr>"; 
	    }
	    $("#lista_autorizado").html(html);
	    
	}
 
 function excluirAutorizado(id){
     $.ajax({
       url: base_url + "admin/notafiscal/excluirAutorizado/" + id ,
       type: "GET",
       data: {  },
       dataType:"Json",
       success: function(data){
    	   lista_autorizado(data);
			
       }
       
   });
}