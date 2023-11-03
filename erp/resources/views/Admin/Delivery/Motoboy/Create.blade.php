@extends("admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="fas fa-plus-circle"></i> Cadastrar motoboy</span>
 
 @if(isset($motoboy))    
   <form action="{{route('admin.deliverymotoboy.update', $motoboy->id)}}" method="POST" >
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.deliverymotoboy.store')}}" method="Post" >
@endif
	@csrf	
	
                                
            <div class="rows px-5 py-5">
                <div class="col-12 mb-3">
                    <label class="text-label">Nome</label>	
                    <input type="text" name="nome" value="{{isset($motoboy->nome) ? $motoboy->nome : null}}" class="form-campo" placeholder="Digite o nome da motoboy">
                    @if($errors->has('nome'))
					<div class="invalid-feedback">
						{{ $errors->first('nome') }}
					</div>
					@endif
                </div>
                <div class="col-12 mb-3">
                    <label class="text-label">Endereço</label>	
                    <input type="text" name="endereco" value="{{isset($motoboy->endereco) ? $motoboy->endereco : null}}" class="form-campo" placeholder="Digite o nome da motoboy">
                    @if($errors->has('endereco'))
					<div class="invalid-feedback">
						{{ $errors->first('endereco') }}
					</div>
					@endif
                </div>
                
              <div class="col-4 mb-3">
                    <label class="text-label">Telefone 1</label>	
                    <input type="text" name="telefone1" value="{{isset($motoboy->telefone1) ? $motoboy->telefone1 : null}}" class="form-campo" placeholder="Digite o nome da motoboy">
                    @if($errors->has('telefone1'))
					<div class="invalid-feedback">
						{{ $errors->first('telefone1') }}
					</div>
					@endif
                </div>
              
              <div class="col-4 mb-3">
                    <label class="text-label">Telefone 2</label>	
                    <input type="text" name="telefone2" value="{{isset($motoboy->telefone2) ? $motoboy->telefone2 : null}}" class="form-campo" placeholder="Digite o nome da motoboy">
                    @if($errors->has('telefone2'))
					<div class="invalid-feedback">
						{{ $errors->first('telefone2') }}
					</div>
					@endif
                </div>
                
                <div class="col-4 mb-3">
                    <label class="text-label">Telefone 3</label>	
                    <input type="text" name="telefone3" value="{{isset($motoboy->telefone3) ? $motoboy->telefone3 : null}}" class="form-campo" placeholder="Digite o nome da motoboy">
                    @if($errors->has('telefone3'))
					<div class="invalid-feedback">
						{{ $errors->first('telefone3') }}
					</div>
					@endif
                </div>
                
                
                <div class="col-4 mb-3">
                    <label class="text-label">CPF</label>	
                    <input type="text" name="cpf" value="{{isset($motoboy->cpf) ? $motoboy->cpf : null}}" class="form-campo" placeholder="Digite o nome da motoboy">
                    @if($errors->has('cpf'))
					<div class="invalid-feedback">
						{{ $errors->first('cpf') }}
					</div>
					@endif
                </div> 
          
           		<div class="col-4 mb-3">
                    <label class="text-label">RG</label>	
                    <input type="text" name="rg" value="{{isset($motoboy->rg) ? $motoboy->rg : null}}" class="form-campo" placeholder="Digite o nome da motoboy">
                    @if($errors->has('rg'))
					<div class="invalid-feedback">
						{{ $errors->first('rg') }}
					</div>
					@endif
                </div>
                
                 <div class="col-4 mb-3">
                    <label class="text-label">Tipo de transporte</label>	
                    <select class="form-campo" name="tipo_transporte">
						@foreach(\App\Models\Motoboy::tiposTransporte() as $tp)
						<option value="{{$tp}}">{{$tp}}</option>
						@endforeach
					</select>
					@if($errors->has('cpf'))
					<div class="invalid-feedback">
						{{ $errors->first('cpf') }}
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