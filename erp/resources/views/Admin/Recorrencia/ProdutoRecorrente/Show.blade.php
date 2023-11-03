<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Venda</span>
	<div class="d-flex">
		<a href="{{route('admin.venda.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	
	</div>
</span>                      


			<div class="p-2 pb-0">
			<div class="rows">	
		
			
			
			
			<div class="col-12">
                <div class="caixa"> 
                    <fieldset class="pt-0 bg-padrao mb-0">
						 <div class="">							  
							<span class="titulo text-branco px-0">Dados da Venda </span>
							<div class="mt-2 radius-4">
							 <div class="rows">								 	
                                        
							 		  	<div class="col-3">	
                                            <label class="text-label d-block text-branco">Data Venda</label>
                                            <input type="date" name="data_venda" id="data_venda" value="{{$venda->data_venda ?? hoje()}}" class="form-campo ">
                                        </div>                                       
                                        <div class="col-8">
                                            <label class="text-label d-block text-branco">Cliente</label>
                                            <div class="group-btn">	                                
                                                <input type="text" name="desc_cliente" id="desc_cliente" value="{{$cliente->nome_razao_social ?? null}}" class="form-campo">
                                                <input type="hidden" name="cliente_id" value="{{$cliente->id ?? null}}"  id="cliente_id" >       
                							</div>                               
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
	
	  <div id="tab-1">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">		

                <fieldset class="mt-3 mb-0">                 
				<legend>Itens da Venda</legend>
                   
                
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
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($venda->itens as $v)
                            	<tr>
                            		<td align="center">{{$v->id}}</td>
                            		<td align="center">{{$v->produto->nome}}</td>
                            		<td align="center">{{$v->produto->unidade}}</td>
                            		<td align="center">{{$v->quantidade}}</td>
                            		<td align="center">{{formataNumeroBr($v->valor)}}</td>
                            		<td align="center">{{formataNumeroBr($v->subtotal)}}</td>
                            		<td align="center">{{formataNumeroBr($v->desconto_por_item)}}</td>
                            		<td align="center">{{formataNumeroBr($v->total_desconto_item)}}</td>
                            		<td align="center">{{formataNumeroBr($v->subtotal_liquido)}}</td>
                            				
                            	</tr>
                            @endforeach
                           
							</tbody>
                            </table>
								
                   </div>

                </fieldset>

				<fieldset class="mt-4">
	<legend>Totais do Pedido</legend>
	  <input type="hidden" id="_token" value="{{ csrf_token() }}"> 
			<div class="rows">
					<div class="col-2">	
                         <label class="text-label d-block ">Total dos Produtos</label>
                         <input type="text" name="valor_total"  value="{{($venda->valor_total) ?? old('valor_total')}}" disabled value="0" id="valor_total" class="form-campo">
                     </div>                                   
                     
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Valor Frete</label>
                         <input type="text" name="valor_frete" id="valor_frete" value="{{($venda->valor_frete) ?? old('valor_frete')}}"  class="form-campo  mascara-float">
                     </div>
                   
                     <div class="col-2">	
                         <label class="text-label d-block ">Desconto </label>
                         <input type="text" name="desconto_valor"  id="desconto_valor" value="{{($venda->valor_desconto) ?? old('valor_desconto')}}" class="form-campo mascara-float">
                     </div>
                    
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Total de Seguro </label>
                         <input type="text" name="total_seguro"  id="total_seguro"  value="{{($venda->total_seguro) ?? old('total_seguro')}}" class="form-campo mascara-float">
                     </div>
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Outras Despesas </label>
                         <input type="text" name="despesas_outras"  id="despesas_outras" value="{{($venda->despesas_outras) ?? old('despesas_outras')}}" class="form-campo mascara-float">
                     </div>
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Total da Venda</label>
                         <input type="text" name="totalvenda" disabled  id="totalvenda" value="{{($venda->valor_venda) ?? old('valor_venda')}}" class="form-campo">
                     </div>
                   
            </div>
		</fieldset>
            	
		
			<div class="rows">
			<div class="col-12">		
             <fieldset class="p-2">
				<legend class="h5 mb-0 text-left">Dados de Pagamento </legend>
			 
            <div class="caixa px-2">
          
            
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0" class="table table-bordered menor fatura" width="100%">
                    <thead>
						<tr>
                            <th align="center">Id</th>
                            <th align="center">Data</th>
                            <th align="center">Forma Pagto</th>
                            <th align="center">Valor</th>     
                            <th align="center">Observação</th>                       
                            
                        </tr>
                    </thead>
                    <tbody id="lista_duplicata">
                  @foreach($duplicatas as $duplicata)
                            <tr>
                            	<td align="center">{{$duplicata->nDup}}</td>
                                <td align="center" width="10%"><input type="date" value="{{$duplicata->dVenc}}" id="vencimento_{{$duplicata->id}}" class="form-campo" onchange="alterarDuplicata({{$duplicata->id}})" ></td>
                                
                                <td align="center" width="25%">
                                    <select class="form-campo" name="tPag" id="tPag_{{$duplicata->id}}" onchange="alterarDuplicata({{$duplicata->id}})">		
                            			 @foreach(ConstanteService::tiposPagamento() as $chave=>$valor)
                                			<option value="{{$chave}}" {{ ($duplicata->tPag ?? null ) == $chave ? 'selected' : null }} >{{$chave}} - {{$valor}}</option>
                                		 @endforeach
                            		</select>
        						</td>
                                <td align="center" width="15%"><input type="text" readonly="readonly" value="{{ $duplicata->vDup }}" name="primeiro_vencimento"  class="form-campo"></td>
                                <td align="center" width="35%"><input type="text"  id="obs_{{$duplicata->id}}" value="{{ $duplicata->obs }}" class="form-campo"></td>
                               
                            </tr>
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
	  </div>
	  </div>
 
	
 </div>  
		
</div>


@endsection