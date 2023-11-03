
    <div class="rows pb-4 px-3 mt-4">
		<div class="col-12">		
             <fieldset class="p-2">
				<legend class="h5 mb-0 text-left">Pagamento </legend>
			 <div class="caixa">			         
                <div class="rows p-2">
                        <div class="col-10 mb-3">
                                 <label class="text-label">CNPJ/CPJ</label>
                                 <input type="text" name="cnpj_autorizado" id="cnpj_autorizado"   class="form-campo">
                        </div>
                   				
                        <div class="col-2 mt-1 pt-1"> 
                        <input type="button" onclick="inserirAutorizado()"  value="Inserir" class="btn btn-azul width-100"/>                             
                        
                        </div>                                                                                                                    
                </div>
               
            </div>
            <div class="caixa px-2">
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0" class="table-bordered">
                            <thead>
                                    <tr>
                                        <th align="center">ID</th>
                                        <th align="center">CNPJ / CPF</th>
                                        <th align="center">Excluir</th>
                                  </tr>
                            </thead>
                           <tbody id="lista_autorizado">
                               <?php foreach($autorizados as $item){ ?>
                                <tr>
                                    <td align="center"><?php echo $item->id_nfe_autorizado ?></td>
                                    <td align="center"><?php echo $item->cnpj ?></td>
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

<script src="{{ asset('assets/js/NFE/tabProduto_js.js')}}"> </script>