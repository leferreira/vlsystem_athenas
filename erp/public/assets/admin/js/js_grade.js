
var item_selecionado_id = null;
var CAMPO = "";
var TABELA = "";

$(function () {

  
   
});

function abrirGradeProduto(item_id, produto_id, campo){	
	item_selecionado_id  = item_id;
	CAMPO = campo;		
	$.ajax({
		url: base_url + "admin/grade/gradeComMovimento" ,
	   type: "POST",
	   dataType: "json",
	   data:{
			item_id: item_id,
			produto_id: produto_id,
			campo:campo
		},
		 success: function(data){			
			 montarGrade(data);			 
			 abrirModal("#modalListaGrade");				 
		 }
		
	});		
	
}

function abrirGradeEntradaSaida(produto_id, tabela){
	TABELA = tabela;
	$.ajax({
		url: base_url + "admin/grade/gradeParaEntradaSaida" ,
	   type: "POST",
	   dataType: "json",
	   data:{
			produto_id: produto_id,
			tabela:tabela
		},
		 success: function(data){		
			 montarGradeEntradaSaida(data);				 
		 }
		
	});		
	
}

function inserirMovimentoGrade(grade_id){
	var qtde 		= $("#qtde_grade_item_"+grade_id).val();
	var produto_id 	= $("#produto_id").val();
	var produto_id 	= $("#produto_id").val();
	if(qtde==""){
		alert("Digite um valor para quantidade");
		return false;
	}
	$.ajax({
         url: base_url + "admin/movimentograde/salvarJs" ,
         type: "POST", 
         data: {
			qtde			: qtde,
	   		grade_id 		: grade_id,
	   		produto_id 		: produto_id,	
	   		item_id 		: item_selecionado_id,
	   		campo			: CAMPO
		},
         dataType:"Json",
		 beforeSend: function (){
		   //veio
	   },
		success: function (data) {		
			if(data.tem_erro ==true){
				alert( data.erro);
			}else{	
				var movimentos = data.movimentos;			
				var html2 = "";		
				for(var m in movimentos){			
					html2 +="<tr>" ;
						html2 +="<td>"+ movimentos[m].id + "</td>" ;
						html2 +="<td align='center'>"+ movimentos[m].descricao +"</td>" ;
						html2 +="<td align='center'>"+ movimentos[m].linha +"</td>" ;
						html2 +="<td align='center'>"+ movimentos[m].coluna +"</td>" ;
						html2 +="<td align='center'>"+ movimentos[m].qtde +"</td>" ;
						html2 +="<td align='center'><a href='javascript:;' onclick='excluirMovimentoGrade("+ movimentos[m].id +")'  class='btn btn-outline-vermelho btn-pequeno fas fa-trash' title='Excluir'></a></td>";

					html2 +="</tr>" ;	
				}
		}	
		
			$("#lista_movimento_grade").html(html2);
			$("#qtde_movimento").html(data.qtde_movimento);
			$("#estoque_grade_item_" + grade_id).html(data.estoque_grade_item);
		
			
		}, error: function (e) {
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
			        
     });
	
}

function montarGrade(data){
	var grade = data.grade;
	var movimentos = data.movimentos;
	var variacao_coluna = grade.variacao_coluna;
	var variacao_linha = grade.variacao_linha;
	
	$("#variacao_coluna").html(variacao_coluna);
	$("#variacao_linha").html(variacao_linha);
	 var html = "";		
		for(var l in grade.linhas){
			html +="<div class='scrollH'>";
			for(var c in grade.colunas){				
				var id_linha = grade.linhas[l].id;
				var id_coluna= grade.colunas[c].id;
				var id_grade = grade.grade[id_linha][id_coluna].id;	
				var estoque  = grade.grade[id_linha][id_coluna].estoque_temporario;
			
				html +="<div class='cols'>";
					html +="<div class='border cxCor'>";
						html +="<div>";
							html +="<small>"+ grade.variacao_linha  + ": <b>" + id_grade + "</b></small>" ;
							html +="<small>"+ grade.variacao_coluna + ": <b>" + grade.colunas[c].valor + "</b></small>" ;
							html +="<span class='tt'>Estoque: <b id='estoque_grade_item_" + id_grade + "'>" + estoque + "</b></span>" ;
						html +="</div>";						
							html +="<div class='d-flex mt-1 align-items-center'>";
								html +="<input type='text' id='qtde_grade_item_" + id_grade + "' class='input' placeholder='qtde'>";
								html +="<a href='javascript:;' onclick='inserirMovimentoGrade(" + id_grade + ")' class='btn btn-azul btn-menor ml-1 fa fa-plus-circle' title='Inserir'></a>";
							html +="</div>";												
					html +="</div>";					
				html +="</div>";	
							
			}
			html +="</div>";
		}
		
		
		var html2 = "";		
		for(var m in movimentos){			
			html2 +="<tr>" ;
				html2 +="<td>"+ movimentos[m].id + "</td>" ;
				html2 +="<td align='center'>"+ movimentos[m].descricao +"</td>" ;
				html2 +="<td align='center'>"+ movimentos[m].linha +"</td>" ;
				html2 +="<td align='center'>"+ movimentos[m].coluna +"</td>" ;
				html2 +="<td align='center'>"+ movimentos[m].qtde +"</td>" ;
				html2 +="<td align='center'><a href='javascript:;' onclick='excluirMovimentoGrade("+ movimentos[m].id +")'  class='btn btn-outline-vermelho btn-pequeno fas fa-trash' title='Excluir'></a></td>";

			html2 +="</tr>" ;	
		}
		
		$("#grade_produto").html(html);
		$("#lista_movimento_grade").html(html2);
		$("#qtde_movimento").html(data.qtde_movimento);
		abrirModal("#modalGradeProduto");
}

function montarGradeEntradaSaida(data){
	var grade = data.grade;
	var variacao_coluna = grade.variacao_coluna;
	var variacao_linha = grade.variacao_linha;
	
	$("#variacao_coluna").html(variacao_coluna);
	$("#variacao_linha").html(variacao_linha);
	 var html = "";		
		for(var l in grade.linhas){
			html +="<div class='scrollH'>";
			for(var c in grade.colunas){				
				var id_linha = grade.linhas[l].id;
				var id_coluna= grade.colunas[c].id;
				var id_grade = grade.grade[id_linha][id_coluna].id;	
				var estoque  = grade.grade[id_linha][id_coluna].estoque_temporario;
			
				html +="<div class='cols'>";
					html +="<div class='border cxCor'>";
						html +="<div>";
							html +="<small>"+ grade.variacao_linha  + ": <b>" + id_grade + "</b></small>" ;
							html +="<small>"+ grade.variacao_coluna + ": <b>" + grade.colunas[c].valor + "</b></small>" ;
							html +="<span class='tt'>Estoque: <b id='estoque_grade_item_" + id_grade + "'>" + estoque + "</b></span>" ;
						html +="</div>";						
							html +="<div class='d-flex mt-1 align-items-center'>";
								html +="<input type='text' id='qtde_grade_item_" + id_grade + "' class='input' placeholder='qtde'>";
								html +="<a href='javascript:;' onclick='inserirEntradaSaida("+ id_grade +")'  class='btn btn-azul btn-menor ml-1 fa fa-plus-circle' title='Inserir'></a>";
							html +="</div>";												
					html +="</div>";					
				html +="</div>";	
							
			}
			html +="</div>";
		}
		
		
		
		$("#grade_produto").html(html);
		abrirModal("#modalGradeParaEntradaSaida");
}

function excluirMovimentoGrade(id){
       $.ajax({
         url: base_url + "admin/movimentograde/"  + id ,
         type: "DELETE",
         data: {  },
         dataType:"Json",
         success: function(data){
             var html2 = "";	
             var movimentos = data.movimentos;	
			for(var m in movimentos){			
				html2 +="<tr>" ;
					html2 +="<td>"+ movimentos[m].id + "</td>" ;
					html2 +="<td align='center'>"+ movimentos[m].descricao +"</td>" ;
					html2 +="<td align='center'>"+ movimentos[m].linha +"</td>" ;
					html2 +="<td align='center'>"+ movimentos[m].coluna +"</td>" ;
					html2 +="<td align='center'>"+ movimentos[m].qtde +"</td>" ;
					html2 +="<td align='center'><a href='javascript:;' onclick='excluirMovimentoGrade("+ movimentos[m].id +")'  class='btn btn-outline-vermelho btn-pequeno fas fa-trash' title='Excluir'></a></td>";
	
				html2 +="</tr>" ;	
			}
			
			$("#lista_movimento_grade").html(html2);
			$("#qtde_movimento").html(data.qtde_movimento);
         }
         
     });
}



function inserirEntradaSaida(grade_id){
	var produto_id	= $("#produto_id").val();	
	var preco		= $("#preco").val();	
	var qtde		= $("#qtde_grade_item_"+grade_id).val();
	var observacao	= $("#observacao").val();
	var unidade		= $("#unidade_"+TABELA).val();
	
	if(qtde==""){
		alert("Digite um valor para quantidade");
		return false;
	}
	$.ajax({
         url: base_url + "admin/movimentograde/inserirEntradaSaida" ,
         type: "POST", 
         data: {
			valor			: preco,
			qtde			: qtde,
	   		grade_id 		: grade_id,
	   		observacao		: observacao,
	   		produto_id 		: produto_id,	
	   		unidade 		: unidade,
	   		tabela			: TABELA,
		},
         dataType:"Json",
		 beforeSend: function (){
		   //veio
	   },
		success: function (data) {		
			if(data.tem_erro ==true){
				alert( data.erro);
			}else{	
				alert("Operação realizada com sucesso");
			}		
			
		}, error: function (e) {
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
			        
     });
	
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


$('#btnInserir').click(() => {
	var estoque_grade 	= percorrerTabela();
	   
	$.ajax({
         url: base_url + "admin/itemvenda/ajustarGrade" ,
         type: "POST", 
         data: {
			item_venda_id	: item_venda_id,
	   		estoque_grade 	: estoque_grade,
	
		},
         dataType:"Json",
		 beforeSend: function (){
		   giraGira();
	   },
		success: function (data) {
			fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{				
				location.href = data.redirect;
			}
		}, error: function (e) {
			console.log(e);
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
			        
     });	
	
});


function inserirItem(){
	var cliente_id		= $('#cliente_id').val();
	var	vendedor_id		= $('#vendedor_id').val();
	var	tabela_preco_id	= $('#tabela_preco_id').val();
	var ITENS 			= [];
	
	ITENS.push({
			venda_id: $("#venda_id").val(), 
			produto_id: $("#produto_id").val(), 
			quantidade: $("#quantidade").val(), 
			unidade: $("#unidade_venda").val(), 
			valor: $("#preco").val(),
			desconto_percentual: $('#desconto_percentual').val(),
			desconto_por_valor: $('#desconto_por_valor').val()
		})	
		
		
	if(ITENS.length<=0){
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira algum item antes!"));	
		return false;
	}
	if( (cliente_id == '--') || (cliente_id == '') ||(cliente_id == 'null') ||(cliente_id == null)) {
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Não foi possível salvar a venda, Selecione um cliente para continuar!"));	
		return false;	
	}
	
	$.ajax({
		url: base_url + "admin/itemvenda",
	   type: "POST",
	   dataType: "json",
	   data:{	
	   		cliente_id 		: cliente_id,
	   		vendedor_id 	: vendedor_id,
	   		tabela_preco_id : tabela_preco_id,
	   		itens			: ITENS
	   		
	   	},
		 beforeSend: function (){
		   giraGira();
	   },
		success: function (data) {
			fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{				
				location.href = data.redirect;
			}
		}, error: function (e) {
			console.log(e);
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
		
	});
}



function percorrerTabela(){
	var id = "";
	var retorno = [];  
	SOMA_QTDE = 0.0;
	$("#lista_grade_produto tr").each(function(){
		let grade 		= new Object();
		id 				= $(this).find("td:eq(0)").attr("id");		
		grade.id 		= id;
		grade.estoque 	= $("#estoque_"+id).val();
		grade.qtde 		= $("#valor_"+id).val();
		retorno.push(grade);          
	});
	
   return retorno;
   
}