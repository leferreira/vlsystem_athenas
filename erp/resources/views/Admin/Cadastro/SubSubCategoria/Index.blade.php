@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
	
    <div class="col-12">
    <div class="caixa">
	<div class="p-2  bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Lista de subsubcategorias</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>				
            
		 @if(isset($subsubcategoria))    
           <form action="{{route('admin.subsubcategoria.update', $subsubcategoria->id)}}" method="POST" >
           <input name="_method" type="hidden" value="PUT"/>
         @else                       
        	<form action="{{route('admin.subsubcategoria.store')}}" method="Post" >
        @endif
        	@csrf
            
            <div class="px-2 pt-2">	
				  <div class=" {{isset($subsubcategoria) ? 'bg-orange' : 'bg-padrao' }}  mt-2 p-2 radius-4">
				  <div class="rows">
				 		 <div class="col-3">
				 		 <label class="text-label d-block text-branco">Categoria </label>
				  			<select class="form-campo" name="categoria_id" id="categoria_id" onchange="listarSubcategoriaPelaCategoria(0)">
				 		 	<option value="">Selecione</option>
				  				@foreach($categorias as $categoria)
				  					<option value='{{$categoria->id}}' {{($subsubcategoria->categoria_id ?? null)== $categoria->id ? 'selected': '' }} >{{$categoria->categoria}}</option>
				  				@endforeach				  			
				  			</select>
				  		</div>
				  		
				  		<div class="col-3">
				 		 <label class="text-label d-block text-branco">SubCategoria </label>
				 		 	
				  			<select class="form-campo" name="subcategoria_id" id="subcategoria_id" >
				  			<option value="">Selecione</option>
				  				@foreach($subcategorias as $subcategoria)
				  					<option value='{{$subcategoria->id}}' {{($subsubcategoria->subcategoria_id ?? null)== $subcategoria->id ? 'selected': '' }} >{{$subcategoria->subcategoria}}</option>
				  				@endforeach				  			
				  			</select>
				  		</div>
				  		
				  			
                            <div class="col-3">	
                                    <label class="text-label d-block text-branco">Subcategoria </label>
                                    <input type="text" name="subsubcategoria" value="{{isset($subsubcategoria->subsubcategoria) ? $subsubcategoria->subsubcategoria: null}}"  class="form-campo">
                            </div>                                    
                            
                            <div class="col-2 mt-1 pt-1">
                                    <input type="submit" value="{{isset($subsubcategoria) ? 'Alterar' : 'Inserir' }}" class="width-100 btn btn-roxo text-uppercase">
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
                                       <th class="text-left" >SubCategoria</th>
                                       <th class="text-left" >SubSubCategoria</th>
                                       <th align="center" width="70">Editar</th>
                                       <th align="center" width="30">Excluir</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($lista as $cat)                                     
                             <tr>
								<td align="center">{{$cat->id}}</td>
                                <td align="left">{{$cat->categoria->categoria}}</td>	
                                <td align="left">{{$cat->subCategoria->subcategoria}}</td>	
                                <td align="left">{{$cat->subsubcategoria}}</td>											
                                <td align="center"><a href="{{route('admin.subsubcategoria.edit', $cat->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno"><i class="fas fa-edit"></i> Editar</a>                              </td>									
                                <td align="center">

                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$cat->id}}').submit() : '';" class="d-inline-block btn btn-outline-vermelho btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.subsubcategoria.destroy', $cat->id)}}" method="POST" id="apagar{{$cat->id}}">
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