var eh_modal_categoria = 0;
$(function(){	

});



function salvarVariacaoGrade(){ 
		eh_modal = 1;       
        $.ajax({
         url: base_url + "admin/variacaograde/salvarJs",
         type: "POST",
         data:$("#frmCadVariacaoGrade").serialize(),
         dataType:"Json",
         success: function(data){			
			if(data.tem_erro ==true){
				fecharGiraGira(eh_modal);
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				fecharModal();
				$("#mostrarUmErro").html(MostrarUmaMsgSucesso(" Registro Inserido com Sucesso"));
				 html = "";
				  for (i = 0; i < data.lista.length; i++) {	
					  html +="<option value='"+ data.lista[i].id +"'>" + data.lista[i].variacao + "</option>";
				  }				  				  
				  $("#variacao_grade_id").html(html);
				  $("#variacao").val("");
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
