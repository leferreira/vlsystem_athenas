
<div class="rows">
        <div class="col-12 mt-4">
               <a href="javascript:;" onclick="abrirModal('#janela_listagem_contato')" class="btn btn-roxo d-inline-block"><i class="fa fa-search"></i> Buscar</a>
                <a href="" class="btn btn-azul d-inline-block"><i class="fa fa-box"></i> Cadastrar novo</a>					
                <button onclick="salvarDestinatario()"   name="aba02" class="btn btn-outline-verde float-right text-uppercase"><i class="far fa-save"></i> Salvar</button>
        </div>
</div>
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
            
            <div class="col-6 mb-1">
                    <label class="text-label">Email</label>	
                    <input type="text" name="emailDestinatario" id="emailDestinatario" value="<?php echo isset($destinatario) ? $destinatario->dest_email : NULL ?>" class="form-campo">
            </div>
            
             <div class="col-6 mb-1">
            <label class="text-label">Indicador IE Dest</label>	
            <?php $indIEDest = ($destinatario->indIEDest) ? $destinatario->indIEDest : null ?>
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
			
                
               <div class="col-3 mb-3" >
                <label class="text-label">Endereço de Retirada</label>	
                <select class="form-campo" name="id_endereco_retirada" id="id_endereco_retirada" onchange="carregar_endereco_retirada()">
                   <option value="0">Não se aplica</option>
                    <option value="1">Diferente do Destinatário</option>
                </select>
                </div>
                
                <div class="col-3 mb-3" >
                <label class="text-label">Endereço de Entrega</label>	
                <select class="form-campo" name="id_endereco_entrega" id="id_endereco_entrega" onchange="carregar_endereco_entrega()">
                    <option value="0">Não se aplica</option>
                    <option value="1">Diferente do Destinatário</option>
                    
                </select>
                </div>
                
            </div>	
     </fieldset>
	 
     <fieldset class="mt-2"> 
 	<legend class="h5 mb-0 text-left" id="titulo_endereco_retirada">Endereço Retirada</legend>	    
	<div class="rows p-2" id="div_endereco_retirada"> 
			<div class="col-6 mb-1">
                    <label class="text-label">Nome / Razão Social </label>	
                    <input type="text" name="xNomeRetirada"  id="xNomeRetirada" value="{{ ($retirada->nome_retirada) ??  null }}" class="form-campo">
            </div>
            
			<div class="col-3 mb-1">
                <label class="text-label">CNPJ </label>	
                <input type="text" name="CNPJRetirada" id="CNPJRetirada" value="{{  ($retirada->cnpj_retirada) ??  null }}" class="form-campo">
            </div>
                     
            <div class="col-3 mb-1">
                <label class="text-label">Inscr. Estadual</label>	
                <input type="text" name="IERetirada" id="IERetirada" value="{{  ($retirada->ie_retirada) ?? null }}" class="form-campo">
            </div>
        	
			
		   <div class="col-6 mb-1">
                    <label class="text-label">Logradouro</label>	
                    <input type="text" name="xLgrRetirada" id="xLgrRetirada"  value="{{  ($retirada->logradouro_retirada) ?? null }}" class="form-campo">
            </div>
			<div class="col-2 mb-4">
                    <label class="text-label">Numero</label>	
                    <input type="text" name="nroRetirada" id="nroRetirada"  value="{{  ($retirada->numero_retirada) ?? null }}"  class="form-campo">
            </div>
            <div class="col-4 mb-1">
                <label class="text-label">Complemento</label>	
                <input type="text" name="xCplRetirada" id="xCplRetirada"  value="{{  ($retirada->complemento_retirada) ?? null }}" class="form-campo">
            </div>
			
			<div class="col-4 mb-3">
                    <label class="text-label">Bairro</label>	
                    <input type="text" name="xBairroRetirada" id="xBairroRetirada"  value="{{  ($retirada->bairro_retirada) ?? null }}"  class="form-campo">
            </div>          
                  
                      
            <div class="col-4 mb-1">
                    <label class="text-label">UF</label>	
                   <input type="text" name="UFRetirada" id="UFRetirada"  value="{{  ($retirada->UFRetirada) ?? null }}"  class="form-campo">
                  
            </div>
           
            <div class="col-4 mb-1">
                <label class="text-label">Cidade</label>
                <input type="text" name="cMunRetirada" id="cMunRetirada"  value="{{  ($retirada->cMunRetirada) ?? null }}"  class="form-campo">
               
             </div>
              
              <div class="col-2 mb-1">
                <label class="text-label">CEP</label>
                 <div class="input-grupo">
                 <input type="text"  name="CEPRetirada" id="CEPRetirada"  value="{{  ($retirada->cep_retirada) ?? null }}" class="form-campo">

                 </div>
            </div> 
            
            <div class="col-2 mb-1">
                    <label class="text-label">Fone</label>	
                    <input type="text" name="foneRetirada" id="foneRetirada"  value="{{  ($retirada->fone_retirada) ?? null }}"  class="form-campo">
            </div>
            
            <div class="col-8 mb-3">
                    <label class="text-label">Email</label>	
                    <input type="text" name="emailRetirada" id="emailRetirada"  value="{{  ($retirada->email_retirada) ?? null }} "  class="form-campo">
            </div> 

            </div>
 </fieldset>
 
 
 	<fieldset class="mt-2"> 
 	<legend class="h5 mb-0 text-left" id="titulo_endereco_entrega">Endereço Entrega</legend>	    
	<div class="rows p-2" id="div_endereco_entrega"> 
			<div class="col-6 mb-1">
                    <label class="text-label">Nome / Razão Social </label>	
                    <input type="text" name="xNomeEntrega"  id="xNomeEntrega" value="{{ ($entrega->nome_entrega) ?? null }}" class="form-campo">
            </div>
            
			<div class="col-3 mb-1">
                <label class="text-label">CNPJ </label>	
                <input type="text" name="CNPJEntrega" id="CNPJEntrega" value="{{ ( $entrega->cnpj_entrega) ?? null }}" class="form-campo">
            </div>
                     
            <div class="col-3 mb-1">
                <label class="text-label">Inscr. Estadual</label>	
                <input type="text" name="IEEntrega" id="IEEntrega" value="{{ ( $entrega->ie_entrega) ?? null }}" class="form-campo">
            </div>
        	
			
		   <div class="col-6 mb-1">
                    <label class="text-label">Logradouro</label>	
                    <input type="text" name="xLgrEntrega" id="xLgrEntrega"  value="{{ ( $entrega->logradouro_entrega) ?? null }}" class="form-campo">
            </div>
			<div class="col-2 mb-1">
                    <label class="text-label">Numero</label>	
                    <input type="text" name="nroEntrega" id="nroEntrega"  value="{{ ( $entrega->numero_entrega) ?? null }}"  class="form-campo">
            </div>
            <div class="col-4 mb-1">
                <label class="text-label">Complemento</label>	
                <input type="text" name="xCplEntrega" id="xCplEntrega"  value="{{ ( $entrega->complemento_entrega) ?? null }}" class="form-campo">
            </div>
			
			<div class="col-4 mb-1">
                    <label class="text-label">Bairro</label>	
                    <input type="text" name="xBairroEntrega" id="xBairroEntrega"  value="{{ ( $entrega->bairro_entrega) ?? null }}"  class="form-campo">
            </div>          
                  
                      
            <div class="col-4 mb-1">
                    <label class="text-label">UF</label>	
                    <input type="text" name="UFEntrega" id="UFEntrega"  value="{{ ( $entrega->UFEntrega) ?? null }}"  class="form-campo">
                 
            </div>
           
            <div class="col-4 mb-1">
                <label class="text-label">Cidade</label>	
                  <input type="text" name="cMunEntrega" id="cMunEntrega"  value="{{ ( $entrega->cMunEntrega) ?? null }}"  class="form-campo">
                
             </div>
              
              <div class="col-2 mb-1">
                <label class="text-label">CEP</label>
                 <input type="text"  name="CEPEntrega" id="CEPEntrega"  value="{{ ( $entrega->cep_entrega) ?? null }}" class="form-campo">

            </div> 
            
            <div class="col-2 mb-1">
                    <label class="text-label">Fone</label>	
                    <input type="text" name="foneEntrega" id="foneEntrega"  value="{{ ( $entrega->fone_entrega) ?? null }}"  class="form-campo">
            </div>
            
            <div class="col-8 mb-3">
                    <label class="text-label">Email</label>	
                    <input type="text" name="emailEntrega" id="emailEntrega"  value="{{ ( $entrega->email_entrega) ?? null }}"  class="form-campo">
            </div> 

            </div>
       </fieldset>     
 <script>
 	mostrar_endereco_retirada(<?php echo  ($destinatarioid_retirada) ??  NULL ?>);
 	mostrar_endereco_entrega(<?php echo   ($destinatario->id_entrega) ??  NULL ?>);
 </script>           
