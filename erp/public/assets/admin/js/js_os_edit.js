var ITENS 		= [];
var FATURA 		= [];

var TOTAL_FATURA= parseFloat(0);

var TOTAL_DESCONTO_ITENS= parseFloat(0.0);

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
   
   $("#desc_servico").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return;
	   }
	   $.ajax({
		   url: base_url + "admin/produto/buscarServico",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   $("#desc_servico").after('<ol class="listaServicos"></ol>');
			   html="";
			   for(var i in data){
				   html +=	'<li><a href="javascript:;" onclick="selecionarServicoVenda(this)" ' +	
				   		  	'data-id="'+data[i].id +
				   		  	'" data-preco = "' + data[i].valor_venda +
				   		  	'" data-nome  = "' + data[i].nome + '">' +
				   		  data[i].nome + " - RS " + data[i].valor_venda + '</a></li>' 
				  
			   }
			   
			   $(".listaServicos").html(html);
			   $(".listaServicos").show();
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
});

$('#quantidade').on('keyup', () => {
	//atualizaTotalCompra();
	calcularDescontoItem();
})

$('#desconto_valor').on('keyup', () => {
	$('#desconto_per').val("");
	//atualizaTotalCompra()
})

$('#desconto_per').on('keyup', () => {	
	$('#desconto_valor').val("");
	//atualizaTotalCompra()
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




$('#quantidade_servico').on('keyup', () => {
	//atualizaTotalCompra();
	calcularDescontoItemServico();
})

$('#val_desconto_servico').on('keyup', () => {
	$('#desc_perc_servico').val("");
	//atualizaTotalCompra()
})

$('#desc_perc_servico').on('keyup', () => {	
	$('#val_desconto_servico').val("");
	//atualizaTotalCompra()
})

$('#val_desconto_servico').on('keyup', () => {
		calcularDescontoItemServico();
})

$('#val_desconto_servico').on('blur', () => {
	let val_desconto= $('#val_desconto_servico').val();
	if(val_desconto==null || val_desconto==''  ){
		$('#val_desconto_servico').val(0);
	}
	calcularDescontoItemServico();
})







$('#total_seguro').on('keyup', () => {
	//atualizaTotalCompra()
})

$('#despesas_outras').on('keyup', () => {
	//atualizaTotalCompra()
})



$('#valor_frete').on('keyup', () => {
	//atualizaTotalCompra();
	calcularDescontoItem();
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

function selecionarServicoVenda(obj){
	var id					= $(obj).attr('data-id');
	var nome				= $(obj).attr('data-nome');
	var preco				= $(obj).attr('data-preco');

	$(".listaServicos").hide();
	
	$("#servico_id").val(id);
	$("#desc_servico").val(nome);
	$("#valor_servico").val(preco);
	$("#subtotal_servico").val(preco);	
	$("#quantidade_servico").val(1);
	$("#total_item").val(converteFloatMoeda(preco));
	calcularDescontoItemServico();
	$("#valor_servico").focus();	
}

$('#addProd').click(() => {
	let os_id 	= $('#os_id').val();
	let produto_id 	= $('#produto_id').val();
	let nome 		= $('#desc_produto').val();
	let quantidade  = converteMoedaFloat($('#quantidade').val());
	let valor 		= converteMoedaFloat($('#valor').val());
	let unidade		= $('#unidade_venda').val();
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
         url: base_url + "admin/produtoos" ,
         type: "POST", 
         data: {
			os_id			: os_id,
			produto_id 		: produto_id,
			quantidade  	: quantidade,
			valor 			: valor,
			unidade			: unidade,
			desconto_percentual : desconto_percentual,
			desconto_por_valor: desconto_por_valor
	
		},
         dataType:"Json",
         success: function(data){
			fecharModal();					
			if(data.tem_erro == true){		
				alert("Produto não encontrado");
			}else{
				location.reload();
			}					
		},
		  beforeSend: function () {
			giraGira();
	     }
			        
     });	
	

});

$('#addServico').click(() => {
	let os_id 		= $('#os_id').val();
	let servico_id 	= $('#servico_id').val();
	let quantidade  = converteMoedaFloat($('#quantidade_servico').val());
	let valor 		= converteMoedaFloat($('#valor_servico').val());	
	let tipo_desc	= $('#tipo_desc').val();
	let valor_desconto= converteMoedaFloat($('#desconto_servico').val());
	let desconto_percentual = 0;
	let desconto_por_valor =0;

	if(servico_id == ''){
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
         url: base_url + "admin/servicoos" ,
         type: "POST", 
         data: {
			os_id			: os_id,
			servico_id 		: servico_id,
			quantidade  	: quantidade,
			valor 			: valor,
			desconto_percentual : desconto_percentual,
			desconto_por_valor: desconto_por_valor
	
		},
         dataType:"Json",
         success: function(data){
			fecharModal();					
			if(data.tem_erro == true){		
				alert("Produto não encontrado");
			}else{
				location.reload();
			}					
		},
		  beforeSend: function () {
			giraGira();
	     }
			        
     });	
	

});

function addItemTable(codigo, nome, quantidade, unidade, valor, desconto, desconto_item) {	
	if (!verificaProdutoIncluso()) {		
	
		TOTAL += parseFloat((valor * quantidade).toFixed(2));
		TOTAL_DESCONTO_ITENS += parseFloat(desconto);		
		ITENS.push({
			id: (ITENS.length + 1), codigo: codigo, nome: nome,
			quantidade: quantidade, unidade:unidade, valor: valor, 
			desconto:desconto, desconto_item:desconto_item
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

function calcularDescontoItemServico(){
	let tipo_desc 	= $('#tipo_desc_servico').val();
	let qtde 		= converteMoedaFloat($('#quantidade_servico').val());
	let preco 		= converteMoedaFloat($('#valor_servico').val());
	let subtotal 	= preco * qtde;
	let val_desconto= converteMoedaFloat($('#val_desconto_servico').val());
	var desc    	=  parseFloat(0);
	var desconto   	=  parseFloat(0);			
    
	
	if(tipo_desc=="desc_perc_servico"){
		desconto =  preco * val_desconto * 0.01 ;
	}else if(tipo_desc=="desc_valor_servico"){
		desconto = val_desconto
	}

	desc = 	subtotal - 	(qtde * desconto);	
		

	$('#desconto_servico').val(converteFloatMoeda((qtde * desconto).toFixed(2)));
	$('#desconto_item_servico').val(converteFloatMoeda(desconto.toFixed(2)));	
	$('#total_item_servico').val(converteFloatMoeda(desc.toFixed(2)));
	$('#subtotal_servico').val(converteFloatMoeda(subtotal.toFixed(2)));
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

function abrirModalFinalizarVenda(){
	abrirModal("#modal_finalizar_venda");
}
function finalizarVenda(id) {
	var gerar_nota = $("input[name='lancar_nota']:checked").val();	
	var natureza_operacao_id = $("#natureza_operacao_id").val();
	
	if(gerar_nota=="S"){		
		if(natureza_operacao_id==null || natureza_operacao_id==""  ){
			alert('Selecione Uma Natureza de Operação Primeiramente')
			return;
		}
	}
	$.ajax
	({
		type: 'POST',
		data: {
			"venda_id" : id,
			"natureza_operacao_id": natureza_operacao_id,
			"gerar_estoque": $("input[name='lancar_estoque']:checked").val(),
			"gerar_financeiro": $("input[name='lancar_financeiro']:checked").val(),
			"gerar_nota": gerar_nota
			
		},
		url: base_url + 'admin/venda/finalizarVenda' ,
		dataType: 'json',
		beforeSend: function (){
		   giraGira();
	   },
		success: function (data) {
			fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{
				location.href = data.redirect ;
			}
		}, error: function (e) {
			console.log(e);
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
	});
	
}


function atualizarDadosPagamentos(id){
	$.ajax({
         url: base_url + "admin/venda/atualizarDadosPagamentos",
         type: "post",
         dataType:"Json",
         data:{
        	 venda_id     		: id ,
        	 vendedor_id		: $('#vendedor_id').val(),
        	 valor_frete		: $("#valor_frete").val() ,
        	 total_seguro		: $("#total_seguro").val(),
			 despesas_outras	: $("#despesas_outras").val(),
        	 desconto_valor		: $("#desconto_valor").val() ,
        	 desconto_per		: $("#desconto_per").val()      	
         },
         success: function(data){ 
        	fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{
				alert("atualizacao com sucesso");
				href.reload(); 					
			}              
         },
         beforeSend: function(){           
             giraGira();
        }, error: function (e) {
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
         
     });
}
 
 function inserirDuplicata(){
	var tPag 				= $("#tPag").val();
	var forma_de_parcelar 	= $("#forma_de_parcelar").val()
	var qtde_parcela 		= $("#qtde_parcela").val();
	var valor 				= $("#vLiq").val();
	var venda_id 			= $("#venda_id").val();
    $.ajax({
         url: base_url + "admin/duplicata/inserir",
         type: "post",
         dataType:"Json",
         data:{
        	 venda_id     		: venda_id ,
        	 tPag				: tPag ,
        	 forma_de_parcelar	: forma_de_parcelar,
			 qtde_parcela		: qtde_parcela,  
			 valor				: valor,  	
         },
         success: function(data){ 
			location.reload();             
         },
         beforeSend: function(){           
             
        }
         
     });
   
 } 
 
 function alterarDuplicata(id){
	var tPag 				= $("#tPag_"+id).val();
	var dVenc 				= $("#vencimento_"+id).val()
	var obs 				= $("#obs_"+id).val();
	
    $.ajax({
         url: base_url + "admin/duplicata/salvarAlteracao",
         type: "post",
         dataType:"Json",
         data:{
        	 id     		: id ,
        	 tPag			: tPag ,
        	 dVenc			: dVenc,
			 obs			: obs,     	
         },
         success: function(data){ 
			  console.log(data);
        	  fecharGiraGira();              
         },
         beforeSend: function(){           
             giraGira(); 
        }
         
     });
   
 } 
 
 function lista_duplicata(data){
	    var html = "";
	    for(var i in data){
	        html += "<tr> " +
	               "<td align='center' >" + data[i].nDup + "</td>" +
	               "<td align='center' >" + data[i].dVenc + "</td>" +
	               "<td align='center' >" + data[i].vDup + "</td>" +
				   "<td align='center' >" + data[i].pagamento + "</td>" +
	               "<td align='center' ><a href='javascript:;' onclick='excluirDuplicata("+ data[i].id +")'  class='btn btn-sm btn-danger d-inline-block' title='Excluir'><i class='fas fa-trash'></i></a></td>" +
	       "</tr>"; 
	    }
	    $("#lista_duplicata").html(html);
	    
	}
 
 function excluirDuplicata(id){	
     $.ajax({
       url: base_url + "admin/duplicata/excluir/" + id ,
       type: "GET",
       data: {  },
       dataType:"Json",
       success: function(data){
			//location.reload();
			fecharGiraGira();
			location.reload();
			//window.location.href = base_url + "admin/notafiscal/edit/" + venda_id +"#tab-7" ;
    	  
       },
         beforeSend: function(){           
             giraGira(); 
        }
       
   });
}

