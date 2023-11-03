@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-check"></i> Enviar Comprovante</span>
	<div class="d-flex">
		<a href="{{route('admin.fatura.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	</div>
</span>
<div class="rows">

	<div class="col-12 mt-4">
	
        <div class="col-12 mb-4">
            <fieldset class="caixa border radius-4">
            <legend><i class="far fa-list-alt"></i> Fatura : <b class="text-vermelho">{{ $fatura->id}}</b></legend>

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
	
	<div class="col-12">
<form action="{{ route('comprovante.store')}}" method="post" enctype="multipart/form-data">
     @csrf
	<div class="col-12 mb-4">
       <fieldset class="caixa border radius-4">
            <legend><i class="far fa-list-alt"></i> Dados do Comprovante</legend>
			<input type="hidden" name="tipo_documento" value="{{ config('constantes.tipo_documento.FATURA')  }}" >
            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">
					<div class="col-2 mb-3">
						<label class="text-label">Data Pagamento</label>
						 <input type="date" name="data_pagamento" value="{{ hoje() }}" id="data_pagamento"  class="form-campo">												
					</div>									
						
					<div class="col-4 mb-3">
						<label class="text-label">Observação</label>
						<input type="text" name="observacao"  id="observacao" class="form-campo">												
					</div>
					
					<div class="col-4 mb-3">
						<label class="text-label">.</label>
						<input type="file" name="file"  id="file" class="form-campo">												
					</div>					
									
					 <div class="col-2 mb-3">  
					 <label class="text-label">.</label> 
						<input type="hidden" name="fatura_id" value="{{ $fatura->id }}" /> 
						<input type="hidden" name="valor_original" value="{{ $fatura->valor }}" />
						<input type="submit" value="Enviar Comprovante" class="btn btn-azul btn-medio d-block m-auto" />
					</div>							
					   
					</div>
				</div>          
			</div>
        
	</div>
   
   </form>
 
</div>

<script>


function atualizaValor(){
	var saldo_devedor = $("#valor_original").val();
	var juros 	      = $("#juros").val();
	var multa 		  = $("#multa").val();
	var desconto 	  = $("#desconto").val();
	
	var valor_a_pagar = parseFloat(saldo_devedor) + parseFloat(juros) + parseFloat(multa) - parseFloat(desconto);
	console.log(valor_a_pagar);
	$("#valor_a_pagar").val(valor_a_pagar);
	
}
</script>
@endsection