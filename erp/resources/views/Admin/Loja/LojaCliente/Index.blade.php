@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
				<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Cliente da Loja </span>
				<div>
					<a href="" class="btn btn-laranja filtro ml-1 d-inline-block" title="Filtrar"><i class="fas fa-filter"></i> </a>
				</div>
			</div>
                     
				<div class="px-2 pt-2"> 
					<form  action="{{route('admin.lojacliente.filtro')}}" method="GET">
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
                            <th align="left" width="380">Cliente</th>
                            <th align="center">CPF</th>
                            <th align="center">Email</th>
                            <th align="center">Telefone</th>
                            <th align="center">Endereços</th>
                            <th align="center">Editar</th>                            
                            <th align="center">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $l)
						<tr>
							<td align="center">{{$l->id}}</td>
							<td align="left">{{$l->nome}} {{$l->sobre_nome}}</td>
							<td align="left">{{$l->cpf}}</td>
							<td align="center">{{$l->email}}</td>
							<td align="center">{{$l->telefone}}</td>
							<td align="center"><a href="{{route('admin.lojacliente.endereco', $l->id)}}" class="btn btn-roxo d-inline-block btn-pequeno" title="Endereço"><i class="fas fa-map-marker-alt"></i></a></td>
							<td align="center"><a href="{{route('admin.lojacliente.edit', $l->id)}}" class="btn btn-verde d-inline-block btn-pequeno" title="Editar"><i class="fas fa-edit"></i></a></td>
							<td align="center">
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$l->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.lojacliente.destroy', $l->id)}}" method="POST" id="apagar{{$l->id}}">
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