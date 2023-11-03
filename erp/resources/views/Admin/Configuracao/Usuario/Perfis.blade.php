@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de perfil do Usuário: {{$usuario->name}}  </span>
						<div>
							<a href="{{route('admin.usuario.index')}}" class="btn btn-azul btn-pequeno d-inline-block"><i class="fas fa-arrow-left"></i>  Voltar</a>
						
						</div>
					</div>                        
					  
                       <form action="{{route('admin.perfilusuario.store')}}" method="POST">                    
                    	@csrf                        
                        <div class="px-2 pt-2">	
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">                                        
                                        <div class="col-4">	
                                                <label class="text-label d-block text-branco">Selecione o perfil </label>
                            					<select class="form-campo" id="perfil_id" name="perfil_id">
                                                    @foreach($perfis as $p)
                                                        <option value="{{$p->id}}">{{$p->nome}}</option>
                                                    @endforeach
                                                </select>
                                        </div>                                    
                                        
                                        <div class="col-2 mt-1 pt-1">
                                        		<input type="hidden" name="user_id" value="{{isset($usuario->id) ? $usuario->id: NULL }}">
                                                <input type="submit" value="Salvar" class="btn btn-roxo text-uppercase">
                                        </div>
                                </div>
                                </div>
                        </div>
                    </form>
                </div>
                </div>

		    <div class="col-12">
        <div class="px-2 pb-4">
            <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                    <thead>
                            <tr>
                                    <th align="center" width="40">Id</th>
                                    <th align="left" >Perfil</th>
                                    <th align="center" width="40">Excluir</th>
                            </tr>
                    </thead>
                    <tbody>	
                   	 	@foreach($perfisusuario as $p)
						<tr>
							<td align="center">{{$p->id}}</td>
							<td align="left">{{$p->perfil->nome}}</td>							
							 <td align="center">
                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar-{{$p->id}}').submit() : '';" class="btn btn-vermelho d-inline-block btn-circulo"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.perfilusuario.destroy', $p->id)}}" method="POST" id="apagar-{{$p->id}}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="perfil" value="{{$p->nome}}">
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
        @endsection