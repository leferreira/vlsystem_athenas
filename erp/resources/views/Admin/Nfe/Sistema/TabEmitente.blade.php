
<fieldset class="mt-4">
<legend class="h5 mb-0 text-left">Emitente</legend>										
        <div class="rows p-2">																		
            
          	<div class="col-6 mb-1">
                <label class="text-label">CPF/CNPJ </label>	
                <input type="text" name="CNPJEmitente" readonly="true" id="CNPJEmitente"  value="{{ $notafiscal->em_CNPJ ?? null }}" class="form-campo">
            </div>
            
            <div class="col-6 mb-1">
                    <label class="text-label">Nome / Razão Social </label>	
                    <input type="text" name="xNomeEmitente" id="xNomeEmitente"  value="{{ $notafiscal->em_xNome ?? null  }}"  class="form-campo">
            </div>	
            <div class="col-8 mb-3">
                    <label class="text-label">Nome Fantasia</label>	
                    <input type="text" name="xFantEmitente" id="xFantEmitente"  value="{{ $notafiscal->em_xFant ?? null  }}"  class="form-campo">
            </div>
                   			
			 
            <div class="col-4 mb-1">
                    <label class="text-label">Inscr. Estadual</label>	
                    <input type="text" name="IEEmitente" id="IEEmitente"  value="{{ $notafiscal->em_IE ?? null  }}" class="form-campo">
            </div>
            <div class="col-3 mb-1">
                <label class="text-label">Ins. Est. Subst. Trib.</label>	
                <input type="text" name="IESTEmitente" id="IESTEmitente" value="{{ $notafiscal->em_IEST ?? null  }}"  class="form-campo">
            </div> 
			
            <div class="col-3 mb-1">
                    <label class="text-label">Inscr. Municipal</label>	
                    <input type="text" name="IMEmitente" id="IMEmitente"  value="{{ $notafiscal->em_IM ?? null  }}" class="form-campo">
            </div>
                
            <div class="col-3 mb-1">
                    <label class="text-label">CNAE</label>	
                    <input type="text" name="CNAEEmitente" id="CNAEEmitente"  value="{{ $notafiscal->em_CNAE ?? null  }}"  class="form-campo">
            </div>
			
            <div class="col-3 mb-1">
                <label class="text-label">Regime Tributário</label>	
                 <select class="form-campo" name="CRTEmitente" id="CRTEmitente">
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
                 <input type="text"  name="CEPEmitente" id="CEPEmitente"  value="{{ $notafiscal->em_CEP ?? null  }}" class="form-campo">

            </div>
			
		   <div class="col-6 mb-1">
                    <label class="text-label">Logradouro</label>	
                    <input type="text" name="xLgrEmitente" id="xLgrEmitente"  value="{{ $notafiscal->em_xLgr ?? null  }}" class="form-campo">
            </div>
			<div class="col-2 mb-1">
                    <label class="text-label">Numero</label>	
                    <input type="text" name="nroEmitente" id="nroEmitente"  value="{{ $notafiscal->em_nro ?? null  }}"  class="form-campo">
            </div>
            <div class="col-6 mb-1">
                <label class="text-label">Complemento</label>	
                <input type="text" name="xCplEmitente" id="xCplEmitente"  value="{{ $notafiscal->em_xCpl ?? null  }}" class="form-campo">
            </div>
			
			<div class="col-6 mb-1">
                    <label class="text-label">Bairro</label>	
                    <input type="text" name="xBairroEmitente" id="xBairroEmitente"  value="{{ $notafiscal->em_xBairro ?? null  }}"  class="form-campo">
            </div>  
                  
            
             
             <div class="col-2 mb-1">
                     <label class="text-label">Telefone</label>	
                     <input type="text" name="foneEmitente" id="foneEmitente"  value="{{ $notafiscal->em_fone ?? null  }}" class="form-campo">
             </div>
            
                    <div class="col-3 mb-1">
                    <label class="text-label">UF</label>	
                    <input type="text" name="ufEmitente" id="ufEmitente"  value="{{ $notafiscal->em_UF ?? null  }}" class="form-campo">
           
            </div>
           
            <div class="col-3 mb-1">
                <label class="text-label">Cidade</label>
                  <input type="text" name="xMunEmitente" id="xMunEmitente"  value="{{ $notafiscal->em_xMun ?? null  }}" class="form-campo">              
             </div>
             
             <div class="col-2 mb-1">
                <label class="text-label">IBGE</label>
                  <input type="text" name="cMunEmitente" id="cMunEmitente"  value="{{ $notafiscal->em_cMun ?? null  }}" class="form-campo">              
             </div>
             
              <div class="col-2 mb-1">
             <label class="text-label">País</label>
				<input type="text" name="cPais" id="cPais"  value="{{ $notafiscal->em_xPais ?? null  }}" class="form-campo">
            </div>       

            </div>
 
</fieldset>