@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
	
    <div class="col-12">
    <div class="caixa">
	<div class="p-2  bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Lista de Variações de Grade</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>				
            
		 @if(isset($itemvariacaograde))    
           <form action="{{route('admin.itemvariacaograde.update', $itemvariacaograde->id)}}" method="POST" >
           <input name="_method" type="hidden" value="PUT"/>
         @else                       
        	<form action="{{route('admin.itemvariacaograde.store')}}" method="Post" >
        @endif
        	@csrf
            
            <div class="px-2 pt-2">	
				  <div class=" {{isset($itemvariacaograde) ? 'bg-orange' : 'bg-padrao' }}  mt-2 p-2 radius-4">
				  <div class="rows">
				 		 <div class="col-4">
				 		   <label class="text-label d-block text-branco">Variação </label>
				 		   <div class="group-btn">
				  			<select class="form-campo" name="variacao_grade_id" id="variacao_grade_id">
				  				@foreach($variacoes as $variacaograde)
				  					<option value='{{$variacaograde->id}}' {{($itemvariacaograde->variacao_grade_id ?? null)== $variacaograde->id ? 'selected': '' }} >{{$variacaograde->variacao}}</option>
				  				@endforeach				  			
				  			</select>
				  				<a href="javascript:;" onclick="abrirModal('#modalCadVariacaoGrade')" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova variacaograde"></a>
							</div>
				  		</div>
				  			
                            <div class="col-4">	
                                    <label class="text-label d-block text-branco">Variação </label>
                                    <input type="text" name="valor" value="{{isset($itemvariacaograde->valor) ? $itemvariacaograde->valor : null}}"  class="form-campo">
                            </div>                                    
                            
                            <div class="col-2 mt-1 pt-1">
                                    <input type="submit" value="{{isset($itemvariacaograde) ? 'Alterar' : 'Inserir' }}" class="width-100 btn btn-roxo text-uppercase">
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
                                       <th class="text-left" >Variação</th>
                                       <th class="text-left" >Valor</th>
                                       <th align="center" width="70">Editar</th>
                                       <th align="center" width="30">Excluir</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($lista as $cat)                                     
                             <tr>
								<td align="center">{{$cat->id}}</td>
								<td align="left">{{$cat->variacao->variacao}}</td>	
                                <td align="left">{{$cat->valor}}</td>											
                                <td align="center"><a href="{{route('admin.itemvariacaograde.edit', $cat->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno"><i class="fas fa-edit"></i> Editar</a>                              </td>									
                                <td align="center">

                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$cat->id}}').submit() : '';" class="d-inline-block btn btn-outline-vermelho btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.itemvariacaograde.destroy', $cat->id)}}" method="POST" id="apagar{{$cat->id}}">
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
        @include("Admin.Cadastro.VariacaoGrade.modal.modalVariacao")
        @endsection