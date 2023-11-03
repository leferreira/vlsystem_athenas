
var item_selecionado_id = null;
var CAMPO = "";
var TABELA = "";

$(function () {  
   
});

function inserirMovimentoGradeTemp(grade_id){
	var qtde 		= $("#qtde_grade_item_"+grade_id).val();
	var produto_id 	= $("#produto_id").val();
	var produto_id 	= $("#produto_id").val();
	if(qtde==""){
		alert("Digite um valor para quantidade");
		return false;
	}
	$.ajax({
         url: base_url + "admin/movimentogradetemp/salvarJs" ,
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
						html2 +="<td align='center'><a href='javascript:;' onclick='excluirMovimentoGradeTemp("+ movimentos[m].id +")'  class='btn btn-outline-vermelho btn-pequeno fas fa-trash' title='Excluir'></a></td>";

					html2 +="</tr>" ;	
				}
		}	
		
			$("#lista_movimento_grade_temp").html(html2);
			$("#qtde_movimento").html(data.qtde_movimento);
			$("#estoque_grade_item_" + grade_id).html(data.estoque_grade_item);
		
			
		}, error: function (e) {
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
			        
     });
	
}

function abrirGradeProdutoTemp(item_id, produto_id, campo){	
	item_selecionado_id  = item_id;
	CAMPO = campo;		
	$.ajax({
		url: base_url + "admin/grade/gradeTempComMovimento" ,
	   type: "POST",
	   dataType: "json",
	   data:{
			item_id: item_id,
			produto_id: produto_id,
			campo:campo
		},
		 success: function(data){			
			 montarGradeTemp(data);			 
			 abrirModal("#modalListaGradeTemp");				 
		 }
		
	});		
	
}

function montarGradeTemp(data){
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
								html +="<a href='javascript:;' onclick='inserirMovimentoGradeTemp(" + id_grade + ")' class='btn btn-azul btn-menor ml-1 fa fa-plus-circle' title='Inserir'></a>";
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
				html2 +="<td align='center'><a href='javascript:;' onclick='excluirMovimentoGradeTemp("+ movimentos[m].id +")'  class='btn btn-outline-vermelho btn-pequeno fas fa-trash' title='Excluir'></a></td>";

			html2 +="</tr>" ;	
		}
		
		$("#grade_produto").html(html);
		$("#lista_movimento_grade_temp").html(html2);
		$("#qtde_movimento").html(data.qtde_movimento);
		abrirModal("#modalGradeProduto");
}

function excluirMovimentoGradeTemp(id){
       $.ajax({
         url: base_url + "admin/movimentogradetemp/"  + id ,
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
			
			$("#lista_movimento_grade_temp").html(html2);
			$("#qtde_movimento").html(data.qtde_movimento);
         }
         
     });
}