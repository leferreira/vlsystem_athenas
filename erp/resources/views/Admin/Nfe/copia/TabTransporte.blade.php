<fieldset class="mt-3">
<legend class="h5 mb-0 text-left">Frete</legend>
<div class="rows px-2">
    <div class="col-10 mb-3">
        <label class="text-label">Modalidade do frete</label>	
        <select class="form-campo" name="modfrete" id="modfrete">
			<option value="0" <?php echo ($notafiscal->modFrete==0) ? "selected" : null?>>0 - Frete por conta do Remetente (CIF)</option>
			<option value="1" <?php echo ($notafiscal->modFrete==1) ? "selected" : null?>>1 - Frete por conta do Destinatário (FOB)</option>
			<option value="2" <?php echo ($notafiscal->modFrete==2) ? "selected" : null?>>2 - Frete por conta de Terceiros</option>
			<option value="3" <?php echo ($notafiscal->modFrete==3) ? "selected" : null?>>3 - Transporte Próprio por conta do Remetente</option>
			<option value="4" <?php echo ($notafiscal->modFrete==4) ? "selected" : null?>>4 - Transporte Próprio por conta do Destinatário</option>
			<option value="9" <?php echo ($notafiscal->modFrete==9) ? "selected" : null?>>9 - Sem Ocorrência de Transporte</option>
		</select>
	</div>
	<div class="col-2 mt-1 pt-1">
        <input type="button" onclick="salvarTransporte()" value="Salvar" class="btn btn-azul text-uppercase width-100" />
    </div>
</div>
</fieldset>
<fieldset class="mt-2">
<legend class="h5 mb-0 text-left">Listagem de Transportadora</legend>
			<div class="rows p-2">
				<div class="col-6 mb-3">
				   <label class="text-label">Nome da transportadora (<a href="javascript:;" onclick="abrirModal('#janela_transportadora')" class="btn btn-roxo d-inline-block btn-pequeno" style="padding: 0.25rem 0.6rem;">Buscar</a>)</label>
                    <input type="text" name="transp_xnome" id="transp_xnome" value="<?php echo isset($transportadora) ? $transportadora->xNome : NULL ?>"  class="form-campo">
				</div>
				<div class="col-3 mb-3">
                    <label class="text-label">CNPJ/CPF transport.</label>	
                    <input type="text" name="transp_cnpj"  id="transp_cnpj" value="<?php echo isset($transportadora) ? $transportadora->CNPJ : NULL ?>"  class="form-campo">
				</div>
				<div class="col-3 mb-3">
                    <label class="text-label">Inscr. Est. transp.</label>	
                    <input type="text" name="transp_ie" id="transp_ie" value="<?php echo isset($transportadora) ? $transportadora->IE : NULL ?>"  class="form-campo">
				</div>
				<div class="col-6 mb-3">
                    <label class="text-label">Endereço completo</label>	
                    <input type="text" name="transp_xender" id="transp_xender" value="<?php echo isset($transportadora) ? $transportadora->xEnder : NULL ?>"  class="form-campo">
				</div>
				<div class="col-4 mb-3">
                    <label class="text-label">Município</label>	
                    <input type="text" name="transp_mun" id="transp_mun" value="<?php echo isset($transportadora) ? $transportadora->xMun : NULL ?>"  class="form-campo">
				</div>
				
				<div class="col-2 mb-3">
                    <label class="text-label">UF transportador</label>	
                    <input type="text" name="transp_uf" id="transp_uf" value="<?php echo isset($transportadora) ? $transportadora->UF : NULL ?>"  class="form-campo">
                </div>		
			</div>
	</fieldset>
	
<fieldset class="mt-2">
<legend class="h5 mb-0 text-left">Veículo/Reboque/Balsa/Vagão</legend>
			<div class="rows p-2">				
				<div class="col-4 mb-3">
                    <label class="text-label">Placa veículo</label>	
                    <input type="text" name="transp_placa" id="transp_placa" value="<?php echo isset($notafiscal) ? $notafiscal->placa_reboque : NULL ?>"  class="form-campo">
				</div>
				<div class="col-4 mb-3">
                    <label class="text-label">UF veículo</label>	
                     <input type="text" name="transp_ufveic" id="transp_ufveic" value="<?php echo isset($notafiscal) ? $notafiscal->UF_reboque : NULL ?>"  class="form-campo">
                    
				</div>
				<div class="col-4 mb-3">
                    <label class="text-label">Reg. Nac. Trans. Carga</label>	                   
                    <input type="text" name="transp_rntc" id="transp_rntc" value="<?php echo isset($notafiscal) ? $notafiscal->RNTC_reboque : NULL ?>"  class="form-campo">
				</div>
				<div class="col-6 mb-3">
                    <label class="text-label">Identificação vagão</label>	                   
                    <input type="text" name="transp_vagao" id="transp_vagao" value="<?php echo isset($notafiscal) ? $notafiscal->vagao : NULL ?>"  class="form-campo">
				</div>
				<div class="col-6 mb-3">
                    <label class="text-label">Identificação balsa</label>	                   
                    <input type="text" name="transp_balsa" id="transp_balsa" value="<?php echo isset($notafiscal) ? $notafiscal->balsa : NULL ?>"  class="form-campo">
				</div>
			</div>	
</fieldset>



			
			<!--mostra mais opções ocultas -->
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

			<fieldset>
				<legend class="h5 mb-0 text-left">Volumes transportados</legend>
			<div class="rows p-2">
				<div class="col mb-1">
					<label class="text-label">Quantidade de vol.</label>	                   
					<input type="text" name="vol_qtde" id="vol_qtde" value="<?php echo isset($notafiscal) ? $notafiscal->qVol : NULL ?>"  class="form-campo">
				</div> 
				<div class="col mb-1">
					<label class="text-label">Espécie dos vol.</label>	                   
					<input type="text" name="vol_especie" id="vol_especie" value="<?php echo isset($notafiscal) ? $notafiscal->esp : NULL ?>"  class="form-campo">
				</div>

				<div class="col mb-1">
					<label class="text-label">Marca dos volumes</label>	                   
					<input type="text" name="vol_marca" id="vol_marca" value="<?php echo isset($notafiscal) ? $notafiscal->marca : NULL ?>"  class="form-campo">
				</div>      
				<div class="col mb-1">
					<label class="text-label">Numeração dos vol.</label>	                   
					<input type="text" name="vol_numeraco" id="vol_numeraco" value="<?php echo isset($notafiscal) ? $notafiscal->nVol : NULL ?>"  class="form-campo">
				</div>      
				<div class="col mb-1">
					<label class="text-label">Peso líquido</label>	                   
					<input type="text" name="vol_peso_liq" id="vol_peso_liq" value="<?php echo isset($notafiscal) ? $notafiscal->pesoL : NULL ?>"  class="form-campo">
				</div>     
				<div class="col mb-1">
					<label class="text-label">Peso bruto</label>	                   
					<input type="text" name="vol_peso_bruto"  id="vol_peso_bruto" value="<?php echo isset($notafiscal) ? $notafiscal->pesoB : NULL ?>"  class="form-campo">
				</div>      
				<div class="col mb-1">
					<label class="text-label">Números dos lacres</label>	                   
					<input type="text" name="vol_lacre" id="vol_lacre" value="<?php echo isset($notafiscal) ? $notafiscal->nLacre : NULL ?>"  class="form-campo">
				</div>           
			</div>
			</fieldset>
<script src="{{ asset('assets/js/NFE/tabTransporte_js.js')}}"> </script>