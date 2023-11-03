@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i>Lista de Permissões da Função: {{$funcao->nome}}</span>
	<div class="d-flex">
		<a href="{{route('admin.usuario.index')}}" class="btn btn-azul btn-pequeno ml-1" title="Voltar">Lista Usuarios</a>
		<a href="{{route('admin.funcao.vincular', $funcao->id)}}" class="btn btn-pequeno btn-roxo ml-1" title="Ver menu">Vincular Permissões</a>
	
	</div>
</span> 

<div class="rows">	
                

		    <div class="col-12">
        <div class="px-2 pb-4">
            <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                    <thead>
                            <tr>
                                    <th align="center">Id</th>
                                    <th align="left" >Permissao</th>
                                    <th align="center">Funcao</th>
                                    <th align="center">Excluir</th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($funcao_permissoes as $p)
						<tr>
							<td align="center">{{$p->id}}</td>
							<td align="left">{{$p->permissao->permissao}}</td>
							<td align="center">{{$p->funcao->nome}}</td>
							
							
							 <td align="center">
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$p->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.funcaopermissao.destroy', $p->id)}}" method="POST" id="apagar{{$p->id}}">
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