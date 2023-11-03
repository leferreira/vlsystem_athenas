@extends("templates.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="fas fa-plus-circle"></i> Cadastrar usuario</span>
 
 @if(isset($usuario))    
   <form action="{{route('usuario.update', $usuario->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('usuario.store')}}" method="Post">
@endif
	@csrf
            <div class="col-6 d-block m-auto rows px-5 py-5">
                <div class="col-12 mb-3">
                    <label class="text-label">Nome</label>	
                    <input type="text" name="name" value="{{isset($usuario->name) ? $usuario->name : old('name')}}" class="form-campo">
                </div>
                <div class="col-12 mb-3">
                    <label class="text-label">Email</label>	
                    <input type="text" name="email" value="{{isset($usuario->email) ? $usuario->email : old('email')}}" class="form-campo">
                </div>
                                                   
                <div class="col-12 mt-3 mb-5">
                    <input type="submit" value="Salvar Dados" class="btn btn-laranja d-block m-auto">
                </div>
            </div>
        </form>
</div>
@endsection