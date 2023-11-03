
<div class="window medio" id="telaEstado">

	<div class="p-2 px-4">
			<span class="d-block h3 border-bottom fw-700">Produtos da Tributação</span>
		<div class="rows">
				<div class="col-3 mb-3">
						<label class="text-label">Estado </label>	
						<select class="form-campo" name="estado_id" id="estado_id" >							
							@foreach($estados as $e)
								<option value="{{$e->id}}" >{{$e->uf}} - {{$e->estado}} </option>
							@endforeach							
						</select>
				</div>
				<div class="col-6 mb-3">
					<label class="text-label">CST ICMS</label>
					<select class="form-campo" name="cstEstadoICMS" id="cstEstadoICMS"  >							
						@foreach($lista_cstIcms as $c)
							<option value="{{$c->cst}}" {{($natureza->cstICMS ?? null) == $c->cst ? "selected" : null }}>{{$c->descricao}}</option>
						@endforeach
					</select>	
						
				</div>
				
				<div class="col-3 mb-3">
						<label class="text-label">Tipo Contribuinte </label>	
						<select class="form-campo" name="tributacao_contribuinte_id" id="tributacao_contribuinte_id" >							
							@foreach($tipos as $t)
								<option value="{{$t->id}}" >{{$t->id}} -  {{$t->tipo_contribuinte}}</option>
							@endforeach							
						</select>
				</div>
				
				<div class="col-3 mb-3" >
						<label class="text-label">Alíquota ICMS</label>	
						<input type="text" name="pICMSEstado"   id="pICMSEstado" value="{{$nfeItem->pICMS ?? old('pICMS') }}" class="form-campo mascara-float ">
				</div>
				
				<div class="col-3 mb-3" >
						<label class="text-label">Alíquota FCP</label>	
						<input type="text" name="pFCPEstado"   id="pFCPEstado" value="{{$nfeItem->pICMS ?? old('pICMS') }}" class="form-campo mascara-float ">
				</div>
				
				<div class="col-3 mb-3" >
						<label class="text-label">CFOP</label>	
						<input type="text" name="cfopEstado"   id="cfopEstado" value="{{$nfeItem->pICMS ?? old('pICMS') }}" class="form-campo ">
				</div>
				
				
							
				
				 <div class="col-2 mb-3">
				 	<label class="text-label">.</label>	
				 	<input type="hidden" id="natureza_operacao_id"  value="{{$natureza->id ?? null}}"> 
				 	<input type="hidden" name="tributacao_id" id="tributacao_id" >
				 	<input type="button" value="Ins" id="btnInserirEstadoTributacao" class="btn btn-azul border-bottom width-100">						 	
        		 </div>
					
         </div>
         
         <div class="rows">
			<div class="col-12">
                <div class="scroll tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" width="100%" >
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th class="text-left">Estado</th>
                                    <th class="text-left">Tipo Contribuinte</th>
                                    <th class="text-left">Cfop</th>
                                    <th class="text-left">CST</th>
                                    <th class="text-left">pICMS</th>
                                    <th class="text-left">pFCP</th>
                                    <th align="center">Opções</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body" id="lista_estado_tributacao">   
                            
							</tbody>
                          </table>
								
                   </div>

                </div>
                </div>
                
			
         </div>
		 <div class="tfooter end">
			<a href="" class="btn btn-neutro fechar">Fechar</a> 
		 </div>
	</div>
