		<div class="window medio" id="modalVerGradeProduto">
		<form action="{{route('admin.grade.store')}}" name="frmGrade" method="POST">
		@csrf
			<div class="titulo" style="font-size: 1.1rem!important;">Faça a montagem da Grade</div>
			<input type="hidden" id="variacao_grade_linha_id" name="variacao_grade_linha_id">
			<input type="hidden" id="variacao_grade_coluna_id" name="variacao_grade_coluna_id">
			<input type="hidden" id="produto_grade_id" name="produto_grade_id">
			<div class="p-2 cadSelect">
				<div class="rows">
				
					<div class="col-6">
						<div class="scroll">
							<table cellpadding="0" cellspacing="0" class="table-bordered">
								<thead>
									<tr>
										<th align="left"><span class="nome_linha"></span></th>
									</tr>
								</thead>
								<tbody id="linha_clicavel">
									<tr>
										<td align="left"><a href="javascript:;" onclick="selecionarLinhaGrade()"><span id="linha_clicavel_">linha</span></a></td>
									</tr>
								
								</tbody>
							</table>
						</div>
					</div>
					
					
					<div class="col-6">						
						<div class="scroll">
							<table cellpadding="0" cellspacing="0" class="table-bordered">
								<thead>
									<tr>
										<th align="left"><span class="nome_coluna"></span></th>
									</tr>
								</thead>
								<tbody id="coluna_clicavel">
									<tr>
										<td align="left"><label><input type="checkbox" name="colunas[]" > Marron</label></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
				</div>
			</div>
			<div class="tfooter justify-content-space-between">
				
				
				<div class="d-flex">
					<input type="submit" value="Gerar Grade" class="btn btn-verde btn-menor">
					<a href="" class="btn btn-vermelho btn-menor fechar ml-1"  title="Cadastrar cancelar"><i class="fas fa-times"></i> Cancelar</a>
				</div>
			</div>
		</form>
		</div>