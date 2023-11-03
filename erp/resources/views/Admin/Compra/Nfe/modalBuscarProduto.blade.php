<?php
    use App\Service\ConstanteService;
?>

<div class="window medio" id="modalBuscarProduto">

	<div class="p-2 px-4">
			<span class="d-block h3 border-bottom fw-700">Produtos Para Vinculação<span id="tabela"></span></span>
		<div class="rows">
						<div class="col-10 position-relative mb-3">
							<label class="text-label">Produto</label>
							<input type="text" name="nomeProduto" id="nomeProduto" class="form-campo">																		
						</div>													
            						
						
						 <div class="col-2 mb-3">
						 	<label class="text-label">.</label>	
						 	<input type="hidden"  id="item_nota_id" >
                		 </div>
					
         </div>
         
         <div class="rows">
			<div class="col-12">
                <div class="scroll tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" width="100%" >
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th class="text-left">Produto</th>
                                    <th align="center">Selecionar</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body" id="lista_produto_disponivel">                           
                            	<tr>
                            		<td align="center"></td>
                            		<td align="center"></td>
                            		<td align="center">
                            			<a href="" title="Excluir" class="text-vermelho"><i class="fas fa-trash"></i></a>
                            		</td>
                            	</tr>
                            
							</tbody>
                          </table>
								
                   </div>

                </div>
                </div>
                
			
         </div>
		 <div class="tfooter end">
			<a href="" class="btn btn-neutro fechar">Fechar</a> 
		 </div>
	</div>
