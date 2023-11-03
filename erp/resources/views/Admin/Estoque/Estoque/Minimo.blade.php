@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle  mb-0 h5"><i class="far fa-list-alt mr-1"></i> Lista de produto </span></span>
				<div>
					<a href="{{route('admin.produto.create')}}" class="btn btn-azul d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
					<a href="" class="btn btn-laranja filtro ml-1 d-inline-block" title="Filtrar"><i class="fas fa-filter"></i> </a>
				</div>
			</div>
                     
				<div class="px-2 pt-2"> 
					<form  action="{{route('admin.produto.filtro')}}" method="GET">
					<div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
						 <div class="rows p-3">	
							<div class="col-6">
									<span class="text-label text-branco">Produto</span>
									<input type="text" name="nome" value="{{($filtro->nome) ?? null}}"  class="form-campo">
							</div>
							
							 <div class="col-2 pt-1 mt-1">
								  <input type="submit" value="Pesquisar" class="btn btn-azul text-uppercase">
							  </div>
						</div>								 
                    </div>								 
                     </form>
				</div>
            </div>		
    <div class="col">
        <div class="px-2 pb-4">
            <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                    <thead>
                            <tr>
                                    <th align="center">Id</th>
                                    <th align="left" width="380">Produto</th>
                                    <th align="center">Estoque</th>
                                    <th align="center">Estoque Grade</th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $e)
						<tr>
							<td align="center">{{$e->id}}</td>
							<td align="left">{{$e->nome}}</td>
							<td align="center">{{$e->quantidade}}</td>
							<td align="center">{{$e->qtde_grade}}</td>
								 
                            </tr>
					@endforeach
					</tbody>
			</table>   
	</div>
	</div>

							
	</div>
</div>

@endsection