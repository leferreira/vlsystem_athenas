@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle  h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de cliente Recorrentes</span></span>
				<div>
				
					<a href="{{route('admin.cliente.create')}}" class="btn btn-azul ml-1 d-inline-block" title=" Adicionar novo"><i class="fas fa-plus-circle"></i></a>
				</div>
			</div>
                     
			
            </div>		
    <div class="col">
        <div class="px-2 pb-4">
            <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                    <thead>
                            <tr>
                                    <th align="center">Id</th>
                                    <th align="left" width="380">Razão Social</th>
                                    <th align="center">CNPJ</th>
                                    <th align="center">Email</th>
                                    <th align="center">Celular</th>
                                    <th align="center">Editar</th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $l)
						<tr>
							<td align="center">{{$l->cliente->id}}</td>
							<td align="left">{{$l->cliente->nome_razao_social}}</td>
							<td align="center">{{$l->cliente->cpf_cnpj}}</td>
							<td align="center">{{$l->cliente->email}}</td>
							<td align="center">{{$l->cliente->celular}}</td>
							<td align="center">
							<a href="{{route('admin.clienterecorrente.cobrancas', $l->cliente->id)}}" >Ver Cobranças</a></td>
							
                            					
                            </tr>
					@endforeach
					</tbody>
			</table>   
	</div>
					
	</div>
							
	</div>
</div>
<script>
var cliente_id = 0;
function abrir_opcoes_cliente(id){
	cliente_id = id;
	$("#id_cliente").html(id);
	mostrar_opcoes('opcoes_cliente')
	
}

function verEndereco(){	
	giraGira();
	location.href = base_url + "admin/cliente/endereco/" + cliente_id;
}

function verMovimento(){	
	giraGira();
	location.href = base_url + "admin/cliente/movimento/" + cliente_id;
}

function editar(){	
	giraGira();
	location.href = base_url + "admin/cliente/" + cliente_id + "/edit";
}

function excluir(){
    if (confirm('Tem Certeza?')){
    	
    }	
}

function fechar_opcoes_cliente(){
	esconder_opcoes('opcoes_cliente');
}
</script>
@endsection