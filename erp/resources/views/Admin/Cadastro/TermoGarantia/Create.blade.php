@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" h5 mb-0 "><i class="fas fa-plus-circle"></i> Cadastrar termogarantias</span>
		<div>
			<a href="{{route('admin.termogarantia.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>	
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>			
		</div>
	</div>                 
 @if(isset($termogarantia))    
   <form action="{{route('admin.termogarantia.update', $termogarantia->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.termogarantia.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2 mt-1">
			
			<fieldset>
				<legend>Informações básicas</legend>
				
				<div class="rows">
				                   												
					
					<div class="col-3 mb-3" >
							<label class="text-label" >Data</label>	
							<input type="date" name="data_garantia"  value="{{isset($termogarantia->data_garantia) ? $termogarantia->data_garantia : old('data_garantia') }}"  class="form-campo">
					</div>					
					
					<div class="col-9 mb-3">
							<label class="text-label">Referência Garantia</label>	
							<input type="text" name="referencia_garantia"  value="{{isset($termogarantia->referencia_garantia) ? $termogarantia->referencia_garantia : old('referencia_garantia') }}"  class="form-campo ">
					</div>
			
					
					<div class="col-12 mb-3" >
							<label class="text-label">Texto Garantia</label>	
							<textarea rows="15" cols="5" name="texto_garantia" class="form-campo">{{isset($termogarantia->texto_garantia) ? $termogarantia->texto_garantia : old('texto_garantia') }}</textarea>
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

<script>
	function tipoCliente(){
		var tp = $("#tipo_cliente").val();
		
		if(tp=="F"){
			$("#div_pesquisar").hide();
            $("#div_tipo_contribuinte").hide();
            $("#divIscEstadual").hide();
            $("#divSuframa").hide();
            $("#divFantasia").hide();
            
            $("#lblInscEstadual").html("RG");
            $("#lblCnpj").html('CPF');
            $("#lblRazaoSocial").html('Nome');
            $("#cnpj").mask('000.000.000-00', {reverse: true});
       
            
		}else{
			$("#div_pesquisar").show();
            $("#div_tipo_contribuinte").show();
            $("#divIscEstadual").show();
            $("#divSuframa").show();
            $("#divFantasia").show();
            
            $("#lblInscEstadual").html("Inscrição Estadual");
            $("#lblCnpj").html('CNPJ');
            $("#lblRazaoSocial").html('Razão Social');
            $("#cnpj").mask('00.000.000/0000-00', {reverse: true});
          
		}
	}
</script>
@endsection