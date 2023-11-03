var FATURA 		= [];
var TOTAL 		= parseFloat(0);
var TOTAL_VENDA = parseFloat(0);
var TOTAL_FATURA= parseFloat(0);

var TOTAL_DESCONTO_ITENS= parseFloat(0.0);

var PRODUTOS 	= [];
var unidades 	= [];

$(function () {
	
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

 function selecionarClienteVenda(obj){
	var id					= $(obj).attr('data-cliente_id');
	var nome				= $(obj).attr('data-nome_razao_social');	
	
	$(".listaClientes").hide();
	$("#cliente_id").val(id);
	$("#desc_cliente").val(nome);	
}

function selecionarProduto(){
	var id = $("#produto_recorrente_id").val();
	if(id!=""){
		$.ajax({
		   url: base_url + "admin/produtorecorrente/buscaPorId",
		   type: "GET",
		   dataType: "json",
		   data: {id:id},
		   success: function (data){
            	$("#valor").val(data.valor);
            	$("#subtotal").val(data.valor);
            	$("#quantidade").val(1);
            	$("#total_item").val(converteFloatMoeda(data.valor));
            	calcularDescontoItem();
            	$("#valor").focus();
		   }
	   });
	}
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

function calcularDataVencimento(){
	let data_inicio			= $('#data_inicio').val();
	let qtde_recorrencia 	= $('#qtde_recorrencia').val();
	var dias 				= parseInt(30) * parseInt(qtde_recorrencia);
	 
	
	
	if ($("#data_inicio").val()) {		
		let novaData = somarData(data_inicio, dias);
		$('#data_fim').val(novaData);
		
	}
}

function inserirItem(){
	var cliente_id		= $('#cliente_id').val();
	var data_inicio		= $('#data_inicio').val();
	var data_fim		= $('#data_fim').val();
	var	tipo_cobranca_id	= $('#tipo_cobranca_id').val();
	var qtde_recorrencia = $('#qtde_recorrencia').val();
	var	duracao	= $('#duracao').val();
	var	vendedor_id		= $('#vendedor_id').val();
	var	modelo_contrato_id		= $('#modelo_contrato_id').val();
	
	var ITENS 			= [];
	
	ITENS.push({
			produto_recorrente_id: $("#produto_recorrente_id").val(), 
			valor: $("#valor").val(),
			quantidade: $("#quantidade").val(), 			
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
	
	if( (modelo_contrato_id == '--') || (modelo_contrato_id == '') ||(modelo_contrato_id == 'null') ||(modelo_contrato_id == null)) {
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Não foi possível salvar a venda, Selecione um Modelo de Contrato para continuar!"));	
		return false;	
	}
	
	if( (vendedor_id == '--') || (vendedor_id == '') ||(vendedor_id == 'null') ||(vendedor_id == null)) {
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Não foi possível salvar a venda, Selecione um Vendedor para continuar!"));	
		return false;	
	}
	
	if( (data_inicio == '--') || (data_inicio == '') ||(data_inicio == 'null') ||(data_inicio == null) ) {
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Não foi possível salvar a venda, Selecione uma Data de Início continuar!"));	
		return false;	
	}
	
	if( (produto_recorrente_id == '--') || (produto_recorrente_id == '') ||(produto_recorrente_id == 'null') ||(produto_recorrente_id == null) ) {
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Não foi possível salvar a venda, Selecione um produto para continuar!"));	
		return false;	
	}
	
	if( (valor == '--') || (valor == '') ||(valor == 'null') ||(valor == null) ) {
		fecharModal();
		$("#mostrarUmErro").html(MostrarUmaMsgErro("Não foi possível salvar a venda, Selecione um Valor para continuar!"));	
		return false;	
	}
	$.ajax({
		url: base_url + "admin/vendarecorrente/salvar",
	   type: "POST",
	   dataType: "json",
	   data:{	
	   		cliente_id 		: cliente_id,
	   		data_inicio 	: data_inicio,
	   		data_fim 		: data_fim,
	   		tipo_cobranca_id: tipo_cobranca_id,
	   		qtde_recorrencia:qtde_recorrencia,
	   		duracao 		: duracao,
	   		vendedor_id 	: vendedor_id,
	   		modelo_contrato_id : modelo_contrato_id,
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
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
		
	});
}

$('#quantidade').on('keyup', () => {	
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


$('#desconto_percentual').on('keyup', () => {
	$('#desconto_por_valor').val(0);
	calcularDescontoItem();
})

$('#desconto_por_valor').on('keyup', () => {
	$('#desconto_percentual').val(0);
	calcularDescontoItem()
})


function atualizaTotal() {	
	$('#total').html(converteFloatMoeda(TOTAL));
	$('#valor_total').val(converteFloatMoeda(TOTAL));
	$('#total_desconto_item').val(converteFloatMoeda(TOTAL_DESCONTO_ITENS));
}