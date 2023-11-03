@extends("Admin.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="fas fa-plus-circle"></i> Cadastrar Bairro</span>
 
 @if(isset($bairro))    
   <form action="{{route('admin.deliverybairro.update', $bairro->id)}}" method="POST" >
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.deliverybairro.store')}}" method="Post" >
@endif
	@csrf	
	
                                
            <div class="col-6 d-block m-auto rows px-5 py-5">
                <div class="col-12 mb-3">
                    <label class="text-label">Nome</label>	
                    <input type="text" name="nome" value="{{isset($bairro->nome) ? $bairro->nome : null}}" class="form-campo" placeholder="Digite o nome da bairro">
                    @if($errors->has('nome'))
					<div class="invalid-feedback">
						{{ $errors->first('nome') }}
					</div>
					@endif
                </div>
                <div class="col-12 mb-3">
                    <label class="text-label">Valor de Entrega</label>	
                    <input type="text" name="valor_entrega" value="{{isset($bairro->valor_entrega) ? $bairro->valor_entrega : null}}" class="form-campo" placeholder="Digite o nome da bairro">
                    @if($errors->has('valor_entrega'))
					<div class="invalid-feedback">
						{{ $errors->first('valor_entrega') }}
					</div>
					@endif
                </div>
                
              <div class="col-12 mb-3">
                    <label class="text-label">Valor de repasse(Opcional)</label>	
                    <input type="text" name="valor_repasse" value="{{isset($bairro->valor_repasse) ? $bairro->valor_repasse : null}}" class="form-campo" placeholder="Digite o nome da bairro">
                    @if($errors->has('valor_repasse'))
					<div class="invalid-feedback">
						{{ $errors->first('valor_repasse') }}
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