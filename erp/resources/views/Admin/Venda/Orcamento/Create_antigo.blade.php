<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Orçamentos</span>
	<div class="d-flex">
		<a href="{{route('admin.orcamento.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	
	</div>
</span>                      


			<div class="p-2 pb-0">
			<div class="rows">	
			<input type="hidden" value="{{($orcamento->id) ?? null}}" id="orcamento_id" >
			<input type="hidden" id="produtos" value="{{json_encode($produtos)}}" >
			@if(isset($orcamento))				
				<input type="hidden" value="{{json_encode($orcamento)}}" id="orcamento_edit" >						
			@endif
			
			<?php 
			     
    			$tPag               = null;
    			$forma_pagto        = null;
    			$id_cliente         = null;
			
    			if(isset($orcamento)){
    			    $id_cliente 		= ($orcamento->cliente_id) ?? null;
    			    $tPag 				= ($orcamento->tPag) ?? null;
    				$forma_pagto		= ($orcamento->forma_pagamento) ?? null;
    			}
				
			?>		
			
			<div class="col-12">
                <div class="caixa"> 
                    <fieldset class="pt-0 bg-padrao mb-0">
						 <div class="">							  
							<span class="titulo text-branco px-0">Dados do Orçamento </span>
							<div class="mt-2 radius-4">
							 <div class="rows">								 	
                                        
							 		  	<div class="col-3">	
                                            <label class="text-label d-block text-branco">Data Orçamento</label>
                                            <input type="date" name="data_orcamento" id="data_orcamento" value="{{$orcamento->data_orcamento ?? hoje()}}" class="form-campo ">
                                        </div>                                       
                                        <div class="col-8">
                                            <label class="text-label d-block text-branco">Cliente</label>
                                            <div class="group-btn">	                                
                                                <input type="text" name="desc_cliente" id="desc_cliente" value="{{$cliente->nome_razao_social ?? null}}" class="form-campo">
                                                <input type="hidden" name="cliente_id" value="{{$cliente->id ?? null}}"  id="cliente_id" >       
                                               <a href="javascript:;" onclick="abrirModal('#modalCadCliente')" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
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
				<legend>Itens do Orçamento</legend>
                    <div class="pt-0">
						<div class="rows">	
						
                            <div class="col-6">
                                <label class="text-label d-block ">produto</label>
                                <div class="group-btn">	                                
                                    <input type="text" name="desc_produto" id="desc_produto" class="form-campo">
                                    <input type="hidden" name="produto_id"   id="produto_id" >       
                                   <a href="javascript:;" onclick="abrirModal('#modalCadProduto')" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
    							</div>                               
                            </div>
                            
                          <div class="col-2">	
                            <label class="text-label d-block ">Unidade</label>
                            <select id="unidade_orcamento" class="form-campo" onchange="selecionarUnidade()"></select>
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
                                 <select  class="form-campo" id="tipo_desc" name="tipo_desc">
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
                                    <th align="center">Código</th>
                                    <th align="center">Nome</th>
                                    <th align="center">Unidade</th>
                                    <th align="center">Quantidade</th>                                    
                                    <th align="center">Valor Unit</th>
                                    <th align="center">Subtotal</th>
                                    <th align="center">Desconto</th>
                                    <th align="center">Total</th>
                                    <th align="center">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
							</tbody>
                            </table>
								
                   </div>

                </fieldset>
			
		
		<fieldset class="mt-3 mb-0"> 
			<div class="rows">
			<div class="col-12 mb-3">				       
                   
			</div>
			<div class="col-6">
				<fieldset class="p-1 border radius-4 ">
				<legend class="">Totais do Orçamento</legend>	
					<div class="rows">
					<div class="col-4 mb-3">	
                         <label class="text-label d-block ">Total dos Produtos</label>
                         <input type="text" name="valor_total" disabled value="0" id="valor_total" class="form-campo">
                     </div>                                   
                     
                     
                     <div class="col-4 mb-3">	
                         <label class="text-label d-block ">Valor Frete</label>
                         <input type="text" name="valor_frete" id="valor_frete" value="{{($orcamento->valor_frete) ?? old('frete')}}"  class="form-campo  mascara-float">
                     </div>
                   
                   <div class="col-4 mb-3">	
                         <label class="text-label d-block ">Desconto Itens </label>
                         <input type="text"  id="total_desconto_item" readonly="readonly" value="{{($orcamento->valor_desconto) ?? old('desconto_valor')}}" class="form-campo mascara-float">
                     </div>
                     
                     <div class="col-4 mb-3">	
                         <label class="text-label d-block ">Desconto Venda R$ </label>
                         <input type="text" name="desconto_valor"  id="desconto_valor" value="{{($orcamento->valor_desconto) ?? old('desconto_valor')}}" class="form-campo mascara-float">
                     </div>
                     
                     <div class="col-4 mb-3">	
                         <label class="text-label d-block ">Desconto Venda % </label>
                         <input type="text" name="desconto_per"  id="desconto_per"  class="form-campo mascara-float">
                     </div>
                     
                     <div class="col-4 mb-3">	
                         <label class="text-label d-block ">Total de Seguro </label>
                         <input type="text" name="total_seguro"  id="total_seguro"  class="form-campo mascara-float">
                     </div>
                     
                     <div class="col-4 mb-3">	
                         <label class="text-label d-block ">Outras Despesas </label>
                         <input type="text" name="despesas_outras"  id="despesas_outras"  class="form-campo mascara-float">
                     </div>
                     
                     <div class="col-4 mb-3">	
                         <label class="text-label d-block ">Total da Venda</label>
                         <input type="text" name="totalorcamento" disabled value="0" id="totalorcamento" value="{{($orcamento->valor_orcamento) ?? old('valor_orcamento')}}" class="form-campo">
                     </div>
            </div>
                   
				</fieldset>
			   </div>
			   
			   
			<div class="col-6 d-flex">           
			  <fieldset class="border radius-4 p-1">
				<legend class="">Dados do Pagamento</legend>	 
				<div class="rows">
                  <div class="col-12 mb-3">
                		<label class="text-label">Meio de Pagamento</label>
                		<select class="form-campo" name="tPag" id="tPag" >	
                			               													
                			@foreach(ConstanteService::tiposPagamento() as $chave=>$valor)
                			     <option value='{{ $chave}}' {{($tPag==$chave) ? 'selected' : ''}}>{{$chave . " - ". $valor }}</option>
                			@endforeach		
                		</select>
                	</div>
				
						<div class="col-6 mb-3">	
                            <label class="text-label d-block">Forma de pagamento</label>
                            <select id="formaPagamento" name="formaPagamento" class="form-campo">
							
								<option value="a_vista" {{($forma_pagto=='a_vista') ? 'selected' : ''}}>A vista</option>
								<option value="personalizado" {{($forma_pagto=='personalizado') ? 'selected' : ''}}>Parcelado</option>
							</select>
                        </div>                                     
                        
                         <div class="col-6 mb-3">	
                            <label class="text-label d-block">Qt. Parcelas</label>
                            <select id="qtde_parcela"  class="form-campo">
                           
                            @for($i=1; $i<=12; $i++)
								<option value="{{$i}}">{{zeroEsquerda($i,2)}}</option>
							@endfor
							</select>
                        </div>                                       
                        
                         <div class="col-6 mb-3 validated">	
                            <label class="text-label d-block ">Vencimento</label>
                            <input type="date" name="primeiro_vencimento" value="{{hoje()}}" id="primeiro_vencimento" class="form-campo">
                        </div>
                       
                        <div class="col-6 mb-3">	
                            <label class="text-label d-block">Valor da parcela</label>
                            <input type="text" name="valor_parcela" value="0" id="valor_parcela" class="form-campo mascara-float">
                        </div>                      
                                                      
					</div>
                </fieldset>
                  
                
               </div>
               
			   
			   
			</div>
		</fieldset>
		
		
		<fieldset class="mt-4">
    	<legend>Finalizar</legend>	   
    				<div class="rows">	
    					<div class="col-12">
    					</div>
                 			<div class="col-12 mb-3">
    								<label class="text-label">Observação </label>
    								<textarea rows="5" cols="5" name="observacao" id="observacao" class="form-campo">{{($orcamento->observacao) ?? old('observacao')}}</textarea>
    						</div>		
    						
    						<div class="col-12 mb-3">
    								<input type="hidden" name="observacao_interna" value="{{($orcamento->observacao_interna) ?? old('observacao_interna')}}" id="observacao_interna" class="form-campo">
    						</div>
    						
    						<div class="col-12 text-center pb-4">
                    			<button type="button" class="btn btn-azul m-auto d-block" id="salvar-orcamento" href="#" onclick="salvarOrcamento()"><i class="fas fa-check"></i> Finalizar</button>                		
                    		</div>
    				</div>
    	</fieldset>
			</div>
		</div>
	  </div>
	  </div>
	  
     
	  
	  

 </div>  
		
</div>

<!--identificar cliente-->
<div class="window medio" id="modal_opcoes" style="padding:0!important">
<h4 class="d-block text-center pb-1 border-bottom mb-2 h4 p-3">Escolha uma Opção</h4>
	<div class="p-2 text-center mt-2" id="giragira_orcamento">
		<img src="{{asset('assets/admin/img/load2.gif')}}" width="60" class="m-auto">
		<span class="text-cinza d-block mt-2 mb-2"> Aguarde carregando...</span>
	</div>
	
	<div class="p-2 text-center mt-2" id="div_retorno_orcamento">
		<span class="msg msg-vermelho p-1 text-left">
			<span class="d-block text-center mb-0"> Erro: <b id="mensagem_erro_orcamento"></b></span>			
		</span>
	</div>	
	<div class="p-2 text-center mt-2" id="div_sucesso_orcamento">
		<span class="msg msg-verde p-1 text-left">
			<span class="d-block text-center mb-0"> Operação Realizada com Sucesso!!</span>			
		</span>
	</div>	
		
	<div class="text-right base-botoes radius-0 mt-0 p-1 border-top py-3 ">	
			<a href="javascript:;" onclick="salvarNfePorVenda()" class="btn btn-azul d-inline-block btn-medio"><i class="fas fa-scroll"></i> Salvar NFE</a>					
			<a href="javascript:;" onclick="salvarNfePorVenda()" class="btn btn-azul d-inline-block btn-medio"><i class="fas fa-scroll"></i> Salvar e Transmitir NFE</a>	
			<a href="{{route('admin.orcamento.index')}}" class="btn btn-verde d-inline-block btn-medio"><i class="fas fa-scroll"></i> Listar Vendas</a>
			<a href="{{route('admin.orcamento.create')}}" class="btn btn-verde d-inline-block btn-medio"><i class="fas fa-scroll"></i> Nova Venda</a>
			<a href="javascript:;" onclick="fecharTela()" class="btn btn-vermelho d-inline-block btn-medio"><i class="fas fa-times"></i> Fechar</a>
	</div>
	<input type="hidden" id="id_orcamento">
</div>

<!--cancelar orcamento -->
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

<div class="window medio" id="modal_salvar_orcamento">
	<div class="p-2 px-4">
			<span class="pt-4 d-block h3 border-bottom fw-700">Salvar Orçamento</span>
		<div class="rows">
             <div class="col-12 mb-3">
                   <span class="text-label fw-700 h5 mb-1">Selecione as opções desejadas</span>
                    <div class="width-100 border radius-4">
                        <div class="check radio p-4 d-block">							
        					<label class="d-flex mb-1"><input type="checkbox"  id="lancar_estoque" {{$parametro->lancar_estoque_orcamento=='S' ? 'checked' : ''}}> Lançar estoque</label>
        					<label class="d-flex mb-1"><input type="radio" name="rbNFE" value="1"  id="nao_gerar_nfe" {{($parametro->opcao_depois_orcamento=="1") ? "checked" : ""}}>Não Gerar Nota Fiscal</label>
        					<label class="d-flex mb-1"><input type="radio" name="rbNFE" value="2" id="gerar_nfe" {{($parametro->opcao_depois_orcamento=="2") ? "checked" : ""}}> Gerar Nota Fiscal</label>
        				</div>
    				</div>
             </div>                                 
         </div>
		 <div class="tfooter border-0 between">
			<div class="d-flex">
				<input type="hidden" name="eh_modal" id="eh_modal" value="0">
				<a href="javascript:;" onClick="salvarOrcamento()" class="btn btn-verde border-bottom" >Salvar Venda</a>
		 </div>
			<a href="" class="btn btn-vermelho fechar">Fechar</a>
		 </div>
	</div>
</div>

  @include ("Admin.Cadastro.Produto.modal.modalCadastroProduto")
  @include ("Admin.Cadastro.Cliente.modal.modalCadastroCliente")
  @include ("Admin.Cadastro.Transportadora.modal.modalCadastroTransportadora")
  @include ("Admin.Cadastro.Categoria.modal.modalCategoria")
  @include ("Admin.Cadastro.SubCategoria.modal.modalSubCategoria")
  @include ("Admin.Cadastro.SubSubCategoria.modal.modalSubSubCategoria")
@endsection