
var base_urlname = window.location.base_urlname;
var soma = 0;
$(function () {
	soma = parseFloat($('#soma_hidden').val())
});
$('.qtd').keyup((e) => {
	let quantidade = e.target.value
	let id = e.target.id
	setQuantidade(id, quantidade)

});

function removeItem(id){
	$.get(base_url+'carrinho/excluir/'+id, 
		function(data) {
			location.reload();
	})
}

function refresh(id){
	
	let qtd = $('#qtd_item_'+id).val()
	$.get(base_url+'carrinho/atualizarItem/'+id+'/'+ qtd, 
		function(data) {
				//console.log(data)
				//location.reload();
			})
}

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
	let base_url = prot + "//" + host + base_urlname;
	$.get(base_url + '/atualizaItem', {id: id, quantidade: quantidade})
	.done((success) => {
	}).fail((err) => {
	})

}
$('#btn-calcular-frete').click(() => {	
	let cep = $('#cep').val();
	
	$('#mostrarGiraGira').css('display', 'block');
	if(cep.length == 9){
		$('.frete').css('display', 'block')
		$('#total').html(formatReal(soma))

		$('#btn-calcular-frete').attr('disabled', true)
		let pedido_id = $('#pedido_id').val()
		$.get(base_url +'carrinho/calculaFrete/', 
		{
			cep: cep,
			pedido_id: pedido_id
		})
		.done((success) => {
			$('.frete').css('display', 'block')
			console.log(success)
			$('#btn-calcular-frete').removeAttr('disabled')
			let html = ''			
			
			if(parseFloat(success.preco_sedex) > 0){
				html = '<div class="radio p-1"><input onclick="setValorFrete(\'sedex\','+parseFloat(success.preco_sedex.replace(",", "."))+')" type="radio" value="'+success.preco_sedex+'" name="tipo_frete" id="sedex">'
				html += '<label style="margin-left: 5px;" for="sedex"> SEDEX R$ '+success.preco_sedex + ' - '+ success.prazo_sedex +' Dias</label></div>'
			}
			if(parseFloat(success.preco) > 0){
				html += '<div class="radio p-1"><input onclick="setValorFrete(\'pac\','+parseFloat(success.preco.replace(",", "."))+')" type="radio" value="'+success.preco+'" name="tipo_frete" id="PAC">'
				html += '<label style="margin-left: 5px;" for="PAC"> PAC R$ '+success.preco + ' - ' + success.prazo +' Dias</label></div>'
			}

			if(success.frete_gratis){
				html += '<div class="radio p-1"><input onclick="setValorFrete(\'gratis\',0)" type="radio" value="0" name="tipo_frete" id="freteGratis">'
				html += '<label style="margin-left: 5px;" for="freteGratis"> FRETE GRATIS '+ ' - ' + success.prazo +' Dias</label></div>'
			}
			$('.frete').html(html)
			$('#mostrarGiraGira').css('display', 'none');

		}).fail((err) => {
			$('.spinner-border').css('display', 'none')
			$('#btn-calcular-frete').removeAttr('disabled')
			$('#mostrarGiraGira').css('display', 'none');

		})
	}else{
		alert("Erro", "Informe um CEP válido", "warning")
		$('#mostrarGiraGira').css('display', 'none');
	}
})

function setarFrete(tipo, valor){
	let pedido_id = $('#pedido_id').val();
	let token = $('#token').val();
	let cep = $('#cep').val();
	$('#tp_frete').val(tipo)
	$.post(prot + "//" + host + '/ecommerceSetaFrete',
	{
		_token: token,
		pedido_id: pedido_id,
		tipo: tipo,
		cep: cep,
		valor: valor
	})
	.done((success) => {
		console.log(success)

	}).fail((err) => {
		console.log(err)
	})
}

function setValorFrete(tipo, valor){
	let total = valor + soma
	$('#total').html(formatReal(total))
	setarFrete(tipo, valor)
}

function formatReal(v){
	return v.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
}
