@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" h5 mb-0 "><i class="fas fa-plus-circle"></i> Cadastrar equipamentos</span>
		<div>
			<a href="{{route('admin.equipamento.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>	
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>			
		</div>
	</div>                 
 @if(isset($equipamento))    
   <form action="{{route('admin.equipamento.update', $equipamento->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.equipamento.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2 mt-1">
			
			<fieldset>
				<legend>Informações básicas</legend>
				
				<div class="rows">
					<div class="col-4">
                        <label class="text-label ">Cliente<span class="text-vermelho">*</span></label>
                        <div class="group-btn">	                                
                            <input type="text"  id="desc_cliente" value="{{$equipamento->cliente->nome_razao_social ?? null}}" class="form-campo">
                            <input type="hidden" name="cliente_id" value="{{$equipamento->cliente_id ?? null}}"  id="cliente_id" >       
                           <a href="{{route('admin.cliente.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
						</div>                               
                    </div>
                    												
					<div class="col-8 mb-3">
							<label class="text-label"  >Equipamento<span class="text-vermelho">*</span></label>	
							<input type="text" name="equipamento"  required id="equipamento" value="{{$equipamento->equipamento ?? old('equipamento') }}" class="form-campo">
					</div>                                    
					<div class="col-3 mb-3" >
							<label class="text-label">Número de Série</label>	
							<input type="text" name="num_serie" maxlength="60" id="num_serie" value="{{isset($equipamento->num_serie) ? $equipamento->num_serie : old('num_serie') }}" class="form-campo">
					</div>
					<div class="col-3 mb-3">
							<label class="text-label"  >Modelo<span class="text-vermelho">*</span></label>	
							<input type="text" name="modelo"   value="{{isset($equipamento->modelo) ? $equipamento->modelo : old('modelo') }}"  class="form-campo">
					</div>						
					
					<div class="col-3 mb-3" >
							<label class="text-label" >Cor</label>	
							<input type="text" name="cor"  value="{{isset($equipamento->cor) ? $equipamento->cor : old('cor') }}"  class="form-campo">
					</div>
								
					
					<div class="col-3 mb-3">
							<label class="text-label">Tensão</label>	
							<input type="text" name="tensao" value="{{isset($equipamento->tensao) ? $equipamento->tensao : old('tensao') }}"  class="form-campo ">
					</div>
					
					<div class="col-3 mb-3">
							<label class="text-label">Potência</label>	
							<input type="text" name="potencia"  value="{{isset($equipamento->potencia) ? $equipamento->potencia : old('potencia') }}"  class="form-campo ">
					</div>
					
					<div class="col-3 mb-3">
							<label class="text-label">Voltagem</label>	
							<input type="text" name="voltagem"  value="{{isset($equipamento->voltagem) ? $equipamento->voltagem : old('voltagem') }}"  class="form-campo ">
					</div>
					
					<div class="col-3 mb-3">
							<label class="text-label">Data Fabricação</label>	
							<input type="date" name="data_fabricacao"  value="{{isset($equipamento->data_fabricacao) ? $equipamento->data_fabricacao : old('data_fabricacao') }}"  class="form-campo ">
					</div>
					
					<div class="col-12 mb-3" >
							<label class="text-label">Descrição</label>	
							<textarea rows="5" cols="5" name="descricao" class="form-campo">{{isset($equipamento->descricao) ? $equipamento->descricao : old('descricao') }}</textarea>
					</div>
				</div>
			</fieldset>
			
			
		</div>
	  </div>
	  
	  
		<div class="col-12 text-center pb-4">
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	  </div>
	
</form>
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

	function tipoCliente(){
		var tp = $("#tipo_cliente").val();
		
		if(tp=="F"){
			$("#div_pesquisar").hide();
            $("#div_tipo_contribuinte").hide();
            $("#divIscEstadual").hide();
            $("#divSuframa").hide();
            $("#divFantasia").hide();
            
            $("#lblInscEstadual").html("RG");
            $("#lblCnpj").html('CPF');
            $("#lblRazaoSocial").html('Nome');
            $("#cnpj").mask('000.000.000-00', {reverse: true});
       
            
		}else{
			$("#div_pesquisar").show();
            $("#div_tipo_contribuinte").show();
            $("#divIscEstadual").show();
            $("#divSuframa").show();
            $("#divFantasia").show();
            
            $("#lblInscEstadual").html("Inscrição Estadual");
            $("#lblCnpj").html('CNPJ');
            $("#lblRazaoSocial").html('Razão Social');
            $("#cnpj").mask('00.000.000/0000-00', {reverse: true});
          
		}
	}
</script>
@endsection