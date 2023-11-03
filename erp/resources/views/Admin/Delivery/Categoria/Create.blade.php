@extends("Admin.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="fas fa-plus-circle"></i> Cadastrar categoria</span>
 
 @if(isset($categoria))    
   <form action="{{route('admin.deliverycategoria.update', $categoria->id)}}" method="POST" enctype="multipart/form-data">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.deliverycategoria.store')}}" method="Post" enctype="multipart/form-data">
@endif
	@csrf
	
	 @php
    	$imagem = isset($categoria->path) ? $categoria->path: 'no_image.png';
    @endphp
                                
            <div class="col-6 d-block m-auto  px-5 py-5">
            <div class="rows">
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
                    <label class="text-label">Descrição: </label>	
                    <input type="text" name="descricao" value="{{isset($categoria->descricao) ? $categoria->descricao : null}}" class="form-campo" placeholder="Digite o nome da categoria">
                    @if($errors->has('descricao'))
					<div class="invalid-feedback">
						{{ $errors->first('descricao') }}
					</div>
					@endif
                </div>
                <div class="col-4 mb-3">
                		<label for="imagem"><img src="{{asset('storage/upload/imagens_categorias/'.$imagem)}}" class="img-fluido opaco"></label>
                </div>
                
                
                <div class="col-8 mb-3">
                	<div class="form-group row">
						<label class="col-xl-12 col-lg-12 col-form-label text-left">Imagem</label>
						<div class="col-lg-10 col-xl-6">

							<div class="image-input image-input-outline file mb-2" id="kt_image_1">
								<div class="image-input-wrapper" @if(isset($categoria) && file_exists('imagens_categorias/'.$categoria->path)) style="background-image: url(/imagens_categorias/{{$categoria->path}})" @else style="background-image: url(/imgs/no_image.png)" @endif></div>
								
									<i class="fas fa-pencil icon-sm text-muted d-none"></i>
									<input type="file" name="file" accept=".png, .jpg, .jpeg" id="imagem">
									<input type="hidden" name="profile_avatar_remove">
									<label data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar" for="imagem">Selecionar imagem	</label>
								<span class="" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar">
									<i class="fa fa-close icon-xs text-muted d-none"></i>
								</span>
							</div>


							<span class="form-text text-muted">.png, .jpg, .jpeg</span>
							@if($errors->has('file'))
							<span class="text-danger">{{ $errors->first('file') }}</span>
							@endif
						</div>
					</div>
                </div>
                
                                       
                <div class="col-12 mt-3 mb-5">
                    <input type="submit" value="Salvar Dados" class="btn btn-azul d-block m-auto">
                </div>
            </div>
            </div>
        </form>
</div>
@endsection