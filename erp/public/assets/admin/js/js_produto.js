var eh_modal = 0;
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});

$(function () {		
	$("#desc_categoria").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return;
	   }
	   $.ajax({
		   url: base_url + "admin/categoria/pesquisa",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   $("#desc_categoria").after('<ol class="listaCategorias"></ol>');
			   html="";
			   for(var i in data){
				   html +=	'<li><a href="javascript:;" onclick="selecionarCategoriaCombro(this)" ' +	
				   		  	'data-id="'+data[i].id +
							'" data-categoria = "' + data[i].categoria + '">' +
				   		  data[i].categoria +  '</a></li>' 
				  
			   }
			   
			   $(".listaCategorias").html(html);
			   $(".listaCategorias").show();
		   }
	   });
   })
	
});

function selecionarCategoriaCombro(obj){
	var id		= $(obj).attr('data-id');
	var nome	= $(obj).attr('data-categoria');	
	
	$.ajax({
         url: base_url + "admin/categoria/selecionarCategoria/"  + id ,
         type: "GET",
         data: {  },
         dataType:"Json",
         success: function(data){
			 console.log(data);
             $(".listaCategorias").hide();
			 $("#categoria_id").val(id);
			 $("#desc_categoria").val(nome);
			 
			 html = "<option value=''>selecione</option>";
			  for (i = 0; i < data.subcategorias.length; i++) {	
				  html +="<option value='"+ data.subcategorias[i].id +"'>" + data.subcategorias[i].subcategoria + "</option>";
			  }
			 $("#subcategoria_id").html(html);
			 
			 html2 = "<option value=''>selecione</option>";
			  for (i = 0; i < data.subsubcategorias.length; i++) {	
				  html2 +="<option value='"+ data.subsubcategorias[i].id +"'>" + data.subsubcategorias[i].subsubcategoria + "</option>";
			  }
			 $("#subsubcategoria_id").html(html2);
         }
         
     });
}

function mostrarUnidade(){
	var unidade = $('#unidade :selected').text();
	$("#txt_unidade").html(unidade);
}

function calcularPreco(){
	var margem_lucro 		= converteMoedaFloat($('#margem_lucro').val());
	var valor_custo  		= converteMoedaFloat($('#valor_custo').val());	
	var preco_venda  		= valor_custo/(1-margem_lucro * 0.01);
	
	$('#valor_venda').val(converteFloatMoeda(preco_venda.toFixed(2)));
	
}

function calcularMargem(){
	var valor_venda  		= converteMoedaFloat($('#valor_venda').val());
	var valor_custo  		= converteMoedaFloat($('#valor_custo').val());	
	
	var margem_lucro  		= ((valor_venda - valor_custo)/valor_venda) * 100 ;	
	
	$('#margem_lucro').val(converteFloatMoeda(margem_lucro.toFixed(2)));
	
}

function salvarProduto(){ 
		eh_modal = 1;       
        $.ajax({
         url: base_url + "admin/produto/salvarJs",
         type: "POST",
         data:$("#frmCadProduto").serialize(),
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

function inserirProdutoTributacao(){
	$.ajax({
		url: base_url + "admin/tributacaoproduto",
	   type: "POST",
	   dataType: "json",
	   data:{
			tributacao_id: $("#tributacao_id").val(),
			produto_id: $("#produto_id").val(),
		},
		 success: function(data){
			fecharModal();
			if(data.tem_erro ==true){
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{				
			   lista_produto_tributacao(data.retorno);
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
function gerarBarras(){
	var barras = Math.floor(Math.random() * 10000000000000);
	$("#codigo_barra").val(barras);
}	
function lista_produto_tributacao(data){
	html = "<tr>";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="left">' + data[i].cfop + '</td>' + 
		'<td align="left">' + data[i].descricao + '</td>' + 
		'<td align="left">' + data[i].cstICMS + '</td>' + 
		'<td align="left">' + data[i].cstIPI + '</td>' + 
		'<td align="left">' + data[i].cstPIS + '</td>' + 
		'<td align="left">' + data[i].cstCOFINS + '</td>' + 
       	'<td align="center"><a href="javascript:;" onclick="excluirProdutoTributacao('+ data[i].id +')"  class="btn btn-outline-vermelho btn-pequeno fas fa-trash" title="Excluir"></a></td></tr>'
	}
	$("#lista_produto_tributacao").html(html);
}

function excluirProdutoTributacao(id){
       $.ajax({
         url: base_url + "admin/tributacaoproduto/"  + id ,
         type: "DELETE",
         data: {  },
         dataType:"Json",
         success: function(data){
             lista_produto_tributacao(data.retorno);
         }
         
     });
}


function inserirProdutoComposicao(){
	$.ajax({
		url: base_url + "admin/composicaoproduto",
	   type: "POST",
	   dataType: "json",
	   data:{
			produto_pai_id: $("#produto_pai_id").val(),
			produto_filho_id: $("#produto_filho_id").val(),
			qtde: $("#qtde").val(),
		},
		 success: function(data){
			fecharModal();
			if(data.tem_erro ==true){
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{				
			   lista_produto_composicao(data.retorno);
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
	
function lista_produto_composicao(data){
	html = "<tr>";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="left">' + data[i].produto_filho.nome + '</td>' + 
		'<td align="left">' + data[i].qtde + '</td>' + 
       	'<td align="center"><a href="javascript:;" onclick="excluirProdutoComposicao('+ data[i].id +')"  class="btn btn-outline-vermelho btn-pequeno fas fa-trash" title="Excluir"></a></td></tr>'
	}
	$("#lista_produto_composicao").html(html);
}

function excluirProdutoComposicao(id){
       $.ajax({
         url: base_url + "admin/composicaoproduto/"  + id ,
         type: "DELETE",
         data: {  },
         dataType:"Json",
         success: function(data){
             lista_produto_composicao(data.retorno);
         }
         
     });
}



function inserirProdutoSemelhante(){
	$.ajax({
		url: base_url + "admin/produtosemelhante",
	   type: "POST",
	   dataType: "json",
	   data:{
			produto_principal_id: $("#produto_principal_id").val(),
			produto_semelhante_id: $("#produto_semelhante_id").val(),			
		},
		 success: function(data){
			fecharModal();
			if(data.tem_erro ==true){
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{				
			   lista_produto_semelhante(data.retorno);
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
	
function lista_produto_semelhante(data){
	html = "<tr>";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="left">' + data[i].produto_semelhante.nome + '</td>' + 
       	'<td align="center"><a href="javascript:;" onclick="excluirProdutoSemelhante('+ data[i].id +')"  class="btn btn-outline-vermelho btn-pequeno fas fa-trash" title="Excluir"></a></td></tr>'
	}
	$("#lista_produto_semelhante").html(html);
}

function excluirProdutoSemelhante(id){
       $.ajax({
         url: base_url + "admin/produtosemelhante/"  + id ,
         type: "DELETE",
         data: {  },
         dataType:"Json",
         success: function(data){
             lista_produto_semelhante(data.retorno);
         }
         
     });
}


function gerarGrade(){
	$.ajax({
		url: base_url + "admin/grade/gerar",
	   type: "POST",
	   dataType: "json",
	   data:{
			produto_principal_id: $("#produto_principal_id").val(),
			linhas: $("input[type=text][name=linhas]").val() ,	
			colunas:$("input[type=text][name=colunas]").val() ,		
		},
		 success: function(data){
			fecharModal();
			if(data.tem_erro ==true){
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{				
			   lista_produto_semelhante(data.retorno);
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
	
function lista_grade(data){
	html = "<tr>";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="left">' + data[i].produto_semelhante.nome + '</td>' + 
       	'<td align="center"><a href="javascript:;" onclick="excluirProdutoSemelhante('+ data[i].id +')"  class="btn btn-outline-vermelho btn-pequeno fas fa-trash" title="Excluir"></a></td></tr>'
	}
	$("#lista_produto_semelhante").html(html);
}

function excluirGrade(id){	
       $.ajax({
         url: base_url + "admin/grade/"  + id ,
         type: "DELETE",
         data: {  },
         dataType:"Json",
         success: function(data){
             location.reload();
         }
         
     });
}

function upload_produto(){
	var data 	 	= new FormData();	
	var arquivos 	= $('#img_loja_produto')[0].files;
	var produto_id 	= $('#produto_id').val();

	if(arquivos.length > 0) {		
		data.append('file', arquivos[0]);
		data.append('produto_id', produto_id);
		
		$.ajax({
			type:'POST',
			url:base_url + 'admin/lojaimagemproduto',
			data:data,
			contentType:false,
			processData:false,
			dataType: "json",
			beforeSend: function(){
				$('#uploadStatus').html('<img src=' + base_url + '"assets/img/loading.gif"/>');
			},
            error:function(){
                alert("erro");
            },
			success:function(data){	
				lista_imagem(data);
			}
		});
	}
}

function excluirImagem(id){	
       $.ajax({
         url: base_url + "admin/lojaimagemproduto/"  + id ,
         type: "DELETE",
         data: {  },
         dataType:"Json",
         success: function(data){
             lista_imagem(data.retorno);
         }
         
     });
}

function lista_imagem(data){
	html="";
	for(var i in data){
	var path = base_url +  data[i].img;	   
	html +='<div class="col-2 d-flex mb-3">'+
		'<div class="banner-thumb radius-4 p-2 border" style="background:#fff">'+
			'<img src="' + path + '" class="img-fluido">'+
			'<a href="javascript:;" onclick="excluirImagem(' + data[i].id + ')" class="btn btn-vermelho btn-circulo"><i class="fas fa-times"></i></a>' +
		'</div>'+
	'</div>';
	}
			   
   $("#lista_imagens").html(html);
}




function inserirTabelaPreco(){
	var valor			= $("#preco").val();
	if(preco==""){
		alert("Digite o valor do Preço primeiramente");
		return false;
	}
	$.ajax({
		url: base_url + "admin/tabelaprecoproduto",
	   type: "POST",
	   dataType: "json",
	   data:{
			tabela_preco_id : $("#tabela_preco_id").val(),
			produto_id		: $("#produto_id").val(),
			valor			: valor,	
			data_atualizacao: $("#data_atualizacao").val(),		
		},
		 success: function(data){
			fecharModal();
			if(data.tem_erro ==true){
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{				
			   lista_tabela_preco(data.retorno);
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
	
function lista_tabela_preco(data){
	var html = "";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="left">' + data[i].tabela_preco.nome + '</td>' + 
        '<td align="left">' + data[i].valor + '</td>' +
        '<td align="left">' + data[i].data_atualizacao + '</td>' +
       	'<td align="center"><a href="javascript:;" onclick="excluirTabelaPreco('+ data[i].id +')"  class="btn btn-outline-vermelho btn-pequeno fas fa-trash" title="Excluir"></a></td></tr>'
	}
	$("#lista_tabela_preco").html(html);
}

function excluirTabelaPreco(id){
       $.ajax({
         url: base_url + "admin/tabelaprecoproduto/"  + id ,
         type: "DELETE",
         data: {  },
         dataType:"Json",
         success: function(data){
             lista_tabela_preco(data.retorno);
         }
         
     });
}

function salvarLocalizacao(){
	var localizacao 	= $("#localizacao").val();	
	
	if(localizacao!=""){
		$.ajax({
         url: base_url + "admin/localizacao/salvarJs",
         type: "post",
         dataType:"Json",
         data:{
         	localizacao: localizacao,
         },
         success: function(data){   
	       	        	  
			if(data.tem_erro ==true){
					fecharGiraGira(eh_modal);
					$("#erroModalLivre").html(data.erro);
					abrirModalLivre("#modalLivreErro");				
				}else{
					$("#mostrarSucesso").html(MostrarUmaMsgSucesso("Salvo com sucesso, aguarde..."));
				     fecharGiraGira(eh_modal);
					 fecharModalLivre();
					 html = "<option value=''>selecione</option>";
					  for (i = 0; i < data.retorno.length; i++) {	
						  html +="<option value='"+ data.retorno[i].id +"'>" + data.retorno[i].localizacao + "</option>";
					  }			 
					  $("#localizacao_id").html(html);
					  $("#localizacao").val("");
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
	
	
}
