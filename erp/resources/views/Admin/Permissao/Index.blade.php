@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Permissão  </span>
						
					</div>
                        
					 @if(isset($permissao))    
                       <form action="{{route('admin.permissao.update', $permissao->id)}}" method="POST" >
                       <input name="_method" type="hidden" value="PUT"/>
                     @else                       
                    	<form action="{{route('admin.permissao.store')}}" method="Post" >
                    @endif
                    	@csrf
                        
                        <div class="px-2 pt-2">	
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">permissao </label>
												<input type="text" name="permissao" value="{{isset($permissao->permissao) ? $permissao->permissao : old('permissao')}}" class="form-campo">
                                        </div>
                                        <div class="col-6">	
                                                <label class="text-label d-block text-branco">Descrição </label>
												<input type="text" name="descricao" value="{{isset($permissao->descricao) ? $permissao->descricao : old('descricao')}}" class="form-campo">
                                        </div>                                       
                                        
                                        <div class="col-3 mt-1 pt-1">
                                        		<input type="hidden" name="id" value="{{isset($permissao->id) ? $permissao->id: NULL }}">
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
                                    <th align="center">Id</th>
                                    <th align="left" >Razão Social</th>
                                    <th align="center">CNPJ</th>
                                    <th align="center">Editar</th>
                                    <th align="center">Excluir</th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $permissao)
						<tr>
							<td align="center">{{$permissao->id}}</td>
							<td align="left">{{$permissao->permissao}}</td>
							<td align="center">{{$permissao->descricao}}</td>
							<td align="center"><a href="{{route('permissao.edit', $permissao->id)}}" class="btn btn-outline-roxo">Editar</a></td>
							 <td align="center">
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$permissao->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('permissao.destroy', $permissao->id)}}" method="POST" id="apagar{{$permissao->id}}">
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
        @endsection