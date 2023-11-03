@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" h5 mb-0 "><i class="fas fa-plus-circle"></i> Cadastrar Recorrência</span>
		<div>
			<a href="{{route('admin.produtorecorrente.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>	
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>			
		</div>
	</div>                 
                      
	<form action="{{route('admin.produtorecorrente.store')}}" method="Post">

	@csrf
   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2 mt-1">
			
			<fieldset>
				<legend>Informações básicas</legend>
				
				<div class="rows">
					<div class="col-8 mb-3" >
							<label class="text-label">Descrição</label>	
							<input type="text" name="descricao"  value="{{isset($produtorecorrente->descricao) ? $produtorecorrente->descricao : old('descricao') }}" class="form-campo">
					</div>
					<div class="col-4 mb-3" >
							<label class="text-label">Valor</label>	
							<input type="text" name="valor" id="valor" value="{{isset($produtorecorrente->valor) ? $produtorecorrente->valor : old('valor') }}" class="form-campo mascara-float">
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