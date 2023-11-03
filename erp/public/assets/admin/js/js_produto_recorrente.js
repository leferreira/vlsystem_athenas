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
				   html +=	'<li><a href="javascript:;" onclick="selecionarServico(this)" ' +	
				   		  	'data-id="'+data[i].id +
				   		  	'" data-preco = "' + data[i].valor_venda +
				   		  	'" data-nome  = "' + data[i].nome +  
							'" data-unidade = "' + data[i].unidade + '">' +
				   		  data[i].nome + " - RS " + data[i].valor_venda + '</a></li>' 
				  
			   }
			   
			   $(".listaServicos").html(html);
			   $(".listaServicos").show();
		   }
	   });
   })
});


function selecionarProdutoVenda(obj){
	var id					= $(obj).attr('data-id');
	var nome				= $(obj).attr('data-nome');
	var preco				= $(obj).attr('data-preco');	
		
	$(".listaProdutos").hide();	
	$("#produto_id").val(id);
	$("#desc_produto").val(nome);
	$("#valor").val(preco);
	$("#subtotal").val(preco);	
	$("#quantidade").val(1);
		
}

function selecionarServico(obj){
	var id					= $(obj).attr('data-id');
	var nome				= $(obj).attr('data-nome');	
		
	$(".listaServicos").hide();	
	$("#servico_id").val(id);
	$("#desc_servico").val(nome);		
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




