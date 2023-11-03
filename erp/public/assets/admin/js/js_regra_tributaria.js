var eh_modal = 0;
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});

$(function () {
   $("#btnInserirRegraTributaria").on("click", function(){
	alert();
		eh_modal = 1;	
		$.ajax({
		   url: base_url + "regratributaria",
		   type: "POST",
		   dataType: "json",
		   data: $("#frmCadRegraTributaria").serialize(),
		   success: function (data){
				if(data.tem_erro == true){
					fecharGiraGira(eh_modal);
					$("#erroModalLivre").html(data.erro);
					abrirModalLivre("#modalLivreErro");
				}else{
					location.reload();
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
   });

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
			   $("#nomeProduto").after('<div class="listaProdutos"></div>');
			   html="";
			   for(var i in data){
				   html +='<div class="si"><a href="javascript:;" onclick="selecionarProdutoTributacao(this)" ' +
				   		  'data-id="'+data[i].id +
				   		  '" data-nome = "' + data[i].nome + '">' +  data[i].id + " -  " + data[i].nome + '</a></div>';
			   }
			   
			   $(".listaProdutos").html(html);
			   $(".listaProdutos").show();
		   }
	   });
   });
	
		
});

function selecionarIcms900(){
	var cst = $("#cstICMS").val();
	if(cst =="900"){
		$("#divCst900").show();
	}else{
		$("#divCst900").hide();
	}
}
function abrirTelaInserirTributacao(){
	$("#id").val("");
	abrirModal('#modalTributacaoSimples')
}

function abrirTelaInserirRegraTributaria(){
	limparDados();
	$("#vbc_vprod_s").attr('checked',true);
	$("#id").val("");
	$("#divCst900").hide();	
	abrirModal('#modalRegraTributaria')
}

function excluirTributacao(id, padrao){
	if(padrao == "S"){
		$("#erroModalLivre").html("Você não pode excluir uma Tributação Padrão");
		abrirModalLivre("#modalLivreErro");
		return ;
	}
	
	if(confirm("Tem certeza que deseja excluir esta tributação, isso implicará em excluir todas as relações criadas com os produtos desta tribuitação")){
		$.ajax({
			url: base_url + "admin/tributacao/" + id,
		   type: "DELETE",
		   dataType: "json",
		   data:{},
			 success: function(data){
				if(data.tem_erro == true){
					fecharGiraGira(0);
					$("#erroModalLivre").html(data.erro);
					abrirModalLivre("#modalLivreErro");
				}else{
					location.reload();
				}
			},
			  	beforeSend: function () {
				giraGira();
		     }
			
		});
	}
}

function tornarPadrao(id){
	
	if(confirm("Tem certeza que deseja tornar esta tributação como padrão")){
		$.ajax({
			url: base_url + "admin/tributacao/tornarPadrao/" + id,
		   type: "GET",
		   dataType: "json",
		   data:{},
			 success: function(data){
				if(data.tem_erro == true){
					fecharGiraGira(0);
					$("#erroModalLivre").html(data.erro);
					abrirModalLivre("#modalLivreErro");
				}else{
					location.reload();
				}
			},
			  	beforeSend: function () {
				giraGira();
		     }
			
		});
	}
}

function verLista(){
	var tipo = $("#tipo").val();
	if(tipo == ""){
		return ;
	}else{
		verListaIPI(tipo);
		verListaCfop(tipo)
	}
}
function verListaIPI(tipo){	
	$.ajax({
			url: base_url + "admin/naturezaoperacao/buscarCstIpi/" + tipo,
		   type: "get",
		   dataType: "json",
		   data:{},
			 success: function(data){
				 html = "";
				for(var i in data){
					html += '<option value="' + data[i].cst + '">' +  data[i].descricao + '</option>';
			   }
				$("#cstIpi").html(html);
			 }
			
		});
}

function verListaCfop(tipo){	
	$.ajax({
			url: base_url + "admin/naturezaoperacao/buscarListaCfop/" + tipo,
		   type: "get",
		   dataType: "json",
		   data:{},
			 success: function(data){
				 html = "";
				for(var i in data){
					html += '<option value="' + data[i].cfop + '">' + data[i].cfop + ' - ' + data[i].descricao + '</option>';
			   }
				$("#cfop").html(html);
			 }
			
		});
}

$("#btnInserirProdutoTributacao").on("click", function(){
		var natureza_operacao_id= $("#natureza_operacao_id").val();
		var tributacao_id 		= $("#tributacao_id").val();
		var produto_id 			= $("#produto_id").val();	
	
		if(natureza_operacao_id==""){
			alert("Selecionar a natureza de operação primeiramente");
			return;
		}
		
		if(tributacao_id==""){
			alert("Selecionar a tributação primeiramente");
			return;
		}
		
		if(produto_id==""){
			alert("Selecionar o Produto primeiramente");
			return;
		}
		
		$.ajax({
			url: base_url + "admin/tributacao/inserirProduto",
		   type: "POST",
		   dataType: "json",
		   data:{	
		   		produto_id				: produto_id,
		   		natureza_operacao_id	: natureza_operacao_id,
		   		tributacao_id			: tributacao_id
		   	},
			 success: function(data){
				 lista_produto_tributacao(data);
				 limpar_produto_tributacao();
			 }
			
		});
	});

$("#btnInserirIvaTributacao").on("click", function(){
		var natureza_operacao_id		= $("#natureza_operacao_id").val();
		var tributacao_id_iva			= $("#tributacao_id_iva").val();
	
		if(natureza_operacao_id==""){
			alert("Selecionar a natureza de operação primeiramente");
			return;
		}
		
		if(tributacao_id_iva==""){
			alert("Selecionar a tributação primeiramente");
			return;
		}
			
		
		$.ajax({
			url: base_url + "admin/tributacao/inserirIva",
		   type: "POST",
		   dataType: "json",
		   data:$("#frmCadIva").serialize(),
			 success: function(data){
				 lista_iva_tributacao(data);
				 limpar_iva_tributacao();
			 }
			
		});
	});
	
$("#btnInserirEstadoTributacao").on("click", function(){
		var natureza_operacao_id		= $("#natureza_operacao_id").val();
		var tributacao_id 				= $("#tributacao_id").val();
		var tributacao_contribuinte_id  = $("#tributacao_contribuinte_id").val();	
		var estado_id 					= $("#estado_id").val();	
		var cst  						= $("#cstEstadoICMS").val();
		var pICMS  						= $("#pICMSEstado").val();
		var pFCP  						= $("#pFCPEstado").val();
		var cfop						= $("#cfopEstado").val();
	
		if(natureza_operacao_id==""){
			alert("Selecionar a natureza de operação primeiramente");
			return;
		}
		
		if(tributacao_id==""){
			alert("Selecionar a tributação primeiramente");
			return;
		}
		
		if(estado_id==""){
			alert("Selecionar o Estado primeiramente");
			return;
		}
		
		$.ajax({
			url: base_url + "admin/tributacao/inserirEstado",
		   type: "POST",
		   dataType: "json",
		   data:{	
		   		estado_id				: estado_id,
		   		natureza_operacao_id	: natureza_operacao_id,
		   		tributacao_id			: tributacao_id,
		   		tributacao_contribuinte_id	: tributacao_contribuinte_id,
		   		cst						: cst,
		   		pICMS					: pICMS,
		   		pFCP					: pFCP,
		   		cfop					: cfop
		   	},
			 success: function(data){
				 lista_estado_tributacao(data);
				 limpar_estado_tributacao();
			 }
			
		});
	});
	
function editarTributacaoSimples(id){	
	$.ajax({
	   url: base_url + "admin/tributacao/"  + id,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
		     mostrarDadosSimples(data);
			 abrirModal('#modalTributacaoSimples');
		 }		
	});	
}

function editarTributacaoLucro(id){	
	$.ajax({
	   url: base_url + "admin/tributacao/"  + id,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
		     mostrarDadosLucro(data);
			 abrirModal('#modalTributacaoLucro');
		 }		
	});	
}

function abrirTelaProduto(id){
	$("#tributacao_id").val(id);
	$.ajax({
	   url: base_url + "admin/tributacao/listaProdutoTributacao/"  + id,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
			 lista_produto_tributacao(data);
		 }		
	});
	abrirModal('#telaProduto');
}
	
function selecionarProdutoTributacao(obj){
	var id		= $(obj).attr('data-id');
	var nome	= $(obj).attr('data-nome');
	$(".listaProdutos").hide();
	
	$("#produto_id").val(id);
	$("#nomeProduto").val(nome);
	$("#nomeProduto").focus();
		
}

function abrirTelaEstado(id){
	$("#tributacao_id").val(id);
	$.ajax({
	   url: base_url + "admin/tributacao/listaTributacaoEstado/"  + id,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
			 lista_estado_tributacao(data);
		 }		
	});
	abrirModal('#telaEstado');
}

function abrirTelaIva(id){
	$("#tributacao_id_iva").val(id);
	$.ajax({
	   url: base_url + "admin/tributacao/listaTributacaoIva/"  + id,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
			 lista_iva_tributacao(data);
		 }		
	});
	abrirModal('#telaIva');
}

function lista_iva_tributacao(data){
	html = "<tr>";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="left">' + data[i].uf_origem + '</td>' + 
		'<td align="left">' + data[i].uf_destino + '</td>' + 
		'<td align="left">' + data[i].pIcmsIntra + '</td>' + 
		'<td align="left">' + data[i].pIcmsInter + '</td>' + 
		'<td align="left">' + data[i].pMVAST + '</td>' +
		'<td align="left">' + data[i].pRedBCST + '</td>' +
		'<td align="left">' + data[i].pFCPST + '</td>' +
		'<td align="left">' + data[i].modBCST + '</td>' +
		'<td align="left">' + data[i].pDifal + '</td>' + 
       	'<td align="center"><a href="javascript:;" onclick="excluirIvaTributacao('+ data[i].id +')"  class="btn btn-outline-vermelho btn-pequeno fas fa-trash" title="Excluir"></a></td></tr>'
	}
	$("#lista_iva_tributacao").html(html);
}

function lista_estado_tributacao(data){
	html = "<tr>";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="left">' + data[i].estado + '</td>' + 
		'<td align="left">' + data[i].tipo_contribuinte + '</td>' + 
		'<td align="left">' + data[i].cfop + '</td>' + 
		'<td align="left">' + data[i].cst + '</td>' + 
		'<td align="left">' + data[i].pICMS + '</td>' + 
		'<td align="left">' + data[i].pFCP + '</td>' + 
       	'<td align="center"><a href="javascript:;" onclick="excluirEstadoTributacao('+ data[i].id +')"  class="btn btn-outline-vermelho btn-pequeno fas fa-trash" title="Excluir"></a></td></tr>'
	}
	$("#lista_estado_tributacao").html(html);
}

function lista_produto_tributacao(data){
	html = "<tr>";
	for(var i in data){
		html += '<td align="center">' + data[i].id + '</td>' +
        '<td align="left">' + data[i].nome + '</td>' + 
       	'<td align="center"><a href="javascript:;" onclick="excluirProdutoTributacao('+ data[i].id +')"  class="btn btn-outline-vermelho btn-pequeno fas fa-trash" title="Excluir"></a></td></tr>'
	}
	$("#lista_produto_tributacao").html(html);
}

function excluirProdutoTributacao(id){
       $.ajax({
         url: base_url + "admin/tributacao/excluirProdutoTributacao/"  + id ,
         type: "GET",
         data: {  },
         dataType:"Json",
         success: function(data){
             lista_produto_tributacao(data.retorno);
			 limpar_produto_tributacao();
         }
         
     });
}

function excluirEstadoTributacao(id){
       $.ajax({
         url: base_url + "admin/tributacao/excluirEstadoTributacao/"  + id ,
         type: "GET",
         data: {  },
         dataType:"Json",
         success: function(data){
             lista_estado_tributacao(data);
         }
         
     });
}

function excluirIvaTributacao(id){
       $.ajax({
         url: base_url + "admin/tributacao/excluirIvaTributacao/"  + id ,
         type: "GET",
         data: {  },
         dataType:"Json",
         success: function(data){
             lista_iva_tributacao(data);
         }
         
     });
}

function limpar_produto_tributacao(){
	$("#produto_id").val("");
	$("#nomeProduto").val("");
}

function limpar_estado_tributacao(){
	$("#pICMSEstado").val("");
	$("#pFCPEstado").val("");
	$("#cfopEstado").val("");
}

function selecionarIcms(){
	var cstICMS = $("#cstICMS").val();
	sumirTodos();	
	if(cstICMS=="00"){
		$("#divModBC").show();
		$("#divPICMS").show();
		$("#divPFCP").show();
		$("#divVICMSSubstituto").show();
	}else if(cstICMS=="10"){
		$("#divModBC").show();
		$("#divPICMSST").show();
		$("#divPICMS").show();
		$("#divPMVAST").show();
		$("#divPRedBCST").show();
		$("#divModBCST").show();
		$("#divVICMSSubstituto").show();
		$("#divPFCP").show();
		$("#divPFCPST").show();
	}else if(cstICMS=="20"){
		$("#divModBC").show();
		$("#divPICMS").show();
		$("#divPRedBC").show();
		$("#divVICMSSubstituto").show();
		$("#divPFCP").show();
	
	}else if(cstICMS=="30"){
		$("#divPICMSST").show();
		$("#divPMVAST").show();
		$("#divPRedBCST").show();
		$("#divModBCST").show();
		$("#divVICMSSubstituto").show();
		$("#divPFCPST").show();
	}else if(cstICMS=="40" || cstICMS=="41" || cstICMS=="50" ){
		$("#divVICMSSubstituto").show();
	}else if(cstICMS=="30"){
		$("#divModBC").show();
		$("#divPICMS").show();
		$("#divPRedBC").show();
		$("#divVICMSSubstituto").show();
		$("#divPFCP").show();
		$("#divPFCPST").show();
	}else if(cstICMS=="51"){
		$("#divModBC").show();
		$("#divPICMS").show();
		$("#divPDif").show();
		$("#divPFCP").show();
		$("#divPFCPST").show();
	}
}
function desabilitarTodos(){
	$("#modBC").prop('readonly', true);
	$("#divPICMS").prop('readonly', true);
	$("#divPRedBC").prop('readonly', true);
	$("#modBCST").prop('readonly', true);
	$("#vBCST").prop('readonly', true);
	$("#divPICMSST").prop('readonly', true);
	$("#divPMVAST").prop('readonly', true);
	$("#pRedBCST").prop('readonly', true);
	$("#pFCP").prop('readonly', true);
	$("#pFCPST").prop('readonly', true);
	$("#pFCPSTRet").prop('readonly', true);
	$("#divVICMSSubstituto").prop('readonly', true);
	$("#pDif").prop('readonly', true);
}

function sumirTodos(){
	$("#divModBC").hide();
	$("#divPICMS").hide();
	$("#divPRedBC").hide();
	$("#divModBCST").hide();
	$("#divVBCST").hide();
	$("#divPICMSST").hide();
	$("#divPMVAST").hide();
	$("#divPRedBCST").hide();
	$("#divVICMSSubstituto").hide();
	$("#divPFCP").hide();
	$("#divPFCPST").hide();
	$("#divVFCP").hide();
	$("#divPFCPSTRet").hide();
	$("#divPDif").hide();
}

function mostrarDadosSimples(data){
	$("#id").val(data.id);
	$("#descricao").val(data.descricao);
	$("#cfop").val(data.cfop);
	$("#cstICMS").val(data.cstICMS);
	$("#cstCOFINS").val(data.cstCOFINS);
	$("#cstPIS").val(data.cstPIS);
	$("#cstIPI").val(data.cstIPI);	
	$("#pICMS").val(data.pICMS);
	$("#modBC").val(data.modBC);
	$("#modBCST").val(data.modBCST);
	$("#pMVAST").val(data.pMVAST);
	$("#pICMSST").val(data.pICMSST);
	$("#pRedBCST").val(data.pRedBCST);
	$("#uso_consumo").val(data.uso_consumo);
}

function mostrarDadosLucro(data){
	$("#cstICMS").val(data.cstICMS);
	var cst = $("#cstICMS").val();
	if(cst =="900"){
		$("#divCst900").show();
	}else{
		$("#divCst900").hide();
	}	
	
	
	$("#id").val(data.id);
	$("#descricao").val(data.descricao);
	$("#cfop").val(data.cfop);
	$("#cfop_fora").val(data.cfop_fora);
	$("#cfop_fora_consumidor_final").val(data.cfop_fora_consumidor_final);
	$("#cfop_exportacao").val(data.cfop_exportacao);
	
	$("#vBCICMS").val(data.vBCICMS);
	
	$("#modBC").val(data.modBC);
	$("#pICMS").val(data.pICMS);
	$("#pRedBC").val(data.pRedBC);
	$("#modBCST").val(data.modBCST);
	$("#pICMSST").val(data.pICMSST);
	$("#pMVAST").val(data.pMVAST);
	$("#preco_unit_Pauta_ST").val(data.preco_unit_Pauta_ST);
	$("#pRedBCST").val(data.pRedBCST);
	$("#motDesICMS").val(data.motDesICMS);
	$("#vICMSSubstituto").val(data.vICMSSubstituto);
	$("#pBCOp").val(data.pBCOp);
	$("#pFCP").val(data.pFCP);
	$("#pFCPST").val(data.pFCPST);
	$("#pFCPSTRet").val(data.pFCPSTRet);
	$("#pDif").val(data.pDif);
	
	$("#cstIPI").val(data.cstIPI);
	$("#pIPI").val(data.pIPI);
	if(data.tipo_calc_ipi==null){
		$("#tipo_calc_ipi").val(1);
	}else{
		$("#tipo_calc_ipi").val(data.tipo_calc_ipi);
	}
	$("#CNPJProd").val(data.CNPJProd);
	$("#cSelo").val(data.cSelo);
	$("#qSelo").val(data.qSelo);
	$("#qUnidIPI").val(data.qUnidIPI);
	$("#vUnidIPI").val(data.vUnidIPI);
	$("#cEnq").val(data.cEnq);
	
	$("#cstPIS").val(data.cstPIS);
	$("#tipo_calc_pis").val(data.tipo_calc_pis);
	$("#pPIS").val(data.pPIS);
	$("#vAliqProd_pis").val(data.vAliqProd_pis);
	$("#tipo_calc_pis").val(data.tipo_calc_pis);
	$("#pPISST").val(data.pPISST);
	$("#vAliqProd_pisst").val(data.vAliqProd_pisst);
	
	$("#cstCOFINS").val(data.cstCOFINS);
	$("#tipo_calc_cofins").val(data.tipo_calc_cofins);
	$("#pCOFINS").val(data.pCOFINS);
	$("#vAliqProd_cofins").val(data.vAliqProd_cofins);
	$("#tipo_calc_cofinsst").val(data.tipo_calc_cofinsst);
	$("#pCOFINSST").val(data.pCOFINSST);
	$("#vAliqProd_cofinsst").val(data.vAliqProd_cofinsst);
	
	$("#uso_consumo").val(data.uso_consumo);
	
	marcarCheck('vbc_somente_produto', data.vbc_somente_produto);
	marcarCheck('vbc_frete', data.vbc_frete);
	marcarCheck('vbc_outros', data.vbc_outros);
	marcarCheck('vbc_seguro', data.vbc_seguro);
	marcarCheck('vbc_ipi', data.vbc_ipi);
	marcarCheck('vbc_desconto', data.vbc_desconto);
	
	marcarCheck('ipi_somente_produto', data.ipi_somente_produto);
	marcarCheck('ipi_frete', data.ipi_frete);
	marcarCheck('ipi_outros', data.ipi_outros);
	marcarCheck('ipi_seguro', data.ipi_seguro);
	marcarCheck('ipi_desconto', data.ipi_desconto);
	
	marcarCheck('pis_somente_produto', data.pis_somente_produto);
	marcarCheck('pis_frete', data.pis_frete);
	marcarCheck('pis_ipi', data.pis_ipi);
	marcarCheck('pis_outros', data.pis_outros);
	marcarCheck('pis_seguro', data.pis_seguro);
	marcarCheck('pis_desconto', data.pis_desconto);
	
	marcarCheck('cofins_somente_produto', data.cofins_somente_produto);
	marcarCheck('cofins_frete', data.cofins_frete);
	marcarCheck('cofins_ipi', data.cofins_ipi);
	marcarCheck('cofins_outros', data.cofins_outros);
	marcarCheck('cofins_seguro', data.cofins_seguro);
	marcarCheck('cofins_desconto', data.cofins_desconto);
	
	marcarCheck('cst900_icms', data.cst900_icms);
	marcarCheck('cst900_redbc', data.cst900_redbc);
	marcarCheck('cst900_credisn', data.cst900_credisn);
	marcarCheck('cst900_st', data.cst900_st);
	marcarCheck('cst900_redbcst', data.cst900_redbcst);
}

function limparDados(){
	$("#cstICMS").val("00");
	$("#divCst900").hide();	
	$("#id").val("");
	$("#descricao").val("");
	$("#cfop").val("");
	$("#cfop_fora").val("");
	$("#cfop_fora_consumidor_final").val("");
	$("#cfop_exportacao").val("");
	$("#vBCICMS").val("");
	
	$("#modBC").val("2");
	$("#pICMS").val("");
	$("#pRedBC").val("");
	$("#modBCST").val("4");
	$("#pICMSST").val("");
	$("#pMVAST").val("");
	$("#pRedBCST").val("");
	$("#motDesICMS").val("");
	$("#vICMSSubstituto").val("");
	$("#pBCOp").val("");
	$("#pFCP").val("");
	$("#pFCPST").val("");
	$("#pFCPSTRet").val("");
	$("#pDif").val("");
	
	$("#cstIPI").val("53");
	$("#pIPI").val();
	$("#CNPJProd").val("");
	$("#cSelo").val("");
	$("#qSelo").val("");
	$("#qUnidIPI").val("");
	$("#vUnidIPI").val("");
	$("#cEnq").val("999");
	
	$("#cstPIS").val("07");
	$("#pPIS").val("");
	$("#vAliqProd_pis").val("");
	$("#tipo_calc_pis").val("");
	$("#pPISST").val("");
	$("#vAliqProd_pisst").val("");
	
	$("#cstCOFINS").val("07");
	$("#pCOFINS").val("");
	$("#vAliqProd_cofins").val("");
	$("#tipo_calc_cofinsst").val("");
	$("#pCOFINSST").val("");
	$("#vAliqProd_cofinsst").val("");
	
	
	marcarCheck('vbc_frete', "N");
	marcarCheck('vbc_outros', "N");
	marcarCheck('vbc_seguro', "N");
	marcarCheck('vbc_ipi', "N");
	marcarCheck('vbc_desconto', "N");
	
	marcarCheck('ipi_frete', "N");
	marcarCheck('ipi_outros', "N");
	marcarCheck('ipi_seguro', "N");
	marcarCheck('ipi_desconto', "N");
	
	marcarCheck('pis_frete', "N");
	marcarCheck('pis_ipi', "N");
	marcarCheck('pis_outros', "N");
	marcarCheck('pis_seguro', "N");
	marcarCheck('pis_desconto', "N");
	
	marcarCheck('cofins_frete', "N");
	marcarCheck('cofins_ipi', "N");
	marcarCheck('cofins_outros', "N");
	marcarCheck('cofins_seguro', "N");
	marcarCheck('cofins_desconto', "N");
	
	marcarCheck('cst900_icms', "S");
	marcarCheck('cst900_redbc', "N");
	marcarCheck('cst900_credisn', "N");
	marcarCheck('cst900_st', "N");
	marcarCheck('cst900_redbcst', "N");
}