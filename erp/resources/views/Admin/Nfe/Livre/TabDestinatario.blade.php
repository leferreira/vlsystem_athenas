

<fieldset class="mt-2">
<legend class="h5 mb-0 text-left">Destinatário</legend>										
        <div class="rows p-2">	
			
            <div class="col-6 mb-1">
                    <label class="text-label">Nome / Razão Social </label>	
                    <input type="text" name="xNomeDestinatario" name="xNomeDestinatario" id="xNomeDestinatario" value="<?php echo isset($destinatario) ? $destinatario->dest_xNome : NULL ?>" class="form-campo">
            </div>
            <div class="col-3 mb-1">
                <label class="text-label">CNPJ </label>
                <input type="text" name="CNPJDestinatario" id="CNPJDestinatario" value="<?php echo isset($destinatario) ? $destinatario->dest_CNPJ : NULL ?>" class="form-campo">
            </div>
            
            <div class="col-3 mb-1">
                <label class="text-label">CPF </label>
                <input type="text" name="CPFDestinatario" id="CPFDestinatario" value="<?php echo isset($destinatario) ? $destinatario->dest_CPF : NULL ?>" class="form-campo">
            </div>
                     
            <div class="col-3 mb-1">
                <label class="text-label">Inscr. Estadual</label>	
                <input type="text" name="IEDestinatario" id="IEDestinatario" value="<?php echo isset($destinatario) ? $destinatario->dest_IE : NULL ?>" class="form-campo">
            </div>
            <div class="col-3 mb-1">
                    <label class="text-label">Inscr. Municipal</label>	
                    <input type="text" name="IMDestinatario" id="IMDestinatario" value="<?php echo isset($destinatario) ? $destinatario->dest_IM : NULL ?>" class="form-campo">
            </div>
            <div class="col-3 mb-1">
                <label class="text-label">Insc. Suframa.</label>	
                <input type="text" name="ISUFDestinatario" id="ISUFDestinatario" value="<?php echo isset($destinatario) ? $destinatario->dest_ISUF : NULL ?>" class="form-campo">
            </div>	
            	 
            <div class="col-3 mb-1">
                    <label class="text-label">Ind. Estrangeiro</label>	
                    <input type="text" name="idEstrangeiro" id="idEstrangeiro" value="<?php echo isset($destinatario) ? $destinatario->dest_idEstrangeiro : NULL ?>"  class="form-campo">
            </div>
            
            <div class="col-4 mb-1">
                    <label class="text-label">Email</label>	
                    <input type="text" name="emailDestinatario" id="emailDestinatario" value="<?php echo isset($destinatario) ? $destinatario->dest_email : NULL ?>" class="form-campo">
            </div>
            
             <div class="col-8 mb-1">
            <label class="text-label">Indicador IE Dest</label>	
            <?php $indIEDest = $destinatario->dest_indIEDest ?? null ?>
                 <select class="form-campo" name="indIEDest" id="indIEDest">
                    <option value="1" <?php echo ($indIEDest =="1") ? "selected": NULL ?>>01- Contribuinte ICMS (informar a IE do destinatário)</option> 
                    <option value="2" <?php echo ($indIEDest =="2") ? "selected": NULL ?>>02 - Contribuinte isento de Inscrição no cadastro de Contribuintes do ICMS</option> 
                    <option value="9" <?php echo ($indIEDest =="9") ? "selected": NULL ?>>09 - Não Contribuinte, que pode ou não possuir Inscrição Estadual no Cadastro de Contribuintes do ICMS</option> 
                </select>
            </div>
   </div>
   </fieldset>
    
	<fieldset class="mt-2">
   <legend class="h5 mb-0 text-left">Endereço Destinatário</legend>	    
	<div class="rows p-2"> 
			<div class="col-6 mb-1">
                    <label class="text-label">Logradouro</label>	
                    <input type="text" name="xLgrDestinatario" id="xLgrDestinatario"  value="<?php echo isset($destinatario) ? $destinatario->dest_xLgr : NULL ?>" class="form-campo">
            </div>
            
            <div class="col-2 mb-1">
                    <label class="text-label">Numero</label>	
                    <input type="text" name="nroDestinatario" id="nroDestinatario"  value="<?php echo isset($destinatario) ? $destinatario->dest_nro : NULL ?>"  class="form-campo">
            </div>
            
            <div class="col-4 mb-1">
                <label class="text-label">Complemento</label>	
                <input type="text" name="xCplDestinatario" id="xCplDestinatario"  value="<?php echo isset($destinatario) ? $destinatario->dest_xCpl : NULL ?>" class="form-campo">
            </div>
            
            <div class="col-4 mb-1">
                    <label class="text-label">Bairro</label>	
                    <input type="text" name="xBairroDestinatario" id="xBairroDestinatario"  value="<?php echo isset($destinatario) ? $destinatario->dest_xBairro : NULL ?>"  class="form-campo">
            </div>
            
	   		<div class="col-2 mb-1">
                <label class="text-label">CEP</label>
                 <div class="input-grupo">
                 <input type="text"  name="CEPDestinatario" id="CEPDestinatario"  value="<?php echo isset($destinatario) ? $destinatario->dest_CEP : NULL ?>" class="form-campo">

                 </div>
            </div>
             <div class="col-2 mb-1">
                     <label class="text-label">Telefone</label>	
                     <input type="text" name="foneDestinatario" id="foneDestinatario"  value="<?php echo isset($destinatario) ? $destinatario->dest_fone : NULL ?>" class="form-campo">
             </div>            
            <div class="col-4 mb-2">
                    <label class="text-label">UF</label>	
                    <input type="text" name="UFDestinatario" id="UFDestinatario"  value="<?php echo isset($destinatario) ? $destinatario->dest_UF : NULL ?>" class="form-campo">
                
            </div>
           
            <div class="col-3 mb-1">
                <label class="text-label">Cidade</label>	
                 <input type="text" name="xMunDestinatario" id="xMunDestinatario"  value="<?php echo isset($destinatario) ? $destinatario->dest_xMun : NULL ?>" class="form-campo">
                
             </div>               

			 <div class="col-3 mb-1">
                <label class="text-label">IBGE</label>	
                 <input type="text" name="cMunDestinatario" id="cMunDestinatario"  value="<?php echo isset($destinatario) ? $destinatario->dest_cMun : NULL ?>" class="form-campo">
                
             </div> 
		         
            </div>	
     </fieldset>
	 
 
          
