@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase h5 mb-0 text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Endereço do Cliente: <b class="text-vermelho"> {{$cliente->nome}} {{$cliente->sobre_nome}}</b> </span>
				<div>
					<a href="{{route('admin.loja.lojaenderecocliente.create')}}" class="btn btn-azul ml-1 d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
					<a href="" class="btn btn-laranja filtro ml-1 d-inline-block" title="Filtrar"><i class="fas fa-filter"></i> </a>
				</div>
			</div>
                     
				<div class="px-2 pt-2"> 
					<form  action="{{route('admin.loja.lojacliente.filtro')}}" method="GET">
					<div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
						 <div class="rows p-3">	
							<div class="col-6">
									<span class="text-label text-branco">Cliente</span>
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
                            <th align="left" width="380">Logradouro</th>
                            <th align="center">Número</th>
                            <th align="center">Bairro</th>
                            <th align="center">Cidade</th>
                            <th align="center">UF</th>
                            <th align="center">CEP</th>
                            <th align="center">Editar</th>
                            <th align="center">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $l)
						<tr>
							<td align="center">{{$l->id}}</td>
							<td align="left">{{$l->rua}}</td>
							<td align="left">{{$l->numero}}</td>
							<td align="center">{{$l->bairro}}</td>
							<td align="center">{{$l->cidade}}</td>
							<td align="center">{{$l->uf}}</td>
							<td align="center">{{$l->cep}}</td>
							<td align="center"><a href="{{route('admin.loja.lojaenderecocliente.edit', $l->id)}}" class="btn btn-verde d-inline-block btn-pequeno" title="Editar"><i class="fas fa-edit"></i></a></td>
							<td align="center">
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$l->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.loja.lojaenderecocliente.destroy', $l->id)}}" method="POST" id="apagar{{$l->id}}">
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