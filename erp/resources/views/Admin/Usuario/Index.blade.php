@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Usuários </span>
						
					</div>
                        
					@if(isset($usuario))    
                       <form action="{{route('admin.usuario.update', $usuario->id)}}" method="POST" enctype="multipart/form-data">
                       <input name="_method" type="hidden" value="PUT"/>
                     @else                       
                    	<form action="{{route('admin.usuario.store')}}" method="Post" enctype="multipart/form-data">
                    @endif
                	
                	@csrf
                        
                        <div class="px-2 pt-2">	
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Nome </label>
                                                <input type="text" name="name" required value="{{isset($usuario->name) ? $usuario->name : old('name')}}"  class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Email </label>
                                                <input type="text" name="email" required value="{{isset($usuario->email ) ? $usuario->email  : old('email ')}}"  class="form-campo ">
                                        </div>
                                        <div class="col-2">	
                                                <label class="text-label d-block text-branco">Senha </label>
                                                <input type="password" name="password" required  class="form-campo">
                                        </div>
                                        <div class="col-2">	
                                             <label class="text-label d-block text-branco">Admin </label>
                                            <div class="radio d-flex">
    										 <label class="d-block"><input type="radio" name="eh_admin" value="S" {{ ($usuario->eh_admin ?? null) == "S" ? "checked" : "" }} > Sim</label>
    										 <label class="d-block ml-3"><input type="radio" name="eh_admin" value = "N" {{ ($usuario->eh_admin ?? "N") == "N" ? "checked" : "" }} > Não</label>
    									</div>
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
                                       <th align="center" >Id</th>
                                       <th align="left" class="text-left">Nome</th>
                                       <th align="left" class="text-left">Email</th>
                                       <th align="left" class="text-left">Funções</th>
                                       <th align="left" class="text-left">Admin</th>
                                       <th align="left" class="text-left">Status</th>
                                       <th align="center"  class="text-center">+ Função</th>
                                       <th align="center" >Editar</th>
                                       <th align="center" >Excluir</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($usuarios as $b)
                         @if($b->status_id != config('constantes.status.DELETADO'))
                          @php
                          		$lista = $b->funcoes;
                          		$p = array();
                          		if(count($lista) > 0 ){
                          			foreach($lista as $l){
                          				$p[] = $l->nome ;
                          			}
                          		}
                          @endphp                                     
                             <tr>
								<td align="center">{{$b->id}}</td>
								<td align="left">{{$b->name}}</td>
                                <td align="left">{{$b->email}}</td>
                                <td align="left">{{implode(", ", $p)}}</td>
                                <td align="left">{{$b->eh_admin}}</td>
                                <td align="left">{{$b->status->status}}</td>
                                <td align="center"> <a href="{{route('admin.usuario.funcoes', $b->id)}}" class="btn btn-azul d-inline-block"><i class="fas fa-user"></i>+ Função</a> </td>
                                <td align="center"><a href="{{route('admin.usuario.edit', $b->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno"><i class="fas fa-edit"></i> Editar</a>  </td>									
                                <td align="center">
                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$b->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.usuario.destroy', $b->id)}}" method="POST" id="apagar{{$b->id}}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        {{csrf_field()}}
                                    </form>
                                 </td>
                             </tr> 
                             @endif                                      
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
        