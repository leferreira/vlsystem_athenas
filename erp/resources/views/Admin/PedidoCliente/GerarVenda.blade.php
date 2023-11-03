<?php
    use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Nova Venda pelo Pedido: {{$pedido->id}}</span>
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
                                        <input type="hidden" value="{{json_encode($pedido)}}" id="venda_edit" >
                                        <input type="hidden" id="cliente_id" value="{{$pedido->cliente_id}}" >
                                        <input type="hidden" id="pedido_id" value="{{$pedido->id}}" >
							 		  	<div class="col-3">	
                                            <label class="text-label d-block text-branco">Data Pedido </label>
                                            <input type="date" name="data_venda" id="data_venda" value="{{$pedido->data_pedido}}" class="form-campo">
                                        </div>                                       
                                        
							  			<div class="col-6">	
                                            <label class="text-label d-block text-branco">Cliente</label>
                                            <input type="text"   value="{{$pedido->cliente->nome_razao_social}}" class="form-campo">
                                        </div>
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Total</label>
                                            <input type="text"   value="{{$pedido->total}}" class="form-campo">
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
		<li><a href="#tab-2">Transporte</a></li>
		<li><a href="#tab-3">Pagamento</a></li>
	  </ul>
	  <div id="tab-1">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">		

                <fieldset class="mt-3 mb-0">                 
				<legend>Itens da Compra</legend>
                    <div class="pt-0">
						<div class="rows">	
                                        <div class="col-4">	
                                            <label class="text-label d-block ">produto</label>
                                            <select  name="produto" id="produto_id" class="form-campo select2 produto">
                                            	<option value="--">Selecione o Produto</option>
												@foreach($produtos as $p)
													<option value="{{$p->id}}">{{$p->id}} - {{$p->nome}}</option>
												@endforeach
											</select>
                                        </div>
                                        
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Qtde</label>
                                            <input type="text" name="quantidade" id="quantidade" value="1" class="form-campo">
                                            <input type="hidden" id="desc_produto">
                                        </div>
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Val Unit</label>
                                            <input type="text" name="valor" disabled value="0" id="valor" class="form-campo">
                                        </div>
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block ">Subtotal</label>
                                            <input type="text" name="subtotal" disabled value="0" id="subtotal" class="form-campo">
                                        </div>
                                        
                                        <div class="col-2 mt-1">
                                        	<a style="margin-top: 11px;" id="addProd" class="btn btn-roxo text-uppercase">
														Adicionar
											</a>
                                        </div>                               
                        </div>
                    
                </div>
                
                <div class="tabela-responsiva pb-4 prod table border-top mt-4 border-left border-bottom border-right" style="background: #f3f3f3;">
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

                </fieldset>

			</div>
		</div>
	  </div>
	  </div>
	  
	   <div id="tab-2">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">
			
			<fieldset class="mt-3">
            <legend class="h5 mb-0 text-left">Transportadora</legend>
            <div class="rows px-2">
                <div class="col-10 mb-3">
                    <label class="text-label">Transportadora</label>	
                    <select class="form-campo" name="transportadora_id" id="transportadora_id">
            			<option value="" >Selecione Uma Opção</option>
            			@foreach($transportadoras as $t)
            				<option value="{{$t->id}}" >{{$t->razao_social}}</option>
            			@endforeach
            		</select>
            	</div>
            	
            </div>
            </fieldset>
            <fieldset class="mt-2">
            <legend class="h5 mb-0 text-left">Frete</legend>
        			<div class="rows p-2">
        			<div class="col-4 mb-3">
                        <label class="text-label">Tipo de Frete</label>	
                        <select class="form-campo" name="modfrete" id="modfrete">
                			<option value="0" >0 - Frete por conta do Remetente (CIF)</option>
                			<option value="1" >1 - Frete por conta do Destinatário (FOB)</option>
                			<option value="2" >2 - Frete por conta de Terceiros</option>
                			<option value="3" >3 - Transporte Próprio por conta do Remetente</option>
                			<option value="4" >4 - Transporte Próprio por conta do Destinatário</option>
                			<option value="9" >9 - Sem Ocorrência de Transporte</option>
                		</select>
                	</div>
            			<div class="col-3 mb-3">
                            <label class="text-label">Placa veículo</label>	
                            <input type="text" name="placa" id="placa"   class="form-campo">
        				</div>
        				<div class="col-3 mb-3">
                            <label class="text-label">UF veículo</label>
                            <select name="uf_placa" id="uf_placa"  class="form-campo">
                            	<option value="">selecione</option>                            	
                            	@foreach(ConstanteService::listaUf() as $chave=>$valor)
                            		<option value="{{$chave}}">{{$valor}}</option>
                            	@endforeach()
                            </select>	
                            
        				 </div> 
            				
            				<div class="col-2 mb-3">
                                <label class="text-label">Valor</label>	                   
                                <input type="text" name="valor_frete" id="valor_frete" value="<?php echo isset($notafiscal) ? $notafiscal->RNTC_reboque : NULL ?>"  class="form-campo">
            				</div>
        						
        			</div>
        	</fieldset>
        	<fieldset class="mt-2">
            <legend class="h5 mb-0 text-left">Volume</legend>
            			<div class="rows p-2">		
            				<div class="col-4 mb-3">
                                <label class="text-label">Especie</label>	                   
                                <input type="text" name="especie" id="especie"  class="form-campo">
            				</div>
            				<div class="col-4 mb-3">
                                <label class="text-label">Numeraçáo de Volume</label>	                   
                                <input type="text" name="numeracaoVol" id="numeracaoVol"  class="form-campo">
            				</div>
            				<div class="col-4 mb-3">
                                <label class="text-label">Qtde de Volume</label>	                   
                                <input type="text" name="qtdVol" id="qtdVol"  class="form-campo">
            				</div>
            				
            				<div class="col-4 mb-3">
                                <label class="text-label">Peso Líquido</label>	                   
                                <input type="text" name="pesoL" id="pesoL"  class="form-campo">
            				</div>
            				<div class="col-4 mb-3">
                                <label class="text-label">Peso Bruto</label>	                   
                                <input type="text" name="pesoB" id="pesoB"  class="form-campo">
            				</div>
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
                   <legend>Dados do Pagamento</legend>	
						<div class="rows">
							  <div class="col-4 d-flex">            
								<div class="border radius-4 p-2  width-100">
									<div class="rows">
										<div class="col-12 mb-3">
											<label class="text-label">Meio de Pagamento</label>
											<select class="form-campo" name="tPag" id="tPag" onChange="selecionarCartao()">	
												<option value="">Selecione uma Opção</option>                													
												@foreach(ConstanteService::tiposPagamento() as $chave=>$valor)
													 <option value='{{ $chave}}'>{{$chave . " - ". $valor }}</option>
												@endforeach		
											</select>
										</div>
					
							  			<div class="col-12 mb-3">	
                                            <label class="text-label d-block">Forma de pagamento</label>
                                            <select id="formaPagamento" name="formaPagamento" class="form-campo">
												<option value="--">Selecione a forma de pagamento</option>
												<option value="a_vista">A vista</option>
												<option value="30_dias">30 Dias</option>
												<option value="personalizado">Personalizado</option>
											</select>
                                        </div>                                       
                                        
                                        <div class="col-6 mb-3">	
                                            <label class="text-label d-block">Valor da parcela</label>
                                            <input type="text" name="valor_parcela" value="0" id="valor_parcela" class="form-campo">
                                        </div>
                                        
                                        <div class="col-6 mb-3">	
                                            <label class="text-label d-block ">Qtd parcelas</label>
                                            <input type="text" name="qtdParcelas" id="qtdParcelas" value="1" class="form-campo">
                                        </div>
                                        <div class="col-12  mb-3 validated">	
                                            <label class="text-label d-block ">Primeiro Vencimento</label>
                                            <input type="date" name="primeiro_vencimento" value="0" id="primeiro_vencimento" class="form-campo data-input">
                                        </div>
										<div class="col-12 text-center">
											<button type="submit" class="btn btn-azul m-auto"><i class="fas fa-check"></i> Adicionar pagamento </button>
											<!--<input type="submit" class="btn btn-azul m-auto" value="Adicionar pagamento">-->
											<!--<a href="" class="btn btn-azul m-auto"><i class="fas fa-check"></i> Adicionar pagamento</a>-->
										</div>  
                                        
									</div>
                                </div>
                                </div>
								
								<div class="col-8 d-flex">
									<div class="tabela-responsiva scroll border radius-4 p-0 width-100">
									<table cellpadding="0" cellspacing="0" class="table table-bordered menor" width="100%">
											<thead>
												<tr>
													<th align="center">Id</th>
													<th align="center">Parcela</th>
													<th align="center">Data</th>
													<th align="center">Valor</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td align="center">Id</td>
													<td align="center">Parcela</td>
													<td align="center">Data</td>
													<td align="center">Valor</td>
												</tr>					 
											</tbody>
								   </table>
												
									</div>
							   </div>
                           </div>
                  
                </fieldset>
                </div>
			</div>
		
	
	<fieldset class="mt-4">
	<legend>Totais do Pedido</legend>
	  <input type="hidden" id="_token" value="{{ csrf_token() }}"> 
			<div class="rows">
					<div class="col-2">	
                         <label class="text-label d-block ">Total dos Produtos</label>
                         <input type="text" name="valor_total" disabled value="0" id="valor_total" class="form-campo">
                     </div>                                   
                     
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Valor Frete</label>
                         <input type="text" name="frete" id="frete" readonly="readonly" class="form-campo">
                     </div>
                   
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Desconto R$ </label>
                         <input type="text" name="desconto_valor"  id="desconto_valor" class="form-campo">
                     </div>
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Desconto % </label>
                         <input type="text" name="desconto_per"  id="desconto_per" class="form-campo">
                     </div>
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Total da Venda</label>
                         <input type="text" name="totalvenda" disabled value="0" id="totalvenda" class="form-campo">
                     </div>
            </div>
		</fieldset>
		
	
	<fieldset class="mt-4">
	<legend>Finalizar</legend>	   
				<div class="rows">	
					<div class="col-12">
					</div>
             			<div class="col-12 mb-3">
								<label class="text-label">Observação Externa</label>	
								<input type="text" name="observacao" value="" id="observacao" class="form-campo">
						</div>		
						
						<div class="col-12 mb-3">
								<label class="text-label">Observação Interna</label>	
								<input type="text" name="observacao_interna" value="" id="observacao_interna" class="form-campo">
						</div>
						<div class="col-12 text-center pb-4">
                			<button type="button" class="btn btn-azul m-auto d-block" id="salvar-venda" href="#" onclick="salvarVenda()"><i class="fas fa-check"></i> Finalizar</button>                		
                		</div>
				</div>
	</fieldset>
    </div>  
 </div>
 </div>  
		
</div>

	<div class="window form" id="pagamento_cartao">
		<div class="caixa mb-0 p-0">
		<span class="d-block titulo mb-0"><i class="fas fa-plus"></i> Informe os dados do cartão</span>	
		<div class="border radius-4">
			<div class="rows p-4">  		
				<div class="col-4 mb-3">
					<label class="text-label">Bandeira</label>	                   
					<select class="form-campo" name="bandeira_cartao" id="bandeira_cartao" >	
    					<option value=''>Selecionar bandeira</option>
    					@foreach(ConstanteService::bandeiras() as $ch=>$v)
    					     <option value='{{ $ch}}'>{{$ch . " - ". $v }}</option>
    					@endforeach	                							
					</select>
				</div>    		
				<div class="col-4 mb-3">
					<label class="text-label">Cód. autorização(Opcional)</label>	                   
					<input type="text" name="cAut_cartao" id="cAut_cartao"  placeholder="Digite aqui..." class="form-campo">
				</div>   	
				<div class="col-4 mb-3">
					<label class="text-label">CNPJ (Opcional)</label>	                   
					<input type="text" name="cnpj_cartao" id="cnpj_cartao"  placeholder="Digite aqui..." class="form-campo">
				</div>   
			</div>   
			<div class="tfooter end">
				<button class="btn btn-vermelho fechar">Fechar</button>					
			</div>
		</div>
		</div>
	</div>
<?php ?>
@endsection