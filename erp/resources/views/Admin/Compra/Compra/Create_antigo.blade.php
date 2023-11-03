<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase  text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Cadastrar compra</span>
	<div class="d-flex">
		<a href="{{route('admin.compra.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	</div>
</span>                      

		<input type="hidden" value="{{($compra->id) ?? null}}" id="compra_id" >
		
			@if(isset($compra))
				<input type="hidden" id="produtos" value="{{json_encode($produtos)}}" >
				<input type="hidden" value="{{json_encode($compra)}}" id="compra_edit" >
						
			@endif
			@php
				$id_fornecedor	= ($compra->fornecedor_id) ?? null;
				$id_transportadora	= ($compra->transportadora_id ) ?? null;
			@endphp
			
   <div id="tab">
	  <ul>
		<li><a href="#tab-1">Itens</a></li>
		<li><a href="#tab-2">Pagamento</a></li>
	  </ul>
	  <div id="tab-1">
		<div class="p-2">
			<div class="rows">	
			
			<div class="col-12">
                <div class="caixa"> 
                    <div class="pt-0">
						 <div class=" mt-2">							  
							<fieldset>
							<legend>Dados da compra</legend>
							 <div class="rows">
							 			<div class="col-2 mb-3">	
                                            <label class="text-label d-block ">Data Entrada</label>
                                            <input type="date" name="data_entrada" id="data_entrada" value="{{hoje()}}" class="form-campo">
                                        </div>
                                        
							  			<div class="col-4 mb-3">	
                                            <label class="text-label d-block">Fornecedor</label>
                                            <select id="fornecedor_id" name="fornecedor" class="form-campo fornecedor">
												<option value="--">Selecione o fornecedor</option>
												@foreach($fornecedores as $f)
												<option value="{{$f->id}}" {{($f->id==$id_fornecedor) ? 'selected' : ''}}>{{$f->razao_social}} ({{$f->cnpj}})</option>
												@endforeach
											</select>
                                        </div>
                                        
                                        <div class="col-4 mb-3">	
                                            <label class="text-label d-block">Transportadora</label>
                                            <select id="transportadora_id" name="transportadora" class="form-campo ">
												<option value="--">Selecione a Transportadora </option>
												@foreach($transportadoras as $t)
												<option value="{{$t->id}}" {{($t->id==$id_transportadora) ? 'selected' : ''}}>{{$t->razao_social}} ({{$t->cnpj}})</option>
												@endforeach
											</select>
                                        </div>
                                        
                                    
										<div class="col-2 mb-3">	
                                            <label class="text-label d-block ">Num NFE</label>
                                            <input type="text" name="num_nfe" id="num_nfe"  id="nf" value="{{$compra->nf ?? old('num_nfe')}}" class="form-campo">
                                        </div>			
                                   <!--       <div class="col-4 mb-3">	
                                            <label class="text-label d-block">Centro de Custo</label>
                                            <select id="centro_custo_id" name="centro_custo" class="form-campo ">
												<option value="--">Selecione um Valor</option>
												@foreach($centro_custos as $c)
												<option value="{{$c->id}}">{{$c->nome}} </option>
												@endforeach
											</select>
                                        </div>                           
                               -->
                                </div>
                            </fieldset>  
							
                            <fieldset class="mt-4 p-2">
							<legend>Itens da Compra</legend>
							 <div class="rows">	
							  			<div class="col-4">	
                                            <label class="text-label d-block ">produto</label>
                                            <input type="text" name="desc_produto" id="desc_produto" class="form-campo">
                                            <input type="hidden" name="produto_id"   id="produto_id" >                                      
                                        </div>                                      
                                       
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Qtde</label>
                                            <input type="text" name="quantidade" id="quantidade" value="1" class="form-campo mascara-float">
                                            <input type="hidden" id="desc_produto">
                                        </div>
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Val Unit</label>
                                            <input type="text" name="valor"  value="0" id="valor" class="form-campo mascara-float">
                                        </div>
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Subtotal</label>
                                            <input type="text" name="subtotal" disabled value="0" id="subtotal" class="form-campo  ">
                                        </div>
                                        
                                        <div class="col-2 mt-1">
                                        	<a style="margin-top: 11px;" id="addProd" class="btn btn-roxo text-uppercase ">
														Adicionar
											</a>
                                        </div>
										
									<div class="col-12">
										<div class="tabela-responsiva pb-4  table border-top mt-4 border-left border-bottom border-right prod" style="background: #f3f3f3;">
											<table cellpadding="0" cellspacing="0" id="" width="100%">
												<thead>
												 <tr>
														<th align="center">#</th>
														<th align="center">Código</th>
														<th align="center">Nome</th>
														<th align="center">Quantidade</th>
														<th align="center">Valor Unit</th>
														<th align="center">Subtotal</th>
														<th align="center">Ação</th>
													</tr>
												</thead>
												<tbody class="datatable-body"></tbody>
											</table>								
										</div>

											<!--<ul class="d-flex text-end mb-3 mt-3">
												<li><a href="#tab-2">Pagamento <i class="fas fa-arrow-right"></i></a></li>
											</ul>-->										
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
	  
	  
	  <div id="tab-2">
		<div class="p-2">
			<div class="rows">
			
				<div class="col-12">
                <div class="caixa">                    
                            <fieldset class="mt-3 p-2">
							<legend>Total dos Produtos</legend>
							  <div class="rows">
							  			<div class="col-2">	
                                            <label class="text-label d-block ">Total dos Produtos</label>
                                            <input type="text" name="valor_total" disabled  id="valor_total" value="{{$compra->valor_total ?? old('valor_total')}}" class="form-campo mascara-dinheiro">
                                        </div>                                   
                                        
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Valor Frete</label>
                                            <input type="text" name="frete" id="frete" value="{{$compra->valor_frete ?? old('valor_frete')}}"  class="form-campo mascara-dinheiro">
                                        </div>
                                    
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Desconto R$ </label>
                                            <input type="text" name="desconto_valor"  id="desconto_valor" value="{{$compra->valor_desconto ?? old('valor_desconto')}}" class="form-campo mascara-dinheiro">
                                        </div>
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Desconto % </label>
                                            <input type="text" name="desconto_per"  id="desconto_per" class="form-campo">
                                        </div>
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Total da Compra</label>
                                            <input type="text" name="totalcompra" disabled value="0" id="totalcompra" value="{{$compra->valor_compra ?? old('valor_compra')}}" class="form-campo mascara-dinheiro">
                                        </div>
                                </div>
                        </fieldset>
                  
                </div>
                </div>  
				
			<div class="col-12">
                <div class="caixa">                    
                    <fieldset class="mt-3 mb-0"> 
			<div class="rows">
			<div class="col-6 d-flex">            
			 <fieldset class="border radius-4 p-1">
                   <legend class="">Dados do Pagamento</legend>
				<div class="rows">
                  <div class="col-12 mb-3">
                		<label class="text-label">Meio de Pagamento</label>
                		<select class="form-campo" name="tPag" id="tPag" >	
                			<option value="">Selecione uma Opção</option>                													
                			@foreach(ConstanteService::tiposPagamento() as $chave=>$valor)
                			     <option value='{{ $chave}}'>{{$chave . " - ". $valor }}</option>
                			@endforeach		
                		</select>
                	</div>				
						<div class="col-6 mb-3">	
                            <label class="text-label d-block">Forma de pagamento</label>
                            <select id="formaPagamento" name="formaPagamento" class="form-campo">
								<option value="--">Selecione a forma pagto</option>
								<option value="a_vista">A vista</option>
								<option value="personalizado">Parcelado</option>
							</select>
                        </div> 
                        <div class="col-6 mb-3">	
                            <label class="text-label d-block">Qt. Parcelas</label>
                            <select id="qtde_parcela"  class="form-campo">
                            <option value="">Selecione</option>
                            @for($i=1; $i<=12; $i++)
								<option value="{{$i}}">{{zeroEsquerda($i,2)}}</option>
							@endfor
							</select>
                        </div>                                       
                        
                         <div class="col-6 mb-3 validated">	
                            <label class="text-label d-block ">Vencimento</label>
                            <input type="date" name="primeiro_vencimento" id="primeiro_vencimento" class="form-campo">
                        </div>
                       
                        <div class="col-6 mb-3">	
                            <label class="text-label d-block">Valor da parcela</label>
                            <input type="text" name="valor_parcela" id="valor_parcela" class="form-campo mascara-dinheiro">
                        </div>                      
                        
                        
                          <div class="col-12 text-center d-flex justify-content-space-between">
							<button type="button" class="btn btn-roxo" id="add-pag-manual"> Individual </button>
						
							<button type="button" class="btn btn-azul" id="add-pag-automatico"> Gerar Parcelas </button>
						</div>                             
					</div>
                </fieldset>                 
                
               </div>
               
			   <div class="col-6">
				<fieldset class="p-1 border radius-4 ">
				<legend class="">Parcelas</legend>
				<div class="tabela-responsiva scroll p-0 width-100" style="border-radius:5px 5px 0 0 !important;">
                    <table cellpadding="0" cellspacing="0" class="table table-bordered menor fatura" width="100%">
                            <thead>
								<tr>
                                    <th align="center">Id</th>
                                    <th align="center">Data</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Excluir</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body"></tbody>
                   </table>
				   </div>
                  <div class="width-100 tabela-responsiva border radius-4 bg-body" style="border-radius: 0 0 5px 5px!important;">  
				      <table cellpadding="0" cellspacing="0" class="table">
							<tr>
								<td class="border-0">
									<strong>Total da Venda: <b class="text-azul h5 d-inline-block mb-0"><i id="total_da_compra"></i></b></strong> 
								</td>
								<td class="border-0">
									<strong>Total das Parcelas: <b class="h5 d-inline-block mb-0" style="color:#18bf91"><i id="soma_parcelas"></i></b></strong> 
								</td>
								<td class="border-0">
									<strong >Restante: <b class="text-vermelho h5 d-inline-block mb-0"><i id="restante_parcelas">00</i> </b></strong>
								</td>
							</tr>
                      </table> 
                   </div>    
                 </fieldset>
                   </div>  
			   </div>
			   
			</div>
		</fieldset>
				</div>  
              </div> 
		
             
            <div class="col-12">
          
             <fieldset class="mt-3 p-2">	
				<legend>Observações</legend>
				<div class="rows">	
             			<div class="col-12 mb-3">
								<label class="text-label">Observação Externa</label>	
								<input type="text" name="observacao" value="{{$compra->observacao ?? old('observacao')}}" id="observacao" class="form-campo">
						</div>		
						
						<div class="col-12 mb-3">
								<label class="text-label">Observação Interna</label>	
								<input type="text" name="observacao_interna" value="{{$compra->observacao_interna ?? old('observacao_interna')}}" id="observacao_interna" class="form-campo">
						</div>
						<div class="col-2 text-center pb-4 m-auto">							
                			<button type="button"  id="salvar-compra" class="btn btn-azul m-auto" href="#" onclick="abrirModal('#modal_salvar_compra')"><i class="fas fa-check"></i> Finalizar</button>
                		</div>
				</div>
				</fieldset>
			</div>

			</div>
		</div>
	
	</div>  
	  <input type="hidden" id="_token" value="{{ csrf_token() }}"> 
	 
      
 </div>
		
<div class="window medio" id="modal_salvar_compra">
	<div class="p-2 px-4">
			<span class="pt-4 d-block h3 border-bottom fw-700">Salvar Compra</span>
		<div class="rows">
             <div class="col-12 mb-3">
                     <span class="text-label fw-700 h5 mb-1">Selecione as opções desejadas</span>
                    <div class="width-100 border radius-4">
                        <div class="check radio p-4 d-block">							
        					<label class="d-flex mb-1"><input type="checkbox" id="lancar_estoque"> Lançar estoque</label>
        				</div>
    				</div>
             </div>                                 
         </div>
		 <div class="tfooter border-0 between">
			<div class="d-flex">
				<a href="javascript:;" onClick="salvarCompra()" class="btn btn-verde border-bottom" >Salvar Compra</a>
		 </div>
			<a href="" class="btn btn-vermelho fechar">Fechar</a>
		 </div>
	</div>
</div>
	
@endsection