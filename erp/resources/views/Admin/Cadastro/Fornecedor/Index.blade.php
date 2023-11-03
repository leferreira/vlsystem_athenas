@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle h5 mb-0 "><i class="far fa-list-alt mr-1"></i> Lista de fornecedor </span></span>
				<div>
					<a href="{{route('admin.fornecedor.create')}}" class="btn btn-azul ml-1 d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
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
                                    <th align="center">Editar</th>
                                    <th align="center">Excluir</th>
                                     <th align="center">Opções</th>
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
							<td align="center"><a href="{{route('admin.fornecedor.edit', $l->id)}}" class="d-inline-block btn btn-verde btn-circulo btn-pequeno" title="Editar"><i class="fas fa-edit"></i></a></td>
							 <td align="center">
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$l->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.fornecedor.destroy', $l->id)}}" method="POST" id="apagar{{$l->id}}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        {{csrf_field()}}
                                    </form>
                                 </td>
                            <td align="center">
								<a href="javascript:;" onclick="abrir_opcoes_fornecedores({{$l->id}})" ><i class="ellipsis-vertical"></i></a>
							</td>							
                            </tr>
					@endforeach
					</tbody>
			</table>   
	</div>
								
								<!-- qunado não hover pedido 
								
								<div class="caixa p-2">
									<div class="msg msg-verde">
									<p><b><i class="fas fa-check"></i> Mensagem de boas vindas</b> Parabéns seu fornecedor foi inserido com sucesso</p>
									</div>
									<div class="msg msg-vermelho">
									<p><b><i class="fas fa-times"></i> Mensagem de Erro</b> Houve um erro</p>
									</div>
									<div class="msg msg-amarelo">
									<p><b><i class="fas fa-exclamation-triangle"></i> Mensagem de aviso</b> Tem um aviso pra você</p>
									</div>
								</div>
								-->
	</div>
	
	
		<!-- MOSTRA AS OPÇÕES  MostraOpcoes --->
		<div class="col-2 MostraOpcoes sm-mx" id="opcoes_fornecedores">
		
			<ul class="cx-opcoes" >
				<li class="titulo bg-padrao text-branco d-flex center-middle justify-content-space-between">
					<span>Fornecedor: <span id="id_fornecedor"></span> </span> 
					<a href="javascript:;" onClick="fechar_opcoes_fornecedores()" title="Fechar Opções" class="text-vermelho position-inherit p-0"><i class="fas fa-times position-inherit"></i></a>
				</li>
				
				<!--<li><a href="javascript:;" onClick="verMovimento()" title="Gerar Nota Fiscal"><i class="fas fa-layer-group"></i> Movimentações do Fornecedor</a></li>-->
				<li><a href="javascript:;" onclick="editar()" class="" title="Visualizar Contas a Receber"><i class="fas fa-edit"></i> Editar</a></li>
				<li><a href="javascript:;" onclick="excluir()"><i class="fas fa-trash-alt"></i> Excluir</a></li>
					
			<!-- AQUI AS DIVISÕES COM CATEGORIAS---
				<li class="titulo text-escuro pt-4 border-0">Subcat 01</li>
				<li class="ml-3 mr-3"><a href="javascript:;" onClick="salvarNfePorVenda()" title="Gerar Nota Fiscal"><i class="fas fa-arrow-right"></i> Gerar Nota Fiscal</a></li>
				<li class="ml-3 mr-3"><a href="javascript:;" onclick="verContaReceber()" class="" title="Visualizar Contas a Receber"><i class="fas fa-arrow-right"></i> Ver Contas a Receber</a></li>
				<li class="ml-3 mr-3"><a href="javascript:;" onclick="verDetalhe()"><i class="fas fa-arrow-right"></i> Ver Detalhes</a></li>
										

				<li class="titulo text-escuro pt-4 border-0">Subcat 02</li>
				<li class="ml-3 mr-3"><a href="javascript:;" onClick="salvarNfePorVenda()" title="Gerar Nota Fiscal"><i class="fas fa-arrow-right"></i> Gerar Nota Fiscal</a></li>
				<li class="ml-3 mr-3"><a href="javascript:;" onclick="verContaReceber()" class="" title="Visualizar Contas a Receber"><i class="fas fa-arrow-right"></i> Ver Contas a Receber</a></li>
				<li class="ml-3 mr-3"><a href="javascript:;" onclick="verDetalhe()"><i class="fas fa-arrow-right"></i> Ver Detalhes</a></li>
				
-->				

			</ul>
		</div>
							
	</div>
</div>
<script>
var fornecedor_id = 0;
function abrir_opcoes_fornecedores(id){
	fornecedor_id = id;
	$("#id_fornecedor").html(id);
	mostrar_opcoes('opcoes_fornecedores')
	
}

function verMovimento(){	
	giraGira();
	location.href = base_url + "admin/fornecedor/movimento/" + fornecedor_id;
}

function editar(){	
	giraGira();
	location.href = base_url + "admin/fornecedor/" + fornecedor_id + "/edit";
}

function excluir(){
    if (confirm('Tem Certeza?')){
    	
    }	
}

function fechar_opcoes_fornecedores(){
	esconder_opcoes('opcoes_fornecedores');
}
</script>
@endsection