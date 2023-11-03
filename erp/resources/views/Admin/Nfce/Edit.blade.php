@extends("Admin.template")
@section("conteudo")
  <script>
        var id_nfce = "<?php echo $notafiscal->id?>";
        var natureza_operacao_id  = "<?php echo $notafiscal->natureza_operacao_id ?>";
    </script>

<section class="col-12 central mb-3">	
<form action="{{route('admin.notafiscal.salvar')}}" method="post">
@csrf
	<div class="">
	 <div class="caixa">
				    <?php  $tem_venda = $notafiscal->venda_id ? 1 : -1   ;?>
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
                            <span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Nota Num: <span class="text-orange"><?php echo $notafiscal->id ?></span></span>
                   <div>
            			<a href="{{route('admin.notafiscal.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
            			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>		
            			<a href="{{route('admin.notafiscal.edicaoLivre',$notafiscal->id)}}" class=" btn btn-verde btn-pequeno ml-1 d-inline-block"> Edição Livre </a>
            			<a href="{{route('admin.nfe.simularDanfe',$notafiscal->id)}}" target="_blank"  class=" btn btn-roxo btn-pequeno ml-1 d-inline-block"> Espelho da Nota </a>            			
            			<a href="javascript:;" onclick="transmitirNfce({{$notafiscal->id}})" class=" btn btn-roxo btn-pequeno ml-1 d-inline-block"> Transmitir NFCE </a>            			
            		</div> 
                    </div>

				<div class="rows">	
                <div class="col-12">               
                <div class="p-2 pb-0 pt-4 width-100 float-left">
					<div id="tab" style="padding:0!important">
                         <ul class="tabs">
                                <li><a href="#tab-1">Dados gerais</a></li>
                                <li><a href="#tab-2">Emitente</a></li>
                                <li><a href="#tab-3">Destinatário</a></li>
                                <li><a href="#tab-4">Produtos</a></li>
                                <li><a href="#tab-5">Totalizadores</a></li>
                                <li><a href="#tab-6">Cobrança</a></li>
                                <li><a href="#tab-7">Adicionais</a></li>
                                <li><a href="#tab-8">Referenciado</a></li>
                                <li><a href="#tab-9">Xml</a></li>
                        </ul>
                        <script src="{{asset('assets/admin/js/js_nfe.js')}}"></script>
                        <script src="{{asset('assets/admin/js/tabTransporte_js.js')}}"></script>	
                        <script src="{{asset('assets/admin/js/tabAutorizado_js.js')}}"></script>
                        <script src="{{asset('assets/admin/js/tabProduto_js.js')}}"></script>	
                        <script src="{{asset('assets/admin/js/tabDuplicata_js.js')}}"></script>
                        <script src="{{asset('assets/admin/js/tabPagamento_js.js')}}"></script>
                        <script src="{{asset('assets/admin/js/tabReferenciado_js.js')}}"></script>
                        
                        		        
		
				<div id="tab-1" class="cx-tab">                                        
					@include("Admin.Nfce.TabIdentificacao")
				</div>
				
				<div id="tab-2" class="cx-tab">          
					@include("Admin.Nfce.TabEmitente")
				</div> 
				
				<div id="tab-3" class="cx-tab">          
					@include("Admin.Nfce.TabDestinatario")
				</div> 
			
				<div id="tab-4" class="cx-tab">									
					@include("Admin.Nfce.TabProduto")
				</div>
							
				<div id="tab-5" class="cx-tab">									
					@include("Admin.Nfce.TabTotalizadores")			
				</div>
  

				<div id="tab-6" class="cx-tab">									
					@include("Admin.Nfce.TabCobranca")	
				</div> 
				
				<div id="tab-7" class="cx-tab">									
					@include("Admin.Nfce.TabAdicionais")	
				</div>
				
				<div id="tab-8" class="cx-tab">									
					@include("Admin.Nfce.TabReferenciado")	
				</div>  
				
				<div id="tab-9" class="cx-tab">									
					@include("Admin.Nfce.TabXml")	
				</div>
				  
			
				</div>            
		</div>

    <div class="d-inline-block width-100 mb-5 mt-0" style="clear:both">
        <input type="hidden" name="id_nfce" value="<?php echo $notafiscal->id ?>">
        <input type="submit" value="Salvar Nota"   class="btn btn-azul d-block m-auto">
        
    </div>
    </div>


    </div>
    </div>
</div>
</form>
</section>
        @include ("Admin.Nfe.janela.salvar_produto")
        @include ("Admin.Nfe.janela.lista_generica")
        @include ("Admin.Nfe.janela.create_duplicata")  
        @include ("Admin.Nfe.janela.detalhe_produto")
        @include ("Admin.Nfe.janela.modalDetalhesItemNota")        
		@include ("Admin.Cadastro.Produto.modal.modalCadastroProduto")
 
 <div class="window medio" id="modal_transferirNfe">
	<div class="titulo d-flex justify-content-space-between"><b id="titulo_erro">Transferir NFE</b> </div>
	<div class="p-2 text-center mt-2">
    	<div id="gira_gira_transferir">
    		<img src="{{asset('assets/admin/img/load2.gif')}}" width="60" class="m-auto">
    		<span class="text-cinza d-block mt-2 mb-2"> Aguarde Enviando...</span>
    	</div>    	
		 
		<span class="msg msg-vermelho p-1" id="div_erro_transferir" >
			<i class="fas fa-bug"></i> <b id="mensagem_erro_transferir"></b>
		</span>
		
		<div class="tfooter center" >
    		<a href="javaScript:;" onclick="fecharModal()" class="btn btn-vermelho btn-pequeno">Fechar</a>
    	</div>
	</div>
</div>
  
  <div class="window pdv medio" id="telaImprimirDanfe">	
	<div class="caixa mb-0 p-0">
	<span class="d-block text-center titulo pb-2 pt-2 h4 border-bottom mb-2 text-verde"><i class="fas fa-check"></i> Nfe Gerada Sucesso</span>
	<div class="p-2">
		<p class="h4 text-escuro text-center"><i class="fas fa-print"></i> Deseja imprimir o DANFE ?</p>							
	</div>
	<div class="tfooter center py-3">
		<a href="javascript:;" onclick="imprimirDanfe()" class="btn btn-verde"><i class="fas fa-check"></i> Sim</a>							
		<a href="{{route('admin.notafiscal.index')}}"  class="btn btn-vermelho ml-1"><i class="fas fa-times"></i> Não</a>							
	</div>	
</div>
</div>
  
  <div class="window medio" id="modal_nfe_selecionar">
	<div class="p-2 px-4">
			<span class="pt-4 d-block h3 border-bottom fw-700">Transmitir NFE</span>
		<div class="rows">
             <div class="col-12 mb-3">
                   <span class="text-label fw-700 h5 mb-1">Selecione as opções desejadas</span>
                    <div class="width-100 border radius-4">
                        <div class="check radio p-4 d-block">							
        					<label class="d-flex mb-1"><input type="checkbox"  id="lancar_estoque" name="lancar_estoque" value="S"> Lançar estoque</label>
        					<label class="d-flex mb-1"><input type="checkbox"  id="lancar_financeiro" name="lancar_financeiro" value="S" > Gerar Financeiro</label>
        				</div>
        				
    				</div>
    				  
             </div>                                 
         </div>
		 <div class="tfooter border-0 between">
		 <div>
			<a href="" class="btn btn-vermelho fechar">Fechar</a>
		 </div>
		 
			<div class="d-flex">
				<a href="javascript:;" onClick="transmitirNfce({{$notafiscal->id}})" class="btn btn-verde border-bottom" >Transmitir NFE</a>
		 </div>
		</div> 
	</div>
</div>
   
 <script>
 function abrirModalTransmitirNfe(tem_venda){
 	if(tem_venda =="-1"){
 		abrirModal("#modal_nfe_selecionar");
 	}else{
 		transmitirNfe()
 	}
 }
 
  function transmitirNfce(id){
	$("#gira_gira_transferir").show();
	$("#div_erro_transferir").hide();
	$("#mensagem_erro_transferir").html(" ");
	abrirModal('#modal_transferirNfe');
	$.ajax({
	   url: base_url + "admin/nfce/transmitirJs/" + id,
	   type: "GET",
	   dataType: "json",
	   data:{},
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


function simularNfce(){	
	giraGira();
	window.open(base_url + 'admin/nfe/simularDanfce/'+id_nfce, '_blank');
	location.href= base_url + 'admin/notanfce/notanfce/'+id_nfce;	
}

function baixarXmlDemo(){	
	giraGira();
	window.open(base_url + 'admin/nfe/verXMLNormal/'+id_nfce, '_blank');
	location.reload();	
}

function imprimirDanfce(){	
	giraGira();
	window.open(base_url + 'admin/nfce/danfce/'+id_nfce, '_blank');
	location.href= base_url + 'admin/notanfce';	
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