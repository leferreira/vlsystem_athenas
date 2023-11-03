@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
	<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de produto </span></span>
	<div>
		<!--<a href="javascript:;" onclick="abrirModal('#add')" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Cadastrar categoria</a>-->
		<a href="{{route('cadastro.produto.index')}}" class="btn btn-azul btn-pequeno mx-1 d-inline-block"><i class="fas fa-arrow-left"></i> Volta</a>
	</div>
</div>                      
 @if(isset($produto))    
   <form action="{{route('cadastro.produto.update', $produto->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('cadastro.produto.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	  <ul>
		<li><a href="#tab-1">Produto</a></li>
		<li><a href="#tab-2">Dados Fiscais</a></li>
	  </ul>
	  <div id="tab-1">
		<div class="p-2 pt-4">
			<fieldset>
				<legend>Informações básicas</legend>
				<div class="rows">	
                        <div class="col-12 px-2">
                           <div class="rows">
                                <div class="col-8 mb-3">
                                        <label class="text-label">Nome do produto</label>
                                        <input type="text" value="{{isset($produto->nome) ? $produto->nome : old('nome')}}" name="nome" placeholder="Digite aqui..." class="form-campo">
                                </div>
                             
                                
                                <div class="col-4 mb-3">
                                        <label class="text-label">GTIN/EAN</label>
                                        <input type="text" name="gtin" value="{{isset($produto->gtin) ? $produto->gtin : old('gtin')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>                              
                                 
                                
                                
                                <div class="col-4 mb-3">
                                        <label class="text-label">Categoria </label>
									<div class="group-btn">
                                        <?php $id_categoria = ($produto->categoria_id) ?? null ?>
                                        <select class="form-campo" name="categoria_id" id="categoria_id">
                                        
                                          @foreach($categorias as $cat)
                                          	<option value="{{$cat->id}}" {{($cat->id == $id_categoria) ? 'selected': ''}}>{{$cat->categoria}}</option>
                                          @endforeach                                              
                                        </select>
										<a href="javascript:;" onclick="abrirModal('#categoriaProduto')" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
									</div> 
                                </div>
                               
                                <div class="col-4 mb-3">
                                        <label class="text-label">Unidade </label>
                                        <select class="form-campo" name="unidade">
                                            @foreach($unidades as $unidade)
                                          	<option value="{{$unidade}}">{{$unidade}}</option>
                                          @endforeach 
									   </select>
                                </div>                              
                                
                               <div class="col-4 mb-3">
                                        <label class="text-label">Preço Venda</label>
                                        <input type="text" name="valor_venda" value="{{isset($produto->valor_venda) ? $produto->valor_venda : old('valor_venda')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                
                                <div class="col-2 mb-3">
                                        <label class="text-label">Preço Custo</label>
                                        <input type="text" name="valor_custo" value="{{isset($produto->valor_custo) ? $produto->valor_custo : old('valor_custo')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                
                                <div class="col-2 mb-3">
                                        <label class="text-label">Custo Médio</label>
                                        <input type="text" name="custo_medio" value="{{isset($produto->custo_medio) ? $produto->custo_medio : old('custo_medio')}}" readonly="readonly" class="form-campo"  placeholder="Digite aqui...">
                                </div>
                               
                                <div class="col-2 mb-3">
                                        <label class="text-label">Estoque Inicial</label>
                                        <input type="text" name="estoque_inicial" value="{{isset($produto->estoque_inicial) ? $produto->estoque_inicial : old('estoque_inicial')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">Estoque Máximo</label>
                                        <input type="text" name="estoque_maximo" value="{{isset($produto->estoque_maximo) ? $produto->estoque_maximo : old('estoque_maximo')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">Estoque Mínimo</label>
                                        <input type="text" name="estoque_minimo" value="{{isset($produto->estoque_minimo) ? $produto->estoque_minimo : old('estoque_minimo')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">Estoque Atual</label>
                                        <input type="text"  value="{{isset($produto->estoque_atual) ? $produto->estoque_atual : old('estoque_atual')}}" readonly="readonly" class="form-campo" placeholder="Digite aqui...">
                                </div>
                              
                                 
                                	
                        </div>
			
                           
                        </div>
				

			</div>
			</fieldset>
		</div>
	  </div>
	  
	  <div id="tab-2">
		<div class="p-2 pt-4">									
       <fieldset>
			<legend>Vendas</legend>									
			<div class="rows">	
        
        	<div class="col-6 mb-3">
                    <label class="text-label">Tributação</label>
                    <select class="form-campo" name="tributacao_id">
                      @foreach($tributacoes as $trib)
                      	<option value="{{$trib->id}}">{{$trib->tributacao}}</option>
                      @endforeach                                              
                    </select>
            </div>
            
             <div class="col-3 mb-3">
                    <label class="text-label">NCM</label>
                    <input type="text" name="ncm" value="{{isset($produto->ncm) ? $produto->ncm : old('ncm')}}" placeholder="Digite aqui..." class="form-campo">
            </div>
            
            <div class="col-3 mb-3">
                    <label class="text-label">CEST</label>
                    <input type="text" name="cest" value="{{isset($produto->cest) ? $produto->cest : old('cest')}}" placeholder="Digite aqui..." class="form-campo">
            </div>
                                
            
            <div class="col-6 mb-3">
                    <label class="text-label">CFOP Saida  </label>
                    <input type="text" name="cfop" value="{{isset($produto->cfop_saida) ? $produto->cfop : old('cfop')}}" placeholder="Digite aqui..." class="form-campo">
            </div> 
             <div class="col-3 mb-3">
                    <label class="text-label">Código Benefício</label>
                    <input type="text" name="cbenef" value="{{isset($produto->cbenef) ? $produto->cbenef : old('cbenef')}}" placeholder="Digite aqui..." class="form-campo">
            </div>
            <div class="col-3 mb-3">
                    <label class="text-label">Código exceção da TIPI</label>
                    <input type="text" name="tipi" value="{{isset($produto->tipi) ? $produto->tipi : old('tipi')}}" placeholder="Digite aqui..." class="form-campo">
            </div>
                  
         </div>
			</fieldset>
        </div>
	  </div>
	  
         
         
 </div>
		<div class="col-12 text-center pb-4">
		     <input type="hidden" name="cadastrar_ecommerce" id="cadastrar_ecommerce" value="N" >		
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	  </div>
	
</form>
</div>
@endsection

<div class="window medio" id="categoriaProduto">
	<span class="d-block titulo mb-0"><i class="fas fa-plus-circle"></i> Adicionar nova categoria</span>
	<form action="" method="">
		<div class="p-3">
			<div class="rows">
                <div class="col-12">	
                        <label class="text-label d-block">Nome </label>
                        <input type="text" name="categoria" id="txtCategoria" class="form-campo" placeholder="Inserir categoria">
                </div> 
                <div class="col-2 mt-1 pt-1">
                </div>
			</div>
		</div>
		<div class="tfooter end">
			<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho fechar" >Cancelar</a>
            <input type="button"  onclick="salvarCategoria()" value="Inserir categoria" class="btn btn-azul text-uppercase">
		</div>
	</form>

</div>


<div class="window medio" id="lojaCategoriaProduto">
	<span class="d-block titulo mb-0"><i class="fas fa-plus-circle"></i> Adicionar nova categoria</span>
	<form action="" method="">
		<div class="p-3">
			<div class="rows">
                <div class="col-12">	
                        <label class="text-label d-block">Nome </label>
                        <input type="text" name="categoria" id="txtLojaCategoria" class="form-campo" placeholder="Inserir categoria">
                </div> 
                <div class="col-2 mt-1 pt-1">
                </div>
			</div>
		</div>
		<div class="tfooter end">
			<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho fechar" >Cancelar</a>
            <input type="button"  onclick="salvarLojaCategoria()" value="Inserir categoria" class="btn btn-azul text-uppercase">
		</div>
	</form>

</div>
