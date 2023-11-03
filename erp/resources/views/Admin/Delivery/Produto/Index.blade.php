@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de produto </span></span>
				<div>
					<a href="{{route('admin.deliveryproduto.create')}}" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Adicionar novo</a>
					<a href="" class="btn btn-laranja filtro mx-1 d-inline-block"><i class="fas fa-filter"></i> Filtrar</a>
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
        <div class="px-2 pb-4">
            <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                    <thead>
                            <tr>
                                    <th align="center">Id</th>
                                    <th align="left" >Produto</th>
                                    <th align="center">Categoria</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Limite Diário</th>
                                    <th align="center">Total Imagens</th>
                                    <th align="center">Destaque</th>
                                    <th align="center">ativo Delivery</th>                                   
                                    <th align="center">Galeria</th>
                                    <th align="center">Adicionais</th>
                                    <th align="center">Editar</th>
                                    <th align="center">Excluir</th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($produtos as $p)
						<tr>
							<td align="center">{{$p->id}}</td>
							<td align="left">{{$p->nome}}</td>
							<td align="center">{{$p->categoria->nome}}</td>
							<td align="center">{{$p->valor}}</td>
							<td align="center">{{$p->limite_diario}}</td>
						<td align="center">{{$p->limite_diario}}</td>
							<td align="center"><input onclick="alterarDestaque({{$p->id}})" @if($p->destaque) checked @endif value="true" name="status" class="red-text" type="checkbox">
												<span class="lever"></span></td>
							<td align="center"><input onclick="alterarStatus({{$p->id}})" @if($p->status) checked @endif value="true" name="status" class="red-text" type="checkbox">
												<span class="lever"></span></td>
							
							<td align="center"><a href="{{route('admin.deliveryproduto.galeria', $p->id)}}" class="btn btn-outline-roxo">Galeria</a></td>
							<td align="center"><a href="{{route('admin.deliveryproduto.adicionais', $p->id)}}" class="btn btn-outline-roxo">Adicionais</a></td>
							<td align="center"><a href="{{route('admin.deliveryproduto.edit', $p->id)}}" class="btn btn-outline-verde">Editar</a></td>
							<td align="center">
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$p->id}}').submit() : '';" class="d-inline-block btn btn-circulo btn-vermelho btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.deliveryproduto.destroy', $p->id)}}" method="POST" id="apagar{{$p->id}}">
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