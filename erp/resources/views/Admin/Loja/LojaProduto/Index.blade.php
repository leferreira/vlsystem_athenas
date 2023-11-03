@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Produto da Loja </span></span>
				<div>
					<a href="{{route('admin.loja.lojaproduto.create')}}" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Adicionar novo</a>
					<a href="" class="btn btn-laranja filtro mx-1 d-inline-block"><i class="fas fa-filter"></i> Filtrar</a>
				</div>
			</div>
                     
				<div class="px-2 pt-2"> 
					<form  action="{{route('admin.loja.lojaproduto.filtro')}}" method="GET">
					<div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
						 <div class="rows p-3">	
							<div class="col-6">
									<span class="text-label text-branco">Produto</span>
									<input type="text" name="nome" value="{{($filtro->nome) ?? null}}"  class="form-campo">
							</div>
							<div class="col-4">
									<?php $id_categoria = ($filtro->categoria_id) ?? null ?>
									<span class="text-label text-branco">Categoria</span>
									<select class="form-campo" name="categoria_id">
									<option value="">Escolha uma Opção</option>
									@foreach($categorias as $cat)
                                      	<option value="{{$cat->id}}" {{($cat->id == $id_categoria) ? 'selected': ''}}>{{$cat->nome}}</option>
                                      @endforeach 
                                      </select>
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
                            <th align="center">Categoria</th>
                            <th align="center">Preço</th>
                            <th align="center">Unidade</th>
                            <th align="center">Estoque</th>
                            <th align="center">Editar</th>
                            <th align="center">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $l)
						<tr>
							<td align="center">{{$l->id}}</td>
							<td align="left">{{$l->produto->nome}}</td>
							<td align="left">{{$l->categoria->nome}}</td>
							<td align="center">{{number_format($l->produto->valor_venda, 2, ',', '.')}}</td>
							<td align="center">{{$l->produto->unidade}}</td>
							<td align="center">{{$l->produto->estoque_atual}}</td>
							<td align="center"><a href="{{route('admin.loja.lojaproduto.edit', $l->id)}}" class="btn btn-outline-roxo">Editar</a></td>
							 <td align="center">
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$l->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.loja.lojaproduto.destroy', $l->id)}}" method="POST" id="apagar{{$l->id}}">
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