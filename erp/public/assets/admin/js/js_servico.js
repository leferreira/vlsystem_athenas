var eh_modal = 0;
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});

$(function () {

	
});

function mostrarUnidade(){
	var unidade = $('#unidade :selected').text();
	$("#txt_unidade").html(unidade);
}

function calcularPreco(){
	//var margem_lucro 		= converteMoedaFloat($('#margem_lucro').val());
	var valor_venda  		= converteMoedaFloat($('#valor_venda').val());
	var valor_custo  		= converteMoedaFloat($('#valor_custo').val());	
	//var margem_lucro  		= valor_custo * (1 + margem_lucro * 0.01);
	var liquido 			= valor_venda - valor_custo;
	var margem_lucro  		= liquido / valor_venda * 100;	
	
	$('#margem_lucro').val(formatarFloat(margem_lucro));
	
}



function salvarServico(){ 
		eh_modal = 1;       
        $.ajax({
         url: base_url + "admin/servico/salvarJs",
         type: "POST",
         data:$("#frmCadServico").serialize(),
         dataType:"Json",
         success: function(data){			
			if(data.tem_erro ==true){
				fecharGiraGira(eh_modal);
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				fecharModal();
				$("#mostrarUmErro").html(MostrarUmaMsgSucesso(" Registro Inserido com Sucesso"));
			}             
         },
		  beforeSend: function () {
			giraGira();
	     },error: function (data) {
			fecharGiraGira(eh_modal);
			if(data.status== 422){
				var errors = $.parseJSON(data.responseText);
				$('#listaErroModal').html('');					
	        	$.each(errors.errors, function (key, erro) {					 
					 $('#listaErroModal').append('<li>' + erro + '</li>');
					 abrirModalLivre("#modalLivreListaComErros");
	        	});
			}else{
				
			}	        
		}        
     })
}

function inserirServicoTributacao(){
	$.ajax({
		url: base_url + "admin/tributacaoservico",
	   type: "POST",
	   dataType: "json",
	   data:{
			tributacao_id: $("#tributacao_id").val(),
			servico_id: $("#servico_id").val(),
		},
		 success: function(data){
			fecharModal();
			if(data.tem_erro ==true){
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{				
			   lista_servico_tributacao(data.retorno);
			}
			
		 },
		  beforeSend: function () {
			giraGira();
	     },error: function (data) {
			fecharGiraGira(eh_modal);
			if(data.status== 422){
				var errors = $.parseJSON(data.responseText);
				$('#listaErroModal').html('');					
	        	$.each(errors.errors, function (key, erro) {					 
					 $('#listaErroModal').append('<li>' + erro + '</li>');
					 abrirModalLivre("#modalLivreListaComErros");
	        	});
			}else{
				
			}	        
		}			
	});
}
	


function excluirServicoTributacao(id){
       $.ajax({
         url: base_url + "admin/tributacaoservico/"  + id ,
         type: "DELETE",
         data: {  },
         dataType:"Json",
         success: function(data){
             lista_servico_tributacao(data.retorno);
         }
         
     });
}

	
function lista_servico_composicao(data){
	html = "<tr>";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="left">' + data[i].servico_filho.nome + '</td>' + 
		'<td align="left">' + data[i].qtde + '</td>' + 
       	'<td align="center"><a href="javascript:;" onclick="excluirServicoComposicao('+ data[i].id +')"  class="btn btn-outline-vermelho btn-pequeno fas fa-trash" title="Excluir"></a></td></tr>'
	}
	$("#lista_servico_composicao").html(html);
}

