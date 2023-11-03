@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" mb-0 h5"><i class="fas fa-plus-circle"></i> Cadastrar Modelo de Contratos</span>
		<div>
			<a href="{{route('admin.modelocontrato.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>		
		</div>
	</div>                 

   <div id="tab">
	  <div id="tab-1">
		<div class="p-2 mt-1">
						
      @if(isset($modelocontrato))    
               <form action="{{route('admin.modelocontrato.update', $modelocontrato->id)}}" method="POST">
               <input name="_method" type="hidden" value="PUT"/>
             @else                       
            	<form action="{{route('admin.modelocontrato.store')}}" method="Post">
            @endif
            	@csrf
	
			<fieldset>
					<legend>Dados do Modelo</legend>
													
					<div class="rows">	
							<div class="col-6 mb-3">
                            	<label class="text-label">Titulo<span class="text-vermelho">*</span></label>	
                            	<input type="text" name="nome" id="nome" required value="{{$modelocontrato->nome ??  old('nome') }}"  class="form-campo ">
                            </div>
                            <div class="col-3 text-center pb-4">	
                    		
                    				<label class="text-label">Selecione</label>
                                
                                    <select  id="escolher_campo" class="form-campo ">
                                    <option>Selecione...</option>
                                        @foreach($dicionarios as $d)
                                        	<optgroup label="{{$d->tabela}}">
                                        	@foreach($d->itens as $item)
                                        		<option value="{{$item->chave}}">{{$item->chave}}</option>
                                        	@endforeach
                                        	</optgroup>
                                        	
                                        @endforeach                                    
                                    
                                    </select>
                           
                    		</div>
                    		
                    		<div class="col-3 mb-3">
                            	<label class="text-label">Copia e Cola</label>	
                            	<input type="text" id="valor_campo"   class="form-campo ">
                            </div>
            		
                            
                            <div class="col-12 mb-3">
                                    <label class="text-label">Conteúdo<span class="text-vermelho">*</span></label>
                                    <textarea rows="30"  id="conteudo" name="conteudo" class="form-campo ">{{isset($modelocontrato->conteudo) ? $modelocontrato->conteudo : old('conteudo') }}</textarea>	
                                    <script src="{{asset('assets/componentes/js/ckeditor/ckeditor.js')}}"></script>
                                    <script>CKEDITOR.replace( 'conteudo' );</script>
                            </div>                           
					</div>
					<div class="col-12 text-center pb-4">	
            			<input type="hidden" name="eh_modal" id="eh_modal" value="0">
            			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
            		</div>
				</fieldset>
			</form>
		</div>
	  </div>
         
 </div>
		
	  </div>
	


<script>
$('#escolher_campo').change(function() {	
    if ($(this).val() != "0")
    	$("#valor_campo").val($(this).val());
        
    $(this).prop('selectedIndex', 0);
    
});
</script>

@endsection