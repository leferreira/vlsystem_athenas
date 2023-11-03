var eh_modal = 0;
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});
$(function () {
   $("#btnInserirTributacao").on("click", function(){
		var natureza_id = $('#natureza_operacao_id').val();
		eh_modal = 1;	
		$.ajax({
		   url: base_url + "admin/tributacao",
		   type: "POST",
		   dataType: "json",
		   data: $("#frmCadTributacao").serialize(),
		   success: function (data){
				if(data.tem_erro == true){
					fecharGiraGira(eh_modal);
					$("#erroModalLivre").html(data.erro);
					abrirModalLivre("#modalLivreErro");
				}else{
					location.reload();
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
   });

   $("#nomeProduto").on("keyup", function(){
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
			   $("#nomeProduto").after('<div class="listaProdutos"></div>');
			   html="";
			   for(var i in data){
				   html +='<div class="si"><a href="javascript:;" onclick="selecionarProdutoTributacao(this)" ' +
				   		  'data-id="'+data[i].id +
				   		  '" data-nome = "' + data[i].nome + '">' +  data[i].id + " -  " + data[i].nome + '</a></div>';
			   }
			   
			   $(".listaProdutos").html(html);
			   $(".listaProdutos").show();
		   }
	   });
   });
	
		
});

function verLista(){
	var tipo = $("#tipo").val();
	if(tipo == ""){
		return ;
	}else{
		verListaIPI(tipo);
		verListaCfop(tipo)
	}
}
function verListaIPI(tipo){	
	$.ajax({
			url: base_url + "admin/naturezaoperacao/buscarCstIpi/" + tipo,
		   type: "get",
		   dataType: "json",
		   data:{},
			 success: function(data){
				 html = "";
				for(var i in data){
					html += '<option value="' + data[i].cst + '">' +  data[i].descricao + '</option>';
			   }
				$("#cstIpi").html(html);
			 }
			
		});
}

function verListaCfop(tipo){	
	$.ajax({
			url: base_url + "admin/naturezaoperacao/buscarListaCfop/" + tipo,
		   type: "get",
		   dataType: "json",
		   data:{},
			 success: function(data){
				 html = "";
				for(var i in data){
					html += '<option value="' + data[i].cfop + '">' + data[i].cfop + ' - ' + data[i].descricao + '</option>';
			   }
				$("#cfop").html(html);
			 }
			
		});
}

$("#btnInserirProdutoTributacao").on("click", function(){
		var natureza_operacao_id= $("#natureza_operacao_id").val();
		var tributacao_id 		= $("#tributacao_id").val();
		var produto_id 			= $("#produto_id").val();	
	
		if(natureza_operacao_id==""){
			alert("Selecionar a natureza de operação primeiramente");
			return;
		}
		
		if(tributacao_id==""){
			alert("Selecionar a tributação primeiramente");
			return;
		}
		
		if(produto_id==""){
			alert("Selecionar o Produto primeiramente");
			return;
		}
		
		$.ajax({
			url: base_url + "admin/tributacao/inserirProduto",
		   type: "POST",
		   dataType: "json",
		   data:{	
		   		produto_id				: produto_id,
		   		natureza_operacao_id	: natureza_operacao_id,
		   		tributacao_id			: tributacao_id
		   	},
			 success: function(data){
				 lista_produto_tributacao(data);
				 limpar_produto_tributacao();
			 }
			
		});
	});


function abrirTelaProduto(id){
	$("#tributacao_id").val(id);
	$.ajax({
	   url: base_url + "admin/tributacao/listaProdutoTributacao/"  + id,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
			 lista_produto_tributacao(data);
		 }		
	});
	abrirModal('#telaProduto');
}
	
function selecionarProdutoTributacao(obj){
	var id		= $(obj).attr('data-id');
	var nome	= $(obj).attr('data-nome');
	$(".listaProdutos").hide();
	
	$("#produto_id").val(id);
	$("#nomeProduto").val(nome);
	$("#nomeProduto").focus();
		
}

function lista_produto_tributacao(data){
	html = "<tr>";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="left">' + data[i].nome + '</td>' + 
       	'<td align="center"><a href="javascript:;" onclick="excluirProdutoTributacao('+ data[i].id +')"  class="btn btn-outline-vermelho btn-pequeno fas fa-trash" title="Excluir"></a></td></tr>'
	}
	$("#lista_produto_tributacao").html(html);
}

function excluirProdutoTributacao(id){
       $.ajax({
         url: base_url + "admin/tributacao/excluirProdutoTributacao/"  + id ,
         type: "GET",
         data: {  },
         dataType:"Json",
         success: function(data){
             lista_produto_tributacao(data.retorno);
			 limpar_produto_tributacao();
         }
         
     });
}

function limpar_produto_tributacao(){
	$("#produto_id").val("");
	$("#nomeProduto").val("");
}

function selecionarIcms(){
	var cstICMS = $("#cstICMS").val();
	sumirTodos();	
	if(cstICMS=="00"){
		$("#divModBC").show();
		$("#divPICMS").show();
		$("#divPFCP").show();
		$("#divVICMSSubstituto").show();
	}else if(cstICMS=="10"){
		$("#divModBC").show();
		$("#divPICMSST").show();
		$("#divPICMS").show();
		$("#divPMVAST").show();
		$("#divPRedBCST").show();
		$("#divModBCST").show();
		$("#divVICMSSubstituto").show();
		$("#divPFCP").show();
		$("#divPFCPST").show();
	}else if(cstICMS=="20"){
		$("#divModBC").show();
		$("#divPICMS").show();
		$("#divPRedBC").show();
		$("#divVICMSSubstituto").show();
		$("#divPFCP").show();
	
	}else if(cstICMS=="30"){
		$("#divPICMSST").show();
		$("#divPMVAST").show();
		$("#divPRedBCST").show();
		$("#divModBCST").show();
		$("#divVICMSSubstituto").show();
		$("#divPFCPST").show();
	}else if(cstICMS=="40" || cstICMS=="41" || cstICMS=="50" ){
		$("#divVICMSSubstituto").show();
	}else if(cstICMS=="30"){
		$("#divModBC").show();
		$("#divPICMS").show();
		$("#divPRedBC").show();
		$("#divVICMSSubstituto").show();
		$("#divPFCP").show();
		$("#divPFCPST").show();
	}
}
function desabilitarTodos(){
	$("#modBC").prop('readonly', true);
	$("#divPICMS").prop('readonly', true);
	$("#divPRedBC").prop('readonly', true);
	$("#modBCST").prop('readonly', true);
	$("#vBCST").prop('readonly', true);
	$("#divPICMSST").prop('readonly', true);
	$("#divPMVAST").prop('readonly', true);
	$("#pRedBCST").prop('readonly', true);
	$("#pFCP").prop('readonly', true);
	$("#pFCPST").prop('readonly', true);
	$("#pFCPSTRet").prop('readonly', true);
	$("#divVICMSSubstituto").prop('readonly', true);
	$("#pDif").prop('readonly', true);
}

function sumirTodos(){
	$("#divModBC").hide();
	$("#divPICMS").hide();
	$("#divPRedBC").hide();
	$("#divModBCST").hide();
	$("#divVBCST").hide();
	$("#divPICMSST").hide();
	$("#divPMVAST").hide();
	$("#divPRedBCST").hide();
	$("#divVICMSSubstituto").hide();
	$("#divPFCP").hide();
	$("#divPFCPST").hide();
	$("#divVFCP").hide();
	$("#divPFCPSTRet").hide();
	$("#divPDif").hide();
}
function selecionarPis(){

}
