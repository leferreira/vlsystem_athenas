@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
                    <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
						<span class=""><i class="fas fa-plus-circle h5 mb-0"></i> Cadastrar tributação</span>
						<div>
							<a href="{{route('cadastro.tributacao.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>	
							<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>							
						</div>
					</div>
 @if(isset($categoria))    
   <form action="{{route('cadastro.categoria.update', $categoria->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('cadastro.categoria.store')}}" method="Post">
@endif
	@csrf
           <div class="col-8 d-block m-auto rows py-4">
				<fieldset class="py-md">
					<legend class="legenda">Inserir nova tributação</legend>
                    <label class="text-label">Nome</label>	
                    <input type="text" name="categoria" value="{{isset($categoria->categoria) ? $categoria->categoria : null}}" class="form-campo" placeholder="Digite o nome da categoria tributação">
               
                    <div class="mt-4">                   
						<input type="submit" value="Salvar Dados" class="btn btn-azul d-block m-auto">
					</div>
				</fieldset> 
			</div>
            </div>
        </form>
</div>
@endsection