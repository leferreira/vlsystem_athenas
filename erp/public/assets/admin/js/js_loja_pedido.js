var ITENS 		= [];
var FATURA 		= [];
var TOTAL 		= parseFloat(0);
var TOTAL_VENDA = parseFloat(0);
var TOTAL_FATURA= parseFloat(0);

var TOTAL_DESCONTO_ITENS= parseFloat(0.0);

var PRODUTOS 	= [];
var unidades 	= [];

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
				   html +=	'<li><a href="javascript:;" onclick="selecionarProdutoVenda(this)" ' +	
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
				   html +=	'<li><a href="javascript:;" onclick="selecionarClienteVenda(this)" ' +	
				   		  	'data-cliente_id="'+data[i].id +				   		  	
							'" data-nome_razao_social = "' + data[i].nome_razao_social + '">' +
				   		 	 data[i].nome_razao_social + '</a></li>' 
				}
			   
			   $(".listaClientes").html(html);
			   $(".listaClientes").show();
		   }
	   });
   })
   
   $("#desc_vendedor").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return;
	   }
	   $.ajax({
		   url: base_url + "admin/vendedor/pesquisa",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   $("#desc_vendedor").after('<ol class="listaVendedor"></ol>');
			   html="";
			   for(var i in data){
				   html +=	'<li><a href="javascript:;" onclick="selecionarVendedorVenda(this)" ' +	
				   		  	'data-vendedor_id="'+data[i].id +				   		  	
							'" data-nome = "' + data[i].nome + '">' +
				   		 	 data[i].nome + '</a></li>' 
				}
			   
			   $(".listaVendedor").html(html);
			   $(".listaVendedor").show();
		   }
	   });
   })
	
});

$('#quantidade').on('keyup', () => {
	atualizaTotalCompra();
	calcularDescontoItem();
})

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


$('#total_seguro').on('keyup', () => {
	atualizaTotalCompra()
})

$('#despesas_outras').on('keyup', () => {
	atualizaTotalCompra()
})



$('#valor_frete').on('keyup', () => {
	atualizaTotalCompra();
	calcularDescontoItem();
})


$('#desconto_valor').on('keyup', () => {
	$('#desconto_per').val("");
	atualizaTotalCompra()
})

$('#desconto_per').on('keyup', () => {	
	$('#desconto_valor').val("");
	atualizaTotalCompra()
})


		
function atualizaTotalCompra() {
	var valor_frete		= ($('#valor_frete').val() !="") ? converteMoedaFloat($('#valor_frete').val()) : parseFloat(0);	
	var total_seguro 	= ($('#total_seguro').val() !="") ? converteMoedaFloat($('#total_seguro').val()) : parseFloat(0);
	var despesas_outras = ($('#despesas_outras').val() !="") ? converteMoedaFloat($('#despesas_outras').val()) : parseFloat(0);
	var desconto_valor 	= ($('#desconto_valor').val() !="") ? converteMoedaFloat($('#desconto_valor').val()) : parseFloat(0);
	var desconto_per 	= ($('#desconto_per').val() !="") ? converteMoedaFloat($('#desconto_per').val()) : parseFloat(0);
	
	let total_da_venda  = TOTAL - TOTAL_DESCONTO_ITENS ;
	
	if(desconto_valor!="" && desconto_valor!="0"){
		total_da_venda = total_da_venda - desconto_valor ;
		desconto_per="";		
	}
	
	if(desconto_per!=""  && desconto_per!="0"){
		total_da_venda = total_da_venda - (total_da_venda * desconto_per * 0.01) ;
		desconto_valor="";		
	}
	TOTAL_VENDA = parseFloat(total_da_venda +  valor_frete + total_seguro + despesas_outras).toFixed(2);
	$('#totalvenda').val(converteFloatMoeda(TOTAL_VENDA));
	$("#valor_parcela").val(converteFloatMoeda(TOTAL_VENDA));
	
}
function selecionarUnidade(){
	var unid = $("#unidade_venda").val();
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

function selecionarClienteVenda(obj){
	var id					= $(obj).attr('data-cliente_id');
	var nome				= $(obj).attr('data-nome_razao_social');	
	
	$(".listaClientes").hide();
	$("#cliente_id").val(id);
	$("#desc_cliente").val(nome);	
}

function selecionarVendedorVenda(obj){
	var id					= $(obj).attr('data-vendedor_id');
	var nome				= $(obj).attr('data-nome');	
	
	$(".listaVendedor").hide();
	$("#vendedor_id").val(id);
	$("#desc_vendedor").val(nome);	
}
function selecionarProdutoVenda(obj){
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
	
	$("#unidade_venda").html(html); 	
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

$('#addProd').click(() => {
	let produto_id 	= $('#produto_id').val();
	let nome 		= $('#desc_produto').val();
	let quantidade  = converteMoedaFloat($('#quantidade').val());
	let valor 		= converteMoedaFloat($('#valor').val());
	let unidade		= $('#unidade_venda').val();
	let desconto	= converteMoedaFloat($('#desconto').val());
	let desconto_item	= converteMoedaFloat($('#desconto_item').val());
	let tipo_desc	= $('#tipo_desc').val();
	let valor_desconto= converteMoedaFloat($('#val_desconto').val());
	let desconto_percentual = 0;
	let desconto_por_valor =0;

	if(produto_id == ''){
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
	
	if(Number.isNaN(quantidade)){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Digite a quantidade primeiramente"));
		return false;
	}

	if(Number.isNaN(valor)){
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Digite a Valor primeiramente"));
		return false;
	}
	
	if(valor_desconto > 0){
		if(tipo_desc=="desc_perc"){
			desconto_percentual = valor_desconto;
			desconto_por_valor = 0;
		}
		
		if(tipo_desc=="desc_valor"){
			desconto_percentual = 0;
			desconto_por_valor = valor_desconto;
		}
	}
	
	$.ajax({
         url: base_url + "admin/produto/pesquisarProdutoPorId/" + produto_id,
         type: "get",
         data: {},
         dataType:"Json",
         success: function(data){
			fecharModal();					
			if(data.tem_erro == true){		
				alert("Produto não encontrado");
			}else{
				addItemTable(produto_id, data.retorno.nome, quantidade, unidade, valor, desconto, desconto_item,  desconto_percentual, desconto_por_valor  );
			}					
		},
		  beforeSend: function () {
			giraGira();
	     }
			        
     });	
	

});

function addItemTable(codigo, nome, quantidade, unidade, valor, desconto, desconto_item,  desconto_percentual, desconto_por_valor  ) {	
	if (!verificaProdutoIncluso()) {		
	
		TOTAL += parseFloat((valor * quantidade).toFixed(2));
		TOTAL_DESCONTO_ITENS += parseFloat(desconto);		
		ITENS.push({
			id: (ITENS.length + 1), produto_id: codigo, nome: nome,
			quantidade: quantidade, unidade:unidade, valor: valor, 
			desconto:desconto, desconto_item:desconto_item,
			desconto_percentual: desconto_percentual,
			desconto_por_valor: desconto_por_valor
		})		
		TOTAL = parseFloat(TOTAL.toFixed(2));
		TOTAL_DESCONTO_ITENS =  parseFloat(TOTAL_DESCONTO_ITENS.toFixed(2));
		$('.prod tbody').html("");

		atualizaTotal();
		atualizaTotalCompra();
		limparCamposFormProd();
		let t = montaTabela();
		$('.prod tbody').html(t);
		
	}
}

function calcularDescontoItem(){
	let tipo_desc 	= $('#tipo_desc').val();
	let qtde 		= converteMoedaFloat($('#quantidade').val());
	let preco 		= converteMoedaFloat($('#valor').val());
	let subtotal 	= preco * qtde;
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
	$('#subtotal').val(converteFloatMoeda(subtotal.toFixed(2)));
}

function atualizaTotal() {
	
	$('#total').html(converteFloatMoeda(TOTAL));
	$('#valor_total').val(converteFloatMoeda(TOTAL));
	$('#total_desconto_item').val(converteFloatMoeda(TOTAL_DESCONTO_ITENS));
}



function montaTabela() {
	let t = "";
	ITENS.map((v) => {
		var total = parseFloat(v.valor * v.quantidade).toFixed(2);
		
		var totalComDesconto = parseFloat(total - v.desconto).toFixed(2);
	
		t += "<tr class='datatable-row' style='left: 0px;'>";
		t += "<td class='datatable-cell'><span class='' style='width: 60px;'>" + v.id + "</span></td>";
		t += "<td class='datatable-cell cod'><span class='codigo' style='width: 60px;'>" + v.produto_id + "</span></td>";
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
			TOTAL_DESCONTO_ITENS -= parseFloat(v.desconto);
		}
	});
	TOTAL = parseFloat(TOTAL.toFixed(2));
	ITENS = temp;
	let t = montaTabela(); // para remover
	$('.prod tbody').html(t)
	atualizaTotal();
}

function verificaProdutoIncluso() {
	if (ITENS.length == 0) return false;
	if ($('#prod tbody tr').length == 0) return false;
	let cod = $('#autocomplete-produto').val().split('-')[0];
	let duplicidade = false;

	ITENS.map((v) => {
		if (v.produto_id == cod) {
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
	$('#produto_id').val('');
	$('#quantidade').val('0');
	$('#desc_produto').val('');
	$('#subtotal').val('0');
	$('#valor').val('');
	$('#valor_unitario').val('');
	$('#unidade_venda').val('');
	$("#desc_produto").focus();
	$("#total_item").val('0');
	
}

function salvarVenda() {	
	if(ITENS.length<=0){
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira algum item antes!"));	
		return false;
	}	

	
	let js = {	
		cliente_id		: $('#cliente_id').val(),
		vendedor_id		: $('#vendedor_id').val(),
		valor_frete		: $('#valor_frete').val(),
		total_seguro	: $('#total_seguro').val(),
		despesas_outras	: $('#despesas_outras').val(),
		desconto_valor	: $('#desconto_valor').val(),
		desconto_per	: $('#desconto_per').val(),		
		data_venda		: $('#data_venda').val(),
		itens			: ITENS
	}

	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		data: {
			venda: js,
			_token: token
		},
		url: base_url + 'admin/lojapedido/salvarVenda',
		dataType: 'json',
		beforeSend: function (){
		   giraGira();
	   },
		success: function (data) {
			fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{
				//location.href = base_url + "admin/venda/edit/"+ data.retorno ;				
				location.href = data.redirect;
			}
		}, error: function (e) {
			console.log(e);
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
	});
	
}


