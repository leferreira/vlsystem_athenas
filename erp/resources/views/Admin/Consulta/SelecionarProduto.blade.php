@extends("Admin.template")
@section("conteudo")
<div class="col-12 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Consultas Produto </span>
						<div>
							<a href="{{route('admin.venda.create')}}" class="btn btn-azul ml-1 d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
						
						</div>
					</div>
                        
					<form name="busca" method="get">                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">							  			
                                        
                                      	
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Qual campo para filtro</label>
                                            <select class="form-campo" name="campo">
                                            	<option value="nome" {{($filtro->campo ?? null) == 'nome' ? 'selected' : '' }}>Nome</option>
                                            	<option value="tipo_produto" {{($filtro->campo ?? null) == 'tipo_produto' ? 'selected' : '' }}>Tipo Produto</option>
                                            	<option value="valor_venda" {{($filtro->campo ?? null) == 'valor_venda' ? 'selected' : '' }}>Valor</option>
                                            	<option value="categoria" {{($filtro->campo ?? null) == 'categoria' ? 'selected' : '' }}>Categoria</option>
                                            	<option value="subcategoria" {{($filtro->campo ?? null) == 'subcategoria' ? 'selected' : '' }}>SubCategoria</option>
                                            	<option value="subsubcategoria" {{($filtro->campo ?? null) == 'subsubcategoria' ? 'selected' : '' }}>SubSubCategoria</option>
                                            	<option value="fornecedor" {{($filtro->campo ?? null) == 'fornecedor' ? 'selected' : '' }}>Fornecedor</option>
                                            	<option value="ncm" {{($filtro->campo ?? null) == 'ncm' ? 'selected' : '' }}>NCM</option>
                                            	<option value="cest" {{($filtro->campo ?? null) == 'cest' ? 'selected' : '' }}>Cest</option>
                                            	<option value="altura" {{($filtro->campo ?? null) == 'altura' ? 'selected' : '' }}>Altura</option>
                                            	<option value="largura" {{($filtro->campo ?? null) == 'largura' ? 'selected' : '' }}>Largura</option>
                                            	<option value="peso" {{($filtro->campo ?? null) == 'peso' ? 'selected' : '' }}>Peso</option>
                                            	<option value="uuid" {{($filtro->campo ?? null) == 'uuid' ? 'selected' : '' }}>uuid</option>
                                            	<option value="origem" {{($filtro->campo ?? null) == 'origem' ? 'selected' : '' }}>Origem</option>
                                            	<option value="gtin" {{($filtro->campo ?? null) == 'gtin' ? 'selected' : '' }}>Gtin</option>
                                            	<option value="codigo_barra" {{($filtro->campo ?? null) == 'codigo_barra' ? 'selected' : '' }}>Código de Barra</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Qual Operador</label>
                                            <select class="form-campo" name="operador">
                                            	<option value="igual" {{($filtro->operador ?? null) == 'igual' ? 'selected' : '' }}>Igual</option>
                                            	<option value="like" {{($filtro->operador ?? null) == 'like' ? 'selected' : '' }}>Por parte</option>
                                            	<option value="diferente" {{($filtro->operador ?? null) == 'diferente' ? 'selected' : '' }}>Diferente</option>
                                            	<option value="maior" {{($filtro->operador ?? null) == 'maior' ? 'selected' : '' }}>Maior</option>
                                            	<option value="menor" {{($filtro->operador ?? null) == 'menor' ? 'selected' : '' }}>Menor</option>
                                            	<option value="maior_igual" {{($filtro->operador ?? null) == 'maior_igual' ? 'selected' : '' }}>Maior igual</option>
                                            	<option value="menor_igual" {{($filtro->operador ?? null) == 'menor_igual' ? 'selected' : '' }}>Menor igual</option>
                                            </select>
                                        </div>
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Digite o valor</label>
                                            <input type="text" name="valor" value="{{$filtro->valor ?? ''}}"  class="form-campo">
                                        </div>
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Qual Produto</label>
                                            <select class="form-campo" name="produto_loja">
                                            	<option value="">Todos os Produtos</option>
                                            	<option value="S" {{($filtro->produto_loja ?? null) == 'S' ? 'selected' : '' }}>Somente da Loja</option>
                                            	<option value="N" {{($filtro->produto_loja ?? null) == 'N' ? 'selected' : '' }}>Somente os que não são da Loja</option>
                                            </select>
                                        </div>
                                       
                                </div>
                                </div>
                        </div>
                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">					  			
                                        
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Categoria</label>
                                            <select class="form-campo" name="categoria_id">
                                            <option value="">Selecione</option>
                                            @foreach($categorias as $c)
												<option value="{{$c->id}}" {{( $filtro->categoria_id ?? null)==$c->id ? 'selected' : null}}>{{$c->categoria}}</option>
											@endforeach
											</select>
                                        </div>                                      
                                        
                                        <div class="col-4">	
                                            <label class="text-label d-block text-branco">Fornecedor</label>
                                            <select class="form-campo" name="fornecedor_nota_id">
                                            <option value="">Selecione</option>
                                            @foreach($fornecedores as $c)
												<option value="{{$c->id}}" {{( $filtro->fornecedor_nota_id ?? null)==$c->id ? 'selected' : null}}>{{$c->razao_social}}</option>
											@endforeach
											</select>
                                        </div>
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Status</label>
                                            <select class="form-campo" name="status_id">
                                            <option value="">Selecione</option>
                                            @foreach($status as $c)
												<option value="{{$c->id}}" {{( $filtro->status_id ?? null)==$c->id ? 'selected' : null}}>{{$c->status}}</option>
											@endforeach
											</select>
                                        </div>
                                        
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Usuario</label>
                                            <select class="form-campo" name="usuario_id">
                                            <option value="">Selecione</option>
                                            @foreach($usuarios as $s)
												<option value="{{$s->id}}" {{( $filtro->usuario_id ?? null)==$s->id ? 'selected' : null}}>{{$s->name}}</option>
											@endforeach
											</select>
                                        </div>
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Tipo de Relatório</label>
                                            <select class="form-campo" name="tipo_relatorio">
                                            	<option value="listagem">Listagem de Produtos</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Tipo de Saída</label>
                                            <select class="form-campo" name="tipo_saida">
                                            	<option value="tela">Visualizar na Tela</option>
                                            	<option value="pdf">Gerar PDF</option>
                                            </select>
                                        </div>
                                        
                                        
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="Filtrar" class="btn btn-roxo text-uppercase">
                                        </div>
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
                                    <th align="left" width="380">Produto</th>
                                    <th align="center">Preço</th>
                                     <th align="center">Categoria</th>
                                    <th align="center">Unidade</th>
                                    <th align="center">Vende Na Loja</th>
                                    <th align="center">Estoque Atual</th>
                                    
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $produto)
						<tr>
							<td align="center">{{$produto->id}}</td>
							<td align="left">{{$produto->nome}}</td>
							<td align="center">{{$produto->valor_venda}}</td>
							<td align="center">{{$produto->categoria->categoria ?? "---"}}</td>
							<td align="center">{{$produto->unidade}}</td>
							<td align="center">{{($produto->produto_loja=='S') ? 'Sim' : 'Não'}}</td>
							<td align="center">{{$produto->estoque->quantidade ?? '--'}}</td>
							</tr>
					@endforeach
					</tbody>
			</table>   
	</div>
	</div>
			
        </div>
</div>

        @endsection
		
<
