@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">

	<div class="col-12">
		 <div class="caixa">
           <span class="p-2 bg-title text-light text-uppercase  text-branco justify-content-space-between d-flex">
				<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Conta Pagar: <b class="text-vermelho"> {{$contapagar->id}}</b> </span>
				<div class="d-flex">
					@if(isset($contapagar->compra_id))
						<a href="{{route('admin.compra.financeiro',$contapagar->compra_id )}}" class="btn btn-azul btn-pequeno ml-1" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
					@else
						<a href="{{route('admin.contapagar.index')}}" class="btn btn-azul btn-pequeno ml-1" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
					@endif
					<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
				</div>
			</div>
        
        
        <div class="col-12 mb-4">
            <div class="caixa border radius-4">
            <span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Dados da Conta a Pagar: {{ $contapagar->id}}</span>

            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">
					
					<div class="col-6 mb-3">
						<label class="text-label">Descricao</label>
						 <input type="text" name="descricao" readonly="readonly" value="{{ $contapagar->descricao }}" id="descricao"  class="form-campo">												
					</div>
					<div class="col-6">	
                        <label class="text-label d-block">Cliente</label>
                        <input type="text" name="cliente" readonly="readonly" value="{{ $contapagar->fornecedor->razao_social }}"   class="form-campo">												

                    </div>
                  
                                        
					<div class="col-3 mb-3">
						<label class="text-label">Data Emissão</label>
						 <input type="date" name="data_emissao" readonly="readonly" value="{{ $contapagar->data_emissao }}" id="data_emissao" readonly class="form-campo">												
					</div>	
					
					<div class="col-2 mb-3">
						<label class="text-label">Data Vencimento</label>
						 <input type="date" name="data_vencimento" readonly="readonly" value="{{ $contapagar->data_vencimento }}"  readonly id="data_vencimento"  class="form-campo">												
					</div>						
					<div class="col-2 mb-3">
						<label class="text-label">Valor</label>
						<input type="text" name="valor" id="valor_original" readonly="readonly" value="{{ $contapagar->valor }}"    class="form-campo mascara-float">												
					</div>
									
					   
					</div>
				</div>          
			</div>
        </div>
	</div>

	<div class="col-12 mb-4">
            <div class="caixa border radius-4">
            <span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Dados do Pagamento</span>

            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">
					<div class="col-2 mb-3">
						<label class="text-label">Data Pagamento</label>
						 <input type="date" name="data_pagamento" readonly="readonly" value="{{ $pagamento->data_pagamento ?? null }}"  readonly class="form-campo">												
					</div>
										
					<div class="col-4 mb-3">
						<label class="text-label">Forma de Pagamento</label>
						<input type="text"  readonly="readonly"  value="{{ $pagamento->forma_pagto->forma_pagto  ?? null}}" class="form-campo">	
					</div>	
					<div class="col-2 mb-3">
						<label class="text-label">Número Documento</label>
						<input type="text" name="numero_documento" readonly="readonly" value="{{ $pagamento->numero_documento ?? null }}"  class="form-campo">												
					</div>
					
					<div class="col-4 mb-3">
						<label class="text-label">Observação</label>
						<input type="text" name="observacao" readonly="readonly" value="{{ $pagamento->observacao ?? null }}"class="form-campo">												
					</div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Juros</label>
						<input type="text" name="juros"  readonly="readonly" value="{{ $pagamento->juros ?? null }}" class="form-campo mascara-float">												
					</div>
					<div class="col-2 mb-3">
						<label class="text-label">Multa</label>
						<input type="text" name="multa"  readonly="readonly" value="{{ $pagamento->multa ?? null }}" class="form-campo  mascara-float">												
					</div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Desconto</label>
						<input type="text" name="desconto"  readonly="readonly" id="desconto" value="{{ $pagamento->desconto ?? null }}"  class="form-campo mascara-float">												
					</div>				 
					<div class="col-3 mb-3">
						<label class="text-label">Valor pago</label>
						<input type="text" name="valor_a_pagar" readonly="readonly" id="valor_a_pagar" value="{{ $pagamento->valor_pago ?? null }}"    class="form-campo mascara-float">												
					</div>					
					 <div class="caixa p-2">                   
               
            </div>							
					   
					</div>
				</div>          
			</div>
        </div>
	</div>
 
 
</div>

@endsection