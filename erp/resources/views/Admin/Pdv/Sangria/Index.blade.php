@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
	
    <div class="col-12">
    <div class="caixa">
		<div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
			<span class="h5 mb-0  d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de sangria </span>
		</div>				
            
		
    </div>
    </div>

		<div class="col-12">
            <div class="px-2">
                    <div class="tabela-responsiva pb-4">
                     
                    <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                                    <tr>
                                       
                                       <th align="center" width="20">Id</th>
                                       <th class="text-left" >Usuario</th>
                                       <th class="text-left" >Data</th>
                                       <th class="text-left" >Terminal</th>
                                       <th class="text-left" >Descrição</th>
                                       <th class="text-left" >Valor</th>
                                       <th align="center" >Editar</th>
                                       <th align="center" >Excluir</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($lista as $cat)                                     
                             <tr>
								<td align="center">{{$cat->id}}</td>
                                <td align="left">{{$cat->usuario->name}}</td>	
                                <td align="left">{{databr($cat->caixa->data_abertura)}}</td>
                                <td align="left">{{$cat->caixa->caixaNumero->num_caixa}}</td>
                                <td align="left">{{$cat->descricao}}</td>	
                                <td align="left">{{$cat->valor}}</td>									
                                <td align="center"><a href="{{route('admin.sangria.edit', $cat->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno"><i class="fas fa-edit"></i> Editar</a>                              </td>									
                                <td align="center">

                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$cat->id}}').submit() : '';" class="d-inline-block btn btn-outline-vermelho btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.sangria.destroy', $cat->id)}}" method="POST" id="apagar{{$cat->id}}">
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