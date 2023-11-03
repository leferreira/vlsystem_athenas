//VENDA PDV

var ITENS 	= [];
var FATURA 	= [];
var TOTAL 	= 0;
var DESCONTO= 0;
var TOTAL_VENDA = 0;
var TOTAL_FATURA = 0;
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});

$(function() {
	$("#codigo_produto").on("keydown", function(event){
		var q = $(this).val();
		if(event.keyCode==13){
			$.ajax({
				url: base_url + "produtoPorCodigo/" + q,
				type: "get",
				data: {},
				dataType:"json",
				success: function(data){
					fecharModal();
					if(data.tem_erro == true){
						fecharGiraGira();
						$("#erroModalLivre").html(data.erro);
						abrirModalLivre("#modalLivreErro");
					}else{
						$("#imagem").attr("src", base_url_imagem + data.imagem);
						
						$("#preco").val(data.valor_venda);
						$("#id_produto").val(data.id);
						$("#qtde").val(1);
						$("#subtotal").val(data.valor_venda );
						$("#descricao").html(data.nome);
						$("#qtde").focus();
					}					
				},
				  beforeSend: function () {
					giraGira();
			     }
			})
		}
	});
	
	$("#qtde").on("keydown", function(event){
		if(event.keyCode==13){
			var produto_id 	= $("#id_produto").val();
			var nome 		= $("#descricao").html();						
			var qtde 		= $("#qtde").val();
			var preco 		= $("#preco").val();			
			AdicionarItemNaLista(produto_id, nome, qtde, preco)
		}
	});
	
});

function AdicionarItemNaLista(codigo, nome, quantidade, valor) {
	if (!verificaProdutoIncluso()) {
		TOTAL += parseFloat(valor.replace(',', '.')) * parseFloat(quantidade.replace(',', '.'));
		
		ITENS.push({
			id: (ITENS.length + 1), codigo: codigo, nome: nome,
			quantidade: quantidade, valor: valor
		})
		
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

function montaTabela() {
	let t = "";
	ITENS.map((v) => {
		t += "<tr class='datatable-row' style='left: 0px;'>";
		t += "<td class='datatable-cell cod'><span class='codigo' style='width: 60px;'>" + v.codigo + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 120px;'>" + v.nome + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + v.quantidade + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + v.valor + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + formatReal(v.valor.replace(',', '.') * v.quantidade.replace(',', '.')) + "</span></td>";
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
			TOTAL -= parseFloat(v.valor.replace(',', '.')) * (v.quantidade.replace(',', '.'));
		}
	});
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
	if (duplicidade) c = !confirm('Produto já adicionado, deseja incluir novamente?');
	else c = false;
	console.log(c)
	return c;
}

$('#tipo_desconto').on('change', () => {
	atualizaTotal()
})


$('#desconto_perc').on('keyup', () => {
	atualizaTotal()
})
function atualizaTotal() {
	var tipo_desconto = $("#tipo_desconto").val();
	var desconto_perc  = $("#desconto_perc").val();
	
	if(tipo_desconto=="perc"){
		DESCONTO = TOTAL * parseFloat(desconto_perc.replace(',', '.')) * 0.01;
	}else if(tipo_desconto=="valor"){
		DESCONTO = parseFloat(desconto_perc.replace(',', '.'));
	}else{
		DESCONTO = 0;
	}
	
	
	TOTAL_VENDA = TOTAL - DESCONTO;	
	$('#volume').val(ITENS.length);
	$('#total_geral').val(formatReal(TOTAL));
	$('#lbl_total_vendido').html(TOTAL);
	$('#lbl_desconto').html(DESCONTO);
	$('#lbl_total_geral').html(TOTAL_VENDA);
	$('#lbl_total_recebido').html(TOTAL_FATURA);
	$('#lbl_total_restante').html(TOTAL_VENDA - TOTAL_FATURA);
	
}


function limparCliente() {
	$('#cliente_nome').val('');
	$('#cliente_cpf').val('');
	fecharModal();
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
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira um valor antes"));	
		return false;
	}
	
	if(desc_suplemento.length<=0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira uma descrição antes"));	
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
		success: function(data){			
			$("#mostrarSucesso").html(MostrarUmaMsgSucesso("Salvo com sucesso, aguarde..."));		
			fecharModal();
		}
	});
}

function confirmarSangria(){
	var caixa_id 	  = $("#caixa_id").val();	
	var valor_sangria = $("#valor_sangria").val();
	var desc_sangria  = $("#desc_sangria").val();
	
	if(valor_sangria.length<=0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira um valor antes"));	
		return false;
	}
	
	if(desc_sangria.length<=0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira uma descrição antes"));	
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
		success: function(data){			
			$("#mostrarSucesso").html(MostrarUmaMsgSucesso("Salvo com sucesso, aguarde..."));		
			fecharModal();
		}
	});
}
function confirmarDesconto(){
	var valor_desconto = $("#valor_desconto").val();
	
	if(valor_desconto.length<=0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira um valor antes"));	
		return false;
	}
	
	fecharModal();
}

function limparCamposFormProd() {
	$('#id_produto').val('');
	$('#qtde').val('0');
	$('#preco').val('0');
	$('#codigo_produto').val('');
	$('#descricao').html('Selecione um Produto');
	$('#subtotal').val('');
	$('#codigo_produto').focus();
	$("#imagem").attr("src", base_url + "assets/pdv/img/semproduto.png");
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

	
function inserirPagamento(){
	var id_forma_pagamento 	= $("#id_forma_pagamento").val();
	var valor 				= $("#valor_pago").val();
	var qtde_vezes 			= $("#qtde_vezes").val();	
	
	if(TOTAL_VENDA< TOTAL_FATURA + parseFloat(valor.replace(',', '.'))){
		alert("O valor recebido não pode ser maior que o valor a pagar");
		return;
	}
	FATURA.push({			
			forma_pagto_id: id_forma_pagamento,
			descricao: $('#id_forma_pagamento :selected').text(),
			valor: valor, 
			qtde_vezes: qtde_vezes,
			numero: (FATURA.length + 1)});
	TOTAL_FATURA += parseFloat(valor.replace(',', '.')) ;
	listaPagamento();
	atualizaTotal();	
}

function deleteItemFatura(id) {
	let temp = [];
	FATURA.map((v) => {
		if (v.numero != id) {
			temp.push(v)
		} else {
			TOTAL_FATURA -= parseFloat(v.valor.replace(',', '.')) ;
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
				'<td class="text-center">' + FATURA[i].valor  + '</td>'+
				'<td class""><a class="btn btn-vermelho btn-pequeno d-inline-block"" href="#prod tbody" onclick="deleteItemFatura(' + FATURA[i].numero  + ')">' +
				'<i class="fas fa-trash"></i></a></span></td></tr>';		
	}
	
	$("#lista_pagamento").html(html);	
	
}

function salvarVenda() {	
	if(ITENS.length<=0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira algum item antes!"));	
		return false;
	}	
		
	
	if(TOTAL_VENDA != TOTAL_FATURA){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("O total da venda tem que ser igual ao total a paga, restando: R$ " + (TOTAL_VENDA - TOTAL_FATURA)));
		return false;
	}
	let js = {
		cliente_nome	: $('#cliente_nome').val(),
		cliente_cpf		: $('#cliente_cpf').val(),
		caixa_id		: $('#caixa_id').val(),	
		itens			: ITENS,
		total			: TOTAL,
		desconto		: DESCONTO,
		pagamentos		: FATURA
	}
	console.log(js);
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
			$("#mostrarSucesso").html(MostrarUmaMsgSucesso("Salvo com sucesso, aguarde..."));
		    location.href = base_url + "pdv/index";
		    fecharModal();
		}, error: function (e) {
			console.log(e);
			var response = JSON.parse(e.responseText);
			fecharModal();
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
	});
	
}


