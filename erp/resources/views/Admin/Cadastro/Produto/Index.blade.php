@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle  mb-0 h5"><i class="far fa-list-alt mr-1"></i> Lista de produto </span></span>
				<div>
					<a href="{{route('admin.produto.create')}}" class="btn btn-azul d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
				</div>
			</div>
                     
				<div class="px-2 pt-2"> 
					<form  action="" method="GET">
					<div class=" bg-padrao mt-2 p-2 radius-4">
						 <div class="rows p-3">	
							<div class="col-6">
									<span class="text-label text-branco">Produto</span>
									<input type="text" name="nome" value="{{($filtro->nome) ?? null}}"  class="form-campo">
							</div>
							<div class="col-4">
									<?php $id_categoria = ($filtro->categoria_id) ?? null ?>
									<span class="text-label text-branco">Categoria</span>
									<select class="form-campo" name="categoria_id">
									<option value="">Escolha uma Opção</option>
									@foreach($categorias as $cat)
                                      	<option value="{{$cat->id}}" {{($cat->id == $id_categoria) ? 'selected': ''}}>{{$cat->categoria}}</option>
                                      @endforeach 
                                      </select>
							</div>
							 <div class="col-2 pt-1 mt-1">
								  <input type="submit" value="Pesquisar" class="btn btn-azul text-uppercase">
							  </div>
						</div>								 
                    </div>								 
                     </form>
				</div>
            </div>		
    <div class="col">
        <div class="px-2 pb-4">
            <table cellpadding="0" cellspacing="0" class="table mt-2" width="100%">
                    <thead>
                            <tr>
                                    <th align="center">Id</th>
                                    <th align="left" width="380">Produto</th>
                                    <th align="center">Preço</th>
                                    <th align="center">Unidade</th>
                                    <th align="center">Vende Na Loja</th>
                                    <th align="center">Usa Grade</th>
                                    <th align="center">Estoque Atual</th>
                                    <th align="center"></th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($produtos as $produto)
						<tr>
							<td align="center">{{$produto->id}}</td>
							<td align="left">{{$produto->nome}}</td>
							<td align="center">{{$produto->valor_venda}}</td>
							<td align="center">{{$produto->unidade}}</td>
							<td align="center">{{($produto->produto_loja=='S') ? 'Sim' : 'Não'}}</td>
							<td align="center">{{($produto->usa_grade=='S') ? 'Sim' : 'Não'}}</td>
							<td align="center">{{$produto->estoque->quantidade ?? '--'}}</td>
							
                            <td align="center">
								<a href="javascript:;" onclick="abrir_opcoes_produto({{$produto->id}})" ><i class="ellipsis-vertical"></i></a>
							</td>	 
                            </tr>
					@endforeach
					</tbody>
			</table> 

			<div class="paginacao">
                {{ $produtos->links() }}
            </div>   
	</div>
					
	</div>
	
		<!-- MOSTRA AS OPÇÕES  MostraOpcoes --->
		<div class="col-2 MostraOpcoes sm-mx" id="opcoes_produto">
		
			<ul class="cx-opcoes" >
				<li class="titulo bg-padrao text-branco d-flex center-middle justify-content-space-between">
					<span>Produto: <span id="id_produto"></span> </span> 
					<a href="javascript:;" onClick="fechar_opcoes_produto()" title="Fechar Opções" class="text-vermelho position-inherit p-0"><i class="fas fa-times position-inherit"></i></a>
				</li>
				
				<li><a href="javascript:;" onClick="verEstoque()" title="Gerar Nota Fiscal"><i class="fas fa-layer-group"></i> Movimentação de Estoque</a></li>
				<li><a href="javascript:;" onClick="clonarProduto()" title="Gerar Nota Fiscal"><i class="fas fa-layer-group"></i> Clonar Produto</a></li>
				<li><a href="javascript:;" onclick="editar()" class="" title="Visualizar Contas a Receber"><i class="fas fa-edit"></i> Editar</a></li>
				<li><a href="javascript:;" onclick="excluir()"><i class="fas fa-trash-alt"></i> Excluir</a></li>

			</ul>
		</div>
							
	</div>
</div>
<script>
var produto_id = 0;
function abrir_opcoes_produto(id){
	produto_id = id;
	$("#id_produto").html(id);
	mostrar_opcoes('opcoes_produto')
	
}

function verEstoque(){	
	giraGira();
	location.href = base_url + "admin/movimento/" + produto_id;
}

function clonarProduto(){	
	giraGira();
	location.href = base_url + "admin/produto/clonarProduto/" + produto_id;
}

function editar(){	
	giraGira();
	location.href = base_url + "admin/produto/" + produto_id + "/edit";
}

function excluir(){
    if (confirm('Tem Certeza?')){
    	
    }	
}

function fechar_opcoes_produto(){
	esconder_opcoes('opcoes_produto');
}
</script>
@endsection