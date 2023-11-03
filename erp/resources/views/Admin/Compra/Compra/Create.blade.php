<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Compra</span>
	<div class="d-flex">
		<a href="{{route('admin.compra.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	
	</div>
</span>                      


			<div class="p-2 pb-0">
			<div class="rows">
			
			<div class="col-12">
                <div class="caixa"> 
                    <fieldset class="pt-0 bg-padrao mb-0">
						 <div class="">							  
							<span class="titulo text-branco px-0">Dados da Compra </span>
							<div class="mt-2 radius-4">
							 <div class="rows">								 	
                                        
							 		  	<div class="col-3">	
                                            <label class="text-label d-block text-branco">Data Compra</label>
                                            <input type="date" name="data_compra" id="data_compra" value="{{$compra->data_compra ?? hoje()}}" class="form-campo ">
                                        </div>                                       
                                        <div class="col-4">
                                            <label class="text-label d-block text-branco">Fornecedores</label>
                                            <div class="group-btn">	                                
                                                <input type="text" name="desc_fornecedor" id="desc_fornecedor" value="{{$fornecedor->nome_razao_social ?? null}}" class="form-campo">
                                                <input type="hidden" name="fornecedor_id" value="{{$fornecedor->id ?? null}}"  id="fornecedor_id" >       
                                               <a href="{{route('admin.fornecedor.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Fornecedor"></a>
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
				<legend>Itens da Compra</legend>
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
                            <select id="unidade_compra" class="form-campo" onchange="selecionarUnidade()"></select>
                        </div>
                                                               
                         <div class="col-2">	
                            <label class="text-label d-block ">Valor de Compra</label>
                            <input type="text" name="valor"  value="0" id="valor" class="form-campo mascara-float">
                        </div>
                        
                                                        
                        
                        <div class="col-2">	
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
                            <input type="text" name="subtotal" readonly="readonly" value="0" id="subtotal" class="form-campo mascara-float">
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
				

	
			</div>
		</div>
	  </div>
	  </div>
	  		
 </div>  
		
</div>


  @include ("Admin.Cadastro.Produto.modal.modalCadastroProduto")
  @include ("Admin.Cadastro.Fornecedor.modal.modalCadastroFornecedor")
  @include ("Admin.Cadastro.Vendedor.modal.modalCadastroVendedor")
@endsection