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


function inserirItem(){
	var cliente_id		= $('#cliente_id').val();
	var	vendedor_id		= $('#vendedor_id').val();
	var ITENS 			= [];
	
	ITENS.push({
			orcamento_id: $("#orcamento_id").val(), 
			produto_id: $("#produto_id").val(), 
			quantidade: $("#quantidade").val(), 
			unidade: $("#unidade_orcamento").val(), 
			valor: $("#valor").val(),
			desconto_percentual: $('#desconto_percentual').val(),
			desconto_por_valor: $('#desconto_por_valor').val()
		})	
		
		
	if(ITENS.length<=0){
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Por favor, insira algum item antes!"));	
		return false;
	}
	if( (cliente_id == '--') || (cliente_id == '') ||(cliente_id == 'null') ||(cliente_id == null)) {
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Não foi possível salvar a venda, Selecione um cliente para continuar!"));	
		return false;	
	}
	
	$.ajax({
		url: base_url + "admin/itemorcamento",
	   type: "POST",
	   dataType: "json",
	   data:{	
	   		cliente_id 		: cliente_id,
	   		vendedor_id 	: vendedor_id,
	   		itens			: ITENS
	   		
	   	},
		 beforeSend: function (){
		   giraGira();
	   },
		success: function (data) {
			fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{				
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


$('#quantidade').on('keyup', () => {
	if($('#quantidade').val()==""){
		$('#quantidade').val(1)
	}	
	calcularDescontoItem();
})

$('#desconto_percentual').on('keyup', () => {
	$('#desconto_por_valor').val(0);
	calcularDescontoItem();
})

$('#desconto_por_valor').on('keyup', () => {
	$('#desconto_percentual').val(0);
	calcularDescontoItem()
})

$('#valor_frete').on('keyup', () => {
	atualizaTotalCompra()
})

$('#desconto_valor').on('keyup', () => {
	$('#desconto_per').val(0);	
	atualizaTotalCompra()
})

$('#desconto_per').on('keyup', () => {
	$('#desconto_valor').val(0);	
	atualizaTotalCompra()
})

$('#total_seguro').on('keyup', () => {
	atualizaTotalCompra()
})

$('#despesas_outras').on('keyup', () => {
	atualizaTotalCompra()
})

function calcularDescontoItem(){
	let qtde 				= converteMoedaFloat($('#quantidade').val());
	let preco 				= converteMoedaFloat($('#valor').val());
	let subtotal 			= preco * qtde;
	let desconto_por_valor	= converteMoedaFloat($('#desconto_por_valor').val());
	var desconto_percentual = converteMoedaFloat($('#desconto_percentual').val());
	var desconto_por_unidade= parseFloat(0);			
    var subtotal_liquido 	= subtotal;
    var total_desconto_item = 0;
	
	if(desconto_percentual > 0){		
		desconto_por_unidade =  preco * desconto_percentual * 0.01 ;
	}
	
	if(desconto_por_valor > 0){
		desconto_por_unidade = desconto_por_valor;
	}
	
	subtotal_liquido = 	(preco-desconto_por_unidade) * qtde ;		
	total_desconto_item = desconto_por_unidade * qtde;
	
	$('#subtotal_liquido').val(converteFloatMoeda((subtotal_liquido).toFixed(2)));
	$('#total_desconto_item').val(converteFloatMoeda(total_desconto_item.toFixed(2)));	
	$('#subtotal').val(converteFloatMoeda(subtotal.toFixed(2)));
}



	
function atualizaTotalCompra() {
	var valor_frete		= ($('#valor_frete').val() !="") ? converteMoedaFloat($('#valor_frete').val()) : parseFloat(0);	
	var total_seguro 	= ($('#total_seguro').val() !="") ? converteMoedaFloat($('#total_seguro').val()) : parseFloat(0);
	var despesas_outras = ($('#despesas_outras').val() !="") ? converteMoedaFloat($('#despesas_outras').val()) : parseFloat(0);
	var desconto_valor 	= ($('#desconto_valor').val() !="") ? converteMoedaFloat($('#desconto_valor').val()) : parseFloat(0);
	var desconto_per 	= ($('#desconto_per').val() !="") ? converteMoedaFloat($('#desconto_per').val()) : parseFloat(0);
	
	let total_da_orcamento  = converteMoedaFloat($('#valor_total').val())  ;
	
	
	if(desconto_valor!="" && desconto_valor!="0"){
		total_da_orcamento = total_da_orcamento - desconto_valor ;
		desconto_per="";		
	}
	
	if(desconto_per!=""  && desconto_per!="0"){
		total_da_orcamento = total_da_orcamento - (total_da_orcamento * desconto_per * 0.01) ;
		desconto_valor="";		
	}
	TOTAL_ORCAMENTO = parseFloat(total_da_orcamento +  valor_frete + total_seguro + despesas_outras).toFixed(2);
	
	$('#totalorcamento').val(converteFloatMoeda(TOTAL_ORCAMENTO));
	$("#valor_parcela").val(converteFloatMoeda(TOTAL_ORCAMENTO));
	
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

function selecionarVendedorVenda(obj){
	var id					= $(obj).attr('data-vendedor_id');
	var nome				= $(obj).attr('data-nome');	
	
	$(".listaVendedor").hide();
	$("#vendedor_id").val(id);
	$("#desc_vendedor").val(nome);	
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

$('#addProd').click(() => {
	let orcamento_id 	= $('#orcamento_id').val();
	let produto_id 		= $('#produto_id').val();
	let nome 		= $('#desc_produto').val();
	let quantidade  = converteMoedaFloat($('#quantidade').val());
	let valor 		= converteMoedaFloat($('#valor').val());
	let unidade		= $('#unidade_orcamento').val();
	let desconto	= converteMoedaFloat($('#desconto').val());
	let desconto_item	= converteMoedaFloat($('#desconto_item').val());

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
	
		   
	$.ajax({
         url: base_url + "admin/itemorcamento" ,
         type: "POST", 
         data: {
			orcamento_id		: orcamento_id,
			produto_id 		: produto_id,
			quantidade  	: quantidade,
			valor 			: valor,
			unidade			: unidade,
			desconto		: desconto,
			desconto_item	: desconto_item
	
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
	$('#unidade_orcamento').val('');
	$("#desc_produto").focus();
	$("#total_item").val('0');
	
}

function abrirModalFinalizarOrcamento(){
	abrirModal("#modal_finalizar_orcamento");
}
function finalizarOrcamento(id) {
	var cliente_id 		= $("#cliente_id").val();	
	var vendedor_id 	= $("#vendedor_id").val();
	
	
	$.ajax
	({
		type: 'POST',
		data: {
			"id" : id,
			"cliente_id"	: cliente_id,
			"vendedor_id"  : vendedor_id
			
		},
		url: base_url + 'admin/orcamento/finalizarOrcamento' ,
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
         url: base_url + "admin/orcamento/atualizarDadosPagamentos",
         type: "post",
         dataType:"Json",
         data:{
        	 orcamento_id     		: id ,
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
	var orcamento_id 			= $("#orcamento_id").val();
	
    $.ajax({
         url: base_url + "admin/duplicataorcamento/inserir",
         type: "post",
         dataType:"Json",
         data:{
        	 orcamento_id     	: orcamento_id ,
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
         url: base_url + "admin/duplicataorcamento/salvarAlteracao",
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
       url: base_url + "admin/duplicataorcamento/excluir/" + id ,
       type: "GET",
       data: {  },
       dataType:"Json",
       success: function(data){
			//location.reload();
			fecharGiraGira();
			location.reload();
			//window.location.href = base_url + "admin/notafiscal/edit/" + orcamento_id +"#tab-7" ;
    	  
       },
         beforeSend: function(){           
             giraGira(); 
        }
       
   });
}

