@extends("admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="fas fa-plus-circle"></i> Cadastrar Tamanho Pizza</span>
 
 @if(isset($tamanho))    
   <form action="{{route('admin.deliverytamanhopizza.update', $tamanho->id)}}" method="POST" >
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.deliverytamanhopizza.store')}}" method="Post" >
@endif
	@csrf	
	
                                
            <div class="col-6 d-block m-auto rows px-5 py-5">
                <div class="col-12 mb-3">
                    <label class="text-label">Nome</label>	
                    <input type="text" name="nome" value="{{isset($tamanho->nome) ? $tamanho->nome : old('nome')}}" class="form-campo" placeholder="Digite o nome da tamanho">
                    @if($errors->has('nome'))
					<div class="invalid-feedback">
						{{ $errors->first('nome') }}
					</div>
					@endif
                </div>
                <div class="col-12 mb-3">
                    <label class="text-label">Pedaços</label>	
                    <input type="text" name="pedacos" value="{{isset($tamanho->pedacos) ? $tamanho->pedacos : old('pedacos')}}" class="form-campo" placeholder="Digite o nome da tamanho">
                    @if($errors->has('pedacos'))
					<div class="invalid-feedback">
						{{ $errors->first('pedacos') }}
					</div>
					@endif
                </div>
                
              <div class="col-12 mb-3">
                    <label class="text-label">Maximo de sabores</label>	
                    <input type="text" name="maximo_sabores" value="{{isset($tamanho->maximo_sabores) ? $tamanho->maximo_sabores : old('maximo_sabores')}}" class="form-campo" placeholder="Digite o nome da tamanho">
                    @if($errors->has('maximo_sabores'))
					<div class="invalid-feedback">
						{{ $errors->first('maximo_sabores') }}
					</div>
					@endif
                </div>
               
          
                
                                       
                <div class="col-12 mt-3 mb-5">
                    <input type="submit" value="Salvar Dados" class="btn btn-laranja d-block m-auto">
                </div>
            </div>
        </form>
</div>
@endsection