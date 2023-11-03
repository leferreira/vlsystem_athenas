@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i>Vincular Permissões à função Função: {{$funcao->nome}}</span>
	<div class="d-flex">
		<a href="{{route('admin.usuario.index')}}" class="btn btn-azul btn-pequeno ml-1" title="Voltar">Lista Usuarios</a>
	
	</div>
</span>

<div class="rows">

		    <div class="col-12">
		    <form action="{{ route('admin.funcao.vincularPermissao', $funcao->id) }}" method="POST">
				@csrf
        <div class="px-2 pb-4">
            <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                    <thead>
                            <tr>
                                 <th class="text-center" width="70px">#marcar</th>
                                <th class="text-left" >Permissao</th>
                                <th class="text-left" >Descrição</th>
                            </tr>
                    </thead>
                    <tbody>	
                   @foreach($lista as $p)
						<tr>
							<td class="text-center check"><input type="checkbox" name="permissoes[]" value="{{ $p->id }}" id="{{ $p->id }}"></td>
							<td class="text-left"><label for="{{ $p->id }}">{{$p->permissao}}</label></td>
                          	<td class="text-left"><label for="{{ $p->id }}">{{$p->descricao}}</label></td>
						</tr>
					@endforeach
					</tbody>
			</table> 
			<div class="col-2">
				<input type="submit" class="btn btn-verde width-100" value="Vincular">
			</div>  
	</div>
	</form>
			</div>

        </div>
        </div>
        @endsection