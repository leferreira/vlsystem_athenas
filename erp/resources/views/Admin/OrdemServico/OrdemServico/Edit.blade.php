<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Ordem de Serviço</span>
	<div class="d-flex">
		<a href="{{route('admin.ordemservico.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	
	</div>
</span>
<div class="p-2 pb-0">
			<div class="rows">
			
			<div class="col-12">
                <div class="caixa">                       
			<fieldset>
				<legend>Informações Financeira</legend>
				
				<div class="rows">
				 
					<div class="col-2 mb-3" >
							<label class="text-label">Total Produto</label>	
							<input type="text"  id="valor_total_produto" value="{{$ordemservico->valor_total_produto ?? null }}" class="form-campo">
					</div>
					
					<div class="col-2 mb-3" >
							<label class="text-label">Total Serviço</label>	
							<input type="text"  id="valor_total_servico" value="{{$ordemservico->valor_total_servico ?? null }}" class="form-campo">
					</div>
				
					<div class="col-2 mb-3" >
							<label class="text-label">Produto + Serviços</label>	
							@php $total = $ordemservico->valor_total_produto + $ordemservico->valor_total_servico; @endphp
							<input type="text" readonly="readonly" value="{{ $total }}" class="form-campo">
					</div>
					
					<div class="col-2 mb-3" >
							<label class="text-label">Valor Desconto</label>	
							<input type="text"  id="valor_desconto" value="{{$ordemservico->valor_desconto ?? null}}" class="form-campo mascara-float">
					</div>
					
					<div class="col-2 mb-3" >
							<label class="text-label">Valor Líquido</label>	
							<input type="text"  id="valor_liquido" value="{{$ordemservico->valor_liquido ?? null }}" class="form-campo mascara-float">
					</div>
					
					
					
				</div>
			</fieldset>
		</div>
	</div>
	</div>
	</div>
		
			
			
   <div id="tab">
	  <ul>
		<li><a href="#tab-1">Detalhes</a></li>
		<li><a href="#tab-2">Produtos</a></li>
		<li><a href="#tab-3">Serviços</a></li>
		<li><a href="#tab-4">Anotaçoes</a></li>
	  </ul>
	   <div id="tab-1">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">		
				<form action="{{route('admin.ordemservico.update', $ordemservico->id)}}" method="POST" name="frmOrdemServico" >
           <input name="_method" type="hidden" value="PUT"/>
           @csrf  
                <fieldset class="mt-3 mb-0">                 
				<legend>Detalhes da OS</legend>
                    <div class="pt-0">
						<div class="rows">	
						<div class="col-2 mb-3">
							<label class="text-label">Data Fabricação</label>	
							<input type="date" name="data_abertura"  value="{{isset($ordemservico->data_abertura) ? $ordemservico->data_abertura : hoje() }}"  class="form-campo ">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label">Previsão de Entrega</label>	
							<input type="date" name="previsao_entrega"  value="{{isset($ordemservico->previsao_entrega) ? $ordemservico->previsao_entrega : old('previsao_entrega') }}"  class="form-campo ">
					</div>
					
					<div class="col-4">
                        <label class="text-label ">Cliente<span class="text-vermelho">*</span></label>
                        <div class="group-btn">	                                
                            <input type="text"  id="desc_cliente" value="{{$cliente->nome_razao_social ?? null}}" class="form-campo">
                            <input type="hidden" name="cliente_id" value="{{$cliente->id ?? null}}"  id="cliente_id" >       
                           <a href="{{route('admin.cliente.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
						</div>                               
                    </div>
                    
                    <div class="col-4 mb-3">
							<label class="text-label"  >Equipamento<span class="text-vermelho">*</span></label>	
							<div class="group-btn">	 
							<select name="equipamento_id" id="equipamento_id" class="form-campo">
								<option value="">Selecione</option>
								@foreach($equipamentos as $e)
									<option value="{{$e->id}}" {{$e->id==$ordemservico->equipamento_id ? 'selected' : ''}}>{{$e->equipamento}}</option>
								@endforeach
							</select>
							<a href="javascript:;" onclick="abrirEquipamento()" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Equipamento"></a>
						</div>
					</div>
					
					<div class="col-4 mb-3">
							<label class="text-label"  >Vendedor<span class="text-vermelho">*</span></label>	
							<div class="group-btn">	 
							<select name="vendedor_id" id="vendedor_id" class="form-campo">
								<option value="">Selecione</option>
								@foreach($vendedores as $v)
									<option value="{{$v->id}}" {{$v->id==$ordemservico->vendedor_id ? 'selected' : ''}}>{{$v->nome}}</option>
								@endforeach
							</select>
							<a href="{{route('admin.vendedor.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Vendedor"></a>
						</div>
					</div>
					
																	
					<div class="col-4 mb-3">
							<label class="text-label"  >Técnico/Responsável<span class="text-vermelho">*</span></label>	
							<div class="group-btn">	
							<select name="tecnico_id"  id="tecnico_id"class="form-campo">
								<option value="">Selecione</option>
								@foreach($tecnicos as $t)
									<option value="{{$t->id}}" {{$t->id==$ordemservico->tecnico_id ? 'selected' : ''}}>{{$t->nome}}</option>
								@endforeach
							</select>
							<a href="{{route('admin.tecnico.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Técnico"></a>
						</div>
					</div>                                    
					<div class="col-2 mb-3" >
							<label class="text-label">Garantia (dias)</label>	
							<input type="number" name="garantia" id="garantia" value="{{isset($ordemservico->garantia) ? $ordemservico->garantia : old('garantia') }}" class="form-campo">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label"  >Termo Garantia<span class="text-vermelho">*</span></label>	
							<div class="group-btn">	
							<select name="garantia_id" class="form-campo">
								<option value="">Selecione</option>
								@foreach($termos as $t)
									<option value="{{$t->id}}" {{$t->id==$ordemservico->garantia_id ? 'selected' : ''}}>{{$t->referencia_garantia}}</option>
								@endforeach
							</select>
							<a href="{{route('admin.termogarantia.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Técnico"></a>
						</div>
					</div>
                            
						 <div class="col-6 mb-3" >
							<label class="text-label">Descrição Produto/Serviço</label>	
							<textarea rows="15" cols="5" name="descricao_produto" class="form-campo">{{isset($ordemservico->descricao_produto) ? $ordemservico->descricao_produto : old('descricao_produto') }}</textarea>
    					</div>
    					
    					<div class="col-6 mb-3" >
    							<label class="text-label">Devolução</label>	
    							<textarea rows="15" cols="5" name="defeito" class="form-campo">{{isset($ordemservico->defeito) ? $ordemservico->defeito : old('defeito') }}</textarea>
    					</div>
    					
    					<div class="col-6 mb-3" >
    							<label class="text-label">Observações</label>	
    							<textarea rows="15" cols="5" name="observacoes" class="form-campo">{{isset($ordemservico->observacoes) ? $ordemservico->observacoes : old('observacoes') }}</textarea>
    					</div>
    					
    					<div class="col-6 mb-3" >
    							<label class="text-label">Laudo Técnico</label>	
    							<textarea rows="15" cols="5" name="laudo_tecnico" class="form-campo">{{isset($ordemservico->laudo_tecnico) ? $ordemservico->laudo_tecnico: old('laudo_tecnico') }}</textarea>
    					</div>                           
                     </div>
                    
                </div>
                
              <div class="rows">	
    					<div class="col-12">
    					</div>		
    						
    						<div class="col-12 text-center pb-4">
                    			<input type="submit" class="btn btn-azul m-auto d-block" value="Salvar Alterações Venda">                		
                    		</div>
    				</div>

                </fieldset>
</form>

            	
	
			</div>
		</div>
	  </div>
	  </div>
	  

  <div id="tab-2">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">		

                <fieldset class="mt-3 mb-0">                 
				<legend>Produtos da OS</legend>
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
                                 <select  class="form-campo" id="tipo_desc" name="tipo_desc" onchange="calcularDescontoItem()">
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
                            <input type="text" name="subtotal" readonly  value="0" id="subtotal" class="form-campo mascara-float">
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
                            @foreach($produtos as $v)
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
                                            <form action="{{route('admin.produtoos.destroy', $v->id)}}" method="POST" id="apagar{{$v->id}}">
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
	  
	
	  <div id="tab-3">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">		

                <fieldset class="mt-3 mb-0">                 
				<legend>Serviços da OS</legend>
                    <div class="pt-0">
						<div class="rows">	
						
                            <div class="col-6">
                                <label class="text-label d-block ">Serviço</label>
                                <div class="group-btn">	                                
                              		<input type="text" name="desc_servico" id="desc_servico" class="form-campo">
                                	<input type="hidden" name="servico_id"   id="servico_id" >
    								<a href="javascript:;" onclick="abrirModal('#modalCadServico')" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Serviço"></a>
                				</div>                               
                            </div>
                                                   
                                                               
                         <div class="col-2">	
                            <label class="text-label d-block ">Valor de Venda</label>
                            <input type="text" name="valor_servico"  value="0" id="valor_servico" class="form-campo mascara-float">
                        </div>
                        
                                                        
                        
                        <div class="col-2">	
                            <label class="text-label d-block ">Quantidade</label>
                            <input type="text" name="quantidade_servico" id="quantidade_servico" value="1" class="form-campo mascara-float">
                            <input type="hidden" id="desc_servico_selecionado">
                        </div> 
                        <div class="col-2 mb-3">
                                 <label class="text-label">Tipo Desconto</label>
                                 <select  class="form-campo" id="tipo_desc_servico" name="tipo_desc_servico" onchange="calcularDescontoItemServico()">
                                 	<option value="desc_perc_servico">Percento (%)</option>
                                 	<option value="desc_valor_servico">Valor (R$)</option>
                                 </select>
                        </div> 
                        
                        <div class="col-2 mb-3">
                                 <label class="text-label">Desconto (R$)</label>
                                 <input type="text" name="val_desconto_servico" id="val_desconto_servico"  value="0"  class="form-campo mascara-float">
                        </div> 
                        
                        <div class="col-2">	
                            <label class="text-label d-block ">Subtotal</label>
                            <input type="text" name="subtotal_servico" readonly value="0" id="subtotal_servico" class="form-campo mascara-float">
                        </div>
                        <div class="col-2 mb-3">
                                 <label class="text-label">Total Desconto</label>
                                 <input type="text" readonly="readonly" id="desconto_servico"   class="form-campo mascara-float">
                        </div>
                        
                        <div class="col-2 mb-3">
                                 <label class="text-label">Total Geral</label>
                                 <input type="text" readonly="readonly" id="total_item_servico"   class="form-campo mascara-float">
                        </div>
						   
                        <div class="col-2 mt-1">
                        <input type="hidden" readonly="readonly" id="desconto_item_servico"   class=" mascara-float">
                        	<a style="margin-top: 11px;" id="addServico" class="btn btn-roxo text-uppercase">
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
                            @foreach($servicos as $v)
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
                                        <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar2{{$v->id}}').submit() : '';" title="Excluir">Excluir</a>
                                            <form action="{{route('admin.servicoos.destroy', $v->id)}}" method="POST" id="apagar2{{$v->id}}">
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
	    

	  
	   <div id="tab-4">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">		
		
                <fieldset class="mt-3 mb-0"> 
               @if(isset($anotacao))    
                   <form action="{{route('admin.anotacaoos.update', $subcategoria->id)}}" method="POST" name="frmAnotacao" >
                   <input name="_method" type="hidden" value="PUT"/>
                 @else                       
                	<form action="{{route('admin.anotacaoos.store')}}" method="Post" >
                @endif
                	@csrf                
				<legend>Anotação da OS</legend>
                    <div class="pt-0">
						<div class="rows">					
                                                        
                         <div class="col-9">	
                            <label class="text-label d-block ">Descrição</label>
                            <input type="text" name="anotacao"   class="form-campo ">
                        </div>
                        
						   
                        <div class="col-2 mt-1">
                       	<input type="hidden" id="os_id" name="os_id" value="{{$ordemservico->id ?? null}}" class="form-campo ">
                        	<input type="submit" class="btn btn-roxo text-uppercase" value="Inserir">
                        	
                        </div>                            
                     </div>
                    
                </div>
         </form>       
                <div class="tabela-responsiva pb-4 prod table border-top mt-4 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" id="" width="100%">
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th align="center">Data</th>
                                    <th align="center">Anotação</th>
                                    <th align="center">Excluir</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($anotacoes as $a)
                            	<tr>
                            		<td align="center">{{$a->id}}</td>
                            		<td align="center" >{{databr($a->data)}}</td>
                            		<td align="center">{{$a->anotacao}}</td>
                            		<td align="center">
                                        <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar3{{$a->id}}').submit() : '';" title="Excluir">Excluir</a>
                                            <form action="{{route('admin.anotacaoos.destroy', $a->id)}}" method="POST" id="apagar3{{$a->id}}">
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




<script>
	var TOTAL = "{{$ordemservico->valor_total}}";
	var TOTAL_VENDA = "{{$ordemservico->valor_venda}}";
	
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
  @include ("Admin.Cadastro.Produto.modal.modalCadastroProduto")
  @include ("Admin.Cadastro.Cliente.modal.modalCadastroCliente")
  @include ("Admin.Cadastro.Transportadora.modal.modalCadastroTransportadora")
  @include ("Admin.Cadastro.Categoria.modal.modalCategoria")
  @include ("Admin.Cadastro.SubCategoria.modal.modalSubCategoria")
  @include ("Admin.Cadastro.SubSubCategoria.modal.modalSubSubCategoria")
  @include ("Admin.Cadastro.Servico.modal.modalCadastroServico")
@endsection