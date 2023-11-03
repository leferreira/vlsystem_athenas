
var ITENS 		= [];
var FATURA 		= [];
var TOTAL 		= parseFloat(0);
var TOTAL_ORCAMENTO = parseFloat(0);
var TOTAL_FATURA= parseFloat(0);

var TOTAL_DESCONTO_ITENS= parseFloat(0.0);

var PRODUTOS 	= [];
var CHAVE 		= "";

var unidades = [];


$(function () {
	PRODUTOS = JSON.parse($('#produtos').val());	
	 $("#desc_produto").on("keyup", function(){
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
			   $("#desc_produto").after('<ol class="listaProdutos"></ol>');
			   html="";
			   for(var i in data){
				   html +=	'<li><a href="javascript:;" onclick="selecionarProdutoOrcamento(this)" ' +	
				   		  	'data-id="'+data[i].id +
				   		  	'" data-preco = "' + data[i].valor_venda +
				   		  	'" data-nome  = "' + data[i].nome + 
							'" data-fragmentacao_qtde = "' + data[i].fragmentacao_qtde + 
							'" data-fragmentacao_unidade = "' + data[i].fragmentacao_unidade + 
							'" data-fragmentacao_valor = "' + data[i].fragmentacao_valor + 
							'" data-unidade = "' + data[i].unidade + '">' +
				   		  data[i].nome + " - RS " + data[i].valor_venda + '</a></li>' 
				  
			   }
			   
			   $(".listaProdutos").html(html);
			   $(".listaProdutos").show();
		   }
	   });
   })

	$("#desc_cliente").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return;
	   }
	   $.ajax({
		   url: base_url + "admin/cliente/pesquisa",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   $("#desc_cliente").after('<ol class="listaClientes"></ol>');
			   html="";
			   for(var i in data){
				   html +=	'<li><a href="javascript:;" onclick="selecionarClienteOrcamento(this)" ' +	
				   		  	'data-cliente_id="'+data[i].id +				   		  	
							'" data-nome_razao_social = "' + data[i].nome_razao_social + '">' +
				   		 	 data[i].nome_razao_social + '</a></li>' 
				}
			   
			   $(".listaClientes").html(html);
			   $(".listaClientes").show();
		   }
	   });
   })

	//Se vier da edição da orcamento
	if($('#orcamento_edit').val()){		
		ORCAMENTO = JSON.parse($('#orcamento_edit').val());
		ORCAMENTO.itens.map((rs) => {			
			addItemTable(rs.produto_id, rs.produto.nome, rs.quantidade, rs.unidade, rs.valor, rs.total_desconto_item, rs.desconto_por_item);			
		});		
	
		let t = montaTabela();
		$('#prod tbody').html(t);			
	}

		
	$('#val_desconto').on('keyup', () => {
		calcularDescontoItem();
	})
	
	$('#val_desconto').on('blur', () => {
		let val_desconto= $('#val_desconto').val();
		if(val_desconto==null || val_desconto==''  ){
			$('#val_desconto').val(0);
		}
		calcularDescontoItem();
	})

	var tot = TOTAL_ORCAMENTO / $("#qtde_parcela").val();
	$('#valor_parcela').val(tot);
});

function calcularDescontoItem(){
	let tipo_desc 	= $('#tipo_desc').val();
	let qtde 		= converteMoedaFloat($('#quantidade').val());
	let preco 		= converteMoedaFloat($('#valor').val());
	let subtotal 	= converteMoedaFloat($('#subtotal').val());
	let val_desconto= converteMoedaFloat($('#val_desconto').val());
	var desc    	=  parseFloat(0);
	var desconto   	=  parseFloat(0);			
    
	
	if(tipo_desc=="desc_perc"){
		desconto =  preco * val_desconto * 0.01 ;
	}else if(tipo_desc=="desc_valor"){
		desconto = val_desconto
	}
	
	desc = 	subtotal - 	(qtde * desconto);		

	$('#desconto').val(converteFloatMoeda((qtde * desconto).toFixed(2)));
	$('#desconto_item').val(converteFloatMoeda(desconto.toFixed(2)));	
	$('#total_item').val(converteFloatMoeda(desc.toFixed(2)));
}
	
function selecionarUnidade(){
	var unid = $("#unidade_orcamento").val();
	for (i = 0; i < unidades.length; i++) {
		if(unidades[i].unidade == unid){
			$("#valor").val(unidades[i].valor);
			$("#subtotal").val(unidades[i].valor);	
			$("#quantidade").val(1);
			$("#valor").focus();
			break;
		}
	}
}

function selecionarClienteOrcamento(obj){
	var id					= $(obj).attr('data-cliente_id');
	var nome				= $(obj).attr('data-nome_razao_social');	
	
	$(".listaClientes").hide();
	$("#cliente_id").val(id);
	$("#desc_cliente").val(nome);	
}

function selecionarProdutoOrcamento(obj){
	var id					= $(obj).attr('data-id');
	var nome				= $(obj).attr('data-nome');
	var preco				= $(obj).attr('data-preco');
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
	
	$("#unidade_orcamento").html(html); 	
	$(".listaProdutos").hide();
	
	$("#produto_id").val(id);
	$("#desc_produto").val(nome);
	$("#valor").val(preco);
	$("#subtotal").val(preco);	
	$("#quantidade").val(1);
	$("#total_item").val(converteFloatMoeda(preco));
	calcularDescontoItem();
	$("#valor").focus();	
}

function abrir_modal_opcoes(id_orcamento){	 
	$("#giragira_orcamento").hide();
	$("#div_retorno_orcamento").hide();
	$("#div_sucesso_orcamento").show();
	$("#mensagem_retorno_orcamento").hide();
	$("#mensagem_erro_orcamento").hide();
	$("#id_orcamento").val(id_orcamento);
	
	
	abrirModal("#modal_opcoes");	
}

function salvarNfe(id_orcamento){	 
	 $.ajax({
		  url: base_url + "admin/notafiscal/salvarNfePorOrcamentoJs/" + id_orcamento,
		  type: "GET",
		  dataType: "json",
		  data:{},
		  beforeSend: function () {
	     },
		  success: function (data){	
				console.log(data);		  
			  if(data.tem_erro == false){
						
			  }else{
				  			  
			  }
		  },
 		error: function (e) {
		
		}
	});	
}

function transmitirNfePelaOrcamento(id_orcamento){
	 $.ajax({
		  url: base_url + "admin/nfe/transmitirNfePelaOrcamentoJs/" + id_orcamento,
		  type: "GET",
		  dataType: "json",
		  data:{},
		  beforeSend: function () {
			
	     },
		  success: function (data){	
			console.log(data);		  
			  if(data.tem_erro == true){			
			  }else{				  
			  }
		  },
 		  error: function (e) {
				
			}
	});	
}


function telaImprimirNfe() {	
	fecharModal();
	abrirModal("#telaImprimirCupom");
}

function imprimirDanfePelaChave(){	
	fecharModal();
	giraGira();	
	location.href = base_url + 'admin/nfe/imprimirDanfePelaChave/'+ CHAVE; 
}


function imprimirDanfe(){	
	var id_orcamento = $("#id_orcamento").val(); 
	fecharModal();
	window.open(base_url + 'admin/nfe/imprimirDanfePelaOrcamento/'+id_orcamento, '_blank');
	location.href = base_url + "admin/orcamento/create";	
}

function imprimirPdf(){	
	var id_orcamento = $("#id_orcamento").val(); 
	fecharModal();
	location.href = base_url + "admin/orcamento/pdf/" + id_orcamento;	
}



function fecharTela(){	 
	fecharModal();
	location.href = base_url + "admin/orcamento/create";	
}

function salvarNfePorOrcamento(){
	var id_orcamento = $("#id_orcamento").val();	 
	fecharModal();
	location.href = base_url + "admin/notafiscal/salvarNfePorOrcamento/" + id_orcamento;	
}




function selecionarCartao(){	
	var op = $("#tPag").val();
	if(op=='03' || op =='04'){
		abrirModal('#pagamento_cartao');		
	}
}

function getFornecedor(id, data) {
	$.ajax
	({
		type: 'GET',
		url: base_url + 'admin/cliente/find/' + id,
		dataType: 'json',
		success: function (e) {
			data(e)

		}, error: function (e) {
			$("#mostrarUmErro").html(MostrarUmaMsgErro(e))
		}

	});
}

function getProdutos(data) {
	$.ajax
	({
		type: 'GET',
		url: base_url + 'produtos/naoComposto',
		dataType: 'json',
		success: function (e) {
			data(e)

		}, error: function (e) {
			console.log(e)
		}

	});
}

function getProduto(id, data) {
	console.log(id)
	$.ajax
	({
		type: 'GET',
		url: base_url + 'admin/produto/getProduto/' + id,
		dataType: 'json',
		success: function (e) {
			data(e)

		}, error: function (e) {
			$("#mostrarUmErro").html(MostrarUmaMsgErro(e));
		}

	});
}

function habilitaBtnSalarOrcamento() {
	var cliente = $('.cliente').val().split('-');
	if (ITENS.length > 0 && FATURA.length > 0 && TOTAL > 0 && parseInt(cliente[0]) > 0) {
		$('#salvar-orcamento').removeClass('disabled')
	}
}

$('#valor').on('keyup', () => {
	calcSubtotal()
})

$('#total_seguro').on('keyup', () => {
	atualizaTotalCompra()
})

$('#valor_frete').on('keyup', () => {
	atualizaTotalCompra()
})

$('#despesas_outras').on('keyup', () => {
	atualizaTotalCompra()
})

$('#quantidade').on('keyup', () => {
	atualizaTotalCompra()
})

$('#quantidade').on('change', () => {
	calcSubtotal()
})

$('#desconto_valor').on('keyup', () => {
	$('#desconto_per').val("");
	atualizaTotalCompra()
})
$('#desconto_per').on('keyup', () => {
	$('#desconto_valor').val("");	
	atualizaTotalCompra()
})


function calcSubtotal() {
	let quantidade 	= converteMoedaFloat($('#quantidade').val());
	let valor 		= converteMoedaFloat($('#valor').val());	
	let subtotal 	= valor * quantidade;
	$('#subtotal').val(converteFloatMoeda(subtotal.toFixed(2)));
	$('#total_item').val(converteFloatMoeda(subtotal));
	
	calcularDescontoItem();	
}


$('#autocomplete-produto').on('keyup', () => {
	$('#last-purchase').css('display', 'none')
})

$('#addProd').click(() => {
	let codigo 		= $('#produto_id').val();
	let nome 		= $('#desc_produto').val();
	let quantidade  = converteMoedaFloat($('#quantidade').val());
	let valor 		= converteMoedaFloat($('#valor').val());
	let unidade		= $('#unidade_orcamento').val();
	let desconto	= converteMoedaFloat($('#desconto').val());
	let desconto_item	= converteMoedaFloat($('#desconto_item').val());

	if(codigo == ''){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione um Produto primeiramente"));
		return false;
	}
	
	
	if(nome.length <= 0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione um Produto primeiramente"));
		return false;
	}
	
	if(parseFloat(quantidade <= 0)){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Digite a quantidade primeiramente"));
		return false;
	}
	
	if(parseFloat(valor) <= 0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Digite o Valor primeiramente"));
		return false;
	}	

	if(quantidade.length <= 0 && parseFloat(quantidade <= 0)  ){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Digite a quantidade primeiramente"));
		return false;
	}	
	
	
	addItemTable(codigo, nome, quantidade, unidade, valor, desconto, desconto_item);

});

function addItemTable(codigo, nome, quantidade, unidade, valor, desconto, desconto_item) {	
	if (!verificaProdutoIncluso()) {
		limparDadosFatura();
		
		TOTAL += parseFloat((valor * quantidade).toFixed(2));	
			
		TOTAL_DESCONTO_ITENS += parseFloat(desconto);		
		ITENS.push({
			id: (ITENS.length + 1), codigo: codigo, nome: nome,
			quantidade: quantidade, unidade:unidade, valor: valor, 
			desconto:desconto, desconto_item:desconto_item
		})		
		TOTAL = parseFloat(TOTAL.toFixed(2));
	
		$('.prod tbody').html("");

		atualizaTotal();
		atualizaTotalCompra();
		limparCamposFormProd();
		let t = montaTabela();
		$('.prod tbody').html(t);
		
	}
}

function verificaProdutoIncluso() {
	if (ITENS.length == 0) return false;
	if ($('#prod tbody tr').length == 0) return false;
	let cod = $('#autocomplete-produto').val().split('-')[0];
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

function limparCamposFormProd() {
	//$("#produto_id option:contains(Selecione)").attr('selected', true)
	$('#quantidade').val('0');
	$('#desc_produto').val('');
	$('#subtotal').val('0');
	$('#valor').val('');
	$('#valor_unitario').val('');
	$('#unidade_orcamento').val('');
	$("#desc_produto").focus();
}

function limparDadosFatura() {
	$('.fatura tbody').html('')
	$(".data-input").val("");
	$("#valor_parcela").val("");
	$('#add-pag').removeClass("disabled");	
	FATURA = [];
	TOTAL_FATURA = 0;
}

function atualizaTotal() {
	$('#total').html(converteFloatMoeda(TOTAL));
	$('#valor_total').val(converteFloatMoeda(TOTAL));
	$('#total_desconto_item').val(converteFloatMoeda(TOTAL_DESCONTO_ITENS));
}

function atualizaTotalCompra() {
	var frete 			= ($('#valor_frete').val() !="") ? converteMoedaFloat($('#valor_frete').val()) : parseFloat(0);
	var total_seguro 	= ($('#total_seguro').val() !="") ? converteMoedaFloat($('#total_seguro').val()) : parseFloat(0);
	var despesas_outras = ($('#despesas_outras').val() !="") ? converteMoedaFloat($('#despesas_outras').val()) : parseFloat(0);
	var desconto_valor 	= ($('#desconto_valor').val() !="") ? converteMoedaFloat($('#desconto_valor').val()) : parseFloat(0);
	var desconto_per 	= ($('#desconto_per').val() !="") ? converteMoedaFloat($('#desconto_per').val()) : parseFloat(0);
	
	let total_da_orcamento  = TOTAL - TOTAL_DESCONTO_ITENS ;
	console.log(total_da_orcamento);
	if(desconto_valor!="" && desconto_valor!="0"){
		total_da_orcamento = total_da_orcamento - desconto_valor ;
		desconto_per="";		
	}
	
	if(desconto_per!=""  && desconto_per!="0"){
		total_da_orcamento = total_da_orcamento - (total_da_orcamento * desconto_per * 0.01) ;
		desconto_valor="";		
	}
	TOTAL_ORCAMENTO = parseFloat(total_da_orcamento +  frete + total_seguro + despesas_outras).toFixed(2);
	
	$('#totalorcamento').val(converteFloatMoeda(TOTAL_ORCAMENTO));
	$("#valor_parcela").val(converteFloatMoeda(TOTAL_ORCAMENTO));
	atualizarValorVisual()
}

function montaTabela() {
	let t = "";
	ITENS.map((v) => {
		var total = parseFloat(v.valor * v.quantidade).toFixed(2);		
		var totalComDesconto = parseFloat(total - v.desconto).toFixed(2);
		t += "<tr class='datatable-row' style='left: 0px;'>";
		t += "<td class='datatable-cell'><span class='' style='width: 60px;'>" + v.id + "</span></td>";
		t += "<td class='datatable-cell cod'><span class='codigo' style='width: 60px;'>" + v.codigo + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 120px;'>" + v.nome + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + v.unidade + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + converteFloatMoeda(v.quantidade) + "</span></td>";		
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(v.valor) + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(total) + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(v.desconto) + "</span></td>";		
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(totalComDesconto) + "</span></td>";
		t += "<td class='datatable-cell text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-vermelho btn-pequeno d-inline-block' href='#prod tbody' onclick='deleteItem(" + v.id + ")'>"
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
			TOTAL -= parseFloat((v.valor * v.quantidade).toFixed(2));
			TOTAL_DESCONTO_ITENS -= parseFloat(v.desconto)
		}
	});
	TOTAL = parseFloat(TOTAL.toFixed(2));
	ITENS = temp;
	let t = montaTabela(); // para remover
	$('.prod tbody').html(t)
	atualizaTotal();
	atualizaTotalCompra();
}

$('#formaPagamento').change(() => {
	limparDadosFatura();
	let now = new Date();
	let data = now.getFullYear() + "-"+ ((now.getMonth() + 1) < 10 ? "0" + (now.getMonth() + 1) : (now.getMonth() + 1)) +
	"-" + (now.getDate() < 10 ? "0" + now.getDate() : now.getDate());
	TOTAL_FATURA = 0;
	
	$('#primeiro_vencimento').val(data);
	let txt_forma_pagto = $('#tPag :selected').text();
	let forma_pagto_id  = $("#tPag").val();
	
	//if ($('#formaPagamento').val() == 'a_vista') {
	//	$('#valor_parcela').val(TOTAL_ORCAMENTO);		
	//	addpagamento(data, $('#valor_parcela').val(),txt_forma_pagto, forma_pagto_id);
		
	//}else if ($('#formaPagamento').val() == 'personalizado') {
		$("#qtde_parcela").val(1);
		$("#valor_parcela").val(TOTAL_ORCAMENTO);
		$('.fatura tbody').html("");		
	//}
	atualizarValorVisual();	
})

$('#qtde_parcela').on('change', () => {
	if ($("#qtde_parcela").val()) {
		let qtd = $("#qtde_parcela").val();
		let valor_parcela = (TOTAL_ORCAMENTO / qtd).toFixed(2);
		$('#valor_parcela').val(converteFloatMoeda(valor_parcela));
	}
})

$('#add-pag-manual').click(() => {
	if (!verificaValorMaiorQueTotal()) {
		let data 			= $('#primeiro_vencimento').val();
		let valor 			= converteMoedaFloat($('#valor_parcela').val());
		let txt_forma_pagto = $('#tPag :selected').text();
		let forma_pagto_id  = $("#tPag").val();	
		if(data.length <= 0){
			$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione uma data inicial"));
			return false;
		}
		
		if (data.length > 0  && valor > 0) {	
			addpagamento(data, valor, txt_forma_pagto,forma_pagto_id );				
		}		
			
	}
})


$('#add-pag-automatico').click(() => {		
		let data 		= $('#primeiro_vencimento').val();
		let valor 		= converteMoedaFloat($('#valor_parcela').val());
		let qtde_parcela= parseInt($('#qtde_parcela').val());
		let txt_forma_pagto = $('#tPag :selected').text();
		let forma_pagto_id  = $("#tPag").val();	

		if(data.length <= 0){
			$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione uma data inicial"));
			return false;
		}
		
		TOTAL_FATURA 	= 0;
		
		FATURA			=[];
		$('.fatura tbody').html("");		
		var tot = parseFloat(0);
		for(var i=0; i < qtde_parcela; i++){
			let novaData = somarData(data, 30 * i);
			let parcela = 0;
			
			if(i== qtde_parcela-1){
				parcela = TOTAL_ORCAMENTO - tot;
			}else{
				parcela = valor;				
			}
			tot += valor;
			addpagamento(novaData, parcela,txt_forma_pagto,forma_pagto_id );
		}
		
})

function converterData(data){
	let temp = data.split('/')
	
	return temp[2] + '-' + temp[1] + '-' + temp[0]
}

function verificaValorMaiorQueTotal() {
	let retorno;
	let valorParcela = converteMoedaFloat($('#valor_parcela').val());
	let somatorio = TOTAL_FATURA + valorParcela;
	console.log(valorParcela);
	console.log(somatorio);
	console.log(TOTAL_ORCAMENTO);
	
	
	if (valorParcela <= 0) {
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Valor deve ser maior que 0"));
		retorno = true;		
	}else if((TOTAL_FATURA + valorParcela) > TOTAL_ORCAMENTO) {
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Somatório das parcelas maior que o total da orcamento"));
		retorno = true;
	}else {
		retorno = false;
	}
	return retorno;
}
function addpagamentoEdit(data, valor) {
		TOTAL_FATURA += (parseFloat(valor)) ;
		
		console.log("FATURA:" + TOTAL_FATURA);
		FATURA.push({ data: data, valor: valor, numero: (FATURA.length + 1) })
		$('.fatura tbody').html(""); // apagar linhas da tabela
		let t = "";
		FATURA.map((v) => {
			let val = formatReal(parseFloat(v.valor));
			t += "<tr class='text-center' style='left: 0px;'>";
			t += "<td class='text-center'><span class='numero' style='width: 160px;'>" + v.numero + "</span></td>";
			t += "<td class='text-center'><span class='' style='width: 160px;'>" + dataBr(v.data) + "</span></td>";
			t += "<td class='text-center'><span class='' style='width: 160px;'>" + val + "</span></td>";
			t += "<td class='text-center text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-vermelho btn-pequeno d-inline-block' href='#prod tbody' onclick='deleteItemFatura(" + v.numero + ")'>"
			t += "<i class='fa fa-trash'></i></a></span></td>";
			t += "</tr>";
		});
		$('.fatura tbody').html(t);		
		atualizarValorVisual();
	
}

function addpagamento(data, valor, txt_forma_pagto, forma_pagto_id) {
	let result = verificaProdutoIncluso();	
	if (!result) {
		TOTAL_FATURA += (parseFloat(valor)) ;
		FATURA.push({ data: data, valor: valor, numero: (FATURA.length + 1), txt_forma_pagto, forma_pagto_id })
		$('.fatura tbody').html(""); // apagar linhas da tabela
		let t = "";
		FATURA.map((v) => {
			let val = formatReal(parseFloat(v.valor));
			t += "<tr class='text-center' style='left: 0px;'>";
			t += "<td class='text-center'><span class='numero' style='width: 160px;'>" + v.numero + "</span></td>";
			t += "<td class='text-center'><span class='' style='width: 160px;'>" + dataBr(v.data) + "</span></td>";
			t += "<td class='text-center'><span class='' style='width: 160px;'>" + val + "</span></td>";
			t += "<td class='text-center'><span class='' style='width: 160px;'>" + v.txt_forma_pagto + "</span></td>";
			t += "<td class='text-center text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-vermelho btn-pequeno d-inline-block' href='#prod tbody' onclick='deleteItemFatura(" + v.numero + ")'>"
			t += "<i class='fa fa-trash'></i></a></span></td>";
			t += "</tr>";
		});
		$('.fatura tbody').html(t);		
		atualizarValorVisual();
	}	
}

function deleteItemFatura(id) {
	let temp = [];
	FATURA.map((v) => {
		if (v.numero != id) {
			temp.push(v)
		} else {
			TOTAL_FATURA -= parseFloat(v.valor) ;
		}
	});
	FATURA = temp;
	let t = "";
	FATURA.map((v) => {
			let val = formatReal(parseFloat(v.valor));
			t += "<tr class='text-center' style='left: 0px;'>";
			t += "<td class='text-center'><span class='numero' style='width: 160px;'>" + v.numero + "</span></td>";
			t += "<td class='text-center'><span class='' style='width: 160px;'>" + dataBr(v.data) + "</span></td>";
			t += "<td class='text-center'><span class='' style='width: 160px;'>" + val + "</span></td>";
			t += "<td class='text-center'><span class='' style='width: 160px;'>" + v.txt_forma_pagto + "</span></td>";			
			t += "<td class='text-center text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-vermelho btn-pequeno d-inline-block' href='#prod tbody' onclick='deleteItemFatura(" + v.numero + ")'>"
			t += "<i class='fa fa-trash'></i></a></span></td>";
			t += "</tr>";
		});
		$('.fatura tbody').html(t);		
		atualizarValorVisual();
	
}

function atualizarValorVisual(){
	$("#total_da_orcamento").html(converteFloatMoeda(TOTAL_ORCAMENTO));
	$("#soma_parcelas").html(converteFloatMoeda(TOTAL_FATURA));
	$("#restante_parcelas").html(converteFloatMoeda(TOTAL_ORCAMENTO- TOTAL_FATURA));
	
	
}
function montaTabelaFatura() {
	let t = "";
	FATURA.map((v) => {
			t += "<tr class='datatable-row' style='left: 0px;'>";
			t += "<td class='datatable-cell'><span class='numero' style='width: 160px;'>" + v.numero + "</span></td>";
			t += "<td class='datatable-cell'><span class='' style='width: 160px;'>" + v.data + "</span></td>";
			t += "<td class='datatable-cell'><span class='' style='width: 160px;'>" + v.valor + "</span></td>";
			t += "<td class='datatable-cell text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-vermelho btn-pequeno d-inline-block' href='#prod tbody' onclick='deleteItemFatura(" + v.numero + ")'>"
			t += "<i class='la la-trash'></i></a></span></td>";
			t += "</tr>";
		});
	return t
}


function salvarOrcamento() {
	var cliente_id 			= $('#cliente_id').val();	
	var formaPagamento 		= $('#formaPagamento').val();
	var tPag 				= $('#tPag').val();
	var opt_nfe 			= $("input[name='rbNFE']:checked").val();


	
	if(ITENS.length<=0){
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira algum item antes!"));	
		return false;
	}
	if( (cliente_id == '--') || (cliente_id == '') ||(cliente_id == 'null') ||(cliente_id == null)) {
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione um cliente para continuar!"));	
		return false;	
	}
	if (formaPagamento == '--') {
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione a forma de Pagamento!"));	
		return false;	
	}
	
	if (tPag == '--') {
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione o meio de pagamento"));	
		return false;	
	}
	
	
	let vol = {
		'especie': $('#especie').val(),
		'numeracaoVol': $('#numeracaoVol').val(),
		'qtdVol': $('#qtdVol').val(),
		'pesoL': $('#pesoL').val(),
		'pesoB': $('#pesoB').val(),
	}
	
	let orcamento = {
		orcamento_id	: $('#orcamento_id').val(),
		cliente_id		: $('#cliente_id').val(),
		forma_pagamento	: $('#formaPagamento').val(),
		valor_frete		: $('#valor_frete').val(),
		total_seguro	: $('#total_seguro').val(),
		despesas_outras	: $('#despesas_outras').val(),	
		tPag			: tPag,	
			
		qtde_parcela	: $('#qtde_parcela').val(),		
		valor_desconto	: $('#desconto_valor').val(),
		data_orcamento	: $('#data_orcamento').val(),
		taxa_desconto	: $('#desconto_per').val(),
		observacao		: $('#observacao').val()
	}
	let js = {	
		
		orcamento 			: orcamento,		
		itens			: ITENS,
		volume			: vol,
		valor_total		: TOTAL,
	}

	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		data: {
			orcamento: js,
			_token: token
		},
		url: base_url + 'admin/orcamento/salvar',
		dataType: 'json',
		beforeSend: function (){
		   giraGira();
	   },
		success: function (data) {
			fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{
				location.href = base_url + "admin/orcamento/";
								
				
			}
		}, error: function (e) {
			console.log(e);
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
	});
	
}

function sucesso() {
	$('#content').css('display', 'none');
	$('#anime').css('display', 'block');
	setTimeout(() => {
		location.href = base_url + 'orcamento';
	}, 4000)
}

