@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">        
        <div class="col-12 mb-0">
		<span class="p-2 bg-title text-light text-uppercase  text-branco justify-content-space-between d-flex">
			<span class="h5 mb-0"><i class="fas fa-plus-circle"></i>  Dados da Conta a Pagar: <b class="text-vermelho">{{ $contapagar->id}}</b></span>
			<div class="d-flex">
				@if($contapagar->compra_id)
					<a href="{{route('admin.compra.financeiro', $contapagar->compra_id)}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
				@else
					<a href="{{route('admin.contapagar.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
				@endif
				<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
			</div>
		</span> 	
            <div class="caixa p-3">
				<fieldset>
				<legend>Dados da conta a Pagar </legend>
				<div class="caixa">
					<div class="px-4">
					<div class="rows pt-3 pb-4">
						
						<div class="col-4 mb-3">
							<label class="text-label">Descricao</label>
							 <input type="text" name="descricao" readonly="readonly" value="{{ $contapagar->descricao }}" id="descricao"  class="form-campo">												
						</div>
						<div class="col-4">	
							<label class="text-label d-block">Fornecedor</label>
							<input type="text" name="fornecedor" readonly="readonly" value="{{ $contapagar->fornecedor->razao_social }}"   class="form-campo">												
						</div>					
											
						<div class="col-2 mb-3">
							<label class="text-label">Data Emissão</label>
							 <input type="date" name="data_emissao" readonly="readonly" value="{{ $contapagar->data_emissao }}" id="data_emissao" readonly class="form-campo">												
						</div>	
						
						<div class="col-2 mb-3">
							<label class="text-label">Data Vencimento</label>
							 <input type="date" name="data_vencimento" readonly="readonly" value="{{ $contapagar->data_vencimento }}"  readonly id="data_vencimento"  class="form-campo">												
						</div>						
						<div class="col-2 mb-3">
    						<label class="text-label">Valor Original</label>
    						<input type="text"  readonly="readonly" readonly="readonly" value="{{ $contapagar->valor }}"    class="form-campo mascara-float">												
    					</div>
    					
    					<div class="col-2 mb-3">
    						<label class="text-label">Total Juros</label>
    						<input type="text"   readonly="readonly" readonly="readonly" value="{{ $contapagar->total_juros }}"    class="form-campo mascara-float">												
    					</div>
    					
    					<div class="col-2 mb-3">
    						<label class="text-label">Total Multa</label>
    						<input type="text"   readonly="readonly" readonly="readonly" value="{{ $contapagar->total_multa}}"    class="form-campo mascara-float">												
    					</div>
    					
    					<div class="col-2 mb-3">
    						<label class="text-label">Total Desconto</label>
    						<input type="text"   readonly="readonly" readonly="readonly" value="{{ $contapagar->total_desconto }}"    class="form-campo mascara-float">												
    					</div>
    					
    					<div class="col-2 mb-3">
    						<label class="text-label">Total Recebido</label>
    						<input type="text"  readonly="readonly" readonly="readonly" value="{{ $contapagar->total_recebido }}"    class="form-campo mascara-float">												
    					</div>
    					
    					<div class="col-2 mb-3">
    						<label class="text-label">Total Restante</label>
    						<input type="text"   readonly="readonly" readonly="readonly" value="{{ $contapagar->total_restante }}"    class="form-campo mascara-float">												
    					</div>
						</div>
					</div>
				</div>        
		</fieldset>        
</div>
</div>
<form action="{{ route('admin.contapagar.pagar')}}" method="post">
     @csrf
	 
	<div class="col-12 mb-4">
            <div class="caixa p-3 pt-0">			
				<fieldset>
            <legend> Dados do Pagamento</legend>
			<input type="hidden" name="tipo_documento" required value="{{ ($contapagar->compra_id) ? config('constantes.tipo_documento.COMPRA') : config('constantes.tipo_documento.AVULSO') }}" >												
           
            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">
					<div class="col-2 mb-3">
						<label class="text-label">Data Pagamento</label>
						 <input type="date" name="data_pagamento" value="{{ hoje() }}" id="data_pagamento" readonly class="form-campo">												
					</div>
										
					<div class="col-2 mb-3">
						<label class="text-label">Forma de Pagamento</label>
						<select class="form-campo" name="forma_pagto_id" required>							
							@foreach($formaPagto as $f)
							     <option value='{{ $f->id}}'>{{ $f->forma_pagto }}</option>
							@endforeach		
						</select>
					</div>	
					
					<div class="col-4">	
                     <label class="text-label d-block ">Conta Corrente </label>
                    <select name="conta_corrente_id" class="form-campo">
                       @foreach($contas as $conta) 
                        	<option value="{{$conta->id}}" >{{$conta->descricao}}</option>  
                       @endforeach                                                  
                    </select>
                 </div>
                 
                 <div class="col-4">	
                     <label class="text-label d-block ">Classificação Financeira </label>
                    <select name="classificacao_financeira_id" class="form-campo">
                       @foreach($classificacoes as $c) 
                        	<option value="{{$c->id}}" >{{$c->codigo}} - {{$c->descricao}}</option>  
                       @endforeach                                                  
                    </select>
                 </div>
                 
                 
					<div class="col-2 mb-3">
						<label class="text-label">Número Documento</label>
						<input type="text" name="numero_documento"  id="numero_documento" class="form-campo">												
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
					<div class="col-2 mb-3">
						<label class="text-label">Valor a Pagar</label>
						<input type="text" name="valor_a_pagar" required readonly="readonly" id="valor_a_pagar" value="{{ $contapagar->valor }}"    class="form-campo mascara-float">												
					</div>	

					
					<div class="col-6 mb-3">
						<label class="text-label">Observação</label>
						<input type="text" name="observacao"  id="observacao" class="form-campo">												
					</div>					
					 <div class="col-12 text-center"> 
						<input type="hidden" name="conta_pagar_id" value="{{ $contapagar->id }}" /> 
						<input type="hidden" name="valor_original" id="valor_original"  value="{{ $contapagar->valor }}" />
						<input type="submit" value="Salvar" class="btn btn-azul btn-medio d-block m-auto" /> 
					</div>							
					   
					</div>
				</div>          
			</div>
			
			</fieldset>
        </div>
	</div>
    </div>
   </form>
 
</div>

<script>


function atualizaValor(){
	var saldo_devedor  = ($('#valor_original').val() !="") ? converteMoedaFloat($('#valor_original').val()) : parseFloat(0);
	var juros 			= ($('#juros').val() !="") ? converteMoedaFloat($('#juros').val()) : parseFloat(0);
	var multa 			= ($('#multa').val() !="") ? converteMoedaFloat($('#multa').val()) : parseFloat(0);
	var desconto 		= ($('#desconto').val() !="") ? converteMoedaFloat($('#desconto').val()) : parseFloat(0);
	

	
	var valor_a_pagar = parseFloat(saldo_devedor) + parseFloat(juros) + parseFloat(multa) - parseFloat(desconto);
	$('#valor_a_pagar').val(converteFloatMoeda(valor_a_pagar));
	
}
</script>
@endsection