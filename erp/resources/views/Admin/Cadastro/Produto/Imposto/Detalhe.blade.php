<?php
use App\Service\ConstanteService;
?>
<section class="col-12">			
	<div class="">
		<div class="rows">
		<form action= "<?php echo 'itemnotafiscal/atualizar' ?>" method="POST" >	
			<input type="hidden" value="<?php echo isset($produto) ? $produto->cProd: "" ?>" name="cProd"  >
			<input type="hidden" value="<?php echo isset($produto) ? $produto->cEAN: "" ?>" name="cEAN"  >
			<input type="hidden" value="<?php echo isset($produto) ? $produto->id_item_nota: "" ?>" name="id_item_nota"  >	
		
				
			 
			 <!--ABAS-->
			 <div class="mt-0 col-12">
				<div id="tabs">
							<ul class="tabs mb-3">
								<li><a href="#aba-1">ICMS</a></li>
								<li><a href="#aba-2">IPI</a></li>
								<li><a href="#aba-3">PIS</a></li>
								<li><a href="#aba-4">CONFIS</a></li>
								<li><a href="#aba-5">ICMSSON</a></li>
								<li><a href="#aba-6">Imposto de importação</a></li>								
								<li><a href="#aba-7">IPI devolvido</a></li>
								<li><a href="#aba-8">ICMS em operações interestaduais</a></li>
							</ul>
							<div id="aba-1">
							
								<div class="col-12">
									
									<!--AQUI INCLUDE-->
									<div class="" id="mostrar_icms">
									
<div class="rows">
	<div class="col-4">
			<fieldset class="p-2">
			<legend>Tributação ICMS para PDV</legend>
				<div class="rows">
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> NFC-e</label>
						<select class="form-campo menor" name="icms_orig" id="icms_orig">
							<option value="">Selecionar</option>
							@foreach(ConstanteService::listaCstNfce() as $ch=>$valor)
                        		<option value='{{$ch}}'>{{$ch}} - {{$valor}}</option>
                        	@endforeach	
						</select>
					</div>
					<div class="col-6 mb-3">
						<label class="text-label"> % ICMS</label>
						<input type="text" name="vBCIcms" id="vBCIcms" value="<?php echo isset($produto->vBCIcms) ? $produto->vBCIcms: "" ?>" class="form-campo menor">
					</div>
					<div class="col-6 mb-3">
						<label class="text-label"> % FCP</label>
						<input type="text" name="pICMS" id="pICMS" value="<?php echo isset($produto->pICMS) ? $produto->pICMS: "" ?>" class="form-campo menor">
					</div>
					<div class="col-6 mb-3">
						<label class="text-label">% Red. ICMS</label>
						<input type="text" name="vICMS" id="vICMS" value="<?php echo isset($produto->vICMS) ? $produto->vICMS: "" ?>"  class="form-campo menor">
					</div>
					<div class="col-6 mb-3">
						<label class="text-label">Beneficio Fiscal</label>
						<input type="text" name="vICMS" id="vICMS" value="<?php echo isset($produto->vICMS) ? $produto->vICMS: "" ?>"  class="form-campo menor">
					</div>
					<div class="col-6 mb-3">
						<label class="text-label"> Motivo Desoneração</label>
						<select class="form-campo menor" name="icms_orig" id="icms_orig">
							<option value=''>Não definido</option>
                        	@foreach(ConstanteService::motivoDesoneracao() as $ch=>$valor)
                        		<option value='{{$ch}}'>{{$valor}}</option>
                        	@endforeach
						</select>
					</div>
				</div>
			</fieldset>
			</div>
		<div class="col-8">
			<fieldset class="p-2">
			<legend>Tributação ICMS para a NF-e</legend>
				<div class="rows">
					<div class="col-6 mb-3">
						<label class="text-label"> Situação tributária Saída</label>
						<select class="form-campo menor" name="nfe_st_saida" id="nfe_st_saida">
							<option value=''>--Selecione--</option>
                        	@foreach(ConstanteService::listaCST() as $ch=>$valor)
                        		<option value='{{$ch}}'>{{$ch}} - {{$valor}}</option>
                        	@endforeach								
						</select>
					</div>
					<div class="col-6 mb-3">
						<label class="text-label"> Situação tributária Entrada</label>
						<select class="form-campo menor" name="nfe_st_entrada" id="nfe_st_entrada">
							<option value=''>--Selecione--</option>
                        	@foreach(ConstanteService::listaCST() as $ch=>$valor)
                        		<option value='{{$ch}}'>{{$ch}} - {{$valor}}</option>
                        	@endforeach								
						</select>
					</div>
					
					<div class="col-4 mb-3">
						<label class="text-label">% ICMS</label>
						<input type="text" name="nfe_icms" id="nfe_icms" value="<?php echo isset($produto->nfe_icms) ? $produto->nfe_icms: "" ?>" class="form-campo menor">
					</div>
					<div class="col-4 mb-3">
						<label class="text-label">% Red. ICMS</label>
						<input type="text" name="nfe_redicms" id="nfe_redicms" value="<?php echo isset($produto->nfe_redicms) ? $produto->nfe_redicms: "" ?>" class="form-campo menor">
					</div>
					<div class="col-4 mb-3">
						<label class="text-label"> % FCP</label>
						<input type="text" name="nfe_fcp" id="nfe_fcp" value="<?php echo isset($produto->nfe_fcp) ? $produto->nfe_fcp: "" ?>"  class="form-campo menor">
					</div>
					
					<div class="col-4 mb-3">
						<label class="text-label"> Benficio Fiscal</label>
						<input type="text" name="nfe_benefiscal" id="nfe_benefiscal" value="<?php echo isset($produto->nfe_benefiscal) ? $produto->nfe_benefiscal: "" ?>"  class="form-campo menor">
					</div>
					
					<div class="col-6 mb-3">
						<label class="text-label"> Motivo Desoneração</label>
						<select class="form-campo menor" name="nfe_mot_deson" id="nfe_mot_deson">
							<option value=''>Não definido</option>
                        	@foreach(ConstanteService::motivoDesoneracao() as $ch=>$valor)
                        		<option value='{{$ch}}'>{{$valor}}</option>
                        	@endforeach							
						</select>
					</div>
					
					
				</div>
			</fieldset>
			
		</div>
		<div class="col-12">
			<fieldset class="p-2">
			<legend>ICMS ST</legend>
				<div class="rows">
					<div class="col-4 mb-3">
						<label class="text-label"> Modalida. BC ICMS ST</label>
						<select class="form-campo menor" name="modBCST" id="modBCST">
							<option value=''>Nenhuma</option>
                        	@foreach(ConstanteService::listaModalidade() as $ch=>$valor)
                        		<option value='{{$ch}}'>{{$ch}} - {{$valor}}</option>
                        	@endforeach								
						</select>
					</div>
					<div class="col-4 mb-3">
						<label class="text-label"> %MVA ou preço de pauta</label>
						<input type="text" name="pMVAST" id="pMVAST" value="<?php echo isset($produto->pMVAST) ? $produto->pMVAST: "" ?>"  class="form-campo menor">
					</div>
					
					<div class="col-4 mb-3">
						<label class="text-label">%redução de MVA</label>
						<input type="text"  name="pRedBCST" id="pRedBCST"  value="<?php echo isset($produto->pRedBCST) ? $produto->pRedBCST: "" ?>"  class="form-campo menor">
					</div>
					<div class="col-4 mb-3">
						<label class="text-label">Tabela MVA/Pauta</label>
						<select class="form-campo menor" name="modBCST" id="modBCST">
							<option value=''>Nenhuma</option>							
						</select>
					</div>
					
					<div class="col-4 mb-3">
						<label class="text-label">MVA ajustado em op. interestaduais</label>
						<select class="form-campo menor" name="modBCST" id="modBCST">
							<option value=''>Selecione</option>
							<option value='1'>Não Calcular</option>
							<option value='2'>Calcular</option>
							<option value='3'>Calcular para Clientes de Lucro Real/Presumido</option>							
						</select>
					</div>
					
					
					<div class="col-4 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span>Base ICMS ST unit últ. compra</label>
						<input type="text" name="vBCST" id="vBCST" value="<?php echo isset($produto->vBCST) ? $produto->vBCST: "" ?>"  class="form-campo menor">
					</div>
					<div class="col-4 mb-3">
						<label class="text-label">% ICMS ST da última compra</label>
						<input type="text" name="pICMSST" id="pICMSST" value="<?php echo isset($produto->pICMSST) ? $produto->pICMSST: "" ?>"  class="form-campo menor">
					</div>
					<div class="col-4 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> Valor un. ICMS próprio do sub. da Ult. Compra</label>
						<input type="text" name="vICMSST" id="vICMSST" value="<?php echo isset($produto->vICMSST) ? $produto->vICMSST: "" ?>"  class="form-campo menor">
					</div>
					<div class="col-4 mb-3">
						<label class="text-label">Valor de ICMS ST unitário da última compra</label>
						<input type="text" name="pICMSST" id="pICMSST" value="<?php echo isset($produto->pICMSST) ? $produto->pICMSST: "" ?>"  class="form-campo menor">
					</div>
					<div class="col-4 mb-3">
    					<label class="text-label">>Base de FCP ST da Última Compra</label>
    					<input type="text" name="vBCFCPST" id="vBCFCPST" value="<?php echo isset($produto->vBCFCPST) ? $produto->vBCFCPST: "" ?>"  class="form-campo menor">
    				</div>
    				
    				<div class="col-4 mb-3">
    					<label class="text-label"> % FCP ST da Última compra</label>
    					<input type="text" name="pFCPST" id="pFCPST" value="<?php echo isset($produto->pFCPST) ? $produto->pFCPST: "" ?>"  class="form-campo menor">
    				</div>
    				<div class="col-4 mb-3">
    					<label class="text-label"> valor FCP ST unitário da úlitma compra</label>
    					<input type="text" name="vFCPST" id="vFCPST" value="<?php echo isset($produto->vFCPST) ? $produto->vFCPST: "" ?>"  class="form-campo menor">
    				</div>
    				
    				<div class="col-4 mb-3">
    					<label class="text-label"> CEST</label>
    					<input type="text" name="CEST" id="vFCPST" value="<?php echo isset($produto->vFCPST) ? $produto->vFCPST: "" ?>"  class="form-campo menor">
    				</div>
    				<div class="col-4 mb-3">
						<label class="text-label">Escala de Produção</label>
						<select class="form-campo menor" name="escala" >
							<option value=''>Selecione</option>
							<option value='1'>Relevante</option>
							<option value='2'>Não Relevante</option>							
						</select>
					</div>
    				
    				<div class="col-4 mb-3">
    					<label class="text-label"> CNPJ do Faabricante</label>
    					<input type="text" name="CNPJFab" id="vFCPST" value="<?php echo isset($produto->vFCPST) ? $produto->vFCPST: "" ?>"  class="form-campo menor">
    				</div>
				</div>
			</fieldset>
		
		</div>
		</div>									



			</div>									
									<!--INCLUDE-->
					</div>
								
							</div>
							<div id="aba-2">
								<div class="col-12">
									<fieldset class="p-2">
										<legend>IPI</legend>
									<div class="rows">
										<div class="col-6 mb-3">
											<label class="text-label">Situação triburaria</label>
											<select class="form-campo" name="cst_ipi" id="cst_ipi">
												<option>Selecionar</option>
												
											</select>
										</div>
										<div class="col-3 mb-3">
											<label class="text-label"><span class="text-vermelho">*</span> Classe de enquadramento</label>
											<input type="text" name="clEnq" id="clEnq" value="<?php echo isset($produto->clEnq) ? $produto->clEnq: "" ?>"  class="form-campo">
										</div>
										
										<div class="col-3 mb-3">
											<label class="text-label"><span class="text-vermelho">*</span> Código de enquadramento</label>
											<input type="text" name="cEnq" id="cEnq" value="<?php echo isset($produto->cEnq) ? $produto->cEnq: "" ?>"  class="form-campo">
										</div>
										
										<div class="col-4 mb-3">
											<label class="text-label">CNPJ do produtor</label>
											<input type="text" name="CNPJProd" id="CNPJProd" value="<?php echo isset($produto->CNPJProd) ? $produto->CNPJProd: "" ?>"  class="form-campo">
										</div>
										<div class="col-4 mb-3">
											<label class="text-label">Código do selo de controle</label>
											<input type="text" name="cSelo" id="cSelo" value="<?php echo isset($produto->cSelo) ? $produto->cSelo: "" ?>"  class="form-campo">
										</div>
										<div class="col-4 mb-3">
											<label class="text-label">Qtde. do selo de controle</label>
											<input type="text" name="qSelo" id="qSelo" value="<?php echo isset($produto->qSelo) ? $produto->qSelo: "" ?>" class="form-campo">
										</div>
										<div class="col-6 mb-3">
											<label class="text-label">Tipo de cálculo</label>
											<select class="form-campo" name="tipo_calc_ipi" id="tipo_calc_ipi" onchange="seleciona_tipo_calculo();">
                                                <option value="0">Selecione</option>
                                                <option value="1">Porcentagem</option>                                                 
                                                <option value="2">Em valor</option>
                                            </select>
										</div>
										<div class="col-3 mb-3">
											<label class="text-label">Alíquota</label>
											<input type="text" name="pIPI" id="pIPI" value="<?php echo isset($produto->pIPI) ? $produto->pIPI: "" ?>" class="form-campo">
										</div>
										<div class="col-3 mb-3">
											<label class="text-label">Valor por unidade</label>
											<input type="text" name="vUnid" id="vUnid" value="<?php echo isset($produto->vUnid) ? $produto->vUnid: "" ?>"  class="form-campo">
										</div>
										
										<div class="col-3 mb-3">
											<label class="text-label">Qtde total na Unid padrão</label>
											<input type="text" name="qUnid" id="qUnid" value="<?php echo isset($produto->qUnid) ? $produto->qUnid: "" ?>"  class="form-campo">
										</div>
										
										<div class="col-3 mb-3">
											<label class="text-label">Valor do IPI</label> 
											<input type="text" name="vIPI" id="vIPI" value="<?php echo isset($produto->vIPI) ? $produto->vIPI: "" ?>"  class="form-campo">
										</div>
										<div class="col-12 mt-4">
											<label class="text-label"><small>A informação do código de selo, quando aplicavel, deve ser informada utilizando a codificação prevista nos atos normativos editados pela Receita Federal.</small></label> 
										</div>
									</div>
									</fieldset>
								</div>
							</div>
							
							<div id="aba-3">
								<div class="rows">
									<div class="col-6">
										<fieldset class="p-2">
										<legend>PIS</legend>
									<div class="rows">
										<div class="col-12 mb-3">
											<label class="text-label"><span class="text-vermelho">*</span> Situação triburaria</label>
											<select class="form-campo">
												<option>Selecionar</option>
												
											</select>
										</div>
										<div class="col-6 mb-3">
											<label class="text-label">Tipo de cálculo</label>
											<select class="form-campo" name="tipo_calc_pis" id="tipo_calc_pis" onchange="seleciona_tipo_calculo_pis();">
                                                <option value="1">Porcentagem</option>                                                 
                                                <option value="2">Em valor</option>
                                            </select>
										</div>
										<div class="col-6 mb-3">
											<label class="text-label">Valor da base de cálculo</label>
											<input type="text" name="vBCPis" value="<?php echo isset($produto->vBCPis) ? $produto->vBCPis: "" ?>"  class="form-campo">
										</div>
										<div class="col-6 mb-3">
											<label class="text-label">Alíquota (percentual)</label>
											<input type="text" name="pPIS" id="pPIS" value="<?php echo isset($produto->pPIS) ? $produto->pPIS: "" ?>"  class="form-campo">
										</div>
										<div class="col-6 mb-3">
											<label class="text-label">Alíquota (em reais)</label>
											<input type="text" name="vAliqProd_pis" id="vAliqProd_pis" value="<?php echo isset($produto->vAliqProd_pis) ? $produto->vAliqProd_pis: "" ?>"  class="form-campo">
										</div>
										<div class="col-6 mb-3">
											<label class="text-label">Quantidade vendida</label>
											<input type="text" name="qBCProd_pis" value="<?php echo isset($produto->qBCProd_pis) ? $produto->qBCProd_pis: "" ?>"  class="form-campo">
										</div>
										<div class="col-6 mb-3">
											<label class="text-label">Valor PIS</label>
											<input type="text" name="vPIS" id="vPIS" value="<?php echo isset($produto->vPIS) ? $produto->vPIS: "" ?>" class="form-campo">
										</div> 
									</div>
									</fieldset>
									</div>
									
									<div class="col-6 d-flex">
									<fieldset class="p-2 width-100">
										<legend>PIS ST</legend>
										<div class="rows">
											<div class="col-6 mb-3">
												<label class="text-label">Tipo de cálculo</label>
												<input type="text" name="tipo_calc_pisst" id="tipo_calc_pisst"  value="<?php echo isset($produto->tipo_calc_pisst) ? $produto->tipo_calc_pisst: "" ?>"  class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Valor da base de cálculo</label>
												<input type="text" name="vBCPISST" id="vBCPISST" value="<?php echo isset($produto->vBCPISST) ? $produto->vBCPISST: "" ?>"  class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Alíquota (percentual)</label>
												<input type="text" name="pPISST" id="pPISST" value="<?php echo isset($produto->pPISST) ? $produto->pPISST: "" ?>"  class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Alíquota (em reais)</label>
												<input type="text" name="vAliqProdPISST" id="vAliqProdPISST" value="<?php echo isset($produto->vAliqProdPISST) ? $produto->vAliqProdPISST: "" ?>"  class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Quantidade vendida</label>
												<input type="text" name="qBCProdPISST" id="qBCProdPISST" value="<?php echo isset($produto->qBCProdPISST) ? $produto->qBCProdPISST: "" ?>"  class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Valor PIS ST</label>
												<input type="text" name="vPISST" id="vPISST" value="<?php echo isset($produto->vPISST) ? $produto->vPISST: "" ?>"  class="form-campo">
											</div>
											<div class="col-6 mb-3">
											<label class="text-label">valor do PISST compõe valor total da NF-e</label>
											<select class="form-campo" name="indSomaPISST" id="indSomaPISST" >
                                                <option value="0">Não</option>                                                 
                                            	<option value="1">Sim</option>
                                            </select>
										</div> 
										</div>
									</fieldset>
									</div>
								</div>
							</div>
							
							<div id="aba-4">
								<div class="rows">
									<div class="col-6">
										<fieldset class="p-2">
										<legend>Cofins</legend>
									<div class="rows">
										<div class="col-12 mb-3">
											<label class="text-label"><span class="text-vermelho">*</span> Situação triburaria</label>
											<select class="form-campo">
												<option value="">Selecionar</option>
											
											</select>
										</div>
										<div class="col-6 mb-3">
											<label class="text-label">Tipo de cálculo</label>
											<select class="form-campo" name="tipo_calc_cofins" id="tipo_calc_cofins" onchange="seleciona_tipo_calculo_pis();">
                                                <option value="1">Porcentagem</option>                                                 
                                                <option value="2">Em valor</option>
                                                
                                            </select>
										</div>
										<div class="col-6 mb-3">
											<label class="text-label">Valor da base de cálculo</label>
											<input type="text" name="vBCCofins" id="vBCCofins" value="<?php echo isset($produto->vBCCofins) ? $produto->vBCCofins: "" ?>"  class="form-campo">
										</div>
										<div class="col-6 mb-3">
											<label class="text-label">Alíquota (percentual)</label>
											<input type="text" name="pCofins" id="pCofins" value="<?php echo isset($produto->pCofins) ? $produto->pCofins: "" ?>"  class="form-campo">
										</div>
										<div class="col-6 mb-3">
											<label class="text-label">Alíquota (em reais)</label>
											<input type="text" name="vAliqProd_cofins" id="vAliqProd_cofins" value="<?php echo isset($produto->vAliqProd_cofins) ? $produto->vAliqProd_cofins: "" ?>"  class="form-campo">
										</div>
										<div class="col-6 mb-3">
											<label class="text-label">Quantidade vendida</label>
											<input type="text" name="qBCProd_cofins" value="<?php echo isset($produto->qBCProd_cofins) ? $produto->qBCProd_cofins: "" ?>"  class="form-campo">
										</div>
										<div class="col-6 mb-3">
											<label class="text-label">Valor PIS</label>
											<input type="text" name="vCofins" id="vCofins" value="<?php echo isset($produto->vCofins) ? $produto->vCofins: "" ?>" class="form-campo">
										</div> 
										
										
                                            
									</div>
									</fieldset>
									</div>
									
									<div class="col-6 d-flex">
									<fieldset class="p-2 width-100">
										<legend>Cofins ST</legend>
										<div class="rows">
											<div class="col-6 mb-3">
												<label class="text-label">Tipo de cálculo</label>
												<input type="text" name="tipo_calc_cofinsst" id="tipo_calc_cofinsst"  value="<?php echo isset($produto->tipo_calc_cofinsst) ? $produto->tipo_calc_cofinsst: "" ?>"  class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Valor da base de cálculo</label>
												<input type="text" name="vBCCOFINSST" id="vBCCOFINSST" value="<?php echo isset($produto->vBCCOFINSST) ? $produto->vBCCOFINSST: "" ?>"  class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Alíquota (percentual)</label>
												<input type="text" name="pCOFINSST" id="pCOFINSST" value="<?php echo isset($produto->pCOFINSST) ? $produto->pCOFINSST: "" ?>"  class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Alíquota (em reais)</label>
												<input type="text" name="vAliqProdCOFINSST" id="vAliqProdCOFINSST" value="<?php echo isset($produto->vAliqProdCOFINSST) ? $produto->vAliqProdCOFINSST: "" ?>"  class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Quantidade vendida</label>
												<input type="text" name="qBCProdCOFINSST" id="qBCProdCOFINSST" value="<?php echo isset($produto->qBCProdCOFINSST) ? $produto->qBCProdCOFINSST: "" ?>"  class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Valor PIS ST</label>
												<input type="text" name="vCOFINSST" id="vCOFINSST" value="<?php echo isset($produto->vCOFINSST) ? $produto->vCOFINSST: "" ?>"  class="form-campo">
											</div> 
											<div class="col-6 mb-3">
											<label class="text-label">valor do COFINSST compõe valor total da NF-e</label>
        										<select class="form-campo" name="indSomaCOFINSST" id="indSomaCOFINSST" >
                                                    <option value="0">Não</option>                                                 
                                                    <option value="1">Sim</option>
                                                </select>
                                        	</div>
										</div>
									</fieldset>
									</div>
								</div>
							</div>
							
							
					<div id="aba-5">
							
								<div class="col-12">
									<fieldset class="p-2">
										<legend>Simples nacional</legend>
									<div class="rows">
										<div class="col-6 mb-3">
											<label class="text-label"><span class="text-vermelho">*</span> Situação triburaria</label>
											<select class="form-campo" name="cst_icmssn" id="cst_icmssn" onchange="selecionar_cst_icms()">
												
												<option value="">Selecionar</option>
												
											</select>
										</div>										
										<div class="col-6 mb-3">
											<label class="text-label"><span class="text-vermelho">*</span> Origem</label>
											<select class="form-campo" name="icms_orig" id="icms_orig1">
												<option value="">Selecionar</option>
												
											</select>
										</div>
									</div>
									</fieldset>
									
									<!--AQUI INCLUDE-->
<div class="" id="mostrar_icms">
									
<div class="rows">
		<div class="col-6">
			<fieldset class="p-2">
			<legend>ICMS</legend>
				<div class="rows">
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> Modalida. determ. da BC ICMS</label>
						<select class="form-campo menor" name="modBCSN" id="modBCSN">
							<option value="">Selecionar</option>
								
						</select>
					</div>
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> Valor BC ICMS</label>
						<input type="text" name="vBCSN" id="vBCSN" value="" class="form-campo menor">
					</div>
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> Alíquota do ICMS</label>
						<input type="text" name="pICMSSN" id="pICMSSN" value="" class="form-campo menor">
					</div>					
					
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> ICMS</label>
						<input type="text" name="vICMSSN" id="vICMSSN" value=""  class="form-campo menor">
					</div>
					
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> Alíq. Cálc. Crédito SN</label>
						<input type="text" name="pCredSN" id="pCredSN" value=""  class="form-campo menor">
					</div>
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> Valor crédito do ICMS  SN</label>
						<input type="text" name="vCredICMSSN" id="vCredICMSSN" value=""  class="form-campo menor">
					</div>
					
					<div class="col-6 mb-3">
    					<label class="text-label"><span class="text-vermelho">*</span> Percentual da Redução de BC</label>
    					<input type="text" name="pRedBCSN" id="pRedBCSN" value=""  class="form-campo menor">
    				</div>
    				<div class="col-6 mb-3">
    					<label class="text-label"><span class="text-vermelho">*</span> Valor da BC efetiva</label>
    					<input type="text" name="vBCEfetSN" id="vBCEfetSN" value=""  class="form-campo menor">
    				</div>
    				
    				<div class="col-6 mb-3">
    					<label class="text-label"><span class="text-vermelho">*</span> Valor do ICMS próprio do Substituto</label>
    					<input type="text" name="vICMSSubstitutoSN" id="vICMSSubstitutoSN" value=""  class="form-campo menor">
    				</div>
					
					
				</div>
			</fieldset>
		</div>
		<div class="col-6">
			<fieldset class="p-2">
			<legend>ICMS ST</legend>
				<div class="rows">
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> Modalida. determ.  BC ICMS ST</label>
						<select class="form-campo menor" name="modBCSTSN" id="modBCSTSN">
							<option value="">Selecionar</option>
								
						</select>
					</div>
					<div class="col-6 mb-3">
						<label class="text-label">%redução da BC ICMS ST</label>
						<input type="text"  name="pRedBCSTSN" id="pRedBCSTSN"  value=""  class="form-campo menor">
					</div>
					<div class="col-6 mb-3">
						<label class="text-label"> %margem de valor adic. ICMS ST</label>
						<input type="text" name="pMVASTSN" id="pMVASTSN" value=""  class="form-campo menor">
					</div>
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> BC ICMS ST</label>
						<input type="text" name="vBCSTSN" id="vBCSTSN" value=""  class="form-campo menor">
					</div>
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> Alíquota do ICMS ST</label>
						<input type="text" name="pICMSSTSN" id="pICMSSTSN" value=""  class="form-campo menor">
					</div>
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> ICMS ST</label>
						<input type="text" name="vICMSSTSN" id="vICMSSTSN" value=""  class="form-campo menor">
					</div>
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> Valor da BC do FCP ST</label>
						<input type="text" name="vBCFCPSTSN" id="vBCFCPSTSN" value=""  class="form-campo menor">
					</div>
					
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> Percentual FCP ST (%)</label>
						<input type="text" name="pFCPSTSN" id="pFCPSTSN" value=""  class="form-campo menor">
					</div>
					
					<div class="col-6 mb-3">
						<label class="text-label"><span class="text-vermelho">*</span> Valor do FCP ST</label>
						<input type="text" name="vFCPSTSN" id="vFCPSTSN" value=""  class="form-campo menor">
					</div>
				</div>
			</fieldset>
			
		</div>
	
		</div>									

<div class="rows">
	<div class="col-6">
		<fieldset class="p-2">
		<legend>ICMS RETIDO</legend>
			<div class="rows">
				<div class="col-6 mb-3">
					<label class="text-label"><span class="text-vermelho">*</span> Motivo Desoneração</label>
					<input type="text" name="vBCSTRetSN" id="vBCSTRetSN" value=""  class="form-campo menor">
				</div>			
				<div class="col-6 mb-3">
					<label class="text-label"><span class="text-vermelho">*</span> Valor do ICMS ST retido</label>
					<input type="text" name="vICMSSTRetSN" id="vICMSSTRetSN" value=""  class="form-campo menor">
				</div>
				<div class="col-6 mb-3">
					<label class="text-label"><span class="text-vermelho">*</span> Perc. FCP Ret. ST(%)</label>
					<input type="text" name="pFCPSTRetSN" id="pFCPSTRetSN" value=""  class="form-campo menor">
				</div>
				
				<div class="col-6 mb-3">
					<label class="text-label"><span class="text-vermelho">*</span> Valor FCP Ret. ST</label>
					<input type="text" name="vFCPSTRetSN" id="vFCPSTRetSN" value=""  class="form-campo menor">
				</div>
				<div class="col-6 mb-3">
					<label class="text-label"><span class="text-vermelho">*</span> Valor BC FCP Ret. ST</label>
					<input type="text" name="vBCFCPSTRetSN" id="vBCFCPSTRetSN" value=""  class="form-campo menor">
				</div>
				<div class="col-6 mb-3">
					<label class="text-label"><span class="text-vermelho">*</span> Valor do ICMS ST retido</label>
					<input type="text" name="pSTSN" id="pSTSN" value=""  class="form-campo menor">
				</div>
			</div>
		</fieldset>							
	</div>
	<div class="col-6">
		<fieldset class="p-2">
		<legend>ICMS Efetivo</legend>
			<div class="rows">
				<div class="col-6 mb-3">
					<label class="text-label"><span class="text-vermelho">*</span> Perc. Red. BC Efetiva(%)</label>
					<select class="form-campo menor" name="pRedBCEfet" id="pRedBCEfet"></select>
				</div>
				<div class="col-6 mb-3">
					<label class="text-label">Valor BC Efetiva</label>
					<input type="text" name="vBCEfetSN" id="vBCEfetSN" value="" class="form-campo menor">
				</div>
				<div class="col-6 mb-3">
					<label class="text-label"> Aliq. ICMS Efet. (%) </label>
					<input type="text" name="pICMSEfetSN" id="pICMSEfetSN" value=""  class="form-campo menor">
				</div>
				<div class="col-6 mb-3">
					<label class="text-label"> Valor ICMS Efet. </label>
					<input type="text" name="vICMSEfetSN" id="vICMSEfetSN" value=""  class="form-campo menor">
				</div>				
				
			</div>
		</fieldset>
	
	</div>
</div>







	
	
	
			</div>									
									<!--INCLUDE-->
									
								</div>
								
							</div>							
							
							
							
							
							
							
							
							
							
							
							<div id="aba-6">								
									<div class="col-12">
									<fieldset class="p-2 width-100">
										<legend>Imposto de importação</legend>
										<div class="rows">
											<div class="col-6 mb-3">
												<label class="text-label">Valor da base de cálculo</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Valor despesas aduaneiras</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Valor do IOF</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Valor imposto de importação</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
										</div>
									</fieldset>
									</div>
							</div>
							
							
							
							<div id="aba-7">
								<div class="col-12">
									<fieldset class="p-2 width-100">
										<legend>IPI devolvido</legend>
										<div class="rows">
											<div class="col-6 mb-3">
												<label class="text-label">Percentual da mercadoria devolvida</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Valor do IPI devolvido</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
										</div>
									</fieldset>
								</div>
							</div> 
							
							<div id="aba-8">
								<div class="col-12">
									<fieldset class="p-2 width-100">
										<legend>IPI devolvido</legend>
										<div class="rows">
											<div class="col-6 mb-3">
												<label class="text-label">Percentual ICMS relativo ao FCP na UF de destino</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Valor da base cálculo na UF de destinatário</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Valor da base cálculo  FCP na UF do destinatário</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Alíquota interna da UF do destinatário</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Alíquota interestadual</label>
												<select class="form-campo">
													<option>Selecionar</option>
												</select>
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Percentual provisória de partilha</label>
												<select class="form-campo">
													<option>Selecionar</option>
												</select>
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Valor ICMS de partilha para UF do destinatário</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Valor ICMS de partilha para UF do remetente</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-3">
												<label class="text-label">Valor ICMS relativo ao FCP da UF de destino<label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
										</div>
									</fieldset>
								</div>
							</div>
							
					</div>  
				</div>
				<div class="col-12 text-center">
					<input type="Submit" value="Salvar" class="btn btn-azul m-auto">
				</div>
			 
			</div>
			</div>
			 
			
		</div>
		</form>
	</div>
</section>
