<?php
use App\Service\ConstanteService;
?>
@extends("template_gestor")
@section("conteudo")
<div class="conteudo">
<section class="caixa">
<div class="thead border-bottom mb-3 p-1	">
		<div class="titulo mb-0">
			<span><i class="fas fa-list-alt"></i> Contas a Pagar</span>
			<span class="mig"><a href="{{route('index')}}" class="text-azul"> Home </a> <i class="fas fa-angle-double-right text-azul"></i> <a href="{{route('pagar.index')}}" class="text-azul"> Lista de contas a pagar </a>  <i class="fas fa-angle-double-right text-azul"></i> <b class="text-azul2"> Dar baixa</b></span>
		</div>
		<div class="text-end d-flex">
			<a href="{{route('pagar.create')}}" class="btn btn-azul d-inline-block " title="Adicionar Novo"><i class="fas fa fa-plus-circle" aria-hidden="true"></i></a>
			<a href="{{route('pagar.index')}}" class="btn btn-azul2 d-inline-block ml-1" title="Voltar"><i class="fas fa fa-arrow-left" aria-hidden="true"></i></a>
		</div>
	</div>
				<div class="px-md mb-4">
					<div class="caixa-form">
						    
                           <form action="{{route('pagar.pagar')}}" method="POST">                        
                        	@csrf
						
						<fieldset class="mb-3">
						<legend>Conta a Pagar</legend>	
							<div class="rows">
								
								<div class="col-12">
								<div class="rows">									
									
									<div class="col-3 mb-3">
										<label class="text-label">Fornecedor</label>
                    					<input type="text" readonly="readonly"  value="{{$conta_pagar->fornecedor->razao_social}}" class="form-campo" >
									</div>
									<div class="col-3 mb-3">
										<label class="text-label">Descrição</label>
                    					<input type="text" readonly="readonly"  value="{{$conta_pagar->descricao}}" class="form-campo" >
									</div>
									<div class="col-2 mb-3">
										<label class="text-label">Data Lançamento</label>
                    					<input type="date" readonly value="{{$conta_pagar->data_lancamento }}" class="form-campo" >
									</div>
									<div class="col-2 mb-3">
										<label class="text-label">Data do Vencimento</label>
                    					<input type="date" readonly value="{{ $conta_pagar->data_vencimento}}" class="form-campo" >
									</div>
									<div class="col-2 mb-3">
										<label class="text-label">Valor Original </label>
                    					<input type="text" readonly id="valor_original"  value="{{$conta_pagar->valor}}" class="form-campo mascara-float" >
									</div>
									
									
																
								
								</div>
								</div>
								</div>
							</fieldset>	
								
							<fieldset>
							<legend>Pagamento</legend>	
								<div class="rows">
								
								<div class="col-12">
								<div class="rows">
									
									
									<div class="col-2">
										<label class="text-label">Data Pagamento</label>
                    					<input type="date" name="data_pagamento" value="{{date('Y-m-d') }}" class="form-campo" >
									</div>
									<div class="col-4">
										<label class="text-label">Forma Pagto</label>
										<select name="forma_pagto_id" class="form-campo">
											@foreach(config('constantes.forma_pagto') as $chave =>$valor)
												<option value="{{$valor}}">{{$valor}} - {{$chave}}</option>
											@endforeach
										</select>
									</div>
									
									
                					<div class="col-6 mb-3">
                						<label class="text-label">Observação</label>
                						<input type="text" name="observacao"  id="observacao" class="form-campo">												
                					</div>	
                					<div class="col-3 mb-3">
                						<label class="text-label">Número Documento</label>
                						<input type="text" name="numero_documento"  id="numero_documento" class="form-campo">												
                					</div>
                					<div class="col-2 mb-3">
										<label class="text-label">Juros</label>
                    					<input type="text" id="juros" name="juros"   class="form-campo mascara-float" >
									</div>
									<div class="col-2 mb-3">
										<label class="text-label">Multa</label>
                    					<input type="text" id="multa" name="multa"  class="form-campo mascara-float" >
									</div>
									<div class="col-2 mb-3">
										<label class="text-label">Desconto</label>
                    					<input type="text" id="desconto" name="desconto"   class="form-campo mascara-float" >
									</div>
									<div class="col-2 mb-3">
										<label class="text-label">Valor a Pagar</label>
                    					<input type="text" id="valor_pagar" name="valor_pagar" value="{{$conta_pagar->valor}}" class="form-campo mascara-float" >
									</div>
									
									<div class="col-12 mt-3 text-center">
        								<input type="hidden" name="conta_pagar_id" value="{{ $conta_pagar->id }}" />
        								<input type="hidden" name="valor_original" value="{{ $conta_pagar->valor }}" />
        								<input type="hidden" name="fornecedor_id" value="{{ $conta_pagar->fornecedor_id }}" />
        								<input type="submit" value="Fazer Pagamento" class="btn btn-azul2 d-inline-block">
    								</div>							
								</div>
								</div>
							
								</div>
							
							</fieldset>	
						</form>
					</div>
				</div>
				
</section>
</div>
<script>
$(function () {
	$('#juros').on('keyup', () => {
		atualizaTotalPagamento()
	})

    $('#multa').on('keyup', () => {
    	atualizaTotalPagamento()
    })
    
    $('#desconto').on('keyup', () => {
    	atualizaTotalPagamento()
    })
});


function atualizaTotalPagamento() {
	var valor_original  = ($('#valor_original').val() !="") ? converteMoedaFloat($('#valor_original').val()) : parseFloat(0);
	var juros 			= ($('#juros').val() !="") ? converteMoedaFloat($('#juros').val()) : parseFloat(0);
	var multa 			= ($('#multa').val() !="") ? converteMoedaFloat($('#multa').val()) : parseFloat(0);
	var desconto 		= ($('#desconto').val() !="") ? converteMoedaFloat($('#desconto').val()) : parseFloat(0);
	
	let total_a_pagar = parseFloat(valor_original) + parseFloat(juros) + parseFloat(multa) - parseFloat(desconto);
	$('#valor_pagar').val(converteFloatMoeda(total_a_pagar));
	$('#total_a_pagar_final').val(converteFloatMoeda(total_a_pagar));
}


</script>
@endsection