$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});

$(document).ready(function() {
	$('.tecla').bind('keydown', 'f1',function() {
		abrirModal("#telaPesquisaProduto");
		//$("#codigo_produto").focus();
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+1',function() {
		telaDesconto();	
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+2',function() {
		abrirModal("#verTelaSangria");		
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+3',function() {
		abrirModal("#verTelaSuplemento");		
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+c',function() {
		telaCliente();	
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+F',function() {
		abrirModal('#fecharCaixa')	
		return false;
	});
	
	$('.tecla').bind('keydown', 'f2',function() {
		finalizarVenda();
		return false;
	});
	
	$('.tecla').bind('keydown', 'f3',function() {	
		selecionarFormaPagamento(1,"Dinheiro");	
		return false;
	});
	
	$('.tecla').bind('keydown', 'f4',function() {
		selecionarFormaPagamento(17,"Pix");
		return false;
	});
	$('.tecla').bind('keydown', 'f5',function() {
		selecionarFormaPagamento(16,"Transferência");
		return false;
	});
	$('.tecla').bind('keydown', 'f6',function() {
		selecionarFormaPagamento(3,"Cartão Crédito");
		return false;
	});
	
	$('.tecla').bind('keydown', 'f7',function() {
		selecionarFormaPagamento(4,"Cartão Débito");		
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+a',function() {
		habilitarAcrescimo();		
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+d',function() {		
		habilitarDesconto();		
		return false;
	});
	
	$('.tecla').bind('keydown', 'Ctrl+s',function() {
		abrirModal('#sairPdv');				
		return false;
	});
	
	$('.tecla').bind('keydown', 'esc',function() {		
		cancelarVenda();		
		return false;
	});
	
	$('.tecla').bind('keydown', 'f10',function() {		
		salvarVenda();		
		return false;
	});
	
	
	$(document).bind('keydown', 'f1',function() {
		abrirModal("#telaPesquisaProduto");	
		//$("#codigo_produto").focus();
		return false;
	});
	
	$(document).bind('keydown', 'f2',function() {
		finalizarVenda();
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+1',function() {			
		telaDesconto();	
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+2',function() {
		abrirModal("#verTelaSangria");		
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+3',function() {
		abrirModal("#verTelaSuplemento");		
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+c',function() {
		telaCliente();		
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+F',function() {
		abrirModal('#fecharCaixa')	
		return false;
	});
	
	$(document).bind('keydown', 'f3',function() {	
		selecionarFormaPagamento(1,"Dinheiro");	
		return false;
	});
	
	$(document).bind('keydown', 'f4',function() {
		selecionarFormaPagamento(17,"Pix");
		return false;
	});
	$(document).bind('keydown', 'f5',function() {
		selecionarFormaPagamento(16,"Transferência");
		return false;
	});
	$(document).bind('keydown', 'f6',function() {
		selecionarFormaPagamento(3,"Cartão Crédito");
		return false;
	});
	$(document).bind('keydown', 'f7',function() {
		selecionarFormaPagamento(4,"Cartão Débito");		
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+a',function() {
		habilitarAcrescimo();		
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+d',function() {		
		habilitarDesconto();		
		return false;
	});
	
	$(document).bind('keydown', 'Ctrl+s',function() {
		abrirModal("#sairPdv");		
		return false;
	});
		
	$(document).bind('keydown', 'esc',function() {		
		cancelarVenda();		
		return false;
	});
	
	$(document).bind('keydown', 'f10',function() {		
		salvarVenda();		
		return false;
	});
	
	$("#codigo_produto").on("keydown", function(event){
		var q = $(this).val();
		if(event.keyCode==13){
			$.ajax({
				url: base_url + "produtoPorCodigo/" + q,
				type: "get",
				data: {},
				dataType:"json",
				success: function(data){
					fecharModal();					
					if(data.tem_erro == true){		
						$("#imagem").attr("src", base_url_imagem + "assets/pdv/img/naoencontrado.png");
					}else{
						if(data.retorno.imagem == null){
							$("#imagem").attr("src", base_url_imagem + "assets/pdv/img/semimagem.jpg");	
						}else{
							$("#imagem").attr("src", base_url_imagem + data.retorno.imagem);
						}		
						
						$("#preco").val(data.retorno.valor_venda);
						$("#id_produto").val(data.retorno.id);
						$("#qtde").val(1);
						$("#subtotal").val(data.retorno.valor_venda );
						$("#descricao").html(data.retorno.nome);
						$("#qtde").focus();
					}					
				},
				  beforeSend: function () {
					giraGira();
			     }
			})
		}
	});
	
	$("#qtde").on("keydown", function(event){
		if(event.keyCode==13){
			var produto_id 	= $("#id_produto").val();
			var nome 		= $("#descricao").html();						
			var qtde 		= $("#qtde").val();
			var preco 		= $("#preco").val();
			if(produto_id == ""){
				alert("Selecione primeiramente um produto");
				return;
			}			
			AdicionarItemNaLista(produto_id, nome, qtde, preco)
		}
	});
	
	$("#valor_pago").on("keydown", function(event){
		if(event.keyCode==13){
			inserirPagamento();
		}
	});
	


});



