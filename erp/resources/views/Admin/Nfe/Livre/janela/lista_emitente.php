	<!--lista de produto-->
	<div class="window" id="janela_listagem_empresa">
	<a href="" class="fechar">X</a>
		<div class="caixa mb-0 p-3">
			
				<div class="caixa">
						<div class="caixa-titulo py-1 d-inline-block width-100">
								<span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Lista produtos</span>
						</div>
						
					
						<div class="row">
						<div class="rolagem-400">
							<table cellpadding="0" cellspacing="0" id="dataTable">
								<thead>
				<tr>
                                        <th align="center">Id</th>
                                        <th align="left">Razão Social</th>
                                        <th align="center">Nome Fantasia</th>
                                        <th align="center">CNPJ</th>
                                        <th align="center">Fone</th>
                                        <th align="center" >Ação</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($emitentes as $emitente){ ?>
                                        <tr>
                                         <td align="center"><?php echo $emitente->id_emitente  ?></td>
                                         <td align="center"><?php echo $emitente->razao_social ?></td>
                                        <td align="left"><?php echo $emitente->nome_fantasia ?></td>
                                         <td align="center"><?php echo $emitente->cnpj ?></td>
                                         <td align="center"><?php echo $emitente->fone ?></td>
                                         <td align="center">
                                             <a href="javascript:;" onclick="selecionar_emitente(<?php echo $emitente->id_emitente?>)" class="d-inline-block btn btn-outline-verde btn-pequeno"><i class="fas fa-check"></i> Selecionar</a>
                                         </td>
                                        </tr>                       
				 		
                                        <?php } ?>
                                        
					</tbody>
							</table>
									
				</div>
						</div> 
				</div>
		</div>
	</div>