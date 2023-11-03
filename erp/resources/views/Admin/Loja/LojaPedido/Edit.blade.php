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
		<fieldset class="mt-4">
	<legend>Dados do Pedido</legend>
			<div class="rows">
					<div class="col-6">
                        <label class="text-label d-block ">Cliente</label>
                        <div class="group-btn">	                                
                            <input type="text" name="desc_cliente" id="desc_cliente" value="{{$pedido->cliente->nome_razao_social ?? null}}" class="form-campo">
                            <input type="hidden" name="cliente_id" value="{{$pedido->cliente_id ?? null}}"  id="cliente_id" >       
                           <a href="{{route('admin.cliente.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
						</div>                               
                    </div>  
                    <div class="col-3">	
                         <label class="text-label d-block ">Cód. de Rastreamento</label>
                         <input type="text" name="codigo_rastreio" id="codigo_rastreio" value="{{($pedido->codigo_rastreio) ?? old('codigo_rastreio')}}"  class="form-campo  ">
                     </div>
                     
                     <div class="col-3">	
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
                     
                     
                      <div class="col-2 mb-3 position-relative">       
                      	<label class="text-label d-block ">.</label>            
            			<button type="button" class="btn btn-azul" onclick="atualizarDadosPagamentos({{$pedido->id}})"> Atualizar Valores</button>
            		</div>
            </div>
		</fieldset>
		
		<fieldset class="mt-3 mb-0">                 
				<legend>Itens do Pedido</legend>
                    <div class="pt-0">
						<div class="rows">	
						
                            <div class="col-6">
                                <label class="text-label d-block ">produto</label>
                                <div class="group-btn">	                                
                                    <input type="text" name="desc_produto" id="desc_produto" class="form-campo">
                                    <input type="hidden" name="produto_id"   id="produto_id" >       
                                   <a href="{{route('admin.produto.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
    							</div>                               
                            </div>
                            
                          <div class="col-2">	
                            <label class="text-label d-block ">Unidade</label>
                            <select id="unidade_venda" class="form-campo" onchange="selecionarUnidade()"></select>
                        </div>
                                                               
                         <div class="col-2">	
                            <label class="text-label d-block ">Valor de Venda</label>
                            <input type="text" name="valor"  value="0" id="valor" class="form-campo mascara-float">
                        </div>
                        
                                                        
                        
                        <div class="col-2">	
                            <label class="text-label d-block ">Quantidade</label>
                            <input type="text" name="quantidade" id="quantidade" value="1" class="form-campo mascara-float">
                            <input type="hidden" id="desc_produto">
                        </div> 
                        <div class="col-2 mb-3">
                                 <label class="text-label">Tipo Desconto</label>
                                 <select  class="form-campo" id="tipo_desc" name="tipo_desc"  onchange="calcularDescontoItem()">
                                 	<option value="desc_perc">Percento (%)</option>
                                 	<option value="desc_valor">Valor (R$)</option>
                                 </select>
                        </div> 
                        
                        <div class="col-2 mb-3">
                                 <label class="text-label">Desconto (R$)</label>
                                 <input type="text" name="val_desconto" id="val_desconto"  value="0"  class="form-campo mascara-float">
                        </div> 
                        
                        <div class="col-2">	
                            <label class="text-label d-block ">Subtotal</label>
                            <input type="text" name="subtotal"  value="0" id="subtotal" class="form-campo mascara-float">
                        </div>
                        <div class="col-2 mb-3">
                                 <label class="text-label">Total Desconto</label>
                                 <input type="text" readonly="readonly" id="desconto"   class="form-campo mascara-float">
                        </div>
                        
                        <div class="col-2 mb-3">
                                 <label class="text-label">Total Geral</label>
                                 <input type="text" readonly="readonly" id="total_item"   class="form-campo mascara-float">
                        </div>
						   
                        <div class="col-2 mt-1">
                        <input type="hidden" readonly="readonly" id="desconto_item"   class=" mascara-float">
                        	<a style="margin-top: 11px;" id="addProd" class="btn btn-roxo text-uppercase">
								INS
							</a>
                        </div>                            
                     </div>
                    
                </div>
                
                <div class="tabela-responsiva pb-4 prod table border-top mt-4 border-left border-bottom border-right" style="background: #f3f3f3;">
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
                                    <th align="center">Excluir</th>
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
                            		<td align="center">
                                        <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$v->id}}').submit() : '';" title="Excluir">Excluir</a>
                                            <form action="{{route('admin.lojaitempedido.destroy', $v->id)}}" method="POST" id="apagar{{$v->id}}">
                                                <input type="hidden" name="_method" value="DELETE">
                                                {{csrf_field()}}
                                            </form>
                                         </td>		
                            	</tr>
                            @endforeach
                           
							</tbody>
                            </table>
								
                   </div>

                </fieldset>
				
          <fieldset class="mt-3 mb-0"> 
			<div class="rows">
			<div class="col-12">		
             <fieldset class="p-2">
				<legend class="h5 mb-0 text-left">Conta a Receber </legend>
			 
            <div class="caixa px-2">
            <div class="rows">
               
                
                
            </div>
            
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0" class="table table-bordered menor fatura" width="100%">
                    <thead>
						<tr>
                            <th align="center">Id</th>
                            <th align="center">Data Emissão</th>
                            <th align="center">Data Vencimento</th>
                            <th align="center">Valor</th>     
                            <th align="center">Status</th>   
                        </tr>
                    </thead>
                     <tbody id="lista_duplicata">
                  	@foreach($contas_receber as $c)
                            <tr>
                            	<td align="center">{{$c->id}}</td>
                                <td align="center" width="15%">{{ databr($c->data_emissao) }}</td>
                                <td align="center" width="35%">{{ databr($c->data_vencimento) }}</td>
                                <td align="center" width="35%">{{ $c->total_liquido}}</td>
                                <td align="center" width="35%">{{ $c->status->status}}</td>
                            </tr>
                            
                            @foreach($c->recebimentos as $r)                           
                            	{{$r->id}} - {{$r->descricao_recebimento}} - {{$r->forma_pagamento->forma_pagto}}  - {{$r->valor_recebido}}
                            @endforeach
                     @endforeach
                    </tbody>                
           </table>	
                  
            </div>

		
            </div>
			
     
		</fieldset>
			</div>
			   
			</div>
		</fieldset>
	
	
	
		
	
	
    </div>  
 </div>
 

 </div>  
		
</div>


@endsection