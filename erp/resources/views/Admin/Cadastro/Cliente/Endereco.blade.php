@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle  h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de Endereço : <?php echo $cliente->nome_razao_social ?></span>
				<div>			
					<a href="javascript:;" onclick="abrirModalEndereco(<?php echo $cliente->id ?>)" class="btn btn-azul d-inline-block" title="Adicionar novo">Adcionar Endereço </a>
				</div>
			</div>
                     
				<div class="px-2 pt-2"> 
					<form name="busca" action="" method="GET">
					<div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
						 <div class="rows p-3">	
							<div class="col-6">
									<span class="text-label text-branco">Cliente</span>
									<input type="text" name="cliente" value="" placeholder="Digite aqui..." class="form-campo">
							</div>
							<div class="col-4">
									<span class="text-label text-branco">Categoria</span>
									<select class="form-campo" name="idCategoria">
									<option value="">Escolha uma Opção</option>
									<option value="1">Panela</option><option value="2">Cuzcuzeira</option><option value="3">Copo</option><option value="4">Caneca</option><option value="5">Papeiro</option><option value="6">Leiteira</option><option value="7">Frigideira</option><option value="8">Bacia</option><option value="9">Balde</option><option value="10">Assadeira</option><option value="11">Baquelite</option><option value="12">yyy</option>                                         </select>
							</div>
							 <div class="col-2 pt-1 mt-1">
								  <input type="submit" value="Pesquisar" class="btn btn-azul width-100 text-uppercase">
							  </div>
						</div>								 
                    </div>								 
                     </form>
				</div>
            </div>		
    <div class="col">
        <div class="px-2 pb-4">
            <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                    <thead>
                            <tr>
                                    <th align="center">Id</th>
                                    <th align="left" >Endereço</th>
                                    <th align="center">Complemento</th>
                                    <th align="center">Bairro</th>
                                    <th align="center">Cidade</th>
                                    <th align="center">UF</th>
                                    <th align="center">Cep</th>
                                    <th align="center">Editar</th>
                                    <th align="center">Excluir</th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $l)
						<tr>
							<td align="center">{{$l->id}}</td>
							<td align="left">{{$l->logradouro}} , Num: {{$l->numero}}  </td>
							<td align="center">{{$l->complemento}}</td>
							<td align="center">{{$l->bairro}}</td>
							<td align="center">{{$l->cidade}}</td>
							<td align="center">{{$l->uf}}</td>
							<td align="center">{{$l->cep}}</td>
							<td align="center"><a href="javascript:;" onclick="abrirEdicaoModalEndereco(<?php echo $l->id ?>, 1)" class="d-inline-block btn btn-verde btn-circulo btn-pequeno" title="Editar"><i class="fas fa-edit"></i></a></td>
							 <td align="center">
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$l->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.enderecocliente.destroy', $l->id)}}" method="POST" id="apagar{{$l->id}}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        {{csrf_field()}}
                                    </form>
                                 </td>	
                           					
                            </tr>
					@endforeach
					</tbody>
			</table>   
	</div>
					
	</div>
		
							
	</div>
</div>
 @include ("Admin.Cadastro.Cliente.modal.modalEnderecoCliente")
<script>
var cliente_id = 0;
function abrir_opcoes_cliente(id){
	cliente_id = id;
	$("#id_cliente").html(id);
	mostrar_opcoes('opcoes_cliente')
	
}

function abrirModalEndereco(id){
limparDadosEndereco();
	$("#cliente_id").val(id);
	abrirModal('#modalCadEndereco')
}

function salvarEnderecoCliente(eh_modal){ 	
        $.ajax({
         url: base_url + "admin/enderecocliente",
         type: "POST",
         data:$("#frmCadEnderecoCliente").serialize(),
         dataType:"Json",
         success: function(data){			
			if(data.tem_erro ==true){
				fecharGiraGira(eh_modal);
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				fecharModal();
				location.reload();
			}             
         },
		  beforeSend: function () {
			giraGira();
	     },error: function (data) {
			fecharGiraGira(eh_modal);
			if(data.status== 422){
				var errors = $.parseJSON(data.responseText);
				$('#listaErroModal').html('');					
	        	$.each(errors.errors, function (key, erro) {					 
					 $('#listaErroModal').append('<li>' + erro + '</li>');
					 abrirModalLivre("#modalLivreListaComErros");
	        	});
			}else{
				
			}	        
		}        
     })
}

function abrirEdicaoModalEndereco(id, eh_modal){ 	
        $.ajax({
         url: base_url + "admin/enderecocliente/buscar/" + id,
         type: "GET",
         data:{},
         dataType:"Json",
         success: function(data){
         		fecharGiraGira(eh_modal);
         		$("#cliente_id").val(data.cliente_id);
         		$("#endereco_id").val(data.id);
         	   	preencherDadosEndereco(data);
				abrirModal('#modalCadEndereco');          
         },
		  beforeSend: function () {
			giraGira();
	     },error: function (data) {
			fecharGiraGira(eh_modal);
			if(data.status== 422){
				var errors = $.parseJSON(data.responseText);
				$('#listaErroModal').html('');					
	        	$.each(errors.errors, function (key, erro) {					 
					 $('#listaErroModal').append('<li>' + erro + '</li>');
					 abrirModalLivre("#modalLivreListaComErros");
	        	});
			}else{
				
			}	        
		}        
     })
}

function preencherDadosEndereco(data){	
	$("#numero").val(data.numero);
	$("#bairro").val(data.bairro);
	$("#complemento").val(data.complemento);
	$("#cep").val(data.cep);
	$("#logradouro").val(data.logradouro);
	$("#cidade").val(data.cidade);
	$("#bairro").val(data.bairro);
	$("#uf").val(data.uf);
	$("#ibge").val(data.ibge);
}

function limparDadosEndereco(){	
	$("#numero").val("");
	$("#bairro").val("");
	$("#complemento").val("");
	$("#cep").val("");
	$("#logradouro").val("");
	$("#cidade").val("");
	$("#bairro").val("");
	$("#uf").val("");
	$("#ibge").val("");
	
	$("#cliente_id").val("");
   $("#endereco_id").val("");
}

</script>
@endsection