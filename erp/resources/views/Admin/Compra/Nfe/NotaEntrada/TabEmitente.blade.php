
<fieldset class="mt-4">
<legend class="h5 mb-0 text-left">Emitente</legend>										
        <div class="rows p-2">																		
            
          	<div class="col-3 mb-1">
                <label class="text-label">CPF/CNPJ </label>	
                <input type="text" name="em_CNPJ" readonly="true" id="CNPJEmitente"  value="{{ $emitente->cnpj ?? null }}" class="form-campo">
            </div>
            
            <div class="col-6 mb-1">
                    <label class="text-label">Nome / Razão Social </label>	
                    <input type="text" name="em_xNome" id="xNomeEmitente"  value="{{ $emitente->razao_social ?? null  }}"  class="form-campo">
            </div>	
            <div class="col-3 mb-3">
                    <label class="text-label">Nome Fantasia</label>	
                    <input type="text" name="em_xFant" id="xFantEmitente"  value="{{ $emitente->nome_fantasia ?? null  }}"  class="form-campo">
            </div>
                   			
			 
            <div class="col-4 mb-1">
                    <label class="text-label">Inscr. Estadual</label>	
                    <input type="text" name="em_IE" id="IEEmitente"  value="{{ $emitente->rg_ie ?? null  }}" class="form-campo">
            </div>
           
			
            <div class="col-3 mb-1">
                    <label class="text-label">Inscr. Municipal</label>	
                    <input type="text" name="em_IM" id="IMEmitente"  value="{{ $emitente->im ?? null  }}" class="form-campo">
            </div>
               
		</div> 
		</fieldset>
		
		
<fieldset class="mt-2 mb-2">
<legend class="h5 mb-0 text-left">Endereço Emitente</legend>	
             
		<div class="rows p-2"> 
			<div class="col-4 mb-1">
                <label class="text-label">CEP</label>
                 <input type="text"  name="em_CPF" id="CEPEmitente"  value="{{ $emitente->cep ?? null  }}" class="form-campo">

            </div>
			
		   <div class="col-6 mb-1">
                    <label class="text-label">Logradouro</label>	
                    <input type="text" name="em_xLgr" id="xLgrEmitente"  value="{{ $emitente->logradouro ?? null  }}" class="form-campo">
            </div>
			<div class="col-2 mb-1">
                    <label class="text-label">Numero</label>	
                    <input type="text" name="em_nro" id="nroEmitente"  value="{{ $emitente->numero ?? null  }}"  class="form-campo">
            </div>
            <div class="col-6 mb-1">
                <label class="text-label">Complemento</label>	
                <input type="text" name="em_xCpl" id="xCplEmitente"  value="{{ $emitente->complemento ?? null  }}" class="form-campo">
            </div>
			
			<div class="col-6 mb-1">
                    <label class="text-label">Bairro</label>	
                    <input type="text" name="em_xBairro" id="xBairroEmitente"  value="{{ $emitente->bairro ?? null  }}"  class="form-campo">
            </div>  
                  
            
             
             <div class="col-2 mb-1">
                     <label class="text-label">Telefone</label>	
                     <input type="text" name="em_fone" id="foneEmitente"  value="{{ $emitente->telefone ?? null  }}" class="form-campo">
             </div>
            
                    <div class="col-3 mb-1">
                    <label class="text-label">UF</label>	
                    <input type="text" name="em_UF" id="ufEmitente"  value="{{ $emitente->uf ?? null  }}" class="form-campo">
           
            </div>
           
            <div class="col-3 mb-1">
                <label class="text-label">Cidade</label>
                  <input type="text" name="em_xMun" id="xMunEmitente"  value="{{ $emitente->cidade ?? null  }}" class="form-campo">              
             </div>
             
             <div class="col-2 mb-1">
                <label class="text-label">IBGE</label>
                  <input type="text" name="em_cMun" id="cMunEmitente"  value="{{ $emitente->ibge ?? null  }}" class="form-campo">              
             </div>
                  

            </div>
 
</fieldset>