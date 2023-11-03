@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle h5 mb-0 "><i class="far fa-list-alt mr-1"></i> Lista de transportadora </span></span>
				<div>
					<a href="{{route('admin.transportadora.create')}}" class="btn btn-azul ml-1 d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
				</div>
			</div>
                     
				<div class="px-2 pt-2"> 
					<form name="busca" action="" method="GET">
					<div class=" bg-padrao mt-2 p-2 radius-4">
						 <div class="rows p-3">	
							<div class="col-4">
									<span class="text-label text-branco">Nome/Razão Social</span>
									<input type="text" name="nome" value="{{$filtro->nome ?? null}}"  class="form-campo">
							</div>
							
							<div class="col-3">
									<span class="text-label text-branco">Email</span>
									<input type="text" name="email" value="{{$filtro->email ?? null}}"  class="form-campo">
							</div>
							
							<div class="col-3">
									<span class="text-label text-branco">CNPJ</span>
									<input type="text" name="cnpj" value="{{$filtro->cnpj ?? null}}"  class="form-campo">
							</div>
						
							 <div class="col-2 pt-1 mt-1">
								  <input type="submit" value="Pesquisar" class="btn btn-azul width-100 text-uppercase">
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
                                    <th align="left" width="380">Razão Social</th>
                                    <th align="center">CNPJ</th>
                                    <th align="center">Email</th>
                                    <th align="center">Celular</th>
                                    <th align="center">Movimentos</th>
                                    <th align="center">Editar</th>
                                    
                                    <th align="center">Excluir</th>                                  
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $l)
						<tr>
							<td align="center">{{$l->id}}</td>
							<td align="left">{{$l->razao_social}}</td>
							<td align="center">{{$l->cnpj}}</td>
							<td align="center">{{$l->email}}</td>
							<td align="center">{{$l->celular}}</td>
							<td align="center"><a href="{{route('admin.transportadora.movimento', $l->id)}}"   title="Editar">Movimentos</a></td>
							<td align="center"><a href="{{route('admin.transportadora.edit', $l->id)}}"  class="d-inline-block btn btn-verde btn-circulo btn-pequeno" title="Editar"><i class="fas fa-edit"></i></a></td>
							 <td align="center">
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$l->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.transportadora.destroy', $l->id)}}" method="POST" id="apagar{{$l->id}}">
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
var transportadora_id = 0;
function abrir_opcoes_transportadora(id){
	transportadora_id = id;
	$("#id_transportadora").html(id);
	mostrar_opcoes('opcoes_transportadora')
	
}

function verMovimento(){	
	giraGira();
	location.href = base_url + "admin/transportadora/movimento/" + transportadora_id;
}

function editar(){	
	giraGira();
	location.href = base_url + "admin/transportadora/" + transportadora_id + "/edit";
}

function excluir(){
    if (confirm('Tem Certeza?')){
    	
    }	
}

function fechar_opcoes_transportadora(){
	esconder_opcoes('opcoes_transportadora');
}
</script>
@endsection