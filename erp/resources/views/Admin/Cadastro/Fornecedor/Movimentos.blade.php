<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
	<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de Movimentação do Fornecedor: {{$fornecedor->razao_social}} </span>
	<div>
		<!--<a href="javascript:;" onclick="abrirModal('#add')" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Cadastrar categoria</a>-->
		<a href="{{route('admin.fornecedor.index')}}" class="btn btn-azul btn-pequeno d-inline-block" title="Volta"><i class="fas fa-arrow-left"></i></a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	</div>
</div>                      

   <div id="tab">
		     
	  <div>
		<div class="p-2 pt-4">
			<fieldset>
				<legend>Resumo de Geral</legend>
				<div class="rows">
					<div class="px-2 mt-3 pb-5 historico-movimentacao">
        				<div class="rows">	
        					 <div class="col-3 d-flex">
            					<div class="caixa width-100"> 
            						<i >ERP</i>
            						<div class="box">
            							<strong class="text-entrada">
            								<span class="tt">Qtde Vendas</span>{{$qtde_venda_erp}}
            								<span class="tt">Total Vendas</span>R$ {{$soma_venda_erp}}
            								<a href="">Ver</a>
            							</strong>
            						</div>
            					</div>
            				</div>
            				<div class="col-3  d-flex">
            					<div class="caixa width-100"> 
            						<i >PDV</i>
            						<div class="box">
            							<strong class="text-saida">
            								<span class="tt">Qtde Vendas</span>{{$qtde_venda_pdv}}
            								<span class="tt">Total Vendas</span>R$ {{$soma_venda_pdv}}
            								<a href="">Ver</a>
            							</strong>
            							
            						</div>
            					</div>
            				</div>                       
                            <div class="col-3  d-flex">
        					<div class="caixa width-100">
        						<i >LOJA</i>
        						<div class="box">							
        							<strong class="text-estoque">
        								<span class="tt">Qtde Vendas</span>{{$qtde_venda_loja}}
        								<span class="tt">Total Vendas</span>R$ {{$soma_venda_loja}}
        								<a href="">Ver</a>
        							</strong>
        						</div>
        					</div>
        				</div>
				
        				<div class="col-3 d-flex">
        					<div class="caixa width-100">
        						<i>Financeiro</i>
        						<div class="box">							
        							<strong class="text-estoque">
        								<span class="tt">Total Pago</span> R$ {{$total_recebimento}}
        								<a href="">Ver</a>
        								<span class="tt">Total a Pagar</span> R$ {{$total_a_pagar}}
        								<a href="">Ver</a>
        							</strong>
        						</div>
        					</div>
        				</div>  
        		</div>
        		</div>  
				</div>
			</fieldset>
         
			
		<ul>
			<li><a href="#tab-1">Limite de Crédito</a></li>
			<li><a href="#tab-2">Títulos em Aberto</a></li>
			<li><a href="#tab-3">Títulos em Atraso</a></li>
			<li><a href="#tab-4">Pedido em Aberto</a></li>
		</ul>	
		
		<div id="tab-1"  class="py-4">									
			<div class="rows">	
				<div class="col-12">        
										
			<div class="rows">
                <div class="col-12">
                	<fieldset>
        			<legend>Limite de Crédito</legend>	
    				
        			<div class="rows">
        			<div class="col-12"> 
                             
                        <div class="tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                            <table cellpadding="0" cellspacing="0" id="" width="100%">
                                    
                                    <tbody class="datatable-body" id="lista_produto_marca">
                                    
                                    	<tr>
                                    		<td align="left">Limite de Crédito do Cliente</td>
                                    		<td align="left">0,00</td> 
                                    	</tr>
                                    	<tr>
                                    		<td align="left">Valor de Títulos em Aberto</td>
                                    		<td align="left">0,00</td> 
                                    	</tr>
                                    	<tr>
                                    		<td align="left">Valor de Títulos em Atraso</td>
                                    		<td align="left">0,00</td> 
                                    	</tr>
                                    	<tr>
                                    		<td align="left">Valor de Vendas em Aberto</td>
                                    		<td align="left">0,00</td> 
                                    	</tr>
                                    	<tr>
                                    		<td align="left">ValorLimite Disponível</td>
                                    		<td align="left">0,00</td> 
                                    	</tr>                                   
        							</tbody>
                              </table>
        								
                           </div>
                        </div>
                </div>
        			</fieldset>
                    </div>                  
         	</div>
      
				</div>
              
         </div>
		</div>
		
		<div id="tab-2" class="py-4">								
			<div class="rows">
        <div class="col-12">
        	<fieldset>
				<legend>Títulos em Aberto</legend>	
				   <div class="rows">				                                  
						  <table cellpadding="0" cellspacing="0" width="100%" id="">
								<thead>
									<tr>
										<th align="center">Id</th>
                                       <th class="text-left">Lançamento</th>
                                       <th align="center">Data Emissão</th>
                                       <th align="center">Vencimento</th>
                                       <th align="center">Previsão Pagto</th>                                       
                                       <th align="center">Valor Original</th>
                                       <th align="center">Total Recebido</th>
                                       <th align="center">Total Restante</th>
                                       <th align="center">Juros</th>
                                       <th align="center">Multa</th>
                                       <th align="center">Desconto</th>
                                      <!--   <th align="center">Total Líquido Recebido</th>   -->                                    
                                       <th align="center">Status</th>
									</tr>
								</thead>
								<tbody >
								@foreach($titulos_aberto as $lancamento)
									<tr>
                                       <td align="center">{{ $lancamento->id }}</td>
                                       <td align="left">{{ $lancamento->descricao }} <small class="d-block text-azul">{{ $lancamento->cliente->nome_razao_social }} <b class="qtd">{{ $lancamento->num_parcela }} / {{ $lancamento->ult_parcela }} </b></small></td>
                                       <td align="center">{{ databr($lancamento->data_emissao) }}</td>
                                       <td align="center">{{ databr($lancamento->data_vencimento) }}</td>
                                       <td align="center">{{ ($lancamento->data_previsao) ? databr($lancamento->data_previsao) : "--" }}</td>
                                       <td align="center">{{ $lancamento->total_recebido }}</td>
                                       <td align="center">{{ $lancamento->total_restante }}</td>
                                       <td align="center">{{ $lancamento->total_juros }}</td>
                                       <td align="center">{{ $lancamento->total_multa }}</td>
                                       <td align="center">{{ $lancamento->total_desconto }}</td>
                                       <td align="center">{{ $lancamento->total_desconto }}</td>
                                       <!--<td align="center">{{ $lancamento->total_liquido }}</td>-->
                                       
                                       <td align="center"><span class="{{ strtolower($lancamento->status->status) }}">{{ $lancamento->status->status }}</span></td>
                                    
									   <td align="center">
        								<a href="javascript:;" onclick="abrir_opcoes_receber({{$lancamento->id}})" ><i class="ellipsis-vertical"></i></a>
        							</td>
							
                                    </tr> 
								@endforeach								
								</tbody>
							</table>                          
					</div>
			</fieldset>
            </div>
                  
         </div>
         </div>
         
         <div id="tab-3" class="py-4">	
             <div class="rows">
            <div class="col-12">
            	<fieldset>
    			<legend>Títulos em Atraso</legend>	
    				   <div class="rows">				                                  
						  <table cellpadding="0" cellspacing="0" width="100%" id="">
								<thead>
									<tr>
										<th align="center">Id</th>
                                       <th class="text-left">Lançamento</th>
                                       <th align="center">Data Emissão</th>
                                       <th align="center">Vencimento</th>
                                       <th align="center">Previsão Pagto</th>                                       
                                       <th align="center">Valor Original</th>
                                       <th align="center">Total Recebido</th>
                                       <th align="center">Total Restante</th>
                                       <th align="center">Juros</th>
                                       <th align="center">Multa</th>
                                       <th align="center">Desconto</th>
                                      <!--   <th align="center">Total Líquido Recebido</th>   -->                                    
                                       <th align="center">Status</th>
									</tr>
								</thead>
								<tbody >
								@foreach($titulos_atraso as $lancamento)
									<tr>
                                       <td align="center">{{ $lancamento->id }}</td>
                                       <td align="left">{{ $lancamento->descricao }} <small class="d-block text-azul">{{ $lancamento->cliente->nome_razao_social }} <b class="qtd">{{ $lancamento->num_parcela }} / {{ $lancamento->ult_parcela }} </b></small></td>
                                       <td align="center">{{ databr($lancamento->data_emissao) }}</td>
                                       <td align="center">{{ databr($lancamento->data_vencimento) }}</td>
                                       <td align="center">{{ ($lancamento->data_previsao) ? databr($lancamento->data_previsao) : "--" }}</td>
                                       <td align="center">{{ $lancamento->total_recebido }}</td>
                                       <td align="center">{{ $lancamento->total_restante }}</td>
                                       <td align="center">{{ $lancamento->total_juros }}</td>
                                       <td align="center">{{ $lancamento->total_multa }}</td>
                                       <td align="center">{{ $lancamento->total_desconto }}</td>
                                       <td align="center">{{ $lancamento->total_desconto }}</td>
                                       <!--<td align="center">{{ $lancamento->total_liquido }}</td>-->
                                       
                                       <td align="center"><span class="{{ strtolower($lancamento->status->status) }}">{{ $lancamento->status->status }}</span></td>
                                    
									   <td align="center">
        								<a href="javascript:;" onclick="abrir_opcoes_receber({{$lancamento->id}})" ><i class="ellipsis-vertical"></i></a>
        							</td>
							
                                    </tr> 
								@endforeach								
								</tbody>
							</table>                          
					</div>
    			</fieldset>
                </div>
                  
         </div>
      	</div>
         
		
		<div id="tab-4"  class="py-4">									
			<div class="rows">	
				<div class="col-12">        
				<fieldset>
					<legend>Vendas em Aberto</legend>	
						    <div class="rows">				                                  
						  <table cellpadding="0" cellspacing="0" width="100%" id="">
								<thead>
									<tr>
										<th align="center">Id</th>
										<th align="left">Cliente</th>
										<th align="center">Data</th>
										<th align="center">Valor</th>
										<th align="center">Status Venda</th>
										<th align="center">Status Financeiro</th>
										<th align="center">Nota Gerada</th>
									</tr>
								</thead>
								<tbody >
								@foreach($vendas_aberto as $c)
									<tr>
									<td align="center">{{$c->id}} 
										<input type="hidden" id="nfe_{{$c->id}}" value="{{$c->enviou_nfe}}">										
										<input type="hidden" id="estoque_{{$c->id}}" value="{{$c->enviou_estoque}}">
									</td>
									<td align="center">{{substr($c->cliente->nome_razao_social, 0, 30)}}</td>
									<td align="center">{{ databr($c->data_venda)}}</td>
									
									<td align="center">{{ $c->valor_venda  }}	</td>
									<td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>									
									<td align="center"><span class="{{ strtolower($c->status_financeiro->status) }}">{{ $c->status_financeiro->status }}</span></td>
								    <td align="center">{{ isset($c->nfe) ? "Sim" : "Não"  }}	</td>
								
									<td align="right">	
											<input type="hidden" id="obs_{{$c->id}}" value="{{$c->observacao}}">																
											<a href="javascript:;" onclick="verObservacao({{$c->id}})" class="btn btn-verde d-inline-block" title="Observação"><i class="fas fa-edit"></i></a>
									</td>
									
									
								 </tr>
								@endforeach								
								</tbody>
							</table>                          
					</div>
					</fieldset>
				</div>
              
         </div>
		</div>

		
		</div>
	  </div>

	 
	  
	
         
 </div>
		<div class="col-12 text-center pb-4">	
				
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	  </div>

</div>

<script>


</script>

@endsection


