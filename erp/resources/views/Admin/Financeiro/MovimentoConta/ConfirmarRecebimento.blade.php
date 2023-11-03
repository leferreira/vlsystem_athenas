@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">

	<div class="col-12">
		 <div class="caixa">
           <span class="p-2 bg-title text-light text-uppercase  text-branco justify-content-space-between d-flex">
				<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Confirmar Recebimento da Conta: <b class="text-vermelho"> {{$contareceber->id}}</b> </span>
				<div class="d-flex">
				@if($contareceber->venda_id)
					<a href="{{route('admin.venda.financeiro',$contareceber->venda_id )}}" class="btn btn-azul btn-pequeno ml-1" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
				@else
					<a href="{{route('admin.contareceber.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
				@endif
				
					<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
				</div>
			</div>
        
        
        <div class="col-12 mb-4 mt-4">
            <fieldset class="caixa border radius-4">
            <legend class="h5"><i class="far fa-list-alt"></i> Dados da Conta a Receber: {{ $contareceber->id}}</legend>

            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">
					
					<div class="col-6 mb-3">
						<label class="text-label">Descricao</label>
						 <input type="text" name="descricao" readonly="readonly" value="{{ $contareceber->descricao }}" id="descricao"  class="form-campo">												
					</div>
					<div class="col-6">	
                        <label class="text-label d-block">Cliente</label>
                        <input type="text" name="cliente" readonly="readonly" value="{{ $contareceber->cliente->nome_razao_social }}"   class="form-campo">												

                    </div>
                  
                                        
					<div class="col-3 mb-3">
						<label class="text-label">Data Emissão</label>
						 <input type="date" name="data_emissao" readonly="readonly" value="{{ $contareceber->data_emissao }}" id="data_emissao" readonly class="form-campo">												
					</div>	
					
					<div class="col-2 mb-3">
						<label class="text-label">Data Vencimento</label>
						 <input type="date" name="data_vencimento" readonly="readonly" value="{{ $contareceber->data_vencimento }}"  readonly id="data_vencimento"  class="form-campo">												
					</div>						
					<div class="col-2 mb-3">
						<label class="text-label">Valor</label>
						<input type="text" name="valor" id="valor_original" readonly="readonly" readonly="readonly" value="{{ $contareceber->valor }}"    class="form-campo mascara-float">												
					</div>
									
					   
					</div>
				</div>          
			</div>
        </fieldset>
	</div>
<form action="{{ route('admin.contareceber.receber')}}" method="post">
     @csrf
	<div class="col-12 mb-4">
			<input type="hidden" name="tipo_documento" value="{{ ($contareceber->venda_id) ? config('constantes.tipo_documento.VENDA') : config('constantes.tipo_documento.AVULSO') }}" >												
	
            <fieldset class="caixa border radius-4">
            <legend class="h5"><i class="far fa-list-alt"></i> Dados do Pagamento</legend>

            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">
					<div class="col-2 mb-3">
						<label class="text-label">Data Pagamento</label>
						 <input type="date" name="data_pagamento" required value="{{ hoje() }}" id="data_pagamento" readonly class="form-campo">												
					</div>
										
					<div class="col-4 mb-3">
					
						<label class="text-label">Forma de Pagamento</label>
						<select name="forma_pagto_id" class="form-campo" required>	
							<option value="">Selecione uma Opção</option>						
							@foreach($formaPagto as $f)
							     <option value='{{ $f->id}}'>{{ $f->forma_pagto }}</option>
							@endforeach		
						</select>
					</div>	
					<div class="col-2 mb-3">
						<label class="text-label">Número Documento</label>
						<input type="text" name="numero_documento"  id="numero_documento" class="form-campo">												
					</div>
					
					<div class="col-4 mb-3">
						<label class="text-label">Observação</label>
						<input type="text" name="observacao"  id="observacao" class="form-campo">												
					</div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Juros</label>
						<input type="text" name="juros" value="0" id="juros" onkeyup="atualizaValor()" class="form-campo mascara-float">												
					</div>
					<div class="col-2 mb-3">
						<label class="text-label">Multa</label>
						<input type="text" name="multa" value="0" id="multa" onkeyup="atualizaValor()" class="form-campo mascara-float">												
					</div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Desconto</label>
						<input type="text" name="desconto" value="0" id="desconto" onkeyup="atualizaValor()"  class="form-campo mascara-float">												
					</div>				 
					<div class="col-3 mb-3">
						<label class="text-label">Valor a Pagar</label>
						<input type="text" name="valor_a_receber" required readonly="readonly" id="valor_a_receber" value="{{ $contareceber->valor }}"    class="form-campo mascara-float">												
					</div>					
					 <div class="caixa p-2">                   
                <div class="caixa-rodape">
                	<input type="hidden" name="conta_receber_id" value="{{ $contareceber->id }}" /> 
                	<input type="hidden" name="valor_original" value="{{ $contareceber->valor }}" />
					<input type="submit" value="Salvar" class="btn btn-verde btn-medio d-inline-block" />                   
				</div>
            </div>							
					   
					</div>
				</div>          
			</div>
        </fieldset>
	</div>
   
   </form>
 
</div>

<script>


function atualizaValor(){
	var saldo_devedor  = ($('#valor_original').val() !="") ? converteMoedaFloat($('#valor_original').val()) : parseFloat(0);
	var juros 			= ($('#juros').val() !="") ? converteMoedaFloat($('#juros').val()) : parseFloat(0);
	var multa 			= ($('#multa').val() !="") ? converteMoedaFloat($('#multa').val()) : parseFloat(0);
	var desconto 		= ($('#desconto').val() !="") ? converteMoedaFloat($('#desconto').val()) : parseFloat(0);	

	
	var valor_a_receber = parseFloat(saldo_devedor) + parseFloat(juros) + parseFloat(multa) - parseFloat(desconto);
	$('#valor_a_receber').val(converteFloatMoeda(valor_a_receber));
	
	
	
	
}
</script>
@endsection