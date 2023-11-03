@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" mb-0 h5"><i class="fas fa-plus-circle"></i> Cadastrar clientes</span>
		<div>
			<a href="{{route('admin.cliente.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>		
		</div>
	</div>                 

   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2 mt-1">
			<small class="d-block text-right text-vermelho">(*) Campos obrigatórios</small>
			
			 @if(isset($enderecocliente))    
               <form action="{{route('admin.enderecocliente.update', $enderecocliente->id)}}" method="POST">
               <input name="_method" type="hidden" value="PUT"/>
             @else                       
            	<form action="{{route('admin.enderecocliente.store')}}" method="Post">
            @endif
            	@csrf
	
			<fieldset>
					<legend>Endereço</legend>
													
					<div class="rows">	
							<div class="col-2 mb-3">
                            <label class="text-label">Cep<span class="text-vermelho">*</span></label>	
                            <input type="text" name="cep" id="cep" required value="{{isset($endereco->cep) ? $endereco->cep : old('cep') }}"  class="form-campo busca_cep mascara-cep">
                            </div>
                            
                            <div class="col-4 mb-3">
                                    <label class="text-label">Logradouro<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="logradouro" maxlength="60" required id="logradouro" value="{{isset($endereco->logradouro) ? $endereco->logradouro : old('logradouro') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Numero<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="numero" required id="numero" value="{{isset($endereco->numero) ? $endereco->numero : old('numero') }}"  class="form-campo">
                            </div>
                            <div class="col-4 mb-3">
                                     <label class="text-label">Bairro</label>	
                                     <input type="text" name="bairro"  maxlength="60" id="bairro" value="{{isset($endereco->bairro) ? $endereco->bairro : old('bairro') }}"  class="form-campo bairro">
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="complemento" maxlength="60" id="complemento" value="{{isset($endereco->complemento) ? $endereco->complemento : old('complemento') }}"  class="form-campo">
                             </div>	                            
        						 
                             <div class="col-2 mb-2">
                                 <label class="text-label">UF</label>	
                                 <input type="text" name="uf" id="uf" required  value="{{isset($endereco->uf) ? $endereco->uf : old('uf') }}"   class="form-campo estado"> 
                             </div>                    
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade</label>	
                                     <input type="text" name="cidade" maxlength="60" required id="cidade" value="{{isset($endereco->cidade) ? $endereco->cidade : old('cidade') }}"  class="form-campo cidade">
                             </div>	
                             <div class="col-2 mb-3">
                                     <label class="text-label">Ibge</label>	
                                     <input type="text" name="ibge" required id="ibge" value="{{isset($endereco->ibge) ? $endereco->ibge : old('ibge') }}"  class="form-campo ibge ">
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
	function tipoCliente(){
		var tp = $("#tipo_cliente").val();
		
		if(tp=="F"){
			$("#div_pesquisar").hide();
            $("#divIscEstadual").hide();
            $("#divSuframa").hide();
            $("#divFantasia").hide();
            
            $("#lblInscEstadual").html("RG");
            $("#lblCnpj").html('CPF');
            $("#lblRazaoSocial").html('Nome');
            $("#cnpj").mask('000.000.000-00', {reverse: true});
            $("#indFinal option:contains(Sim)").attr('selected', true);
            $("#tipo_contribuinte option:contains(Não)").attr('selected', true);
        }else{
			$("#div_pesquisar").show();
            $("#divIscEstadual").show();
            $("#divSuframa").show();
            $("#divFantasia").show();
            
            $("#lblInscEstadual").html("Inscrição Estadual");
            $("#lblCnpj").html('CNPJ');
            $("#lblRazaoSocial").html('Razão Social');
            $("#cnpj").mask('00.000.000/0000-00', {reverse: true});
          	
          	$("#lblCnpj").html('CNPJ');
          	$("#indFinal option:contains(Não)").attr('selected', true);
          	$("#tipo_contribuinte option:contains(ICMS)").attr('selected', true);
          	
		}
	}
</script>
@endsection