@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
			<div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
						<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de banners da Loja</span>
						<div class="">
							<a href="{{route('admin.lojabanner.create')}}" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Adicionar novo</a>
						</div>
					</div>
			
                     
				<div class="px-2 pt-2"> 
					<form name="busca" action="" method="GET">
					<div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
						 <div class="rows p-3">	
							<div class="col-6">
									<span class="text-label text-branco">Produto</span>
									<input type="text" name="produto" value="" placeholder="Digite aqui..." class="form-campo">
							</div>
							<div class="col-4">
									<span class="text-label text-branco">Categoria</span>
									<select class="form-campo" name="idCategoria">
									<option value="">Escolha uma Opção</option>
									<option value="1">Panela</option><option value="2">Cuzcuzeira</option><option value="3">Copo</option><option value="4">Caneca</option><option value="5">Papeiro</option><option value="6">Leiteira</option><option value="7">Frigideira</option><option value="8">Bacia</option><option value="9">Balde</option><option value="10">Assadeira</option><option value="11">Baquelite</option><option value="12">yyy</option>                                         </select>
							</div>
							 <div class="col-2 pt-1 mt-1">
								  <input type="submit" value="Pesquisar" class="btn btn-laranja text-uppercase">
							  </div>
						</div>								 
                    </div>								 
                     </form>
				</div>
            </div>		
  
	
    <div class="col-12">
        <div class="p-2 px-md pb-4 lista-banner">
			<div class="rows rows2">
		@if(count($lista) >0)				
			@foreach($lista as $l)
			
				<div class="col-3 mb-3">
					<div class="card">
						<div class="thumb">								
							<img src="{{ url($l->path) }}" class="img-fluido">
						</div>
						<div class="tfooter between ">
							<p>{{$l->titulo}}</p>
							<div>
								<a href="{{route('admin.lojabanner.edit', $l->id)}}" class="fas fa-edit btn btn-circulo btn-verde" title="Editar banner"></a>
								<a href="javascript:;" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$l->id}}').submit() : '';" class="far fa-trash-alt btn btn-circulo btn-vermelho" title="Excluir banner"></a>
                                <form action="{{route('admin.lojabanner.destroy', $l->id)}}" method="POST" id="apagar{{$l->id}}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    {{csrf_field()}}
                                </form>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		 @else			
				<div class="col-12 mb-3 text-center">
					<a href="{{route('admin.lojabanner.create')}}"><img src="{{asset('assets/admin/img/sembanner.svg')}}" class="img-fluido"></a>
				</div>
		@endif
			</div>
		</div>
	</div>
							
	</div>
</div>
@endsection