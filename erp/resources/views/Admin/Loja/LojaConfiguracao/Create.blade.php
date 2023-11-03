@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
	<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i>Configurações da loja </span>
	<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
</div>                      
 @if(isset($configuracao))    
   <form action="{{route('admin.lojaconfiguracao.update', $configuracao->id)}}" method="POST" enctype="multipart/form-data">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.lojaconfiguracao.store')}}" method="Post" enctype="multipart/form-data">
@endif
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
									<img src="{{asset('assets/admin/img/logo_padrao.svg')}}" class="img-fluido" id="imgUp">
								@else									
									<img src="{{ url($img) }}" class="img-fluido" id="imgUp">
								@endif									
									<input type="file" name="file" id="img_logo" onChange="valida_imagem('img_logo','imgUp')" class="d-none">

									<span>Carregar imagem</span>
								</label>
								<small class="d-block text-center">Tamanho de <b>170px</b> por <b>40px</b></small>
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
                                <div class="col-4 mb-3">
                                        <label class="text-label">Url da Loja</label>
                                        <input type="text" name="url" value="{{isset($configuracao->url) ? $configuracao->url : old('url')}}"  class="form-campo ">
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