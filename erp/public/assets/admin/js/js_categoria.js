var eh_modal_categoria = 0;
$(function(){	

});

function listarCategoria(eh_modal){
	if (parseInt(eh_modal) > 0) {
		var compontente_subcategoria = "#cb_subcategoria_id";
	}else{
		var compontente_subcategoria = "#subcategoria_id";
	}
	
	$.ajax({
         url: base_url + "admin/categoria/listarCategoria/" ,
         type: "get",
         dataType:"Json",
         data:{},
         success: function(data){
			  fecharGiraGira(eh_modal);
        	  html = "<option value=''>selecione</option>";
			  for (i = 0; i < data.length; i++) {	
				  html +="<option value='"+ data[i].id +"'>" + data[i].subcategoria + "</option>";
			  }
			 $(compontente_subcategoria).html(html);
         },
         beforeSend: function(){           
            giraGira(); 
        }
         
     });
}

function listarSubcategoriaPelaCategoria(eh_modal){
	if (parseInt(eh_modal) > 0) {
		var compontente_categoria 		= "#cb_categoria_id";
		var compontente_subcategoria 	= "#cb_subcategoria_id";
		var compontente_subsubcategoria = "#cb_subsubcategoria_id";
	}else{
		var compontente_categoria 		= "#categoria_id";
		var compontente_subcategoria 	= "#subcategoria_id";
		var compontente_subsubcategoria = "#subsubcategoria_id";
		
	}
	
	var categoria_id = $(compontente_categoria).val();
	$.ajax({
         url: base_url + "admin/categoria/listarSubcategoriaPelaCategoria/" + categoria_id,
         type: "get",
         dataType:"Json",
         data:{},
         success: function(data){
			  fecharGiraGira(eh_modal);
        	  html = "<option value=''>selecione</option>";
			  for (i = 0; i < data.length; i++) {	
				  html +="<option value='"+ data[i].id +"'>" + data[i].subcategoria + "</option>";
			  }
			 $(compontente_subcategoria).html(html);
			 $(compontente_subsubcategoria).html("<option value=''>selecione</option>");
         },
         beforeSend: function(){           
            giraGira(); 
        }         
     });
}
 
function listarSubSubcategoriaPelaSubCategoria(eh_modal){
	if (parseInt(eh_modal) > 0) {
		var compontente_subcategoria = "#cb_subcategoria_id";
		var compontente_subsubcategoria = "#cb_subsubcategoria_id";
	}else{
		var compontente_subcategoria = "#subcategoria_id";
		var compontente_subsubcategoria = "#subsubcategoria_id";
	}
	
	var subcategoria_id = $(compontente_subcategoria).val();
	$.ajax({
         url: base_url + "admin/categoria/listarSubSubcategoriaPelaSubCategoria/" + subcategoria_id,
         type: "get",
         dataType:"Json",
         data:{},
         success: function(data){
			  fecharGiraGira(eh_modal);
        	  html = "<option value=''>selecione</option>";
			  for (i = 0; i < data.length; i++) {	
				  html +="<option value='"+ data[i].id +"'>" + data[i].subsubcategoria + "</option>";
			  }
			 $(compontente_subsubcategoria).html(html);
         },
         beforeSend: function(){           
            giraGira(); 
        }
         
     });
}
function fecharTelaCategoria(){
	fecharModal(eh_modal_categoria);
}
function abrirModalCategoria(eh_modal){
	eh_modal_categoria = eh_modal;
		$("#modalCadCategoria").removeClass("window");
		$("#modalCadCategoria").removeClass("modal_livre");
	if(eh_modal > 0){
		$("#modalCadCategoria").addClass("modal_livre");
		abrirModalLivre("#modalCadCategoria");
	}else{
		$("#modalCadCategoria").addClass("window");
		abrirModal("#modalCadCategoria");
	}	
}

function salvarCategoria(eh_modal){	
	var nome 		= $('#txtCategoria').val();
	$.ajax({
		   url: base_url + "admin/categoria/salvarJs",
		   type: "POST",
		   dataType: "json",
		   data: { categoria:nome },
		   beforeSend: function (){
			   giraGira();
		   },
		   success: function (data){
				if(data.tem_erro ==true){
					fecharGiraGira(eh_modal);
					$("#erroModalLivre").html(data.erro);
					abrirModalLivre("#modalLivreErro");				
				}else{
					$("#mostrarSucesso").html(MostrarUmaMsgSucesso("Salvo com sucesso, aguarde..."));
				     fecharGiraGira(eh_modal);
					 fecharModalLivre();
					 html = "";
					  for (i = 0; i < data.length; i++) {	
						  html +="<option value='"+ data[i].id +"'>" + data[i].categoria + "</option>";
					  }			 
					  $("#cb_categoria_id").html(html);
					  $("#txtCategoria").val("");
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
	   });	
}


	
function abrirModalSubCategoria(eh_modal){
	var categoria_id = $('#cb_categoria_id').val();
	eh_modal_categoria = eh_modal;
	if(categoria_id ==""){
		alert("Selecione uma Categoria Primeiramente");
		return false;
	}
			
	if(eh_modal > 0){
		$("#modalCadSubCategoria").addClass("modal_livre");
		abrirModalLivre("#modalCadSubCategoria");
	}else{
		$("#modalCadSubCategoria").addClass("window");
		abrirModal("#modalCadSubCategoria");
	}
}

function salvarSubCategoria(){	
	var nome 		= $('#txtSubCategoria').val();
	var categoria_id= $('#cb_categoria_id').val();
	if(categoria_id ==""){
		alert("Selecione uma Categoria Primeiramente");
		return false;
	}
	$.ajax({
		   url: base_url + "admin/categoria/salvarSubCategoriaJs",
		   type: "POST",
		   dataType: "json",
		   data: {
				categoria_id: categoria_id, 
				subcategoria: nome 
			},
		   beforeSend: function (){
			   giraGira();
		   },
		   success: function (data){
				if(data.tem_erro ==true){
					fecharGiraGira(eh_modal_categoria);
					$("#erroModalLivre").html(data.erro);
					abrirModalLivre("#modalLivreErro");				
				}else{
					$("#mostrarSucesso").html(MostrarUmaMsgSucesso("Salvo com sucesso, aguarde..."));
					fecharGiraGira(eh_modal_categoria);
				    fecharModalLivre();
					 html = "";
					  for (i = 0; i < data.length; i++) {	
						  html +="<option value='"+ data[i].id +"'>" + data[i].subcategoria + "</option>";
					  }
			 
					  $("#cb_subcategoria_id").html(html);
					  $("#txtSubCategoria").val("");
				}
			},
			  beforeSend: function () {
				giraGira();
		     },error: function (data) {
				fecharGiraGira(eh_modal_categoria);
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
 
function abrirModalSubSubCategoria(eh_modal){
	var subcategoria_id = $('#cb_subcategoria_id').val();
	eh_modal_categoria = eh_modal;
	if(subcategoria_id =="" || subcategoria_id =="null" || subcategoria_id ==null){
		alert("Selecione uma SubCategoria Primeiramente");
		return false;
	}	
	if(eh_modal > 0){
		$("#modalCadSubSubCategoria").addClass("modal_livre");
		abrirModalLivre("#modalCadSubSubCategoria");
	}else{
		$("#modalCadSubSubCategoria").addClass("window");
		abrirModal("#modalCadSubSubCategoria");
	}
}

function salvarSubSubCategoria(){	
	var nome 		= $('#txtSubSubCategoria').val();
	var subcategoria_id= $('#cb_subcategoria_id').val();
	if(subcategoria_id ==""){
		alert("Selecione uma SubCategoria Primeiramente");
		return false;
	}
	$.ajax({
		   url: base_url + "admin/categoria/salvarSubSubCategoriaJs",
		   type: "POST",
		   dataType: "json",
		   data: {
				subcategoria_id: subcategoria_id, 
				subsubcategoria: nome 
			},
		   beforeSend: function (){
			   giraGira();
		   },
		   success: function (data){
				if(data.tem_erro ==true){
					fecharGiraGira(eh_modal_categoria);
					$("#erroModalLivre").html(data.erro);
					abrirModalLivre("#modalLivreErro");				
				}else{
					$("#mostrarSucesso").html(MostrarUmaMsgSucesso("Salvo com sucesso, aguarde..."));
					fecharGiraGira(eh_modal_categoria);
				    fecharModalLivre();
					 html = "";
					  for (i = 0; i < data.length; i++) {	
						  html +="<option value='"+ data[i].id +"'>" + data[i].subsubcategoria + "</option>";
					  }
			 
					  $("#cb_subsubcategoria_id").html(html);
					  $("#txtSubSubCategoria").val("");
				}
			},
			  beforeSend: function () {
				giraGira();
		     },error: function (data) {
				fecharGiraGira(eh_modal_categoria);
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
