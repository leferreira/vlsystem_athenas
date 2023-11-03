
$(function(){

});

function salvar(){	 
	let identificacao = {
        indPres				: $("#indPres").val(), 
		verProc				: $("#verProc").val(),       
        tpAmb				: $("#tpAmb").val() ,
        finNFe				: $("#finNFe").val(),
        indIntermed			: $("#indIntermed").val(),
        cnpjIntermed		: $("#cnpjIntermed").val(),
		idCadIntTran		: $("#idCadIntTran").val(),
        tipo_nota_referenciada : $("#tipo_nota_referenciada").val(), 
		ref_NFe 			: $("#ref_NFe").val(),
		ref_ano_mes 		: $("#ref_ano_mes").val(),
		ref_num_nf 			: $("#ref_num_nf").val(),
		ref_serie 			: $("#ref_serie").val(),		
		modfrete			: $("#modfrete").val(), 
		infadfisco			: $("#infadfisco").val() ,
    	infcpl				: $("#infcpl").val(),
		tPag				: $("#tPag").val(),
		indPag				: $("#indPag").val(),
		
		     
	}
	let destinatario = {
		xNomeDestinatario   :$("#xNomeDestinatario").val(),
        indIEDest     		:$("#indIEDest").val(), 
        IEDestinatario    	:$("#IEDestinatario").val(),
        ISUFDestinatario    :$("#ISUFDestinatario").val(),
        IMDestinatario    	:$("#IMDestinatario").val(),
        emailDestinatario   :$("#emailDestinatario").val(),
        CNPJDestinatario    :$("#CNPJDestinatario").val(),   
		CPFDestinatario     :$("#CPFDestinatario").val(),     
        idEstrangeiro   	:$("#idEstrangeiro").val(),
        CEPDestinatario    	:$("#CEPDestinatario").val(),
        
        xLgrDestinatario    :$("#xLgrDestinatario").val(),
        nroDestinatario    	:$("#nroDestinatario").val(),
        xCplDestinatario    :$("#xCplDestinatario").val(),
        xBairroDestinatario :$("#xBairroDestinatario").val(),
        xMunDestinatario    :$("#xMunDestinatario").val(),
		cMunDestinatario    :$("#cMunDestinatario").val(),
        UFDestinatario    	:$("#UFDestinatario").val(),
	}
	
	let transporte = {
		transp_xNome	: $("#transp_xNome").val(),
		transp_CNPJ		: $("#transp_CNPJ").val(),
		transp_IE		: $("#transp_IE").val(),
		transp_xEnder	: $("#transp_xEnder").val(),
		transp_xMun		: $("#transp_xMun").val(),
		transp_UF		: $("#transp_UF").val(),
		
		
    	 transp_placa	: $("#transp_placa").val(),
    	 transp_ufveic	: $("#transp_ufveic").val(), 
    	 transp_rntc	: $("#transp_rntc").val(),        
    	 transp_vagao	: $("#transp_vagao").val() ,
    	 transp_balsa	: $("#transp_balsa").val(),
    	 
    	 /*ret_tran_vserv	: $("#ret_tran_vserv").val(),
    	 ret_tran_vbc	: $("#ret_tran_vbc").val(),
    	 ret_tran_pcims	: $("#ret_tran_pcims").val(),
    	 ret_tran_vicms	: $("#ret_tran_vicms").val(),
    	 ret_tran_cfop	: $("#ret_tran_cfop").val(),
    	 ret_tran_cmunfg: $("#ret_tran_cmunfg").val(),*/
    	 
    	 vol_qtde		: $("#vol_qtde").val(),
    	 vol_especie	: $("#vol_especie").val(),
    	 vol_marca		: $("#vol_marca").val(),
    	 vol_numeraco	: $("#vol_numeraco").val(),     
    	 vol_peso_liq	: $("#vol_peso_liq").val(),
    	 vol_peso_bruto	: $("#vol_peso_bruto").val(),
    	 vol_lacre		: $("#vol_lacre").val()		
	}
	
	
    $.ajax({
         url: base_url + "admin/notafiscal/salvar",
         type: "post",
         dataType:"Json",
         data:{
        	id_nfe        : id_nfe ,
            identificacao : identificacao,	
			destinatario  : destinatario,
			transporte	  : transporte
         },
         success: function(data){
        	 console.log(data);
             fecharTela();
         },
         beforeSend: function(){           
            giraGira(); 
        }
         
     });
   
 } 




  


