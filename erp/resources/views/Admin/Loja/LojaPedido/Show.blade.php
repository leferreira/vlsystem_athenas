<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Pedido Loja Virtual</span>
	<div class="d-flex">
		<a href="{{route('admin.lojapedido.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>	
	</div>
</span>                      

   <div id="tab">
	  <div id="tab-1">
		<div class="p-2">
		<input type="hidden" id="_token" value="{{ csrf_token() }}">
		<fieldset class="mt-0">
	<legend>Dados do Pedido</legend>
			<div class="rows">
					<div class="col-4 mb-2">
                        <label class="text-label d-block ">Cliente</label>
                        <div class="group-btn">	                                
                            <input type="text" name="desc_cliente" id="desc_cliente" value="{{$pedido->cliente->nome_razao_social ?? null}}" class="form-campo">
                            <input type="hidden" name="cliente_id" value="{{$pedido->cliente_id ?? null}}"  id="cliente_id" >       
						</div>                               
                    </div>  
                    <div class="col-3 mb-2">	
                         <label class="text-label d-block ">Cód. de Rastreamento</label>
                         <input type="text" name="codigo_rastreio" id="codigo_rastreio" value="{{($pedido->codigo_rastreio) ?? old('codigo_rastreio')}}"  class="form-campo  ">
                     </div>
                     
                     <div class="col-3 mb-2">	
                         <label class="text-label d-block ">Status de Entrega</label>
                         <select class="form-campo  " name="status_entrega_id" id="status_entrega_id">
                         	@foreach($status as $s)
                         	<option value="{{$s->id}}" {{ ($pedido->status_entrega_id ?? null ) == $s->id ? 'selected' : null }}> {{$s->status}}</option>
                         	@endforeach
                         </select>
                     </div>
              
					
					<div class="col-2">	
                         <label class="text-label d-block ">Data do Pedido</label>
                         <input type="date" name="data_pedido"  value="{{($pedido->data_pedido) ?? old('data_pedido')}}" disabled value="0" id="data_pedido" class="form-campo">
                     </div>                                   
                                          
                     <div class="col-2">	
                         <label class="text-label d-block ">Data do Pagamento</label>
                         <input type="date" name="data_pagamento" id="data_pagamento" value="{{($pedido->data_pagamento) ?? old('data_pagamento')}}"  class="form-campo  ">
                     </div>
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Data Separação </label>
                         <input type="date" name="data_separacao"  id="data_separacao"  value="{{($pedido->data_separacao) ?? old('data_separacao')}}" class="form-campo">
                     </div>
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Data de Envio </label>
                         <input type="date" name="data_envio"  id="data_envio" value="{{($pedido->data_envio) ?? old('data_envio')}}" class="form-campo ">
                     </div>
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Data Entrega </label>
                         <input type="date" name="data_entrega"  id="data_entrega" value="{{($pedido->data_entrega) ?? old('data_entrega')}}"  class="form-campo">
                     </div>
                     
                     
                      <div class="col-4 mb-3 position-relative">       
                      	<label class="text-label d-block ">.</label>            
            			<button type="button" class="btn btn-azul" onclick="atualizarDadosPagamentos({{$pedido->id}})"> Atualizar Valores</button>
            		</div>
            </div>
		</fieldset>
		
		<fieldset class="mt-3 mb-0">                 
				<legend>Itens do Pedido</legend>                    
                
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
                                    <th align="center">Desconto (unit)</th>
                                    <th align="center">Desconto (total)</th>
                                    <th align="center">Líquido</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($pedido->itens as $v)
                            	<tr>
                            		<td align="center">{{$v->id}}</td>
                            		<td align="center">{{$v->produto->nome}}</td>
                            		<td align="center">{{$v->produto->unidade}}</td>
                            		<td align="center">{{$v->quantidade}}</td>
                            		<td align="center">{{formataNumeroBr($v->valor)}}</td>
                            		<td align="center">{{formataNumeroBr($v->subtotal)}}</td>
                            		<td align="center">{{formataNumeroBr($v->desconto_por_unidade)}}</td>
                            		<td align="center">{{formataNumeroBr($v->total_desconto_item)}}</td>
                            		<td align="center">{{formataNumeroBr($v->subtotal_liquido)}}</td>
                            			
                            	</tr>
                            @endforeach
                           
							</tbody>
                            </table>
								
                   </div>

                </fieldset>
				
          <fieldset class="mt-3 mb-0"> 
			<legend class="h5 mb-0 text-left">Conta a Receber </legend>
					
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0"  width="100%" id="dataTable" class="contas border">
                    <thead>
						
                    </thead>
                     <tbody id="lista_duplicata">
                  	@foreach($contas_receber as $c)
						<tr style="background: #00000014;">
                            <th align="center">Id</th>
                            <th align="center">Data Emissão</th>
                            <th align="center">Data Vencimento</th>
                            <th align="center">Valor</th>     
                            <th align="center">Status</th>   
                        </tr>
                            <tr>
                            	<td align="center">{{$c->id}}</td>
                                <td align="center" width="15%">{{ databr($c->data_emissao) }}</td>
                                <td align="center" width="35%">{{ databr($c->data_vencimento) }}</td>
                                <td align="center" width="35%">{{ $c->total_liquido}}</td>
                                <td align="center" width="35%">{{ $c->status->status}}</td>
                            @if(count($c->recebimentos) > 0)           
                                  
                                    	<tr>                                   
                                           <td colspan="5" align="center">
    											<table cellpadding="0" cellspacing="0" class="table table-bordered menor fatura m-auto" style="width:95%">
    												<thead>
    													<tr>
    													   <th align="center" colspan="11"><span  class="h6 mb-0">RECEBIMENTOS</span></th>
    													 </tr>
    													<tr>
    														<th align="center">Id</th>
                                                               <th class="text-left">Descrição</th>
                                                               <th align="center">Data Pagamento</th>
                                                               <th align="center">Número</th>
                                                               <th align="center">Valor Original</th>
                                                               <th align="center">Juros</th>
                                                               <th align="center">Desconto</th>
                                                               <th align="center">Multa</th>
                                                               <th align="center">Valor Recebido</th>
                                                               <th align="center">Forma Pagto</th>
    													</tr>
    												</thead>
    												 <tbody>
    												 @foreach($c->recebimentos as $pag)
    													<tr>
                                                           <td align="center">{{ $pag->id }}</td>
                                                           <td align="left">{{ $pag->descricao_pagamento }} </td>
                                                           <td align="center">{{ databr($pag->data_pagamento) }}</td>
                                                           <td align="center">{{ $pag->numero_documento }}</td>
                                                           <td align="center">{{ formataNumeroBr($pag->valor_original) }}</td>
                                                           <td align="center">{{ formataNumeroBr($pag->juros) }}</td>
                                                           <td align="center">{{ formataNumeroBr($pag->desconto) }}</td>
                                                           <td align="center">{{ formataNumeroBr($pag->multa) }}</td>
                                                           <td align="center">{{ formataNumeroBr($pag->valor_recebido) }}</td>
                                                           <td align="center">{{ $pag->forma_pagamento->forma_pagto }}</td>
                                                           
                                                        </tr>
    													@endforeach
    												</tbody>                
    											</table>
    									   </td>                                   
    							
                                    </tr>
    
    					@endif    
                                
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


@endsection