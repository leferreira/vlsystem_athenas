//VENDA PDV


$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});


$(document).ready(function() {	
	
	$("#codigo_produto").on("keydown", function(event){
		var q = $(this).val();
		var tipo 	= "codigo"; 	
		if(BUSCA_PELO_PRODUTO==true){
			inserirItem();
			return;
		} 	
		if(q!=""){
			if(event.keyCode==13){
				tipo 	= $("input[name='tipo_pesquisa']:checked").val();			
				$.ajax({
					url: base_url + "buscaProduto/" + q + "/" + tipo ,
					type: "get",
					data: {},
					dataType:"json",
					success: function(data){										
						if(data.tem_erro == true){									
							$("#imagem").attr("src", base_url + "assets/pdv/img/naoencontrado.png");
							alert("produto não encontrado");
						}else{
							if(data.retorno.imagem == null){							
								$("#imagem").attr("src", base_url + "assets/pdv/img/semimagem.jpg");								
							}else{
								$("#imagem").attr("src", base_url_imagem + data.retorno.imagem);
							}	
							
							$("#preco").val(converteFloatMoeda(data.retorno.preco));
							$("#id_produto").val(data.retorno.id);					
							$("#subtotal").val(converteFloatMoeda(data.retorno.preco) );
							$("#descricao").html(data.retorno.nome);						
							inserirItem(0);
								
						}					
					},
					  beforeSend: function () {
						$("#codigo_produto").blur();
						$(".suspenso").css("display", "flex" );
				     }
				})
			}
			}
	});
	
	

	
});


function resgatar(plataforma, codigo){

	$.ajax({
		type: 'POST',
		data: {
			id				: codigo,
			plataforma		: plataforma
		},
		url: base_url + 'resgate/enviarParaCaixa',
		dataType: 'json',
		beforeSend: function (){
	   },
		success: function (e) {
			if(e.tem_erro==true){
				alert('Não foi encontrado');
				$("#data").html("");
				$("#total").html("");
				listaItens("");
			}else{
				location.href = base_url + "pdv/pagamento/" + e.retorno.id;
			}
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
}

function buscar(){
	var codigo 				= $("#codigo").val();
	var plataforma			= $("#plataforma").val();	

	$.ajax({
		type: 'POST',
		data: {
			codigo				: codigo,
			plataforma			: plataforma
		},
		url: base_url + 'resgate/resgatar',
		dataType: 'json',
		beforeSend: function (){
	   },
		success: function (e) {
			if(e.tem_erro==true){
				alert('Não foi encontrado');
				$("#data").html("");
				$("#total").html("");
				listaItens("");
			}else{
				$("#data").html(e.retorno.cabecalho.data);
				$("#total").html(e.retorno.cabecalho.total);
				listaItens(e.retorno.produtos);
			}
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
}

function gerarLinkDoCaixa(uuid){
	var link_unico  = link_loja + 'vendapdv/vercarrinho/' + uuid;
	var link_modelo = link_loja + 'vendapdv/modelo/' + uuid;
	$("#link_unico").val(link_unico);
	$("#link_modelo").val(link_modelo);
	
	abrirModal('#verTelaResgate');
}

function gerarLinkDaLoja(uuid){
	var link_unico  = link_loja + 'carrinho/retornar/' + uuid;
	var link_modelo = link_loja + 'carrinho/modelo/' + uuid;
	$("#link_unico").val(link_unico);
	$("#link_modelo").val(link_modelo);
	
	abrirModal('#verTelaResgate');
}

function listaItens(itens) {
	html = '<tr>';
	for(var i in itens){	
		html += "<tr class='datatable-row' style='left: 0px;'>";
		html += "<td class='datatable-cell cod'><span class='codigo' style='width: 60px;'>" + itens[i].produto_id + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + itens[i].produto + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + converteFloatMoeda(itens[i].qtde) + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(itens[i].valor) + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(itens[i].subtotal) + "</span></td>";
		html += "</tr>";
	}	
	$("#listaVendasParaResgate").html(html);
}