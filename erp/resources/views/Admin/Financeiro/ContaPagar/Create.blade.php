@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows"> 
        
        
        <div class="col-12 mb-4">
            <div class="caixa ">
			<span class="p-2 bg-title text-light text-uppercase  text-branco justify-content-space-between d-flex">
				<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Cadastro de Conta a Pagar</span>
				<div class="d-flex">
					<a href="{{route('admin.contapagar.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
					<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
				</div>
			</span>  
				@if(isset($contapagar))    
               <form action="{{route('admin.contapagar.update', $contapagar->id)}}" method="POST" >
               <input name="_method" type="hidden" value="PUT"/>
             @else                       
            	<form action="{{route('admin.contapagar.store')}}" method="Post" >
            @endif
            	@csrf
        	   
            <div class="caixa">
				<div class="px-4 mt-3">
				<fieldset>
				<div class="rows pt-3 pb-4">
					
					<div class="col-6 mb-3">
						<label class="text-label">Descrição da Despesa</label>
						 <input type="text" name="descricao" required id="descricao" value="{{$contapagar->descricao ?? old('descricao') }}" class="form-campo">												
					</div>
					 <div class="col-6">
                            <label class="text-label d-block ">Fornecedor</label>
                            <div class="group-btn">	                                
                                <input type="text"  id="desc_fornecedor" value="{{$contapagar->fornecedor->razao_social ?? null}}" class="form-campo">
                                <input type="hidden" name="fornecedor_id" value="{{$contapagar->fornecedor_id ?? null}}"  id="fornecedor_id" >       
                               <a href="{{route('admin.fornecedor.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Fornecedor"></a>
							</div>                               
                        </div>
                    
                                                          
					<div class="col-2 mb-3">
						<label class="text-label">Data Emissão</label>
						 <input type="date" name="data_emissao" required  id="data_emissao" value="{{$contapagar->data_emissao ?? hoje() }}" class="form-campo">												
					</div>	
					
										
					<div class="col-2 mb-3">
						<label class="text-label">Valor</label>
						<input type="text" name="valor" required id="valor" value="{{$contapagar->valor ?? old('valor') }}"  class="form-campo mascara-float">												
					</div>
					@if(!isset($contapagar->id))
						<div class="col-2">	
                            <label class="text-label d-block " >Qtd Repetição</label>
                            <input type="number" min="1" name="qtdParcelas" required id="qtdParcelas" value="1" class="form-campo">
                        </div>
                        
                        
                        <div class="col-3 validated">	
                            <label class="text-label d-block ">Primeiro Vencimento</label>
                            <input type="date" name="primeiro_vencimento" required value="0" id="primeiro_vencimento" class="form-campo data-input">
                        </div>
                   @else
                   		<div class="col-2 mb-3">
						<label class="text-label">Data Vencimento</label>
						 <input type="date" name="data_vencimento" required  id="data_vencimento" value="{{$contapagar->data_vencimento ?? old('data_vencimento') }}" class="form-campo">												
					</div>
                   @endif     
					    <div class="col-12 text-center mt-3">	 
					    <input type="hidden" name="origem" value="avulsa" >              
                			<input type="submit" value="Salvar" class="btn btn-azul btn-medio d-inline-block" />                   
                			
                          </div>		
					   
					</div>
					</fieldset>
				</div>          
			</div>
			</form>
        </div>
	</div>
</div>

	
   
   
</div>

<script>
$(function () {
	$("#desc_fornecedor").on("keyup", function(){
	   var q = $(this).val();
	   if(q==""){
		   return;
	   }
	   $.ajax({
		   url: base_url + "admin/fornecedor/pesquisa",
		   type: "GET",
		   dataType: "json",
		   data: {q:q},
		   success: function (data){
			   $("#desc_fornecedor").after('<ol class="listaFornecedores"></ol>');
			   html="";
			   for(var i in data){
				   html +=	'<li><a href="javascript:;" onclick="selecionarFornecedorCompra(this)" ' +	
				   		  	'data-fornecedor_id="'+data[i].id +				   		  	
							'" data-nome_razao_social = "' + data[i].razao_social + '">' +
				   		 	 data[i].razao_social + '</a></li>' 
				}
			   
			   $(".listaFornecedores").html(html);
			   $(".listaFornecedores").show();
		   }
	   });
   })

});

function selecionarFornecedorCompra(obj){
	var id					= $(obj).attr('data-fornecedor_id');
	var nome				= $(obj).attr('data-nome_razao_social');	
	
	$(".listaFornecedores").hide();
	$("#fornecedor_id").val(id);
	$("#desc_fornecedor").val(nome);	
}


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