<?php
use App\Service\ConstanteService;
?>
<div class="scroll-tab">     
  
   <form action="" method="POST">
    @csrf
    
   <div class="p-2 mt-3">
		<fieldset class="mt-0">
        <legend>Dados Gerais</legend>		
    		<div class="rows">
    			<div class="col-4 mb-3">
						<label class="text-label">Descricao do Produto</label>	
						<input type="text" name="xProd" value="{{$nfeItem->xProd ?? old('descricao') }}"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">NCM</label>	
						<input type="text" name="NCM" value="{{$nfeItem->NCM ?? old('NCM') }}"  class="form-campo">
				</div>	
				<div class="col-2 mb-3">
						<label class="text-label">CEST</label>	
						<input type="text" name="CEST" value="{{$nfeItem->CEST ?? old('CEST') }}"  class="form-campo">
				</div>	
				<div class="col-2 mb-3">
						<label class="text-label">cBenef</label>	
						<input type="text" name="cBenef" value="{{$nfeItem->cBenef ?? old('cBenef') }}"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">CFOP</label>	
						<input type="text" name="CFOP" value="{{$nfeItem->CFOP?? old('CFOP') }}"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">uCom</label>	
						<input type="text" name="uCom" value="{{$nfeItem->uCom ?? old('uCom') }}"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">qCom</label>	
						<input type="text" name="qCom" value="{{$nfeItem->qCom?? old('qCom') }}"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vUnCom</label>	
						<input type="text" name="vUnCom" value="{{$nfeItem->vUnCom?? old('vUnCom') }}"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vFrete</label>	
						<input type="text" name="vFrete" value="{{$nfeItem->vFrete?? old('vFrete') }}"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vDesc</label>	
						<input type="text" name="vDesc" value="{{$nfeItem->vDesc ?? old('vDesc') }}"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vSeg</label>	
						<input type="text" name="vSeg" value="{{$nfeItem->vSeg ?? old('vSeg') }}"  class="form-campo">
				</div>
						
    		</div>
		</fieldset>
	</div>
	
   <div id="tabmod" class="abas">
	    <ul class="tabmod">
            <li><a href="#tabmod-1">ICMS </a></li>
            <li><a href="#tabmod-2">IPI</a></li>
            <li><a href="#tabmod-3">PIS</a></li>
            <li><a href="#tabmod-4">COFINS</a></li>
         </ul>
	  <div id="tabmod-1">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>ICMS</legend>	
				<div class="rows">
				
					<div class="col-6 mb-3">
							<label class="text-label">CST</label>
							<select class="form-campo" name="cstICMS" id="cstICMS" onchange="selecionarIcms()" >							
								
								
							</select>
								
						</div>                                    
						<div class="col-3 mb-3">
								<label class="text-label">CFOP (intraestadual)</label>	
								<input type="text" name="CFOP" maxlength="4"  id="CFOP" value="{{$nfeItem->CFOP ?? old('CFOP') }}" class="form-campo">
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">Modalidade BC</label>	
								<select class="form-campo" name="modBC" id="modBC" >							
								
								
							</select>							
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">Alíquota ICMS</label>	
								<input type="text" name="pICMS"   id="pICMS" value="{{$nfeItem->pICMS ?? old('pICMS') }}" class="form-campo mascara-float ">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Red. BC ICMS (%)</label>	
								<input type="text" name="pRedBC"   id="pRedBC" value="{{$nfeItem->pRedBC ?? old('pRedBC') }}" class="form-campo mascara-float ">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Modalidade BC ICMSST</label>	
								<select class="form-campo" name="modBCST" id="modBCST" >							
							</select>							
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">Valor BC ICMS ST</label>	
								<input type="text" name="vBCST"   id="vBCST" value="{{$nfeItem->vBCST ?? old('vBCST') }}" class="form-campo mascara-float ">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Alíquota do ICMS ST</label>	
								<input type="text" name="pICMSST"   id="pICMSST" value="{{$nfeItem->pICMSST ?? old('pICMSST') }}" class="form-campo mascara-float ">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">MVA ICMS ST(%)</label>	
								<input type="text" name="pMVAST"   id="pMVAST" value="{{$nfeItem->pMVAST ?? old('pMVAST') }}" class="form-campo mascara-float ">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Red. BC ICMS ST(%)</label>	
								<input type="text" name="pRedBCST"   id="pRedBCST" value="{{$nfeItem->pRedBCST ?? old('pRedBCST') }}" class="form-campo mascara-float ">
						</div>				
						
						<div class="col-3 mb-3">
								<label class="text-label">Vr. ICMS Substituto</label>	
								<input type="text" name="vICMSSubstituto" id="vICMSSubstituto" value="{{$nfeItem->vICMSSubstituto ?? old('vICMSSubstituto') }}"  class="form-campo mascara-float">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Aliq. FCP (%)</label>	
								<input type="text" name="pFCP" id="pFCP" value="{{$nfeItem->pFCP ?? old('pFCP') }}"  class="form-campo mascara-float">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Aliq. FCP ST(%)</label>	
								<input type="text" name="pFCPST" id="pFCPST" value="{{$nfeItem->pFCPST ?? old('pFCPST') }}"  class="form-campo mascara-float">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">vFCP</label>	
								<input type="text" name="vFCP" id="vFCP" value="{{$nfeItem->vFCP ?? old('vFCP') }}"  class="form-campo mascara-float">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Aliq. FCP ST Ret.(%)</label>	
								<input type="text" name="pFCPSTRet" id="pFCPSTRet" value="{{$nfeItem->pFCPSTRet ?? old('pFCPSTRet') }}"  class="form-campo mascara-float">
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">Perc do Diferimento (%)</label>	
								<input type="text" name="pDif" id="pDif" value="{{$nfeItem->pDif ?? old('pDif') }}"  class="form-campo mascara-float">
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">vICMS</label>	
								<input type="text" name="vICMS" id="vICMS" value="{{$nfeItem->vICMS ?? old('vICMS') }}"  class="form-campo mascara-float">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">vICMSST</label>	
								<input type="text" name="vICMSST" id="vICMSST" value="{{$nfeItem->vICMSST ?? old('vICMSST') }}"  class="form-campo mascara-float">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">vFCPST</label>	
								<input type="text" name="vFCPST" id="vFCPST" value="{{$nfeItem->vFCPST ?? old('vFCPST') }}"  class="form-campo mascara-float">
						</div>
						                                        
            </div>
   
</fieldset>
	
		
		</div>
	  </div>
	  
	  
  <div id="tabmod-2">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>IPI</legend>	
				<div class="rows">	
					<div class="col-6 mb-3">
							<label class="text-label">CST</label>
							<select class="form-campo" name="cstIPI" id="cstIPI" >							
							</select>		
								
						</div>
						                                    
						<div class="col-2 mb-3">
								<label class="text-label">Aliquota %</label>	
								<input type="text" name="pIPI"  id="pIPI" value="{{$nfeItem->pIPI ?? old('pIPI') }}" class="form-campo mascara-float">
						</div>		
						
						<div class="col-2 mb-3">
								<label class="text-label">Base %</label>	
								<input type="text" name="vBCIPI" value="{{$nfeItem->vBCIPI ?? old('vBCIPI') }}"  class="form-campo mascara-float">
						</div>
						
						<div class="col-2 mb-3">
							<label class="text-label">Tipo de cálculo</label>
							<select class="form-campo" name="tipo_calc_ipi" >	
								<option value="0" {{ (($nfeItem->tipo_calc_ipi ?? null) == "0") ? "selected" : null }}>Selecione</option>
                                <option value="1" {{ (($nfeItem->tipo_calc_ipi ?? null) == "1") ? "selected" : null }}>Porcentagem</option>                                                 
                                <option value="2" {{ (($nfeItem->tipo_calc_ipi ?? null) == "2") ? "selected" : null }}>Em valor</option>
							</select>	
						</div>
						
						<div class="col-4 mb-3">
								<label class="text-label">CNPJ do produtor</label>	
								<input type="text" name="CNPJProd" maxlength="60" value="{{$nfeItem->cSelo?? old('cSelo') }}"  class="form-campo ">
						</div>						
						
						
						<div class="col-4 mb-3">
								<label class="text-label">Código do selo de controle</label>	
								<input type="text" name="cSelo" maxlength="60" value="{{$nfeItem->cSelo?? old('cSelo') }}"  class="form-campo ">
						</div>
						
						<div class="col-4 mb-3">
								<label class="text-label">Qtde. do selo de controle</label>	
								<input type="text" name="qSelo" maxlength="12" value="{{$nfeItem->qSelo ?? old('qSelo') }}"  class="form-campo">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Qtde na Unidade</label>	
								<input type="text" name="qUnidIPI" maxlength="10" value="{{$nfeItem->qUnidIPI ?? old('qUnidIPI') }}"  class="form-campo">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Valor por Unidade</label>	
								<input type="text" name="vUnidIPI" maxlength="10" value="{{$nfeItem->vUnidIPI ?? old('vUnidIPI') }}"  class="form-campo">
						</div>
						
						
						<div class="col-3 mb-3">
                               <label class="text-label">Cód. de Enquadramento</label>	
                               <input type="text" name="cEnq" maxlength="3" value="{{$nfeItem->cEnq ??  old('cEnq') }}"  class="form-campo">
                       </div>
                       
                       <div class="col-3 mb-3">
								<label class="text-label">vIPI</label>	
								<input type="text" name="vIPI" id="vIPI" value="{{$nfeItem->vIPI ?? old('vIPI') }}"  class="form-campo mascara-float">
						</div>
                                           
           </div>  

</fieldset>
	
		
		</div>
	  </div>
	  
     <div id="tabmod-3">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>PIS</legend>	
				<div class="rows">	
					<div class="col-12 mb-3">
							<label class="text-label">CST</label>
							<select class="form-campo" name="cstPIS" id="cstPIS" >							
							</select>		
								
						</div> 
						<div class="col-3 mb-3">
							<label class="text-label">Modalidade Pis</label>
							<select class="form-campo" name="tipo_calc_pis" >	
								<option value="0" {{ (($nfeItem->tipo_calc_pis ?? null) == "0") ? "selected" : null }}>Selecione</option>
                                <option value="1" {{ (($nfeItem->tipo_calc_pis ?? null) == "1") ? "selected" : null }}>Porcentagem</option>                                                 
                                <option value="2" {{ (($nfeItem->tipo_calc_pis ?? null) == "2") ? "selected" : null }}>Em valor</option>
							</select>	
						</div>
						                                   
						<div class="col-3 mb-3">
								<label class="text-label">Alíquota PIS %</label>	
								<input type="text" name="pPIS"  id="pPIS" value="{{$nfeItem->pPIS ?? old('pPIS') }}" class="form-campo mascara-float">
						</div>	
						
						<div class="col-3 mb-3">
								<label class="text-label">Valor Alíquota (R$)</label>	
								<input type="text" name="vAliqProd_pis"  id="vAliqProd_pis" value="{{$nfeItem->vAliqProd_pis ?? old('vAliqProd_pis') }}" class="form-campo mascara-float">
						</div>			
											
						
						<div class="col-3 mb-3">
							<label class="text-label">Modalidade Pis ST</label>
							<select class="form-campo" name="tipo_calc_pis" >	
								<option value="0" {{ (($nfeItem->tipo_calc_pis ?? null) == "0") ? "selected" : null }}>Selecione</option>
                                <option value="1" {{ (($nfeItem->tipo_calc_pis ?? null) == "1") ? "selected" : null }}>Porcentagem</option>                                                 
                                <option value="2" {{ (($nfeItem->tipo_calc_pis ?? null) == "2") ? "selected" : null }}>Em valor</option>
							</select>	
						</div>
						                                   
						<div class="col-3 mb-3">
								<label class="text-label">Alíquota PIS ST (%)</label>	
								<input type="text" name="pPISST"  id="pPISST" value="{{$nfeItem->pPISST ?? old('pPISST') }}" class="form-campo mascara-float">
						</div>	
						
						<div class="col-3 mb-3">
								<label class="text-label">Valor Alíquota ST (R$)</label>	
								<input type="text" name="vAliqProd_pisst"  id="vAliqProd_pisst" value="{{$nfeItem->vAliqProd_pisst ?? old('vAliqProd_pisst') }}" class="form-campo mascara-float">
						</div>	
						<div class="col-3 mb-3">
								<label class="text-label">vPIS</label>	
								<input type="text" name="vPIS"  id="vPIS" value="{{$nfeItem->vPIS ?? old('vPIS') }}" class="form-campo mascara-float">
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">vPISST</label>	
								<input type="text" name="vPISST"  id="vPISST" value="{{$nfeItem->vPISST ?? old('vPISST') }}" class="form-campo mascara-float">
						</div>			
						
          </div> 

</fieldset>
	
		
		</div>
	  </div>    

  <div id="tabmod-4">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>COFINS</legend>	
				<div class="rows">
					<div class="col-12 mb-3">
							<label class="text-label">CST</label>
							<select class="form-campo" name="cstCofins" >							
							</select>		
								
						</div>                                    
						<div class="col-3 mb-3">
							<label class="text-label">Modalidade Cofins</label>
							<select class="form-campo" name="tipo_calc_cofins" >	
								<option value="0" {{ (($nfeItem->tipo_calc_cofins ?? null) == "0") ? "selected" : null }}>Selecione</option>
                                <option value="1" {{ (($nfeItem->tipo_calc_cofins ?? null) == "1") ? "selected" : null }}>Porcentagem</option>                                                 
                                <option value="2" {{ (($nfeItem->tipo_calc_cofins ?? null) == "2") ? "selected" : null }}>Em valor</option>
							</select>	
						</div>
						                                   
						<div class="col-3 mb-3">
								<label class="text-label">Alíq. Cofins (%)</label>	
								<input type="text" name="pCofins"  id="pCofins" value="{{$nfeItem->pCofins ?? old('pCofins') }}" class="form-campo mascara-float">
						</div>	
						
						<div class="col-3 mb-3">
								<label class="text-label">Alíq. Cofins (R$)</label>	
								<input type="text" name="vAliqProd_cofins"  id="vAliqProd_cofins" value="{{$nfeItem->vAliqProd_cofins?? old('vAliqProd_cofins') }}" class="form-campo mascara-float">
						</div>			
						
						
						<div class="col-3 mb-3">
							<label class="text-label">Modalidade Cofins ST</label>
							<select class="form-campo" name="tipo_calc_cofinsst" >	
								<option value="0" {{ (($nfeItem->tipo_calc_cofins ?? null) == "0") ? "selected" : null }}>Selecione</option>
                                <option value="1" {{ (($nfeItem->tipo_calc_cofins ?? null) == "1") ? "selected" : null }}>Porcentagem</option>                                                 
                                <option value="2" {{ (($nfeItem->tipo_calc_cofins ?? null) == "2") ? "selected" : null }}>Em valor</option>
							</select>	
						</div>
						                                   
						<div class="col-3 mb-3">
								<label class="text-label">Alíq. Cofins ST (%)</label>	
								<input type="text" name="pCofinsst"  id="pCofinsst" value="{{$nfeItem->pCofinsst ?? old('pCofinsst') }}" class="form-campo mascara-float">
						</div>	
						
						<div class="col-3 mb-3">
								<label class="text-label">Alíq. Cofins ST (R$)</label>	
								<input type="text" name="vAliqProd_cofinsst"  id="vAliqProd_cofinsst" value="{{$nfeItem->vAliqProd_cofinsst?? old('vAliqProd_cofinsst') }}" class="form-campo mascara-float">
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">vCofins</label>	
								<input type="text" name="vCofins"  id="vCofins" value="{{$nfeItem->vCofins ?? old('vCofins') }}" class="form-campo mascara-float">
						</div>
							
						
            </div>  
   
</fieldset>
	
		
		</div>
	  </div> 	  
         
 </div>

		
		<div class="col-12 text-center pb-4 tfooter center">
			<input type="button" class="btn btn-vermelho fechar" value="Fechar">
			<input type="hidden" name="id"  value="{{$nfeItem->id ?? null}}">   
			<input type="submit" value="Salvar" class="btn btn-azul">
		</div>
	
	
</form>
</div>
