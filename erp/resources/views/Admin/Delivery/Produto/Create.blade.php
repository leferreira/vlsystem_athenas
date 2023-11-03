@extends("Admin.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="fas fa-plus-circle"></i> Cadastrar produto</span>
                      
 @if(isset($produto))    
   <form action="{{route('admin.deliveryproduto.update', $produto->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.deliveryproduto.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	  <ul>
		<li><a href="#tab-1">Produto</a></li>
	
	  </ul>
	  <div id="tab-1">
		<div class="p-2">
				<span class="d-block mt-4 mb-4 h4 border-bottom text-uppercase">Informações básicas</span>
				<div class="rows">									
					

                        <div class="col-12 px-2">
                           <div class="rows">                               
                                
                                <div class="col-6 mb-3" id="ref-prod">
                                        <label class="text-label">Produto</label>
                                        <select class="form-campo" name="produto_id" id="kt_select2_1">
                                        <option  value="">selecione</option>
                                          @foreach($produtos as $prod)
                                          	<option value="{{$prod->id}}">{{$prod->nome}}</option>
                                          @endforeach                                              
                                        </select>
                                        @if($errors->has('produto'))
											<div class="invalid-feedback">
												{{ $errors->first('produto') }}
											</div>
											@endif
                                </div>
                                
                                <div style="display: none" id="novo-prod" class="form-group validated col-sm-7 col-lg-7 col-10">
											<label class="col-form-label">Nome do Produto</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('nome')) is-invalid @endif" name="produto" id="nome" >
												@if($errors->has('nome'))
												<div class="invalid-feedback">
													{{ $errors->first('nome') }}
												</div>
												@endif
											</div>
										</div>
										
										
                                
                                <div class="col-6 mb-3">
                                        <label class="text-label">Categoria</label>
                                        <select class="form-campo" name="categoria_id">
                                          @foreach($categorias as $c)
                                          	<option value="{{$c->id}}">{{$c->nome}}</option>
                                          @endforeach                                              
                                        </select>
                                        @if($errors->has('categoria_id'))
											<div class="invalid-feedback">
												{{ $errors->first('categoria_id') }}
											</div>
											@endif
                                </div>                    
                                
                                <div class="col-4 mb-3">
                                        <label class="text-label">Valor Venda</label>
                                        <input type="text" name="valor" id="valor" value="{{isset($produto->valor) ? $produto->valor : old('valor')}}" placeholder="Digite aqui..." class="form-campo">
                                        @if($errors->has('valor'))
										<div class="invalid-feedback">
											{{ $errors->first('valor') }}
										</div>
										@endif
                                </div>
                                
                                <div class="col-4 mb-3">
                                        <label class="text-label">Valor Anterior</label>
                                        <input type="text" name="valor_anterior" value="{{isset($produto->valor_anterior) ? $produto->valor_anterior : old('valor_anterior')}}" placeholder="Digite aqui..." class="form-campo">
                                        @if($errors->has('valor_anterior'))
										<div class="invalid-feedback">
											{{ $errors->first('valor_anterior') }}
										</div>
										@endif
                                </div>
                                <div class="col-4 mb-3">
                                        <label class="text-label">Limite diário de Venda</label>
                                        <input type="text" name="limite_diario" value="{{isset($produto->limite_diario) ? $produto->limite_diario : old('limite_diario')}}" placeholder="Digite aqui..." class="form-campo">
                                        @if($errors->has('limite_diario'))
										<div class="invalid-feedback">
											{{ $errors->first('limite_diario') }}
										</div>
										@endif
                                </div>
                                
                                
                                
                                <div class="col-12 mb-3">
                                        <label class="text-label">Descricao</label>
                                        <input type="text" name="descricao" value="{{isset($produto->descricao) ? $produto->descricao : old('descricao')}}" placeholder="Digite aqui..." class="form-campo">
                                        @if($errors->has('descricao'))
											<div class="invalid-feedback">
												{{ $errors->first('descricao') }}
											</div>
											@endif
                                </div>
                                <div class="col-12 mb-3">
                                        <label class="text-label">Ingredientes</label>
                                        <input type="text" name="ingredientes" value="{{isset($produto->ingredientes) ? $produto->ingredientes : old('ingredientes')}}" placeholder="Digite aqui..." class="form-campo">
                                        @if($errors->has('ingredientes'))
											<div class="invalid-feedback">
												{{ $errors->first('ingredientes') }}
											</div>
											@endif
                                </div>
                                
                                <div class="col-4 mb-3">
                                        <label class="text-label">Destaque </label>
                                        <select class="form-campo" name="vende_pdv">                        
                                            <option value="">Selecione</option>
                                          	<option value="S">Sim</option>
                                          	<option value="N">Não</option>
                                          
                    				   </select>
                                </div>
                                
                                <div class="col-4 mb-3">
                                        <label class="text-label">Ativo no Delivery </label>
                                        <select class="form-campo" name="vende_pdv">                        
                                            <option value="">Selecione</option>
                                          	<option value="S">Sim</option>
                                          	<option value="N">Não</option>
                                          
                    				   </select>
                                </div>
                                
                                <div class="col-4 mb-3">
                                        <label class="text-label">Exibir auto Atendimento </label>
                                        <select class="form-campo" name="vende_pdv">                        
                                            <option value="">Selecione</option>
                                          	<option value="S">Sim</option>
                                          	<option value="N">Não</option>
                                          
                    				   </select>
                                </div>
                                                    
                                                            
                                	
                        </div>
			
                           
                        </div>
				

			</div>
		</div>
	  </div>
	  
	  
         
         
 </div>
		<div class="col-12 text-center pb-4">
			<input type="submit" value="Salvar" class="btn btn-laranja m-auto">
		</div>
	  </div>
	
</form>
</div>
@endsection