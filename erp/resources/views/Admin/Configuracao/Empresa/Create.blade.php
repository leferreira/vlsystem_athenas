@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Minha empresa</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div>  
	</div>  
    
   <form action="{{route('admin.empresa.update', $empresa->id)}}" method="POST" enctype="multipart/form-data">
   <input name="_method" type="hidden" value="PUT"/>
	@csrf
   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2">
			<fieldset style="background: #f3f3f3;">
				<legend>Pesquisar Por CNPJ</legend>				
				<div class="rows">
					<div class="col-6 mb-3">
						<div class="grupo-form-btn">
							<input type="text" id="codigocnpj"   class="form-campo">
							<input type="button" onclick="pesquisarCnpj()" value="Pesquisar CNPJ" class="btn btn-azul d-block m-auto">
						</div>
					</div>
				</div>
			</fieldset>
			
			<fieldset>
				<legend>Dados da empresa</legend>					
				<div class="rows">		
					<div class="col-3 mb-3 text-center">
							<label class="banner-thumb" title="Carregar logo da empresa">	
							@php
								$img = ($empresa->logo) ??  false; 
							@endphp
							@if(!$img)
								<img src="{{asset('assets/admin/img/img-logo-empresa.svg')}}" class="img-fluido" id="imgUp">
							@else									
								<img src="{{ url($img) }}" class="img-fluido" id="imgUp">
							@endif										
							<input type="file" name="file" id="img_logo" onChange="valida_imagem('img_logo', 'imgUp')" class="d-none">
							<span>Carregar imagem</span>
							</label>
					</div>
										
					<div class="col-9 mb-3">
					<div class="rows">
								<div class="col-6 mb-3">
										<label class="text-label">Chave UUID</label>	
										<input type="text"  value="{{$empresa->uuid ?? null }}" class="form-campo">
								</div>
								
								<div class="col-6 mb-3">
										<label class="text-label">Razão Social</label>	
										<input type="text" name="razao_social" id="razao_social" value="{{isset($empresa->razao_social) ? $empresa->razao_social : old('razao_social') }}" class="form-campo">
								</div>                                    
																						
								<div class="col-3 mb-3">
										<label class="text-label">CNPJ</label>	
										<input type="text" name="cpf_cnpj" id="cnpj" value="{{isset($empresa->cpf_cnpj) ? $empresa->cpf_cnpj : old('cpf_cnpj') }}"  class="form-campo">
								</div>
								
								<div class="col-3 mb-3">
                            <label class="text-label">Cep</label>	
                            <input type="text" name="cep" id="cep" value="{{isset($empresa->cep) ? $empresa->cep : old('cep') }}"  class="form-campo busca_cep mascara-cep">
                            </div>
                             <div class="col-6 mb-3">
                                    <label class="text-label">Logradouro</label>	
                                    <input type="text" name="logradouro" id="logradouro" value="{{isset($empresa->logradouro) ? $empresa->logradouro : old('logradouro') }}"  class="form-campo rua">
                            </div>                          
                         </div>	                           
                         </div>	   
						 
                            
                            <div class="col-2 mb-4">
                                    <label class="text-label">Numero</label>	
                                    <input type="text" name="numero" id="numero" value="{{isset($empresa->numero) ? $empresa->numero : old('numero') }}"  class="form-campo">
                            </div>
                            <div class="col-3 mb-3">
                                     <label class="text-label">Bairro</label>	
                                     <input type="text" name="bairro" id="bairro" value="{{isset($empresa->bairro) ? $empresa->bairro : old('bairro') }}"  class="form-campo bairro">
                             </div>
                             <div class="col-1 mb-2">
                                 <label class="text-label">UF</label>	
                                 <input type="text" name="uf" id="uf" value="{{isset($empresa->uf) ? $empresa->uf : old('uf') }}"   class="form-campo estado"> 
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="complemento" id="complemento" value="{{isset($empresa->complemento) ? $empresa->complemento : old('complemento') }}"  class="form-campo">
                             </div>	
                             <div class="col-2 mb-4">
                                    <label class="text-label">Marcar Configurado</label>	
                                    <select name="configurado" class="form-campo">
                                    	<option value='S' {{$empresa->configurado=='S' ? 'selected' : NULL}}>Sim</option>
                                    	<option value='N' {{$empresa->configurado=='N' ? 'selected' : NULL}}>Não</option>
                                    </select>
                            </div>                        
        						 
                                                 
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade</label>	
                                     <input type="text" name="cidade" id="cidade" value="{{isset($empresa->cidade) ? $empresa->cidade : old('cidade') }}"  class="form-campo cidade">
                             </div>	
                             
                             <div class="col-2 mb-3">
                                     <label class="text-label">Fone</label>	
                                     <input type="text" name="fone" id="fone" value="{{isset($empresa->fone) ? $empresa->fone : old('fone') }}"  class="form-campo mascara-celular ">
                             </div> 
                             <div class="col-5 mb-3">
                                     <label class="text-label">Email</label>	
                                     <input type="text" readonly="readonly" value="{{isset($empresa->email) ? $empresa->email : old('email') }}"  class="form-campo ">
                             </div> 
                           

			</div>
			</fieldset>
			
			
		</div>
	  </div>
	 
   
 		</div>
		<div class="col-12 text-center pb-4">
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
		</form>
		
		
		
	  </div>
	
@endsection