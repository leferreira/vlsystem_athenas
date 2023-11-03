<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
	<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Cadastrar Serviço </span>
	<div>
		<!--<a href="javascript:;" onclick="abrirModal('#add')" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Cadastrar categoria</a>-->
		<a href="{{route('admin.produto.index')}}" class="btn btn-azul btn-pequeno d-inline-block" title="Volta"><i class="fas fa-arrow-left"></i></a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
		
	</div>
</div>                      
 @if(isset($produto))    
   <form action="{{route('admin.servico.update', $produto->id)}}" method="POST" enctype="multipart/form-data">
   <input name="_method" type="hidden" value="PUT"/>   
 @else                       
	<form action="{{route('admin.servico.store')}}" method="Post" enctype="multipart/form-data">
@endif
	@csrf
   <div id="tab">

	 
				     
	  <div>
		<div class="p-2 pt-4">
			<small class="d-block text-right text-vermelho">(*) Campos obrigatórios</small>
			<fieldset>
				<legend>Informações básicas</legend>
				<div class="rows">	
						
                        <div class="col-9 px-2">
                           <div class="rows">
                          
								
                                <div class="col-6 mb-3">
                                        <label class="text-label">Nome do Serviço<span class="text-vermelho">*</span></label>
                                        <input type="text" id="nome" name="nome" required maxlength="100" value="{{isset($produto->nome) ? $produto->nome : old('nome')}}"   class="form-campo">
                                </div>                         
                             	             
        				   
        				   		<div class="col-3 mb-3">
                                        <label class="text-label">Valor<span class="text-vermelho">*</span></label>
                                        <input type="text" name="valor_venda" id="valor_venda"  required value="{{isset($produto->valor_venda) ? $produto->valor_venda : old('valor_venda')}}"  class="form-campo  mascara-float">
                                </div> 
                        
                        </div>
                        </div>
			</div>
			</fieldset>        
			
		
		</div>
	  </div>

	 
		<div class="col-12 text-center pb-4">	
				
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	  </div>
	
</form>
</div>


@endsection


