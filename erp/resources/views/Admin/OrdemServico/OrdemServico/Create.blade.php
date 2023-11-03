@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" h5 mb-0 "><i class="fas fa-plus-circle"></i> Cadastrar Ordem de Servicos</span>
		<div>
			<a href="{{route('admin.ordemservico.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>	
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>			
		</div>
	</div>                 
 @if(isset($ordemservico))    
   <form action="{{route('admin.ordemservico.update', $ordemservico->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.ordemservico.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2 mt-1">
			
			<fieldset>
				<legend>Informações básicas</legend>
				
				<div class="rows">
					<div class="col-2 mb-3">
							<label class="text-label">Data Fabricação</label>	
							<input type="date" name="data_abertura"  value="{{isset($ordemservico->data_abertura) ? $ordemservico->data_abertura : hoje() }}"  class="form-campo ">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label">Previsão de Entrega</label>	
							<input type="date" name="previsao_entrega"  value="{{isset($ordemservico->previsao_entrega) ? previsao_entrega : old('previsao_entrega') }}"  class="form-campo ">
					</div>
					
					<div class="col-4">
                        <label class="text-label ">Cliente<span class="text-vermelho">*</span></label>
                        <div class="group-btn">	                                
                            <input type="text"  id="desc_cliente" value="{{$cliente->nome_razao_social ?? null}}" class="form-campo">
                            <input type="hidden" name="cliente_id" value="{{$cliente->id ?? null}}"  id="cliente_id" >       
                           <a href="{{route('admin.cliente.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
						</div>                               
                    </div>
                    
                    <div class="col-4 mb-3">
							<label class="text-label"  >Equipamento<span class="text-vermelho">*</span></label>	
							<div class="group-btn">	 
							<select name="equipamento_id" id="equipamento_id" class="form-campo">
								<option value="">Selecione</option>
								@foreach($equipamentos as $e)
									<option value="{{$e->id}}">{{$e->equipamento}}</option>
								@endforeach
							</select>
							<a href="javascript:;" onclick="abrirEquipamento()" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Equipamento"></a>
						</div>
					</div>
					
					<div class="col-4 mb-3">
							<label class="text-label"  >Vendedor<span class="text-vermelho">*</span></label>	
							<div class="group-btn">	 
							<select name="vendedor_id" id="vendedor_id" class="form-campo">
								<option value="">Selecione</option>
								@foreach($vendedores as $v)
									<option value="{{$v->id}}">{{$v->nome}}</option>
								@endforeach
							</select>
							<a href="{{route('admin.vendedor.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Vendedor"></a>
						</div>
					</div>
					
																	
					<div class="col-4 mb-3">
							<label class="text-label"  >Técnico/Responsável<span class="text-vermelho">*</span></label>	
							<div class="group-btn">	
							<select name="tecnico_id"  id="tecnico_id"class="form-campo">
								<option value="">Selecione</option>
								@foreach($tecnicos as $t)
									<option value="{{$t->id}}">{{$t->nome}}</option>
								@endforeach
							</select>
							<a href="{{route('admin.tecnico.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Técnico"></a>
						</div>
					</div>                                    
					<div class="col-2 mb-3" >
							<label class="text-label">Garantia (dias)</label>	
							<input type="number" name="garantia" id="garantia" value="{{isset($ordemservico->garantia) ? $ordemservico->garantia : old('garantia') }}" class="form-campo">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label"  >Termo Garantia<span class="text-vermelho">*</span></label>	
							<div class="group-btn">	
							<select name="garantia_id" class="form-campo">
								<option value="">Selecione</option>
								@foreach($termos as $t)
									<option value="{{$t->id}}">{{$t->referencia_garantia}}</option>
								@endforeach
							</select>
							<a href="{{route('admin.termogarantia.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Técnico"></a>
						</div>
					</div>
								
					
					
					
					<div class="col-6 mb-3" >
							<label class="text-label">Descrição Produto/Serviço</label>	
							<textarea rows="15" cols="5" name="descricao_produto" class="form-campo">{{isset($ordemservico->descricao_produto) ? $ordemservico->descricao_produto : old('descricao_produto') }}</textarea>
					</div>
					
					<div class="col-6 mb-3" >
							<label class="text-label">Devolução</label>	
							<textarea rows="15" cols="5" name="defeito" class="form-campo">{{isset($ordemservico->defeito) ? $ordemservico->defeito : old('defeito') }}</textarea>
					</div>
					
					<div class="col-6 mb-3" >
							<label class="text-label">Observações</label>	
							<textarea rows="15" cols="5" name="observacoes" class="form-campo">{{isset($ordemservico->observacoes) ? $ordemservico->observacoes : old('observacoes') }}</textarea>
					</div>
					
					<div class="col-6 mb-3" >
							<label class="text-label">Laudo Técnico</label>	
							<textarea rows="15" cols="5" name="laudo_tecnico" class="form-campo">{{isset($ordemservico->laudo_tecnico) ? $ordemservico->laudo_tecnico: old('laudo_tecnico') }}</textarea>
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


  @include ("Admin.Cadastro.Cliente.modal.modalCadastroCliente")
  @include ("Admin.Cadastro.Tecnico.modal.modalCadastroTecnico")
  @include ("Admin.Cadastro.Vendedor.modal.modalCadastroVendedor")
  @include ("Admin.Cadastro.Equipamento.modal.modalCadastroEquipamento")
  
  <script>
	function abrirEquipamento(){
		var cliente_id = $("#cliente_id").val();
		
		if(cliente_id==""){
			alert("Selecione primeiramente um cliente"); 
			return;   
        }
        $(".cliente_id").val(cliente_id);
        abrirModal('#modalCadEquipamento');
        
	}
</script>

@endsection