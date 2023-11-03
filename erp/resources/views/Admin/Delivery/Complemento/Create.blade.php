@extends("templates.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="fas fa-plus-circle"></i> Cadastrar Complemento</span>
 
 @if(isset($categoria))    
   <form action="{{route('admin.deliverycomplemento.update', $complemento->id)}}" method="POST" >
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.deliverycomplemento.store')}}" method="Post" >
@endif
	@csrf	
	
                                
            <div class="col-6 d-block m-auto rows px-5 py-5">
                <div class="col-12 mb-3">
                    <label class="text-label">Nome</label>	
                    <input type="text" name="nome" value="{{isset($complemento->nome) ? $complemento->nome : null}}" class="form-campo" placeholder="Digite o nome da categoria">
                    @if($errors->has('nome'))
					<div class="invalid-feedback">
						{{ $errors->first('nome') }}
					</div>
					@endif
                </div>
                <div class="col-12 mb-3">
                    <label class="text-label">Valor </label>	
                    <input type="text" name="valor" value="{{isset($complemento->valor) ? $complemento->valor : null}}" class="form-campo" placeholder="Digite o nome da categoria">
                    @if($errors->has('valor'))
					<div class="invalid-feedback">
						{{ $errors->first('valor') }}
					</div>
					@endif
                </div>
                
               <div class="col-12 mb-3">
                    <label class="text-label">Categoria </label>	
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
          
                
                                       
                <div class="col-12 mt-3 mb-5">
                    <input type="submit" value="Salvar Dados" class="btn btn-azul d-block m-auto">
                </div>
            </div>
        </form>
</div>
@endsection