    
    <div class="rows">
        <div class="col-12 mt-2">
               <a href="javascript:;" onclick="abrirModal('#janela_finalizar_produto')" class="btn btn-roxo d-inline-block text-uppercase"><i class="far fa-save"></i> Salvar</a>
        </div>
    </div>

	<fieldset class="mt-2 pb-4">
		<legend class="h5 mb-0 text-left">Produto </legend>
			 <div class="">
			 <div class="caixa">			        
                <div class="rows">                        
                        <div class="col-4 mb-3 position-relative">
                            <label class="text-label">Nome do Produto </label>
                            <input type="text" id="produto" data-type="localizar_produto" placeholder="Digite aqui..." class="form-campo">
						</div>
                        
                       	
                        <div class="col-2 mb-3">
                                 <label class="text-label">Preço</label>
                                 <input type="text" name="preco" id="preco"   class="form-campo">
                        </div>
                        	
                        <div class="col-2 mb-3">
                                 <label class="text-label">Qtde</label>
                                 <input type="text" name="qtde" id="qtde"   class="form-campo">
                        </div>
                        <div class="col-2 mb-3">
                                 <label class="text-label">Subtotal</label>
                                 <input type="text" name="qtde" id="qtdetrib"   class="form-campo">
                        </div>
                        
				
                        <div class="col-2 mt-1 pt-1">
                                <input type="hidden" id="id_produto" name="id_produto">                              
                                <input type="button" value="ins" id="btnInserirProduto" class="btn btn-azul width-100">
                        </div>                                                                                                                    
                </div>
              
            </div>
            </div>
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
                                        <th align="center">Detalhes</th>
                                        <th align="center">Excluir</th>
                                  </tr>
                            </thead>
                           <tbody id="lista_itens">
                               <?php foreach($itens as $item){ ?>
                                <tr>
                                    <td align="left"><?php echo $item->id_item   ?></td>
                                    <td align="center"><?php echo $item->cProd ?></td>
                                    <td align="left"><?php echo $item->xProd ?></td>
                                    <td align="center">R$ <?php echo $item->vUnCom ?></td>
                                    <td align="center"><?php echo $item->qCom ?></td>							
                                    <td align="center">R$ <?php echo $item->vUnCom ?></td>
                                    <td align="center"><a href="" target="_blank"  class="btn btn-outline-verde d-inline-block  btn-pequeno" title="Detalhes"><i class="fas fa-eye"></i> </a></td>
                                    <td align="center"><a href="javascript:;" onclick="excluirProduto(<?php echo $item->id_item  ?>)" class="btn btn-outline-vermelho btn-pequeno  d-inline-block" title="Excluir"><i class="fas fa-trash"></i> </a></td>
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
<script src="{{asset('assets/js/NFE/tabProduto_js.js')}}"> </script>