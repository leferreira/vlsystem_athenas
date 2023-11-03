@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Cadastrar emitente</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>
		@if(isset($certificado->id))    
           <form action="{{route('admin.certificadodigital.update', $certificado->id)}}" method="POST" enctype="multipart/form-data" >
           <input name="_method" type="hidden" value="PUT"/>
         @else                       
        	<form action="{{route('admin.certificadodigital.store')}}" method="Post" enctype="multipart/form-data">
        @endif
        	@csrf
        	
   <div id="tab">	  
       <div id="tab-5">
		<div class="p-2 mt-3">
		<fieldset>
        <legend>CERTIFICADO DIGITAL</legend>										
        <div class="rows">	            
             
             <div class="col-4 mb-3">
                     <label class="text-label">Senha</label>	
                     <input type="text" name="certificado_senha" value="{{isset($certificado->certificado_senha) ? $certificado->certificado_senha : old('certificado_senha') }}"  class="form-campo">
             </div>
             <div class="col-8 mb-4">
                     <span class="text-label">Arquivo</span>	
					<div class="file">
						<input type="file" name="arquivo"  id="arquivo" class="form-campo"><label for="arquivo">selecionar arquivo </label>	
					</div>
             </div>
		</div>
		</fieldset>
	@if(($detalhe->tem_erro ?? null) == false)
		<fieldset>	
        <legend>Dados do Certificado Digital</legend>										
        <div class="rows">	            
             
             <div class="col-2 mb-3">
                     <label class="text-label">Serial do Certificado</label>	
                     <input type="text" value="{{$detalhe->retorno->serial ?? null }}"  class="form-campo">
             </div>
             <div class="col-2 mb-3">
                     <label class="text-label">Início</label>	
                     <input type="text" value="{{$detalhe->retorno->inicio ?? null }}"  class="form-campo">
             </div>
             <div class="col-2 mb-3">
                     <label class="text-label">Expiração</label>	
                     <input type="text" value="{{$detalhe->retorno->expiracao ?? null }}"  class="form-campo">
             </div>
             <div class="col-6 mb-3">
                     <label class="text-label">IDCTX</label>	
                     <input type="text" value="{{$detalhe->retorno->id ?? null }}"  class="form-campo">
             </div>
             
		</div>
		</fieldset>
	@else
	<fieldset>	
        <legend>Detalhes do Certificado Digital</legend>										
        <div class="rows">
        	<div class="col-6 mb-3">
                     <label class="text-label">{{$detalhe->erro}}</label>	
             </div>
        </div>
       </fieldset>
	@endif
        </div>
	  </div>
	  <div class="col-12 text-center pb-4">
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	  
         
 </div>
	</form>	
	  </div>

@endsection