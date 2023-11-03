@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
	<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Meus Planos</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>                      
    
   
   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2">
			
			<fieldset>
				<legend>Dados do plano Atual</legend>					
				<div class="rows">									
					<div class="col-6 mb-3">
								<label class="text-label">Nome</label>	
								<input type="text" readonly value="{{isset($assinatura->planopreco->plano->nome) ? $assinatura->planopreco->plano->nome : old('nome') }}" class="form-campo">
						</div>                                    
																				
    						<div class="col-3 mb-3">
    								<label class="text-label">Valor</label>	
    								<input type="text" readonly value="{{isset($assinatura->planopreco->plano->valor) ? $assinatura->planopreco->plano->valor : old('valor') }}"  class="form-campo mascara-dinheiro">
    						</div>
    						
    						<div class="col-3 mb-3">
    								<label class="text-label">Data Aquisição</label>	
    								<input type="text" readonly value="{{isset($assinatura->data_aquisicao) ? databr($assinatura->data_aquisicao) : old('data_aquisicao') }}"  class="form-campo">
    						</div>
    						
    						<div class="col-3 mb-3">
    								<label class="text-label">Data Vencimento</label>	
    								<input type="text" readonly value="{{isset($assinatura->data_vencimento) ? databr($assinatura->data_vencimento) : old('data_vencimento') }}"  class="form-campo">
    						</div>
								
							<div class="col-3 mb-3">
                            <label class="text-label">Descrição</label>	
                            <input type="text" readonly value="{{isset($assinatura->planopreco->plano->descricao) ? $assinatura->planopreco->plano->descricao : old('descricao') }}"  class="form-campo">
                            </div>
                            
                            <div class="col-2 mb-3">
                                    <label class="text-label">Limite Nfe</label>	
                                    <input type="text" readonly value="{{isset($assinatura->planopreco->plano->limite_nfe) ? $assinatura->planopreco->plano->limite_nfe : old('limite_nfe') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Limite NFCE</label>	
                                    <input type="text" readonly value="{{isset($assinatura->planopreco->plano->limite_nfce) ? $assinatura->planopreco->plano->limite_nfce : old('limite_nfce') }}"  class="form-campo">
                            </div>
                            <div class="col-2 mb-3">  
        					 <label class="text-label">.</label> 
        						<input type="hidden" name="planopreco_id" value="" /> 
        						<input type="hidden" value="Pagamento de Assinatura"  name="descricao"  >	
        						<a href="{{route('admin.assinatura.assinar')}}" class="btn btn-azul btn-medio d-block m-auto" >Mudar Plano</a>        						
        					</div>	
                                      
                              

			</div>
			</fieldset>
			<fieldset>
				<legend>Histórico de Planos</legend>
				  <div class="col-12">
                    <div class="px-2 pb-4">
                        <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                                <thead>
                                        <tr>
                                                <th align="center">Id</th>
                                                <th align="left" >Plano</th>
                                                <th align="center">Data Aquisição</th>
                                                <th align="center">Valor Contrato</th>
                                                <th align="center">Valor Recorrente</th>
                                                <th align="center">Status</th>
                                                <th align="center">Faturas</th>
                                        </tr>
                                </thead>
                                <tbody>	
                                @foreach($lista as $l)
            						<tr>
            							<td align="center">{{$l->id}}</td>
            							@if($l->eh_teste=="S")
            								<td align="left">Plano Teste: {{$l->planopreco->plano->nome}}</td>
            							@else
            								<td align="left">Assinatura: {{$l->planopreco->plano->nome}}</td>
            							@endif
            							
            							<td align="center">{{databr($l->data_aquisicao)}}</td>
            							<td align="center">{{$l->valor_contrato}}</td>
            							<td align="center">{{$l->valor_recorrente}}</td>
            							<td align="center">{{$l->status->status}}</td> 
                							@if($l->eh_teste=="S")
                								@if($l->status_id==config("constantes.status.ATIVO"))
                									<td align="center"><a href="{{route('admin.assinatura.pagamento', $l->id)}}" class="btn btn-outline-roxo">Assinar</a></td>
                								@else
                									<td align="center">---</td>
                								@endif                																		
                                           @else
                								<td align="center"><a href="{{route('admin.assinatura.faturas', $l->id)}}" class="btn btn-outline-roxo">Ver Faturas</a></td>										
                                           @endif
                                        
            					@endforeach
            					</tbody>
            			</table>   
            	</div>
		</div>
			</fieldset>
			
		</div>
		  

	  </div>		
		</div>
		
	  </div>
	
@endsection