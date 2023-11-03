@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Cadastrar parâmetro</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>                  
 @if(isset($parametro))    
   <form action="{{route('admin.parametro.update', $parametro->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.parametro.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	 
	  <div id="tab-1">		
	  
		<fieldset class="p-2 mt-4">									
        <legend class="h5">Gerais</legend>										
        <div class="rows">	
        
             <div class="col-3 mb-3">
                <label class="text-label">Margem de Lucro Padrão(%)</label>	
                <input type="text" name="margem_lucro" value="{{$parametro->margem_lucro ?? 0 }}" class="form-campo mascara-float">
               
             </div>
             
             <div class="col-3 mb-3">
                <label class="text-label">Estoque Mínimo Padrão</label>	
                <input type="text" name="estoque_minimo_padrao" value="{{$parametro->estoque_minimo_padrao ?? 0 }}" class="form-campo mascara-float">
               
             </div>
             
             <div class="col-3 mb-3">
                <label class="text-label">Estoque Mínimo Padrão</label>	
                <input type="text" name="estoque_maximo_padrao" value="{{$parametro->estoque_maximo_padrao ?? 0 }}" class="form-campo mascara-float">
               
             </div>
         
            <div class="col-3 mb-3">
                <label class="text-label">Permitir Estoque Negativo </label>	
                <select class="form-campo" name="permitir_estoque_negativo">
                    <option value="S" {{($parametro->permitir_estoque_negativo=="S") ? "selected" : ""}}>Sim</option> 
                    <option value="N" {{($parametro->permitir_estoque_negativo=="N") ? "selected" : ""}}>Não</option>  
                </select>
             </div>
             	
              <div class="col mb-3">
                        <label class="text-label">mercadopago public key</label>
                        <input type="text" name="mercadopago_public_key" value="{{isset($parametro->mercadopago_public_key) ? $parametro->mercadopago_public_key : old('mercadopago_public_key')}}"  class="form-campo">
                </div>
                
                <div class="col mb-3">
                        <label class="text-label">mercadopago access token</label>
                        <input type="text" name="mercadopago_access_token" value="{{isset($parametro->mercadopago_access_token) ? $parametro->mercadopago_access_token: old('mercadopago_access_token')}}"  class="form-campo">
                </div> 
                    
                            
			                    
        </div>
        </fieldset>
		
        
		
		<div class="col-12 text-center pb-4 mt-4">
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
        </div>
	  </div>
   
	
</form>
</div>
@endsection