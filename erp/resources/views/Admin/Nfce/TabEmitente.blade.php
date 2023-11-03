
<fieldset class="mt-4">
<legend class="h5 mb-0 text-left">Emitente</legend>										
        <div class="rows p-2">																		
            
          	<div class="col-6 mb-1">
                <label class="text-label">CPF/CNPJ </label>	
                <input type="text" name="em_CNPJ" readonly="true" id="CNPJEmitente"  value="{{ $notafiscal->em_CNPJ ?? null }}" class="form-campo">
            </div>
            
            <div class="col-6 mb-1">
                    <label class="text-label">Nome / Razão Social </label>	
                    <input type="text" name="em_xNome" id="xNomeEmitente"  value="{{ $notafiscal->em_xNome ?? null  }}"  class="form-campo">
            </div>	
            <div class="col-8 mb-3">
                    <label class="text-label">Nome Fantasia</label>	
                    <input type="text" name="em_xFant" id="xFantEmitente"  value="{{ $notafiscal->em_xFant ?? null  }}"  class="form-campo">
            </div>
                   			
			 
            <div class="col-4 mb-1">
                    <label class="text-label">Inscr. Estadual</label>	
                    <input type="text" name="em_IE" id="IEEmitente"  value="{{ $notafiscal->em_IE ?? null  }}" class="form-campo">
            </div>
            <div class="col-3 mb-1">
                <label class="text-label">Ins. Est. Subst. Trib.</label>	
                <input type="text" name="em_IEST" id="IESTEmitente" value="{{ $notafiscal->em_IEST ?? null  }}"  class="form-campo">
            </div> 
			
            <div class="col-3 mb-1">
                    <label class="text-label">Inscr. Municipal</label>	
                    <input type="text" name="em_IM" id="IMEmitente"  value="{{ $notafiscal->em_IM ?? null  }}" class="form-campo">
            </div>
                
            <div class="col-3 mb-1">
                    <label class="text-label">CNAE</label>	
                    <input type="text" name="em_CNAE" id="CNAEEmitente"  value="{{ $notafiscal->em_CNAE ?? null  }}"  class="form-campo">
            </div>
			
            <div class="col-3 mb-1">
                <label class="text-label">Regime Tributário</label>	
                 <select class="form-campo" name="em_CRT" id="CRTEmitente">
                    <option value="1" {{(($notafiscal->em_CRT ?? null) =="1") ? "selected": NULL }}>Simples Nacional</option> 
                    <option value="2" {{(($notafiscal->em_CRT  ?? null)=="2") ? "selected": NULL }}>Lucro Presumido</option> 
                    <option value="3" {{(($notafiscal->em_CRT  ?? null)=="3") ? "selected": NULL }}>Lucro Real</option> 
                </select>
            </div> 
		</div> 
		</fieldset>
		
		
<fieldset class="mt-2 mb-2">
<legend class="h5 mb-0 text-left">Endereço Emitente</legend>	
             
		<div class="rows p-2"> 
			<div class="col-4 mb-1">
                <label class="text-label">CEP</label>
                 <input type="text"  name="em_CPF" id="CEPEmitente"  value="{{ $notafiscal->em_CEP ?? null  }}" class="form-campo">

            </div>
			
		   <div class="col-6 mb-1">
                    <label class="text-label">Logradouro</label>	
                    <input type="text" name="em_xLgr" id="xLgrEmitente"  value="{{ $notafiscal->em_xLgr ?? null  }}" class="form-campo">
            </div>
			<div class="col-2 mb-1">
                    <label class="text-label">Numero</label>	
                    <input type="text" name="em_nro" id="nroEmitente"  value="{{ $notafiscal->em_nro ?? null  }}"  class="form-campo">
            </div>
            <div class="col-6 mb-1">
                <label class="text-label">Complemento</label>	
                <input type="text" name="em_xCpl" id="xCplEmitente"  value="{{ $notafiscal->em_xCpl ?? null  }}" class="form-campo">
            </div>
			
			<div class="col-6 mb-1">
                    <label class="text-label">Bairro</label>	
                    <input type="text" name="em_xBairro" id="xBairroEmitente"  value="{{ $notafiscal->em_xBairro ?? null  }}"  class="form-campo">
            </div>  
                  
            
             
             <div class="col-2 mb-1">
                     <label class="text-label">Telefone</label>	
                     <input type="text" name="em_fone" id="foneEmitente"  value="{{ $notafiscal->em_fone ?? null  }}" class="form-campo">
             </div>
            
                    <div class="col-3 mb-1">
                    <label class="text-label">UF</label>	
                    <input type="text" name="em_UF" id="ufEmitente"  value="{{ $notafiscal->em_UF ?? null  }}" class="form-campo">
           
            </div>
           
            <div class="col-3 mb-1">
                <label class="text-label">Cidade</label>
                  <input type="text" name="em_xMun" id="xMunEmitente"  value="{{ $notafiscal->em_xMun ?? null  }}" class="form-campo">              
             </div>
             
             <div class="col-2 mb-1">
                <label class="text-label">IBGE</label>
                  <input type="text" name="em_cMun" id="cMunEmitente"  value="{{ $notafiscal->em_cMun ?? null  }}" class="form-campo">              
             </div>
             
              <div class="col-2 mb-1">
             <label class="text-label">País</label>
				<input type="text" name="em_xPais" id="cPais"  value="{{ $notafiscal->em_xPais ?? null  }}" class="form-campo">
            </div>       

            </div>
 
</fieldset>