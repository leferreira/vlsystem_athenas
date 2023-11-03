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
            <legend><i class="far fa-list-alt"></i> Plano : <b class="text-vermelho">{{ $planopreco->plano->nome}}</b></legend>

            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">
					
					<div class="col-4 mb-3">
						<label class="text-label">Descricao</label>
						 <input type="text" value="Pagamento de Assinatura" readonly="readonly" id="descricao"  class="form-campo">												
					</div>				                    
                                        
					<div class="col-2 mb-3">
						<label class="text-label">Data Emissão</label>
						 <input type="date"  value="{{ hoje() }}" readonly="readonly" id="data_emissao" readonly class="form-campo">												
					</div>						
										
					<div class="col-2 mb-3">
						<label class="text-label">Valor Plano</label>
						<input type="text"  id="planopreco_id" readonly="readonly" value="{{ formataNumeroBr($planopreco->preco) }}"    class="form-campo">												
					</div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Valor Setup</label>
						<input type="text"  id="planopreco_id" readonly="readonly" value="{{ formataNumeroBr($planopreco->plano->valor_setup) }}"    class="form-campo">												
					</div>
					 <div class="col-2 mb-3">
						<label class="text-label">Total</label>
						<input type="text"  id="planopreco_id" readonly="readonly" value="{{ formataNumeroBr($planopreco->preco + $planopreco->plano->valor_setup) }}"    class="form-campo">												
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
					<div class="col-3 mb-3">
						<label class="text-label">Forma de Pagamento</label>
						<select class="form-campo" name="forma_pagto_id" required>							
							@foreach($formaPagto as $f)
							     <option value='{{ $f->id}}'>{{ $f->forma_pagto }}</option>
							@endforeach		
						</select>
					</div>
					
					<div class="col-3">	
                     <label class="text-label d-block ">Conta Corrente </label>
                    <select name="conta_corrente_id" class="form-campo">
                       @foreach($contas as $conta) 
                        	<option value="{{$conta->id}}" >{{$conta->descricao}}</option>  
                       @endforeach                                                  
                    </select>
                 </div>
                 
                 <div class="col-4">	
                     <label class="text-label d-block ">Classificação Financeira </label>
                    <select name="classificacao_id" class="form-campo">
                       @foreach($classificacoes as $c) 
                        	<option value="{{$c->id}}" >{{$c->codigo}} - {{$c->descricao}}</option>  
                       @endforeach                                                  
                    </select>
                 </div>									
					<div class="col-2 mb-3">
						<label class="text-label">Valor Pago</label>
						<input type="text" name="valor_pago" id="valor_pago" required="required" value="{{ formataNumeroBr($planopreco->preco + $planopreco->plano->valor_setup) }}"    class="form-campo mascara-float">												
					</div> 
						
					<div class="col-4 mb-3">
						<label class="text-label">Observação</label>
						<input type="text" name="obs"  id="obs" class="form-campo">												
					</div>
					
					<div class="col-4 mb-3">
						<label class="text-label">.</label>
						<input type="file" name="file"  id="file" class="form-campo">												
					</div>					
									
					 <div class="col-2 mb-3">  
					 <label class="text-label">.</label> 
						<input type="hidden" name="planopreco_id" value="{{ $planopreco->id }}" /> 
						<input type="hidden" value="Pagamento de Assinatura"  name="descricao"  >	
						<input type="submit" value="Enviar Comprovante" class="btn btn-azul btn-medio d-block m-auto" />
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