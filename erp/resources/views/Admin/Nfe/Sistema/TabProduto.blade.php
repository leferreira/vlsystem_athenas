    
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
                                        <th align="center">Id_prod</th>
                                        <th align="left">Produto</th>
                                        <th align="center">Preço</th>
                                        <th align="center">Quantidade</th>							
                                        <th align="center">Subtotal</th>
                                        <th align="center">NCM</th>
                                        <th align="center">Detalhes</th>
                                  </tr>
                            </thead>
                           <tbody id="lista_itens">
                               <?php foreach($itens as $item){ ?>
                                <tr>
                                    <td align="left"><?php echo $item->id   ?></td>
                                    <td align="center"><?php echo $item->cProd ?></td>
                                    <td align="left"><?php echo $item->xProd ?></td>
                                    <td align="center">R$ <?php echo $item->vUnCom ?></td>
                                    <td align="center"><?php echo $item->qCom ?></td>							
                                    <td align="center">R$ <?php echo $item->vUnCom ?></td>
                                    <td align="center"><?php echo $item->NCM ?></td>
                                    <td align="center"><a href="" target="_blank"  class="btn btn-outline-verde d-inline-block  btn-pequeno" title="Detalhes"><i class="fas fa-eye"></i> </a></td>
                                </tr>
                               <?php } ?>
                       </tbody>
                    </table>
                  
            </div>
		
            </div>
            </div>
<!-- 			
			<a href="" class="btn d-inline-block d-table m-auto">Inserir novo</a>
   
 -->   
       
            </fieldset>