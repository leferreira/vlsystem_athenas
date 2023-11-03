$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});
$(function () {
	
	$("#btnInserirItemOrdemCompra").on("click", function(){
		var id		= $("#produto_id").val();
		var preco	= $("#preco").val();
		var qtde	= $("#qtde").val();
		
		$.ajax({
			url: path + "itemordemcompra",
		   type: "POST",
		   dataType: "json",
		   data:{	
			   		token :_token,
					produto_id:id,
			   		qtde: qtde,
			   		valor: preco,
			   		ordem_compra_id : id_ordem,
			   		subtotal: qtde * preco
			   	},
			 success: function(data){
				 lista_item_ordem_compras(data);
				 limpar_item_ordem_compras();
			 }
			
		});
	});

   $("#produto").on("keyup", function(){
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
			   $("#produto").after('<div class="listaProdutos"></div>');
			   html="";
			   for(var i in data){
				   html +='<div class="si"><a href="javascript:;" onclick="selecionarProduto(this)" ' +
				   		  'data-id="'+data[i].id +
				   		  '" data-preco = "' + data[i].valor_venda +
				   		  '" data-nome = "' + data[i].nome + '">' +
				   		  data[i].nome + " - RS " + data[i].valor_venda + '</a></div>';
			   }
			   
			   $(".listaProdutos").html(html);
			   $(".listaProdutos").show();
		   }
	   });
   })
});


function selecionarProduto(obj){
	var id= $(obj).attr('data-id');
	var nome= $(obj).attr('data-nome');
	var preco= $(obj).attr('data-preco');
	$(".listaProdutos").hide();
	
	$("#produto_id").val(id);
	$("#produto").val(nome);
	$("#preco").val(preco);
	$("#qtde").val(1);
	$("#qtde").focus();
	
}

function lista_item_ordem_compras(data){
	html = "<tr>";
	var total_item_ordem_compra = 0.00;
	for(var i in data){
		total_item_ordem_compra += parseFloat(data[i].subtotal);
		html +=
        '<td align="center">' + data[i].id + '</td>' + 	
        '<td align="center">'   + data[i].produto.nome + '</td>' +
        '<td align="center">' + data[i].qtde + '</td>' + 	
        '<td align="center">' + data[i].valor + '</td>' + 	
        '<td align="center">' + data[i].subtotal + '</td>' + 
		'<td align="center"><a href="javascript:;" onclick="excluir_item_ordem_compra(this)" data-id="'+data[i].id +'"  class="d-inline-block btn btn-outline-vermelho btn-pequeno"><i class="fas fa-trash-alt"></i></a> </td></tr>';
}
	total = total_item_ordem_compra.toFixed(2).replace(".",",");
	html += '<tr><td align="right" colspan="7"><b>Total:</b> <span class="text-verde minimo-font" id="total_item_ordem_compra">' + total +'</span></td> </tr>'
	$("#lista_item_ordem_compras").html(html);
	$("#totol_ordem").html(total);
}

function excluir_item_ordem_compra(obj){
	var id= $(obj).attr('data-id');
	if(!confirm("Deseja Realmente excluir!!!")){
		return false;
	}
	$.ajax({
		   url: path + "itemordemcompra/" + id,
		   type: "DELETE",
		   dataType: "json",
		   data: {},
		   success: function (data){
			   lista_item_ordem_compras(data);
		   }
	   });
}
function limpar_item_ordem_compras(){
	$("#produto_id").val("");
	$("#produto").val("");
	$("#preco").val("");
	$("#qtde").val(1);
	$("#produto").focus();
}


