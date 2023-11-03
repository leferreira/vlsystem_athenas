<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")


<section class="col-12 central mb-3">	
	<div class="">
	 <div class="caixa">
        <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
                <span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Nota NFE <span class="text-orange"></span></span>
        </div>
                    
	<form action="{{route('admin.notafiscal.criarNota')}}" method="post">
	@csrf
				<div class="rows">	
                <div class="col-12">               
                <div class="p-2 pb-0 pt-4 width-100 float-left">
					<div id="tab" style="padding:0!important">                                               
                        <script src="{{asset('assets/admin/js/js_nfe.js')}}"></script>			        
		
				<div id="tab-1" class="cx-tab">   
				<fieldset class="mt-4">
            <legend class="h5 mb-0 text-left">Informações básicas</legend>
            <div class="rows p-2">
            		
                  <div class="col-4 mb-3">
                     <label class="text-label">Natureza Operação<span class="text-vermelho">*</span></label>
						<div class="group-btn">
                            <select class="form-campo" name="natureza_operacao_id" id="natureza_operacao_id">
                            @foreach($naturezas as $natureza)
                                <option value="{{$natureza->id}}" >{{$natureza->descricao}}</option>
                            @endforeach
                            </select>
							<a href="{{route('admin.naturezaoperacao.create')}}" target="_blank"  class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova Natureza"></a>
						</div> 
                    </div>                    
                    
						
                    <div class="col-4 position-relative mb-3">
						<label class="text-label">Cliente<span class="text-vermelho">*</span></label>
						<div class="group-btn">	  
							<input type="text" name="clientePesquisado" id="clientePesquisado" class="form-campo">
							<input type="hidden" name="cliente_id" id="cliente_id" class="form-campo">
							<a href="{{route('admin.cliente.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
						</div>											
					</div>
				
                  <div class="col-1 mb-3">
                    <label class="text-label">Versão </label>	
                    <input type="text" name="verProc" id="verProc" value="1.0"  class="form-campo">
                </div>
           
          
        
        </div>
</fieldset>
 <fieldset class="mt-4" style="display: none" id="docReferenciado">
                        <legend class="h5 mb-0 text-left">Documento Referenciado</legend>
                        <div class="rows p-2">
                        		 <div class="col-4 mb-3" id="ver_combo_notar_refereciada">
                                    <label class="text-label">Tipo de nota referenciada</label>	
                                    <select class="form-campo" name="tipo_nota_referenciada" id="tipo_nota_referenciada" onchange="ver_tipo_nota_referenciada()">
                                        <option value="">Selecione</option>
                                        <option value="1">Nfe ou Nfce (Mod 55 ou 65)</option>
                                        <option value="2">Cupom Fiscal(ECF - modelo 2D)</option>
                                        <option value="3">Nota Fiscal (talão - modelo 01)</option>
                                        <option value="4">Nota Fiscal de Consumidor (talão - modelo 02)</option>
                                        <option value="5">Nota Fiscal de Produtor (talão - modelo 01)</option>
                                        <option value="6">Nota Fiscal de Produtor (talão - modelo 04)</option>
                                        <option value="7">CTe (modelo 57)</option>
                                    </select>
                                    </div>
                                    <div class="col-4 mb-3" style="display: none" id="divChave" >
                                        <label class="text-label" id="lblChave">Chave de acesso</label>	
                                        <input type="text" class="form-campo" name="ref_NFe" id="ref_NFe"  autocomplete="off"/>
                                    </div>
                                    <div class="col-3 mb-3"  style="display: none" id="divDataEmissao">
                                        <label class="text-label" id="lblMesAno">Ano e mês da emissão (AAMM)</label>
                                        <input type="text" class="form-campo" name="ref_ano_mes" id="ref_ano_mes" autocomplete="off"/>
                                    </div>
                                    <div class="col-3 mb-3"  style="display: none" id="divNumeroNota">
                                        <label class="text-label" id="lblNumero">Número </label>
                                        <input type="text" class="form-campo" name="ref_num_nf" id="ref_num_nf" autocomplete="off"/>
                                    </div>
                                     <div class="col-2 mb-3"  style="display: none" id="divSerieNota">
                                        <label class="text-label" id="lblSerie">Série </label>
                                        <input type="text" class="form-campo" name="ref_serie" id="ref_serie"  autocomplete="off"/>
                                    </div>
                            
                         </div>
                    </fieldset>
                  
                        
                       <fieldset class="mt-4">
                        <legend class="h5 mb-0 text-left">Intermediador</legend>
                        <div class="rows p-2">		
                        		 
                        		
                        		<div class="col-4 mb-3">
                                            <label class="text-label">Indicador de Intermediador</label>	
                                            <select class="form-campo" name="indIntermed" id="indIntermed" >
                                                    <option value="0" {{ (($notafiscal->indIntermed ?? null) == "0") ? "selected" : null  }}>0 - Operação sem intermediador </option>
                                                    <option value="1" {{ (($notafiscal->indIntermed ?? null) == "1") ? "selected" : null  }}>1 - Operação em site ou plataforma de terceiros</option>
                                            </select>
                        		</div>	
                        	           
                        		<div class="col-4 mb-3">
                                    <label class="text-label">CNPJ </label>	
                                    <input type="text" name="cnpjIntermed" id="cnpjIntermed" value="{{ $notafiscal->cnpjIntermed ?? null }}"  class="form-campo">
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="text-label">Identificação do Intermediador </label>	
                                    <input type="text" name="idCadIntTran" id="idCadIntTran" value="{{ $notafiscal->idCadIntTran ?? null }}"  class="form-campo">
                                </div>
                         </div>
                        </fieldset>                       
                       
				</div>		
			
			
				</div>            
			</div>

            <div class="d-inline-block width-100 mb-5 mt-0" style="clear:both">
                <input type="submit" value="Salvar NOTA" class="btn btn-azul d-block m-auto">
            </div>
            </div>
        
        
            </div>
    </form>
    </div>
</div>
 @include ("Admin.Cadastro.Cliente.modal.modalCadastroCliente")
</section>
<!--carregar modal-->
<script>
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