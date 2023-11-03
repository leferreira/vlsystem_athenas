
var ITENS = [];
var FATURA = [];
var TOTAL = parseFloat(0);
var TOTAL_COMPRA = parseFloat(0);
var TOTAL_FATURA= parseFloat(0);

var PRODUTOS 	= [];

$(function () {
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
				   html +='<li><a href="javascript:;" onclick="selecionarProdutoVenda(this)" ' +
				   		  'data-id="'+data[i].id +
				   		  '" data-preco = "' + data[i].valor_venda +
				   		  '" data-nome = "' + data[i].nome + '">' +
				   		  data[i].nome + " - RS " + data[i].valor_venda + '</a></li>' 
				  
			   }
			   
			   $(".listaProdutos").html(html);
			   $(".listaProdutos").show();
		   }
	   });
   })
	
	
	if($('#compra_edit').val()){	
		PRODUTOS = JSON.parse($('#produtos').val());	
		COMPRA = JSON.parse($('#compra_edit').val());			
		COMPRA.itens.map((rs) => {			
			addItemTable(rs.produto.id, rs.produto.nome, rs.quantidade.toString(), rs.valor_unitario);			
		});
		let t = montaTabela();
		$('#prod tbody').html(t);
			
		
		if(COMPRA.faturas.length > 0){
			COMPRA.faturas.map((rs) => {
				addpagamentoEdit(rs.data_vencimento, rs.valor)
			})
		}
	}
});

function selecionarProdutoVenda(obj){
	var id= $(obj).attr('data-id');
	var nome= $(obj).attr('data-nome');
	var preco= $(obj).attr('data-preco');
	$(".listaProdutos").hide();
	
	$("#produto_id").val(id);
	$("#desc_produto").val(nome);
	$("#valor").val(preco);
	$("#subtotal").val(preco);	
	$("#quantidade").val(1);
	$("#valor").focus();	
}
/*
$('.produto').change(() => {
	let produto_id = $('#produto_id').val()

	if (produto_id != '--') {
		getProduto(produto_id, (d) => {
			$('#desc_produto').val(d.nome)
			$('#quantidade').val(1)
			$('#quantidade').focus()
			$('#valor').val("")
			$('#subtotal').val("")

		})
	}
})
*/
function getLastPurchase(produto_id, call) {
	$('#preloader-last-purchase').css('display', 'block')
	$.get(base_url + 'compraManual/ultimaCompra/' + produto_id)
	.done((success) => {
		call(success)
		$('#preloader-last-purchase').css('display', 'none')
	})
	.fail((err) => {
		call(err)
		$('#preloader-last-purchase').css('display', 'none')
	})
}


function getFornecedor(id, data) {
	$.ajax
	({
		type: 'GET',
		url: base_url + 'admin/fornecedor/find/' + id,
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



$('#valor').on('keyup', () => {
	calcSubtotal()
})

$('#quantidade').on('keyup', () => {
	calcSubtotal()
})

$('#frete').on('keyup', () => {
	atualizaTotalCompra()
})



$('#desconto_valor').on('keyup', () => {
	atualizaTotalCompra()
})
$('#desconto_per').on('keyup', () => {	
	atualizaTotalCompra()
})

function calcSubtotal() {
	let quantidade 	= converteMoedaFloat($('#quantidade').val());
	let valor 		= converteMoedaFloat($('#valor').val());	
	let subtotal 	= valor * quantidade;
	$('#subtotal').val(subtotal.toFixed(2));
}

$('#autocomplete-produto').on('keyup', () => {
	$('#last-purchase').css('display', 'none')
})

$('#addProd').click(() => {
	let codigo 		= $('#produto_id').val();
	let nome 		= $('#desc_produto').val();
	let quantidade  = converteMoedaFloat($('#quantidade').val());
	let valor 		= converteMoedaFloat($('#valor').val());	
	
	if(codigo.length <= 0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione um Produto primeiramente"));
		return false;
	}
	
	if(nome.length <= 0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione um Produto primeiramente"));
		return false;
	}
	
	if(quantidade.length <= 0 && parseFloat(quantidade <= 0)){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Digite a quantidade primeiramente"));
		return false;
	}
	
	if(valor.length > 0 && valor < 0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Digite o Valor primeiramente"));
		return false;
	}		
	
	addItemTable(codigo, nome, quantidade, valor);
	
});


function addItemTable(codigo, nome, quantidade, valor) {
	if (!verificaProdutoIncluso()) {
		limparDadosFatura();
		
		TOTAL += parseFloat((valor * quantidade).toFixed(2));		
		
		ITENS.push({
			id: (ITENS.length + 1), codigo: codigo, nome: nome,
			quantidade: quantidade, valor: valor
		})
		
		$('.prod tbody').html("");

		atualizaTotal();
		atualizaTotalCompra();
		limparCamposFormProd();
		let t = montaTabela();
		$('.prod tbody').html(t)
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
	$('#autocomplete-produto').val('');
	$('#quantidade').val('0');
	$('#valor').val('0');
}

function limparDadosFatura() {
	$('#fatura tbody').html('')
	$(".data-input").val("");
	$("#valor_parcela").val("");
	$('#add-pag').removeClass("disabled");
	FATURA = [];
	TOTAL_FATURA = 0;

}

function atualizaTotal() {
	$('#total').html(converteFloatMoeda(TOTAL));
	$('#valor_total').val(converteFloatMoeda(TOTAL));
}

function atualizaTotalCompra() {
	var frete 			= ($('#frete').val() !="") ? converteMoedaFloat($('#frete').val()) : parseFloat(0);
	var desconto_valor 	= ($('#desconto_valor').val() !="") ? converteMoedaFloat($('#desconto_valor').val()) : parseFloat(0);
	var desconto_per 	= ($('#desconto_per').val() !="") ? converteMoedaFloat($('#desconto_per').val()) : parseFloat(0);
	
	let total_da_compra = TOTAL +  frete ;
	if(desconto_valor!="" && desconto_valor!="0"){
		total_da_compra = total_da_compra - desconto_valor;
		desconto_per="";		
	}
	
	if(desconto_per!=""  && desconto_per!="0"){
		total_da_compra = total_da_compra - (total_da_compra * desconto_per * 0.01);
		desconto_valor="";		
	}
	TOTAL_COMPRA = parseFloat(total_da_compra.toFixed(2));
	$('#totalcompra').val(TOTAL_COMPRA);
	atualizarValorVisual()
}

function montaTabela() {
	let t = "";
	ITENS.map((v) => {
		var total = v.valor * v.quantidade;
		t += "<tr class='datatable-row' style='left: 0px;'>";
		t += "<td class='datatable-cell'><span class='' style='width: 60px;'>" + v.id + "</span></td>";
		t += "<td class='datatable-cell cod'><span class='codigo' style='width: 60px;'>" + v.codigo + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 120px;'>" + v.nome + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + v.quantidade + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + v.valor + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + total.toFixed(2) + "</span></td>";
		t += "<td class='datatable-cell text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-vermelho d-inline-block btn-pequeno' href='#prod tbody' onclick='deleteItem(" + v.id + ")'>"
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
			TOTAL -= v.valor * v.quantidade;
		}
	});
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

	if ($('#formaPagamento').val() == 'a_vista') {
		$('#valor_parcela').val(TOTAL_COMPRA);	
		addpagamento(data, $('#valor_parcela').val());
		
	}else if ($('#formaPagamento').val() == 'personalizado') {
		$("#qtde_parcela").val(1);
		$("#valor_parcela").val(TOTAL_COMPRA);
		$('.fatura tbody').html("");		
	}
	atualizarValorVisual();	
})

$('#add-pag-manual').click(() => {
	if (!verificaValorMaiorQueTotal()) {		
		let data 	= $('#primeiro_vencimento').val();
		let valor 	= converteMoedaFloat($('#valor_parcela').val());		
		/*let cifrao 	= valor.substring(0, 2);
		
		if (cifrao == 'R$') 
			valor = valor.substring(3, valor.length);	*/
		
		if(data.length <= 0){
			$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione uma data inicial"));
			return false;
		}
				
		if (data.length > 0  && valor > 0) {	
			addpagamento(data, valor);				
		}
			
	}
})

$('#add-pag-automatico').click(() => {		
		let data 		= $('#primeiro_vencimento').val();
		let valor 		= converteMoedaFloat($('#valor_parcela').val());
		let qtde_parcela= parseInt($('#qtde_parcela').val());

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
				parcela = TOTAL_COMPRA - tot;
			}else{
				parcela = valor;				
			}
			tot += valor;
			addpagamento(novaData, parcela);
		}	
})


function converterData(data){
	let temp = data.split('/')
	
	return temp[2] + '-' + temp[1] + '-' + temp[0]
}

function verificaValorMaiorQueTotal() {
	let retorno;
	let valorParcela = converteMoedaFloat($('#valor_parcela').val());	
	
	if (valorParcela <= 0) {
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Valor deve ser maior que 0"));
		retorno = true;		
	}else if((TOTAL_FATURA + valorParcela) > TOTAL_COMPRA) {
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Somatório das parcelas maior que o total da venda"));
		retorno = true;
	}else {
		retorno = false;
	}
	return retorno;
}

function addpagamentoEdit(data, valor) {
		TOTAL_FATURA += (parseFloat(valor)) ;
		FATURA.push({ data: data, valor: valor, numero: (FATURA.length + 1) })
		$('.fatura tbody').html(""); // apagar linhas da tabela
		let t = "";
		FATURA.map((v) => {
			let val = converteFloatMoeda(formatarFloat(parseFloat(v.valor)));
			t += "<tr class='text-center' style='left: 0px;'>";
			t += "<td class='text-center'><span class='numero' style='width: 160px;'>" + v.numero + "</span></td>";
			t += "<td class='text-center'><span class='' style='width: 160px;'>" + dataBr(v.data) + "</span></td>";
			t += "<td class='text-center'><span class='' style='width: 160px;'>" + val + "</span></td>";
			t += "<td class='text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-vermelho btn-pequeno d-inline-block' href='#prod tbody' onclick='deleteItemFatura(" + v.numero + ")'>"
			t += "<i class='fa fa-trash'></i></a></span></td>";
			t += "</tr>";
		});
		$('.fatura tbody').html(t);		
		atualizarValorVisual();
		
}


function addpagamento(data, valor) {
	let result = verificaProdutoIncluso();	
	if (!result) {
		TOTAL_FATURA += (parseFloat(valor)) ;
		FATURA.push({ data: data, valor: valor, numero: (FATURA.length + 1) })
		$('.fatura tbody').html(""); // apagar linhas da tabela
		let t = "";
		FATURA.map((v) => {
			let val = converteFloatMoeda(formatarFloat(parseFloat(v.valor)));
			t += "<tr class='text-center' style='left: 0px;'>";
			t += "<td class='text-center'><span class='numero' style='width: 160px;'>" + v.numero + "</span></td>";
			t += "<td class='text-center'><span class='' style='width: 160px;'>" + dataBr(v.data) + "</span></td>";
			t += "<td class='text-center'><span class='' style='width: 160px;'>" + val + "</span></td>";
			t += "<td class='text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-vermelho btn-pequeno d-inline-block' href='#prod tbody' onclick='deleteItemFatura(" + v.numero + ")'>"
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
	let t = montaTabelaFatura();
	$('.fatura tbody').html(t);
	atualizarValorVisual();
	
}

function atualizarValorVisual(){
	$("#total_da_compra").html(TOTAL_COMPRA);
	$("#soma_parcelas").html(TOTAL_FATURA);
	$("#restante_parcelas").html(TOTAL_COMPRA- TOTAL_FATURA);
	
}
function montaTabelaFatura() {
	let t = "";
	FATURA.map((v) => {
			t += "<tr class='datatable-row' style='left: 0px;'>";
			t += "<td class='datatable-cell'><span class='numero' style='width: 160px;'>" + v.numero + "</span></td>";
			t += "<td class='datatable-cell'><span class='' style='width: 160px;'>" + dataBr(v.data) + "</span></td>";
			t += "<td class='datatable-cell'><span class='' style='width: 160px;'>" + v.valor + "</span></td>";
			t += "<td class='datatable-cell text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-vermelho btn-pequeno d-inline-block' href='#prod tbody' onclick='deleteItemFatura(" + v.numero + ")'>"
			t += "<i class='fas fa-trash'></i></a></span></td>";
			t += "</tr>";
		});
	return t
}


function salvarCompra() {
	var fornecedor 			= $('.fornecedor').val();	
	var formaPagamento 		= $('#formaPagamento').val();
	
	if (TOTAL_FATURA < TOTAL_COMPRA) {
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("O valor total da compra é menor que a soma das parcelas. Valor pendente:" + formatReal(TOTAL_COMPRA -TOTAL_FATURA)  ));	
		return false;	
	}
	
	if (fornecedor == '--') {
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione um fornecedor para continuar!"));	
		return false;	
	}
		
	let js = {
		fornecedor: fornecedor,
		formaPagamento	: $('#formaPagamento').val(),
		compra_id		: $('#compra_id').val(),
		itens			: ITENS,
		fatura			: FATURA,
		valor_total		: TOTAL,
		fornecedor_id	: $('#fornecedor_id').val(),
		transportadora_id:$('#transportadora_id').val(),
		centro_custo_id	: $('#centro_custo_id').val(),
		valor_frete		: $('#frete').val(),	
		valor_desconto	: $('#desconto_valor').val(),
		data_compra		: $('#data_entrada').val(),
		nf				: $('#num_nfe').val(),
		
		lancar_estoque	: $('#lancar_estoque').is(':checked'),
		lancar_financeiro: $('#lancar_financeiro').is(':checked'),
		
		taxa_desconto	: $('#desconto_per').val(),
		qtde_parcela	: $('#qtdParcelas').val(),
		primeiro_vencimento: $('#primeiro_vencimento').val(),
		observacao		: $('#observacao').val(),
		observacao_interna: $('#observacao_interna').val()
	}

	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		data: {
			compra: js,
			_token: token
		},
		url: base_url + 'admin/compra/salvar',
		dataType: 'json',
		beforeSend: function (){
		   giraGira();
	   },
		success: function (e) {
			fecharModal();
			$("#mostrarSucesso").html(MostrarUmaMsgSucesso("Salvo com sucesso, aguarde..."));
		    location.href = base_url + "admin/compra";
		    
		}, error: function (e) {
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
		location.href = base_url + 'compra';
	}, 4000)
}

