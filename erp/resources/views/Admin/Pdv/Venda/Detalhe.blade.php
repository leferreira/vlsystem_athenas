<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase  justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Detalhe da Venda</span>
	<div class="d-flex">
		<a href="{{route('admin.pdvvenda.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
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
                                        
							  			<div class="col-2 border-bottom mb-3">	
                                            <label class="text-label d-block ">Cliente</label>
                                             <input type="text"  value="{{$venda->cliente_nome}}" class="form-campo form-text" readonly>

                                        </div>     
                                        <div class="col-2 border-bottom mb-3">	
                                            <label class="text-label d-block ">Situação</label>
                                             <input type="text"  value="{{$venda->status->status}}" class="form-campo form-text" readonly>
                                        </div>  
                                        <div class="col-2 border-bottom mb-3">	
                                            <label class="text-label d-block ">Valor Bruto</label>
                                             <input type="text"  value="{{$venda->valor_total}}" class="form-campo form-text" readonly>
                                        </div> 
                                    	                                        
                                        
                                        <div class="col-2 border-bottom mb-3">	
                                            <label class="text-label d-block ">Desconto </label>
                                             <input type="text"  value="{{$venda->valor_desconto}}" class="form-campo form-text" readonly>
                                        </div>                                        
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Valor Líquido</label>
                                             <input type="text"  value="{{$venda->total_receber}}" class="form-campo  form-text" readonly>
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
                                    <th align="center">Desconto</th>
                                    <th align="center">Subtotal</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($venda->itens as $v)
                            	<tr>
                            		<td align="center">{{$v->id}}</td>
                            		<td align="center">{{$v->produto->nome}}</td>
                            		<td align="center">{{$v->produto->unidade}}</td>
                            		<td align="center">{{$v->qtde}}</td>
                            		<td align="center">{{$v->valor}}</td>
                            		<td align="center">{{$v->desconto_item}}</td>
                            		<td align="center">{{$v->subtotal}}</td>                      
                            	</tr>
                            @endforeach
                           
							</tbody>
                            </table>
								
                   </div>

                </fieldset>
			

			<fieldset class="mt-3 mb-0">                 
				<legend>Pagamentos</legend>
                <div class="tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" id="" width="100%">
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th align="center">Forma de Pagamento</th>
                                    <th align="center">Valor</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($venda->pagamentos as $v)
                            	<tr>
                            		<td align="center">{{$v->id}}</td>
                            		<td align="center">{{$v->forma_pagto->forma_pagto}}</td>
                            		<td align="center">{{$v->subtotal}}</td>
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

	

@endsection