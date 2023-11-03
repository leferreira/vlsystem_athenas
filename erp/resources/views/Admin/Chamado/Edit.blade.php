@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-lock-open"></i> Chamado</span>
		<div class="d-flex">		
			<a href="{{route('admin.chamado.index')}}" class="btn btn-pequeno btn-azul" title="Voltar"><i class="fas fa-arrow-left"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>                     
	<div id="tab-1" class="col-10 pt-4 m-auto">
		<div class="p-2">			
			
			
			
			<fieldset class="mb-3">					
				<legend>Dados do Chamado</legend>
																
				<div class="rows">
				
					<div class="col-6 mb-3 border-bottom pb-2">
                            <label class="text-label"><i class="fas fa-city text-azul"></i> Usuário</label>
							<input type="text" value="{{$chamado->usuario->name}}" class="fw-700 form-campo limpo p-0 min" />							
                    </div>
                    
                    <div class="col-2 mb-3 border-bottom pb-2">
                            <label class="text-label"><i class="fas fa-calendar-alt text-azul text-azul"></i> Data e Hora</label>
							<input type="text" value="{{Carbon\Carbon::parse($chamado->created_at)->format('d/m/Y H:i:s')}}" class="fw-700 form-campo limpo p-0 min" >							
                    </div>
                    <div class="col-2 mb-3 border-bottom pb-2 text-center">
                            <label class="text-label"><i class="fas fa-check text-azul"></i> Status</label>	
                            <input type="text" value="{{$chamado->status->status}}" class="text-center fw-700 form-campo limpo p-0 min" >
                    </div> 
                   
					 <div class="col-2  mb-3 border-bottom pb-2 "> 
                        <label class="text-label"><i class="fas fa-download text-azul"></i> Baixar anexos</label>
                        @if($chamado->anexo)
							<a href="" class="btn btn-pequeno px-3 btn-outline-azul d-inline-block text-uppercase"> Baixar</a>
						@else
							Sem anexo
						@endif
					</div>
					
                    <div class="col-12 mb-3 border-bottom pb-2 cham">
                            <label class="text-label fw-700 mb-3">Descrição</label>	
                            <span class="form-campo limpo p-0 min">{{$chamado->descricao}}</span>
                    </div> 
                   
				</div>
			
			</fieldset>
					<fieldset class="mb-3" style="background: #f3f4f5;">					
				<legend>Interaçoes</legend>
				@if(count($respostas) > 0)
    				@foreach($respostas as $resposta)
    					<div class="rows border-bottom inter">
        				
        					<div class="col-12 mb-3 pb-0">                           
                                    <small class="form-campo limpo p-0 min"><i class="fas fa-calendar-alt text-azul"></i> Data e hora <b>{{Carbon\Carbon::parse($resposta->created_at)->format('d/m/Y H:i:s')}} - {{($resposta->usuario->id !=1) ? $resposta->usuario->name : 'Gestor'}}</b> &nbsp; &nbsp; </small>
                            </div>
                         
                    					
    
                            <div class="col-12 mb-4">
                                    <span class="form-campo limpo p-0 min">{{$resposta->descricao}}.</span>
                            </div>
                           
        				</div>
        		   @endforeach
    			@else
    				Sem Interação
    			@endif			
			</fieldset>
				<form action="{{route('admin.chamado.salvarResposta')}}" method="Post">
				@csrf				
															
    				<div class="rows"> 
                        <div class="col-12 mb-4">
                                <label class="text-label fw-700">Nova Interação</label>	
                                <textarea class="form-campo min" name="descricao" rows="9"></textarea>
                        </div>  
    				</div>
					<div class="col-12">
    					<input type="hidden" name="chamado_id" value="{{$chamado->id}}">
    					<input type="submit" value="Salvar Informações" class="btn btn-azul m-auto">
    				</div>
    			
					
			</form>	
			</fieldset>
				</div>
			
		</div>

@endsection