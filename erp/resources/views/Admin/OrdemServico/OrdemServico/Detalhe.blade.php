<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase  justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Detalhe da Venda</span>
	<div class="d-flex">
		<a href="{{route('admin.venda.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	</div>
</span>                      


<div class="p-2 pb-0">
			<div class="rows">	
			
			<div class="col-12">
                <div class="caixa"> 
                    <fieldset class="pt-0 bg-cinza mb-0">
						 <div class="">							  
							<span class="titulo px-0">Dados da Venda</span>
							<div class="mt-2 radius-4 detalhes">
							 <div class="rows">								 	
                                        
							 		  	<div class="col-2 border-bottom mb-3">	
                                            <label class="text-label d-block ">Data Venda</label>
                                            <input type="text"  value="{{databr($venda->data_venda)}}" class="form-campo form-text" readonly>
                                        </div>                                       
                                        
							  			<div class="col-4 border-bottom mb-3">	
                                            <label class="text-label d-block ">Cliente</label>
                                             <input type="text"  value="{{$venda->cliente->nome_razao_social}}" class="form-campo form-text" readonly>

                                        </div>     
                                        <div class="col-2 border-bottom mb-3">	
                                            <label class="text-label d-block ">Situação</label>
                                             <input type="text"  value="{{$venda->status->status}}" class="form-campo form-text" readonly>
                                        </div>  
                                        <div class="col-2 border-bottom mb-3">	
                                            <label class="text-label d-block ">Total dos Produtos</label>
                                             <input type="text"  value="{{$venda->valor_total}}" class="form-campo form-text" readonly>
                                        </div> 
                                    	 <div class="col-2 border-bottom mb-3">	
                                            <label class="text-label d-block ">Frete</label>
                                             <input type="text"  value="{{$venda->valor_frete}}" class="form-campo form-text" readonly>
                                        </div> 
                                        <div class="col-2 border-bottom mb-3">	
                                            <label class="text-label d-block ">Desconto Itens</label>
                                             <input type="text"  value="{{$venda->total_desconto_item}}" class="form-campo form-text" readonly>
                                        </div> 
                                        
                                        <div class="col-2 border-bottom mb-3">	
                                            <label class="text-label d-block ">Desconto Nota</label>
                                             <input type="text"  value="{{$venda->valor_desconto}}" class="form-campo form-text" readonly>
                                        </div>                                        
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Valor a Pagar</label>
                                             <input type="text"  value="{{$venda->valor_venda}}" class="form-campo  form-text" readonly>
                                        </div>                                        
                                       
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Parcelas</label>
                                             <input type="text"  value="{{$venda->qtde_parcela}} X de R$ {{($venda->valor_venda) / $venda->qtde_parcela}}" class="form-campo  form-text" readonly>
                                        </div>
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Primeiro Vencimento</label>
                                             <input type="text"  value="{{databr($venda->primeiro_vencimento)}}" class="form-campo  form-text" readonly>
                                        </div>
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Ultimo Vencimento</label>
                                             <input type="text"  value="{{databr(somarData($venda->primeiro_vencimento,($venda->qtde_parcela-1) * 30 ))}}" class="form-campo  form-text" readonly>
                                        </div>
                                </div>
                                </div>
							</div>
                        </fieldset>
                    
               
                </div>
                
              


			</div>
		</div>
	  </div>



   <div id="tab">
	  <ul>
		<li><a href="#tab-1">Itens</a></li>
		<li><a href="#tab-2">Contas a Receber</a></li>
		@if($venda->transportadora)
			<li><a href="#tab-3">Transporte</a></li>
		@endif
	  </ul>
	  <div id="tab-1">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">	
                <fieldset class="mt-3 mb-0">                 
				<legend>Itens da Venda</legend>
                <div class="tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" id="" width="100%">
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th align="center">Nome</th>
                                    <th align="center">Unidade</th>
                                    <th align="center">Quantidade</th>
                                    <th align="center">Valor Unit</th>
                                    <th align="center">Subtotal</th>
                                    <th align="center">Desconto</th>
                                    <th align="center">Total c/ Desconto</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($venda->itens as $v)
                            	<tr>
                            		<td align="center">{{$v->id}}</td>
                            		<td align="center">{{$v->produto->nome}}</td>
                            		<td align="center">{{$v->produto->unidade}}</td>
                            		<td align="center">{{$v->quantidade}}</td>
                            		<td align="center">{{$v->valor}}</td>
                            		<td align="center">{{$v->subtotal}}</td>
                            		<td align="center">{{$v->desconto_item}}</td>
                            		<td align="center">{{$v->subtotal - $v->desconto_item}}</td>
                            	</tr>
                            @endforeach
                           
							</tbody>
                            </table>
								
                   </div>

                </fieldset>
				
				 <fieldset class="mt-4">
					<legend>Observação</legend>	   
						<div class="border radius-4 p-1 detalhes">
							<div class="rows">	
								<div class="col-12 mb-3">
										<label class="text-label">Observação Externa</label>	
										<input type="text" name="observacao" value="" id="observacao" class="form-campo form-text" readonly>
								</div>		
								
								<div class="col-12 mb-3">
										<label class="text-label">Observação Interna</label>	
										<input type="text" name="observacao_interna" value="" id="observacao_interna" class="form-campo form-text" readonly>
								</div>	
							</div>
						</div>
				</fieldset>


			</div>
		</div>
	  </div>
	  </div>
	    <div id="tab-2">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">	
                <fieldset class="mt-3 mb-0">                 
				<legend>Contas a Receber</legend>
                <div class="tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" id="" width="100%">
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th align="center">Nome</th>
                                    <th align="center">Data Vencimento</th>
                                    <th align="center">Data Pagamento</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($venda->duplicatas as $v)
                            	<tr>
                            		<td align="center">{{$v->id}}</td>
                            		<td align="center">{{$v->descricao}}</td>
                            		<td align="center">{{databr($v->data_vencimento)}}</td>
                            		<td align="center">{{($v->recebimento) ? databr($v->recebimento->data_vencimento) : "--"}}</td>                            		
                            		<td align="center">{{$v->valor}}</td>
                            		<td align="center">{{$v->status->status}}</td>
                            	</tr>
                            @endforeach
							</tbody>
                            </table>
								
                   </div>

                </fieldset>
				
				 <fieldset class="mt-4">
					<legend>Observação</legend>	   
						<div class="border radius-4 p-1 detalhes">
							<div class="rows">	
								<div class="col-12 mb-3">
										<label class="text-label">Observação Externa</label>	
										<input type="text" name="observacao" value="" id="observacao" class="form-campo form-text" readonly>
								</div>		
								
								<div class="col-12 mb-3">
										<label class="text-label">Observação Interna</label>	
										<input type="text" name="observacao_interna" value="" id="observacao_interna" class="form-campo form-text" readonly>
								</div>	
							</div>
						</div>
				</fieldset>


			</div>
		</div>
	  </div>
	  </div>
	  
	 @if($venda->transportadora) 
	   <div id="tab-3">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">			
			<fieldset class="mt-3">
            <legend class="h5 mb-0 text-left">Transportadora</legend>
            <div class="rows px-2">
                <div class="col-12 mb-3">
                <div class="border radius-4 p-1 detalhes">
                    <label class="text-label">Transportadora</label>	
					<input type="text"  value="{{$venda->transportadora->razao_social}}"  class="form-campo form-text" readonly>
            	</div>
            	</div>
            	
           <div class="col-12 mb-3">
                <div class="border radius-4 p-1 detalhes">
				<span class="h5 mb-3 text-left text-uppercase fw-700 border-bottom">Frete</span>
               @php
               		$modfrete = ($venda->frete->modfrete) ?? null;
               @endphp
        			<div class="rows">
        			<div class="col-4 mb-3 border-right">
                        <label class="text-label">Tipo de Frete</label>	
                        <select class="form-campo form-text" name="modfrete" id="modfrete" disabled="disabled">
                			<option value="9" {{($modfrete==9) ? 'selected' : ''}}>9 - Sem Ocorrência de Transporte</option>
                			<option value="0" {{($modfrete==0) ? 'selected' : ''}}>0 - Frete por conta do Remetente (CIF)</option>
                			<option value="1" {{($modfrete==1) ? 'selected' : ''}}>1 - Frete por conta do Destinatário (FOB)</option>
                			<option value="2" {{($modfrete==2) ? 'selected' : ''}}>2 - Frete por conta de Terceiros</option>
                			<option value="3" {{($modfrete==3) ? 'selected' : ''}}>3 - Transporte Próprio por conta do Remetente</option>
                			<option value="4" {{($modfrete==4) ? 'selected' : ''}}>4 - Transporte Próprio por conta do Destinatário</option>
                		</select>
                	</div>
            			<div class="col-3 mb-3  border-right">
                            <label class="text-label">Placa veículo</label>	
                            <input type="text" name="placa" id="placa" value="{{($venda->frete) ? $venda->frete->placa : ''}}"  class="form-campo form-text" readonly>
        				</div>
        				<div class="col-3 mb-3  border-right">
                            <label class="text-label">UF veículo</label>
                             <input type="text" name="placa" id="placa" value="{{($venda->frete) ? $venda->frete->uf : ''}}"  class="form-campo form-text" readonly>
	
                            
        				 </div> 
            				
            				<div class="col-2 mb-3">
                                <label class="text-label">Valor</label>	                   
                            <input type="text" name="placa" id="placa" value="{{($venda->frete) ? $venda->frete->valor : ''}}"  class="form-campo form-text" readonly>
            				</div>
        						
        			</div>
        		</div>
        	</div>
        	<div class="col-12 mb-3">
                <div class="border radius-4 p-1 detalhes">
           				<span class="h5 mb-3 text-left text-uppercase fw-700 border-bottom">Volume</span>
            			<div class="rows p-2">		
            				<div class="col mb-3 border-right">
                                <label class="text-label">Especie</label>	                   
                            <input type="text" name="placa" id="placa" value="{{($venda->frete) ? $venda->frete->especie : ''}}"  class="form-campo form-text" readonly>
            				</div>
            				<div class="col mb-3 border-right">
                                <label class="text-label">Numeraçáo de Volume</label>	                   
                                <input type="text" name="numeracaoVol" id="numeracaoVol"  class="form-campo form-text" readonly>
            				</div>
            				<div class="col mb-3 border-right">
                                <label class="text-label">Qtde de Volume</label>	                   
                            <input type="text" name="placa" id="placa" value="{{($venda->frete) ? $venda->frete->qtdVolumes : ''}}"  class="form-campo form-text" readonly>
            				</div>
            				
            				<div class="col mb-3 border-right">
                                <label class="text-label">Peso Líquido</label>	                   
                            <input type="text" name="placa" id="placa" value="{{($venda->frete) ? $venda->frete->peso_liquido : ''}}"  class="form-campo form-text" readonly>
            				</div>
            				<div class="col mb-3">
                                <label class="text-label">Peso Bruto</label>	                   
                            <input type="text" name="placa" id="placa" value="{{($venda->frete) ? $venda->frete->peso_bruto : ''}}"  class="form-campo form-text" readonly>
            				</div>
            			</div>	
            </fieldset>
			</div>
			</div>
		</div>
	  </div>
	  </div>
	@endif 
 </div>  
		
</div>

	

@endsection