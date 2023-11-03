<fieldset class="mt-3">
<legend class="h5 mb-0 text-left">Frete</legend>
<div class="rows px-2">
    <div class="col-10 mb-3">
        <label class="text-label">Modalidade do frete</label>	
        <select class="form-campo" name="modFrete" id="modFrete">
			<option value="0" <?php echo ($notafiscal->modFrete==0) ? "selected" : null?>>0 - Frete por conta do Remetente (CIF)</option>
			<option value="1" <?php echo ($notafiscal->modFrete==1) ? "selected" : null?>>1 - Frete por conta do Destinatário (FOB)</option>
			<option value="2" <?php echo ($notafiscal->modFrete==2) ? "selected" : null?>>2 - Frete por conta de Terceiros</option>
			<option value="3" <?php echo ($notafiscal->modFrete==3) ? "selected" : null?>>3 - Transporte Próprio por conta do Remetente</option>
			<option value="4" <?php echo ($notafiscal->modFrete==4) ? "selected" : null?>>4 - Transporte Próprio por conta do Destinatário</option>
			<option value="9" <?php echo ($notafiscal->modFrete==9) ? "selected" : null?>>9 - Sem Ocorrência de Transporte</option>
		</select>
	</div>
	
</div>
</fieldset>
<fieldset class="mt-2">
<legend class="h5 mb-0 text-left">Listagem de Transportadora</legend>
			<div class="rows p-2">
				<div class="col-6 position-relative mb-3">
				   <label class="text-label">Nome da transportadora (<a href="javascript:;" onclick="listarTransportadora()" class="btn btn-roxo d-inline-block btn-pequeno" style="padding: 0.25rem 0.6rem;">Buscar</a>)</label>
					<div class="group-btn">	  
                       <input type="text" name="transp_xNome" id="transp_xNome" value="<?php echo  $notafiscal->transp_xNome ?? old('transp_xNome') ?>"  class="form-campo">
						<a href="javascript:;" onclick="abrirModal('#modalCadTransportadora')" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
					</div>											
				</div>					
			
				<div class="col-3 mb-3">
                    <label class="text-label">CNPJ/CPF transport.</label>	
                    <input type="text" name="transp_CNPJ"  id="transp_CNPJ" value="<?php echo  $notafiscal->transp_CNPJ ?? old('transp_CNPJ') ?>"  class="form-campo">
				</div>
				<div class="col-3 mb-3">
                    <label class="text-label">Inscr. Est. transp.</label>	
                    <input type="text" name="transp_IE" id="transp_IE" value="<?php echo  $notafiscal->transp_IE ?? old('transp_IE') ?>"  class="form-campo">
				</div>
				<div class="col-6 mb-3">
                    <label class="text-label">Endereço completo</label>	
                    <input type="text" name="transp_xEnder" id="transp_xEnder" value="<?php echo $notafiscal->transp_xEnder ?? old('transp_xEnder') ?>"  class="form-campo">
				</div>
				<div class="col-4 mb-3">
                    <label class="text-label">Município</label>	
                    <input type="text" name="transp_xMun" id="transp_xMun" value="<?php echo  $notafiscal->transp_xMun ?? old('transp_xMun') ?>"  class="form-campo">
				</div>
				
				<div class="col-2 mb-3">
                    <label class="text-label">UF transportador</label>	
                    <input type="text" name="transp_UF" id="transp_UF" value="<?php echo  $notafiscal->transp_UF ?? old('transp_UF') ?>"  class="form-campo">
                </div>		
			</div>
	</fieldset>
	
<fieldset class="mt-2">
<legend class="h5 mb-0 text-left">Veículo/Reboque/Balsa/Vagão</legend>
			<div class="rows p-2">				
				<div class="col-4 mb-3">
                    <label class="text-label">Placa veículo</label>	
                    <input type="text" name="transp_placa" id="transp_placa" value="<?php echo  $notafiscal->transp_placa ?? old('transp_placa') ?>"  class="form-campo">
				</div>
				<div class="col-4 mb-3">
                    <label class="text-label">UF veículo</label>	
                     <input type="text" name="UF_placa" id="UF_placa" value="<?php echo $notafiscal->UF_placa ?? old('UF_placa') ?>"  class="form-campo">
                    
				</div>
				<div class="col-4 mb-3">
                    <label class="text-label">Reg. Nac. Trans. Carga</label>	                   
                    <input type="text" name="RNTC" id="RNTC" value="<?php echo $notafiscal->RNTC ?? old('RNTC') ?>"  class="form-campo">
				</div>
				<div class="col-6 mb-3">
                    <label class="text-label">Identificação vagão</label>	                   
                    <input type="text" name="transp_vagao" id="transp_vagao" value="<?php echo $notafiscal->transp_vagao ?? old('transp_vagao') ?>"  class="form-campo">
				</div>
				<div class="col-6 mb-3">
                    <label class="text-label">Identificação balsa</label>	                   
                    <input type="text" name="transp_balsa" id="transp_balsa" value="<?php echo $notafiscal->transp_balsa ?? old('transp_balsa') ?>"  class="form-campo">
				</div>
			</div>	
</fieldset>



			
			<!--mostra mais opções ocultas 
			<div class="item limpo"> 
				<div class="p-3 check on"><label class="filtro text-verde h5 mb-0"><input type="checkbox" name="" class="d-none">  Informar retenções de ICMS de transporte</label></div>
				<div class="mostraFiltro">									
					<fieldset>
					<legend class="h5 mb-0 text-left">Retenção ICMS transporte</legend>
					<div class="rows p-2">
						<div class="col mb-1">
							<label class="text-label">Valor do serviço</label>	                   
							<input type="text" name="ret_tran_vserv" id="ret_tran_vserv" value="<?php echo isset($notafiscal) ? $notafiscal->rettransp_vServ : NULL ?>"  class="form-campo">
						</div>
						<div class="col mb-1">
							<label class="text-label">BC retenção ICMS</label>	                   
							<input type="text" name="ret_tran_vbc" id="ret_tran_vbc" value="<?php echo isset($notafiscal) ? $notafiscal->vBCRet : NULL ?>"  class="form-campo">
						</div>
						<div class="col mb-1">
							<label class="text-label">Alíq. da retenção</label>	                   
							<input type="text" name="ret_tran_pcims"  id="ret_tran_pcims" value="<?php echo isset($notafiscal) ? $notafiscal->pICMSRet : NULL ?>"  class="form-campo">
						</div>
						<div class="col mb-1">
							<label class="text-label">Valor ICMS retido</label>	                   
							<input type="text" name="ret_tran_vicms" id="ret_tran_vicms" value="<?php echo isset($notafiscal) ? $notafiscal->vICMSRet : NULL ?>"  class="form-campo">
						</div>
						<div class="col mb-1">
							<label class="text-label">CFOP transp</label>	                   
							<input type="text" name="ret_tran_cfop"  id="ret_tran_cfop"value="<?php echo isset($notafiscal) ? $notafiscal->ret_CFOP : NULL ?>"  class="form-campo">
						</div>
						<div class="col mb-1">
							<label class="text-label">Município do ICMS</label>	
							<input type="text" name="ret_tran_cmunfg" id="ret_tran_cmunfg" value="<?php echo isset($notafiscal) ? $notafiscal->rettransp_cMunFG : NULL ?>"  class="form-campo">
							                   
						</div>
					</div>
</fieldset>					
				</div>               
			</div>    
-->
			<fieldset>
				<legend class="h5 mb-0 text-left">Volumes transportados</legend>
			<div class="rows p-2">
				<div class="col mb-1">
					<label class="text-label">Quantidade de vol.</label>	                   
					<input type="text" name="vol_qtde" id="vol_qtde" value="<?php echo $notafiscal->qVol ?? old('qVol') ?>"  class="form-campo">
				</div> 
				<div class="col mb-1">
					<label class="text-label">Espécie dos vol.</label>	                   
					<input type="text" name="vol_especie" id="vol_especie" value="<?php echo $notafiscal->esp ?? old('esp') ?>"  class="form-campo">
				</div>

				<div class="col mb-1">
					<label class="text-label">Marca dos volumes</label>	                   
					<input type="text" name="vol_marca" id="vol_marca" value="<?php echo $notafiscal->marca ?? old('marca') ?>"  class="form-campo">
				</div>      
				<div class="col mb-1">
					<label class="text-label">Numeração dos vol.</label>	                   
					<input type="text" name="vol_numeraco" id="vol_numeraco" value="<?php echo $notafiscal->nVol ?? old('nVol') ?>"  class="form-campo">
				</div>      
				<div class="col mb-1">
					<label class="text-label">Peso líquido</label>	                   
					<input type="text" name="vol_peso_liq" id="vol_peso_liq" value="<?php echo $notafiscal->pesoL ?? old('pesoL') ?>"  class="form-campo">
				</div>     
				<div class="col mb-1">
					<label class="text-label">Peso bruto</label>	                   
					<input type="text" name="vol_peso_bruto"  id="vol_peso_bruto" value="<?php echo $notafiscal->pesoB ?? old('pesoB') ?>"  class="form-campo">
				</div>      
				<div class="col mb-1">
					<label class="text-label">Números dos lacres</label>	                   
					<input type="text" name="vol_lacre" id="vol_lacre" value="<?php echo $notafiscal->nLacre ?? old('nLacre') ?>"  class="form-campo">
				</div>           
			</div>
			</fieldset>