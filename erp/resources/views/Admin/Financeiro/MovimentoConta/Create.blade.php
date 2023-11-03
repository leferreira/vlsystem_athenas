@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">
<div class="col-12">
 <span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Novo Lançamento Conta</span>
</div>
	<div class="col-12">
	@if(isset($movimentoconta))    
           <form action="{{route('admin.movimentoconta.update', $movimentoconta->id)}}" method="POST" >
           <input name="_method" type="hidden" value="PUT"/>
         @else                       
        	<form action="{{route('admin.movimentoconta.store')}}" method="Post" >
        @endif
        	@csrf
        	
   
        
        
        <div class="col-12 mb-4 mt-4">           
            <div class="caixa border radius-4">
				<div class="px-4">
				<div class="rows pt-3 pb-4">					
					<div class="col-2 mb-3">
						<label class="text-label">Data Emissão</label>
						 <input type="date" name="data_emissao" required value="{{$movimentoconta->data_emissao ?? old('data_emissao') }}" id="data_emissao"  class="form-campo">												
					</div>
					
					<div class="col-2">	
                        <label class="text-label d-block">Conta</label>
                        <div class="group-btn">
                        <?php $id_conta = ($movimentoconta->conta_id) ?? null ?>
                            <select id="conta_id" name="conta_id" class="form-campo">
    							@foreach($contas as $c)
    							<option value="{{$c->id}}" {{($c->id == $id_conta) ? 'selected': ''}}>{{$c->descricao}}</option>
    							@endforeach
    						</select>
    						 <a href="{{route('admin.contacorrente.index')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
    						
    					</div>
                    </div>
                    
                    <div class="col-6">	
                        <label class="text-label d-block">Classificação Financeira</label>
                        <div class="group-btn">
                        <?php $id_classificacao = ($movimentoconta->classificacao_financeira_id) ?? null ?>
                            <select id="classificacao_financeira_id" name="classificacao_financeira_id" class="form-campo">
    							@foreach($classificacoes as $c)
    							<option value="{{$c->id}}" {{($c->id == $id_classificacao) ? 'selected': ''}}>{{$c->codigo}} - {{$c->descricao}}</option>
    							@endforeach
    						</select>
    					</div>
                    </div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Valor</label>
						<input type="text" name="valor" id="valor" required value="{{$movimentoconta->valor ?? old('valor') }}"  class="form-campo  mascara-float">												
					</div>
					<div class="col-2">	
                            <label class="text-label d-block ">Operação</label>
                            <select  name="tipo_movimento" class="form-campo">
    							<option value="D">Débito</option>
    							<option value="C">Crédito</option>
    						</select>
                    </div>
                        
                    <div class="col-4 mb-3">
						<label class="text-label">Descricao do Movimento</label>
						 <input type="text" name="historico"  id="historico" value="{{$movimentoconta->historico ?? old('historico') }}"   class="form-campo">												
					</div>
                 
                 <div class="col-4 mb-3">
						<label class="text-label">Documento</label>
						 <input type="text" name="documento"  id="documento" value="{{$movimentoconta->documento ?? old('documento') }}"   class="form-campo">												
					</div>
					
                           
                        <div class="col-2 validated">	
                            <label class="text-label d-block ">Data Compensação</label>
                            <input type="date" name="data_compensacao" required value="{{$movimentoconta->data_compensacao ?? old('data_compensacao') }}" id="data_compensacao" class="form-campo data-input">
                        </div>
                      
					    <div class="col-12 text-center mt-3">	          
                					<input type="submit" value="Salvar" class="btn btn-verde btn-medio d-inline-block" />                   
                					
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
	var valor_a_receber = $("#valor_a_receber").val();
	if(tipo=='T'){
		$("#valor_pago").val(valor_a_receber);
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
	var valor_a_receber = parseFloat(saldo_devedor) + parseFloat(juros) + parseFloat(multa) - parseFloat(desconto);
	console.log(valor_a_receber);
	$("#valor_a_receber").val(valor_a_receber);
	tipoBaixa();
}
</script>
@endsection