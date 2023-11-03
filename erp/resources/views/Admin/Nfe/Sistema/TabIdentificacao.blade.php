
<fieldset class="mt-4">
<legend class="h5 mb-0 text-left">Informações básicas</legend>
<div class="rows p-2">
		 <div class="col-3 mb-3">
                <label class="text-label">Natureza Operação</label>	
                <input type="text" readonly value="{{ $notafiscal->natOp ?? null }}"  class="form-campo">  
		</div>

		
          <div class="col-6  mb-3">
                <label class="text-label">Presença do comprador</label>
                <select class="form-campo" name="indPres" id="indPres">
                    <option value="0" {{ (($notafiscal->indPres ?? null) == "0") ? "selected" : null }}>0 - NÃO SE APLICA</option>
                    <option value="1" {{ (($notafiscal->indPres ?? null) == "1") ? "selected" : null }}>1 - OPERAÇÃO PRESENCIAL</option>
                    <option value="2" {{ (($notafiscal->indPres ?? null) == "2") ? "selected" : null }}>2 - OPERAÇÃO NÃO PRESENCIAL, PELA INTERNET</option>
                    <option value="3" {{ (($notafiscal->indPres ?? null) == "3") ? "selected" : null }}>3 - OPERAÇÃO NÃO PRESENCIAL, TELEATENDIMENTO</option>
                    <option value="5" {{ (($notafiscal->indPres ?? null) == "5") ? "selected" : null }}>5 - OPERAÇÃO PRESENCIAL, FORA DO ESTABELECIMENTO</option>
                    <option value="9" {{ (($notafiscal->indPres ?? null) == "9") ? "selected" : null }}>9 - OPERAÇÃO NÃO PRESENCIAL, OUTROS</option> 
                </select>
        </div> 
		
				           
		<div class="col-2 mb-3">
            <label class="text-label">Versão </label>	
            <input type="text" name="verProc" id="verProc" value="{{ $notafiscal->verProc?? null }}"  class="form-campo">
        </div>
        
        <div class="col-3 mb-3">
                <label class="text-label">Ambiente</label>	
                <select class="form-campo" name="tpAmb" id="tpAmb">
                        <option value="1" {{ (($notafiscal->tpAmb ?? null) == "1") ? "selected" : null }}>Produção</option>
                        <option value="2" {{ (($notafiscal->tpAmb ?? null) == "2") ? "selected" : null }}>Homologação</option>                                                 

                </select>
        </div>
        <div class="col-3 mb-3">
                <label class="text-label">Finalidade da emissão</label>	
                <select class="form-campo" name="finNFe" id="finNFe" onclick="verDocReferenciado()">
                    <option value="1" {{ (($notafiscal->finNFe ?? null) == "1") ? "selected" : null }}>1 - NORMAL</option>
                    <option value="2" {{ (($notafiscal->finNFe ?? null) == "2") ? "selected" : null }}>2 - COMPLEMENTAR</option>
                    <option value="3" {{ (($notafiscal->finNFe ?? null) == "3") ? "selected" : null }}>3 - DE AJUSTE</option>
                    <option value="4" {{ (($notafiscal->finNFe ?? null) == "4") ? "selected" : null }}>4 - DEVOLUÇÃO DE MERCADORIA</option>
                </select>
          </div>
          
          <div class="col-2 mb-3">
                <label class="text-label">Consumidor final</label>	
                <select class="form-campo" name="indFinal" id="indFinal">
                        <option value="0" {{ (($notafiscal->indFinal ?? null) == "0") ? "selected" : null }}>0 - NÃO</option>
                        <option value="1" {{ (($notafiscal->indFinal ?? null) == "1") ? "selected" : null }}>1 - SIM</option>
                </select>
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
                <div class="col-4 mb-3" style="display: none" id="divChave">
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
    
