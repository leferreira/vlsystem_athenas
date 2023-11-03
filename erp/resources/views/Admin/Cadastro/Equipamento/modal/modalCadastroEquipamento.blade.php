
<div class="window form alt" id="modalCadEquipamento">
<span class="d-block h4 fw-700 titulo">Cadastro de Equipamento</span>
		<a href="" class="fechar position-absolute">X</a>
		<div class="caixa mb-0 p-3">

    <input type="hidden" name="_token" value="HyqwkJzIzCTlOwEYbDBLYUyvJVW09v9kR9qo1hao">    

<form id="frmCadEquipamento">	
<div class="scroll-modal">     
   <div id="tabmod" class="abas py-0">	    
	  <div id="tabmod-1">
		<div class="p-2 mt-3 px-0">			
				
			<fieldset>
				<legend>Dados Pessais</legend>	
				<div class="rows">
					<div class="col-8 mb-3">
							<label class="text-label"  >Equipamento<span class="text-vermelho">*</span></label>	
							<input type="text" name="equipamento"  required id="equipamento" value="{{isset($equipamento->equipamento) ? equipamento : old('equipamento') }}" class="form-campo">
					</div>                                    
					<div class="col-3 mb-3" >
							<label class="text-label">Número de Série</label>	
							<input type="text" name="num_serie" maxlength="60" id="num_serie" value="{{isset($equipamento->num_serie) ? $equipamento->num_serie : old('num_serie') }}" class="form-campo">
					</div>
					<div class="col-3 mb-3">
							<label class="text-label"  >Modelo<span class="text-vermelho">*</span></label>	
							<input type="text" name="modelo"   value="{{isset($equipamento->modelo) ? $equipamento->modelo : old('modelo') }}"  class="form-campo">
					</div>						
					
					<div class="col-3 mb-3" >
							<label class="text-label" >Cor</label>	
							<input type="text" name="cor"  value="{{isset($equipamento->cor) ? $equipamento->cor : old('cor') }}"  class="form-campo">
					</div>
								
					
					<div class="col-3 mb-3">
							<label class="text-label">Tensão</label>	
							<input type="text" name="tensao" value="{{isset($equipamento->tensao) ? $equipamento->tensao : old('tensao') }}"  class="form-campo ">
					</div>
					
					<div class="col-3 mb-3">
							<label class="text-label">Potência</label>	
							<input type="text" name="potencia"  value="{{isset($equipamento->potencia) ? $equipamento->potencia : old('potencia') }}"  class="form-campo ">
					</div>
					
					<div class="col-3 mb-3">
							<label class="text-label">Voltagem</label>	
							<input type="text" name="voltagem"  value="{{isset($equipamento->voltagem) ? $equipamento->voltagem : old('voltagem') }}"  class="form-campo ">
					</div>
					
					<div class="col-3 mb-3">
							<label class="text-label">Data Fabricação</label>	
							<input type="text" name="data_fabricacao"  value="{{isset($equipamento->data_fabricacao) ? $equipamento->data_fabricacao : old('data_fabricacao') }}"  class="form-campo ">
					</div>
					
					<div class="col-12 mb-3" >
							<label class="text-label">Descrição</label>	
							<textarea rows="5" cols="5" name="descricao" class="form-campo">{{isset($equipamento->descricao) ? $equipamento->descricao : old('descricao') }}</textarea>
					</div>
				</div>
   
</fieldset>
	
		</div>
	  </div>
	 
         
 </div>

</div>
		
		<div class="col-12 text-center pb-0 tfooter end">
			<input type="button" class="btn btn-vermelho fechar" value="Fechar">
			<input type="hidden" class="cliente_id" >
			<a href="javascript:;" onclick="salvarEquipamento()" class="btn btn-azul">Salvar Dados</a>			
		</div>	
	
</form>
			
		</div>
	</div>
	
