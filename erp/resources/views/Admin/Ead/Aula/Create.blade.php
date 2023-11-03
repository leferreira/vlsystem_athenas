@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
	<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Cadastro de Aulas </span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
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
				<legend>Cadastro de Aulas</legend>					
				<div class="rows">									
					<div class="col-8 mb-3">
								<label class="text-label">Título</label>	
								<input type="text" name="titulo"  value="{{isset($aula->titulo) ? $aula->titulo : old('titulo') }}" class="form-campo">
						</div>                                    
																				
    						<div class="col-4 mb-3">
    								<label class="text-label">Curso</label>	
    								<select name="curso_id" class="form-campo">
    									@foreach($cursos as $c)
    										<option value="{{$c->id}}">{{$c->curso}}</option>
    									@endforeach
    								</select>
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
                                     
                           <div class="col-12 text-center pb-4">	
                    			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
                    		</div>   

			</div>
			</fieldset>
			
			
		</div>
	  </div>	
	  </form>	
		</div>
		
	  </div>
	
@endsection