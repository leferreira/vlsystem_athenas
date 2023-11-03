<?php
use App\Service\ConstanteService;
?>
<div class="window form alt" id="modalDetalheItemNfe">
		<a href="" class="fechar position-absolute">X</a>
		<div class="caixa mb-0 p-3">
		
  
   <form id ="frmAtualizarItemNfe"  >
   <div class="p-0 px-2 mt-0">
		<fieldset class="mt-0">
        <legend>Dados Gerais</legend>		
    		<div class="rows">
    			<div class="col-4 mb-3">
						<label class="text-label">Descricao do Produto</label>	
						<input type="text" name="xProd" id="xProd"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">NCM</label>	
						<input type="text" name="NCM" id="NCM"  class="form-campo">
				</div>	
				<div class="col-2 mb-3">
						<label class="text-label">cBenef</label>	
						<input type="text" name="cBenef" id="cBenef"  class="form-campo">
				</div>
				
				<div class="col-2 mb-3">
						<label class="text-label">CFOP</label>	
						<input type="text" name="CFOP" id="CFOP"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">CEST</label>	
						<input type="text" name="CEST" id="CEST"  class="form-campo">
				</div>
				
				<div class="col-3 mb-3">
						<label class="text-label">GTIN/EAN</label>	
						<input type="text" name="cEAN" id="cEAN"  class="form-campo">
				</div>
				
				<div class="col-3 mb-3">
						<label class="text-label">GTIN/EAN Trib</label>	
						<input type="text" name="cEANTrib" id="cEANTrib"  class="form-campo">
				</div>
				
				<div class="col-2 mb-3">
						<label class="text-label">indTot</label>	
						<input type="text" name="indTot" id="indTot"  class="form-campo">
				</div>
				 <div class="col-4 mb-3">
                        <label class="text-label">Origem </label>
                        <select class="form-campo" name="orig">
                            @foreach(ConstanteService::listaOrigem() as $chave=>$valor)
                          	<option value="{{$chave}}">{{$chave}} - {{$valor}}</option>
                          @endforeach 
					   </select>
                </div> 
				
						
    		</div>
		</fieldset>
	</div>
	
<div >     
   <div id="tabmod" class="abas py-0">
	    <ul class="tabmod">
            <li><a href="#tabmod-1" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-9">Dados Gerais </a></li>
            <li><a href="#tabmod-2" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-9">ICMS </a></li>
            <li><a href="#tabmod-3" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-10">IPI</a></li>
            <li><a href="#tabmod-4" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-11">PIS</a></li>
            <li><a href="#tabmod-5" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-12">COFINS</a></li>
         </ul>
        <div id="tabmod-1" class="scroll-modal">
        
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>Dados Diversos</legend>	
				<div class="rows">
					<div class="col-2 mb-3">
						<label class="text-label">uCom</label>	
						<input type="text" name="uCom" id="uCom"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">qCom</label>	
						<input type="text" name="qCom" id="qCom"  class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vUnCom</label>	
						<input type="text" name="vUnCom" id="vUnCom"  class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vProd</label>	
						<input type="text" name="vProd" id="vProd"   class="form-campo  mascara-float">
				</div>				
				
				<div class="col-2 mb-3">
					<label class="text-label">uTrib</label>	
					<input type="text" name="uTrib" id="uTrib"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">qTrib</label>	
						<input type="text" name="qTrib" id="qTrib"  class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vUnTrib</label>	
						<input type="text" name="vUnTrib" id="vUnTrib"  class="form-campo  mascara-float">
				</div>
				
				<div class="col-2 mb-3">
						<label class="text-label">vFrete</label>	
						<input type="text"  id="vFrete" name="vFrete"  class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">Desconto. Item</label>	
						<input type="text" name="desconto_item" id="desconto_item"    class="form-campo  mascara-float">
				</div>
			
				<div class="col-2 mb-3">
						<label class="text-label">Desconto</label>	
						<input type="text"  id="vDesc" id="vDesc" class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vSeg</label>	
						<input type="text"  id="vSeg" id="vSeg"   class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vOutro</label>	
						<input type="text"  id="vOutro" id="vOutro"   class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">nFCI</label>	
						<input type="text" name="nFCI" id="nFCI"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">EXTIPI</label>	
						<input type="text" name="EXTIPI" id="EXTIPI"  class="form-campo">
				</div>
			
						                                        
            </div>
   
</fieldset>
	
		
		</div>
	  </div>
	  
	  <div id="tabmod-2" class="scroll-modal">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>ICMS</legend>	
				<div class="rows">
				
					<div class="col-6 mb-3">
							<label class="text-label">CST</label>
							<select class="form-campo" name="cstICMS" id="cstICMS" >							
								@foreach($lista_cstIcms as $c)
									<option value="{{$c->cst}}">{{$c->descricao}}</option>
								@endforeach									
							</select>
								
						</div>                                    
						
						<div class="col-3 mb-3">
								<label class="text-label">Modalidade BC</label>	
								<select class="form-campo" name="modBC" id="modBC">							
									@foreach($lista_modalidade as $chave=>$valor)
    									<option value="{{$chave}}" > {{$valor}}</option>
    								@endforeach								
								</select>							
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">Base ICMS</label>	
								<input type="text" name="vBCICMS" id="vBCICMS"    class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Alíquota ICMS</label>	
								<input type="text" name="pICMS" id="pICMS"  class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">vICMS</label>	
								<input type="text" name="vICMS" id="vICMS"  class="form-campo mascara-float" >
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">Red. BC ICMS (%)</label>	
								<input type="text" name="pRedBC" id="pRedBC"  class="form-campo mascara-float ">
						</div>				
						<div class="col-3 mb-3">
								<label class="text-label">Aliq. ICMS Intra (%)</label>	
								<input type="text" name="pICMSIntra" id="pICMSIntra"  class="form-campo mascara-float ">
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">Motivo Deson</label>	
								<select class="form-campo" name="motDesICMS" id="motDesICMS">	
									@foreach($lista_motivo as $chave=>$valor)
    									<option value="{{$chave}}" {{($nfeItem->motDesICMS ?? null) == $chave ? "selected" : null }}>{{$valor}}</option>
    								@endforeach						
								</select>							
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Valor ICMS Deson</label>	
								<input type="text" name="vICMSDeson" id="vICMSDeson"  class="form-campo mascara-float " >
						</div>
					
								
						
						<div class="col-3 mb-3">
								<label class="text-label">Vr. ICMS Substituto</label>	
								<input type="text" name="vICMSSubstituto" id="vICMSSubstituto"  class="form-campo mascara-float" >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">pCredSN</label>	
								<input type="text" name="pCredSN" id="pCredSN"  class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">vCredICMSSN</label>	
								<input type="text" name="vCredICMSSN" id="vCredICMSSN"  class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">vICMSOp</label>	
								<input type="text" name="vICMSOp" id="vICMSOp"  class="form-campo mascara-float" >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">pBCOp</label>	
								<input type="text" name="pBCOp" id="pBCOp"  class="form-campo mascara-float" >
						</div>
						
						
						<div class="col-3 mb-3">
								<label class="text-label">Perc do Diferimento (%)</label>	
								<input type="text" name="pDif" id="pDif"  class="form-campo mascara-float" >
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">vICMS Dif.</label>	
								<input type="text" name="vICMSDif" id="vICMSDif"  class="form-campo mascara-float" >
						</div>						
					
						                                        
            </div>
   
</fieldset>

<fieldset>
				<legend>Substituição Tributária</legend>	
				<div class="rows">
						
						<div class="col-3 mb-3">
								<label class="text-label">Modalidade BC ICMSST</label>	
								<select class="form-campo" name="modBCST" id="modBCST">	
									@foreach($lista_modalidade_st as $chave=>$valor)
    									<option value="{{$chave}}" {{($nfeItem->modBC ?? null) == $chave ? "selected" : null }}> {{$valor}}</option>
    								@endforeach						
								</select>							
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">Alíquota  ST</label>	
								<input type="text" name="pST" id="pST"  class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Valor BC ICMS ST</label>	
								<input type="text" name="vBCST" id="vBCST"  class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Alíquota do ICMS ST</label>	
								<input type="text" name="pICMSST" id="pICMSST"  class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">UF ST</label>	
								<input type="text" name="UFST" id="UFST"  class="form-campo  "  maxlength="2">
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">MVA ICMS ST(%)</label>	
								<input type="text" name="pMVAST" id="pMVAST"  class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Red. BC ICMS ST(%)</label>	
								<input type="text" name="pRedBCST" id="pRedBCST"  class="form-campo mascara-float " >
						</div>				
						
						<div class="col-3 mb-3">
								<label class="text-label">Vr. ICMS Substituto</label>	
								<input type="text" name="vICMSSubstituto" id="vICMSSubstituto"  class="form-campo mascara-float" >
						</div>						
						
						
						<div class="col-3 mb-3">
								<label class="text-label">vICMSST</label>	
								<input type="text" name="vICMSST" id="vICMSST"  class="form-campo mascara-float" >
						</div>
									
						                                        
            </div>
   
</fieldset>	
<fieldset>
				<legend>Fundo Combate à Probreza</legend>	
				<div class="rows">
						<div class="col-3 mb-3">
								<label class="text-label">vBCFCP</label>	
								<input type="text" name="vBCFCP" id="vBCFCP"  class="form-campo mascara-float" >
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">Aliq. FCP (%)</label>	
								<input type="text" name="pFCP" id="pFCP"  class="form-campo mascara-float" >
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">vFCP</label>	
								<input type="text" name="vFCP" id="vFCP"  class="form-campo mascara-float" >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Aliq. FCP ST(%)</label>	
								<input type="text" name="pFCPST" id="pFCPST"  class="form-campo mascara-float" >
						</div>	
										
						<div class="col-3 mb-3">
								<label class="text-label">Aliq. FCP ST Ret.(%)</label>	
								<input type="text" name="pFCPSTRet" id="pFCPSTRet"  class="form-campo mascara-float">
						</div>				
						
						<div class="col-3 mb-3">
								<label class="text-label">vFCPST</label>	
								<input type="text" name="vFCPST" id="vFCPST"  class="form-campo mascara-float" >
						</div>					
						                                        
            </div>
   
</fieldset>			
		</div>
	  </div>
	  
	  
  <div id="tabmod-3" class="scroll-modal">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>IPI</legend>	
				<div class="rows">	
					<div class="col-6 mb-3">
							<label class="text-label">CST</label>
							<select class="form-campo" name="cstIPI" id="cstIPI">
								@foreach($lista_cst_ipi as $l)
									<option value="{{$l->cst}}" {{($natureza->cstIpi ?? null) == $l->cst ? "selected" : null }}>{{$l->descricao}}</option>
								@endforeach								
							</select>		
								
						</div>
						                                    
						<div class="col-2 mb-3">
								<label class="text-label">Aliquota %</label>	
								<input type="text" name="pIPI" id="pIPI"  class="form-campo mascara-float" >
						</div>		
						
						<div class="col-2 mb-3">
								<label class="text-label">VBC</label>	
								<input type="text" name="vBCIPI" id="vBCIPI"  class="form-campo mascara-float" >
						</div>
						<div class="col-2 mb-3">
                               <label class="text-label">cEnq</label>	
                               <input type="text" name="cEnq"  id="cEnq" maxlength="3"  class="form-campo">
                       </div>						
						
						<div class="col-3 mb-3">
								<label class="text-label">CNPJ Prod</label>	
								<input type="text" name="CNPJProd" id="CNPJProd" maxlength="60"  class="form-campo ">
						</div>					
						
						<div class="col-3 mb-3">
								<label class="text-label">Cód. Selo</label>	
								<input type="text" name="cSelo" id="cSelo" maxlength="60"  class="form-campo ">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Qtde. Selo </label>	
								<input type="text" name="qSelo" id="qSelo" maxlength="12"  class="form-campo">
						</div>
						<div class="col-3 mb-3">
							<label class="text-label">Tipo de cálculo</label>
							<select class="form-campo" name="tipo_calc_ipi" id="tipo_calc_ipi">	
                                <option value="1">Porcentagem</option>                                                 
                                <option value="2">Em valor</option>
							</select>	
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">Valor por Unidade</label>	
								<input type="text" name="vUnidIPI" id="vUnidIPI" maxlength="10"  class="form-campo">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">qUnid</label>	
								<input type="text" name="qUnidIPI" id="qUnidIPI" maxlength="10"  class="form-campo">
						</div>						
						
                       <div class="col-3 mb-3">
								<label class="text-label">vIPI</label>	
								<input type="text" name="vIPI" id="vIPI"  class="form-campo mascara-float" >
						</div>
					
                                           
           </div>  

</fieldset>
	
		
		</div>
	  </div>
	  
     <div id="tabmod-4" class="scroll-modal">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>PIS</legend>	
				<div class="rows">	
					<div class="col-9 mb-3">
							<label class="text-label">CST</label>
							<select class="form-campo" name="cstPIS" id="cstPIS">
								@foreach($lista_cstPis as $l)
									<option value="{{$l->cst}}" {{($natureza->cstCofins ?? null) == $l->cst ? "selected" : null }}>{{$l->descricao}}</option>
								@endforeach								
							</select>		
								
						</div> 
						
						                                   
						<div class="col-3 mb-3">
								<label class="text-label">Alíquota PIS %</label>	
								<input type="text" name="pPIS" id="pPIS"  class="form-campo mascara-float" >
						</div>	
						
						<div class="col-3 mb-3">
								<label class="text-label">Valor Alíq. Esp (%)</label>	
								<input type="text" name="vAliqProd_pis" id="vAliqProd_pis"  class="form-campo mascara-float" >
						</div>			
											
						
						
						 
						 <div class="col-3 mb-3">
								<label class="text-label">Base PIS</label>	
								<input type="text" name="vBCPIS" id="vBCPIS" class="form-campo mascara-float" >
						</div>	
						                                  
							
						
						<div class="col-3 mb-3">
								<label class="text-label">qBCProd</label>	
								<input type="text" name="qBCProdPis" id="qBCProdPis"  class="form-campo mascara-float" >
						</div>	
							
						<div class="col-3 mb-3">
								<label class="text-label">vPIS</label>	
								<input type="text" name="vPIS" id="vPIS"  class="form-campo mascara-float" >
						</div>
						
          </div> 

</fieldset>
	
	<fieldset>
				<legend>Substituição Tributário - PIS</legend>	
				<div class="rows">			
						
						<div class="col-3 mb-3">
							<label class="text-label">Modalidade Pis ST</label>
							<select class="form-campo" name="tipo_calc_pisst" id="tipo_calc_pisst">	
								<option >Selecione</option>
                                <option value="1">Porcentagem</option>                                                 
                                <option value="2">Em valor</option>
							</select>	
						</div>						 
						                          
						<div class="col-3 mb-3">
								<label class="text-label">Alíquota PIS ST (%)</label>	
								<input type="text" name="pPISST" id="pPISST"  class="form-campo mascara-float" >
						</div>	
						
						
						<div class="col-3 mb-3">
								<label class="text-label">Valor Alíquota ST (R$)</label>	
								<input type="text" name="vAliqProd_pisst" id="vAliqProd_pisst"  class="form-campo mascara-float" >
						</div>	
						
						<div class="col-3 mb-3">
								<label class="text-label">vPISST</label>	
								<input type="text" name="vPISST" id="vPISST"  class="form-campo mascara-float" >
						</div>
						
									
						
          </div> 

</fieldset>
		
		</div>
	  </div>    

  <div id="tabmod-5" class="scroll-modal">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>COFINS</legend>	
				<div class="rows">
					<div class="col-9 mb-3">
							<label class="text-label">CST</label>
							<select class="form-campo" name="cstCOFINS" id="cstCOFINS">
								@foreach($lista_cstCofins as $l)
									<option value="{{$l->cst}}" >{{$l->descricao}}</option>
								@endforeach								
							</select>	
								
						</div>                                    
						
						                                   
						<div class="col-3 mb-3">
								<label class="text-label">Alíq. Cofins (%)</label>	
								<input type="text" name="pCOFINS" id="pCOFINS"  class="form-campo mascara-float" >
						</div>	
						
						<div class="col-3 mb-3">
								<label class="text-label">Valor Alíq. Esp (%)</label>	
								<input type="text" name="vAliqProd_cofins" id="vAliqProd_cofins"  class="form-campo mascara-float" >
						</div>			
						
						
						<div class="col-3 mb-3">
								<label class="text-label">qBCProdCofins</label>	
								<input type="text" name="qBCProdConfis" id="qBCProdConfis"  class="form-campo mascara-float" >
						</div>
						
					
						<div class="col-3 mb-3">
								<label class="text-label">vBCCofins</label>	
								<input type="text" name="vBCCOFINS" id="vBCCOFINS"  class="form-campo mascara-float" >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">vCofins</label>	
								<input type="text" name="vCOFINS" id="vCOFINS"  class="form-campo mascara-float" >
						</div>										
							
						
            </div>  
   
</fieldset>
	<fieldset>
				<legend>Substituição Tributária - COFINS</legend>	
				<div class="rows">
					
						<div class="col-3 mb-3">
							<label class="text-label">Modalidade Cofins ST</label>
							<select class="form-campo" name="tipo_calc_cofinsst" id="tipo_calc_cofinsst">	
								<option >Selecione</option>
                                <option value="1">Porcentagem</option>                                                 
                                <option value="2">Em valor</option>
							</select>	
						</div>
						                                   
						<div class="col-3 mb-3">
								<label class="text-label">Alíq. Cofins ST (%)</label>	
								<input type="text" name="pCOFINSST" id="pCOFINSST"  class="form-campo mascara-float" >
						</div>	
						
						
						
						<div class="col-3 mb-3">
								<label class="text-label">Alíq. Cofins ST (R$)</label>	
								<input type="text" name="vAliqProd_cofinsst" id="vAliqProd_cofinsst"  class="form-campo mascara-float" >
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">vCofinsST</label>	
								<input type="text" name="vCOFINSST" id="vCOFINSST"  class="form-campo mascara-float" >
						</div>
						
            </div>  
   
</fieldset>
	
		
		</div>
	  </div> 	  
         
 </div>

</div>
		
		<div class="col-12 text-center pb-0 tfooter center">                        
			<input type="button" class="btn btn-vermelho fechar" value="Fechar">
			<input type="hidden" name="id" id="id" >   
			<input type="hidden" name="nfe_id" value="{{$notafiscal->id}}" >
			<input type="hidden" name="cProd" id="cProdItem" >  
			<input type="button" onclick="atualizarSemCalculo()" value="Atualizar Sem Cálculo" class="btn btn-azul">			
		</div>
	
	
</form>
			
		</div>
	</div>