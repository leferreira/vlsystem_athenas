<span class="d-block mt-4 h4 border-bottom pb-2">Duplicatas <a href="#janela1" rel="modal" class="btn btn-pequeno d-inline-block">Editar duplicatas</a></span>										
            <div class="rows pb-4">																					
            <div class="col-12">
                <div class="caixa">
                    <div class="tabela-responsiva">
                            <table cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th align="center">ID</th>
                                            <th align="center">Vencimento</th>
                                            <th align="center">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($duplicatas as $duplicata){?>
                                        <tr>
                                        	<td align="center"><?php echo $duplicata->id_duplicata ?></td>
                                            <td align="center"><?php echo databr($duplicata->vencimento) ?></td>
                                            <td align="center">R$ <?php echo $duplicata->valor ?></td>
                                            
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                            </table>
                    </div>
                </div>
				
					  

					   
            </div>
            </div>