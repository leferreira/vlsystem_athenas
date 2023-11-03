@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Novo Cadastro</span>
	<div class="d-flex">
		<a href="{{route('admin.despesa.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	</div>
</span>   
<div class="rows">
	<div class="col-12 mt-4">
	@if(isset($despesa))    
           <form action="{{route('admin.despesa.update', $despesa->id)}}" method="POST" >
           <input name="_method" type="hidden" value="PUT"/>
         @else                       
        	<form action="{{route('admin.despesa.store')}}" method="Post" >
        @endif
        	@csrf
     
        
        
        <div class="col-12 mb-4">
            <div class="caixa border radius-4">
            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">					
					
					<div class="col-4">	
                        <label class="text-label d-block">Fornecedor</label>
                        <?php $id_fornecedor = ($despesa->fornecedor_id) ?? null ?>
                       <div class="group-btn">
                        	<input type="text"  id="desc_fornecedor" value="{{$despesa->fornecedor->razao_social}}" class="form-campo">
                            <input type="hidden" name="fornecedor_id" id="fornecedor_id"  value="{{$despesa->fornecedor->id}}">
							<a href="{{route('admin.fornecedor.create')}}" target="_blank"  class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir Fornecedor"></a>
                		</div>
                    </div>
                    
                    <div class="col-2">	
                        <label class="text-label d-block">Tipo</label>
                       
                        <div class="group-btn">
                            <input type="text" id="desc_tipo_despesa" value="{{$despesa->tipo->nome}}" class="form-campo">
                            <input type="hidden" name="tipo_despesa_id"   id="tipo_despesa_id" value="{{$despesa->tipo->id}}">
    						<a href="javascript:;" onclick="abrirModal('#modalCadTipoDespesa')" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Serviço"></a>
                		</div>
                    </div>
                    
                    <div class="col-6 mb-3">
						<label class="text-label">Descrição da Despesa</label>
						 <input type="text" name="descricao"  id="descricao" required value="{{$despesa->descricao ?? old('descricao') }}"  class="form-campo">												
					</div>
                    
                                        
					<div class="col-3 mb-3">
						<label class="text-label">Data Emissão</label>
						 <input type="date" name="data_lancamento" required id="data_lancamento" value="{{$despesa->data_lancamento ?? old('data_lancamento') }}"  class="form-campo">												
					</div>	
					
										
					<div class="col-3 mb-3">
						<label class="text-label">Valor</label>
						<input type="text" name="valor_despesa" id="valor_despesa" required value="{{$despesa->valor_despesa ?? old('valor_despesa') }}"  class="form-campo  mascara-float">												
					</div>			
                  
                   		<div class="col-2 mb-3">
						<label class="text-label">Data Vencimento</label>
						 <input type="date" name="data_vencimento" required  id="data_vencimento" value="{{$despesa->data_vencimento ?? old('data_vencimento') }}" class="form-campo">												
					</div>
                 
					    <div class="col-12 text-center mt-3">	            
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
@include ("Admin.Cadastro.fornecedor.modal.modalCadastroFornecedor")
@include ("Admin.Financeiro.TipoDespesa.modal.modalTipoDespesa")
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