$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});
$(function () {
	
	$("#btnInserirSaida").on("click", function(){
		var id		= $("#produto_id").val();
		var preco	= $("#preco").val();
		var qtde	= $("#qtde").val();
		
		$.ajax({
			url: path + "saida",
		   type: "POST",
		   dataType: "json",
		   data:{	
			   		produto_id:id,
			   		qtde_saida: qtde,
			   		valor_saida: preco,
			   		subtotal_saida: qtde * preco
			   	},
			 success: function(data){
				 lista_saidas(data);
				 limpar_saidas();
			 }
			
		});
	});

   $("#produto_saida").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return;
	   }
	   $.ajax({
		   url: path + "produto/pesquisa",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   $("#produto_saida").after('<div class="listaProdutos"></div>');
			   html="";
			   for(var i in data){
				   html +='<div class="si"><a href="javascript:;" onclick="selecionarProduto_saida(this)" ' +
				   		  'data-id="'+data[i].id +
				   		  '" data-preco = "' + data[i].preco +
				   		  '" data-nome = "' + data[i].produto + '">' +
				   		  data[i].produto + " - RS " + data[i].preco + '</a></div>';
			   }
			   
			   $(".listaProdutos").html(html);
			   $(".listaProdutos").show();
		   }
	   });
   })
});

function listaLocalizacaoSaida(produto_id){
	$.ajax({
		   url: path + "produtolocalizacao/listaPorProduto/" + produto_id,
		   type: "GET",
		   dataType: "json",
		   data: {},
		   success: function (data){			
			   html = "";
				  for (i = 0; i < data.length; i++) {	
					  html +="<option value='"+ data[i].id +"'>" + data[i].localizacao + "( "+ data[i].estoque + " )"   + "</option>";
				  } 
				  $("#localizacao_id").html(html); 
		   }
	   });
}
function selecionarProduto_saida(obj){
	var id= $(obj).attr('data-id');
	var nome= $(obj).attr('data-nome');
	var preco= $(obj).attr('data-preco');
	$(".listaProdutos").hide();
	
	$("#produto_id").val(id);
	$("#produto_saida").val(nome);
	$("#preco").val(preco);
	$("#qtde").val(1);
	$("#qtde").focus();
	
	listaLocalizacaoSaida(id);	
}

function lista_saidas(data){
	html = "<tr>";
	var total_saida = 0.00;
	for(var i in data){
		total_saida += parseFloat(data[i].subtotal_saida);
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="center">' + data[i].data_saida + '</td>' + 	
        '<td align="center">' + data[i].produto + '</td>' +
        '<td align="center">' + data[i].localizacao + '</td>' +
        '<td align="center">' + data[i].qtde_saida + '</td>' + 	
        '<td align="center">' + data[i].valor_saida + '</td>' + 	
        '<td align="center">' + data[i].subtotal_saida + '</td></tr>' 
	}
	total = total_saida.toFixed(2).replace(".",",");
	html += '<tr><td align="right" colspan="7"><b>Total:</b> <span class="text-verde minimo-font" id="total_saida">' + total +'</span></td> </tr>'
	$("#lista_saidas").html(html);
}

function limpar_saidas(){
	$("#produto_id").val("");
	$("#produto_saida").val("");
	$("#preco").val("");
	$("#qtde").val(1);
	$("#produto_saida").focus();
}


