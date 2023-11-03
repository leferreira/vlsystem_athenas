var TAMANHOPIZZASELECIONADO = null;
var SABORESESCOLHIDOS = [];
var MAXIMOSABORES = 0;
var ADICIONAISESCOLHIDOS = [];
var TODOSSABORES = [];
var maiorValorPizza = 0;
var DIVISAO_VALOR_PIZZA = 0;
var VALOR_PIZZA= 0;
var PRODUTOS = []
var PRODUTO = null
var ADICIONAIS = []
var PIZZAS = []
var TAMANHOSTEMP = []
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});
var soma = 0;
$(function () {
	
	 $("#nomePesq").on("keyup", function(){
	   var q = $(this).val();
		
	   if(q==""){
		   return;
	   }
	   $.ajax({
		   url: path + "cliente/pesquisaPorNome",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   html="";
			   for(var i in data){
				var url = path + "delivery/balcao/abrirPedido/" + data[i].id + "/edit";
			html +=	'<tr class="bg-branco">' +
					'<td align="center">'+data[i].id+'</td>' +
					'<td align="center">'+data[i].nome+'</td>' + 									  
					'<td align="center">'+data[i].celular+'</td>' + 									  
					'<td align="center">'+data[i].email+'</td>' + 									  
					'<td align="center">'+data[i].referencia+'</td>' + 	
					'<td align="center"><a href="' + url +'">Pedir</a></td>'+
				'</tr>';
			   }
			   
			   $("#lista_clientes").html(html);
		   }
	   });
   })


	soma = parseFloat($('#soma_hidden').val())
});

function addAdicional(adicional){
	var nome ="comp_" + adicional;
	if($('#'+nome).is(':checked')){
		ADICIONAISESCOLHIDOS.push(adicional);
	}else{
		for(var i=0; i< ADICIONAISESCOLHIDOS.length; i++) {
			if(ADICIONAISESCOLHIDOS[i]==adicional){
				ADICIONAISESCOLHIDOS.splice(ADICIONAISESCOLHIDOS.indexOf(adicional), 1);
			}
		}
	}
	somaValor();
	$("#adicioanis_escolhidos").val(ADICIONAISESCOLHIDOS);
}


function selecionarCliente(obj){
	var cliente_id		= $(obj).attr('data-id');
	var nome	= $(obj).attr('data-nome');
	var celular	= $(obj).attr('data-celular');	
	
	$("#cliente_id").val(cliente_id);
	$("#cliente").val(nome);
	$("#celular").val(celular);	
	$(".listaClientes").hide();	
	
}

function maskMoney(v){
	return v.toFixed(2);
}

function addItem(id){
	ADICIONAIS = [];
	ADICIONAISESCOLHIDOS = [];
	$.ajax({
			url: path + "buscarProdutoParaPedido/" + id,
		   type: "get",
		   dataType: "json",
		   data:{},
			 success: function(data){
				PRODUTO = data.produto;
				if(PRODUTO.pizza.length > 0){
					setaTamanhosPizza(p)
				}else{
					$('#valor').val(PRODUTO.produto.valor_venda)
					$('#sabores-pizza').css('display', 'none')
					$('#tamanhos-pizza').css('display', 'none')
					$('#btn-add-sabor').css('display', 'none')	
				}
				
				 $("#nomeProduto").html(data.produto.nome);
				 $("#valorProduto").html(data.produto.valor_venda);
				 $("#produto_id").val(data.produto.id);
			
				var html = "";
				if(data.adicionais.length > 0){					
					for(var i=0; i<data.adicionais.length; i++) {
					html +='<div class="col-4 d-flex">' +
						' <div class="bg-op p-1 width-100 d-block check"><label><b>'+ data.adicionais[i].nome + 
						'</b><input type="checkbox" id="comp_'+data.adicionais[i].id+'" onclick="addAdicional('+data.adicionais[i].id+')"  >' +
						'</label></div></div>';
					}
					
					ADICIONAIS = data.adicionais;
					
				}else{
					html = "Este produto adicionais";
				}
				$('#lista_adicionais').html(html);
				 abrirModal('#add')
			 }
			
		});
}

$('#btn-salvar').click(() => {

$('#formPedido').submit();
/*
	swal({
		title: "Impressão",
		text: "Deseja imprimir o cupom do pedido",
		icon: "warning",
		buttons: ["Não", "Sim"]
	})
	.then((sim) => {
		if(sim){
			$('#imprimir').val('1')
		}else{
			$('#imprimir').val('0')
		}
		$('#formPedido').submit();
	}) */

});


function totalizaAdicional(call){
	let soma = 0;

	ADICIONAISESCOLHIDOS.map((a) => {
		ADICIONAIS.map((ad) => {
			if(ad.id == a){
				soma += parseFloat(ad.valor)
			}
		})
	})
	call(soma)
}

function somaValor(){
	totaliza((res) => {
		totalizaAdicional((resAd) => {
			let quantidade = $('#quantidade').val();			
			console.log(res)
			console.log(resAd)
			
			console.log("setando", maskMoney((res + resAd) * quantidade))
			$('#valor').val(maskMoney((res + resAd) * quantidade))
		})
	})
}

function totaliza(call){

	if(maiorValorPizza){
		let soma = parseFloat(maiorValorPizza);
		console.log(soma)
		SABORESESCOLHIDOS.map((sb) => {
			PIZZAS.map((pz) => {
				if(sb == pz.id){

					pz.pizza.map((pt) => {
						if(pt.tamanho_id == TAMANHO){
							console.log(pt)
							if(DIVISAO_VALOR_PIZZA == 0){
								if(pt.valor > maiorValorPizza){ 
									maiorValorPizza = pt.valor;
								}
							}else{
								soma += parseFloat(pt.valor)
							}
						}
					})
				}
			})
		})

		if(DIVISAO_VALOR_PIZZA == 1){
			console.log(soma)
			let calc = soma/(SABORESESCOLHIDOS.length + 1);
			call(calc)
		}else{
			call(maiorValorPizza)
		}

	}else{
		let valor = 0;
		try{
			valor = parseFloat(PRODUTO.valor)
		}catch{
			valor = parseFloat($('#valor').val())
		}
		call(valor);
	}
}

function salvarItem(id){
	var pedido_id = $("#pedido_id").val();
	$.ajax({
			url: base_url + "entrada",
		   type: "POST",
		   dataType: "json",
		   data:{	
			   		pedido_id		:pedido_id,
			   		produto_id 		: id,
			   		valor_entrada	: preco,
			   		id_localizacao 	: localizacao_id,
			   		subtotal_entrada: qtde * preco
			   	},
			 success: function(data){
				 lista_entradas(data);
				 limpar_entradas();
			 }
			
		});
}
function abrirPedido(){
	var cliente_id		= $("#cliente_id").val();	
	$.post(path + 'abrirPedido', {cliente_id: cliente_id})
	.done((success) => {
		console.log(success)
		location.href = path + 'edit/'+success.id
	})
	.fail((err) => {
		console.log(err)
	})
}




$('.qtd').keyup((e) => {
	let quantidade = e.target.value
	let id = e.target.id
	setQuantidade(id, quantidade)

});


$('.qtd').click((e) => {
	let quantidade = e.target.value
	let id = e.target.id
	setQuantidade(id, quantidade)

});

$('.pro-qty').click((e) => {
	let value = e.currentTarget.childNodes[2]

	let quantidade = value.value
	let id = value.id

	setQuantidade(id, quantidade)

});

function setQuantidade(id, quantidade){
	let path = prot + "//" + host + pathname;
	$.get(path + '/atualizaItem', {id: id, quantidade: quantidade})
	.done((success) => {
	}).fail((err) => {
	})

}


function selecionarEndereco(endereco_id){
	let pedido_id = $('#pedido_id').val();

	$.post(path + 'marcarEnderecoCliente', 
	{
		endereco_id: endereco_id, 
		pedido_id: pedido_id
	})
	.done((success) => {
		location.href = path + 'edit/'+success.id
	})
}

function formatReal(v){
	return v.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
}



