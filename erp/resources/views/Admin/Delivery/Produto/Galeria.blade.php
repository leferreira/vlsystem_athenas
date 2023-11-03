@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="fas fa-plus-circle"></i> Galeria do Produto <span class="text-vermelho">Produto teste</span></span>
 
                      
	<form action="{{route('admin.deliveryproduto.salvarImagem')}}" method="Post" enctype="multipart/form-data">

	@csrf	

            <input type="hidden" name="id" value="{{ $produto->id }}">                    
            <div class="col-6 d-block m-auto py-5">                
            <div class="rows">              
               
						<div class="col-12 card pt-3">
							<!--<span class="d-block text-left mb-2">Imagem</span>-->
							<div class="file" id="kt_image_1">
									<i class="fa fa-pencil icon-sm text-muted d-none"></i>
									<input type="file" name="file" accept=".png, .jpg, .jpeg" id="imagem">
									<input type="hidden" name="profile_avatar_remove">
									<label data-action="change" data-toggle="tooltip" data-original-title="Change avatar" for="imagem">Selecionar imagem</label>
															
							</div>

							<span class="d-block text-label text-muted mt-3">Tipos de arquivos <b>(.png, .jpg, .jpeg)</p></span>
							@if($errors->has('file'))
							<span class="text-danger">{{ $errors->first('file') }}</span>
							@endif 
							<div class="col-12 mt-3 mb-3">
								<input type="submit" value="Salvar Dados" class="btn btn-azul d-block m-auto">
							</div>
						</div>      
               
            </div>
            </div>
        </form>
        
        
        <div class="rows">
        <div class="col-12 px-4 pb-5">
        <div class="card galeria">
				<div class="card-body">
					@if(sizeof($imagens) > 0)
					<div class="rows">

						@foreach($imagens as $v => $g)
						<div class="col-3 d-flex">
							<!--begin::Card-->
							<div class="card">
							<div class="card-stretch">
								<img src="{{asset($g->img)}}" class="img-fluido">								
								<a href="{{route('admin.deliveryproduto.excluirImagem',$g->id)}}" class="btn btn-vermelho btn-circulo" title="Remover">
									<i class="fas fa-trash"></i>
								</a>
							</div>
								<p class="text-info">Imagem {{$v+1}}</p>
							</div>
						</div>

						@endforeach
					</div>
					@else
					<h4 class="text-danger text-center">
						<img src="{{asset('storage/upload/no_image.png')}}" alt="image"  class="img-fluido"><br>
						<span class="text-vermelho d-block mt-2 mb-2">Nenhum imagem cadastrada</span>
					</h4>
					@endif
				</div>
		</div>
		</div>
		</div>
			
</div>
@endsection