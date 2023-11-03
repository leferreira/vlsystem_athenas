<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Venda</span>
	<div class="d-flex">
		<a href="{{route('admin.vendarecorrente.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>	
	</div>
</span>                      


			<div class="p-2 pb-0">
			<div class="rows">	
		
			
			<div class="col-12">
                <div class="caixa"> 
                    <fieldset class="pt-0 bg-padrao mb-0">
						 <div class="">							  
							<span class="titulo text-branco px-0">Dados do Contrato </span>
							<div class="mt-2 radius-4">
							 <div class="rows">								 	
                                        
							 		  	<div class="col-2 mb-3">
                							<label class="text-label text-branco">Data Início</label>	
                							<input type="date" name="data_inicio"  id="data_inicio" value="{{isset($venda->data_inicio) ? $venda->data_inicio : hoje() }}"  class="form-campo ">
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
                                                <select name="vendedor_id" id="vendedor_id" class="form-campo">							
                    								@foreach($vendedores as $v)
                    									<option value="{{$v->id}}" {{$venda->vendedor_id == $v->id ? "selected" : ""}}>{{$v->id}} - {{$v->nome}}</option>
                    								@endforeach
                    							</select>      
                                               <a href="{{route('admin.vendedor.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
                							</div>                               
                                        </div>
                                        <div class="col-3 mb-3">
                							<label class="text-label text-branco" >Modelo Contrato</label>						
                							<select name="modelo_contrato_id" id="modelo_contrato_id" class="form-campo">							
                								@foreach($modelos as $m)
                									<option value="{{$m->id}}" {{$venda->modelo_contrato_id == $m->id ? "selected" : ""}}>{{$m->nome}}</option>
                								@endforeach
                							</select>                					
                						</div>                						
                						
                						
                					
                    					<div class="col-2 mb-3">
                							<label class="text-label text-branco">Data Vencimento</label>	
                							<input type="date" name="data_fim" id="data_fim" readonly="readonly" value="{{isset($vendarecorrente->data_fim) ? $vendarecorrente->data_fim: hoje() }}"  class="form-campo ">
                						</div>                                   
                                                         
                                         
                                         <div class="col-2">	
                                             <label class="text-label d-block  text-branco">Total Bruto</label>
                                             <input type="text" name="valor_total" id="valor_frete" value="{{($venda->valor_total) ?? old('valor_total')}}"  class="form-campo  mascara-float">
                                         </div>
                                       
                                    
                                         
                                         <div class="col-2">	
                                             <label class="text-label d-block  text-branco">Total Desconto </label>
                                             <input type="text" name="total_desconto"  id="total_desconto" value="{{($venda->total_desconto) ?? old('total_desconto')}}" class="form-campo mascara-float">
                                         </div>
                                         
                                         <div class="col-2">	
                                             <label class="text-label d-block  text-branco">Total Contrato </label>
                                             <input type="text" name="valor_liquido"  id="valor_liquido" value="{{($venda->valor_liquido) ?? old('valor_liquido')}}"  class="form-campo mascara-float">
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
		<li><a href="#tab-2">Dados da Cobrança</a></li>
	  </ul>
	  <div id="tab-1">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">		

                <fieldset class="mt-3 mb-0">                 
				<legend>Serviços Contratados</legend>
                    <div class="pt-0">
						<div class="rows">	
    						<div class="col-6">
                                <label class="text-label d-block ">Serviço</label>
                                <div class="group-btn">	                                
                                    <select name="produto_recorrente_id" id="produto_recorrente_id" class="form-campo" onchange="selecionarProduto()">	
                                    	<option value="">Selecione um Produto</option>						
        								@foreach($produtos as $p)
        									<option value="{{$p->id}}">{{$p->id}} - {{$p->descricao}}</option>
        								@endforeach
        							</select>      
                                   
                                   		
    							</div>                               
                            </div>                       
                                                               
                         <div class="col-2">	
                            <label class="text-label d-block ">Valor de Venda</label>
                            <input type="text" name="valor"  value="0" id="valor" class="form-campo mascara-float">
                        </div>                        
                                                        
                        
                        <div class="col-2">	
                            <label class="text-label d-block ">Quantidade</label>
                            <input type="text" name="quantidade" id="quantidade" value="1" class="form-campo mascara-float">
                        </div> 
                        
                        <div class="col-2">	
                            <label class="text-label d-block ">Subtotal</label>
                            <input type="text" name="subtotal" readonly="readonly" value="0" id="subtotal" class="form-campo mascara-float">
                        </div>
                        
                        <div class="col-2 mb-3">
                             <label class="text-label">Desconto perc (%)</label>
                             <input type="text" name="desconto_percentual" id="desconto_percentual"  value="0"  class="form-campo mascara-float">
                        </div> 
                        
                        <div class="col-2 mb-3">
                             <label class="text-label">Desconto Valor (R$)</label>
                             <input type="text" name="desconto_por_valor" id="desconto_por_valor"  value="0"  class="form-campo mascara-float">
                        </div>                         
                        
                        <div class="col-2 mb-3">
                                 <label class="text-label">Total Desconto</label>
                                 <input type="text" readonly="readonly" id="total_desconto_item"   class="form-campo mascara-float">
                        </div>
                        
                        <div class="col-2 mb-3">
                                 <label class="text-label">Subtotal Líquido</label>
                                 <input type="text" readonly="readonly" id="subtotal_liquido"   class="form-campo mascara-float">
                        </div>
						   
                        <div class="col-2 mt-1">
                        	<input type="hidden" readonly="readonly" id="desconto_item"   class=" mascara-float">                        	
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
                            @foreach($venda->itens as $v)
                            	<tr>
                            		<td align="center">{{$v->id}}</td>
                            		<td align="center">{{$v->produto->descricao}}</td>
                            		<td align="center">{{$v->quantidade}}</td>
                            		<td align="center">{{formataNumeroBr($v->valor)}}</td>
                            		<td align="center">{{formataNumeroBr($v->subtotal)}}</td>
                            		<td align="center">{{formataNumeroBr($v->desconto_por_unidade)}}</td>
                            		<td align="center">{{formataNumeroBr($v->total_desconto_item)}}</td>
                            		<td align="center">{{formataNumeroBr($v->subtotal_liquido)}}</td>
                            	
                            		
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
				
          <fieldset class="mt-3 mb-0"> 
			<div class="rows">
			<div class="col-12">		
             <fieldset class="p-2">
				<legend class="h5 mb-0 text-left">Dados da Cobrança </legend>
			 <?php 
			     $descricao          = $venda->itens[0]->produto->descricao ?? "";
			 ?>
            <div class="caixa px-2">
            <form action="{{ route('admin.vendarecorrente.gerarCobranca')}}" id="frmCobranca" method="post">
    			@csrf
            	<div class="rows">
    					<div class="col-3 mb-3">
    						<label class="text-label">Descrição da Cobranca</label>
    						 <input type="text" name="descricao" required="required"  value="{{$descricao}}" id="descricao"  class="form-campo">												
    					</div>    														
                            
                         <div class="col-2 mb-3">
    						<label class="text-label">Tipo Recorrencia<span class="text-vermelho">*</span></label>						
    						<select name="tipo_cobranca_id" class="form-campo">							
    							@foreach($tipos as $t)
    								<option value="{{$t->id}}" {{$t->qtde_dias==30 ? 'selected' : ''}}>{{$t->tipo_cobranca}}</option>
    							@endforeach
    						</select>					
    					</div>
    					                                  
    					<div class="col-2 mb-3">
    							<label class="text-label">Primeiro Vencimento</label>	
    							<input type="date" name="primeiro_vencimento" required value="{{isset($venda->primeiro_vencimento) ? $venda->primeiro_vencimento : hoje() }}"  class="form-campo ">
    					</div>				
    									
    					
    					<div class="col-2 mb-3">
    							<label class="text-label">Valor Recorrente</label>	
    							<input type="text" name="valor_recorrente" value="{{$venda->valor_recorrente}}"  required   class="form-campo mascara-float">
    					</div>
    					
    					<div class="col-1 mb-3">
    							<label class="text-label">Qtde</label>	
    							<input type="number" name="qtde" required value="12"  class="form-campo mascara-float">							
    					</div>
                        
                     
    				    <div class="col-1 text-center">	
    				    	<label class="text-label">.</label>	
    				    	<input type="hidden" name="venda_recorrente_id" value="{{$venda->id}}"  class="form-campo mascara-float"> 
    				    	<input type="hidden" name="cliente_id" value="{{$venda->cliente_id}}" > 
                			<input type="submit" value="Gerar Cobrança" class="btn btn-azul btn-medio d-block m-auto" />                   
                		</div>	
    				</div>
            </form>
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0" class="table table-bordered menor fatura" width="100%">
                    <thead>
						<tr>
                            <th align="center">Id</th>
                            <th align="center">Data</th>
                            <th align="center">Valor</th>     
                            <th align="center">Observação</th>                       
                            <th align="center">Salvar</th>
                             <th align="center">Excluir</th>
                        </tr>
                    </thead>
                    <tbody id="lista_cobranca">
                  @foreach($cobrancas as $cobranca)
                            <tr>
                            	<td align="center">{{$cobranca->id}}</td>
                                <td align="center" width="10%"><input type="date" value="{{$cobranca->data_vencimento}}" id="vencimento_{{$cobranca->id}}" class="form-campo" onchange="alterarDuplicata({{$cobranca->id}})" ></td>
                               
                                <td align="center" width="15%"><input type="text" readonly="readonly" value="{{ $cobranca->valor }}" name="valor"  class="form-campo"></td>
                                <td align="center" width="35%"><input type="text"  id="obs_{{$cobranca->id}}" value="{{ $cobranca->obs }}" class="form-campo"></td>
                                <td align="center"><a href="javascript:;" onclick="alterarDuplicata({{$cobranca->id}})"   class="btn btn-outline-verde d-inline-block  btn-pequeno" title="Detalhes">Salvar </a></td>
                                
                                <td align='center' >
                                	<a href='javascript:;' onclick='excluirDuplicata({{$cobranca->id}})'  class='btn btn-sm btn-danger d-inline-block' title='Excluir'>
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