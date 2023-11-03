@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-check"></i> Detalhes Fatura</span>
	<div class="d-flex">
		<a href="{{route('admin.fatura.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	</div>
</span>
<div class="rows">

	<div class="col-12 mt-4">
	
        <div class="col-12 mb-4">
            <fieldset class="caixa border radius-4">
            <legend><i class="far fa-list-alt"></i> Dados da Conta a Pagar: <b class="text-vermelho">{{ $fatura->id}}</b></legend>

            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">
					
					<div class="col-6 mb-3">
						<label class="text-label">Descricao</label>
						 <input type="text" name="descricao" value="{{ $fatura->descricao }}" id="descricao"  class="form-campo">												
					</div>
					<div class="col-6">	
                        <label class="text-label d-block">Observação</label>
                        <input type="text" name="observacao" value="{{ $fatura->observacao }}"   class="form-campo">												

                    </div>
                    
                                        
					<div class="col-4 mb-3">
						<label class="text-label">Data Emissão</label>
						 <input type="date" name="data_emissao" value="{{ $fatura->data_emissao }}" id="data_emissao" readonly class="form-campo">												
					</div>	
					
					<div class="col-4 mb-3">
						<label class="text-label">Data Vencimento</label>
						 <input type="date" name="data_vencimento" value="{{ $fatura->data_vencimento }}"  readonly id="data_vencimento"  class="form-campo">												
					</div>						
					<div class="col-4 mb-3">
						<label class="text-label">Valor</label>
						<input type="text" name="valor" id="valor_original" readonly="readonly" value="{{ $fatura->valor }}"    class="form-campo">												
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
						 <input type="date" name="data_pagamento" readonly="readonly" value="{{ $pagamento->data_pagamento }}"  readonly class="form-campo">												
					</div>
										
					<div class="col-4 mb-3">
						<label class="text-label">Forma de Pagamento</label>
						<input type="text"  readonly="readonly"  value="{{ $pagamento->forma_pagto->forma_pagto }}" class="form-campo">	
					</div>	
					<div class="col-2 mb-3">
						<label class="text-label">Número Documento</label>
						<input type="text" name="numero_documento" readonly="readonly" value="{{ $pagamento->numero_documento }}"  class="form-campo">												
					</div>
					
					<div class="col-4 mb-3">
						<label class="text-label">Observação</label>
						<input type="text" name="observacao" readonly="readonly" value="{{ $pagamento->observacao }}"class="form-campo">												
					</div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Juros</label>
						<input type="text" name="juros" value="0" readonly="readonly" value="{{ $pagamento->juros }}" class="form-campo">												
					</div>
					<div class="col-2 mb-3">
						<label class="text-label">Multa</label>
						<input type="text" name="multa" value="0" readonly="readonly" value="{{ $pagamento->multa }}" class="form-campo">												
					</div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Desconto</label>
						<input type="text" name="desconto" value="0" readonly="readonly" id="desconto" value="{{ $pagamento->desconto }}"  class="form-campo">												
					</div>				 
					<div class="col-3 mb-3">
						<label class="text-label">Valor Pago</label>
						<input type="text"  readonly="readonly" id="valor_a_receber" value="{{ $pagamento->valor_pago }}"    class="form-campo">												
					</div>					
					 <div class="caixa p-2">                   
               
            </div>							
					   
					</div>
				</div>          
			</div>
        </div>
	</div>


@endsection