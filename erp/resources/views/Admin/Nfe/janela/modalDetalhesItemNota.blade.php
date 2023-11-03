<?php
use App\Service\ConstanteService;
?>
<div class="window form alt" id="modalDetalheItemNfe">
		<a href="" class="fechar position-absolute">X</a>
		<div class="caixa mb-0 p-3">
		
  
   <form id ="frmCadItemNfe"  >
   <div class="p-0 px-2 mt-0">
		<fieldset class="mt-0">
        <legend>Dados Gerais</legend>		
    		<div class="rows">
    			<div class="col-4 mb-3">
						<label class="text-label">Descricao do Produto</label>	
						<input type="text" name="xProd" id="xProd" value="" class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">NCM</label>	
						<input type="text" name="NCM" id="NCM" value="" class="form-campo">
				</div>	
				<div class="col-2 mb-3">
						<label class="text-label">cBenef</label>	
						<input type="text" name="cBenef" id="cBenef" value="" class="form-campo">
				</div>
				
				<div class="col-2 mb-3">
						<label class="text-label">CFOP</label>	
						<input type="text" name="CFOP" id="CFOP" value="" class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">CEST</label>	
						<input type="text" name="CEST" id="CEST" value="" class="form-campo">
				</div>
				
				<div class="col-3 mb-3">
						<label class="text-label">GTIN/EAN</label>	
						<input type="text" name="cEAN" id="cEAN" value="" class="form-campo">
				</div>
				
				<div class="col-3 mb-3">
						<label class="text-label">GTIN/EAN Trib</label>	
						<input type="text" name="cEANTrib" id="cEANTrib" value="" class="form-campo">
				</div>
						
				
				
				<div class="col-2 mb-3">
						<label class="text-label">indTot</label>	
						<input type="text" name="indTot" id="indTot" value="" class="form-campo">
				</div>
				 <div class="col-4 mb-3">
                        <label class="text-label">Origem </label>
                        <select class="form-campo" name="orig" id="orig">
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
						<input type="text" name="uCom" id="uCom" value="" class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">qCom</label>	
						<input type="text" name="qCom" id="qCom" value="" class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vUnCom</label>	
						<input type="text" name="vUnCom" id="vUnCom" value="" class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vProd</label>	
						<input type="text" name="vProd" id="vProd" readonly="readonly" value="" class="form-campo  mascara-float">
				</div>				
				
				<div class="col-2 mb-3">
					<label class="text-label">uTrib</label>	
					<input type="text" name="uTrib" id="uTrib" value="" class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">qTrib</label>	
						<input type="text" name="qTrib" id="qTrib" value="" class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vUnTrib</label>	
						<input type="text" name="vUnTrib" id="vUnTrib"  readonly="readonly" value="" class="form-campo  mascara-float">
				</div>
				
				<div class="col-2 mb-3">
						<label class="text-label">vFrete</label>	
						<input type="text"  id="vFrete" readonly="readonly" value="" class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">Desconto. Item</label>	
						<input type="text" name="desconto_item" id="desconto_item"  readonly="readonly" value="" class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">Desconto. Rateio</label>	
						<input type="text"  id="desconto_rateio" readonly="readonly" value="" class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">Desconto</label>	
						<input type="text"  id="vDesc" readonly="readonly" class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vSeg</label>	
						<input type="text"  id="vSeg" readonly="readonly" value="" class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">vOutro</label>	
						<input type="text"  id="vOutro" readonly="readonly" value="" class="form-campo  mascara-float">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">nFCI</label>	
						<input type="text" name="nFCI" id="nFCI" value="" class="form-campo">
				</div>
				<div class="col-2 mb-3">
						<label class="text-label">EXTIPI</label>	
						<input type="text" name="EXTIPI" id="EXTIPI" value="" class="form-campo">
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
							<select class="form-campo" name="cstICMS" id="cstICMS" onchange="selecionarIcms()">							
								@foreach($lista_cstIcms as $c)
									<option value="{{$c->cst}}">{{$c->descricao}}</option>
								@endforeach									
							</select>
								
						</div>
						                                    
						<div class="col-12 mb-3" id="divCst900">
                             <span class="text-label fw-700 h5 mb-1">Opções para Destaques de CSOSN 900</span>
                                <div class="width-100 border radius-5 d-flex center-middle">
        							<div class="check radio p-6 d-flex p-3">
        								<label class="d-flex mb-1"><input type="checkbox" name="cst900_icms" id="cst900_icms" value="S"> Cálculo ICMS</label>
        								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cst900_redbc" id="cst900_redbc" value="S"> Redução BC</label>
        								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cst900_credisn" id="cst900_credisn" value="S"> CrediSN</label>        								
        								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cst900_st" id="cst900_st" value="S"> Substituição Tributária</label>
        								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cst900_redbcst" id="cst900_redbcst" value="S"> Redução BCST</label>
        							</div>
        						</div>
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
								<input type="text" name="vBCICMS" id="vBCICMS"   readonly="readonly"  class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Alíquota ICMS</label>	
								<input type="text" name="pICMS" id="pICMS"  class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">vICMS</label>	
								<input type="text" name="vICMS" id="vICMS"  readonly="readonly" value="" class="form-campo mascara-float" >
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
								<input type="text" name="vICMSDeson" id="vICMSDeson"  readonly="readonly" class="form-campo mascara-float " >
						</div>
					
								
						
						<div class="col-3 mb-3">
								<label class="text-label">Vr. ICMS Substituto</label>	
								<input type="text" name="vICMSSubstituto" id="vICMSSubstituto"  readonly="readonly"  value="" class="form-campo mascara-float" >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">pCredSN</label>	
								<input type="text" name="pCredSN" id="pCredSN" value="" class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">vCredICMSSN</label>	
								<input type="text" name="vCredICMSSN" id="vCredICMSSN"  readonly="readonly" class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">vICMSOp</label>	
								<input type="text" name="vICMSOp" id="vICMSOp"  readonly="readonly" class="form-campo mascara-float" >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">pBCOp</label>	
								<input type="text" name="pBCOp" id="pBCOp"  class="form-campo mascara-float" >
						</div>
						
						
						<div class="col-3 mb-3">
								<label class="text-label">Perc do Diferimento (%)</label>	
								<input type="text" name="pDif" id="pDif" value="" class="form-campo mascara-float" >
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">vICMS Dif.</label>	
								<input type="text" name="vICMSDif" id="vICMSDif"  readonly="readonly" class="form-campo mascara-float" >
						</div>						
						<div class="col-12 mb-3">
                         <span class="text-label fw-700 h5 mb-1">Composição da BC</span>
                            <div class="width-100 border radius-5 d-flex center-middle">
    							<div class="check radio p-6 d-flex p-3">
    								<label class="d-flex mb-1"><input type="checkbox" name="vbc_frete" id="vbc_frete" value="S"> Frete</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="vbc_ipi" id="vbc_ipi" value="S"> IPI</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="vbc_outros" id="vbc_outros" value="S"> Outras</label>        								
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="vbc_seguro" id="vbc_seguro" value="S"> Seguro</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="vbc_desconto" id="vbc_desconto" value="S"> Desconto</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="vbc_somente_produto" id="vbc_somente_produto" value="S"> Somente Valor da Mercadoria</label>
    							</div>
    						</div>
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
								<input type="text" name="pST" id="pST" value="" class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Valor BC ICMS ST</label>	
								<input type="text" name="vBCST" id="vBCST"  readonly="readonly" class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Alíquota do ICMS ST</label>	
								<input type="text" name="pICMSST" id="pICMSST" value="" class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">UF ST</label>	
								<input type="text" name="UFST" id="UFST" value="" class="form-campo  "  maxlength="2">
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">MVA ICMS ST(%)</label>	
								<input type="text" name="pMVAST" id="pMVAST" value="" class="form-campo mascara-float " >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Red. BC ICMS ST(%)</label>	
								<input type="text" name="pRedBCST" id="pRedBCST" value="" class="form-campo mascara-float " >
						</div>			
						
						<div class="col-3 mb-3">
								<label class="text-label">vICMSST</label>	
								<input type="text" name="vICMSST" id="vICMSST"  readonly="readonly" class="form-campo mascara-float" >
						</div>
									
						                                        
            </div>
   
</fieldset>	
<fieldset>
				<legend>Fundo Combate à Probreza</legend>	
				<div class="rows">
						<div class="col-3 mb-3">
								<label class="text-label">vBCFCP</label>	
								<input type="text" name="vBCFCP" id="vBCFCP" value="" class="form-campo mascara-float" >
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">Aliq. FCP (%)</label>	
								<input type="text" name="pFCP" id="pFCP" value="" class="form-campo mascara-float" >
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">vFCP</label>	
								<input type="text" name="vFCP" id="vFCP"  readonly="readonly" class="form-campo mascara-float" >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Aliq. FCP ST(%)</label>	
								<input type="text" name="pFCPST" id="pFCPST" value="" class="form-campo mascara-float" >
						</div>	
										
						<div class="col-3 mb-3">
								<label class="text-label">Aliq. FCP ST Ret.(%)</label>	
								<input type="text" name="pFCPSTRet" id="pFCPSTRet" value="" class="form-campo mascara-float">
						</div>				
						
						<div class="col-3 mb-3">
								<label class="text-label">vFCPST</label>	
								<input type="text" name="vFCPST" id="vFCPST"  readonly="readonly" class="form-campo mascara-float" >
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
								<input type="text" name="pIPI" id="pIPI" value="" class="form-campo mascara-float" >
						</div>		
						
						<div class="col-2 mb-3">
								<label class="text-label">VBC</label>	
								<input type="text" name="vBCIPI" id="vBCIPI"  readonly="readonly" class="form-campo mascara-float" >
						</div>
						<div class="col-2 mb-3">
                               <label class="text-label">cEnq</label>	
                               <input type="text" name="cEnq"  id="cEnq" maxlength="3" value="" class="form-campo">
                       </div>						
						
						<div class="col-3 mb-3">
								<label class="text-label">CNPJ Prod</label>	
								<input type="text" name="CNPJProd" id="CNPJProd" maxlength="60" value="" class="form-campo ">
						</div>					
						
						<div class="col-3 mb-3">
								<label class="text-label">Cód. Selo</label>	
								<input type="text" name="cSelo" id="cSelo" maxlength="60" value="" class="form-campo ">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Qtde. Selo </label>	
								<input type="text" name="qSelo" id="qSelo" maxlength="12" value="" class="form-campo">
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
								<input type="text" name="vUnidIPI" id="vUnidIPI" maxlength="10" value="" class="form-campo">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">qUnid</label>	
								<input type="text" name="qUnidIPI" id="qUnidIPI" maxlength="10" value="" class="form-campo">
						</div>						
						
                       <div class="col-3 mb-3">
								<label class="text-label">vIPI</label>	
								<input type="text" name="vIPI" id="vIPI"  readonly="readonly" class="form-campo mascara-float" >
						</div>
						
						<div class="col-12 mb-3">
                         <span class="text-label fw-700 h5 mb-1">Composição da BC ipi</span>
                            <div class="width-100 border radius-5 d-flex center-middle">
    							<div class="check radio p-6 d-flex p-3">
    								<label class="d-flex mb-1"><input type="checkbox" name="ipi_frete" id="ipi_frete" value="S"> Frete</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="ipi_outros" id="ipi_outros" value="S"> Outras</label>        								
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="ipi_seguro" id="ipi_seguro" value="S"> Seguro</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="ipi_somente_produto" id="ipi_somente_produto" value="S"> Somente Valor da Mercadoria</label>
    							</div>
    						</div>
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
								<input type="text" name="pPIS" id="pPIS" value="" class="form-campo mascara-float" >
						</div>	
						
						<div class="col-3 mb-3">
								<label class="text-label">Valor Alíq. Esp (%)</label>	
								<input type="text" name="vAliqProd_pis" id="vAliqProd_pis" value="" class="form-campo mascara-float" >
						</div>			
									
						 <div class="col-3 mb-3">
								<label class="text-label">Base PIS</label>	
								<input type="text" name="vBCPIS" id="vBCPIS"  readonly="readonly" class="form-campo mascara-float" >
						</div>	
						                                  
							
						
						<div class="col-3 mb-3">
								<label class="text-label">qBCProd</label>	
								<input type="text" name="qBCProdPis" id="qBCProdPis"  class="form-campo mascara-float" >
						</div>	
							
						<div class="col-3 mb-3">
								<label class="text-label">vPIS</label>	
								<input type="text" name="vPIS" id="vPIS"  readonly="readonly" class="form-campo mascara-float" >
						</div>
						
						
						<div class="col-12 mb-3">
                         <span class="text-label fw-700 h5 mb-1">Composição da BC PIS</span>
                            <div class="width-100 border radius-5 d-flex center-middle">
    							<div class="check radio p-6 d-flex p-3">
    								<label class="d-flex mb-1"><input type="checkbox" name="pis_frete" id="pis_frete" value="S"> Frete</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="pis_ipi" id="pis_ipi" value="S"> IPI</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="pis_outros" id="pis_outros" value="S"> Outras</label>        								
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="pis_seguro" id="pis_seguro" value="S"> Seguro</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="pis_desconto" id="pis_desconto" value="S"> Desconto</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="pis_somente_produto" id="pis_somente_produto" value="S"> Somente Valor da Mercadoria</label>
    							</div>
    						</div>
                     </div>				
						
          </div> 

</fieldset>
	
	<fieldset>
				<legend>Substituição Tributário - PIS</legend>	
				<div class="rows">			
						
						<div class="col-3 mb-3">
							<label class="text-label">Modalidade Pis ST</label>
							<select class="form-campo" name="tipo_calc_pisst" id="tipo_calc_pisst">	
								<option value="">Selecione</option>
                                <option value="1">Porcentagem</option>                                                 
                                <option value="2">Em valor</option>
							</select>	
						</div>						 
						                          
						<div class="col-3 mb-3">
								<label class="text-label">Alíquota PIS ST (%)</label>	
								<input type="text" name="pPISST" id="pPISST" value="" class="form-campo mascara-float" >
						</div>	
						
						
						<div class="col-3 mb-3">
								<label class="text-label">Valor Alíquota ST (R$)</label>	
								<input type="text" name="vAliqProd_pisst" id="vAliqProd_pisst" value="" class="form-campo mascara-float" >
						</div>	
						
						<div class="col-3 mb-3">
								<label class="text-label">vPISST</label>	
								<input type="text" name="vPISST" id="vPISST"  readonly="readonly" class="form-campo mascara-float" >
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
								<input type="text" name="pCOFINS" id="pCOFINS" value="" class="form-campo mascara-float" >
						</div>	
						
						<div class="col-3 mb-3">
								<label class="text-label">Valor Alíq. Esp (%)</label>	
								<input type="text" name="vAliqProd_cofins" id="vAliqProd_cofins" value="" class="form-campo mascara-float" >
						</div>			
						
						
						<div class="col-3 mb-3">
								<label class="text-label">qBCProdCofins</label>	
								<input type="text" name="qBCProdConfis" id="qBCProdConfis" value="" class="form-campo mascara-float" >
						</div>
						
					
						<div class="col-3 mb-3">
								<label class="text-label">vBCCofins</label>	
								<input type="text" name="vBCCOFINS" id="vBCCOFINS"  readonly="readonly" class="form-campo mascara-float" >
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">vCofins</label>	
								<input type="text" name="vCOFINS" id="vCOFINS"  readonly="readonly" class="form-campo mascara-float" >
						</div>
						
						<div class="col-12 mb-3">
                         <span class="text-label fw-700 h5 mb-1">Composição da BC COFINS</span>
                            <div class="width-100 border radius-5 d-flex center-middle">
    							<div class="check radio p-6 d-flex p-3">
    								<label class="d-flex mb-1"><input type="checkbox" name="cofins_frete" id="cofins_frete" value="S"> Frete</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cofins_ipi" id="cofins_ipi" value="S"> IPI</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cofins_outros" id="cofins_outros" value="S"> Outras</label>        								
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cofins_seguro" id="cofins_seguro" value="S"> Seguro</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cofins_desconto" id="cofins_desconto" value="S"> Desconto</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cofins_somente_produto" id="cofins_somente_produto" value="S"> Somente Valor da Mercadoria</label>
    							</div>
    						</div>
                     </div>
							
						
            </div>  
   
</fieldset>
	<fieldset>
				<legend>Substituição Tributária - COFINS</legend>	
				<div class="rows">
					
						<div class="col-3 mb-3">
							<label class="text-label">Modalidade Cofins ST</label>
							<select class="form-campo" name="tipo_calc_cofinsst" id="tipo_calc_cofinsst">	
								<option value="">Selecione</option>
                                <option value="1">Porcentagem</option>                                                 
                                <option value="2">Em valor</option>
							</select>	
						</div>
						                                   
						<div class="col-3 mb-3">
								<label class="text-label">Alíq. Cofins ST (%)</label>	
								<input type="text" name="pCOFINSST" id="pCOFINSST" value="" class="form-campo mascara-float" >
						</div>	
						
						
						
						<div class="col-3 mb-3">
								<label class="text-label">Alíq. Cofins ST (R$)</label>	
								<input type="text" name="vAliqProd_cofinsst" id="vAliqProd_cofinsst" value="" class="form-campo mascara-float" >
						</div>
						<div class="col-3 mb-3">
								<label class="text-label">vCofinsST</label>	
								<input type="text" name="vCOFINSST" id="vCOFINSST"  readonly="readonly" class="form-campo mascara-float" >
						</div>
						
            </div>  
   
</fieldset>
	
		
		</div>
	  </div> 	  
         
 </div>

</div>
		
		<div class="col-12 text-center pb-0 tfooter center">
    		<div class="col-2 mb-3">
                     <label class="text-label">Tipo Desconto</label>
                     <select  class="form-campo" id="tipo_desc_modal_item" >
                     	<option value="desc_perc">Percento (%)</option>
                     	<option value="desc_valor">Valor (R$)</option>
                     </select>
            </div> 
            
            <div class="col-2 mb-3">
                     <label class="text-label">Desconto (R$)</label>
                     <input type="text"  id="val_desconto_modal_item"  value="0"  class="form-campo mascara-float">
            </div>
                        
			<input type="button" class="btn btn-vermelho fechar" value="Fechar">
			<input type="hidden" name="id" id="id" >   
			<input type="hidden" name="nfe_id" value="{{$notafiscal->id}}" >
			<input type="hidden" name="cProd" id="cProdItem" >  
			<input type="button" onclick="atualizarItens()" value="Atualizar Dados" class="btn btn-azul">			
		</div>
	
	
</form>
			
		</div>
	</div>