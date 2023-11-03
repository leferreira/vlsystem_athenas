<section class="conteudo">			
	<div class="conteudo-fluido">
	<div class="rows">			
		
		<div class="col-12">
			<div class="caixa">
                    <div class="caixa-titulo py-1 d-inline-block width-100">
                            <span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Selecione um Emitente</span>
				         </div>
					
				
					<div class="row">
					<div class="tabela-responsiva">
						<table cellpadding="0" cellspacing="0" id="dataTable">
                           <thead>
                                <tr>
                                    <th align="center">Id</th>
                                    <th align="left" >Empresa</th>
                                    <th align="center" >Fantasia</th>
                                    <th align="center">CNPJ</th>
                                    <th align="center" >Selecionar</th>
                                </tr>
                            </thead>
                            <tbody> 
                            <?php foreach($emitentes as $empresa) { ?> 							
								<tr>
									<td align="center"><?php echo $empresa->id_emitente ?></td>
									<td align="center"><?php echo $empresa->razao_social ?></td>
									<td align="left"><?php echo $empresa->nome_fantasia ?> </td>
									<td align="center"><?php echo $empresa->cnpj ?></td>
									<td align="center"><a href="<?php echo URL_BASE ."notafiscal/novo/" .$empresa->id_emitente ?>" class="d-inline-block btn btn-outline-roxo btn-pequeno"><i class="fas fa-edit"></i> Selecionar</a></td>
							</tr>	
							<?php } ?>                    
							                  
											
							</tbody>
						</table>
								
			</div>
					</div> 
			</div>
        </div>
    </div>
    </div>
</section>