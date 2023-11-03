@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle  h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de cliente </span></span>
				<div>
				
					<a href="{{route('admin.cliente.create')}}" class="btn btn-azul ml-1 d-inline-block" title=" Adicionar novo"><i class="fas fa-plus-circle"></i></a>
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
									<span class="text-label text-branco">CPF/CNPJ</span>
									<input type="text" name="cpf" value="{{$filtro->cpf ?? null}}"  class="form-campo">
							</div>
							<div class="col-2">
									<span class="text-label text-branco">Tipo Cliente</span>
									<select class="form-campo" name="tipo_cliente">
    									<option value="">Escolha uma Opção</option>
    									<option value="F">Física</option>
    									<option value="J">Jurídica</option>
									</select>
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
                                    <th align="center">Editar</th>
                                    <th align="center">Excluir</th>
                                    <th align="center"></th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $l)
						<tr>
							<td align="center">{{$l->id}}</td>
							<td align="left">{{$l->nome_razao_social}}</td>
							<td align="center">{{$l->cpf_cnpj}}</td>
							<td align="center">{{$l->email}}</td>
							<td align="center">{{$l->celular}}</td>
							<td align="center"><a href="{{route('admin.cliente.edit', $l->id)}}" class="d-inline-block btn btn-verde btn-circulo btn-pequeno" title="Editar"><i class="fas fa-edit"></i></td>
							 <td align="center">
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$l->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.cliente.destroy', $l->id)}}" method="POST" id="apagar{{$l->id}}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        {{csrf_field()}}
                                    </form>
                                 </td>	
                            <td align="center">
										<a href="javascript:;" onclick="abrir_opcoes_cliente({{$l->id}})" ><i class="ellipsis-vertical"></i></a>
							</td>					
                            </tr>
					@endforeach
					</tbody>
			</table>   
	</div>
					
	</div>
		<!-- MOSTRA AS OPÇÕES  MostraOpcoes --->
		<div class="col-2 MostraOpcoes sm-mx" id="opcoes_cliente">
		
			<ul class="cx-opcoes" >
				<li class="titulo bg-padrao text-branco d-flex center-middle justify-content-space-between">
					<span>Cliente: <span id="id_cliente"></span> </span> 
					<a href="javascript:;" onClick="fechar_opcoes_cliente()" title="Fechar Opções" class="text-vermelho position-inherit p-0"><i class="fas fa-times position-inherit"></i></a>
				</li>
				
				<li><a href="javascript:;" onClick="verMovimento()" title="Gerar Nota Fiscal"><i class="fas fa-layer-group"></i> Movimentações do Cliente</a></li>
				<li><a href="javascript:;" onClick="verEndereco()" title="Gerar Nota Fiscal"><i class="fas fa-layer-group"></i> Endereços do Cliente</a></li>
				<li><a href="javascript:;" onclick="editar()" class="" title="Visualizar Contas a Receber"><i class="fas fa-edit"></i> Editar</a></li>
				<li><a href="javascript:;" onclick="excluir()"><i class="fas fa-trash-alt"></i> Excluir</a></li>
		

			</ul>
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