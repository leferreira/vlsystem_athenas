<!--lista de produto-->
	<div class="window form" id="janela_transportadora">
		<div class="caixa mb-0 p-3">
			
				<div class="caixa">
					<span class="d-block titulo mb-0"><i class="fas fa-list-alt"></i> Lista de transportes</span>						
						<div class="row">
							<div class="tabela-responsiva rolagem-290 p-3">
								<table cellpadding="0" cellspacing="0" id="dataTable"  class="table-bordered">
									<thead>
										<tr>
											<th align="center">Id</th>
											<th align="left">Transportadora</th>
											<th align="center">CNPJ</th>
											<th align="center">Ação</th>
										</tr>
									</thead>
									<tbody id="lista_de_transoportadoras"> 
									<?php foreach($transportadoras as $transportadora){?>                     
										<tr>
											 <td align="center"><?php echo $transportadora->id?></td>
											  <td align="left"><?php echo $transportadora->razao_social ?></td>
											 <td align="center"><?php echo $transportadora->cnpj ?></td>
											 <td align="center">
												 <a href="javascript:;" onclick="selecionar_transportadora(<?php echo $transportadora->id ?>)" class="d-inline-block btn btn-verde btn-pequeno"><i class="fas fa-check"></i> Selecionar</a>
											 </td>
										</tr>                       
									<?php } ?>                 
														  
											
									</tbody>
								</table>
										
							</div>
						</div> 
				</div>
				<div class="tfooter end">
					<button class="btn btn-vermelho fechar">Fechar</button>
				</div>
		</div>
	</div>