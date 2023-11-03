@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
 <div class="p-2 py-1 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
						<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista centro de custo</span>
						<div class="d-flex">
							<a href="{{route('admin.centrocusto.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
							<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
						</div>
					</div>
<div class="rows">	
	
    <div class="col-12">
    <div class="caixa">			
            
		 @if(isset($centrocusto))    
           <form action="{{route('admin.centrocusto.update', $centrocusto->id)}}" method="POST" >
           <input name="_method" type="hidden" value="PUT"/>
         @else                       
        	<form action="{{route('admin.centrocusto.store')}}" method="Post" >
        @endif
        	@csrf
            
            <div class="px-2 pt-2">	
				  <div class="  bg-padrao mt-2 p-2 radius-4">
				  <div class="rows">
                            <div class="col-10">	
                                    <label class="text-label d-block text-branco">Nome </label>
                                    <input type="text" name="nome" value="{{isset($centrocusto->nome) ? $centrocusto->nome : null}}"  class="form-campo">
                            </div>                                    
                            
                            <div class="col-2 mt-1 pt-1">
                                    <input type="submit" value="Inserir" class="width-100 btn btn-roxo text-uppercase">
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
                                       
                                       <th align="center" width="20">Id</th>
                                       <th class="text-left" >Categoria</th>
                                       <th align="center" width="70">Editar</th>
                                       <th align="center" width="30">Excluir</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($centrocustos as $cat)                                     
                             <tr>
								<td align="center">{{$cat->id}}</td>
                                <td align="left">{{$cat->nome}}</td>											
                                <td align="center"><a href="{{route('admin.centrocusto.edit', $cat->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno" title="Editar"><i class="fas fa-edit"></i> </a>                              </td>									
                                <td align="center">

                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$cat->id}}').submit() : '';" class="d-inline-block btn btn-outline-vermelho btn-pequeno" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.centrocusto.destroy', $cat->id)}}" method="POST" id="apagar{{$cat->id}}">
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