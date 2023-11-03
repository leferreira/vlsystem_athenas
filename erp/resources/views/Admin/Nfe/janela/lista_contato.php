	<!--lista de produto-->
	<div class="window form" id="janela_listagem_contato">
		<div class="caixa mb-0 p-0">
				<span class="d-block titulo mb-0"><i class="fas fa-list-alt"></i> Lista Clientes</span>						
					<div class="p-3">
						<div class="tabela-responsiva rolagem-290">
							<table cellpadding="0" cellspacing="0" class="table-bordered">
								<thead>
									<tr>
                                        <th align="center">Id</th>
                                        <th align="left">Nome</th>
                                        <th align="center">Nome Fantasia</th>
                                        <th align="center">CPF</th>
                                        <th align="center">Fone</th>
                                        <th align="center" >Ação</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($contatos as $contato){ ?>
                                        <tr>
											 <td align="center"><?php echo $contato->id_cliente  ?></td>
											 <td align="center"><?php echo $contato->nome ?></td>
											<td align="center"><?php echo $contato->cpf ?></td>
											 <td align="center"><?php echo $contato->cnpj ?></td>
											 <td align="center"><?php echo $contato->fone ?></td>
											 <td align="center">
												 <a href="javascript:;" onclick="selecionar_contato(<?php echo $contato->id_cliente  ?>)" class="d-inline-block btn btn-outline-verde btn-pequeno"><i class="fas fa-check"></i> Selecionar</a>
											 </td>
                                        </tr>                       
				 		
                                        <?php } ?>
									</tbody>
							</table>
									
				</div>
			</div> 
			<div class="tfooter end">
			<button class="btn btn-vermelho fechar">Fechar</button>
            <input type="submit" value="Ok" class="btn btn-azul text-uppercase">
		</div>
		</div>
	</div>