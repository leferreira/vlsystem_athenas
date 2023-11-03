$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});

$(function () {	
	
	
	$("#btnInserirComplementoProduto").on("click", function(){
		var produto_id 		= $("#produto_id ").val();
		var complemento_id  = $("#complemento_id ").val();
		
		$.ajax({
		   url: base_url + "admin/listacomplementodelivery",
		   type: "POST",
		   dataType: "json",
		   data:{	
			   		produto_id		: produto_id,
					complemento_id  : complemento_id 
			   	},
			 success: function(data){
				 lista_complemento_produto(data);
				 console.log(data);
			 }
			
		});
	});
  
});

function selecionarComplemento(){	
	 var categoria_id = $("#categoria_id").val();
	 $.ajax({
		  url: base_url + "admin/deliverycomplemento/listaPorCategoria/" + categoria_id,
		  type: "GET",
		  dataType: "json",
		  data:{},
		  success: function (data){
			  html = "";
			  for (i = 0; i < data.length; i++) {	
				  html +="<option value='" + data[i].id +"'>" + data[i].nome + "</option>";
			  } 
			  
			  $("#complemento_id").html(html); 
		  }
	   });	
}


function lista_complemento_produto(data){
	html = "<tr>";
	for(var i in data){		
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="center">' + data[i].complemento + '</td>' + 	
        '<td align="center">' + data[i].categoria + '</td></tr>' 
	}
	$("#lista_complemento_produto").html(html);
}


function limpar_entradas(){
	$("#id_produto").val("");
	$("#produtoentreda").val("");
	$("#preco").val("");
	$("#qtde").val(1);
	$("#produtoentreda").focus();
	$("#localizacao_id").html(" ");
}


