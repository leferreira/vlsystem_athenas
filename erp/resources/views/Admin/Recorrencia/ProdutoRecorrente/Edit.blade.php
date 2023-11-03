@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" h5 mb-0 "><i class="fas fa-plus-circle"></i> Cadastrar Produto com Recorrência</span>
		<div>
			<a href="{{route('admin.produtorecorrente.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>	
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>			
		</div>
	</div>                 

   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2 mt-1">
		 @if(isset($produtorecorrente))    
           <form action="{{route('admin.produtorecorrente.update', $produtorecorrente->id)}}" method="POST">
           <input name="_method" type="hidden" value="PUT"/>
         @else                       
        	<form action="{{route('admin.produtorecorrente.store')}}" method="Post">
        @endif
		@csrf
			<input type="hidden" id="produto_recorrente_id"  value="{{isset($produtorecorrente->id) ? $produtorecorrente->id : old('id') }}" >	
			<fieldset>
				<legend>Informações básicas</legend>
				
				<div class="rows">
					<div class="col-6 mb-3" >
							<label class="text-label">Descrição</label>	
							<input type="text" name="descricao" id="descricao" value="{{isset($produtorecorrente->descricao) ? $produtorecorrente->descricao : old('descricao') }}" class="form-campo">
					</div>
				
					<div class="col-2 mb-3" >
							<label class="text-label">Produto + Serviços</label>	
							<input type="text" readonly="readonly" value="{{isset($produtorecorrente->subtotal_liquido) ? $produtorecorrente->subtotal_liquido : old('subtotal_liquido') }}" class="form-campo">
					</div>
					
					<div class="col-2 mb-3" >
							<label class="text-label">Valor Final</label>	
							<input type="text" name="valor" id="valor" value="{{isset($produtorecorrente->valor) ? $produtorecorrente->valor: old('valor') }}" class="form-campo mascara-float">
					</div>
					<div class="col-2 mb-3" >
							<label class="text-label">.</label>	
							<input type="submit" value="Salvar Dados" class="btn btn-azul m-auto">
					</div>
					
				</div>
			</fieldset>
		</form>	
			
			<fieldset class="mt-3 mb-0"> 
			<div class="rows">
			<div class="col-12 mb-3">				       
                   
			</div>
			<div class="col-6">
				<fieldset class="p-1 border radius-4 ">			
				<legend class="">Servicos </legend>
					<div class="rows">
				
						<div class="col-9 mb-3">	
                            <label class="text-label d-block">Serviço</label>
                             <div class="group-btn">	
                                <input type="text" name="desc_servico" id="desc_servico" class="form-campo">
                                <input type="hidden" name="servico_id"   id="servico_id" >
    							<a href="javascript:;" onclick="abrirModal('#modalCadServico')" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Serviço"></a>
                			</div> 
                        </div>                                    
                                            
                        <div class="col-3 mb-3">                        	
                            <label class="text-label d-block">.</label>
                            <button type="button" class="btn btn-roxo" onclick="inserirServico()"> Inserir </button>
                        </div>
                        
                                                      
					</div>
			
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
                            <tbody>
                            @foreach($lista_servicos as $t)
                            	<tr class='text-center' style='left: 0px;'>
                    			<td class='text-center'><span class='numero' style='width: 160px;'></span>{{$t->id}}</td>
                    			<td class='text-center'><span class='' style='width: 160px;'></span>{{$t->servico->nome}}</td>
                    			<td class='text-center'><span class='' style='width: 160px;'></span>{{$t->valor}}</td>
                    			<td class='text-center text-center'><span class='svg-icon svg-icon-danger' style='width: 80px;'>
                    			<a class='btn btn-vermelho btn-pequeno d-inline-block' href="{{route('admin.produtorecorrente.excluirItem', $t->id)}}" >
                    			<i class='fa fa-trash'></i></a></span></td>
                    			</tr>
                            
                            @endforeach
                            </tbody>
                   </table>	
                    </div>
                   <div class="width-100 tabela-responsiva border radius-4 bg-body" style="border-radius: 0 0 5px 5px!important;">  
				      <table cellpadding="0" cellspacing="0" class="table">
							<tr>
								
								<td class="border-0" colspan="3" align="right">								
									<strong >Total: <b class="text-vermelho h5 d-inline-block mb-0"><i id="restante_parcelas">{{isset($produtorecorrente->valor_servico) ? $produtorecorrente->valor_servico : 0 }}</i></b></strong>
								</td>
							</tr>
                      </table>  			
					</div>
				</fieldset>
			   </div>
               
			   <div class="col-6">
				<fieldset class="p-1 border radius-4 ">
				<legend class="">Produtos </legend>
					<div class="rows">
				
						<div class="col-8 mb-3">	
                            <label class="text-label d-block">Produtos</label>
                           <div class="group-btn">	                                
                                <input type="text" name="desc_produto" id="desc_produto" class="form-campo">
                                <input type="hidden" name="produto_id"   id="produto_id" >       
                               <a href="{{route('admin.produto.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
							</div>
                        </div>  
                        
                        <div class="col-2 mb-3">	
                            <label class="text-label d-block">Qtde</label>
                            <input type="text" id="quantidade" value="1" class="form-campo mascara-float">
                        </div>                                  
                                             
                        <div class="col-2 mb-3">
                            <label class="text-label d-block">.</label>
                            <button type="button" class="btn btn-roxo" onclick="inserirProduto()"> INS </button>
                        </div>
                        
                                                      
					</div>
						
					<div class="tabela-responsiva scroll p-0 width-100" style="border-radius:5px 5px 0 0 !important;">
                    <table cellpadding="0" cellspacing="0" class="table table-bordered menor fatura" width="100%">
                            <thead>
                            
								<tr>
                                    <th align="center">Id</th>
                                    <th align="center">Data</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Qtde</th>
                                    <th align="center">Subtotal</th>
                                    <th align="center">Excluir</th>
                                </tr>
                            
                            </thead>
                            <tbody>
                            @foreach($lista_produtos as $t)
                            	<tr class='text-center' style='left: 0px;'>
                    			<td class='text-center'><span class='numero' style='width: 160px;'></span>{{$t->id}}</td>
                    			<td class='text-center'><span class='' style='width: 160px;'></span>{{$t->produto->nome}}</td>
                    			<td class='text-center'><span class='' style='width: 160px;'></span>{{$t->valor}}</td>
                    			<td class='text-center'><span class='' style='width: 160px;'></span>{{$t->quantidade}}</td>
                    			<td class='text-center'><span class='' style='width: 160px;'></span>{{$t->subtotal}}</td>
                    			<td><a class='btn btn-vermelho btn-pequeno d-inline-block' href="{{route('admin.produtorecorrente.excluirItem', $t->id)}}" >
                    			<i class='fa fa-trash'></i></a></td>
                    			</tr>
                            
                            @endforeach
                            
                            </tbody>
                   </table>	
                    </div>
                   <div class="width-100 tabela-responsiva border radius-4 bg-body" style="border-radius: 0 0 5px 5px!important;">  
				      <table cellpadding="0" cellspacing="0" class="table">
							<tr>
								
								<td class="border-0" colspan="3" align="right">								
									<strong >Total: <b class="text-vermelho h5 d-inline-block mb-0"><i id="restante_parcelas">{{isset($produtorecorrente->valor_produto) ? $produtorecorrente->valor_produto : 0 }}</i></b></strong>
								</td>
							</tr>
                      </table>  			
					</div>
				</fieldset>
			   </div>
			   
			</div>
		</fieldset>
			
		</div>
	  </div>
	  
	  
		
	  </div>

</div>
@include ("Admin.Cadastro.Servico.modal.modalCadastroServico")
<script>
	function inserirServico(){

		var produto_recorrente_id 	= $("#produto_recorrente_id").val();
		var servico_id 		= $("#servico_id").val();
		var quantidade 		= 1;
		
		$.ajax({
         url: base_url + "admin/produtorecorrente/inserirServico" ,
         type: "POST", 
         data: {
			produto_recorrente_id	: produto_recorrente_id,
			servico_id 		: servico_id,
			quantidade  	: quantidade,
	
		},
          dataType:"Json",
         success: function(data){
			fecharModal();					
			if(data.tem_erro == true){		
				alert("Produto não encontrado");
			}else{
				location.reload();
			}					
		},
		  beforeSend: function () {
			giraGira();
	     }
			        
     });
		
	}
	
	function inserirProduto(){
		var produto_recorrente_id 	= $("#produto_recorrente_id").val();
		var produto_id 		= $("#produto_id").val();
		var quantidade 		= $("#quantidade").val();
		
		$.ajax({
         url: base_url + "admin/produtorecorrente/inserirProduto" ,
         type: "POST", 
         data: {
			produto_recorrente_id	: produto_recorrente_id,
			produto_id 		: produto_id,
			quantidade  	: quantidade,
	
		},
          dataType:"Json",
         success: function(data){
			fecharModal();					
			if(data.tem_erro == true){		
				alert("Produto não encontrado");
			}else{
				location.reload();
			}					
		},
		  beforeSend: function () {
			giraGira();
	     }
			        
     });
		
	}
</script>
@endsection