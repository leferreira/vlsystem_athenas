var ITENS = [];
var TOTAL = 0;

$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});

$(function () {	
	$("#produtopacote").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return;
	   }
	   $.ajax({
		   url: base_url + "lojaadmin/lojaproduto/pesquisa/" + q,
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   $("#produtopacote").after('<div class="listaProdutos"></div>');
			   html="";
			   for(var i in data){
				   html +='<div class="si"><a href="javascript:;" onclick="selecionarProdutoPacote(this)" ' +
				   		  'data-id="'+data[i].id +
				   		  '" data-preco = "' + data[i].valor_venda +
				   		  '" data-nome = "' + data[i].nome + '">' +
				   		  data[i].nome + " - RS " + data[i].valor_venda + '</a></div>';
			   }
			   
			   $(".listaProdutos").html(html);
			   $(".listaProdutos").show();
		   }
	   });
   })

	$("#btnInserirItemNoPacote").on("click", function(){
		if ($("#produto_id").val().length == 0){
			$("#mostrarUmErro").html(MostrarUmaMsgErro("Você precisa Selecionar um produto primeiro"));
			return false;		
		}
		if ($("#qtde").val().length == 0){
			$("#mostrarUmErro").html(MostrarUmaMsgErro("Defina a Quantidade"));
			return false;		
		}
		
		var codigo  = $("#produto_id").val();
		var valor	= $("#preco").val();
		var nome	= $("#produtopacote").val();
		var qtde	= $("#qtde").val();
		valor 		= valor.replace(",", ".");
		if (!verificaProdutoIncluso()) {
			TOTAL += parseFloat(valor.replace(',', '.')) * parseFloat(qtde.replace(',', '.'));
			ITENS.push({
						id: (ITENS.length + 1), 
						codigo: codigo, 
						nome: 	nome,
						quantidade: qtde, 
						valor: valor
			})
			// apagar linhas tabela
			$('.prod tbody').html("");
			atualizaTotal();
			limparCampos();
			let t = montaTabela();
			$('.prod tbody').html(t)
		}		
		
	});
	
});

function salvarPacote(){
	if (ITENS.length == 0){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Você precisa inserir pelo menos um item"));
		return false;		
	}	
	var nome 		= $('#nome').val();
	var descricao 	= $('#descricao').val();
	var status_id  	= $('#status_id').val();
	var valor 		= $('#valor').val();
	$.ajax({
		   url: base_url + "lojaadmin/lojapacote",
		   type: "POST",
		   dataType: "json",
		   data: {
					nome:nome,
					descricao: descricao,
					status_id: status_id,
					valor: valor,
					itens: ITENS
				},
		   beforeSend: function (){
			   giraGira();
		   },
		   success: function (){	   
			   $("#mostrarSucesso").html(MostrarUmaMsgSucesso("Salvo com sucesso, aguarde..."));
			   location.href = base_url + "lojaadmin/lojapacote";
			   fecharModal();
		   },
			error:function (data){
				var response = JSON.parse(data.responseText);
				fecharModal();
				$("#mostrarErros").html(MostrarMsgErros(response.errors));			  
		   }
	   });
	
}
function verificaProdutoIncluso() {
	if (ITENS.length == 0) return false;
	if ($('.prod tbody tr').length == 0) return false;
	let cod = $("#produto_id").val();
	let duplicidade = false;

	ITENS.map((v) => {
		if (v.codigo == cod) {
			duplicidade = true;
		}
	})

	let c;
	if (duplicidade) 
		c = !confirm('Produto já adicionado, deseja incluir novamente?');
	else c = false;
		console.log(c)
	return c;
}
function selecionarProdutoPacote(obj){
	var id		= $(obj).attr('data-id');
	var nome	= $(obj).attr('data-nome');
	var preco	= $(obj).attr('data-preco');
	$(".listaProdutos").hide();
	
	$("#produto_id").val(id);
	$("#produtopacote").val(nome);
	$("#preco").val(preco);
	$("#qtde").val(1);
	$("#qtde").focus();
}

function atualizaTotal() {
	$('#totalItens').val(formatReal(TOTAL));	
}

function formatReal(v) {
	return v.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });;
}

function limparCampos() {
	$('#produtopacote').val('');
	$('#qtde').val('1');
	$('#preco').val('0');
	$("#produtopacote").focus();
}
		
function montaTabela() {
	let t = "";
	ITENS.map((v) => {
		t += "<tr>";
		t += "<td align='center'>" + v.id + "</span></td>";
		t += "<td align='center'>" + v.codigo + "</span></td>";
		t += "<td align='center'>" + v.nome + "</span></td>";
		t += "<td align='center'>" + v.quantidade + "</span></td>";
		t += "<td align='center'>" + v.valor + "</span></td>";
		t += "<td align='center'>" + formatReal(v.valor.replace(',', '.') * v.quantidade.replace(',', '.')) + "</span></td>";
		t += "<td align='center'><a class='d-inline-block btn btn-outline-vermelho btn-pequeno' href='javascript:;' onclick='excluirItem(" + v.id + ")'>"
		t += "<i class='fas fa-trash-alt'></i></a></span></td>";
		t += "</tr>";
	});
	return t
}

function excluirItem(id) {
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