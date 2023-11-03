var codigo = "";
var nome = "";
var ncm = "";
var cfop = "";
var unidade = "";
var valor = "";
var quantidade = "";
var codBarras = "";
var cfopEntrda = "";

var semRegitro;
$(function () {
	semRegitro = $('#prodSemRegistro').val();
	if(semRegitro == 0){
		$('#salvarNF').removeClass("disabled");
		$('.sem-registro').css('display', 'none');
	}
	verificaProdutoSemRegistro();
});

function verificaProdutoSemRegistro(){
	if(semRegitro == 0){
		$('#salvarNF').removeClass("disabled");
		$('.sem-registro').css('display', 'none');
	}else{
		$('.prodSemRegistro').html(semRegitro);
	}
}



function deleteProd(item){
	if (confirm('Deseja excluir este item, se confirmar sua NF ficará informal?')) { 
		var tr = $(item).closest('tr');	
		console.log(tr)
		tr.fadeOut(500, function() {	      
			tr.remove();  
			verificaTabelaVazia();	
			verificaProdutoSemRegistro();
		});	

		return false;
	}
}

function editProd(id){
	let produtoId = $('#th_prod_id_'+id).html();
	$('#idEdit').val(id)
	$.ajax
	({
		type: 'GET',
		url: path + 'produtos/getProduto/'+produtoId,
		dataType: 'json',
		success: function(e){
			console.log(e)
			$("#nomeEdit").val(e.nome)
			$("#conv_estoqueEdit").val(e.conversao_unitaria)
			$('#modal2').modal('show');
		}, error: function(e){
			console.log(e);
		}
	});
}

function verificaTabelaVazia(){
	if($('table tbody tr').length == 0){
		$('#salvarNF').addClass("disabled");
	}
}

$('#salvarEdit').click(() => {
	let id = $('#idEdit').val();
	$('#th_'+id).html($('#nomeEdit').val());
	$('#th_prod_conv_unit_'+id).html($('#conv_estoqueEdit').val());
	$('#modal2').modal('hide');
})

$('#salvar').click(() => {	
	let codigo 		=  $('#codigo').val();	
	let valorVenda 	 = $('#valor_venda').val();
	let valor_compra = $('#valor_compra').val();
	let unidadeVenda = $('#unidade_venda').val();
	let conversaoEstoque =$('#conv_estoque').val();
	let categoria_id =$('#categoria_id').val();
	let cfop 		 = $('#cfop').val();

	let CST_CSOSN 	=$('#CST_CSOSN').val();
	let CST_PIS 	=$('#CST_PIS').val();
	let CST_COFINS 	=$('#CST_COFINS').val();
	let CST_IPI 	=$('#CST_IPI').val();
	let ncm			= $('#NCM').val();
	let unidade		= $('#unidade_compra').val();
	let valor		= $('#valor_compra').val();
	let quantidade	= $('#quantidade').val();
	let codBarras	= $('#codBarras').val();
	let tributacao_id	= $('#tributacao_id').val();

	let prod = {
		valorVenda: valorVenda,
		unidadeVenda: unidadeVenda,
		conversao_unitaria: conversaoEstoque,
		categoria_id: categoria_id,
		tributacao_id:tributacao_id,
		valorCompra: valor_compra,
		nome: $('#nome').val(),
		ncm: ncm,
		cfop: cfop,
		referencia: codigo,
		unidadeCompra: unidade,
		valor: valor,
		quantidade: quantidade,
		codBarras: codBarras,
		CST_CSOSN: CST_CSOSN,
		CST_PIS: CST_PIS,
		CST_COFINS: CST_COFINS,
		CST_IPI: CST_IPI,
		valorCompra: valor
	}
	//console.log(prod);
	semRegitro--;
	
	let token = $('#_token').val();
	$.ajax({
		type: 'POST',
		data: {
			produto: prod,
			_token: token
		},
		url: path + 'produto/salvarProdutoDaNota',
		dataType: 'json',
		success: function(e){
			fecharModal();
			alert('Sucesso', 'Item salvo', 'success')
		}, error: function(e){
			console.log(e)
			$('#preloader').css('display', 'none');
		}
	});
	
})


$('#salvarNF').click(() => {
	$('#preloader2').css('display', 'block');
	let dadosNota = {
		fornecedor_id: 	$('#idFornecedor').val(),
		nNf: 			$('#nNf').val(),
		valor_nf: 		$('#valorDaNF').html(),
		observacao: 	'*',
		desconto: 		$('#vDesc').val(),
		xml_path: 		$('#pathXml').val(),
		chave: 			$('#chave').val(),
	};
	
	const itens = [];
	$('#lista_itens').each(function(){
		let item = {
			cod_barras 		: $(this).find('.codBarras').html(),
			nome 			: $(this).find('.nome').html(),
			conversao_unitaria : parseInt($(this).find('.conv_estoque').html()),
			produto_id 		: parseInt($(this).find('.cod').html()),
			unidade 		: $(this).find('.unidade').html(),
			quantidade 		: $(this).find('.quantidade').html(),
			cfop_entrada 	: $(this).find('#cfop_entrada_input').val(),
			valor 			: $(this).find('.valor').html()
		}
		itens.push(item);
	});
	
	let fatura = $('#fatura').val();
	fatura = JSON.parse(fatura);
	retorno = [];
	let cont = 0;
	
	if(fatura.length > 0){
		fatura.map((item) => {
			cont++;
			item.numero = item.numero[0];
			item.referencia = "Parcela "+cont+", da NF " + $('#nNf').val();			
		});
	}
	
	
	let token = $('#_token').val();
	$.ajax({
		type: 'POST',
		data: {
			nf: dadosNota,
			fatura: fatura,
			itens:itens,
			_token: token
		},
		url: path + 'compra/salvarNfFiscal',
		dataType: 'json',
		success: function(e){
			call(e)

		}, error: function(e){
			console.log(e)
			$('#preloader2').css('display', 'none');
		}

	});
	
})

function salvarFatura(compra_id, call){
	let fatura = $('#fatura').val();
	fatura = JSON.parse(fatura);
	retorno = [];
	let token = $('#_token').val();
	let cont = 0; 

	if(fatura.length > 0){
		fatura.map((item) => {
			cont++;
			item.numero = item.numero[0];
			item.referencia = "Parcela "+cont+", da NF " + $('#nNf').val();
			item.compra_id = compra_id;

			console.log(item)
			$.ajax
			({
				type: 'POST',
				data: {
					parcela: item,
					_token: token
				},
				url: path + 'contasPagar/salvarParcela',
				dataType: 'json',
				success: function(e){
					console.log(e)
					call(e)

				}, error: function(e){
					console.log(e)
					$('#preloader2').css('display', 'none');
				}

			});
		})
	}else{
		sucesso();
		$('#preloader2').css('display', 'none');
	}
}


function sucesso(){
	console.log("sucesso")
	$('#content').css('display', 'none');
	$('#anime').css('display', 'block');
	setTimeout(() => {
		location.href = path+'compras';
	}, 4000)
}

function salvarNF(call){
	
	let js = {
		fornecedor_id: 	$('#idFornecedor').val(),
		nNf: 			$('#nNf').val(),
		valor_nf: 		$('#valorDaNF').html(),
		observacao: 	'*',
		desconto: 		$('#vDesc').val(),
		xml_path: 		$('#pathXml').val(),
		chave: 			$('#chave').val(),
	}
	console.log(js);
	let token = $('#_token').val();
	$.ajax({
		type: 'POST',
		data: {
			nf: js,
			_token: token
		},
		url: path + 'compra/salvarNfFiscal',
		dataType: 'json',
		success: function(e){
			call(e)

		}, error: function(e){
			console.log(e)
			$('#preloader2').css('display', 'none');
		}

	});
}

function getUnidadeMedida(call){
	$.ajax
	({
		type: 'GET',
		url: path + 'produtos/getUnidadesMedida',
		dataType: 'json',
		success: function(e){
			console.log(e)
			call(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

function salvarItens(id, call){
	let token = $('#_token').val();
	$('table tbody tr').each(function(){
		let js = {
			cod_barras : $(this).find('.codBarras').html(),
			nome : $(this).find('.nome').html(),
			conversao_unitaria : parseInt($(this).find('.conv_estoque').html()),
			produto_id : parseInt($(this).find('.cod').html()),
			compra_id : id,
			unidade : $(this).find('.unidade').html(),
			quantidade : $(this).find('.quantidade').html(),
			valor : $(this).find('.valor').html(),
			cfop_entrada : $(this).find('#cfop_entrada_input').val(),
			said : $(this).find('#codigo_siad_input').val(),
		}

		console.log(js)
		$.ajax
		({
			type: 'POST',
			data: {
				produto: js,
				_token: token
			},
			url: path + 'compraFiscal/salvarItem',
			dataType: 'json',
			success: function(success){
				console.log("teste", success)
			}, error: function(e){
				console.log(e)
				$('#preloader2').css('display', 'none');
			}

		});
	});
	call(true)

}