<?php
use App\Service\ConstanteService;
?>
<div class="window form alt" id="modalTributacaoLucro" style="">
<a href="" class="fechar position-absolute">X</a>
<div class="caixa mb-0 p-3">
<div class="">     
  
   <form  id="frmCadTributacao">
    @csrf
    
   <div class="p-2 mt-0 pb-0">
			<span class="d-block h3 border-bottom fw-700">Tributação </span>
    		<div class="rows">			
						
    			<div class="col-12 mb-3">
						<label class="text-label">Descrição </label>	
						<input type="text" name="descricao" id="descricao" value="{{$tributacao->descricao ?? old('descricao') }}"  class="form-campo">
				</div>
			<div class="col-12">
			<fieldset>
			<legend>CFOP</legend>
    			<div class="rows">	
    				<div class="col-2 mb-3">
    						<label class="text-label">Dentro do Estado</label>	
    						<input type="text" name="cfop"  id="cfop" maxlength="4" value="{{$nfeItem->cfop ?? old('cfop') }}"  class="form-campo">
    				</div>	
    				<div class="col-2 mb-3">
    						<label class="text-label">Fora do Estado</label>	
    						<input type="text" name="cfop_fora"  id="cfop_fora" maxlength="4" value="{{$nfeItem->cfop_fora ?? old('cfop_fora') }}"  class="form-campo">
    				</div>
    				<div class="col-4 mb-3">
    						<label class="text-label">Fora do Estado (consumidor final)</label>	
    						<input type="text" name="cfop_fora_consumidor_final"  id="cfop_fora_consumidor_final" maxlength="4" value="{{$nfeItem->cfop_fora_consumidor_final ?? old('cfop_fora_consumidor_final') }}"  class="form-campo">
    				</div>
    				
    				<div class="col-2 mb-3">
    						<label class="text-label">Importação/Exportação</label>	
    						<input type="text" name="cfop_exportacao"  id="cfop_exportacao" maxlength="4" value="{{$nfeItem->cfop_exportacao ?? old('cfop_exportacao') }}"  class="form-campo">
    				</div>
    			</div>
    			</fieldset>			
			</div>			
    		</div>
	</div>
<div >	
   <div id="tabmod" class="abas pt-0">
	    <ul class="tabmod">
            <li><a href="#tabmod-1">ICMS </a></li>
            <li><a href="#tabmod-2">IPI</a></li>
            <li><a href="#tabmod-3">PIS</a></li>
            <li><a href="#tabmod-4">COFINS</a></li>
         </ul>
	  <div id="tabmod-1" class="scroll-modal alt">
		<div class="p-2 mt-0 px-0">			
				
				<fieldset class="mb-0">
				<legend>ICMS</legend>	
				<div class="col-12 mb-3">
                         <span class="text-label fw-700 h5 mb-1">Composição da BC</span>
                            <div class="width-100 border radius-5 d-flex center-middle">
    							<div class="check radio p-6 d-flex p-3">    							
    								<label class="d-flex mb-1"><input type="checkbox" name="vbc_frete" id="vbc_frete" value="S"> Frete</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="vbc_ipi" id="vbc_ipi" value="S"> IPI</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="vbc_outros" id="vbc_outros" value="S"> Outras</label>        								
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="vbc_seguro" id="vbc_seguro" value="S"> Seguro</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="vbc_desconto" id="vbc_desconto" value="S"> Desconto</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="vbc_somente_produto" id="vbc_somente_produto" value="S"> Valor Unitário com base</label>
    							</div>
    						</div>
                     </div>
                     
                     
                     
				<div class="rows">
				
						<div class="col-6 mb-3" id="divCstICMS">
							<label class="text-label">CST Icms</label>
							<select class="form-campo" name="cstICMS" id="cstICMS" onchange="selecionarIcms900()" >							
								@foreach($lista_cstIcms as $c)
									<option value="{{$c->cst}}" {{($natureza->cstICMS ?? null) == $c->cst ? "selected" : null }}>{{$c->descricao}}</option>
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
						<div class="col-3 mb-3" id="divModBC">
								<label class="text-label">Modalidade BC</label>	
								<select class="form-campo" name="modBC" id="modBC" >							
									@foreach(ConstanteService::listaModalidade() as $chave=>$valor)
    									<option value="{{$chave}}" {{($nfeItem->modBC ?? null) == $chave ? "selected" : null }}>{{$chave}} - {{$valor}}</option>
    								@endforeach							
    							</select>							
						</div>						
						
						<div class="col-3 mb-3" id="divPICMS">
								<label class="text-label">Alíquota ICMS</label>	
								<input type="text" name="pICMS"   id="pICMS" value="{{$nfeItem->pICMS ?? old('pICMS') }}" class="form-campo mascara-float ">
						</div>
						<div class="col-3 mb-3" id="divPRedBC">
								<label class="text-label">Red. BC ICMS (%)</label>	
								<input type="text" name="pRedBC"   id="pRedBC" value="{{$nfeItem->pRedBC ?? old('pRedBC') }}" class="form-campo mascara-float ">
						</div>
						<div class="col-3 mb-3" id="divPDif">
								<label class="text-label">Perc do Diferimento (%)</label>	
								<input type="text" name="pDif" id="pDif" value="{{$nfeItem->pDif ?? old('pDif') }}"  class="form-campo mascara-float">
						</div>
						
						
						<div class="col-3 mb-3" id="divMotDesICMS">
								<label class="text-label">Motivo Des.</label>	
								<select class="form-campo" name="motDesICMS" id="motDesICMS" onchange="selecionarIcms900()" >							
    								@foreach($desonaracoes as $d)
    									<option value="{{$d->codigo}}" >{{$d->codigo}} - {{$d->descricao}}</option>
    								@endforeach								
    							</select>
							
						</div>
						
						<div class="col-3 mb-3" id="divVICMSSubstituto">
								<label class="text-label">Vr. ICMS Substituto</label>	
								<input type="text" name="vICMSSubstituto" id="vICMSSubstituto" value="{{$nfeItem->vICMSSubstituto ?? old('vICMSSubstituto') }}"  class="form-campo mascara-float">
						</div>
						
						<div class="col-3 mb-3" id="divPFCP">
								<label class="text-label">Aliq. BCOp (%)</label>	
								<input type="text" name="pBCOp" id="pBCOp" value="{{$nfeItem->pBCOp ?? old('pBCOp') }}"  class="form-campo mascara-float">
						</div>
						
						<div class="col-3 mb-3" id="divPFCP">
								<label class="text-label">Aliq. FCP (%)</label>	
								<input type="text" name="pFCP" id="pFCP" value="{{$nfeItem->pFCP ?? old('pFCP') }}"  class="form-campo mascara-float">
						</div>						
						
						
						                                        
            </div>
   
</fieldset>
	
		
		</div>
	  </div>
	  
	  
  <div id="tabmod-2" class="scroll-modal alt">
		<div class="p-2 mt-0 px-0">			
				
				<fieldset class="mb-0">
				<legend>IPI</legend>	
				<div class="col-12 mb-3">
                         <span class="text-label fw-700 h5 mb-1">Composição da BC ipi</span>
                            <div class="width-100 border radius-5 d-flex center-middle">
    							<div class="check radio p-6 d-flex p-3">
    								<label class="d-flex mb-1"><input type="checkbox" name="ipi_frete" id="ipi_frete" value="S"> Frete</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="ipi_outros" id="ipi_outros" value="S"> Outras</label>        								
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="ipi_seguro" id="ipi_seguro" value="S"> Seguro</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="ipi_desconto" id="ipi_desconto" value="S"> Desconto</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="ipi_somente_produto" id="ipi_somente_produto" value="S"> Valor Unitário com base</label>
    							</div>
    						</div>
                     </div>
                     
				<div class="rows">	
					<div class="col-6 mb-3">
							<label class="text-label">CST IPI</label>
							<select class="form-campo" name="cstIPI" id="cstIPI" >	
								@foreach($lista_cst_ipi as $l)
									<option value="{{$l->cst}}" {{($natureza->cstIPI ?? null) == $l->cst ? "selected" : null }}>{{$l->descricao}}</option>
								@endforeach						
							</select>		
								
						</div>
						                                    
						<div class="col-2 mb-3">
								<label class="text-label">Aliquota %</label>	
								<input type="text" name="pIPI"  id="pIPI" value="{{$nfeItem->pIPI ?? old('pIPI') }}" class="form-campo mascara-float">
						</div>
						<div class="col-2 mb-3">
                               <label class="text-label">Cód. Enq</label>	
                               <input type="text" name="cEnq" id="cEnq" maxlength="3" value="{{$nfeItem->cEnq ??  old('cEnq') }}"  class="form-campo">
                       </div>
                       
						<div class="col-2 mb-3">
							<label class="text-label">Tipo Cálculo</label>
							<select class="form-campo" name="tipo_calc_ipi" id="tipo_calc_ipi">	
                                <option value="1" >Perc</option>                                                 
                                <option value="2" >Valor</option>
							</select>	
						</div>
						
						
						<div class="col-3 mb-3">
								<label class="text-label">CNPJ do Produtor</label>	
								<input type="text" name="CNPJProd" id="CNPJProd" maxlength="60" value="{{$nfeItem->cSelo?? old('cSelo') }}"  class="form-campo ">
						</div>						
						
						
						<div class="col-2 mb-3">
								<label class="text-label">Cód do selo</label>	
								<input type="text" name="cSelo" id="cSelo" maxlength="60" value="{{$nfeItem->cSelo?? old('cSelo') }}"  class="form-campo ">
						</div>
						
						<div class="col-2 mb-3">
								<label class="text-label">Qtde. Selo</label>	
								<input type="text" name="qSelo" id="qSelo" maxlength="12" value="{{$nfeItem->qSelo ?? old('qSelo') }}"  class="form-campo">
						</div>
						
						<div class="col-3 mb-3">
								<label class="text-label">Valor por Unidade</label>	
								<input type="text" name="vUnidIPI" id="vUnidIPI" maxlength="10" value="{{$nfeItem->vUnidIPI ?? old('vUnidIPI') }}"  class="form-campo mascara-float">
						</div>
						 
                                           
           </div>  

</fieldset>
	
		
		</div>
	  </div>
	  
     <div id="tabmod-3" class="scroll-modal alt">
		<div class="p-2 mt-0 px-0">			
				
				<fieldset class="mb-0">
				<legend>PIS</legend>	
				<div class="col-12 mb-3">
                         <span class="text-label fw-700 h5 mb-1">Composição da BC PIS</span>
                            <div class="width-100 border radius-5 d-flex center-middle">
    							<div class="check radio p-6 d-flex p-3">
    								<label class="d-flex mb-1"><input type="checkbox" name="pis_frete" id="pis_frete" value="S"> Frete</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="pis_ipi" id="pis_ipi" value="S"> IPI</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="pis_outros" id="pis_outros" value="S"> Outras</label>        								
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="pis_seguro" id="pis_seguro" value="S"> Seguro</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="pis_desconto" id="pis_desconto" value="S"> Desconto</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="pis_somente_produto" id="pis_somente_produto" value="S"> Valor Unitário com base</label>
    							</div>
    						</div>
                     </div>
                     
				<div class="rows">	
					<div class="col-12 mb-3">
						<label class="text-label">CST PIS</label>
						<select class="form-campo" name="cstPIS" id="cstPIS" >	
							@foreach($lista_cstPis as $l)
								<option value="{{$l->cst}}" {{($natureza->cstPIS ?? null) == $l->cst ? "selected" : null }}>{{$l->descricao}}</option>
							@endforeach	
							<option value="99">99 - Outras Operações</option>				
						</select>	
							
					</div> 						
						                                   
					<div class="col-3 mb-3">
							<label class="text-label">Alíquota PIS %</label>	
							<input type="text" name="pPIS"  id="pPIS" value="{{$nfeItem->pPIS ?? old('pPIS') }}" class="form-campo mascara-float">
					</div>	
					
					<div class="col-3 mb-3">
							<label class="text-label">Valor Alíquota (%) </label>	
							<input type="text" name="vAliqProd_pis"  id="vAliqProd_pis" value="{{$nfeItem->vAliqProd_pis ?? old('vAliqProd_pis') }}" class="form-campo mascara-float">
					</div>			
						                                   
					<div class="col-3 mb-3">
							<label class="text-label">Alíquota PIS ST (%)</label>	
							<input type="text" name="pPISST"  id="pPISST" value="{{$nfeItem->pPISST ?? old('pPISST') }}" class="form-campo mascara-float">
					</div>	
					
					<div class="col-3 mb-3">
							<label class="text-label">Valor Alíquota ST (R$)</label>	
							<input type="text" name="vAliqProd_pisst"  id="vAliqProd_pisst" value="{{$nfeItem->vAliqProd_pisst ?? old('vAliqProd_pisst') }}" class="form-campo mascara-float">
					</div>	
							
							
          </div> 

</fieldset>
	
		
		</div>
	  </div>    

  <div id="tabmod-4" class="scroll-modal alt">
		<div class="p-2 mt-0 px-0">			
				
				<fieldset class="mb-0">
				<legend>COFINS</legend>	
				<div class="col-12 mb-3">
                         <span class="text-label fw-700 h5 mb-1">Composição da BC COFINS</span>
                            <div class="width-100 border radius-5 d-flex center-middle">
    							<div class="check radio p-6 d-flex p-3">
    								<label class="d-flex mb-1"><input type="checkbox" name="cofins_frete" id="cofins_frete" value="S"> Frete</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cofins_ipi" id="cofins_ipi" value="S"> IPI</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cofins_outros" id="cofins_outros" value="S"> Outras</label>        								
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cofins_seguro" id="cofins_seguro" value="S"> Seguro</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cofins_desconto" id="cofins_desconto" value="S"> Desconto</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="cofins_somente_produto" id="cofins_somente_produto" value="S"> Valor Unitário com base</label>
    							</div>
    						</div>
                     </div>
                     
				<div class="rows">
					<div class="col-12 mb-3">
							<label class="text-label">CST</label>
							<select class="form-campo" name="cstCOFINS" id="cstCOFINS" >
								@foreach($lista_cstCofins as $l)
									<option value="{{$l->cst}}" {{($natureza->cstCOFINS ?? null) == $l->cst ? "selected" : null }}>{{$l->descricao}}</option>
								@endforeach	
								<option value="99">99 - Outras Operações</option>						
							</select>		
								
						</div>                                    
					
						                                   
						<div class="col-3 mb-3">
								<label class="text-label">Alíq. Cofins (%)</label>	
								<input type="text" name="pCOFINS"  id="pCOFINS" value="{{$nfeItem->pCOFINS ?? old('pCOFINS') }}" class="form-campo mascara-float">
						</div>	
						
						<div class="col-3 mb-3">
								<label class="text-label">Alíq. Cofins (R$)</label>	
								<input type="text" name="vAliqProd_cofins"  id="vAliqProd_cofins" value="{{$nfeItem->vAliqProd_cofins?? old('vAliqProd_cofins') }}" class="form-campo mascara-float">
						</div>			
					
						                                   
						<div class="col-3 mb-3">
								<label class="text-label">Alíq. Cofins ST (%)</label>	
								<input type="text" name="pCOFINSST"  id="pCOFINSST" value="{{$nfeItem->pCOFINSST ?? old('pCOFINSST') }}" class="form-campo mascara-float">
						</div>	
						
						<div class="col-3 mb-3">
								<label class="text-label">Alíq. Cofins ST (R$)</label>	
								<input type="text" name="vAliqProd_cofinsst"  id="vAliqProd_cofinsst" value="{{$nfeItem->vAliqProd_cofinsst?? old('vAliqProd_cofinsst') }}" class="form-campo mascara-float">
						</div>
						
						
            </div>  
   
</fieldset>
	
		
		</div>
	  </div> 	  
         
 </div>
 </div>

		
		<div class="col-12 text-center pb-2 tfooter center">
			<input type="button" class="btn btn-vermelho fechar" value="Fechar">
			<input type="hidden" name="natureza_operacao_id" id="natureza_operacao_id"  value="{{$natureza->id ?? null}}"> 
			<input type="hidden"  id="id"  name="id"> 	
			<input type="button" id="btnInserirTributacao" value="Salvar" class="btn btn-azul">
		</div>
	
	
</form>
</div>
</div>
</div>

