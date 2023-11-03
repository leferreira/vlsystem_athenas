@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
	
    

		<div class="col-12">
            <div class="px-2">
                    <div class="tabela-responsiva pb-4">
                     
                    <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                                    <tr>                                       
                                       <th align="center" width="20">Id</th>
                                       <th class="text-left" >Data Abertura</th>
                                       <th class="text-left" >Valor Abertura</th>
                                       <th class="text-left" >Data Fechamento</th>
                                       <th class="text-left" >Valor Vendido</th>
                                       <th class="text-left" >Valor Sangria</th>
                                       <th class="text-left" >Valor Suplemento</th>
                                       <th class="text-left" >Total em Caixa</th>
                                       <th class="text-left" >Usuário</th>
                                       <th align="center" width="30">Excluir</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($lista as $cat)                                     
                             <tr>
								<td align="center">{{$cat->id}}</td>
                                <td align="left">{{databr($cat->data_abertura)}}</td>
                                <td align="left">{{$cat->valor_abertura}}</td>	
                                <td align="left">{{$cat->data_fechamento}}</td>	
                                <td align="left">{{$cat->valor_vendido}}</td>
                                <td align="left">{{$cat->valor_sangria}}</td>	
                                <td align="left">{{$cat->valor_suplemento}}</td>		
                                <td align="left">{{$cat->total_em_caixa}}</td>		
                                <td align="left">{{$cat->usuario->name}}</td>								
                                <td align="center">

                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$cat->id}}').submit() : '';" class="d-inline-block btn btn-outline-vermelho btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.caixa.destroy', $cat->id)}}" method="POST" id="apagar{{$cat->id}}">
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