var unidades = [];
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});
$(function () {
	
	
   $("#produtosaida").on("keyup", function(){
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
			   $("#produtosaida").after('<div class="listaProdutos"></div>');
			   html="";
			   for(var i in data){
				var estoque = data[i].estoque !=null ? data[i].estoque.quantidade : 0;
				var estoque_grade = data[i].estoque !=null ? data[i].estoque.qtde_grade : 0;
				   html +='<div class="si"><a href="javascript:;" onclick="selecionarProdutoSaida(this)" ' +
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

function inserirSaidaEstoque(){
	
	var id			= $("#produto_id").val();	
	var preco		= $("#preco").val();	
	var qtde		= $("#qtde").val();	
	var observacao	= $("#observacao").val();
	var unidade		= $("#unidade_saida").val();	
		
	
	$.ajax({
		url: base_url + "admin/saida/salvarJs",
	   type: "POST",
	   dataType: "json",
	   data:{	
	   		produto_id		:id,
	   		qtde_saida	: qtde,
	   		valor_saida	: preco,
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

function verificarInserirSaida(){
	var usa_grade 	= $("#usa_grade").val();
	var produto_id	= $("#produto_id").val();
	if(usa_grade =="S"){
		abrirGradeEntradaSaida(produto_id, "saida");		
	}else{
		inserirSaidaEstoque();
	}
}

function listaGradeProduto(data){	
	html = "<tr>";
	for(var i in data.grade){
		var nome_id 	= "valor_"+ data.grade[i].id;
		var estoque_id 	= "estoque_"+ data.grade[i].id;
		html += 
		'<td align="center" id="'+ data.grade[i].id +'" >' + data.grade[i].id + '</td>' +
        '<td align="center">' + data.grade[i].codigo_barra + '</td>' + 	
        '<td align="center">' + data.grade[i].descricao + '</td>' +
        '<td align="center">' + data.grade[i].linha.valor + '</td>' +
        '<td align="center">' + data.grade[i].coluna.valor + '</td>' + 	
        '<td align="center"><input type="hidden" id="'+ estoque_id +'" value="'+ data.grade[i].estoque +'">' + data.grade[i].estoque + '</td>' +	
        '<td align="center"><input type="text" id="'+ nome_id +'" class="form-campo mascara-float"></td></tr>' 
	}
	total = data.soma_estoque;
	$("#lista_grade_produto").html(html);
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
	var unid = $("#unidade_saida").val();
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

function selecionarProdutoSaida(obj){
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

	$("#unidade_saida").html(html);
	
	$(".listaProdutos").hide();
	
	$("#produto_id").val(id);
	$("#produtosaida").val(nome);
	$("#preco").val(preco);
	$("#usa_grade").val(usa_grade);
	$("#estoque").val(estoque);
	$("#estoque_grade").val(estoque_grade);
	$("#subtotal").val(preco);	
	$("#qtde").val(1);
	$("#qtde").focus();
		
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
	$("#produtosaida").val("");
	$("#preco").val("");
	$("#qtde").val(1);
	$("#produtosaida").focus();
	$("#localizacao_id").html(" ");
}


