
var base_urlname = window.location.base_urlname;

$(function () {
	soma = parseFloat($('#soma_hidden').val())
});

function selecionarLinha(linha_id){
	
	$(".linha_da_grade").removeClass("ativo");
	$("#linha_"+linha_id).addClass("ativo");
	$("#linha_id").val(linha_id);
}

function selecionarColuna(coluna_id){
	
	$(".coluna_da_grade").removeClass("ativo");
	$("#coluna_"+coluna_id).addClass("ativo");
	$("#coluna_id").val(coluna_id);
	
}

function adicionarCarrinho(){
	var usa_grade = $("#usa_grade").val();
	if(usa_grade =="S"){
		var linha_id = $("#linha_id").val();
		var coluna_id = $("#coluna_id").val();
		var variacao_linha = $("#variacao_linha").val();
		var variacao_coluna = $("#variacao_coluna").val();
		if(linha_id == "0"){
			alert("Selecione " + variacao_linha + " primeiramente");
			return false;
		}
		
		if(coluna_id == "0"){
			alert("Selecione " + variacao_coluna + " primeiramente");
			return false;
		}
	}
	$("#frmCarrinho").submit();
}


