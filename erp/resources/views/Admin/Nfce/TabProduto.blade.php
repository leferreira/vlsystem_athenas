    
    <div class="rows">
        
    </div>

	<fieldset class="mt-2 pb-4">
	
		<legend class="h5 mb-0 text-left">Itens da Nota </legend>
			<div class="">
			 <div class="caixa">			        
                <div class="rows">                
						
						<div class="col-6 position-relative mb-3">
							<label class="text-label">Produto</label>
							<div class="group-btn">	  
                           		 <input type="text" id="produto" data-type="localizar_produto"  class="form-campo">
								<a href="javascript:;" onclick="abrirModal('#modalCadProduto')" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
							</div>											
						</div>
						
						<div class="col-2">	
                            <label class="text-label d-block ">Unidade</label>
                            <select id="unidade_nfe" name="unidade" class="form-campo" onchange="selecionarUnidade()"></select>
                        </div>                       
                       	
                        <div class="col-2 mb-3">
                                 <label class="text-label">Preço</label>
                                 <input type="text" name="preco" id="preco"   class="form-campo mascara-float">
                        </div>
                        	
                        <div class="col-2 mb-3">
                                 <label class="text-label">Qtde</label>
                                 <input type="text" name="qtde" id="qtde"   class="form-campo mascara-float">
                        </div>
                        <div class="col-2 mb-3">
                                 <label class="text-label">Tipo Desconto</label>
                                 <select  class="form-campo" id="tipo_desc" name="tipo_desc">
                                 	<option value="desc_perc">Percento (%)</option>
                                 	<option value="desc_valor">Valor (R$)</option>
                                 </select>
                        </div> 
                        
                        <div class="col-2 mb-3">
                                 <label class="text-label">Desconto (R$)</label>
                                 <input type="text" name="val_desconto" id="val_desconto"  value="0"  class="form-campo mascara-float">
                        </div>                       
                    
                        <div class="col-2 mb-3">
                                 <label class="text-label">Subtotal</label>
                                 <input type="text"  name="subtotal" id="subtotal" readonly="readonly"   class="form-campo mascara-float">
                        </div> 
                        
                        <div class="col-2 mb-3">
                                 <label class="text-label">Desconto</label>
                                 <input type="text" readonly="readonly" id="desconto" name="desconto"   class="form-campo mascara-float">
                        </div>
                        
                        <div class="col-2 mb-3">
                                 <label class="text-label">Total Geral</label>
                                 <input type="text" readonly="readonly" id="total_item"   class="form-campo mascara-float">
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
                                        <th align="center">Detalhes</th>
                                        <th align="center">Excluir</th>
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
									<td align="center"><a href="javascript:;" onclick="verDetalheItemNfe({{$item->id}})"   class="btn btn-outline-verde d-inline-block  btn-pequeno" title="Detalhes"><i class="fas fa-eye"></i> </a></td>
                                	<td><a href='javascript:;' onclick='excluirProduto({{$item->id}})'  class='btn btn-outline-vermelho btn-pequeno' title='Excluir'>Excluir</a></td>
                                </tr>
                               <?php } ?>
                       </tbody>
                    </table>
                  
            </div>
		
            </div>
            </div>

       
            </fieldset>
	
