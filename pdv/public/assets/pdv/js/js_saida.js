
$(function(){
	 $("#btnInserir").on("click", function(){
		var id_produto 	= $("#id_produto").val();
		var qtde 		= $("#qtde").val();
		var preco 		= $("#preco").val();
	
	  
	   $.ajax({
		  url: base_url + "saida/inserir/" ,
		  type: "POST",
		  dataType: "json",
		  data:{
			id_produto 	: id_produto,
			qtde		:qtde,
			preco		:preco
		 },
		  success: function (data){
			console.log(data);
			if(data.erro > 0 ){
				alert(data.msg.msg);
			}
			  lista_saidas(data.lista);
		      limpar();
		  }
	   });	   
	   
   }) ;

	
   $("#produto").on("keyup", function(){
	   var q  = $(this).val();
	   if(q ==""){
		   $(".listaProdutos").hide();
		   return;
	   }
	   $.ajax({
		  url: base_url + "produto/pesquisar/" + q,
		  type: "GET",
		  dataType: "json",
		  data:{},
		  success: function (data){
			  $("#produto").after('<div class="listaProdutos"></div>');		       
			   html = "";			   
				for (i = 0; i < data.length; i++) {		  
				  html +='<div class="si"><a href="javascript:;" onclick="selecionarProduto(this)"'
				  + 'data-id="' + data[i].id_produto +
				   '" data-preco="' + data[i].preco  +
				   '" data-nome="' + data[i].produto + '">' +
				   data[i].produto + " - R$ " + data[i].preco + '</a></div>';				  
				}
				$(".listaProdutos").html(html);
		        $(".listaProdutos").show();
			  
		  }
	   });	   
	   
   }) ;
});

function selecionarProduto(obj){
	var id= $(obj).attr("data-id");
	var nome= $(obj).attr("data-nome");
	var preco= $(obj).attr("data-preco");
	
	$(".listaProdutos").hide();
	$("#produto").val(nome);
	$("#preco").val(preco);
	$("#qtde").val(1);
	$("#qtde").focus();
	$("#id_produto").val(id);	
}

function lista_saidas(data){
	html = "<tr>";
    var total_saida = 0.00;
    for(var i in data){ 
        total_saida += parseFloat(data[i].subtotal_saida);
        var j = parseInt(i)+1;
        html += '<td align="center">' + data[i].id_saida  + '</td>' + 	
        	'<td align="center">' + formatarData(data[i].data_saida) + '</td>' + 
            '<td align="left">'   + data[i].produto + '</td>' + 
            '<td align="center">' + data[i].qtde_saida + '</td>' + 
            '<td align="center">' + data[i].valor_saida + '</td>' + 
            '<td align="center">' + data[i].subtotal_saida + '</td></tr>';
     }
     html += '<tr><td align="right" colspan="6"><b>Total:</b><span class="text-verde minimo-font" id="total_saida">  R$ '+ total_saida + '</span></td> </tr>';
	$("#lista_saidas").html(html);

}

function limpar(){
	$("#produto").val("");
	$("#preco").val("");
	$("#qtde").val(1);
	$("#produto").focus();
	$("#id_produto").val("");
	
}

function formatarData(dat){
		var data = new Date(dat);
        var dia  = (data.getDate()+1).toString();
        var diaF = (dia.length == 1) ? '0' + dia : dia;

        var mes  = (data.getMonth()+1).toString(); //+1 pois no getMonth() Janeiro começa com zero.
        var mesF = (mes.length == 1) ? '0' + mes : mes;
        var anoF = data.getFullYear();
	return diaF + "/" + mesF + "/" + anoF ;

}
