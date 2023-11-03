@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" h5 mb-0 "><i class="fas fa-plus-circle"></i> Cadastrar Contrato</span>
		<div>
			<a href="{{route('admin.vendarecorrente.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>	
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>			
		</div>
	</div>                 
 @if(isset($vendarecorrente))    
   <form action="{{route('admin.vendarecorrente.update', $vendarecorrente->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.vendarecorrente.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2 mt-1">
			
			<fieldset>
				<legend>Informações básicas</legend>
				
				<div class="rows">
					<div class="col-2 mb-3">
							<label class="text-label">Data Início</label>	
							<input type="date" name="data_inicio" onchange="calcularDataVencimento()" id="data_inicio" value="{{isset($vendarecorrente->data_inicio) ? $vendarecorrente->data_inicio : hoje() }}"  class="form-campo ">
					</div>
					
						<div class="col-4">
                            <label class="text-label d-block ">Cliente</label>
                            <div class="group-btn">	                                
                                <input type="text" name="desc_cliente" id="desc_cliente"  class="form-campo">
                                <input type="hidden" name="cliente_id"   id="cliente_id" >       
                               <a href="{{route('admin.cliente.create')}}" target="_blank"  class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
							</div>                               
                        </div>
					
					
					
					
					                    
                    <div class="col-3 mb-3">
							<label class="text-label">Modelo Contrato<span class="text-vermelho">*</span></label>
						<div class="group-btn">							
							<select name="modelo_contrato_id" id="modelo_contrato_id" class="form-campo">							
								@foreach($modelos as $m)
									<option value="{{$m->id}}">{{$m->nome}}</option>
								@endforeach
							</select>
								<a href="{{route('admin.modelocontrato.create')}}" target="_blank"  class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
							</div> 
					</div>
					
					<div class="col-3 mb-3">
							<label class="text-label">Vendedor<span class="text-vermelho">*</span></label>						
							<select name="vendedor_id" id="vendedor_id" class="form-campo">							
								@foreach($vendedores as $v)
									<option value="{{$v->id}}">{{$v->id}} - {{$v->nome}}</option>
								@endforeach
							</select>
					
					</div>											
					 			
					
				</div>
			</fieldset>
			
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
	
</form>
</div>

@endsection