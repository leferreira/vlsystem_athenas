@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Venda Recorrente: {{$vendarecorrente->id}}</span>
	<div class="d-flex">
		<a href="{{route('admin.fatura.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	</div>
</span>
<div class="rows">
	<div class="col-12 mt-3">
    <form action="{{ route('admin.vendarecorrente.gerarCobranca')}}" method="post">
     @csrf        
        
        <div class="col-12 mb-4">
            <div class="caixa border radius-4">
            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">					
                    
                    <div class="col-4 mb-3">
						<label class="text-label">Descrição da Cobranca</label>
						 <input type="text" name="descricao"  id="descricao"  class="form-campo">												
					</div>
														
                        
                     <div class="col-2 mb-3">
						<label class="text-label">Tipo Recorrencia<span class="text-vermelho">*</span></label>						
						<select name="tipo_cobranca_id" class="form-campo">							
							@foreach($tipos as $t)
								<option value="{{$t->id}}" {{$t->qtde_dias==30 ? 'selected' : ''}}>{{$t->tipo_cobranca}}</option>
							@endforeach
						</select>					
					</div>
					                                  
					<div class="col-2 mb-3">
							<label class="text-label">Primeiro Vencimento</label>	
							<input type="date" name="primeiro_vencimento" required value="{{isset($vendarecorrente->primeiro_vencimento) ? $vendarecorrente->primeiro_vencimento : hoje() }}"  class="form-campo ">
					</div>				
									
					
					<div class="col-2 mb-3">
							<label class="text-label">Valor Recorrente</label>	
							<input type="text" name="valor_recorrente" value="{{$vendarecorrente->valor_recorrente}}" required   class="form-campo mascara-float">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label">Qtde Cobrança</label>	
							<input type="number" name="qtde" required value="6"  class="form-campo mascara-float">							
					</div>
                    
                 
				    <div class="col-12 text-center">	
				    	<input type="hidden" name="venda_recorrente_id" required value="{{$vendarecorrente->id}}"  class="form-campo mascara-float"> 
            			<input type="submit" value="Salvar" class="btn btn-azul btn-medio d-block m-auto" />                   
            		</div>		
					   
					</div>
				</div>          
			</div>
        </div>
	</div>

	
   
   </form>
    </div>
</div>

<script>

function tipoBaixa(){
	var tipo = $("#id_baixa").val();
	var valor_a_pagar = $("#valor_a_pagar").val();
	if(tipo=='T'){
		$("#valor_pago").val(valor_a_pagar);
		$("#valor_pago").attr("readonly", true);
		
	}else{
		$("#valor_pago").val(0);
		$("#valor_pago").attr("readonly", false);
	}
}

function atualizaValor(){
	var saldo_devedor = $("#saldo_devedor").val();
	var juros 	      = $("#juros").val();
	var multa 		  = $("#multa").val();
	var desconto 	  = $("#desconto").val();
	console.log(juros);
	var valor_a_pagar = parseFloat(saldo_devedor) + parseFloat(juros) + parseFloat(multa) - parseFloat(desconto);
	console.log(valor_a_pagar);
	$("#valor_a_pagar").val(valor_a_pagar);
	tipoBaixa();
}
</script>
@endsection