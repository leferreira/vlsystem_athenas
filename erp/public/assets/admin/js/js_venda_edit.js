var ITENS 		= [];
var FATURA 		= [];
var TOTAL_FATURA= parseFloat(0);
var TOTAL_DESCONTO_ITENS= parseFloat(0.0);
var unidades 	= [];
var item_venda_id = null;

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
				var estoque = data[i].estoque !=null ? data[i].estoque.quantidade : 0;
				var estoque_grade = data[i].estoque !=null ? data[i].estoque.qtde_grade : 0;
				
				   html +=	'<li><a href="javascript:;" onclick="selecionarProdutoVenda(this)" ' +	
				   		  	'data-id="'+data[i].id +
				   		  	'" data-preco = "' + data[i].valor_venda +
				   		  	'" data-nome  = "' + data[i].nome + 
				   		  	'" data-usaGrade  = "' + data[i].usa_grade +
				   		  	'" data-estoque  	= "' + estoque +
				   		  	'" data-estoqueGrade  = "' + estoque_grade +
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




function inserirItem(){

	var cliente_id		= $('#cliente_id').val();
	var	vendedor_id		= $('#vendedor_id').val();
	var	tabela_preco_id	= $('#tabela_preco_id').val();
	var ITENS 			= [];
	
	ITENS.push({
			venda_id: $("#venda_id").val(), 
			produto_id: $("#produto_id").val(), 
			quantidade: $("#quantidade").val(), 
			unidade: $("#unidade_venda").val(), 
			valor: $("#preco").val(),
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
		url: base_url + "admin/itemvenda",
	   type: "POST",
	   dataType: "json",
	   data:{	
	   		cliente_id 		: cliente_id,
	   		vendedor_id 	: vendedor_id,
	   		tabela_preco_id : tabela_preco_id,
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



function percorrerTabela(){
	var id = "";
	var retorno = [];  
	SOMA_QTDE = 0.0;
	$("#lista_grade_produto tr").each(function(){
		let grade 		= new Object();
		id 				= $(this).find("td:eq(0)").attr("id");		
		grade.id 		= id;
		grade.estoque 	= $("#estoque_"+id).val();
		grade.qtde 		= $("#valor_"+id).val();
		retorno.push(grade);          
	});
	
   return retorno;
   
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


		
function atualizaTotalCompra() {
	var valor_frete		= ($('#valor_frete').val() !="") ? converteMoedaFloat($('#valor_frete').val()) : parseFloat(0);	
	var total_seguro 	= ($('#total_seguro').val() !="") ? converteMoedaFloat($('#total_seguro').val()) : parseFloat(0);
	var despesas_outras = ($('#despesas_outras').val() !="") ? converteMoedaFloat($('#despesas_outras').val()) : parseFloat(0);
	var desconto_valor 	= ($('#desconto_valor').val() !="") ? converteMoedaFloat($('#desconto_valor').val()) : parseFloat(0);
	var desconto_per 	= ($('#desconto_per').val() !="") ? converteMoedaFloat($('#desconto_per').val()) : parseFloat(0);
	
	let total_da_venda  = converteMoedaFloat($('#valor_venda').val())  ;
	
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
	var usa_grade			= $(obj).attr('data-usaGrade');
	var estoque				= $(obj).attr('data-estoque');
	var estoque_grade		= $(obj).attr('data-estoqueGrade')!="null" ? $(obj).attr('data-estoqueGrade') : 0;
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
	$("#usa_grade").val(usa_grade);
	$("#estoque").val(estoque);
	$("#estoque_grade").val(estoque_grade);
	$("#subtotal").val(preco);	
	$("#quantidade").val(1);
	$("#total_item").val(converteFloatMoeda(preco));
	calcularDescontoItem();
	$("#valor").focus();	
}



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
	var cliente_id 		= $("#cliente_id").val();	
	var vendedor_id 	= $("#vendedor_id").val();
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
			"cliente_id"	: cliente_id,
			"vendedor_id"  : vendedor_id,
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

