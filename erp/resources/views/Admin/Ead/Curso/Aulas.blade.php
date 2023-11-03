@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
 
		
            <div class="col-12">
            <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle  h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de Aulas </span>
				<div>
					<a href="{{route('ead.aula.create')}}" class="btn btn-azul ml-1 d-inline-block" title=" Adicionar novo"><i class="fas fa-plus-circle"></i></a>
					<a href="" class="btn btn-laranja filtro ml-1 d-inline-block" title="Filtrar"><i class="fas fa-filter"></i> </a>
				</div>
			</div>
            <div id="tab">
	 @if(isset($cliente))    
   <form action="{{route('ead.aula.update', $aula->id)}}" method="POST">
       <input name="_method" type="hidden" value="PUT"/>
     @else                       
    	<form action="{{route('ead.aula.store')}}" method="Post">
    @endif
    	@csrf  
	  <div id="tab-1">
		<div class="p-2">
			
			<fieldset>
				<legend>Cadastro de Aulas do Curso: {{$curso->titulo}}</legend>					
				<div class="rows">									
					<div class="col-8 mb-3">
								<label class="text-label">Título</label>	
								<input type="text" name="titulo"  value="{{isset($aula->titulo) ? $aula->titulo : old('titulo') }}" class="form-campo">
						</div>                                    
																				
    						
    						
    						<div class="col-3 mb-3">
    								<label class="text-label">Embed do Vìdeo</label>	
    								<input type="text" name="embed"  value="{{isset($aula->embed) ? databr($aula->embed) : old('embed') }}"  class="form-campo">
    						</div>
    						
    						<div class="col-3 mb-3">
    								<label class="text-label">Duração</label>	
    								<input type="text" name="duracao"  value="{{isset($aula->duracao) ? $aula->duracao : old('duracao') }}"  class="form-campo">
    						</div>
								
							<div class="col-3 mb-3">
                            <label class="text-label">Data </label>	
                            <input type="date"  name="data_cadastro" value="{{isset($aula->data_cadastro) ? $aula->data_cadastro : old('data_cadastro') }}"  class="form-campo">
                            </div>
                                     
                           <div class="col-3 text-center pb-4">	
                            	<input type="hidden"  name="curso_id" value="{{isset($curso->id) ? $curso->id : null }}"  class="form-campo">
                            	<input type="hidden"  name="pagina" value="curso"  class="form-campo">
                    			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
                    		</div>   

			</div>
			</fieldset>
			
			
		</div>
	  </div>	
	  </form>	
		</div>
            
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle  h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de Aulas </span>
				<div>
				</div>
			</div>
                     
				<div class="px-2 pt-2"> 
					<form name="busca" action="" method="GET">
					<div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
						 <div class="rows p-3">	
							<div class="col-6">
									<span class="text-label text-branco">Curso</span>
									<input type="text" name="cliente" value="" placeholder="Digite aqui..." class="form-campo">
							</div>
							<div class="col-4">
									<span class="text-label text-branco">Categoria</span>
									<select class="form-campo" name="idCategoria">
									<option value="">Escolha uma Opção</option>
									<option value="1">Panela</option><option value="2">Cuzcuzeira</option><option value="3">Copo</option><option value="4">Caneca</option><option value="5">Papeiro</option><option value="6">Leiteira</option><option value="7">Frigideira</option><option value="8">Bacia</option><option value="9">Balde</option><option value="10">Assadeira</option><option value="11">Baquelite</option><option value="12">yyy</option>                                         </select>
							</div>
							 <div class="col-2 pt-1 mt-1">
								  <input type="submit" value="Pesquisar" class="btn btn-azul width-100 text-uppercase">
							  </div>
						</div>								 
                    </div>								 
                     </form>
				</div>
            </div>		
    <div class="col">
        <div class="px-2 pb-4">
             <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th align="center">Id</th>
                            <th align="left" >Título</th>
                            <th align="center">Embed</th>
                            <th align="center">Editar</th>
                            <th align="center">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $l)
						<tr>
							<td align="center">{{$l->id}}</td>
							<td align="left">{{$l->titulo}}</td>
							<td align="center">{{$l->embed}}</td>

							<td align="center"><a href="{{route('ead.aula.edit', $l->id)}}" class="d-inline-block btn btn-verde btn-circulo btn-pequeno" title="Editar"><i class="fas fa-edit"></i></td>
							 <td align="center">
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$l->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.cliente.destroy', $l->id)}}" method="POST" id="apagar{{$l->id}}">
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