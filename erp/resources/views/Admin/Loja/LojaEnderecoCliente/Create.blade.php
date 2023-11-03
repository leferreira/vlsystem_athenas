@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 py-1 bg-title text-light text-uppercase h5 mb-0 text-branco d-flex justify-content-space-between">
	<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Dados do Endereço</span>
	<div>
		<a href="{{route('admin.lojaenderecocliente.index')}}" class="btn btn-azul btn-pequeno mx-1 d-inline-block" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
	</div>
</div>                      
 @if(isset($endereco))    
   <form action="{{route('admin.lojaenderecocliente.update', $endereco->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.loja.lojaenderecocliente.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	  <div id="tab-1">
		<div class="p-2 pt-4">
			<fieldset>
				<legend>Informações básicas</legend>
				<div class="rows">							
					
						 <div class="col-12 px-2">
                           <div class="rows">                                                        
                                <div class="col-6 mb-3">
                                   	<?php 
                                   	    $id_cliente   = ($endereco->cliente_id) ?? null;
                                   	?>
                                    <label class="text-label">Cliente</label>
                                    <select class="form-campo" name="cliente_id">
                                      @foreach($clientes as $c)
                                      	<option value="{{$c->id}}" {{($id_cliente==$c->id) ? 'selected' : ''}}>{{$c->nome}}</option>
                                      @endforeach                                              
                                    </select>
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">CEP</label>
                                        <input type="text" name="cep" value="{{isset($endereco->cep) ? $endereco->cep : old('cep')}}"  class="form-campo busca_cep">
                                </div>
                             
                                <div class="col-4 mb-3">
                                        <label class="text-label">Rua</label>
                                        <input type="text" name="rua" value="{{isset($endereco->rua) ? $endereco->rua : old('rua')}}"  class="form-campo rua">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">Número</label>
                                        <input type="text" name="numero" value="{{isset($endereco->numero) ? $endereco->numero : old('numero')}}"  class="form-campo">
                                </div>
                                <div class="col-4 mb-3">
                                        <label class="text-label">Bairro</label>
                                        <input type="text" name="bairro" value="{{isset($endereco->bairro) ? $endereco->bairro : old('bairro')}}"  class="form-campo bairro">
                                </div>
                                <div class="col-3 mb-3">
                                        <label class="text-label">Complemento</label>
                                        <input type="text" name="complemento" value="{{isset($endereco->complemento) ? $endereco->complemento : old('complemento')}}"  class="form-campo">
                                </div>
                                
                                <div class="col-2 mb-3">
                                        <label class="text-label">Cidade</label>
                                        <input type="text" name="cidade" value="{{isset($endereco->cidade) ? $endereco->cidade : old('cidade')}}"  class="form-campo cidade">
                                </div>
                                <div class="col-1 mb-3">
                                        <label class="text-label">UF</label>
                                        <input type="text" name="uf" value="{{isset($endereco->uf) ? $endereco->uf : old('uf')}}"  class="form-campo estado">
                                </div>                              
                                
                                
                                                          
                        </div>
					</div>
				</div>
			</fieldset>
		</div>
	  </div>

 </div>
		<div class="col-12 text-center pb-4">	
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	  </div>
	
</form>
</div>

@endsection