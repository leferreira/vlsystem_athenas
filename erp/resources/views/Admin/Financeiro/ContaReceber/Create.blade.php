@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">
<div class="col-12">
 <span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Novo Conta a Receber</span>
</div>
	<div class="col-12">
	@if(isset($contareceber))    
           <form action="{{route('admin.contareceber.update', $contareceber->id)}}" method="POST" >
           <input name="_method" type="hidden" value="PUT"/>
         @else                       
        	<form action="{{route('admin.contareceber.store')}}" method="Post" >
        @endif
        	@csrf
        	
   
        
        
        <div class="col-12 mb-4 mt-4">           
            <div class="caixa border radius-4">
				<div class="p-4">
				<div class="rows pt-3 pb-4">
					
					<div class="col-6 mb-3">
						<label class="text-label">Descricao do Recebimento</label>
						 <input type="text" name="descricao" required id="descricao" value="{{$contareceber->descricao ?? old('descricao') }}"   class="form-campo">												
					</div>
					<div class="col-6">
                        <label class="text-label d-block ">Cliente</label>
                        <div class="group-btn">	                                
                            <input type="text" value="{{$contareceber->cliente->nome_razao_social ?? old('nome_razao_social') }}" id="desc_cliente"  class="form-campo">
                            <input type="hidden" name="cliente_id"   id="cliente_id" value="{{$contareceber->cliente_id ?? old('nome_razao_social') }}">       
                           <a href="{{route('admin.cliente.create')}}" target="_blank"  class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
						</div>                               
                    </div>
                    
                    
                 
                                        
					<div class="col-3 mb-3">
						<label class="text-label">Data Emissão</label>
						 <input type="date" name="data_emissao" required value="{{$contareceber->data_emissao ?? hoje() }}" id="data_emissao"  class="form-campo">												
					</div>
					
										
					<div class="col-3 mb-3">
						<label class="text-label">Valor</label>
						<input type="text" name="valor" id="valor" required value="{{$contareceber->valor ?? old('valor') }}"  class="form-campo  mascara-float">												
					</div>
					@if(!isset($contareceber->id))
    					<div class="col-2">	
                                <label class="text-label d-block ">Qtde Repeticção</label>
                                <input type="number" min="1" required name="qtdParcelas" id="qtdParcelas" value="1" class="form-campo">
                        </div>
                        <div class="col-3 validated">	
                            <label class="text-label d-block ">Primeiro Vencimento</label>
                            <input type="date" name="primeiro_vencimento" required value="0" id="primeiro_vencimento" class="form-campo data-input">
                        </div>
                     @else
                   		<div class="col-2 mb-3">
						<label class="text-label">Data Vencimento</label>
						 <input type="date" name="data_vencimento" required  id="data_vencimento" value="{{$contareceber->data_vencimento ?? old('data_vencimento') }}" class="form-campo">												
					</div>
                   @endif   
					    <div class="col-12 text-center mt-3">	
					    	<input type="hidden" name="origem" value="avulsa" >          
                			<input type="submit" value="Salvar" class="btn btn-azul d-inline-block" />                   
                		</div>		
					   
					</div>
				</div>          
			</div>
	</div>

	
   
   </form>
    </div>
</div>

<script>
$(function () {	
	$("#desc_cliente").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return;
	   }
	   $.ajax({
		   url: base_url + "admin/cliente/pesquisa",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   $("#desc_cliente").after('<ol class="listaClientes"></ol>');
			   html="";
			   for(var i in data){
				   html +=	'<li><a href="javascript:;" onclick="selecionarClienteVenda(this)" ' +	
				   		  	'data-cliente_id="'+data[i].id +				   		  	
							'" data-nome_razao_social = "' + data[i].nome_razao_social + '">' +
				   		 	 data[i].nome_razao_social + '</a></li>' 
				}
			   
			   $(".listaClientes").html(html);
			   $(".listaClientes").show();
		   }
	   });
   })
   
});

function selecionarClienteVenda(obj){
	var id					= $(obj).attr('data-cliente_id');
	var nome				= $(obj).attr('data-nome_razao_social');	
	
	$(".listaClientes").hide();
	$("#cliente_id").val(id);
	$("#desc_cliente").val(nome);	
}


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