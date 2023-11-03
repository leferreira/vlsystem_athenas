
var ITENS = [];
var FATURA = [];
var TOTAL = 0;
var TOTAL_VENDA = 0;

$(function () {
	
});



$('.produto').change(() => {
	let produto_id = $('#produto_id').val()

	if (produto_id != '--') {
		getProduto(produto_id, (d) => {
			$('#desc_produto').val(d.nome)
			$('#quantidade').val(1)
			$('#valor').val(d.valor_venda)
			$('#subtotal').val(d.valor_venda)

		})
	}
})


function getFornecedor(id, data) {
	$.ajax
	({
		type: 'GET',
		url: base_url + 'cadastro/cliente/find/' + id,
		dataType: 'json',
		success: function (e) {
			data(e)

		}, error: function (e) {
			$("#mostrarUmErro").html(MostrarUmaMsgErro(e))
		}

	});
}



function getProduto(id, data) {
	console.log(id)
	$.ajax
	({
		type: 'GET',
		url: base_url + 'cadastro/produto/getProduto/' + id,
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




function calcSubtotal() {
	let quantidade = $('#quantidade').val();
	let valor = $('#valor').val();
	let subtotal = parseFloat(valor.replace(',', '.')) * (quantidade.replace(',', '.'));
	let sub = maskMoney(subtotal)
	$('#subtotal').val(sub)
}

function maskMoney(v) {
	return v.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

$('#autocomplete-produto').on('keyup', () => {
	$('#last-purchase').css('display', 'none')
})

$('#addProd').click(() => {
	$('#last-purchase').css('display', 'none')
	let codigo 		= $('#produto_id').val();
	let nome 		= $('#desc_produto').val();
	let quantidade  = $('#quantidade').val();
	let valor 		= $('#valor').val();
	
	if (codigo.length > 0 && nome.length > 0 && quantidade.length > 0
		&& parseFloat(quantidade.replace(',', '.')) &&
		valor.length > 0 && parseFloat(valor.replace(',', '.')) > 0) {
		if (valor.length > 6) valor = valor.replace(".", "");
	valor = valor.replace(",", ".");

	addItemTable(codigo, nome, quantidade, valor);
} else {
	$("#mostrarUmErro").html(MostrarUmaMsgErro("1 - Informe corretamente os campos para continuar!"));
	

}
});

function addItemTable(codigo, nome, quantidade, valor) {
	if (!verificaProdutoIncluso()) {
		limparDadosFatura();
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

}

function atualizaTotal() {
	$('#total').html(formatReal(TOTAL));
	$('#valor_total').val(formatReal(TOTAL));
}



function formatReal(v) {
	return v.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });;
}

function montaTabela() {
	let t = "";
	ITENS.map((v) => {
		t += "<tr class='datatable-row' style='left: 0px;'>";
		t += "<td class='datatable-cell text-center'><span class='' style='width: 60px;'>" + v.id + "</span></td>";
		t += "<td class='datatable-cell text-center cod'><span class='codigo' style='width: 60px;'>" + v.codigo + "</span></td>";
		t += "<td class='datatable-cell text-center'><span class='' style='width: 120px;'>" + v.nome + "</span></td>";
		t += "<td class='datatable-cell text-center'><span class='' style='width: 100px;'>" + v.quantidade + "</span></td>";
		t += "<td class='datatable-cell text-center'><span class='' style='width: 80px;'>" + v.valor + "</span></td>";
		t += "<td class='datatable-cell text-center'><span class='' style='width: 80px;'>" + formatReal(v.valor.replace(',', '.') * v.quantidade.replace(',', '.')) + "</span></td>";
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
			TOTAL -= parseFloat(v.valor.replace(',', '.')) * (v.quantidade.replace(',', '.'));
		}
	});
	ITENS = temp;
	let t = montaTabela(); // para remover
	$('.prod tbody').html(t)
	atualizaTotal();
}

$('#formaPagamento').change(() => {

	limparDadosFatura();
	let now = new Date();
	let data = now.getFullYear() + "-"+ ((now.getMonth() + 1) < 10 ? "0" + (now.getMonth() + 1) : (now.getMonth() + 1)) +
	"-" + (now.getDate() < 10 ? "0" + now.getDate() : now.getDate());
	
	
	var date = new Date(new Date().setDate(new Date().getDate() + 30));
	let data30 = date.getFullYear() + "-" + ((date.getMonth() + 1) < 10 ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1)) + 
				"-" + (date.getDate() < 10 ? "0" + date.getDate() : date.getDate()) 
	

	$("#qtdParcelas").attr("disabled", true);
	$(".data-input").attr("disabled", true);
	$("#valor_parcela").attr("disabled", true);
	$("#qtdParcelas").val('1');

	if ($('#formaPagamento').val() == 'a_vista') {
		$("#qtdParcelas").val(1)
		$('#valor_parcela').val(formatReal(TOTAL_VENDA));
		$('.data-input').val(data);
	} else if ($('#formaPagamento').val() == '30_dias') {
		$("#qtdParcelas").val(1)
		$('#valor_parcela').val(formatReal(TOTAL_VENDA));
		$('.data-input').val(data30);
	} else if ($('#formaPagamento').val() == 'personalizado') {
		$("#qtdParcelas").removeAttr("disabled");
		$(".data-input").removeAttr("disabled");
		$("#valor_parcela").removeAttr("disabled");
		$(".data-input").val("");
		$("#valor_parcela").val(formatReal(TOTAL_VENDA));
	}
})

$('#qtdParcelas').on('keyup', () => {
	limparDadosFatura();

	if ($("#qtdParcelas").val()) {
		let qtd = $("#qtdParcelas").val();
		$('#valor_parcela').val(formatReal(TOTAL_VENDA / qtd));
	}
})

$('#add-pag').click(() => {

	if (!verificaValorMaiorQueTotal()) {
		let data = $('.data-input').val();
		let valor = $('#valor_parcela').val();
		let cifrao = valor.substring(0, 2);
		if (cifrao == 'R$') valor = valor.substring(3, valor.length)
			if (data.length > 0 && valor.length > 0 && parseFloat(valor.replace(',', '.')) > 0) {
				addpagamento(data, valor);
				if ($('#formaPagamento').val() == 'personalizado') {
					data = converterData(data);
					let date = new Date(data+'T00:00:00')
					date.setDate(date.getDate() + 30)

					let data30 = (date.getDate() < 10 ? "0"+date.getDate() : date.getDate()) + 
					"/"+ ((date.getMonth()+1) < 10 ? "0" + (date.getMonth()+1) : (date.getMonth()+1)) + 
					"/" + date.getFullYear();

					console.log(data30)
					$('.data-input').val(data30)
				}

			} else {
				$("#mostrarUmErro").html(MostrarUmaMsgErro("2 - Informe corretamente os campos para continuar!"));				

			}
		}
	})

function converterData(data){
	let temp = data.split('/')
	
	return temp[2] + '-' + temp[1] + '-' + temp[0]
}

function verificaValorMaiorQueTotal(data) {
	let retorno;
	let valorParcela = $('#valor_parcela').val();
	let qtdParcelas = $('#qtdParcelas').val();

	if (valorParcela <= 0) {

		retorno = true;
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Valor deve ser maior que 0"));

	}

	else if (valorParcela > TOTAL) {
		MostrarUmaMsgErro("Valor da parcela maior que o total da venda!")		
		retorno = true;
	}

	else if (qtdParcelas > 1) {
		somaParcelas((v) => {
			console.log(FATURA.length, parseInt(qtdParcelas))

			if (v + parseFloat(valorParcela) > TOTAL) {
				MostrarUmaMsgErro("Valor ultrapassaou o total!")
				retorno = true;
			}
			else if (v + parseFloat(valorParcela) == TOTAL && (FATURA.length + 1) < parseInt(qtdParcelas)) {
				$("#mostrarUmErro").html(MostrarUmaMsgErro("Respeite a quantidade de parcelas pré definido!"))
				
				retorno = true;

			}
			else if (v + parseFloat(valorParcela) < TOTAL && (FATURA.length + 1) == parseInt(qtdParcelas)) {
				$("#mostrarUmErro").html(MostrarUmaMsgErro("Somátoria incorreta!"));				
				let dif = TOTAL - v;
				$('#valor_parcela').val(formatReal(dif))
				retorno = true;

			}
			else {
				retorno = false;

			}
		})
	}
	else {
		retorno = false;
	}

	return retorno;
}

function somaParcelas(call) {
	let soma = 0;
	FATURA.map((v) => {
		console.log(v.valor)
		// if(v.valor.length > 6){
		// 	v = v.valor.replace('.','');
		// 	v = v.replace(',','.');
		// 	soma += parseFloat(v);

		// }else{
		// 	soma += parseFloat(v.valor.replace(',','.'));
		// }
		soma += parseFloat(v.valor.replace(',', '.'));

	})
	call(soma)
}

function addpagamento(data, valor) {
	let result = verificaProdutoIncluso();
	if (!result) {
		FATURA.push({ data: data, valor: valor, numero: (FATURA.length + 1) })

		$('.fatura tbody').html(""); // apagar linhas da tabela
		let t = "";
		FATURA.map((v) => {
			t += "<tr class='datatable-row' style='left: 0px;'>";
			t += "<td class='datatable-cell'><span class='numero' style='width: 160px;'>" + v.numero + "</span></td>";
			t += "<td class='datatable-cell'><span class='' style='width: 160px;'>" + v.data + "</span></td>";
			t += "<td class='datatable-cell'><span class='' style='width: 160px;'>" + v.valor.replace(',', '.') + "</span></td>";
			t += "</tr>";
		});

		$('.fatura tbody').html(t)
		verificaValor();
	}
	habilitaBtnSalarVenda();
}

function verificaValor() {
	let soma = 0;
	FATURA.map((v) => {
		soma += parseFloat(v.valor.replace(',', '.'));
	})
	if (soma >= TOTAL) {
		$('#add-pag').addClass("disabled");
	}
}


function salvarCompra() {

	var fornecedor 			= $('.fornecedor').val();	
	var prazo_recebimento 	= $('#prazo_recebimento').val();
	
	if(ITENS.length<=0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira algum item antes!"));	
		return false;
	}
	
	if (fornecedor == '--') {
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione um Fornecedor para continuar!"));	
		return false;	
	}	
	
	if (prazo_recebimento == '') {
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione a data de prazo continuar!"));	
		return false;	
	}		
	
	
	let js = {
		fornecedor		: fornecedor,
		itens			: ITENS,
		valor_total		: TOTAL,
		fornecedor_id	: $('#fornecedor_id').val(),
		data_emissao	: $('#data_emissao').val(),
		prazo_recebimento: $('#prazo_recebimento').val(),
		observacao		: $('#observacao').val()
	}

	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		data: {
			venda: js,
			_token: token
		},
		url: base_url + 'admin/ordemcompra',
		dataType: 'json',
		beforeSend: function (){
		   //giraGira();
	   },
		success: function (e) {
			$("#mostrarSucesso").html(MostrarUmaMsgSucesso("Salvo com sucesso, aguarde..."));
		    location.href = base_url + "admin/ordemcompra";
		    fecharModal();
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
	});
	
}

function sucesso() {
	$('#content').css('display', 'none');
	$('#anime').css('display', 'block');
	setTimeout(() => {
		location.href = base_url + 'venda';
	}, 4000)
}

