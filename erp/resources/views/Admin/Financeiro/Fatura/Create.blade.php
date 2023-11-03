@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Novo Cadastro</span>
	<div class="d-flex">
		<a href="{{route('admin.fatura.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	</div>
</span>
<div class="rows">
	<div class="col-12 mt-3">
    <form action="{{ route('admin.fatura.store')}}" method="post">
     @csrf        
        
        <div class="col-12 mb-4">
            <div class="caixa border radius-4">
            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">					
                    
                    <div class="col-6 mb-3">
						<label class="text-label">Descrição da Fatura</label>
						 <input type="text" name="descricao"  id="descricao"  class="form-campo">												
					</div>
					
					<div class="col-6 mb-3">
						<label class="text-label">Observação</label>
						 <input type="text" name="observacao"  id="observacao"  class="form-campo">												
					</div>                    
                                        
					<div class="col-4 mb-3">
						<label class="text-label">Data Emissão</label>
						 <input type="date" name="data_emissao" value="{{hoje()}}" id="data_emissao"  class="form-campo">												
					</div>	
					
										
					<div class="col-4 mb-3">
						<label class="text-label">Valor</label>
						<input type="text" name="valor" id="valor"  class="form-campo">												
					</div>			
                        
                        
                        <div class="col-4 validated">	
                            <label class="text-label d-block ">Primeiro Vencimento</label>
                            <input type="date" name="data_vencimento" value="{{hoje()}}"  class="form-campo data-input">
                        </div>
                        
                     
					    <div class="col-12 text-center">	 
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