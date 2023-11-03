@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle  mb-0 h5"><i class="far fa-list-alt mr-1"></i> Lista de servico </span>
				<div>
					<a href="{{route('admin.servico.create')}}" class="btn btn-azul d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
				</div>
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
                                    <th align="center">Editar</th>
                                    <th align="center">Excluir</th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($servicos as $servico)
						<tr>
							<td align="center">{{$servico->id}}</td>
							<td align="left">{{$servico->nome}}</td>
							<td align="center">{{$servico->valor_venda}}</td>
							
                            <td align="center"><a href="{{route('admin.servico.edit', $servico->id)}}" class="d-inline-block btn btn-circulo btn-verde btn-pequeno" title="Editar"><i class="fas fa-edit"></i></a>  </td>									
                                <td align="center">

                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$servico->id}}').submit() : '';" class="d-inline-block btn btn-circulo btn-vermelho btn-pequeno" title="Ecluir"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.servico.destroy', $servico->id)}}" method="POST" id="apagar{{$servico->id}}">
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
<script>
var servico_id = 0;
function abrir_opcoes_servico(id){
	servico_id = id;
	$("#id_servico").html(id);
	mostrar_opcoes('opcoes_servico')
	
}

function verEstoque(){	
	giraGira();
	location.href = base_url + "admin/movimento/" + servico_id;
}

function editar(){	
	giraGira();
	location.href = base_url + "admin/servico/" + servico_id + "/edit";
}



function fechar_opcoes_servico(){
	esconder_opcoes('opcoes_servico');
}
</script>
@endsection