
    <div class="rows pb-4 px-3 mt-4">
		<div class="col-12">		
             <fieldset class="p-2">
				<legend class="h5 mb-0 text-left">Pessoas Autorizadas a Acessar o XML da Nota </legend>
			 
            <div class="caixa px-2">
            <div class="rows">	
                  <div class="col-4 mb-3">
                    	<label class="text-label">Nome</label>	
                    	<input type="text"  id="aut_contato"   class="form-campo">
                    </div>
                    
                    <div class="col-4 mb-3">
                        <label class="text-label">CPF/CNPJ</label>	
                        <input type="text"  id="aut_cnpj"  class="form-campo">
                    </div>
                    <div class="col-2 mt-1 pt-1"> 
                    	<input type="button" onclick="inserirAutorizado()" value="Inserir" class="btn btn-azul width-100" />                              
                    </div> 
            </div>
            
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0" class="table-bordered">
                            <thead>
                                    <tr>
                                        <th align="center">ID</th>
                                        <th align="center">Contato</th>
                                        <th align="center">CNPJ / CPF</th>
                                        <th align="center">Excluir</th>
                                  </tr>
                            </thead>
                           <tbody id="lista_autorizado">
                               <?php foreach($autorizados as $item){ ?>
                                <tr>
                                    <td align="center"><?php echo $item->id ?></td>
                                    <td align="center"><?php echo $item->aut_contato ?></td>
                                    <td align="center"><?php echo $item->aut_cnpj ?></td>
                                    <td align="center"><a href="javascript:;" onclick="excluirAutorizado(<?php echo $item->id_nfe_autorizado ?>)" class="btn btn-vermelho btn-pequeno d-inline-block" title="Excluir"><i class="fas fa-trash"></i></a></td>
                                </tr>
                               <?php } ?>
							    
                       </tbody>
                    </table>
                  
            </div>

		
            </div>
			
     
		</fieldset>
			</div>
        </div>