@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">
	
  <div class="col-12 px-4"><span class="titulo mb-4 mt-3">Configuração de Delivery</span></div>

  <div class="col-12 px-4">
<form method="post" action="{{route('admin.deliveryconfig.store')}}" enctype="multipart/form-data">
<input type="hidden" name="id" value="{{{ isset($deliveryconfig->id) ? $deliveryconfig->id : 0 }}}">
	@csrf                  
            
            
	<div class="rows">					
			<div class="col-6 mb-3">
					<label class="text-label">Link do Facebook</label>	
					<input type="text" name="link_face" value="{{{ isset($deliveryconfig) ? $deliveryconfig->link_face : old('link_face') }}}"  class="form-campo">
					@if($errors->has('link_face'))
					<div class="invalid-feedback">
						{{ $errors->first('link_face') }}
					</div>
					@endif
			</div>
			<div class="col-6 mb-3">
					<label class="text-label">Link do Twiter</label>	
					<input type="text" name="link_twiteer" value="{{{ isset($deliveryconfig) ? $deliveryconfig->link_twiteer : old('link_twiteer') }}}"  class="form-campo">
					@if($errors->has('link_twiteer'))
					<div class="invalid-feedback">
						{{ $errors->first('link_twiteer') }}
					</div>
					@endif
			</div>
			<div class="col-6 mb-3">
					<label class="text-label">Link do Google</label>	
					<input type="text" name="link_google" value="{{{ isset($deliveryconfig) ? $deliveryconfig->link_google : old('link_google') }}}"  class="form-campo">
					@if($errors->has('link_google'))
					<div class="invalid-feedback">
						{{ $errors->first('link_google') }}
					</div>
					@endif
			</div>
			<div class="col-6 mb-3">
					<label class="text-label">Link do Instagram</label>	
					<input type="text" name="link_instagram" value="{{{ isset($deliveryconfig) ? $deliveryconfig->link_instagram : old('link_instagram') }}}"  class="form-campo">
					@if($errors->has('link_instagram'))
					<div class="invalid-feedback">
						{{ $errors->first('link_instagram') }}
					</div>
					@endif
			</div>					                                  
												
			<div class="col-6 mb-3">
					<label class="text-label">Endereço</label>	
					<input type="text" name="endereco" value="{{{ isset($deliveryconfig) ? $deliveryconfig->endereco : old('endereco') }}}"  class="form-campo">
					@if($errors->has('endereco'))
					<div class="invalid-feedback">
						{{ $errors->first('endereco') }}
					</div>
					@endif
			</div>
			<div class="col-3 mb-3">
					<label class="text-label">Bairro</label>	
					<input type="text" name="" value="{{{ isset($deliveryconfig) ? $deliveryconfig->link_instagram : old('link_instagram') }}}"  class="form-campo">
					@if($errors->has('link_face'))
					<div class="invalid-feedback">
						{{ $errors->first('link_face') }}
					</div>
					@endif
			</div>	
			<div class="col-3 mb-3">
					<label class="text-label">Telefone</label>	
					<input type="text" name="telefone" value="{{{ isset($deliveryconfig) ? $deliveryconfig->telefone : old('telefone') }}}"  class="form-campo">
					@if($errors->has('telefone'))
					<div class="invalid-feedback">
						{{ $errors->first('telefone') }}
					</div>
					@endif
			</div>				
			
			<div class="col-3 mb-3">
					<label class="text-label">Tempo Medio Entrega</label>	
					<input type="text" name="tempo_medio_entrega" value="{{{ isset($deliveryconfig) ? $deliveryconfig->tempo_medio_entrega : old('tempo_medio_entrega') }}}"  class="form-campo">
					@if($errors->has('tempo_medio_entrega'))
					<div class="invalid-feedback">
						{{ $errors->first('tempo_medio_entrega') }}
					</div>
					@endif
			</div>	
			<div class="col-3 mb-3">
					<label class="text-label">Valor Entrega Padrão</label>	
					<input type="text" name="valor_entrega" value="{{{ isset($deliveryconfig) ? $deliveryconfig->valor_entrega : old('valor_entrega') }}}"  class="form-campo">
					@if($errors->has('valor_entrega'))
					<div class="invalid-feedback">
						{{ $errors->first('valor_entrega') }}
					</div>
					@endif
			</div>
			<div class="col-3 mb-3">
					<label class="text-label">Máximo de Adicionais</label>	
					<input type="text" name="maximo_adicionais" value="{{{ isset($deliveryconfig) ? $deliveryconfig->maximo_adicionais : old('maximo_adicionais') }}}"  class="form-campo">
					@if($errors->has('maximo_adicionais'))
					<div class="invalid-feedback">
						{{ $errors->first('maximo_adicionais') }}
					</div>
					@endif
			</div>
			<div class="col-3 mb-3">
					<label class="text-label">Máximo Adicionais Pizza</label>	
					<input type="text" name="maximo_adicionais_pizza" value="{{{ isset($deliveryconfig) ? $deliveryconfig->maximo_adicionais_pizza : old('maximo_adicionais_pizza') }}}"  class="form-campo">
					@if($errors->has('maximo_adicionais_pizza'))
					<div class="invalid-feedback">
						{{ $errors->first('maximo_adicionais_pizza') }}
					</div>
					@endif
			</div>
			
			<div class="col-3 mb-3">
					<label class="text-label">Valor KM entrega</label>	
					<input type="text" name="valor_km" value="{{{ isset($deliveryconfig) ? $deliveryconfig->valor_km : old('valor_km') }}}"  class="form-campo">
					@if($errors->has('valor_km'))
					<div class="invalid-feedback">
						{{ $errors->first('valor_km') }}
					</div>
					@endif
			</div>
			
			<div class="col-3 mb-3">
					<label class="text-label">Máximo KM entrega</label>	
					<input type="text" name="maximo_km_entrega" value="{{{ isset($deliveryconfig) ? $deliveryconfig->maximo_km_entrega : old('maximo_km_entrega') }}}"  class="form-campo">
					@if($errors->has('maximo_km_entrega'))
					<div class="invalid-feedback">
						{{ $errors->first('maximo_km_entrega') }}
					</div>
					@endif
			</div>
			
			<div class="col-3 mb-3">
					<label class="text-label">Tempo para Cancelar</label>	
					<input type="text" name="tempo_maximo_cancelamento" value="{{{ isset($deliveryconfig) ? $deliveryconfig->tempo_maximo_cancelamento : old('tempo_maximo_cancelamento') }}}"  class="form-campo">
					@if($errors->has('tempo_maximo_cancelamento'))
					<div class="invalid-feedback">
						{{ $errors->first('tempo_maximo_cancelamento') }}
					</div>
					@endif
			</div>
			<div class="col-3 mb-3">
					<label class="text-label">Nome visualização Web</label>	
					<input type="text" name="nome_exibicao_web" value="{{{ isset($deliveryconfig) ? $deliveryconfig->nome_exibicao_web : old('nome_exibicao_web') }}}"  class="form-campo">
					@if($errors->has('nome_exibicao_web'))
					<div class="invalid-feedback">
						{{ $errors->first('nome_exibicao_web') }}
					</div>
					@endif
			</div>
			
			<div class="col-3 mb-3">
					<label class="text-label">Latitude</label>	
					<input type="text" name="latitude" value="{{{ isset($deliveryconfig) ? $deliveryconfig->latitude : old('latitude') }}}"  class="form-campo">
					@if($errors->has('latitude'))
					<div class="invalid-feedback">
						{{ $errors->first('latitude') }}
					</div>
					@endif
			</div>
			
			<div class="col-3 mb-3">
					<label class="text-label">Longitude</label>	
					<input type="text" name="longitude" value="{{{ isset($deliveryconfig) ? $deliveryconfig->longitude : old('longitude') }}}"  class="form-campo">
					@if($errors->has('longitude'))
					<div class="invalid-feedback">
						{{ $errors->first('longitude') }}
					</div>
					@endif
			</div>
			
												
			<div class="col-6 mb-3">
					<span class="text-label">Imagem</span>	
					<div class="file">
						<input type="file" name="file"  id="imagem">
						<input type="hidden" name="profile_avatar_remove">
						<label for="imagem">Selecionar imagem</label>
					</div>
			</div>
                <div class="col-12 mb-3">
					<label class="text-label">Política de Privacidade</label>	
					<textarea class="form-campo" name="descricao" placeholder="Descrição" rows="3">{{{ isset($deliveryconfig->politica_privacidade) ? $deliveryconfig->politica_privacidade : old('politica_privacidade') }}}</textarea>
					@if($errors->has('descricao'))
					<div class="invalid-feedback">
						{{ $errors->first('descricao') }}
					</div>
					@endif
					
			</div>
			<div class="col-3 m-auto pb-4">                   
                    <div class="caixa-rodape">
                    <input type="submit" value="Salvar Configurações" class="btn btn-azul btn-medio d-inline-block">
                                      
                </div>
                </div>   
					
			</div>
                 
        </div>
</form>
    </div>
</div>


@endsection