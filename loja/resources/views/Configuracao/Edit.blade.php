@extends("template_config")
@section("conteudo")

<div class="col-12">
                     
                    
	<form action="{{route('configuracao.salvar')}}" method="Post" enctype="multipart/form-data">

	@csrf
   <div class="p-4">
	  
	  <div>
		<fieldset>
				<legend>Informações básicas</legend>
                           <div class="rows"> 
                           <div class="col-4 mb-3 text-center">
								<label class="banner-thumb">
								@php
									$img = ($configuracao->logo) ??  false; 
								@endphp
								@if(!$img)
									<img src="{{url('storage/logo/logo.png')}}" class="img-fluido" id="imgUp">
								@else									
									<img src="{{ url($img) }}" class="img-fluido" id="imgUp">
								@endif									
									<input type="file" name="file" id="img_logo" onChange="valida_imagem('img_logo')" class="d-none">

									<span>Carregar imagem</span>
								</label>
								<small class="d-block text-center">Tamanho de <b>170px</b> por <b>40px</b></small>
								</div>
								<div class="col-4 mb-3">
                                        <label class="text-label">Código da Empresa</label>
                                        <input type="text" required name="empresa_uuid" value="{{isset($configuracao->empresa_uuid) ? $configuracao->empresa_uuid : old('empresa_uuid')}}"  class="form-campo">
                                </div>
                                                               
                                <div class="col-4 mb-3">
                                        <label class="text-label">Nome</label>
                                        <input type="text" required name="nome" value="{{isset($configuracao->nome) ? $configuracao->nome : old('nome')}}"  class="form-campo">
                                </div>
                                <div class="col-4 mb-3">
                                        <label class="text-label">email</label>
                                        <input type="text" required name="email" value="{{isset($configuracao->email) ? $configuracao->email : old('email')}}"  class="form-campo">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">cep</label>
                                        <input type="text" required name="cep" value="{{isset($configuracao->cep) ? $configuracao->cep : old('cep')}}"  class="form-campo busca_cep mascara-cep">
                                </div>
                                <div class="col-4 mb-3">
                                        <label class="text-label">Rua</label>
                                        <input type="text" required name="rua" value="{{isset($configuracao->rua) ? $configuracao->rua : old('rua')}}"  class="form-campo rua">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">numero</label>
                                        <input type="text" required name="numero" value="{{isset($configuracao->numero) ? $configuracao->numero : old('numero')}}"  class="form-campo">
                                </div>
                                <div class="col-4 mb-3">
                                        <label class="text-label">bairro</label>
                                        <input type="text" required name="bairro" value="{{isset($configuracao->bairro) ? $configuracao->bairro : old('bairro')}}"  class="form-campo bairro">
                                </div>
                                <div class="col-4 mb-3">
                                        <label class="text-label">cidade</label>
                                        <input type="text" required name="cidade" value="{{isset($configuracao->cidade) ? $configuracao->cidade : old('cidade')}}"  class="form-campo cidade">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">uf</label>
                                        <input type="text" required name="uf" value="{{isset($configuracao->uf) ? $configuracao->uf : old('uf')}}"  class="form-campo estado">
                                </div>
                                
                                
                                <div class="col-2 mb-3">
                                        <label class="text-label">telefone</label>
                                        <input type="text" required name="telefone" value="{{isset($configuracao->telefone) ? $configuracao->telefone : old('telefone')}}"  class="form-campo mascara-celular">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">latitude</label>
                                        <input type="text" name="latitude" value="{{isset($configuracao->latitude) ? $configuracao->latitude : old('latitude')}}"  class="form-campo mascara-celular">
                                </div>
                                
                                <div class="col-2 mb-3">
                                        <label class="text-label">longitude</label>
                                        <input type="text" name="longitude" value="{{isset($configuracao->longitude) ? $configuracao->longitude : old('longitude')}}"  class="form-campo">
                                </div>
                                
                           </div>
						</fieldset>
						<fieldset class="mt-4">
							<legend>Links Redes sociais</legend>
                           <div class="rows">  
                                <div class="col-4 mb-3">
                                        <label class="text-label">link facebook</label>
                                        <input type="text" name="link_facebook" value="{{isset($configuracao->link_facebook) ? $configuracao->link_facebook : old('link_facebook')}}"  class="form-campo" placeholder="Inserir link">
                                </div>
                                <div class="col-4 mb-3">
                                        <label class="text-label">link twiter</label>
                                        <input type="text" name="link_twiter" value="{{isset($configuracao->link_twiter) ? $configuracao->link_twiter : old('link_twiter')}}"  class="form-campo" placeholder="Inserir link">
                                </div>
                                <div class="col-4 mb-3">
                                        <label class="text-label">link instagram</label>
                                        <input type="text" name="link_instagram" value="{{isset($configuracao->link_instagram) ? $configuracao->link_instagram : old('link_instagram')}}"  class="form-campo" placeholder="Inserir link">
                                </div>
                            </div>
						</fieldset>	
						<fieldset class="mt-4">
							<legend>Links de pagamento</legend>
                           <div class="rows">  
                                <div class="col-2 mb-3">
                                        <label class="text-label">frete gratis valor</label>
                                        <input type="text" required name="frete_gratis_valor" value="{{isset($configuracao->frete_gratis_valor) ? $configuracao->frete_gratis_valor : old('frete_gratis_valor')}}"  class="form-campo">
                                </div>
                                <div class="col mb-3">
                                        <label class="text-label">mercadopago public key</label>
                                        <input type="text" name="mercadopago_public_key" value="{{isset($configuracao->mercadopago_public_key) ? $configuracao->mercadopago_public_key : old('mercadopago_public_key')}}"  class="form-campo">
                                </div>
                                
                                <div class="col mb-3">
                                        <label class="text-label">mercadopago access token</label>
                                        <input type="text" name="mercadopago_access_token" value="{{isset($configuracao->mercadopago_access_token) ? $configuracao->mercadopago_access_token: old('mercadopago_access_token')}}"  class="form-campo">
                                </div>
                                </div>
                        </fieldset>

						<fieldset class="mt-4">
							<legend>Política de Privacidade</legend>
                           <div class="rows">  						
                                <div class="col-12 mb-3">
                                        <label class="text-label">Política de Privacidade</label>
                                        <textarea rows="10" cols="150" name="politica_privacidade" class="form-campo">{{isset($configuracao->politica_privacidade) ? $configuracao->politica_privacidade : old('politica_privacidade')}}</textarea>
                                </div>
                            </div>
                        </fieldset>  
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


	