@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
	<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Meu Plano Atual</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>
                      
    
   
   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2">
			
			<fieldset>
				<legend>Dados do plano</legend>					
				<div class="rows">									
					<div class="col-6 mb-3">
								<label class="text-label">Nome</label>	
								<input type="text" readonly value="{{isset($empresa->planopreco->plano->nome) ? $empresa->planopreco->plano->nome : old('nome') }}" class="form-campo">
						</div>                                    
																				
    						<div class="col-3 mb-3">
    								<label class="text-label">Valor</label>	
    								<input type="text" readonly value="{{isset($empresa->planopreco->plano->valor) ? $empresa->planopreco->plano->valor : old('valor') }}"  class="form-campo mascara-dinheiro">
    						</div>
    						
    						<div class="col-3 mb-3">
    								<label class="text-label">Data Aquisição</label>	
    								<input type="text" readonly value="{{isset($empresa->data_aquisicao) ? databr($empresa->data_aquisicao) : old('data_aquisicao') }}"  class="form-campo">
    						</div>
    						
    						<div class="col-3 mb-3">
    								<label class="text-label">Data Vencimento</label>	
    								<input type="text" readonly value="{{isset($empresa->data_vencimento) ? databr($empresa->data_vencimento) : old('data_vencimento') }}"  class="form-campo">
    						</div>
								
							<div class="col-3 mb-3">
                            <label class="text-label">Descrição</label>	
                            <input type="text" readonly value="{{isset($empresa->planopreco->plano->descricao) ? $empresa->planopreco->plano->descricao : old('descricao') }}"  class="form-campo">
                            </div>
                            
                            <div class="col-3 mb-3">
                                    <label class="text-label">Limite Nfe</label>	
                                    <input type="text" readonly value="{{isset($empresa->planopreco->plano->limite_nfe) ? $empresa->planopreco->plano->limite_nfe : old('limite_nfe') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Limite NFCE</label>	
                                    <input type="text" readonly value="{{isset($empresa->planopreco->plano->limite_nfce) ? $empresa->planopreco->plano->limite_nfce : old('limite_nfce') }}"  class="form-campo">
                            </div>
                                      
                              

			</div>
			</fieldset>
			
			
		</div>
	  </div>		
		</div>
		
	  </div>
	
@endsection