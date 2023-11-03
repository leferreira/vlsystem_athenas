@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle  mb-0 h5"><i class="far fa-list-alt mr-1"></i> Lista de Grupo de Produto </span></span>
				<div>
					<a href="{{route('admin.grupoproduto.create')}}" class="btn btn-azul d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
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
    <div class="col-12">
        <div class="px-2 pb-4">
            <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                    <thead>
                            <tr>
                                    <th align="center">Id</th>
                                    <th align="left" width="380">Produto</th>
                                    <th align="center">Preço</th>
                                    <th align="center">Unidade</th>
                                    <th align="center">Vende Na Loja</th>
                                    <th align="center">Editar</th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $produto)
						<tr>
							<td align="center">{{$produto->id}}</td>
							<td align="left">{{$produto->nome}}</td>
							<td align="center">{{$produto->valor_venda}}</td>
							<td align="center">{{$produto->unidade}}</td>
							<td align="center">{{($produto->produto_loja=='S') ? 'Sim' : 'Não'}}</td>
							 
							<td align="center">
							<a href="{{route('admin.movimento.show', $produto->id)}}" class="btn btn-roxo d-inline-block"><i class="fas fa-layer-group" title="Històrico de mmovimentação"></i></a>
							
							<a href="{{route('admin.produto.edit', $produto->id)}}" class="btn btn-verde d-inline-block" title="Editar"><i class="fas fa-edit"></i> </a> 
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$produto->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.produto.destroy', $produto->id)}}" method="POST" id="apagar{{$produto->id}}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        {{csrf_field()}}
                                    </form>
                                 </td>						
                            </tr>
					@endforeach
					</tbody>
			</table>   
	</div>
	</div>
							
	</div>
</div>
@endsection