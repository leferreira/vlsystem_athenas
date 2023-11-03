//VENDA PDV

var ITENS 		= [];
var FATURA 		= [];

var TOTAL_FATURA    = 0;

var QTDE_ITEM       = 0;
var TOTAL_VENDA 	= 0;
var TOTAL_DESCONTO 	= 0
var TOTAL_ACRESCIMO	= 0;
var TOTAL_RECEBIDO	= 0;
var TOTAL 			= parseFloat(0);
var TOTAL_GERAL 	= parseFloat(TOTAL_VENDA + TOTAL_ACRESCIMO - TOTAL_DESCONTO).toFixed(2);
var TOTAL_RESTANTE 	= parseFloat(TOTAL_GERAL - TOTAL_RECEBIDO).toFixed(2);
var TOTAL_DESCONTO_ITENS= parseFloat(0.0);
var DESCONTO_ITEM   = parseFloat(0).toFixed(2);
var BUSCA_PELO_PRODUTO = false;



$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});


$(document).ready(function() {
	$('.tecla').bind('keydown', 'f1',function() {
		abrirModal("#telaPesquisaProduto");
		//$("#codigo_produto").focus();
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
		//return false;
	});
	
	
	$('.tecla').bind('keydown', 'f2',function() {
		salvarItensDaVendaNoBanco();
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
	
	
	$(document).bind('keydown', 'f1',function() {
		abrirModal("#telaPesquisaProduto");	
		//$("#codigo_produto").focus();
		return false;
	});
	
	$(document).bind('keydown', 'insert',function() {
		inserirItem();
		return false;
	});
	
	$(document).bind('keydown', 'f2',function() {
		salvarItensDaVendaNoBanco();
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
		//return false;
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
		var q 					= $(this).val();
		var qtde 				= converteMoedaFloat($("#qtde").val());
		var venda_id			= $("#venda_id").val();
		var valor_desconto_item	= $("#valor_desconto_item").val();
		var tipo_desconto_item	= $("#tipo_desconto_item").val();
		var tipo 				= "id";
		
		if(BUSCA_PELO_PRODUTO==true){
			inserirItem();
			return;
		} 		
		if(q!=""){
			if(event.keyCode==13){
				tipo 	= $("input[name='tipo_pesquisa']:checked").val();			
				$.ajax({
					url: base_url + 'venda/inserirItem',
					type: "post",
					data: {
						q					: q,
						qtde				: qtde,
						venda_id			: venda_id,	
						valor_desconto_item	:valor_desconto_item,
						tipo_desconto_item 	: tipo_desconto_item,
						barra_ou_id			: tipo
					},
					dataType:"json",
					success: function(data){
						console.log(data);															
						if(data.retorno.data.id == null){		
							alert("produto não encontrado");
						}else{	
							listaItens(data.retorno.data.itens);
							limparCamposFormProd();					
						}
						$(".suspenso").css("display", "none" );
						$("#codigo_produto").focus();					
					},
					  beforeSend: function () {
						$("#codigo_produto").blur();
						$(".suspenso").css("display", "flex" );
				     }
				})
			}
		}
	});
	
	$("#qtde").on("keydown", function(event){
		if(event.keyCode==13){
			inserirItem();
		}
	});
	
	$("#valor_pago").on("keydown", function(event){
		if(event.keyCode==13){
			inserirPagamento();
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
	
function listaItens(itens) {
	html = '<tr>';
	for(var i in itens){	
		html += "<tr class='datatable-row' style='left: 0px;'>";
		html += "<td class='datatable-cell cod'><span class='codigo' style='width: 60px;'>" + itens[i].id + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + itens[i].produto.nome + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + converteFloatMoeda(itens[i].qtde) + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(itens[i].valor) + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(itens[i].desconto_item) + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(itens[i].subtotal_liquido) + "</span></td>";
		html += "<td class='datatable-cell text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-vermelho btn-pequeno d-inline-block' href='#prod tbody' onclick='deleteItem(" + itens[i].id + ")'>"
		html += "<i class='fas fa-trash'></i></a></span></td>";
		html += "</tr>";
	}	
	$("#itensDaVenda").html(html);
}

	
	
$("#pesquisaProduto").on("keyup", function(){
       var q = $("#pesquisaProduto").val();      
       $.ajax({
         url: base_url + "produto/pesquisarProdutoPorNome",
         type: "get",
         data: {
             q:q
         },
         dataType:"Json",
         success: function(data){
            listarProduto(data);           
         }         
     });
   }) 
	
});

$('#qtde').on('keyup', () => {
	let quantidade 	= converteMoedaFloat($('#qtde').val());
	let valor 	  	= converteMoedaFloat($('#preco').val());
	let subtotal 	= valor * quantidade;
	$('#subtotal').val(converteFloatMoeda(subtotal.toFixed(2)));
})



function addItemTable(codigo, nome, quantidade,  valor, desconto,  desconto_percentual, desconto_por_valor  ) {	
	if (!verificaProdutoIncluso()) {		
	
		TOTAL += parseFloat((valor * quantidade).toFixed(2));
		TOTAL_DESCONTO_ITENS += parseFloat(desconto);		
		ITENS.push({
			id: (ITENS.length + 1), produto_id: codigo, nome: nome,
			quantidade: quantidade,  valor: valor, desconto:desconto, 
			desconto_percentual: desconto_percentual,
			desconto_por_valor: desconto_por_valor
		})
				
		TOTAL = parseFloat(TOTAL.toFixed(2));
		TOTAL_DESCONTO_ITENS =  parseFloat(TOTAL_DESCONTO_ITENS.toFixed(2));
		$('.prod tbody').html("");

		atualizaTotal();
		let t = montaTabela();
		$('.prod tbody').html(t);
		
	}
}

function salvarItensDaVendaNoBanco(){
	if(ITENS.length<=0){
		alert("Por favor, insira algum item antes!");	
		return false;
	}	
	$.ajax({
		type: 'POST',
		data: {
			itens			: ITENS,
			venda_id		: $('#venda_id').val(),
			cliente_cnpj	: $('#cliente_cnpj').val(),
			cliente_cpf		: $('#cliente_cpf').val(),
		},
		url: base_url + 'venda/salvarItensDaVendaNoBanco',
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
				//location.href=base_url + "pdv/pagamento/" +  $('#venda_id').val() ;
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
	var tipo 			= "codigo";
	
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
			if(TIPO_BUSCA=="id"){
				$("#codigo_produto").val(data.retorno.id);
				$("#codigo_produto").focus();
			}else if(TIPO_BUSCA=="barra"){
				$("#codigo_produto").val(data.retorno.codigo_barra);
				$("#codigo_produto").focus();
			}		
			BUSCA_PELO_PRODUTO = true;
			fecharModal();
		}
	});
}

function fecharCaixa(){
	location.href=base_url + "caixa/fechamento/" + $("#caixa_id").val();
}

function resgatar(){
	alert();
	location.href=base_url + "resgate/index" ;
}
function telaCliente(){	
			
	abrirModal("#verTelaCpf");	
} 


$('#val_desconto').on('blur', () => {
	calcula_desconto_item();	
	
})



$('#qtde').on('blur', () => {
	calcula_desconto_item();	
	
})

$('#tipo_desconto_item').on('change', () => {
	calcula_desconto_item();	
	
})


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

function selecionarFormaPagamento(id_forma,txt_forma){
	$("#txt_forma_pagamento").val(txt_forma);
	$("#id_forma_pagamento").val(id_forma);	
	$("#qtde_vezes").val(1);
	
	
	
	habilitaEntradaPagamento();
	var parcela = calculaParcela();
	$("#valor_pago").focus();	
	
	if(id_forma==1){		
		$('#valor_recebido').val(converteFloatMoeda(parcela));
	}else{		
		$('#valor_recebido').val(converteFloatMoeda(parcela));		
	}	
	$('#valor_troco').val(converteFloatMoeda(0.00));
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
	var parcela = TOTAL_RESTANTE / parseInt(qtde_vezes);	
	$('#valor_pago').val(converteFloatMoeda(parcela.toFixed(2)));
	return parcela;
		
}

function inserirPagamento(){
	var id_forma_pagamento 	= $("#id_forma_pagamento").val();
	var valor 				= converteMoedaFloat($("#valor_pago").val());
	var qtde_vezes 			= converteMoedaFloat($("#qtde_vezes").val());	
	var total_entrada_atual	= valor * qtde_vezes; //valor que está entrando
	var total_geral_pago 	= TOTAL_RECEBIDO + total_entrada_atual;  
	
	if(valor <= 0){
		alert("O valor precisa ser maior que zero");
		return;
	}
	
	//Verifica se o total recebido é maior que o total devido	
	if(TOTAL_GERAL < total_geral_pago){
		alert("O valor recebido não pode ser maior que o valor a pagar");
		return;
	}
	
	FATURA.push({			
			forma_pagto_id: id_forma_pagamento,
			descricao: $('#txt_forma_pagamento').val(),
			valor: valor, 
			qtde_vezes: qtde_vezes,
			numero: (FATURA.length + 1)});
	TOTAL_RECEBIDO += parseFloat(total_entrada_atual) ;
	listaPagamento();
	atualizaTotal();
	telaPagamentoInicio();	
}


function formatReal(v) {
	return v.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });;
}

function montaTabela() {
	let t = "";
	ITENS.map((v) => {
		var subtotal = (v.valor - v.desconto_item) * v.quantidade;	
		t += "<tr class='datatable-row' style='left: 0px;'>";
		t += "<td class='datatable-cell cod'><span class='codigo' style='width: 60px;'>" + v.codigo + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + v.nome + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + converteFloatMoeda(v.quantidade) + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(v.valor) + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(v.desconto_item) + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(subtotal) + "</span></td>";
		t += "<td class='datatable-cell text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-vermelho btn-pequeno d-inline-block' href='#prod tbody' onclick='deleteItem(" + v.codigo + ")'>"
		t += "<i class='fas fa-trash'></i></a></span></td>";
		t += "</tr>";
	});
	return t
}

function deleteItem(id) {
	let temp = [];
	ITENS.map((v) => {
		if (v.id != id) {
			temp.push(v)
		} else {			
			TOTAL_VENDA -= parseFloat((v.valor * v.quantidade).toFixed(2));
		}
	});
	TOTAL_VENDA = parseFloat(TOTAL_VENDA.toFixed(2));
	ITENS = temp;
	let t = montaTabela(); // para remover
	$('.prod tbody').html(t)
	atualizaTotal();
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

function modal_tipo_cupom(id_venda){	 
	$("#giragira_pdv").hide();
	$("#div_retorno_pdv").hide();
	$("#mensagem_retorno_pdv").hide();
	$("#id_venda").val(id_venda);
	
	abrirModal("#modal_tipo_cupom");	
}

function imprimirCupomNaoFiscal(){	
	var id_venda = $("#id_venda").val(); 
	fecharModal();
	window.open(base_url + 'venda/cupom/'+id_venda, '_blank');
	location.href = base_url + "pdv/index";	
}

function imprimirCupomFiscal(){	
	var id_venda = $("#venda_id").val(); 
	fecharModal();
	window.open(base_url + 'venda/imprimirNfcePelaVenda/'+id_venda, '_blank');
	location.href = base_url + "pdv/livre";	
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
	


function limparCamposFormProd() {
	$('#id_produto').val('');
	$('#qtde').val('1');
	$('#preco').val('0');
	$('#tipo_desconto_item').val("desc_perc");
	$('#val_desconto').val(converteFloatMoeda(0));
	$('#qtde').val(converteFloatMoeda(1));	
	$('#codigo_produto').val('');
	$('#descricao').html('Selecione um Produto');
	$('#subtotal').val('');
	//$('#codigo_produto').focus();
	$("#imagem").attr("src", base_url + "assets/pdv/img/semimagem.jpg");	
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

	


function deleteItemFatura(id) {
	let temp = [];
	FATURA.map((v) => {
		if (v.numero != id) {
			temp.push(v)
		} else {
			TOTAL_RECEBIDO -= parseFloat(v.valor) ;
		}
	});
	FATURA = temp;
	listaPagamento();
	atualizaTotal();
}

function listaPagamento(){
	html = '<tr>';
	for(var i in FATURA){
		html += '<td class="text-center">' + FATURA[i].numero  + '</td>' + 
				'<td class="text-center">' + FATURA[i].descricao  + '</td>' + 
				'<td class="text-center">' + FATURA[i].qtde_vezes  + '</td>' + 
				'<td class="text-center">' + converteFloatMoeda(FATURA[i].valor)  + '</td>'+
				'<td class""><a class="btn btn-vermelho btn-pequeno d-inline-block"" href="#prod tbody" onclick="deleteItemFatura(' + FATURA[i].numero  + ')">' +
				'<i class="fas fa-trash"></i></a></span></td></tr>';		
	}
	
	$("#lista_pagamento").html(html);	
	
}



function salvarVenda() {	
	if(ITENS.length<=0){
		//$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira algum item antes!"));
		alert("Por favor, insira algum item antes!");	
		return false;
	}	
	
	
	if(TOTAL_GERAL != TOTAL_RECEBIDO){
		//$("#mostrarUmErro").html(MostrarUmaMsgErro("O total da venda tem que ser igual ao total a paga, restando: R$ " + (TOTAL_GERAL - TOTAL_RECEBIDO)));
		alert("O total da venda tem que ser igual ao total a paga, restando: R$ " + (TOTAL_GERAL - TOTAL_RECEBIDO));
		return false;
	}
	let js = {
		cliente_cnpj	: $('#cliente_cnpj').val(),
		cliente_cpf		: $('#cliente_cpf').val(),
		caixa_id		: $('#caixa_id').val(),	
		venda_id		: $('#venda_id').val(),
		itens			: ITENS,
		total			: TOTAL_VENDA,
		desconto		: TOTAL_DESCONTO,
		pagamentos		: FATURA
	}
	$.ajax({
		type: 'POST',
		data: {
			venda: js
		},
		url: base_url + 'venda/salvar',
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
				modal_tipo_cupom(e.retorno.id);
			}		
			
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
	
}


