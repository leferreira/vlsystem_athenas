@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de adicional </span>
						
					</div>
                        
					 @if(isset($complemento))    
                       <form action="{{route('admin.deliverycomplemento.update', $complemento->id)}}" method="POST" >
                       <input name="_method" type="hidden" value="PUT"/>
                     @else                       
                    	<form action="{{route('admin.deliverycomplemento.store')}}" method="Post" >
                    @endif
                    	@csrf	
                        
                        <div class="px-2 pt-2">	
							  <div class="bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-3">	
                                             <label class="text-label d-block text-branco">Categorias </label>
                                            <select name="categoria_id" class="form-campo">
                                            @foreach($categorias as $c)
                                                <option value="{{$c->id}}">{{$c->nome}}</option>                                                 
                                             @endforeach                                                
                                            </select>
                                        </div>
                                        
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Nome </label>
                                                <input type="text" name="nome" value="{{isset($complemento->nome) ? $complemento->nome : null}}"class="form-campo">
                                        </div>
                                        
                                        <div class="col-2">	
                                                <label class="text-label d-block text-branco">Valor </label>
                                                <input type="text" name="valor" value="{{isset($complemento->valor) ? $complemento->valor : null}}" class="form-campo">
                                        </div>
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="salvar" class="btn btn-roxo text-uppercase">
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
                                       <th align="center">Valor</th>
                                       <th align="center">Categoria</th>
                                       <th align="center">Editar</th>
                                       <th align="center">Excluir</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($complementos as $c)                                     
                             <tr>
								<td align="center">{{$c->id}}</td>
                                <td align="left">{{$c->nome}}</td>
                                <td align="left">{{$c->valor}}</td>
							   	<td align="left">{{$c->categoria->nome}}</td>										
                                <td align="center"><a href="{{route('admin.deliverycomplemento.edit', $c->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno"><i class="fas fa-edit"></i> Editar</a>                              </td>									
                                <td align="center">
                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$c->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.deliverycomplemento.destroy', $c->id)}}" method="POST" id="apagar{{$c->id}}">
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