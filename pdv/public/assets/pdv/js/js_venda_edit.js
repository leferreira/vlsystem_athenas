//VENDA PDV

var ITENS 		= [];
var FATURA 		= [];

var TOTAL_FATURA    = 0;

var QTDE_ITEM       = 0;
var TOTAL_VENDA 	= 0;
var TOTAL_DESCONTO 	= 0
var TOTAL_ACRESCIMO	= 0;
var TOTAL_RECEBIDO	= 0;
var TOTAL_GERAL 	= parseFloat(TOTAL_VENDA + TOTAL_ACRESCIMO - TOTAL_DESCONTO).toFixed(2);

var DESCONTO_ITEM   = 0;
var BUSCA_PELO_PRODUTO = false;
var grade_produto_id = null;
let cronometro;
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});


$(document).ready(function() {
	
	$('.tecla').bind('keydown', 'f8',function() {
		$("#codigo_produto").focus();
		return false;
	});
	
	$('.tecla').bind('keydown', 'f1',function() {
		abrirModal("#telaPesquisaProduto");
		//$("#codigo_produto").focus();
		return false;
	});
	
	
	$('.tecla').bind('keydown', 'Shift+C',function() {
		abrirModal("#telaPesquisaCliente");
		return false;
	});
	
	$('.tecla').bind('keydown', 'insert',function() {
		inserirItem();
		//$("#codigo_produto").focus();
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+1',function() {
		telaQtdeDesconto();	
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+2',function() {
		abrirModal("#verTelaSangria");		
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+3',function() {
		abrirModal("#verTelaSuplemento");		
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+C',function() {
		telaCliente();	
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+F',function() {
		abrirModal('#fecharCaixa')	
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+R',function() {
		resgatar();
		return false;
	});
	
	$('.tecla').bind('keydown', 'f2',function() {
		finalizarVenda();
		return false;
	});
	
	$('.tecla').bind('keydown', 'f3',function() {	
		selecionarFormaPagamento(1,"Dinheiro");	
		return false;
	});
	
	$('.tecla').bind('keydown', 'f4',function() {
		selecionarFormaPagamento(17,"Pix");
		return false;
	});
	$('.tecla').bind('keydown', 'f5',function() {
		selecionarFormaPagamento(16,"Transferência");
		return false;
	});
	$('.tecla').bind('keydown', 'f6',function() {
		selecionarFormaPagamento(3,"Cartão Crédito");
		return false;
	});
	
	$('.tecla').bind('keydown', 'f7',function() {
		selecionarFormaPagamento(4,"Cartão Débito");		
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+a',function() {
		habilitarAcrescimo();		
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+d',function() {		
		habilitarDesconto();		
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+s',function() {
		abrirModal('#sairPdv');				
		return false;
	});
	
	$('.tecla').bind('keydown', 'esc',function() {		
		cancelarVenda();		
		return false;
	});
	
	$('.tecla').bind('keydown', 'f10',function() {		
		salvarVenda();		
		return false;
	});
	
	
	$(document).bind('keydown', 'f8',function() {
		$("#codigo_produto").focus();
		return false;
	});
	
	$(document).bind('keydown', 'f1',function() {
		abrirModal("#telaPesquisaProduto");	
		//$("#codigo_produto").focus();
		return false;
	});
	
	$(document).bind('keydown', 'Shift+C',function() {
		abrirModal("#telaPesquisaCliente");	
		return false;
	});
	
	$(document).bind('keydown', 'insert',function() {
		inserirItem();
		return false;
	});
	
	$(document).bind('keydown', 'f2',function() {
		finalizarVenda();
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+1',function() {			
		telaQtdeDesconto();	
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+2',function() {
		abrirModal("#verTelaSangria");		
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+3',function() {
		abrirModal("#verTelaSuplemento");		
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+C',function() {
		telaCliente();		
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+F',function() {
		abrirModal('#fecharCaixa')	
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+R',function() {
		resgatar();	
		return false;
	});
	
	$(document).bind('keydown', 'f3',function() {	
		selecionarFormaPagamento(1,"Dinheiro");	
		return false;
	});
	
	$(document).bind('keydown', 'f4',function() {
		selecionarFormaPagamento(17,"Pix");
		return false;
	});
	$(document).bind('keydown', 'f5',function() {
		selecionarFormaPagamento(16,"Transferência");
		return false;
	});
	$(document).bind('keydown', 'f6',function() {
		selecionarFormaPagamento(3,"Cartão Crédito");
		return false;
	});
	$(document).bind('keydown', 'f7',function() {
		selecionarFormaPagamento(4,"Cartão Débito");		
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+a',function() {
		habilitarAcrescimo();		
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+d',function() {		
		habilitarDesconto();		
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+s',function() {
		abrirModal("#sairPdv");		
		return false;
	});
		
	$(document).bind('keydown', 'esc',function() {		
		cancelarVenda();		
		return false;
	});
	
	$(document).bind('keydown', 'f10',function() {		
		salvarVenda();		
		return false;
	});	
	
	
	
	$("#codigo_produto").on("keydown", function(event){
		var q = $(this).val();	
		if(BUSCA_PELO_PRODUTO==true){
			grade_produto_id = null;
			inserirItem();
			return;
		} 
			
		if(q!=""){
			if(event.keyCode==13){
				grade_produto_id = null;
				inserirItem(0);
			}
		}
	});
	
	
	
	
	
	
	$("#desconto_percentual").on("keydown", function(event){
		$("#desconto_por_valor").val("0");
	});
	
	$("#desconto_por_valor").on("keydown", function(event){
		$("#desconto_percentual").val("0");
	});
	
	$("#valor_pago").on("keydown", function(event){
		if(event.keyCode==13){
			inserirDuplicata();
		}
	});
	
	$("#qtde_produto_antecipado").on("keydown", function(event){
		if(event.keyCode==13){
			confirmarQtdeDesconto();
		}
	});
	
	$("#valor_desconto_item_antecipado").on("keydown", function(event){
		if(event.keyCode==13){
			confirmarQtdeDesconto();
		}
	});
	
	
$("#pesquisaProduto").on("keyup", function(){
       var q 			= $("#pesquisaProduto").val(); 
       grade_produto_id = null; 
       if(q==""){
			$("#listaProduto").html("");
			return;
		}	
    
       $.ajax({
         url: base_url + "produto/pesquisarProdutoPorNome",
         type: "get",
         data: {
             q:q
         },
         dataType:"Json",
         success: function(data){	
			if(data.tem_erro==true){
				$("#listaProduto").html("");
			}else{
				listarProduto(data);
			}
                       
         }         
     });
   }) 
	
});

$("#valor_busca_cliente").on("keyup", function(){
       var campo			= $("#campo_busca_cliente").val(); 
       var valor 			= $("#valor_busca_cliente").val(); 
       grade_produto_id = null; 
       if(valor==""){
			$("#listaCliente").html("");
			return;
		}	
    
       $.ajax({
         url: base_url + "cliente/buscaCliente",
         type: "post",
         data: {
             campo:campo,
             valor:valor
         },
         dataType:"Json",
         success: function(data){	
			if(data.tem_erro==true){
				$("#listaCliente").html("");
			}else{
				
				listarCliente(data.retorno.lista);
			}
                       
         }         
     });
   }); 
	
function resgatar(){
	location.href=base_url + "resgate/index" ;
}

function irParaFinalizarVenda(){
	var venda_id = $("#venda_id").val();
	if(venda_id){
		location.href=base_url + "pdv/pagamento/" +venda_id ;
	}else{
		alert("Insera algum item primeiramente !");
	}
	
}


function inserirItem(){
	var q 					= $("#codigo_produto").val();
	var qtde 				= converteMoedaFloat($("#qtde").val());
	var venda_id			= $("#venda_id").val();
	var desconto_percentual	= $("#desconto_percentual").val();
	var desconto_por_valor	= $("#desconto_por_valor").val();
	var codigo_cupom		= $("#codigo_cupom").val();
	
	BUSCA_PELO_PRODUTO 		= false;	
	$.ajax({
		type: 'POST',
		data: {
			q					: q,
			qtde				: qtde,
			venda_id			: venda_id,	
			desconto_percentual	: desconto_percentual,
			desconto_por_valor 	: desconto_por_valor,
			grade_id			: grade_produto_id,
			codigo_cupom		: codigo_cupom,
		},
		url: base_url + 'venda/inserirItem',
		dataType: 'json',
		beforeSend: function (){
			$("#codigo_produto").blur();
			$(".suspenso").css("display", "flex" );
	   },
		success: function (e) {
			fecharModal();
			
			if(e.tem_erro == true){	
				alert("Erro na pesquisa de Produto");
			}else{
				if(e.retorno.tem_erro == true){
					alert(e.retorno.erro);
				}
				if(e.retorno.eh_grade==true){
					montarGrade(e.retorno.grade);
				}else{
					if(venda_id==""){
						location.reload();
					}
					$("#id_venda").val(e.retorno.id);		
					$("#venda_id").val(e.retorno.id);			
					preencherDados(e.retorno);
					listaItens(e.retorno.itens);
					limparCamposFormProd();
				}				
			}
			
			$(".suspenso").css("display", "none" );
			$("#codigo_produto").focus();
				
			
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
}

function aplicarCupom(){
	var venda_id			= $("#venda_id").val();
	var codigo_cupom		= $("#codigo_cupom").val();
	$.ajax({
		type: 'POST',
		data: {
			venda_id			: venda_id,	
			codigo_cupom		: codigo_cupom,
		},
		url: base_url + 'venda/aplicarCupom',
		dataType: 'json',
		beforeSend: function (){
			$(".suspenso").css("display", "flex" );
	   },
		success: function (e) {
			fecharModal();			
			if(e.tem_erro == true){	
				alert("Erro: " + e.erro);
			}else{
				if(e.retorno.tem_erro == true){
					alert(e.retorno.erro);
				}else{
					location.reload();
				}				
			}
			
			$(".suspenso").css("display", "none" );
			$("#codigo_produto").focus();			
				
			
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
}

function montarGrade(grade){
	 var html = "";
		for(var l in grade.linhas){
			html +="<div class='scrollH' >";
			
			for(var c in grade.colunas){
				id_linha = grade.linhas[l].id;
				id_coluna= grade.colunas[c].id;
				id_grade = grade.grade[id_linha][id_coluna].id;
				if(id_grade!=-1){
					if(grade.grade[id_linha][id_coluna].estoque > 0){
						html +="<div class='cols'>";
						html +="<a href='javascript:;' onclick='inserirGradeProduto(" + id_grade +")' class='border cxCor'>";
						html +="<span class='tt'>"+ grade.variacao_linha  + ": <b>" + grade.linhas[l].valor + "</b>	</span>";
						html +="<span class='tt'>"+ grade.variacao_coluna + ": <b>" + grade.colunas[c].valor + "</b>	</span>";							
						html +="<span class='tt'>Estoque: <b>" + grade.grade[id_linha][id_coluna].estoque +"</b></span>";
						html +="</a>";	
					html +="</div>";
					}else{
						html +="<div class='cols'>";
						html +="<a href='javascript:;'  class='border cxCor'>";
						html +="<span class='tt'>"+ grade.variacao_linha  + ": <b>" + grade.linhas[l].valor + "</b>	</span>";
						html +="<span class='tt'>"+ grade.variacao_coluna + ": <b>" + grade.colunas[c].valor + "</b>	</span>";							
						html +="<span class='tt'>Estoque: <b>" + grade.grade[id_linha][id_coluna].estoque +"</b> </span>";
						html +="</a>";	
						html +="</div>";
					}
					
				}else{					
						html +="<div class='cols'>";	
						html +="<a href='javascript:;' class='border cxCor vazio'>";								
						html +="<b>Vazio</b>"
						html +="</a>";			
						html +="</div>";									
							
					html +="</div>";			
				}			
				
			}
			html +="</div>";
		}
		
		
		$("#grade_produto").html(html);
		abrirModal("#modalGradeProduto");
	}

function inserirGradeProduto(id){
	grade_produto_id = id;
	inserirItem(0);
}	
function deleteItem(id) {
	var venda_id = $("#venda_id").val();
	alert(venda_id);
	$.ajax({
		type: 'GET',
		data: {},
		url: base_url + 'venda/excluirItem/' + id + "/" + venda_id ,
		dataType: 'json',
		beforeSend: function (){
		   giraGira();
	   },
		success: function (e) {
			fecharModal();
			if(e.tem_erro == true){
				alert(e.erro);
			}else{
				preencherDados(e.retorno.data);
				listaItens(e.retorno.data.itens);
			}		
			
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
}

function listaItens(itens) {
	html = '<tr>';
	for(var i in itens){	
		html += "<tr class='datatable-row' style='left: 0px;'>";
		html += "<td class='datatable-cell cod'><span class='codigo' style='width: 60px;'>" + itens[i].id + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + itens[i].produto.nome + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + converteFloatMoeda(itens[i].qtde) + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(itens[i].valor) + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(itens[i].total_desconto_item) + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(itens[i].subtotal_liquido) + "</span></td>";
		html += "<td class='datatable-cell text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-vermelho btn-pequeno d-inline-block' href='#prod tbody' onclick='deleteItem(" + itens[i].id + ")'>"
		html += "<i class='fas fa-trash'></i></a></span></td>";
		html += "</tr>";
	}	
	$("#itensDaVenda").html(html);
}


function inserirDuplicata(){
	var tPag 				= $("#id_forma_pagamento").val();
	var venda_id 			= $("#venda_id").val();
	var caixa_id 			= $("#caixa_id").val();
	var vDup 				= converteMoedaFloat($("#valor_pago").val());
	var qtde_vezes 			= converteMoedaFloat($("#qtde_vezes").val());	
	
	if(vDup <= 0){
		alert("O valor precisa ser maior que zero");
		return;
	}	

	if(TOTAL_RESTANTE <= 0){
		alert("Não é mais possível inserir uma forma de pagamento");
		return;
	}
	
	if(TOTAL_RESTANTE < vDup){
		alert("O valor a Pagar precisa ser menor ou igual ao total restante");
		return;
	}
	
	$.ajax({
		type: 'POST',
		data: {
			venda_id: venda_id,
			caixa_id: caixa_id,
			tPag: tPag,
			vDup: vDup,
			qtde_vezes: qtde_vezes			
		},
		url: base_url + 'venda/salvarPagamento',
		dataType: 'json',
		beforeSend: function (){
		   giraGira();
	   },
		success: function (e) {
			fecharModal();
			if(e.tem_erro == true){
				alert(e.erro);
			}else{
			
				preencherDados(e.retorno.data);
				listaDuplicata(e.retorno.data.duplicatas);
				TOTAL_RESTANTE = e.retorno.data.valor_restante;
				$("#valor_pago").val(converteFloatMoeda(TOTAL_RESTANTE));
				limparDuplicata();
				
			}		
			
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
		
}

function excluirDuplicata(id) {
	$.ajax({
		type: 'Get',
		data: {},
		url: base_url + 'venda/excluirDuplicata/' + id +"/" + $("#venda_id").val(),
		dataType: 'json',
		beforeSend: function (){
		   $(".suspenso").css("display", "flex" );
	   },
		success: function (e) {
			$(".suspenso").css("display", "none" );
			if(e.tem_erro == true){
				alert(e.erro);
			}else{
				preencherDados(e.retorno.data);
				listaDuplicata(e.retorno.data.duplicatas);
				TOTAL_RESTANTE = e.retorno.data.valor_restante;
				$("#valor_pago").val(converteFloatMoeda(TOTAL_RESTANTE));
			}		
			
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			$(".suspenso").css("display", "none" );
			alert(response.errors);	
		}
	});
}

function listaDuplicata(duplicatas){
	html = '<tr>';
	for(var i in duplicatas){
		html += '<td class="text-center">' + duplicatas[i].id  + '</td>' + 
				'<td class="text-center">' + duplicatas[i].pagto.forma_pagto + '</td>' + 
				'<td class="text-center">' + dataBr(duplicatas[i].dVenc)  + '</td>' + 
				'<td class="text-center">' + duplicatas[i].vDup  + '</td>'+
				'<td class""><a class="btn btn-vermelho btn-pequeno d-inline-block"" href="#prod tbody" onclick="excluirDuplicata(' + duplicatas[i].id  + ')">' +
				'<i class="fas fa-trash"></i></a></span></td></tr>';		
	}
	
	$("#lista_pagamento").html(html);	
	
}


function preencherDados(data){
	$('#lbl_total_vendido').html(converteFloatMoeda(data.valor_venda));
	$('#lbl_desconto').html(converteFloatMoeda(data.valor_desconto));
	$('#lbl_acrescimo').html(converteFloatMoeda(data.valor_acrescimo));
	$('#lbl_total_geral').html(converteFloatMoeda(data.valor_liquido));
	$('#lbl_total_recebido').html(converteFloatMoeda(data.valor_pago));
	$('#lbl_total_restante').html(converteFloatMoeda(data.valor_restante));
	
	$('#volume').val(converteFloatMoeda(data.qtde_volume));
	$('#total_geral').val(converteFloatMoeda(data.valor_liquido));
	
	
}

function limparCamposFormProd() {
	$('#id_produto').val('');
	$('#qtde').val('1');
	$('#desconto_percentual').val('0');
	$('#desconto_por_valor').val('0');
	$('#preco').val('0');
	$('#tipo_desconto_item').val("desc_perc");
	$('#valor_desconto_item').val(converteFloatMoeda(0));
	$('#qtde').val(converteFloatMoeda(1));	
	$('#codigo_produto').val('');
	$('#descricao').html('Selecione um Produto');
	$('#subtotal').val('');
	$('#codigo_produto').focus();
	$("#imagem").attr("src", base_url + "assets/pdv/img/semimagem.jpg");	
}


function selecionarFormaPagamento(id_forma,txt_forma){
	$("#txt_forma_pagamento").val(txt_forma);
	$("#id_forma_pagamento").val(id_forma);	
	$("#qtde_vezes").val(1);
	
	habilitaEntradaPagamento();
	$("#valor_pago").val(converteFloatMoeda(TOTAL_RESTANTE));
	$('#valor_troco').val(converteFloatMoeda(0.00));
	$("#valor_pago").focus();
}


$('#valor_recebido').on('keyup', () => {
	calculaTroco()
})

function calculaTroco(){
	var valor_pago 		= converteMoedaFloat($("#valor_pago").val());	
	var valor_recebido 	= converteMoedaFloat($("#valor_recebido").val());	
	var valor_troco 	= valor_recebido - valor_pago;
	$('#valor_troco').val(converteFloatMoeda(valor_troco.toFixed(2)));
	return valor_troco;	
}


function calculaParcela(){
	var qtde_vezes = $("#qtde_vezes").val();
	var valor_pago = converteMoedaFloat($("#valor_pago").val());
	var parcela = valor_pago / parseInt(qtde_vezes);	
	$('#valor_parcela').val(converteFloatMoeda(parcela.toFixed(2)));
	return parcela;
		
}


function enviarDescontoAcrescimento(){
	var desconto_percentual_total 	= converteMoedaFloat($("#desconto_percentual_total").val());
	var desconto_por_valor_total 	= converteMoedaFloat($("#desconto_por_valor_total").val());
	var acrescimo_percentual_total 	= converteMoedaFloat($("#acrescimo_percentual_total").val());
	var acrescimo_por_valor_total	= converteMoedaFloat($("#acrescimo_por_valor_total").val());
	var venda_id 					= $("#venda_id").val();

	$.ajax({
		type: 'POST',
		data: {
			venda_id					: venda_id,
			desconto_percentual_total	: desconto_percentual_total,
			desconto_por_valor_total	: desconto_por_valor_total,
			acrescimo_percentual_total	: acrescimo_percentual_total,
			acrescimo_por_valor_total	: acrescimo_por_valor_total			
		},
		url: base_url + 'venda/enviarDescontoAcrescimento',
		dataType: 'json',
		beforeSend: function (){
		   giraGira();
	   },
		success: function (e) {
			fecharModal();
			if(e.tem_erro == true){
				alert(e.erro);
			}else{
				preencherDados(e.retorno.data);
				listaDuplicata(e.retorno.data.duplicatas);
				TOTAL_RESTANTE = e.retorno.data.valor_restante;
				$("#valor_pago").val(converteFloatMoeda(TOTAL_RESTANTE));
				limparDuplicata();
				
			}		
			
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
		
}


function limparDuplicata() {
	$('#qtde_vezes').val(1);
	$('#valor_parcela').val('');
	$('#valor_recebido').val('');
	$('#valor_troco').val('');
	
	fecharModal();
}


function salvarVenda() {	
	
	if(TOTAL_RESTANTE > 0 ){
		alert("Por favor insira alguma de pagamento até que o total restante fique igual a zero " );
		return false;
	}
	
	if(TOTAL_RESTANTE < 0 ){
		alert("Por favor insira alguma de pagamento até que o total restante fique igual a zero " );
		return false;
	}
	let js = {
		cliente_cnpj	: $('#cliente_cnpj').val(),
		cliente_cpf		: $('#cliente_cpf').val(),
		cliente_cpf		: $('#cliente_cpf').val(),
		caixa_id		: $('#caixa_id').val(),	
		venda_id		: $('#venda_id').val(),		
	}
	$.ajax({
		type: 'POST',
		data: {
			venda: js
		},
		url: base_url + 'venda/finalizarVenda',
		dataType: 'json',
		beforeSend: function (){
		   giraGira();
	   },
		success: function (e) {
			console.log(e);
			fecharModal();
			if(e.tem_erro == true){
				alert(e.erro);
			}else{				
				if(e.transmitir_nfce =="S"){
					modal_tipo_cupom(e.chave);
				}else{
					location.href = base_url + "pdv/livre";
				}
				
			}		
			
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
	
}



function listarProduto(data){
	html = "<tr>";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="center">' + data[i].cod_barra + '</td>' + 	
        '<td align="center">' + data[i].nome + '</td>' +
        '<td align="center">' + data[i].unidade + '</td>' + 	
		'<td align="center">' + data[i].preco + '</td>' + 
        '<td><a href="javascript:;" onclick="escolher_produto('+ data[i].id +')"  class="d-inline-block btn btn-verde btn-pequeno" title="Selecionar">Selecionar</a></td></tr>'
	}	
	$("#listaProduto").html(html);
}

function escolher_produto(q){
	var tipo = "codigo";
		grade_produto_id = null;
	$.ajax({
		url: base_url + "buscaProduto/" + q + "/" + tipo ,
		type: "get",
		data: {},
		dataType:"json",
		success: function(data){	
			$("#preco").val(converteFloatMoeda(data.retorno.preco));
			$("#id_produto").val(data.retorno.id);
			$("#qtde").val(1);
			$("#subtotal").val(converteFloatMoeda(data.retorno.preco ));
			$("#descricao").html(data.retorno.nome);									
			if(data.retorno.imagem == null){
				$("#imagem").attr("src", base_url + "assets/pdv/img/semimagem.jpg");	
			}else{
				$("#imagem").attr("src", base_url_imagem + data.retorno.imagem);
			}	
			$("#qtde").val(converteFloatMoeda(1));	
			$("#valor_desconto_item").val(converteFloatMoeda(0));
						
			$("#codigo_produto").val(data.retorno.id);
			$("#codigo_produto").focus();			
			
			
			$("#listaProduto").html("");
			$("#pesquisaProduto").val("");			
			fecharModal();			
			BUSCA_PELO_PRODUTO = true;
		}
	});
}



function listarCliente(data){
	html = "<tr>";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="center">' + data[i].nome_razao_social + '</td>' + 	
        '<td align="center">' + data[i].cpf_cnpj + '</td>' +
        '<td align="center">' + data[i].email + '</td>' + 	
		'<td align="center">' + data[i].fone + '</td>' + 
        '<td><a href="javascript:;" onclick="escolher_cliente('+ data[i].id +')"  class="d-inline-block btn btn-verde btn-pequeno" title="Selecionar">Selecionar</a></td></tr>'
	}	
	$("#listaCliente").html(html);
}

function escolher_cliente(id){
	$.ajax({
		url: base_url + "cliente/vincularCliente" ,
		type: "POST",
		data: {
			cliente_id:id,
			venda_id  : $("#venda_id").val(),
		},
		dataType:"json",
		success: function(data){
			location.reload();			
		}
	});
}

function imprimirCupomFiscal(){	
	var chave = $("#chaveNfe").val();
	fecharModal();
	window.open(base_url + 'venda/danfce/' + chave, '_blank');
	location.href = base_url + "pdv/index";	
}

function modal_tipo_cupom(chave){	 
	$("#giragira_pdv").hide();
	$("#div_retorno_pdv").hide();
	$("#chaveNfe").val(chave);
	$("#mensagem_retorno_pdv").hide();
	
	abrirModal("#imprimirCupom");	
}



function pagarComPix(){
	var nome 		= $("#payerFirstName").val();
	var sobrenome 	= $("#payerLastName").val();
	var cpf 		= $("#docNumber").val();
	var email 		= $("#payerEmail").val();
	var codigo 		= $("#pedido_id").val();
	var cliente_id 	= $("#cliente_id").val();
	$.ajax({
		   url: base_url + "mercadopago/pix",
		   type: "POST",
		   dataType: "json",
		   data:{
				"email"		:email,
				"nome"		:nome,
				"sobrenome"	:sobrenome,
				"cpf"		:cpf,			
				"codigo"	:codigo,			
				"cliente_id":cliente_id,			
		   	},
			 success: function(data){
				$("#imageQRCode").attr('src', 'data:image/png;base64,' + data.qr_code_base64);
				$("#codigoPix").val(data.qr_code);
				abrirModal("#pix");
				//iniciarBusca();
			 }
			
		});
	
}
function pagarComPix(){	
	
	var nome 		= $("#payerFirstName").val();
	var sobrenome 	= $("#payerLastName").val();
	var cpf 		= $("#docNumber").val();
	var email 		= $("#payerEmail").val();
	var pedido_id 	= $("#venda_id").val();
	$.ajax({
		   url: base_url + "mercadopago/pix",
		   type: "POST",
		   dataType: "json",
		   data:{		
				
				"email"			:email,
				"nome"			:nome,
				"sobrenome"		:sobrenome,
				"cpf"			:cpf,			
				"codigo"		:pedido_id,	
				"identificador" : 	$('#venda_id').val(),
				"descricao"		: "Venda PDV " + $('#venda_id').val(),	
				"valor" 		: TOTAL_RESTANTE	
		   	},
			 success: function(data){
				$("#imageQRCode").attr('src', 'data:image/png;base64,' + data.qr_code_base64);
				$("#codigoPix").val(data.qr_code);
				abrirModal("#pix");
				//iniciarBusca();
			 }
			
		});
	
}



function iniciarBusca(){
    cronometro = setInterval(function(){
     verificarNotificacao();
	},5000); 	
}

function pararBusca(){    
    clearInterval(cronometro);
}

function verificarNotificacao(){
	$.ajax({
	   url: base_url + "mercadopago/verificaPagamentoPix/" + $("#venda_id").val(),
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(e){			 
			 if(e.tem_erro == false){
				 pararBusca();
				 fecharModal();
				 preencherDados(e.retorno.data);
				 listaDuplicata(e.retorno.data.duplicatas);
				 TOTAL_RESTANTE = e.retorno.data.valor_restante;
				 $("#valor_pago").val(converteFloatMoeda(TOTAL_RESTANTE));
			 }
		 }
		
	});	
 }

























$('#qtde').on('keyup', () => {
	let quantidade 	= converteMoedaFloat($('#qtde').val());
	let valor 	  	= converteMoedaFloat($('#preco').val());
	let subtotal 	= valor * quantidade;
	$('#subtotal').val(converteFloatMoeda(subtotal.toFixed(2)));
})






function fecharCaixa(){
	location.href=base_url + "caixa/fechamento/" + $("#caixa_id").val();
}
function telaCliente(){	
			
	abrirModal("#verTelaCpf");	
} 

function finalizarVenda(){
	if(ITENS.length<=0){
		alert("Digite primeiramente algum Item");
		fecharModal();
		return false;
	}
	atualizaTotal();	
	telaPagamentoInicio();	
	abrirModal("#encerrar");
}

function telaQtdeDesconto(){	
	$('#tipo_desconto_item_antecipado').val("desc_perc");
	$('#valor_desconto_item_antecipado').val(converteFloatMoeda(0));
	$('#qtde_produto_antecipado').val("");
	
	abrirModal("#verTelaQtdeDesconto");	
	$('#qtde_produto_antecipado').focus();
}

function telaDesconto(){
	var subtotal = $("#subtotal").val();
	$("#valor_produto_desconto").val(subtotal);
	
	if($("#id_produto").val()==""){
		alert("Selecione primeiramente um produto");
		fecharModal();
		return false;
	}		
	abrirModal("#verTelaDesconto");	
} 

$('#valor_desconto_item').on('blur', () => {
	calcula_desconto_item();	
	
})



$('#qtde').on('blur', () => {
	calcula_desconto_item();	
	
})

$('#tipo_desconto_item').on('change', () => {
	calcula_desconto_item();	
	
})
function calcula_desconto_item(){
	var tipo_desconto_item 	= $("#tipo_desconto_item").val();
	let qtde 		= converteMoedaFloat($('#qtde').val());
	var valor_desconto_item = ($('#valor_desconto_item').val() !="") ? converteMoedaFloat($('#valor_desconto_item').val()) : parseFloat(0);	
	var preco 		= converteMoedaFloat($("#preco").val());		
	var subtotal 	= parseFloat(0);
	
	if(tipo_desconto_item=="desc_perc"){	
		DESCONTO_ITEM =  preco * valor_desconto_item * 0.01;
	}else{
		DESCONTO_ITEM = valor_desconto_item 
	}	
	
	subtotal = (preco -  DESCONTO_ITEM) * qtde;
	
	$('#subtotal').val(converteFloatMoeda(subtotal));
}

function cancelarVenda(){
	if (confirm("Tem certeza que deseja Cancelar esta venda ") == true) {
	  location.href = base_url + "pdv/index";	
	}
	
}
function telaPagamentoInicio(){
	$("#form_entrada_pagamento").addClass("bloquear");
	$("#qtde_vezes").prop('disabled', true);
	$("#valor_pago").prop('disabled', true);
	$("#btnInserirPagamento").prop('disabled', true);
	$("#tipo_acrescimo").prop('disabled', true);
	$("#acrescimo_perc").prop('disabled', true);
	$("#tipo_desconto").prop('disabled', true);
	$("#desconto_perc").prop('disabled', true);
	$("#btInserirPagamento").prop('disabled', true);
}


function habilitaEntradaPagamento(){
	$("#form_entrada_pagamento").removeClass("bloquear");
	$("#qtde_vezes").prop('disabled', false);
	$("#valor_pago").prop('disabled', false);
	$("#btInserirPagamento").prop('disabled', false);
}

function habilitarAcrescimo(){
	$("#tipo_acrescimo").prop('disabled', false);
	$("#acrescimo_perc").prop('disabled', false);
	$("#tipo_acrescimo").val("perc");
	$("#acrescimo_perc").val('');
	$("#acrescimo_perc").focus();
}

function habilitarDesconto(){
	$("#tipo_desconto").prop('disabled', false);
	$("#desconto_perc").prop('disabled', false);
	$("#tipo_desconto").val("perc");
	$("#desconto_perc").val(' ');
	$("#desconto_perc").focus();
}




function AdicionarItemNaLista(codigo, nome, quantidade, valor) {	
	if(quantidade <= 0){
		alert("O valor precisa ser maior que zero");
		fecharModal();
		return;
	}
	
	if (!verificaProdutoIncluso()) {
		TOTAL_VENDA += parseFloat(((valor - DESCONTO_ITEM) * quantidade).toFixed(2));
		ITENS.push({
			id: (ITENS.length + 1), codigo: codigo, nome: nome,
			quantidade: quantidade, valor: valor, desconto_item: DESCONTO_ITEM, venda_id:$("#venda_id").val()
		})
		QTDE_ITEM += parseFloat(quantidade);
		TOTAL_VENDA = parseFloat(TOTAL_VENDA.toFixed(2));
		$('.prod tbody').html("");

		atualizaTotal();
		limparCamposFormProd();
		let t = montaTabela();
		$('.prod tbody').html(t)
	}
}

function formatReal(v) {
	return v.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });;
}





function verificaProdutoIncluso() {
	if (ITENS.length == 0) return false;
	if ($('#prod tbody tr').length == 0) return false;
	let cod = $("#id_produto").val();
	
	let duplicidade = false;

	ITENS.map((v) => {
		if (v.codigo == cod) {
			duplicidade = true;
		}
	})

	let c;
	if (duplicidade) {
		c = !confirm('Produto já adicionado, deseja incluir novamente?');
		fecharModal();
	}
	else c = false;
	return c;
}



$('#tipo_desconto').on('change', () => {
	atualizaTotal()
})


$('#desconto_perc').on('keyup', () => {
	atualizaTotal()
})

$('#tipo_acrescimo').on('change', () => {
	atualizaTotal()
})


$('#acrescimo_perc').on('keyup', () => {
	atualizaTotal()
})

function atualizaTotal() {
	var tipo_desconto 		= $("#tipo_desconto").val();
	var desconto_perc  		= converteMoedaFloat($("#desconto_perc").val());
	var tipo_acrescimo 		= $("#tipo_acrescimo").val();
	var acrescimo_perc  	= converteMoedaFloat($("#acrescimo_perc").val());
	
	if(tipo_desconto=="perc"){
		TOTAL_DESCONTO = TOTAL_VENDA * desconto_perc * 0.01;
	}else if(tipo_desconto=="valor"){
		TOTAL_DESCONTO = desconto_perc;
	}else{
		TOTAL_DESCONTO = 0;
	}
	
	if(tipo_acrescimo=="perc"){
		TOTAL_ACRESCIMO = TOTAL_VENDA * acrescimo_perc * 0.01;
	}else if(tipo_acrescimo=="valor"){
		TOTAL_ACRESCIMO = acrescimo_perc;
	}else{
		TOTAL_ACRESCIMO = 0;
	}	

	TOTAL_GERAL 	= parseFloat(TOTAL_VENDA + TOTAL_ACRESCIMO - TOTAL_DESCONTO).toFixed(2);
	TOTAL_RESTANTE 	= TOTAL_GERAL - TOTAL_RECEBIDO;
	
	//$('#volume').val(ITENS.length);
	$('#valor_pago').val(converteFloatMoeda(TOTAL_RESTANTE));
	$('#lbl_total_vendido').html(converteFloatMoeda(TOTAL_VENDA));
	$('#lbl_desconto').html(converteFloatMoeda(TOTAL_DESCONTO));
	$('#lbl_acrescimo').html(converteFloatMoeda(TOTAL_ACRESCIMO));
	$('#lbl_total_geral').html(converteFloatMoeda(TOTAL_GERAL));
	$('#lbl_total_recebido').html(converteFloatMoeda(TOTAL_RECEBIDO));
	$('#lbl_total_restante').html(converteFloatMoeda(TOTAL_RESTANTE));	
	$('#total_geral').val(converteFloatMoeda(TOTAL_VENDA));
	$('#volume').val(converteFloatMoeda(QTDE_ITEM));
	
	
}

function transmitir(){
	 var id_venda = $("#id_venda").val(); 	 
	 $.ajax({
		  url: base_url + "venda/transmitirPelaVenda/" + id_venda,
		  type: "GET",
		  dataType: "json",
		  data:{},
		  beforeSend: function () {
			$("#div_retorno_pdv").hide();
			$("#opcoes_nota").hide();
	        $("#giragira_pdv").show();
	     },
		  success: function (data){
			console.log(data);
			  if(data.tem_erro){			
				  $("#giragira_pdv").hide();
				  $("#div_retorno_pdv").show();
				  $("#mensagem_erro_pdv").html(data.erro);
			  }else{
				  telaImprimirPdv();
			  }
		  },
 		  error: function (e) {
				var response = JSON.parse(e.responseText);
				$("#giragira_pdv").hide();
				$("#div_retorno_pdv").show();
				$("#mensagem_retorno_pdv").html(response.errors);	
			}
	});	
}



function imprimirCupomNaoFiscal(){	
	var id_venda = $("#id_venda").val(); 
	fecharModal();
	window.open(base_url + 'venda/cupom/'+id_venda, '_blank');
	location.href = base_url + "pdv/index";	
}




function fecharTela(){	 
	fecharModal();
	location.href = base_url + "pdv/livre";	
}

function limparCliente() {
	$('#cliente_cnpj').val('');
	$('#cliente_cpf').val('');
	fecharModal();
}

function telaImprimirPdv() {
	fecharModal();
	abrirModal("#imprimirCupom");
}

function limparSuplemento() {
	$('#valor_suplemento').val('');
	fecharModal();
}

function limparSangria() {
	$('#valor_sangria').val('');
	fecharModal();
}

function limparDesconto() {
	$('#tipo_desconto').val('');
	$('#valor_desconto').val('');
	fecharModal();
}

function confirmarSuplemento(){
	var caixa_id 		 = $("#caixa_id").val();	
	var valor_suplemento = $("#valor_suplemento").val();
	var desc_suplemento  = $("#desc_suplemento").val();
	
	if(valor_suplemento.length<=0){
		fecharModal();
		alert("Por favor, insira um valor antes");	
		return false;
	}
	
	if(desc_suplemento.length<=0){
		alert("Por favor, insira uma descrição antes");	
		fecharModal();
		return false;
	}
	$.ajax({
		url: base_url + "suplemento/salvarJs" ,
		type: "POST",
		data: {
			caixa_id :caixa_id,
			valor: valor_suplemento,
			descricao: desc_suplemento
		},
		dataType:"json",
		beforeSend: function (){
		   giraGira();
	   },
		success: function(data){			
			fecharModal();
			if(data.tem_erro == true){
				alert(e.erro);
			}else{
				alert("Registro inserido com Sucesso");
				$("#valor_suplemento").val("");
				$("#desc_suplemento").val("");
			}
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
}

function confirmarSangria(){
	var caixa_id 	  = $("#caixa_id").val();	
	var valor_sangria = $("#valor_sangria").val();
	var desc_sangria  = $("#desc_sangria").val();
	
	if(valor_sangria.length<=0){
		alert("Por favor, insira um valor antes");	
		return false;
	}
	
	if(desc_sangria.length<=0){
		alert("Por favor, insira uma descrição antes");	
		return false;
	}
	$.ajax({
		url: base_url + "sangria/salvarJs" ,
		type: "POST",
		data: {
			caixa_id :caixa_id,
			valor: valor_sangria,
			descricao: desc_sangria
		},
		dataType:"json",
		beforeSend: function (){
		   giraGira();
	   },
		success: function(data){			
			fecharModal();
			if(data.tem_erro == true){
				alert(data.erro);
			}else{
				alert("Registro inserido com Sucesso");
				$("#valor_sangria").val("");
				$("#desc_sangria").val("");	
			}
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
}
	
function confirmarQtdeDesconto(){
	 var qtde = ($("#qtde_produto_antecipado").val() != "" ) ? $("#qtde_produto_antecipado").val() : 1;
	 $("#qtde").val(qtde);
	 $("#valor_desconto_item").val($("#valor_desconto_item_antecipado").val());
	 $("#tipo_desconto_item").val($("#tipo_desconto_item_antecipado").val());	 	
	
	 fecharModal();
	 $("#codigo_produto").focus();
}

	
function confirmarDesconto(){
	var valor_desconto = $("#valor_desconto").val();
	
	if(valor_desconto.length<=0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira um valor antes"));	
		return false;
	}
	
	fecharModal();
}






function chamarTelaPagamento(){
	if(ITENS.length<=0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira algum item antes!"));	
		return false;
	}
	abrirModal("#encerrar");
}

function abrirTelaCancelamento(id_item){	
	$("#id_item").val(id_item);
	abrirModal('#cancelaritem');
}


function cancelarItem(){
	var id = $("#id_item").val();	
	$.ajax({
		url: base_url + "itemvenda/excluir/" + id ,
		type: "GET",
		data: {},
		dataType:"json",
		success: function(data){
			lista_itens_venda(data.lista);
			$("#volume").val(data.qtde);
			$("#login_gerente").val("");
			$("#senha_gerente").val("");
			$("#id_item").val("");
			atualizaTotal();			
			fecharModal();
		}
	});
}

	








