var unidades = [];
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});
$(function () {	
	
   $("#produtoentreda").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return;
	   }
	   $.ajax({
		   url: base_url + "admin/produto/pesquisa",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   $("#produtoentreda").after('<div class="listaProdutos"></div>');
			   
			   html="";
			   for(var i in data){
				var estoque = data[i].estoque !=null ? data[i].estoque.quantidade : 0;
				var estoque_grade = data[i].estoque !=null ? data[i].estoque.qtde_grade : 0;
				   html +='<div class="si"><a href="javascript:;" onclick="selecionarProdutoEntrada(this)" ' +						
				   		  	'data-id="'+data[i].id +
				   		  	'" data-preco = "' + data[i].valor_venda +
				   		  	'" data-nome  = "' + data[i].nome + 
				   		  	'" data-usaGrade  = "' + data[i].usa_grade +
				   		  	'" data-estoque  	= "' + estoque +
				   		  	'" data-estoqueGrade  = "' + estoque_grade +
							'" data-fragmentacao_qtde = "' + data[i].fragmentacao_qtde + 
							'" data-fragmentacao_unidade = "' + data[i].fragmentacao_unidade + 
							'" data-fragmentacao_valor = "' + data[i].fragmentacao_valor + 
							'" data-unidade = "' + data[i].unidade + '">' +
				   		  data[i].nome + " - RS " + data[i].valor_venda + '</a></div>';
			   }
			   
			   $(".listaProdutos").html(html);
			   $(".listaProdutos").show();
		   }
	   });
   })
});

function verificarInserirEntrada(){
	var usa_grade 	= $("#usa_grade").val();
	var produto_id	= $("#produto_id").val();
	if(usa_grade =="S"){
		abrirGradeEntradaSaida(produto_id, "entrada");		
	}else{
		inserirEntradaEstoque();
	}
}

function inserirEntradaEstoque(){
	var id			= $("#produto_id").val();	
	var preco		= $("#preco").val();	
	var qtde		= $("#qtde").val();	
	var observacao	= $("#observacao").val();
	var unidade		= $("#unidade_entrada").val();	
		
	
	$.ajax({
		url: base_url + "admin/entrada/salvarJs",
	   type: "POST",
	   dataType: "json",
	   data:{	
	   		produto_id		:id,
	   		qtde_entrada	: qtde,
	   		valor_entrada	: preco,
	   		observacao		: observacao,
	   		unidade			: unidade,
	   	},
		 success: function(data){
			 if(data.tem_erro ==true){
				fecharGiraGira(eh_modal);
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				fecharModal();
				$("#mostrarUmErro").html(MostrarUmaMsgSucesso(" Registro Inserido com Sucesso"));
				location.reload();
			} 
		 }, error: function (e) {
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
		
	});
}

function percorrerTabela(){	
	var eh_grade	= $("#usa_grade").val();
	var id = "";
	var retorno = [];
   if(eh_grade=="S"){
		SOMA_QTDE = 0.0;
	   $("#lista_grade_produto tr").each(function(){
			let grade 		= new Object();
			id 				= $(this).find("td:eq(0)").attr("id");		
			grade.id 		= id;
			grade.estoque 	= $("#estoque_"+id).val();
			grade.qtde 		= $("#valor_"+id).val();
			retorno.push(grade);          
	   });
	}
   return retorno;
   
}

function selecionarUnidade(){
	var unid = $("#unidade_entrada").val();
	for (i = 0; i < unidades.length; i++) {
		if(unidades[i].unidade == unid){
			$("#preco").val(unidades[i].valor);
			$("#subtotal").val(unidades[i].valor);	
			$("#quantidade").val(1);
			$("#preco").focus();
			break;
		}
	}
}



function selecionarProdutoEntrada(obj){
	var id					= $(obj).attr('data-id');
	var nome				= $(obj).attr('data-nome');
	var preco				= $(obj).attr('data-preco');
	var usa_grade			= $(obj).attr('data-usaGrade');
	var estoque				= $(obj).attr('data-estoque');
	var estoque_grade		= $(obj).attr('data-estoqueGrade')!="null" ? $(obj).attr('data-estoqueGrade') : 0;
	var unidade				= $(obj).attr('data-unidade');
	var FRAGMENTACAO_UNIDADE= $(obj).attr('data-fragmentacao_unidade');
	var FRAGMENTACAO_VALOR 	= $(obj).attr('data-fragmentacao_valor');
	var FRAGMENTACAO_QTDE 	= $(obj).attr('data-fragmentacao_qtde');
	
	var html = "";
	if(FRAGMENTACAO_UNIDADE!="null"){
		unidades = [
					{unidade:unidade, valor:preco, qtde:1 },
					{unidade:FRAGMENTACAO_UNIDADE, valor:FRAGMENTACAO_VALOR, qtde:FRAGMENTACAO_QTDE }
					]		
	
	}else{
		unidades = [
					{unidade:unidade, valor:preco, qtde:1 }
					]
	}
	
	  html = "";
	  for (i = 0; i < unidades.length; i++) {	
		  html +="<option value='"+ unidades[i].unidade +"'>" + unidades[i].unidade + "</option>";
	  } 

	$("#unidade_entrada").html(html); 
	$(".listaProdutos").hide();
	
	$("#produto_id").val(id);
	$("#produtoentreda").val(nome);
	$("#preco").val(preco);
	$("#usa_grade").val(usa_grade);
	$("#estoque").val(estoque);
	$("#estoque_grade").val(estoque_grade);
	$("#subtotal").val(preco);	
	$("#qtde").val(1);
	$("#qtde").focus();
		
}

function lista_entradas(data){
	html = "<tr>";
	var total_entrada = 0.00;
	for(var i in data){
		total_entrada += parseFloat(data[i].subtotal_entrada);
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="center">' + data[i].data_entrada + '</td>' + 	
        '<td align="center">' + data[i].produto + '</td>' +
        '<td align="center">' + data[i].localizacao + '</td>' +
        '<td align="center">' + data[i].qtde_entrada + '</td>' + 	
        '<td align="center">' + data[i].valor_entrada + '</td>' + 	
        '<td align="center">' + data[i].subtotal_entrada + '</td></tr>' 
	}
	total = total_entrada.toFixed(2).replace(".",",");
	html += '<tr><td align="right" colspan="7"><b>Total:</b> <span class="text-verde minimo-font" id="total_entrada">' + total +'</span></td> </tr>'
	$("#lista_entradas").html(html);
}

function limpar_entradas(){
	$("#produto_id").val("");
	$("#produtoentreda").val("");
	$("#preco").val("");
	$("#qtde").val(1);
	$("#produtoentreda").focus();
	$("#localizacao_id").html(" ");
}


