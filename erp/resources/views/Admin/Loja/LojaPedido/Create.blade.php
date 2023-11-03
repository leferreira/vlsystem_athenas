<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Venda de Pedido</span>
	<div class="d-flex">
		<a href="{{route('admin.lojapedido.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	
	</div>
</span>                      


			<div class="p-2 pb-0">
			<div class="rows">
			
			<div class="col-12">
                <div class="caixa"> 
                    <fieldset class="pt-0 bg-padrao mb-0">
						 <div class="">							  
							<span class="titulo text-branco px-0">Dados do Pedido </span>
							<div class="mt-2 radius-4">
							 <div class="rows">								 	
                                        
							 		  	<div class="col-3">	
                                            <label class="text-label d-block text-branco">Data Venda</label>
                                            <input type="date" name="data_venda" id="data_venda" value="{{$venda->data_venda ?? hoje()}}" class="form-campo ">
                                        </div>                                       
                                        <div class="col-4">
                                            <label class="text-label d-block text-branco">Cliente</label>
                                            <div class="group-btn">	                                
                                                <input type="text" name="desc_cliente" id="desc_cliente"  class="form-campo">
                                                <input type="hidden" name="cliente_id"   id="cliente_id" >       
                                               <a href="{{route('admin.cliente.create')}}" target="_blank"  class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
                							</div>                               
                                        </div>
                                        
                                        <div class="col-4">
                                            <label class="text-label d-block text-branco">Vendedor</label>
                                            <div class="group-btn">	                                
                                                <input type="text" name="desc_vendedor" id="desc_vendedor"  class="form-campo">
                                                <input type="hidden" name="vendedor_id"   id="vendedor_id" >        
                                               <a href="{{route('admin.vendedor.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
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
                    <div class="pt-0">
						<div class="rows">	
						
                            <div class="col-6">
                                <label class="text-label d-block ">Produto</label>
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
				<fieldset class="mt-4">
	<legend>Totais do Pedido</legend>
	  <input type="hidden" id="_token" value="{{ csrf_token() }}"> 
			<div class="rows">
					<div class="col-2">	
                         <label class="text-label d-block ">Total dos Produtos</label>
                         <input type="text" name="valor_venda" disabled value="0" id="valor_venda" class="form-campo">
                     </div>                                   
                     
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Valor Frete</label>
                         <input type="text" name="valor_frete" id="valor_frete" value="{{($venda->valor_frete) ?? old('valor_frete')}}"  class="form-campo  mascara-float">
                     </div>
                   
                   <div class="col-2">	
                         <label class="text-label d-block ">Desconto Itens </label>
                         <input type="text"  id="total_desconto_item" readonly="readonly" value="{{($venda->valor_desconto) ?? old('desconto_valor')}}" class="form-campo mascara-float">
                     </div>
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Desconto Venda R$ </label>
                         <input type="text" name="desconto_valor"  id="desconto_valor" value="{{($venda->valor_desconto) ?? old('desconto_valor')}}" class="form-campo mascara-float">
                     </div>
                     
                     <div class="col-2">	
                         <label class="text-label d-block ">Desconto Venda % </label>
                         <input type="text" name="desconto_per"  id="desconto_per"  class="form-campo mascara-float">
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
                         <input type="text" name="totalvenda" disabled value="0" id="totalvenda" value="{{($venda->valor_venda) ?? old('valor_venda')}}" class="form-campo">
                     </div>
                     
                      <div class="col-2">	
                         <label class="text-label d-block ">.</label>
                         <button type="button" class="btn btn-azul m-auto d-block" id="salvar-venda" href="#" onclick="salvarVenda()"><i class="fas fa-check"></i> Salvar Venda</button>                		
                     </div>
            </div>
		</fieldset>

	
			</div>
		</div>
	  </div>
	  </div>
	  		
 </div>  
		
</div>

  @include ("Admin.Cadastro.Cliente.modal.modalCadastroCliente")
  @include ("Admin.Cadastro.Vendedor.modal.modalCadastroVendedor")
@endsection