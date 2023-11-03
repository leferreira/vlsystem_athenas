@extends("Admin.template")
@section("conteudo")
  <script>
        var id_nfe = "<?php echo $notafiscal->id?>";
        var natureza_operacao_id  = "<?php echo $notafiscal->natureza_operacao_id ?>";
    </script>

<section class="col-12 central mb-3">	
<form action="{{route('admin.notafiscal.salvar')}}" method="post">
@csrf
	<div class="">
	 <div class="caixa">
				    <?php  $tem_venda = ($notafiscal->venda_id) || ($notafiscal->loja_pedido_id)  ? 1 : -1   ;?>
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
                            <span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Nota Num: <span class="text-orange"><?php echo $notafiscal->id ?></span></span>
                   <div>
            			<a href="{{route('admin.nfeentrada.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
            			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>		
            		</div> 
                    </div>

				<div class="rows">	
                <div class="col-12">               
                <div class="p-2 pb-0 pt-4 width-100 float-left">
					<div id="tab" style="padding:0!important">
                         <ul class="tabs">
                                <li><a href="#tab-1">Dados gerais</a></li>
                                <li><a href="#tab-2">Emitente</a></li>
                                <li><a href="#tab-3">Produtos</a></li>
                                <li><a href="#tab-4">Totalizadores</a></li>
                                <li><a href="#tab-5">Transporte</a></li>
                                <li><a href="#tab-6">Cobrança</a></li>
                                <li><a href="#tab-7">Adicionais</a></li>
                        </ul>
                        <script src="{{asset('assets/admin/js/js_nfe.js')}}"></script>
                        <script src="{{asset('assets/admin/js/tabTransporte_js.js')}}"></script>	
                        <script src="{{asset('assets/admin/js/tabAutorizado_js.js')}}"></script>
                        <script src="{{asset('assets/admin/js/tabProduto_js.js')}}"></script>	
                        <script src="{{asset('assets/admin/js/tabDuplicata_js.js')}}"></script>
                        <script src="{{asset('assets/admin/js/tabPagamento_js.js')}}"></script>
                        <script src="{{asset('assets/admin/js/tabReferenciado_js.js')}}"></script>
                        
                        		        
		
				<div id="tab-1" class="cx-tab">                                        
					@include("Admin.Compra.Nfe.NotaEntrada.TabIdentificacao")
				</div>
				
				<div id="tab-2" class="cx-tab">          
					@include("Admin.Compra.Nfe.NotaEntrada.TabEmitente")
				</div> 
			
				<div id="tab-3" class="cx-tab">									
					@include("Admin.Compra.Nfe.NotaEntrada.TabProduto")
				</div>
							
				<div id="tab-4" class="cx-tab">									
					@include("Admin.Compra.Nfe.NotaEntrada.TabTotalizadores")			
				</div>

				<div id="tab-5" class="cx-tab">		
					@include("Admin.Compra.Nfe.NotaEntrada.TabTransporte")			   
				</div>  

				<div id="tab-6" class="cx-tab">									
					@include("Admin.Compra.Nfe.NotaEntrada.TabCobranca")	
				</div> 
				
				<div id="tab-7" class="cx-tab">									
					@include("Admin.Compra.Nfe.NotaEntrada.TabAdicionais")	
				</div>			  
				
				  
			
				</div>            
		</div>

  
    </div>


    </div>
    </div>
</div>
</form>
</section>
 


  

   
 <script>
 function abrirModalTransmitirNfe(tem_venda){
 	if(tem_venda =="-1"){
 		abrirModal("#modal_nfe_selecionar");
 	}else{
 		transmitirNfe()
 	}
 }
 
 function transmitirNfe(){
 	var gerar_nota = $("input[name='lancar_nota']:checked").val();	
	var natureza_operacao_id = $("#natureza_operacao_id").val();
	
 	fecharModal();
	$("#gira_gira_transferir").show();
	$("#div_erro_transferir").hide();
	$("#mensagem_erro_transferir").html(" ");
	abrirModal('#modal_transferirNfe');
	$.ajax({
	   url: base_url + "admin/nfe/transmitirJs/" + id_nfe,
	   type: "GET",
	   dataType: "json",
	   data:{
	   		"gerar_estoque": $("input[name='lancar_estoque']:checked").val(),
			"gerar_financeiro": $("input[name='lancar_financeiro']:checked").val(),},
		 success: function(data){		
		 	 $("#gira_gira_transferir").hide();
		 	 if(data.tem_erro==true){		 
		 	 	$("#div_erro_transferir").show();
		 	 	$("#mensagem_erro_transferir").html(data.erro);
		 	 }
		 	 
		 	  if(data.tem_erro==false){
		 	 	abrirModal('#telaImprimirDanfe');
		 	 }
		}, error: function (e) {
			var response = e.responseText;	
			console.log(response.erro);			
		}		
	});	
}

function simularNfe(){	
	giraGira();
	window.open(base_url + 'admin/nfe/simularDanfe/'+id_nfe, '_blank');
	location.href= base_url + 'admin/notafiscal/edit/'+id_nfe;	
}

function baixarXmlDemo(){	
	giraGira();
	window.open(base_url + 'admin/nfe/verXMLNormal/'+id_nfe, '_blank');
	location.reload();	
}

function imprimirDanfe(){	
	giraGira();
	window.open(base_url + 'admin/nfe/imprimirDanfePelaNfe/'+id_nfe, '_blank');
	location.href= base_url + 'admin/notafiscal';	
}
 function ver_tipo_nota_referenciada(){
  	 var tipo 	= $("#tipo_nota_referenciada").val();  
     var chave 	= $("#divChave");
     var ano_mes= $("#divDataEmissao");
     var num_nf = $("#divNumeroNota");
     var serie  = $("#divSerieNota");
     
     $("#ref_NFe").val(" ");
     $("#ref_ano_mes").val(" ");
     $("#ref_num_nf").val(" ");
     $("#ref_serie").val(" ");
     
     chave.hide();
     ano_mes.hide();
     num_nf.hide();
     serie.hide(); 
     
     
     
    if(tipo==1 || tipo==7){
    	$("#lblChave").html("Chave de Acesso");
    	chave.show();
    	chave.val(" ");
        ano_mes.hide();
     	num_nf.hide();
     	serie.hide();    
    
    }else if(tipo==2 ){
    	$("#lblChave").html("Número do Contador de Ordem de Operação - COO");
    	chave.show();
        ano_mes.hide();
     	num_nf.hide();
     	serie.hide();
    }else if(tipo==3 || tipo==4 || tipo==5 || tipo==6){
    	$("#lblChave").html("");
    	chave.hide();
        ano_mes.show();
     	num_nf.show();
     	serie.show();
    }
}

function verDocReferenciado(){
	var finNFe = $('#finNFe').val();
	if(finNFe!= 1 ){
		$('#docReferenciado').show();
	}else{
		$('#docReferenciado').hide();
	}
}
 </script>
@endsection