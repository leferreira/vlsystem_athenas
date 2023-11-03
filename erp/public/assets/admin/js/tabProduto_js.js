var unidades = [];
$(function (){	
    $("#btnInserirProduto").on("click", function(){
        var id_produto  		= $("#id_produto").val();
        var qtde        		= converteMoedaFloat($("#qtde").val());
        var preco       		= converteMoedaFloat($("#preco").val());
		var unidade       		= $("#unidade_nfe").val(); 
		var tipo_desc       	= $("#tipo_desc").val();
		let valor_desconto		= converteMoedaFloat($('#val_desconto').val());  
		let desconto_percentual = 0;
		let desconto_por_valor  = 0; 
		
		if(id_produto == ''){
			$("#mostrarUmErro").html(MostrarUmaMsgErro("Selecione um Produto primeiramente"));
			return false;
		}
	
		if(parseFloat(qtde <= 0)){
			$("#mostrarUmErro").html(MostrarUmaMsgErro("Digite a quantidade primeiramente"));
			return false;
		}
		
		if(qtde.length <= 0 && parseFloat(qtde <= 0)  ){
			$("#mostrarUmErro").html(MostrarUmaMsgErro("Digite a quantidade primeiramente"));
			return false;
		}
		
		if(Number.isNaN(qtde)){
			$("#mostrarUmErro").html(MostrarUmaMsgErro("Digite a quantidade primeiramente"));
			return false;
		}
	
		if(Number.isNaN(preco)){
			$("#mostrarUmErro").html(MostrarUmaMsgErro("Digite a Valor primeiramente"));
			return false;
		}
		
		if(valor_desconto > 0){
			if(tipo_desc=="desc_perc"){
				desconto_percentual = valor_desconto;
				desconto_por_valor = 0;
			}
		
			if(tipo_desc=="desc_valor"){
				desconto_percentual = 0;
				desconto_por_valor = valor_desconto;
			}
		}
        
        $.ajax({
         url: base_url + "admin/itemnotafiscal/inserir",
         type: "POST",
         data: {
             nfe_id:id_nfe,
			 natureza_operacao_id : natureza_operacao_id ,
             produto_id: id_produto,
             qtde:qtde,
             preco:preco ,
			 unidade: unidade,
		     desconto_percentual : desconto_percentual,
			 desconto_por_valor: desconto_por_valor
      
         },
         dataType:"Json",
         success: function(data){
			fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{
				mostrar_dados_nfe(data.nfe);
				lista_itens(data.itens);
				limparDadosItem();
			}
             
         }, error: function (e) {
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}         
     });        
    });
    
	 $("#btnInserirProdutoSemCalculo").on("click", function(){
        var id_produto  		= $("#id_produto").val();
        var qtde        		= $("#qtde").val();
        var preco       		= $("#preco").val();
		var unidade       		= $("#unidade_nfe").val(); 
		var tipo_desc       	= $("#tipo_desc").val();
		var val_desconto       	= $("#val_desconto").val();     
        
        $.ajax({
         url: base_url + "admin/itemnotafiscal/inserirSemCalculo",
         type: "POST",
         data: {
             nfe_id:id_nfe,
			 natureza_operacao_id : natureza_operacao_id ,
             produto_id: id_produto,
             qtde:qtde,
             preco:preco ,
			 unidade: unidade,
		     tipo_desc: tipo_desc,
			 val_desconto: val_desconto,
      
         },
         dataType:"Json",
         success: function(data){
			fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{
				mostrar_dados_nfe(data.nfe);
				lista_itens(data.itens);
				limparDadosItem();
			}
             
         }, error: function (e) {
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}         
     });        
    });
	
   $("#produto").on("keyup", function(){
       var q = $("#produto").val();      
       $.ajax({
         url: base_url + "admin/produto/pesquisa/",
         type: "get",
         data: {
             q:q
         },
         dataType:"Json",
         success: function(data){
             $("#produto").after('<div class="listaProdutos"></div>');
            var html = "<ul>";
            for(var i in data){
                html += '<li class="si"><a href="javascript:;" onclick="selecionarProduto(this)" '+
						'data-id="'+data[i].id +
                        '" data-preco = "' + data[i].valor_venda +
				   		  	'" data-nome  = "' + data[i].nome + 
							'" data-fragmentacao_qtde = "' + data[i].fragmentacao_qtde + 
							'" data-fragmentacao_unidade = "' + data[i].fragmentacao_unidade + 
							'" data-fragmentacao_valor = "' + data[i].fragmentacao_valor + 
							'" data-unidade = "' + data[i].unidade + '">' +
                          data[i].nome + ' - ' + data[i].valor_venda +'</a></li>';
            }            
            html +="</ul>";
            
            $(".listaProdutos").html(html);
            $(".listaProdutos").show();
            
              
         }
         
     });
   })    


	$('#preco').on('keyup', () => {
		calcSubtotal()
	})
	
	$('#qtde').on('keyup', () => {
		calcSubtotal()
	})	
	
	
	$('#val_desconto').on('keyup', () => {
		calcularDescontoItem();
	})
	$('#val_desconto').on('blur', () => {
		let val_desconto= $('#val_desconto').val();
		if(val_desconto==null || val_desconto==''  ){
			$('#val_desconto').val(0);
		}
		calcularDescontoItem();
	})
	
	$('#val_desconto_modal_item').on('keyup', () => {
		calcularDescontoModalItem();
	})
	
	$('#val_desconto_modal_item').on('blur', () => {
		let val_desconto_modal_item= $('#val_desconto_modal_item').val();
		if(val_desconto_modal_item==null || val_desconto_modal_item==''  ){
			$('#val_desconto_modal_item').val(0);
		}
		calcularDescontoModalItem();
	})

	$('#vUnCom').on('keyup', () => {
		calcSubtotalModalItem()
	})
	
	$('#qCom').on('keyup', () => {
		calcSubtotalModalItem()
	})

});

function selecionarIcms(){
	var cst = $("#cstICMS").val();
	if(cst =="900"){
		$("#divCst900").show();
	}else{
		$("#divCst900").hide();
	}
}
function calcularDescontoItem(){
		let tipo_desc 	= $('#tipo_desc').val();
		let qtde 		= converteMoedaFloat($('#qtde').val());
		let preco 		= converteMoedaFloat($('#preco').val());
		let subtotal	= converteMoedaFloat($('#subtotal').val());
		let val_desconto= converteMoedaFloat($('#val_desconto').val());
		var desc    	=  parseFloat(0);
		var desconto   	=  parseFloat(0);			
	    
		
		if(tipo_desc=="desc_perc"){
			desconto = qtde * preco * val_desconto * 0.01 ;
		}else if(tipo_desc=="desc_valor"){
			desconto = qtde *  val_desconto
		}
		
		desc = 	 subtotal - desconto;	
		$('#desconto').val(converteFloatMoeda(desconto));
		$('#total_item').val(converteFloatMoeda(desc));
	}
function calcularDescontoModalItem(){
		let tipo_desc_modal_item 	= $('#tipo_desc_modal_item').val();
		let vProd 					= converteMoedaFloat($('#vProd').val());
		let val_desconto_modal_item	= converteMoedaFloat($('#val_desconto_modal_item').val());
		let desconto_rateio			= converteMoedaFloat($('#desconto_rateio').val());
		var desc    				=  parseFloat(0);
		var desconto   				=  parseFloat(0);			
	    
		
		if(tipo_desc_modal_item=="desc_perc"){
			desconto = vProd * val_desconto_modal_item * 0.01 ;
		}else if(tipo_desc=="desc_valor"){
			desconto = val_desconto_modal_item
		}
		
		desc = 	desconto + desconto_rateio;
		
		$('#desconto_item').val(converteFloatMoeda(desconto));
		$('#vDesc').val(converteFloatMoeda(desc));
	}	
function inserirProduto(){
		$.ajax({
			url: base_url + "admin/produto/salvarJs",
		   type: "POST",
		   dataType: "json",
		   data:$("#frmCadProduto").serialize(),
		   	beforeSend: function(){
		   		giraGira();
		   	},
			 success: function(data){
				
				//console.log(data.errors);
				
			 },error: function (data) {
				if(data.status==422){
					var errors = $.parseJSON(data.responseText);				
		        	$.each(errors.errors, function (key, value) {
						 fecharGiraGira();
						 abrirModalLivre("#modallista");
		           		 console.log(key+ " " +value);
		        	});

				}
		        
    		}
			
		});
}

function atualizarItens(){
	$.ajax({
         url: base_url + "admin/itemnotafiscal/atualizar",
         type: "POST",
         data: $("#frmCadItemNfe").serialize() ,
         dataType:"Json",
         success: function(data){
			fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{				
				mostrar_dados_nfe(data.nfe);
				lista_itens(data.itens);
			}
             
         }, error: function (e) {
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		},
		  beforeSend: function () {
			giraGira();
	     }         
     });
}

function atualizarSemCalculo(){
	$.ajax({
         url: base_url + "admin/itemnotafiscal/atualizarSemCalculo",
         type: "POST",
         data: $("#frmAtualizarItemNfe").serialize() ,
         dataType:"Json",
         success: function(data){
			fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{				
				mostrar_dados_nfe(data.nfe);
				lista_itens(data.itens);
			}
             
         }, error: function (e) {
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		},
		  beforeSend: function () {
			giraGira();
	     }         
     });
}

function recalcular(){
	$.ajax({
         url: base_url + "admin/itemnotafiscal/recalcular",
         type: "POST",
         data: $("#frmCadItemNfe").serialize() ,
         dataType:"Json",
         success: function(data){
			fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{
				fecharModal();
			}
             
         }, error: function (e) {
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		},
		  beforeSend: function () {
			giraGira();
	     }         
     });
}



function verDetalheItemNfe(id){
	 $.ajax({
         url: base_url + "admin/itemnotafiscal/detalhe/" + id ,
         type: "GET",
         data: {  },
         dataType:"Json",
         success: function(data){
			 console.log(data);
		     mostrarDados(data);
             abrirModal("#modalDetalheItemNfe");
         }         
     });

	
}

function excluirProduto(id){
       $.ajax({
         url: base_url + "admin/itemnotafiscal/excluir/" + id ,
         type: "GET",
         data: {  },
         dataType:"Json",
         success: function(data){
		 	if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{
            	mostrar_dados_nfe(data.nfe);
				lista_itens(data.itens);
			}
		 }         
     });
}

function excluirProdutoSemCalculo(id){
       $.ajax({
         url: base_url + "admin/itemnotafiscal/excluirSemCalculo/" + id ,
         type: "GET",
         data: {  },
         dataType:"Json",
         success: function(data){
		 	if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{
            	mostrar_dados_nfe(data.nfe);
				lista_itens(data.itens);
			}
		 }         
     });
}
function lista_itens(data){
    var html = "";
	var j = 1;
    for(var i in data){
		var vIcms 	= (data[i].vICMS != null) ? data[i].vICMS : 0;
		var vIpi 	= (data[i].vIPI != null) ? data[i].vIPI : 0;
		var vPis 	= (data[i].vPIS != null) ? data[i].vPIS : 0;
		var vCofins = (data[i].vCOFINS != null) ? data[i].vCOFINS : 0;
        html += "<tr> " +
               "<td>" + j++  + "</td>" +
               "<td>" + data[i].xProd + "</td>" +
               "<td>" + data[i].vUnCom+ "</td>" +
               "<td>" + data[i].qCom+ "</td>" +
               "<td>" + data[i].vProd+ "</td>" +
				"<td>" + data[i].NCM+ "</td>" +
				"<td>" + data[i].CFOP+ "</td>" +
				"<td>" + vIcms + "</td>" +
				"<td>" + vIpi + "</td>" +
				"<td>" + vPis + "</td>" +
				"<td>" + vCofins + "</td>" +
               "<td><a href='javascript:;' onclick='verDetalheItemNfe("+ data[i].id +")'  class='btn btn-outline-verde btn-pequeno'>Detalhes</a></td>" +
               "<td><a href='javascript:;' onclick='excluirProduto("+ data[i].id +")'  class='btn btn-outline-vermelho btn-pequeno' title='Excluir'>Excluir</a></td>" +
       "</tr>"; 
    }
    $("#lista_itens").html(html);    
}

function selecionarUnidade(){
	var unid = $("#unidade_nfe").val();
	for (i = 0; i < unidades.length; i++) {
		if(unidades[i].unidade == unid){
			$("#preco").val(unidades[i].valor);
			$("#subtotal").val(unidades[i].valor);	
			$("#quantidade").val(1);
			$("#preco").focus();
			break;
		}
	}
}

function selecionarProduto(obj){
    var id 					= $(obj).attr("data-id");
    var nome 				= $(obj).attr("data-nome");
    var preco 				= $(obj).attr("data-preco");
	var unidade				= $(obj).attr('data-unidade');
	var FRAGMENTACAO_UNIDADE= $(obj).attr('data-fragmentacao_unidade');
	var FRAGMENTACAO_VALOR 	= $(obj).attr('data-fragmentacao_valor');
	var FRAGMENTACAO_QTDE 	= $(obj).attr('data-fragmentacao_qtde');
	
	var html = "";
	if(FRAGMENTACAO_UNIDADE!="null"){
		unidades = [
					{unidade:unidade, valor:preco, qtde:1 },
					{unidade:FRAGMENTACAO_UNIDADE, valor:FRAGMENTACAO_VALOR, qtde:FRAGMENTACAO_QTDE }
					]		
	
	}else{
		unidades = [
					{unidade:unidade, valor:preco, qtde:1 }
					]
	}
	
	  html = "";
	  for (i = 0; i < unidades.length; i++) {	
		  html +="<option value='"+ unidades[i].unidade +"'>" + unidades[i].unidade + "</option>";
	  } 

	$("#unidade_nfe").html(html);
	
    
    $(".listaProdutos").hide();
    $("#id_produto").val(id);
    $("#produto").val(nome);
    $("#preco").val(converteFloatMoeda(preco));
	$("#subtotal").val(converteFloatMoeda(preco));
	$("#total_item").val(converteFloatMoeda(preco));	
    $("#qtde").val(1);
    $("#qtde").focus();
	calcularDescontoItem();
}



function calcSubtotal() {
	let qtde 		= converteMoedaFloat($('#qtde').val());
	let preco 		= converteMoedaFloat($('#preco').val());
	let subtotal 	= preco * qtde;
	$('#subtotal').val(subtotal.toFixed(2));
	$('#total_item').val(converteFloatMoeda(subtotal));
	
	calcularDescontoItem();
}

function calcSubtotalModalItem() {
	let qCom 		= converteMoedaFloat($('#qCom').val());
	let vUnCom 		= converteMoedaFloat($('#vUnCom').val());
	let vProd 	= qCom * vUnCom;
	$('#vProd').val(vProd.toFixed(2));	
	calcularDescontoModalItem();
}

function carregar_produto_especifico(){    
   var id_especifico = $("#id_especifico").val();      
	 $.ajax({
		url: base_url + 'carregar/produto_especifico/' + id_especifico ,
		type: 'GET',
		//beforeSend: load_in(),
		success: function (html) {
		  $('#div_produto_especifico').html(html);         
		},
		error: function () {
			notify('Erro', 'Houve uma falha de comunicação.');
		}
	});
}
function mostrar_dados_nfe(data){
	$("#vBCtot").val(data.vBC);
	$("#vICMStot").val(data.vICMS );
	$("#vFCPTot").val(data.vFCP );
	$("#vBCSTTot").val(data.vBCST );
	$("#vSTTot").val(data.vST );
	$("#vFCPSTTot").val(data.vFCPST );
	$("#vFCPSTRetTot").val(data.vFCPSTRet );
	$("#vIITot").val(data.vII );
	$("#vBCTot").val(data.CEST );
	$("#vIPITot").val(data.vIPI );
	$("#vIPIDevol").val(data.vIPIDevol );
	$("#vPISTot").val(data.vPIS );
	$("#vCOFINSTot").val(data.vCOFINS );
	$("#vNF1").val(data.vNF );
	$("#vTotTrib").val(data.vTotTrib );
	$("#estadual").val(data.estadual );
	$("#estadual").val(data.estadual );
	$("#nacionalfederal").val(data.nacionalfederal );
	
	$("#vProdTot").val(data.vProd );
	$("#vFreteTot").val(data.vFrete );
	$("#vSegTot").val(data.vSeg );
	$("#vOutroTot").val(data.vOutro );
	$("#vNF").val(data.vNF );
	$("#vLiq").val(data.vLiq );
	$("#vOrig").val(data.vOrig );
	$("#valor_parcela").val(data.vLiq );
	
		
}


function mostrarDados(data){	
	$("#CEST").val(data.retorno.CEST );
	$("#CFOP").val(data.retorno.CFOP );
	$("#CNPJProd").val(data.retorno.CNPJProd );
	$("#CSOSN").val(data.retorno.CSOSN );
	$("#EXTIPI").val(data.retorno.EXTIPI );
	$("#NCM").val(data.retorno.NCM );
	$("#NVE").val(data.retorno.NVE );
	
	$("#uCom").val(data.retorno.uCom );
	$("#qCom").val(converteFloatMoeda(data.retorno.qCom) );
	$("#vUnCom").val(converteFloatMoeda(data.retorno.vUnCom) );
	$("#vProd").val(converteFloatMoeda(data.retorno.vProd) );
	$("#uTrib").val(data.retorno.uTrib) ;
	$("#qTrib").val(converteFloatMoeda(data.retorno.qTrib) );
	$("#vUnTrib").val(converteFloatMoeda(data.retorno.vUnTrib) );
	$("#val_desconto_modal_item").val(converteFloatMoeda(data.retorno.desconto_item) );
	
	if(data.retorno.vFrete!= null)
		$("#vFrete").val(converteFloatMoeda(data.retorno.vFrete) );	
	if(data.retorno.desconto_item!= null)
		$("#desconto_item").val(converteFloatMoeda(data.retorno.desconto_item) );
	if(data.retorno.desconto_rateio!= null)
		$("#desconto_rateio").val(converteFloatMoeda(data.retorno.desconto_rateio) );
	if(data.retorno.vDesc!= null)
		$("#vDesc").val(converteFloatMoeda(data.retorno.vDesc) );		
	if(data.retorno.vSeg!= null)
		$("#vSeg").val(converteFloatMoeda(data.retorno.vSeg) );
	if(data.retorno.vOutro!= null)
		$("#vOutro").val(converteFloatMoeda(data.retorno.vOutro) );	
	$("#xPed").val(data.retorno.xPed );
	$("#xProd").val(data.retorno.xProd );
	
	
	$("#cstICMS").val(data.retorno.cstICMS );
	var cst = data.retorno.cstICMS;	
	if(cst =="900"){
		$("#divCst900").show();
	}else{
		$("#divCst900").hide();
	}
	
	$("#vUnidIPI").val(data.retorno.vUnidIPI );
	
	$("#UFST").val(data.retorno.UFST );
	$("#cBenef").val(data.retorno.cBenef );
	$("#cEAN").val(data.retorno.cEAN );
	$("#cEANTrib").val(data.retorno.cEANTrib );
	$("#cEnq").val(data.retorno.cEnq );
	$("#cProdItem").val(data.retorno.cProd );
	$("#cSelo").val(data.retorno.cSelo );
	$("#clEnq").val(data.retorno.clEnq );
	$("#cstCOFINS").val(data.retorno.cstCOFINS );
	
	$("#cstIPI").val(data.retorno.cstIPI );
	$("#cstPIS").val(data.retorno.cstPIS );
	$("#id").val(data.retorno.id );
	$("#indEscala").val(data.retorno.indEscala );
	$("#indTot").val(data.retorno.indTot );
	$("#infAdProd").val(data.retorno.infAdProd );
	$("#modBC").val(data.retorno.modBC );
	$("#modBCST").val(data.retorno.modBCST );
	$("#motDesICMS").val(data.retorno.motDesICMS );
	$("#nFCI").val(data.retorno.nFCI );
	$("#nItemPed").val(data.retorno.nItemPed );
	$("#nfe_id").val(data.retorno.nfe_id );
	$("#numero_item").val(data.retorno.numero_item );
	$("#orig").val(data.retorno.orig );
	
	$("#pBCOp").val(data.retorno.pBCOp );
	$("#pCOFINS").val(data.retorno.pCOFINS );
	$("#pCOFINSST").val(data.retorno.pCOFINSST );
	$("#pCredSN").val(data.retorno.pCredSN );
	$("#pDif").val(data.retorno.pDif );
	$("#pFCP").val(data.retorno.pFCP );
	$("#pFCPST").val(data.retorno.pFCPST );
	$("#pFCPSTRet").val(data.retorno.pFCPSTRet );
	$("#pFCPUFDest").val(data.retorno.pFCPUFDest );	
	$("#pICMSIntra").val(data.retorno.pICMSIntra );
	$("#pICMS").val(data.retorno.pICMS );
	$("#vBCICMS").val(data.retorno.vBCICMS );
	$("#pICMSEfet").val(data.retorno.pICMSEfet );
	$("#pICMSInter").val(data.retorno.pICMSInter );
	$("#pICMSInterPart").val(data.retorno.pICMSInterPart );
	$("#pICMSST").val(data.retorno.pICMSST );
	$("#pICMSUFDest").val(data.retorno.pICMSUFDest );
	$("#pIPI").val(data.retorno.pIPI );
	$("#pMVAST").val(data.retorno.pMVAST );
	$("#pPIS").val(data.retorno.pPIS );
	$("#pPISST").val(data.retorno.pPISST );
	$("#pRedBC").val(data.retorno.pRedBC );
	$("#pRedBCEfet").val(data.retorno.pRedBCEfet );
	$("#pRedBCST").val(data.retorno.pRedBCST );
	$("#pST").val(data.retorno.pST );
	$("#qBCProdConfis").val(data.retorno.qBCProdConfis );
	$("#qBCProdPis").val(data.retorno.qBCProdPis );
	
	$("#qSelo").val(data.retorno.qSelo );
	
	$("#qUnidIPI").val(data.retorno.qUnidIPI );
	$("#tipo_calc_cofins").val(data.retorno.tipo_calc_cofins );
	$("#tipo_calc_cofinsst").val(data.retorno.tipo_calc_cofinsst );
	$("#tipo_calc_ipi").val(data.retorno.tipo_calc_ipi );
	$("#tipo_calc_pis").val(data.retorno.tipo_calc_pis );
	$("#tipo_calc_pisst").val(data.retorno.tipo_calc_pisst );

	$("#vAliqProd_cofins").val(data.retorno.vAliqProd_cofins );
	$("#vAliqProd_cofinsst").val(data.retorno.vAliqProd_cofinsst );
	$("#vAliqProd_pis").val(data.retorno.vAliqProd_pis );
	$("#vAliqProd_pisst").val(data.retorno.vAliqProd_pisst );
	$("#vBCCOFINS").val(data.retorno.vBCCOFINS );
	$("#vBCEfet").val(data.retorno.vBCEfet );
	$("#vBCFCP").val(data.retorno.vBCFCP );
	$("#vBCFCPST").val(data.retorno.vBCFCPST );
	$("#vBCFCPSTRet").val(data.retorno.vBCFCPSTRet );
	$("#vBCFCPUFDest").val(data.retorno.vBCFCPUFDest );
	$("#vBCICMS").val(data.retorno.vBCICMS );
	$("#vBCIPI").val(data.retorno.vBCIPI );
	$("#vBCPIS").val(data.retorno.vBCPIS );
	$("#vBCST").val(data.retorno.vBCST );
	$("#vBCSTDest").val(data.retorno.vBCSTDest );
	$("#vBCSTRet").val(data.retorno.vBCSTRet );
	$("#vBCUFDest").val(data.retorno.vBCUFDest );
	$("#vCOFINS").val(data.retorno.vCOFINS );
	$("#vCredICMSSN").val(data.retorno.vCredICMSSN );
	
	$("#vFCP").val(data.retorno.vFCP );
	$("#vFCPST").val(data.retorno.vFCPST );
	$("#vFCPSTRet").val(data.retorno.vFCPSTRet );
	$("#vFCPUFDest").val(data.retorno.vFCPUFDest );
	
	$("#vICMS").val(data.retorno.vICMS );
	$("#vICMSDeson").val(data.retorno.vICMSDeson );
	$("#vICMSDif").val(data.retorno.vICMSDif );
	$("#vICMSEfet").val(data.retorno.vICMSEfet );
	$("#vICMSOp").val(data.retorno.vICMSOp );
	$("#vICMSST").val(data.retorno.vICMSST );
	$("#vICMSSTDest").val(data.retorno.vICMSSTDest );
	$("#vICMSSTRet").val(data.retorno.vICMSSTRet );
	$("#vICMSSubstituto").val(data.retorno.vICMSSubstituto );
	$("#vICMSUFDest").val(data.retorno.vICMSUFDest );
	$("#vICMSUFRemet").val(data.retorno.vICMSUFRemet );
	$("#vPIS").val(data.retorno.vPIS );
	$("#vPISST").val(data.retorno.vPISST );
	
	$("#vIPI").val(data.retorno.vIPI );
	
	marcarCheck('vbc_somente_produto', data.retorno.vbc_somente_produto);
	marcarCheck('vbc_frete', data.retorno.vbc_frete);
	marcarCheck('vbc_outros', data.retorno.vbc_outros);
	marcarCheck('vbc_seguro', data.retorno.vbc_seguro);
	marcarCheck('vbc_ipi', data.retorno.vbc_ipi);
	marcarCheck('vbc_desconto', data.retorno.vbc_desconto);
	
	marcarCheck('ipi_somente_produto', data.retorno.ipi_somente_produto);
	marcarCheck('ipi_frete', data.retorno.ipi_frete);
	marcarCheck('ipi_outros', data.retorno.ipi_outros);
	marcarCheck('ipi_seguro', data.retorno.ipi_seguro);
	marcarCheck('ipi_desconto', data.retorno.ipi_desconto);
	
	marcarCheck('pis_somente_produto', data.retorno.pis_somente_produto);
	marcarCheck('pis_frete', data.retorno.pis_frete);
	marcarCheck('pis_ipi', data.retorno.pis_ipi);
	marcarCheck('pis_outros', data.retorno.pis_outros);
	marcarCheck('pis_seguro', data.retorno.pis_seguro);
	marcarCheck('pis_desconto', data.retorno.pis_desconto);
	
	marcarCheck('cofins_somente_produto', data.retorno.cofins_somente_produto);
	marcarCheck('cofins_frete', data.retorno.cofins_frete);
	marcarCheck('cofins_ipi', data.retorno.cofins_ipi);
	marcarCheck('cofins_outros', data.retorno.cofins_outros);
	marcarCheck('cofins_seguro', data.retorno.cofins_seguro);
	marcarCheck('cofins_desconto', data.retorno.cofins_desconto);
	
	marcarCheck('cst900_icms', data.retorno.cst900_icms);
	marcarCheck('cst900_redbc', data.retorno.cst900_redbc);
	marcarCheck('cst900_credisn', data.retorno.cst900_credisn);
	marcarCheck('cst900_st', data.retorno.cst900_st);
	marcarCheck('cst900_redbcst', data.retorno.cst900_redbcst);
	
	$("#id").val(data.retorno.id);

}

function limparDadosItem(){
	$("#produto").val("");
	$("#unidade").val("");
	$("#preco").val("");
	$("#qtde").val("");
	$("#subtotal").val("");
	$("#val_desconto").val("0");
	$("#total_item").val("");
	$("#id_produto").val("");
	$("#desconto").val("");
}