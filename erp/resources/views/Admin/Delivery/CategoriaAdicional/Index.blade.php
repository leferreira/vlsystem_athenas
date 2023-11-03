@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de categoria adicional </span>
						
					</div>
                        
					 @if(isset($categoria))    
                       <form action="{{route('admin.categoriaadicional.update', $categoria->id)}}" method="POST" >
                       <input name="_method" type="hidden" value="PUT"/>
                     @else                       
                    	<form action="{{route('admin.categoriaadicional.store')}}" method="Post" >
                    @endif
                    	@csrf
                        
                        <div class="px-2 pt-2">	
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-4">	
                                                <label class="text-label d-block text-branco">Nome </label>
                                                <input type="text" name="nome" value="{{isset($categoria->nome) ? $categoria->nome : null}}"  class="form-campo">
                                        </div>
                                        <div class="col-2">	
                                                <label class="text-label d-block text-branco">Limite de Escolha </label>
                                                <input type="text" name="limite_escolha" value="{{isset($categoria->limite_escolha) ? $categoria->limite_escolha : null}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Adicional R$ </label>
                                                <input @if(isset($categoria->adicional) && $categoria->adicional) checked @endisset value="1" name="adicional" class="red-text" type="checkbox">
                                        </div>
                                        
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="Salvar" class="btn btn-roxo text-uppercase">
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
                                       <th align="center">Limite Escolha</th>
                                       <th align="center">Adicional</th>
                                       <th align="center">Editar</th>
                                       <th align="center">Excluir</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($categorias as $cat)                                     
                             <tr>
								<td align="center">{{$cat->id}}</td>
                                <td align="left">{{$cat->nome}}</td>
                                <td align="left">{{$cat->limite_escolha}}</td>
							     <td align="left">
										@if($cat->adicional)
								<span class="label label-xl label-inline label-light-success">
									sim
								</span>
								@else
								<span class="label label-xl label-inline label-light-danger">
									não
								</span>
								@endif
								</td>											
                                <td align="center"><a href="{{route('admin.categoriaadicional.edit', $cat->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno"><i class="fas fa-edit"></i> Editar</a>                              </td>									
                                <td align="center">

                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$cat->id}}').submit() : '';" class="d-inline-block btn btn-outline-vermelho btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.categoriaadicional.destroy', $cat->id)}}" method="POST" id="apagar{{$cat->id}}">
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

                   
                    <!--
                        <div class="caixa p-2">
                                <div class="msg msg-verde">
                                <p><b><i class="fas fa-check"></i> Mensagem de boas vindas</b> Parabéns seu produto foi inserido com sucesso</p>
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

        </div>
        </div>
        @endsection