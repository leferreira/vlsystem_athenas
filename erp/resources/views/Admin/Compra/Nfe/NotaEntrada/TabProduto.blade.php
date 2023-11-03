    
    <div class="rows">
        
    </div>

	<fieldset class="mt-2 pb-4">
	
		<legend class="h5 mb-0 text-left">Itens da Nota </legend>
			
			<div class="py-2">
            <div class="caixa">
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0" class="table-bordered">
                            <thead>
                                    <tr>
                                        <th align="left">Item</th>                                        
                                        <th align="left">Produto</th>
                                        <th align="center">Preço</th>
                                        <th align="center">Quantidade</th>							
                                        <th align="center">Subtotal</th>
                                        <th align="center">NCM</th>
                                        <th align="center">Cfop</th>
                                        <th align="center">ICMS</th>
                                        <th align="center">IPI</th>
                                        <th align="center">PIS</th>
                                        <th align="center">Cofins</th>
                                  </tr>
                            </thead>
                           <tbody id="lista_itens">
                               <?php 
                                    $j = 1;
                                    foreach($itens as $item){ ?>
                                <tr>
                                    <td align="left"><?php echo $j++   ?></td>
                                    <td align="left"><?php echo $item->xProd ?></td>
                                    <td align="center"><?php echo $item->vUnCom ?></td>
                                    <td align="center"><?php echo $item->qCom ?></td>							
                                    <td align="center"><?php echo $item->vProd ?></td>  
                                    <td align="center"><?php echo $item->NCM ?></td>                                  
                                    <td align="center"><?php echo  $item->CFOP ?></td>     
                                    <td align="center"><?php echo $item->vICMS ? $item->vICMS : 0  ?></td> 
                                    <td align="center"><?php echo $item->vIPI ? $item->vIPI : 0 ?></td> 
                                    <td align="center"><?php echo $item->vPIS ? $item->vPIS : 0 ?></td> 
                                    <td align="center"><?php echo $item->vCOFINS ? $item->vCOFINS : 0 ?></td>                                
                                </tr>
                               <?php } ?>
                       </tbody>
                    </table>
                  
            </div>
		
            </div>
            </div>

       
            </fieldset>
	
