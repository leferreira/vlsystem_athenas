
$(function(){
	$("#nomeProduto").on("keyup", function(){
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
				listarProdutoDoModal(data);
		   }
	   });
   })
});

function abrirModalBuscarProduto(id){
	$("#item_nota_id").val(id);
	abrirModal("#modalBuscarProduto");
}

function listarProdutoDoModal(data){
	html = "<tr>";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="left">' + data[i].nome + '</td>' + 
       	'<td align="center"><a href="javascript:;" onclick="vincularProduto('+ data[i].id +')" >Vincular</a></td></tr>'
	};
	
	$("#lista_produto_disponivel").html(html);
}

function vincularProduto(id_produto){
	var item_nota_id =  $("#item_nota_id").val();
	$.ajax({
         url: base_url + "admin/notafiscal/vincularProduto/" + id_produto + "/" + item_nota_id,
         type: "get",
         dataType:"Json",
         data:{},
         success: function(data){
			if(data.tem_erro == true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{
				location.reload();
			}		
         },
         beforeSend: function(){ 
	  		giraGira();
         }
         
     });
}

function abrirFormulario(id){
	$.ajax({
         url: base_url + "admin/nfetemp/buscar/" + id,
         type: "get",
         dataType:"Json",
         data:{},
         success: function(data){
			mostrarDados(data);			
            abrirModal("#formulario");
         },
         beforeSend: function(){ 
			//location.reload();  
        }         
     });
}

function mostrarDados(data){
	//var uCom 	= data.uCom;	
	$("#unidade").val( $('option:contains('+data.uCom+')').val() );
	$("#nfe_item_temp_id").val(data.id);
	$("#txt_unidade").html($("#unidade").val());
	$("#nome").val(data.xProd);
	$("#ncm").val(data.NCM);
	$("#gtin").val(data.cEAN);
	$("#ncm").val(data.NCM);
	$("#valor_venda").val(0);
	$("#margem_lucro").val(0);
	$("#valor_custo").val(data.vUnCom);
	$("#estoque_inicial").val(data.qCom)
}



function calcularPreco(){
	var valor_venda  		= converteMoedaFloat($('#valor_venda').val());
	var valor_custo  		= converteMoedaFloat($('#valor_custo').val());	
	var liquido 			= valor_venda - valor_custo;
	var margem_lucro  		= liquido / valor_venda * 100;	
	
	$('#margem_lucro').val(formatarFloat(margem_lucro));
	
}

function mostrarUnidade(){
	var unidade = $('#unidade :selected').text();
	$("#txt_unidade").html(unidade);
}

function salvarCompleto(){
		var id					= $("#nfe_item_temp_id").val();
		var nome 				= $("#nome").val();	
		var unidade				= $("#unidade").val();
		var origem				= $("#origem").val();
		var categoria_id		= $("#categoria_"+id).val();		
		var estoque_inicial 	= converteMoedaFloat($("#estoque_inicial").val());	
		var estoque_maximo  	= converteMoedaFloat($("#estoque_maximo").val());
		var estoque_minimo  	= converteMoedaFloat($("#estoque_minimo").val());	
		var fragmentacao_qtde  	= ($("#fragmentacao_qtde").val()!="") ? converteMoedaFloat($("#fragmentacao_qtde").val()) :null;
		var fragmentacao_unidade= $("#fragmentacao_unidade").val();
		var fragmentacao_valor  = ($("#fragmentacao_valor").val() !="") ? $("#fragmentacao_valor").val() :null;
		var valor_venda 		= converteMoedaFloat($("#valor_venda").val());
		var valor_custo 		= converteMoedaFloat($("#valor_custo").val());
		
		$.ajax({
			url: base_url + "admin/nfetemp/cadastrarProduto",
		   type: "POST",
		   dataType: "json",
		   data:{	
		   		id					: id,
		   		nome				: nome,
				unidade				: unidade,
		   		origem				: origem,
		   		categoria_id		: categoria_id,
		   		estoque_inicial		: estoque_inicial,
		   		estoque_maximo		: estoque_maximo,
		   		estoque_minimo		: estoque_minimo,
		   		fragmentacao_qtde	: fragmentacao_qtde,
		   		fragmentacao_unidade: fragmentacao_unidade,
		   		fragmentacao_valor	: fragmentacao_valor,
		   		valor_venda			: valor_venda,
		   		valor_custo			: valor_custo
		   	},
		   	beforeSend: function(data){
		   		giraGira();
		   	},
			 success: function(data){
			 	fecharModal();
			 	if(data.tem_erro == true){
					$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
				}else{
					location.reload();
				};
			 }
			
		});
}


function salvarReduzido(id){
		var unidade				= $("#unid_"+id).val();
		var produto_id			= $("#prod_"+id).val();
		var categoria_id		= $("#categoria_"+id).val();
		var subcategoria_id		= $("#subcategoria_"+id).val();
		var subsubcategoria_id	= $("#subsubcategoria_"+id).val();
		var preco_id			= converteMoedaFloat($("#preco_"+id).val());
		
		if(isNaN(preco_id) ){
			alert("Digite o valor de Venda");
			return;
		}
		
		if(preco_id==""){
			alert("Digite o valor de Venda");
			return;
		}
		
		if(unidade==""){
			alert("Selecione Uma Unidade");
			return;
		}
		
		$.ajax({
			url: base_url + "admin/notafiscal/cadastrarProduto",
		   type: "POST",
		   dataType: "json",
		   data:{	
		   		id					: id,
		   		produto_id			: produto_id,
		   		subcategoria_id		: subcategoria_id,
		   		subsubcategoria_id	: subsubcategoria_id,
		   		unidade				: unidade,
		   		categoria_id		: categoria_id,
		   		valor_venda			: preco_id,
		   	},
		   	beforeSend: function(data){
		   		giraGira();
		   	},
			 success: function(data){
				fecharModal();
				if(data.tem_erro ==true){
					$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
				}else{
					location.reload();
				}
						
			 	
			}			 	
			
		});
}





  


