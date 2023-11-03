@extends("templates.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="fas fa-plus-circle"></i> Cadastrar categoria</span>
 
 @if(isset($categoria))    
   <form action="{{route('categoriaadicional.update', $categoria->id)}}" method="POST" >
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('categoriaadicional.store')}}" method="Post" >
@endif
	@csrf	
	
                                
            <div class="col-6 d-block m-auto rows px-5 py-5">
                <div class="col-12 mb-3">
                    <label class="text-label">Nome</label>	
                    <input type="text" name="nome" value="{{isset($categoria->nome) ? $categoria->nome : null}}" class="form-campo" placeholder="Digite o nome da categoria">
                    @if($errors->has('nome'))
					<div class="invalid-feedback">
						{{ $errors->first('nome') }}
					</div>
					@endif
                </div>
                <div class="col-12 mb-3">
                    <label class="text-label">Limite de Escolha </label>	
                    <input type="text" name="limite_escolha" value="{{isset($categoria->limite_escolha) ? $categoria->limite_escolha : null}}" class="form-campo" placeholder="Digite o nome da categoria">
                    @if($errors->has('limite_escolha'))
					<div class="invalid-feedback">
						{{ $errors->first('limite_escolha') }}
					</div>
					@endif
                </div>
                
                <div class="col-12 mb-3">
                    <label class="text-label">Adicional R$: </label>	
					<input @if(isset($categoria->adicional) && $categoria->adicional) checked @endisset value="true" name="adicional" class="red-text" type="checkbox">
                   
                </div>
               
          
                
                                       
                <div class="col-12 mt-3 mb-5">
                    <input type="submit" value="Salvar Dados" class="btn btn-laranja d-block m-auto">
                </div>
            </div>
        </form>
</div>
@endsection