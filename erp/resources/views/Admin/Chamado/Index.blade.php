@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
	
    <div class="col-12">
    <div class="caixa">
	<div class="p-2  bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-lock-open"></i> Lista de Chamados</span>
		<div class="d-flex">
			<a href="{{route('admin.chamado.create')}}" class="btn btn-pequeno btn-verde text-branco" title="Adicionar novo"><i class="fas fa-plus-circle"></i></a>		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul ml-1" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>				
            
		
    </div>
    </div>

		<div class="col-12">
            <div class="px-2">
                    <div class="tabela-responsiva p-4">
                     
                    <table cellpadding="0" cellspacing="0" id="dataTable" width="100%" class="table">
                            <thead>
                                    <tr>
                                       
                                       <th align="center" width="20">Id</th>
                                       <th class="text-left" >Assunto</th>
                                       <th class="text-left" >Status</th>
                                       <th align="center" width="200">Opções</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($lista as $c)                                     
                             <tr>
								<td align="center">{{$c->id}}</td>
                                <td align="left">{{$c->assunto}}</td>
                                <td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>
                            
 							<td align="center"><a href="{{route('admin.chamado.show', $c->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno"  title="Visualizar"><i class="fas fa-eye"></i> </a>                              							
                                <a href="{{route('admin.categoria.edit', $c->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno"  title="Editar"><i class="fas fa-edit"></i> </a>                             								
                               
                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$c->id}}').submit() : '';" class="d-inline-block btn btn-outline-vermelho btn-pequeno" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.categoria.destroy', $c->id)}}" method="POST" id="apagar{{$c->id}}">
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