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
                                        
							 		  	<div class="col-2">	
                                            <label class="text-label d-block text-branco">Data Venda</label>
                                            <input type="date" name="data_venda" id="data_venda" value="{{$venda->data_venda ?? hoje()}}" class="form-campo ">
                                        </div>                                       
                                        <div class="col-4">
                                            <label class="text-label d-block text-branco">Cliente</label>
                                            <div class="group-btn">	                                
                                                <input type="text" name="desc_cliente" id="desc_cliente" value="{{$cliente->nome_razao_social ?? null}}" class="form-campo">
                                                <input type="hidden" name="cliente_id" value="{{$cliente->id ?? null}}"  id="cliente_id" >       
                                               <a href="{{route('admin.cliente.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
                							</div>                               
                                        </div>
                                        
                                        <div class="col-3">
                                            <label class="text-label d-block text-branco">Vendedor</label>
                                            <div class="group-btn">	                                
                                                <input type="text" name="desc_vendedor" id="desc_vendedor"  value="{{$vendedor->nome ?? null}}" class="form-campo">
                                                <input type="hidden" name="vendedor_id" value="{{$vendedor->id ?? null}}"  id="vendedor_id" >        
                                               <a href="{{route('admin.vendedor.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
                							</div>                               
                                        </div>
                                        
                                        <div class="col-3">
                				 		 <label class="text-label d-block text-branco">Tabela de Preço </label>
                				 		 <div class="group-btn">
                				  			<select class="form-campo" id="tabela_preco_id">
                				  				@foreach($precos as $preco)
                				  					<option value='{{$preco->id}}' >{{$preco->nome}}</option>
                				  				@endforeach				  			
                				  			</select>
                				  			 <a href="{{route('admin.vendedor.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas " title="Inserir novo Cliente"></a>
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
	  <ul>
		<li><a href="#tab-1">Itens</a></li>
		<li><a href="#tab-2">Pagamento</a></li>
	  </ul>
	  <div id="tab-1">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">		

                <fieldset class="mt-3 mb-0">                 
				<legend>Itens da Venda</legend>
                    <div class="pt-0">
						<div class="rows">	
						
                            <div class="col-6 mb-3">
                                <label class="text-label d-block ">produto</label>
                                <div class="group-btn">	                                
                                    <input type="text" name="desc_produto" id="desc_produto" class="form-campo">
                                    <input type="hidden" name="produto_id"   id="produto_id" >       
                                   <a href="{{route('admin.produto.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
    							</div>                               
                            </div>
                            
                          <div class="col-2 mb-3">	
                            <label class="text-label d-block ">Unidade</label>
                            <select id="unidade_venda" class="form-campo" onchange="selecionarUnidade()"></select>
                        </div>
                                                               
                         <div class="col-2 mb-3">	
                            <label class="text-label d-block ">Valor de Venda</label>
                            <input type="text" name="valor" readonly="readonly" value="0" id="valor" class="form-campo mascara-float">
                        </div>
                        
                                                        
                        
                        <div class="col-2 mb-3">	
                            <label class="text-label d-block ">Quantidade</label>
                            <input type="text" name="quantidade" id="quantidade" value="1" class="form-campo mascara-float">                          
                        </div> 
                        <div class="col-2 mb-3">
                             <label class="text-label">Desconto perc (%)</label>
                             <input type="text" name="desconto_percentual" id="desconto_percentual"  value="0"  class="form-campo mascara-float">
                        </div> 
                        
                        <div class="col-2 mb-3">
                             <label class="text-label">Desconto Valor (R$)</label>
                             <input type="text" name="desconto_por_valor" id="desconto_por_valor"  value="0"  class="form-campo mascara-float">
                        </div>
                        
                        <div class="col-2">	
                            <label class="text-label d-block ">Subtotal</label>
                            <input type="text" name="subtotal" readonly="readonly"  value="0" id="subtotal" class="form-campo mascara-float">
                        </div>
                        <div class="col-2 mb-3">
                                 <label class="text-label">Total Desconto</label>
                                 <input type="text" readonly="readonly" id="total_desconto_item"   class="form-campo mascara-float">
                        </div>
                        
                        <div class="col-2 mb-3">
                                 <label class="text-label">Total Geral</label>
                                 <input type="text" readonly="readonly" id="subtotal_liquido"   class="form-campo mascara-float">
                        </div>
						   
                        <div class="col-2 mt-2">
                        <input type="hidden" readonly="readonly" id="desconto_item"   class=" mascara-float">
                        	<input type="hidden" id="usa_grade" name="usa_grade">
						   <input type="hidden" id="estoque" >
						   <input type="hidden" id="estoque_grade" >
						   <a href="javascript:;" onclick="inserirItem()" class="btn btn-roxo text-uppercase"> Inserir</a>
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
                                    <th align="center">Situação</th>
                                    <th align="center">Excluir</th>
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
                            		<td align="center">{{formataNumeroBr($v->desconto_por_unidade)}}</td>
                            		<td align="center">{{formataNumeroBr($v->total_desconto_item)}}</td>
                            		<td align="center">{{formataNumeroBr($v->subtotal_liquido)}}</td>
                            		@if($v->produto->usa_grade=="S")
                            			<td align="center">
                            				@if(validarGrade($v->quantidade, 'item_venda_id', $v->id ))
                            					<a href="javascript:;" onclick="abrirGradeProduto({{$v->id }}, {{$v->produto_id }}, 'item_venda_id')" title="Ajustar Grade" class="btn btn-azul btn-pequeno d-inline-block">ver Grade</a> 
                                         	@else
                                     		  <a href="javascript:;" onclick="abrirGradeProduto({{$v->id }}, {{$v->produto_id }}, 'item_venda_id')" title="Ajustar Grade" class="btn btn-laranja btn-pequeno d-inline-block">Ajustar Grade</a>
                                         	@endif
                                         </td>
                            		@else
                            			<td align="center">--</td>
                            		@endif
                            		
                            		<td align="center">
                                        <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$v->id}}').submit() : '';" title="Excluir"  class="text-vermelho d-inline-block fas fa-trash-alt"></a>
                                            <form action="{{route('admin.itemvenda.destroy', $v->id)}}" method="POST" id="apagar{{$v->id}}">
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


            	
	
			</div>
		</div>
	  </div>
	  </div>
	  
	  <div id="tab-2">
		<div class="p-2">
		<fieldset class="mt-4">
	<legend>Totais do Pedido</legend>
	  <input type="hidden" id="_token" value="{{ csrf_token() }}"> 
			<div class="rows">
					<div class="col-2">	
                         <label class="text-label d-block ">Total dos Produtos</label>
                         <input type="text" name="valor_venda"  value="{{($venda->valor_venda) ?? old('valor_venda')}}" disabled value="0" id="valor_venda" class="form-campo">
                     </div>                                   
                     
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Valor Frete</label>
                         <input type="text" name="valor_frete" id="valor_frete" value="{{($venda->valor_frete) ?? old('valor_frete')}}"  class="form-campo  mascara-float">
                     </div>
                   
                
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Desconto Venda R$ </label>
                         <input type="text" name="desconto_valor"  id="desconto_valor" value="{{($venda->desconto_valor) ?? old('desconto_valor')}}" class="form-campo mascara-float">
                     </div>
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Desconto Venda % </label>
                         <input type="text" name="desconto_per"  id="desconto_per" value="{{($venda->desconto_per) ?? old('desconto_per')}}"  class="form-campo mascara-float">
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
                         <input type="text" name="totalvenda" disabled  id="totalvenda" value="{{($venda->valor_liquido) ?? old('valor_liquido')}}" class="form-campo">
                     </div>
                     
                      <div class="col-2 mb-3 position-relative">       
                      	<label class="text-label d-block ">.</label>            
            			<button type="button" class="btn btn-azul" onclick="atualizarDadosPagamentos({{$venda->id}})"> Atualizar Valores</button>
            		</div>
            </div>
		</fieldset>
				
          <fieldset class="mt-3 mb-0"> 
			<div class="rows">
			<div class="col-12">		
             <fieldset class="p-2">
				<legend class="h5 mb-0 text-left">Dados de Pagamento </legend>
			 
            <div class="caixa px-2">
            <div class="rows">
            	<div class="col-4 mb-3" id="ver_combo_notar_refereciada">
                 	<label class="text-label">Forma de Pagamento</label>	
               	 	<select class="form-campo" id="tPag" >		
            			 @foreach(ConstanteService::tiposPagamento() as $chave=>$valor)
                			<option value="{{$chave}}" {{ ($notafiscal->tPag ?? null ) == $chave ? 'selected' : null }} >{{$chave}} - {{$valor}}</option>
                		 @endforeach
            		</select>	
                </div>
                <div class="col-3 mb-3" >
                 	<label class="text-label">Forma de Parcelar</label>	
               	 	<select class="form-campo" id="forma_de_parcelar" onchange="mudarTipoInput()">		
            			<option value="1">1 - Número de Parcelas</option>
                		<option value="2">2 - Condições especiais</option>
            		</select>	
                </div>
                
            	<div class="col-2 mb-3" >
                 	<label class="text-label">Parcelas</label>	
               	 	<input type="number"  class="form-campo " value="1" id="qtde_parcela">	
                </div>
              
                <div class="col-1 mt-1 pt-1">
                	<input type="hidden" id="venda_id" value="{{$venda->id}}">
                	<input type="button" onclick="inserirDuplicata()" value="Ok" class="btn btn-azul width-100" />                              
                </div> 
                
            </div>
            
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0" class="table table-bordered menor fatura" width="100%">
                    <thead>
						<tr>
                            <th align="center">Id</th>
                            <th align="center">Data</th>
                            <th align="center">Forma Pagto</th>
                            <th align="center">Valor</th>     
                            <th align="center">Observação</th>                       
                            <th align="center">Salvar</th>
                             <th align="center">Excluir</th>
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
                                <td align="center"><a href="javascript:;" onclick="alterarDuplicata({{$duplicata->id}})"   class="btn btn-outline-verde d-inline-block  btn-pequeno" title="Detalhes">Salvar </a></td>
                                
                                <td align='center' >
                                	<a href='javascript:;' onclick='excluirDuplicata({{$duplicata->id}})'  class='btn btn-sm btn-danger d-inline-block' title='Excluir'>
                                <i class='fas fa-trash'></i></a></td>
                            </tr>
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
 
    
  <div class="rows">	
  	<div class="col-12">
  	</div>		
  		
  		<div class="col-12 text-center pb-4">
  			<button type="button" class="btn btn-azul m-auto d-block" id="salvar-venda" href="#" onclick="abrirModalFinalizarVenda()"><i class="fas fa-check"></i> Finalizar Venda</button>                		
  		</div>
  </div>
    	
 </div>  
		
</div>



<!--cancelar venda -->
<div class="window pdv medio" id="telaImprimirCupom">	
	<div class="caixa mb-0 p-0">
	<span class="d-block text-center titulo pb-2 pt-2 h4 border-bottom mb-2 text-verde"><i class="fas fa-check"></i> Nfe Gerada Sucesso</span>
	<div class="p-2">
		<p class="h4 text-escuro text-center"><i class="fas fa-print"></i> Deseja imprimir o DANFE ?</p>							
	</div>
	<div class="tfooter center py-3">
		<a href="javascript:;" onclick="imprimirDanfePelaChave()" class="btn btn-verde"><i class="fas fa-check"></i> Sim</a>							
		<a href="javascript:;" onclick="fecharTela()" class="btn btn-vermelho ml-1"><i class="fas fa-times"></i> Não</a>							
	</div>	
</div>
</div>



<div class="window medio" id="modal_finalizar_venda">
	<div class="p-2 px-4">
			<span class="pt-4 d-block h3 border-bottom fw-700">Finalizar Venda</span>
		<div class="rows">
             <div class="col-12 mb-3">
                   <span class="text-label fw-700 h5 mb-1">Selecione as opções desejadas</span>
                    <div class="width-100 border radius-4">
                        <div class="check radio p-4 d-block">							
        					<label class="d-flex mb-1"><input type="checkbox"  id="lancar_estoque" name="lancar_estoque" checked value="S"> Lançar estoque</label>
        					<label class="d-flex mb-1"><input type="checkbox"  id="lancar_financeiro" name="lancar_financeiro" checked value="S" > Gerar Financeiro</label>
        					<label class="d-flex mb-1"><input type="checkbox"  id="lancar_nota" name="lancar_nota" value="S"> Gerar Nota Fiscal</label>
        				</div>
        				<div class="check radio p-4 d-block">
                        	<label class="text-label">Natureza de Operação</label>
                        	<select class="form-campo" id="natureza_operacao_id">
                        		@foreach($naturezas as $natureza)
                        			<option value="{{$natureza->id}}" {{$natureza->padrao==config('constantes.padrao_natureza.VENDA') ? 'selected' : ''}}>{{$natureza->descricao}}</option>
                        		@endforeach
                        	</select>                             
                        </div>
    				</div>
    				  
             </div>                                 
         </div>
		 <div class="tfooter border-0 between">
			<div class="d-flex">
				<a href="javascript:;" onClick="finalizarVenda({{$venda->id}})" class="btn btn-verde border-bottom" >Finalizar Venda</a>
		 </div>
			<a href="" class="btn btn-vermelho fechar">Fechar</a>
		 </div>
	</div>
</div>
<script>
	var TOTAL = "{{$venda->valor_venda}}";
	var TOTAL_VENDA = "{{$venda->valor_venda}}";
	
	function mudarTipoInput(){
		var tipo = $("#forma_de_parcelar").val();
		if(tipo=="1"){
			$("#qtde_parcela").val("1");
			$("#qtde_parcela").prop("type", "number")
		}else{
			$("#qtde_parcela").val("");
			$("#qtde_parcela").prop("type", "text")
		}
		
	}
</script>
  @include ("Admin.Cadastro.Produto.modal.modalListaGrade")
@endsection