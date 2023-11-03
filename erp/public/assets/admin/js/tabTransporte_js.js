  function salvarTransportadora(){
    $.ajax({
         url: base_url + "notafiscal/salvatransportadora/",
         type: "post",
         dataType:"Json",
         data:{
        	 id_nfe      	: id_nfe ,
        	 transp_cnpj	: $("#transp_cnpj").val() ,
        	 transp_xnome	: $("#transp_xnome").val(),
        	 transp_ie		: $("#transp_ie").val(),
        	 transp_xender	: $("#transp_xender").val(),
        	 transp_uf		: $("#transp_uf").val(), 
        	 transp_mun		: $("#transp_mun").val()
         },
         success: function(data){
        	 if(data=="ok"){
                 $("#mascara").hide();
                 $(".window").hide(); 
                 
             }
         },
         beforeSend: function(){           
            tela("#carregar"); 
        }
         
     });   
 } 

 function salvarTransporte(){
    $.ajax({
         url: base_url + "notafiscal/salvatransporte/",
         type: "post",
         dataType:"Json",
         data:{
        	 id_nfe      	: id_nfe ,
			 modfrete		: $("#modfrete").val(),
        	 transp_placa	: $("#transp_placa").val(),
        	 transp_ufveic	: $("#transp_ufveic").val(), 
        	 transp_rntc	: $("#transp_rntc").val(),        
        	 transp_vagao	: $("#transp_vagao").val() ,
        	 transp_balsa	: $("#transp_balsa").val(),
        	 
        	 ret_tran_vserv	: $("#ret_tran_vserv").val(),
        	 ret_tran_vbc	: $("#ret_tran_vbc").val(),
        	 ret_tran_pcims	: $("#ret_tran_pcims").val(),
        	 ret_tran_vicms	: $("#ret_tran_vicms").val(),
        	 ret_tran_cfop	: $("#ret_tran_cfop").val(),
        	 ret_tran_cmunfg: $("#ret_tran_cmunfg").val(),
        	 
        	 vol_qtde		: $("#vol_qtde").val(),
        	 vol_especie	: $("#vol_especie").val(),
        	 vol_marca		: $("#vol_marca").val(),
        	 vol_numeraco	: $("#vol_numeraco").val(),     
        	 vol_peso_liq	: $("#vol_peso_liq").val(),
        	 vol_peso_bruto	: $("#vol_peso_bruto").val(),
        	 vol_lacre		: $("#vol_lacre").val()
         },
         success: function(data){
        	 if(data=="ok"){
                 $("#mascara").hide();
                 $(".window").hide();                  
             }
         },
         beforeSend: function(){           
            tela("#carregar"); 
        }
         
     });   
 } 
 
function listarTransportadora(){		
 $.ajax({
	  url: base_url + "admin/transportadora/lista/",
	  type: "GET",
	  dataType: "json",
	  data:{},
	  success: function (data){
		  fecharGiraGira(eh_modal);
		  	html = "<tr>";
			for(var i in data){
				html += '<td align="center">' + data[i].id + '</td>' +
		        	'<td align="center">' + data[i].razao_social + '</td>' +					 	
		        	'<td align="center">' + data[i].cnpj + '</td>' +
               		'<td><a href="javascript:;" onclick="selecionar_transportadora('+ data[i].id +')"  class="d-inline-block btn btn-verde btn-pequeno" title="Selecionar">Selecionar</a></td></tr>'

			} 

		  $("#lista_de_transoportadoras").html(html);
		  abrirModal('#janela_transportadora');		  
	  },
	  beforeSend: function () {
		giraGira();
     },
  });
	
}

 function selecionar_transportadora(id_transportadora){
	    $.ajax({
	         url: base_url + "admin/transportadora/selecionarTransportadora/"+ id_transportadora + "/"+ id_nfe ,
	         type: "get",
	         dataType:"Json",
	         success: function(data){
	            populaFornecedor(data);
				//salvarTransportadora();
	            fecharModal();
	         },
	         beforeSend: function(){           
	            giraGira(); 
	        }         
	     });   
	 } 
 
function populaFornecedor(data){
     $("#transp_xNome").val(data.transp_xNome);
     $("#transp_CNPJ").val(data.transp_CNPJ);
     $("#transp_IE").val(data.transp_IE);
     $("#transp_xEnder").val(data.transp_xEnder);
	 $("#transp_xMun").val(data.transp_xMun);
	 $("#transp_UF").val(data.transp_UF) ;  

	 $("#transp_placa").val(data.transp_placa) ;  
	 $("#UF_placa").val(data.UF_placa) ;  
	 $("#RNTC").val(data.RNTC) ;
	 $("#transp_vagao").val(data.transp_vagao) ;  
	 $("#transp_balsa").val(data.transp_balsa) ;  

	 $("#vol_qtde").val(data.qVol) ;  
	 $("#vol_especie").val(data.esp) ;  
	 $("#vol_marca").val(data.marca) ;
	 $("#vol_numeraco").val(data.nVol) ;  
	 $("#vol_peso_liq").val(data.pesoL) ;
	 $("#vol_peso_bruto").val(data.pesoB) ;
	 $("#vol_lacre").val(data.nLacre) ;
 }
 
 function selecionarModFrete(){
	var modFrete = $("#modFrete").val();
	if(modFrete == "9"){
		limparFornecedor();
	}
}
 function limparFornecedor(){
     $("#transp_xNome").val("");
     $("#transp_CNPJ").val("");
     $("#transp_IE").val("");
     $("#transp_xEnder").val("");
	 $("#transp_xMun").val("");
	 $("#transp_UF").val("") ;  

	 $("#transp_placa").val("") ;  
	 $("#UF_placa").val("") ;  
	 $("#RNTC").val("") ;
	 $("#transp_vagao").val("") ;  
	 $("#transp_balsa").val("") ;  

	 $("#vol_qtde").val("") ;  
	 $("#vol_especie").val("") ;  
	 $("#vol_marca").val("") ;
	 $("#vol_numeraco").val("") ;  
	 $("#vol_peso_liq").val("") ;
	 $("#vol_peso_bruto").val("") ;
	 $("#vol_lacre").val("") ;
 }
