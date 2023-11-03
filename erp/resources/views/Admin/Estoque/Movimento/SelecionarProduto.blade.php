@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle  mb-0 h5"><i class="far fa-list-alt mr-1"></i> Lista de produto </span>				
			</div>
                     
				<div class="px-2 pt-2"> 
					<form  action="{{route('admin.produto.filtro')}}" method="GET">
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
                                      	<option value="{{$cat->id}}" {{($cat->id == $id_categoria) ? 'selected': ''}}>{{$cat->categoria}}</option>
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
    <div class="col">
        <div class="px-2 pb-4">
            <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                    <thead>
                            <tr>
                                    <th align="center">Id</th>
                                    <th align="left" width="380">Produto</th>
                                    <th align="center">Preço</th>
                                    <th align="center">Unidade</th>
                                    <th align="center">Vende Na Loja</th>
                                    <th align="center">Selecionar</th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($produtos as $produto)
						<tr>
							<td align="center">{{$produto->id}}</td>
							<td align="left">{{$produto->nome}}</td>
							<td align="center">{{$produto->valor_venda}}</td>
							<td align="center">{{$produto->unidade}}</td>
							<td align="center">{{($produto->produto_loja=='S') ? 'Sim' : 'Não'}}</td>
							<td align="center"><a href="{{route('admin.movimento.show', $produto->id)}}">Ver Estoque</a></td>
							
					@endforeach
					</tbody>
			</table>   
	</div>
	</div>

							
	</div>
</div>
@endsection