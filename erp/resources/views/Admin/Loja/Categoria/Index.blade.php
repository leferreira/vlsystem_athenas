@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
				<div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Categoria Loja Virtual</span></span>
					
				</div>
                <div class="caixa">
                                           
					 @if(isset($categoria))    
                       <form action="{{route('admin.lojacategoriaproduto.update', $categoria->id)}}" method="POST" >
                       <input name="_method" type="hidden" value="PUT"/>
                     @else                       
                    	<form action="{{route('admin.lojacategoriaproduto.store')}}" method="Post" >
                    @endif
                    	@csrf
                        
                        <div class="px-2 pt-2">	
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-10">	
                                                <label class="text-label d-block text-branco">Nome </label>
                                                <input type="text" name="nome" value="{{isset($categoria->nome) ? $categoria->nome : null}}"  class="form-campo">
                                        </div>                                    
                                        
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="Salvar" class="btn width-100 btn-roxo text-uppercase">
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
                                       <th class="text-left">Categoria</th>
                                       <th align="center" width="80">Editar</th>
                                       <th align="center" width="40">Excluir</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($lista as $l)                                     
                             <tr>
								<td align="center">{{$l->id}}</td>
                                <td align="left">{{$l->nome}}</td>											
                                <td align="center"><a href="{{route('admin.loja.lojacategoriaproduto.edit', $l->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno"><i class="fas fa-edit"></i> Editar</a>                              </td>									
                                <td align="center">

                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$l->id}}').submit() : '';" class="d-inline-block btn btn-outline-vermelho btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.loja.lojacategoriaproduto.destroy', $l->id)}}" method="POST" id="apagar{{$l->id}}">
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