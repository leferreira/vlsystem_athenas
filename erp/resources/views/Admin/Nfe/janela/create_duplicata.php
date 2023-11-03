	<div class="window medio" id="create_duplicata">
		<div class="caixa mb-0 p-0">
		<span class="d-block titulo mb-0"><i class="fas fa-plus"></i> Castarar duplicata</span>	
		<div class="border radius-4">
			<div class="rows p-4">  		
				<div class="col-6 mb-3">
					<label class="text-label">Vencimento</label>	                   
					<input type="date" name="vencimento_duplicata" id="vencimento_duplicata" value="" placeholder="Digite aqui..." class="form-campo">
				</div>    		
				<div class="col-6 mb-3">
					<label class="text-label">Valor</label>	                   
					<input type="text" name="valor_duplicata" id="valor_duplicata" value="" placeholder="Digite aqui..." class="form-campo">
				</div>   
			</div>   
			<div class="tfooter end">
				<button class="btn btn-vermelho fechar">Fechar</button>
			    <button onclick="salvarDuplicata()" name="salvarDuplicata" class="btn btn-azul d-inline-block"> Salvar</button>
					
			</div>
		</div>
		</div>
	</div>