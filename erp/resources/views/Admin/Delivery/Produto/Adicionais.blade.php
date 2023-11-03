@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Adicionais: {{$produto->nome}} </span>
						
					</div>
                        
					<form name="busca" action="{{route('admin.deliverycomplemento.store')}}" method="POST">
                        <input type="hidden" id="produto_id" value="{{$produto->id}}">
                        <div class="px-2 pt-2">	
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        
                                        <div class="col-3">	
                                             <label class="text-label d-block text-branco">Categorias </label>
                                            <select name="categoria_id" id="categoria_id" class="form-campo" onchange="selecionarComplemento()">
                                            	<option value="">Selecione</option>
                                            @foreach($categorias as $c)
                                                <option value="{{$c->id}}">{{$c->nome}}</option>                                                 
                                             @endforeach                                                
                                            </select>
                                        </div>
                                        
                                        <div class="col-3">	
                                             <label class="text-label d-block text-branco">Complementos </label>
                                            <select name="complemento_id" id="complemento_id" class="form-campo"></select>
                                        </div>                                    
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="button" value="inserir" id="btnInserirComplementoProduto" class="btn btn-roxo text-uppercase">
                                        </div>
                                </div>
                                </div>
                        </div>
                    </form>
                </div>
                </div>

		<div class="col-12">
            <div class="px-2">
                    <div class="tabela-responsiva pb-4">
                    <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                                    <tr>
                                       
                                       <th align="center">Id</th>
                                       <th align="left" >Nome</th>
                                       <th align="center">Descrição</th>
                                       <th align="center">Editar</th>
                                       <th align="center">Excluir</th>
                                    </tr>
                            </thead>
                            <tbody id="lista_complemento_produto"> 
                          @foreach($adicionados as $a)                                     
                             <tr>
								<td align="center">{{$a->id}}</td>
                                <td align="left">{{$a->complemento->nome}}</td>
                                <td align="left">{{$a->complemento->categoria->nome}}</td>
							     											
                                <td align="center"><a href="{{route('admin.deliverycategoria.edit', $a->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno"><i class="fas fa-edit"></i> Editar</a>                              </td>									
                                <td align="center">
                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$a->id}}').submit() : '';" class="d-inline-block btn btn-outline-vermelho btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.deliverycategoria.destroy', $a->id)}}" method="POST" id="apagar{{$a->id}}">
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
        </div>

@endsection