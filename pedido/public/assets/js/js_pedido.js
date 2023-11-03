
var ITENS = [];
var FATURA = [];
var TOTAL = 0;
var TOTAL_VENDA = 0;
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});

$(function () {
	$("#produto").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return;
	   }
	   $.ajax({
		   url: base_url + "produto/pesquisa",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   $("#produto").after('<div class="list"></div>');
			   html="";
			   for(var i in data){
				   html +='<li><a href="javascript:;" onclick="selecionarProduto(this)" ' +
				   		  'data-uuid="'+data[i].uuid +
				   		  '" data-preco = "' + data[i].preco +
				   		  '" data-nome = "' + data[i].nome + '">' +
				   		  data[i].nome + " - RS " + data[i].preco + '</a></li>';
			   }			   
			   $(".list").html(html);
			   $(".list").show();
		   }
	   });
   })
	
});


function selecionarProduto(obj){
	var uuid	= $(obj).attr('data-uuid');
	var nome	= $(obj).attr('data-nome');
	var preco	= $(obj).attr('data-preco');
	$(".list").hide();	
	
	$("#produto_uuid").val(uuid);
	$("#produto").val(nome);
	$("#preco").val(converteFloatMoeda(preco));
	$("#subtotal").val(converteFloatMoeda(preco));	
	$("#qtde").val(converteFloatMoeda(1));
	$("#qtde").focus();
		
}


$('#qtde').on('keyup', () => {
	calcSubtotal()
})

$('#qtde').on('change', () => {
	calcSubtotal()
})

function calcSubtotal() {
	let quantidade 	= converteMoedaFloat($('#qtde').val());
	let valor 	  	= converteMoedaFloat($('#preco').val());
	let subtotal 	= valor * quantidade;
	$('#subtotal').val(converteFloatMoeda(subtotal.toFixed(2)));
}

function maskMoney(v) {
	return v.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

$('#addProd').click(() => {
	let codigo 		= $('#produto_uuid').val();
	let nome 		= $('#produto').val();
	let quantidade  = converteMoedaFloat($('#qtde').val());
	let valor 		= converteMoedaFloat($('#preco').val());
	
	
		
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

	addItemTable(codigo,  nome, quantidade, valor);

});

function addItemTable(codigo, nome, quantidade, valor) {
	if (!verificaProdutoIncluso()) {
		TOTAL += parseFloat((valor * quantidade).toFixed(2));		
		ITENS.push({
			id: (ITENS.length + 1),  codigo: codigo, nome: nome,
			quantidade: quantidade, valor: valor
		});
		TOTAL = parseFloat(TOTAL.toFixed(2));
		$('.prod tbody').html("");
		atualizaTotal();
		limpar();
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

function limpar() {
	$('#produto_uuid').val('');
	$('#produto').val('');
	$('#preco').val('');
	$('#qtde').val('0');
	$('#subtotal').val('0');
	$('#produto').focus();
}


function atualizaTotal() {
	$('#total').html(converteFloatMoeda(TOTAL));
	$('#valor_total').val(converteFloatMoeda(TOTAL));
}



function formatReal(v) {
	return v.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });;
}

function montaTabela() {
	let t = "";
	ITENS.map((v) => {
		var total = parseFloat(v.valor * v.quantidade).toFixed(2);
		t += "<tr class='datatable-row' style='left: 0px;'>";
		t += "<td class='datatable-cell'><span class='' style='width: 60px;'>" + v.id + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 120px;'>" + v.nome + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(v.valor) + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + converteFloatMoeda(v.quantidade) + "</span></td>";	
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(total) + "</span></td>";
		t += "<td class='datatable-cell text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-vermelho btn-pequeno d-inline-block' href='#prod tbody' onclick='deleteItem(" + v.id + ")'>"
		t += "<i class='fas fa-trash'></i></a></span></td>";
		t += "</tr>";
	});	
	
	return t
}


function deleteItem(codigo) {	
	let temp = [];
	ITENS.map((v) => {
		if (v.id != codigo) {
			temp.push(v)
		} else {
			TOTAL -= v.valor * v.quantidade;
		}
	});
	ITENS = temp;
	let t = montaTabela(); // para remover
	$('.prod tbody').html(t)
	atualizaTotal();
}



function converterData(data){
	let temp = data.split('/')
	
	return temp[2] + '-' + temp[1] + '-' + temp[0]
}




function salvarPedido() {		
	if(ITENS.length<=0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira algum item antes!"));	
		return false;
	}
	
	$.ajax
	({
		type: 'POST',
		data: {
			venda: ITENS
		},
		url: base_url + 'pedido/salvar',
		dataType: 'json',
		beforeSend: function (){
		   giraGira();
	   },
		success: function (data) {
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{
				$("#mostrarSucesso").html(MostrarUmaMsgSucesso("Salvo com sucesso, aguarde..."));
				location.href = base_url ;
			}			
		    fecharModal();
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
		location.href = base_url + 'venda';
	}, 4000)
}

