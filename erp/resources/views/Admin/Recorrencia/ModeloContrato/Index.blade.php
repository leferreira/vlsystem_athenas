@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle  h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de Modelo De Contrato </span>
				<div>
					<a href="{{route('admin.modelocontrato.create')}}" class="btn btn-azul ml-1 d-inline-block" title=" Adicionar novo"><i class="fas fa-plus-circle"></i></a>
				</div>
			</div>                     
				
            </div>		
    <div class="col">
        <div class="px-2 pb-4">
            <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                    <thead>
                            <tr>
                                    <th align="center">Id</th>
                                    <th align="left" >Título</th>
                                    <th align="center">Status</th>
                                    <th align="center">Editar</th>
                                    <th align="center">Excluir</th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $l)
						<tr>
							<td align="center">{{$l->id}}</td>
							<td align="left">{{$l->nome}}</td>
							<td align="center">{{$l->status->status}}</td>
							<td align="center"><a href="{{route('admin.modelocontrato.edit', $l->id)}}" class="d-inline-block btn btn-verde btn-circulo btn-pequeno" title="Editar"><i class="fas fa-edit"></i></td>
							 <td align="center">
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$l->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.modelocontrato.destroy', $l->id)}}" method="POST" id="apagar{{$l->id}}">
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
var modelocontrato_id = 0;
function abrir_opcoes_modelocontrato(id){
	modelocontrato_id = id;
	$("#id_modelocontrato").html(id);
	mostrar_opcoes('opcoes_modelocontrato')
	
}

function verMovimento(){	
	giraGira();
	location.href = base_url + "admin/modelocontrato/movimento/" + modelocontrato_id;
}

function editar(){	
	giraGira();
	location.href = base_url + "admin/modelocontrato/" + modelocontrato_id + "/edit";
}

function excluir(){
    if (confirm('Tem Certeza?')){
    	
    }	
}

function fechar_opcoes_modelocontrato(){
	esconder_opcoes('opcoes_modelocontrato');
}
</script>
@endsection