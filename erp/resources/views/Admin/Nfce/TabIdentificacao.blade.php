
<fieldset class="mt-4">
<legend class="h5 mb-0 text-left">Informações básicas</legend>
<div class="rows p-2">
		<div class="col-1 mb-3">
                <label class="text-label">Num NFe </label>	
                <input type="text" name="nNF" id="nNF" value="{{ $notafiscal->nNF ?? null}}"   class="form-campo">
    	</div>
		<div class="col-1 mb-3">
				<label class="text-label">Série </label>	
				<input type="text" name="serie" id="serie" value="{{ $notafiscal->serie ?? null }}"  class="form-campo">
		</div>
		<div class="col-1 mb-3">
				<label class="text-label">cUF </label>	
				<input type="text" name="cUF" id="cUF" value="{{ $notafiscal->cUF ?? null }}"  class="form-campo">
		</div>
		 <div class="col-4 mb-3">
                <label class="text-label">Natureza Operação</label>	
                <input type="text" name="natOp" id="natOp"  readonly value="{{ $notafiscal->natOp ?? null }}"  class="form-campo">  
		</div>
		<div class="col-1 mb-3">
				<label class="text-label">Modelo </label>	
				<input type="text" name="modelo" id="modelo" value="{{ $notafiscal->modelo ?? null }}"  class="form-campo">
		</div>
		<div class="col-2 mb-3">
				<label class="text-label">cMunFG </label>	
				<input type="text" name="cMunFG" id="cMunFG" value="{{ $notafiscal->cMunFG ?? null }}"  class="form-campo">
		</div>
		<div class="col-2 mb-3">
            <label class="text-label">Destino Operação</label>	
            <select class="form-campo" name="idDest" id="idDest" >
                    <option value="1" {{ (($notafiscal->idDest ?? null) == "1") ? "selected" : null  }}>1 - Operação Interna</option>
                    <option value="2" {{ (($notafiscal->idDest ?? null) == "2") ? "selected" : null  }}>2 - Operação Interestadual</option>
                    <option value="3" {{ (($notafiscal->idDest ?? null) == "3") ? "selected" : null  }}>3 - Operação Interestadual</option>
            </select>
            
		</div>
		
		<div class="col-2 mb-3">
                    <label class="text-label">Tipo de Documento</label>	
                    <select class="form-campo" name="tpNF" id="tpNF" >
                            <option value="0" {{ (($notafiscal->tpNF ?? null) == "0") ? "selected" : null  }}>0 - ENTRADA</option>
                            <option value="1" {{ (($notafiscal->tpNF ?? null) == "1") ? "selected" : null  }}>1 - SAÍDA</option>
                    </select>
		</div>
		<div class="col-4 mb-3">
                    <label class="text-label">Forma de Emissão</label>	
                    <select class="form-campo" name="tpEmis" id="tpEmis" >
                            <option value="1" {{ (($notafiscal->tpEmis ?? null) == "1") ? "selected" : null  }}>1 - Emissão normal (não em contingência)</option>
                            <option value="2" {{ (($notafiscal->tpEmis ?? null) == "2") ? "selected" : null  }}>2 - Contingência FS-IA, com impressão do DANFE em Formulário de Segurança</option>
                            <option value="4" {{ (($notafiscal->tpEmis ?? null) == "4") ? "selected" : null  }}>4 - Contingência EPEC (Evento Prévio da Emissão em Contingência)</option>
                            <option value="5" {{ (($notafiscal->tpEmis ?? null) == "5") ? "selected" : null  }}>5 - Contingência FS-DA, com impressão do DANFE em Formulário de Segurança</option>
                            <option value="6" {{ (($notafiscal->tpEmis ?? null) == "6") ? "selected" : null  }}>6 - Contingência SVC-AN (SEFAZ Virtual de Contingência do AN)</option>
                            <option value="7" {{ (($notafiscal->tpEmis ?? null) == "7") ? "selected" : null  }}>7 - Contingência SVC-RS (SEFAZ Virtual de Contingência do RS)</option>
                    </select>
		</div>
		
          <div class="col-4  mb-3">
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
                <label class="text-label">Ambiente</label>	
                <select class="form-campo" name="tpAmb" id="tpAmb">
                        <option value="1" {{ (($notafiscal->tpAmb ?? null) == "1") ? "selected" : null }}>Produção</option>
                        <option value="2" {{ (($notafiscal->tpAmb ?? null) == "2") ? "selected" : null }}>Homologação</option>                                                 

                </select>
        </div>
        <div class="col-2 mb-3">
                    <label class="text-label">Tipo Impressão Danfe</label>	
                    <select class="form-campo" name="tpImp" id="tpImp" >
                            <option value="1" {{ (($notafiscal->tpImp ?? null) == "1") ? "selected" : null }}>1 - Retrato </option>
                    </select>
		</div>
		<div class="col-2 mb-3">
            <label class="text-label">Versão </label>	
            <input type="text" name="verProc" id="verProc" value="{{ $notafiscal->verProc?? null }}"  class="form-campo">
        </div>
        
          
          <div class="col-2 mb-3">
                <label class="text-label">Consumidor final</label>	
                <select class="form-campo" name="indFinal" id="indFinal">
                        <option value="0" {{ (($notafiscal->indFinal ?? null) == "0") ? "selected" : null }}>0 - NÃO</option>
                        <option value="1" {{ (($notafiscal->indFinal ?? null) == "1") ? "selected" : null }}>1 - SIM</option>
                </select>
        </div>	
        
        <div class="col-4 mb-3">
                <label class="text-label">Finalidade da emissão</label>	
                <select class="form-campo" name="finNFe" id="finNFe" >
                    <option value="1" {{ (($notafiscal->finNFe ?? null) == "1") ? "selected" : null }}>1 - NORMAL</option>
                    <option value="2" {{ (($notafiscal->finNFe ?? null) == "2") ? "selected" : null }}>2 - COMPLEMENTAR</option>
                    <option value="3" {{ (($notafiscal->finNFe ?? null) == "3") ? "selected" : null }}>3 - DE AJUSTE</option>
                    <option value="4" {{ (($notafiscal->finNFe ?? null) == "4") ? "selected" : null }}>4 - DEVOLUÇÃO DE MERCADORIA</option>
                </select>
          </div>	
  			<input type="hidden" name="procEmi" id="procEmi" value="0"  class="form-campo">

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
                <input type="text" name="cnpjIntermed" id="cnpjIntermed" value="{{ $notafiscal->cnpjIntermed ?? old('cnpjIntermed') }}"  class="form-campo">
            </div>
            <div class="col-4 mb-3">
                <label class="text-label">Identificação do Intermediador </label>	
                <input type="text" name="idCadIntTran" id="idCadIntTran" value="{{ $notafiscal->idCadIntTran ?? old('idCadIntTran') }}"  class="form-campo">
            </div>
     </div>
    </fieldset>
    
    
    
