@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
	
    <div class="col-12">
    <div class="caixa">
	<div class="p-2  bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Lista de Funções (Cargo)</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>				
            
		 @if(isset($funcao))    
           <form action="{{route('admin.funcao.update', $funcao->id)}}" method="POST" >
           <input name="_method" type="hidden" value="PUT"/>
         @else                       
        	<form action="{{route('admin.funcao.store')}}" method="Post" >
        @endif
        	@csrf
            
            <div class="px-2 pt-2">	
				  <div class=" {{isset($funcao) ? 'bg-orange' : 'bg-padrao' }}  mt-2 p-2 radius-4">
				  <div class="rows">
                            <div class="col-3">	
                                    <label class="text-label d-block text-branco">Função </label>
                                    <input type="text" name="nome" value="{{isset($funcao->nome) ? $funcao->nome : old('nome')}}" class="form-campo">
                            </div>
                            <div class="col-6">	
                                    <label class="text-label d-block text-branco">Descrição </label>
									<input type="text" name="descricao" value="{{isset($funcao->descricao) ? $funcao->descricao : old('descricao')}}" class="form-campo">
                            </div>                                    
                            
                            <div class="col-2 mt-1 pt-1">
                            		<input type="hidden" name="id" value="{{isset($funcao->id) ? $funcao->id: NULL }}">
                                    <input type="submit" value="{{isset($funcao) ? 'Alterar' : 'Inserir' }}" class="width-100 btn btn-roxo text-uppercase">
                            </div>
                    </div>
                    </div>
            </div>
        </form>
    </div>
    </div>

		<div class="col">
            <div class="px-2">
                    <div class="tabela-responsiva pb-4">
                     
                    <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                                    <tr>
                                            <th align="center">Id</th>
                                            <th align="left" >Nome</th>
                                            <th align="center">Descrição</th>
                                            <th align="left" >Permissão</th>
                                            <th align="center">Editar</th>
                                            <th align="center">Excluir</th>
                                    </tr>
                            </thead>
                            <tbody>	
                                @foreach($lista as $funcao)
            						<tr>
            							<td align="center">{{$funcao->id}}</td>
            							<td align="left">{{$funcao->nome}}</td>
            							<td align="center">{{$funcao->descricao}}</td>
            							<td align="center"><a href="{{route('admin.funcao.permissao',$funcao->id)}}" class="btn btn-azul"><i class="fas fa-plus-circle"></i> Permissões</a></td>
            							<td align="center"><a href="{{route('admin.funcao.menu',$funcao->id)}}" class="btn btn-azul"><i class="fas fa-plus-circle"></i>Ver Menus</a></td>
            							<td align="center"><a href="{{route('admin.funcao.edit', $funcao->id)}}" class="btn btn-outline-roxo">Editar</a></td>
            							 <td align="center">
            							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$funcao->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                                <form action="{{route('admin.funcao.destroy', $funcao->id)}}" method="POST" id="apagar{{$funcao->id}}">
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