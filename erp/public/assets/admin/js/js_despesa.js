var ITENS 		= [];
var FATURA 		= [];

var TOTAL_FATURA= parseFloat(0);

var TOTAL_DESCONTO_ITENS= parseFloat(0.0);

var unidades 	= [];

$(function () {
	$("#desc_fornecedor").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return;
	   }

	   $.ajax({
		   url: base_url + "admin/fornecedor/pesquisa",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   $("#desc_fornecedor").after('<ol class="listaFornecedores"></ol>');
			   html="";
			   for(var i in data){
				   html +=	'<li><a href="javascript:;" onclick="selecionarFornecedorCombo(this)" ' +	
				   		  	'data-id="'+data[i].id +
							'" data-nome = "' + data[i].razao_social + '">' +
				   		  	data[i].razao_social + '</a></li>' 
				  
			   }
			   
			   $(".listaFornecedores").html(html);
			   $(".listaFornecedores").show();
		   }
	   });
   })
   
   $("#desc_tipo_despesa").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return;
	   }
	   $.ajax({
		   url: base_url + "admin/tipodespesa/pesquisa",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			console.log(data);
			   $("#desc_tipo_despesa").after('<ol class="listaTipoDespesa"></ol>');
			   html="";
			   for(var i in data){
				   html +=	'<li><a href="javascript:;" onclick="selecionarTipoDespesa(this)" ' +	
				   		  	'data-id="'+data[i].id +
							'" data-nome = "' + data[i].nome + '">' +
				   		  data[i].nome +  '</a></li>' 
				  
			   }
			   
			   $(".listaTipoDespesa").html(html);
			   $(".listaTipoDespesa").show();
		   }
	   });
   })
});


function selecionarFornecedorCombo(obj){
	var id					= $(obj).attr('data-id');
	var nome				= $(obj).attr('data-nome');
		
	$(".listaFornecedores").hide();	
	$("#fornecedor_id").val(id);
	$("#desc_fornecedor").val(nome);
		
}


function selecionarTipoDespesa(obj){
	var id					= $(obj).attr('data-id');
	var nome				= $(obj).attr('data-nome');	
		
	$(".listaTipoDespesa").hide();	
	$("#tipo_despesa_id").val(id);
	$("#desc_tipo_despesa").val(nome);		
}



