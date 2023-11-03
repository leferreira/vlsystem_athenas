
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
					<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Produtos </span>
						<div>
							<a href="{{route('admin.nfeentrada.index')}}" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Voltar</a>
							<a href="" class="btn btn-azul mx-1 d-inline-block"> Atualizar</a>
							@if($pode_inserir)
								<a href="javascript:;"  onclick="confirmarEntrada()" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-check"></i> Fazer Entrada</a>							                   		
							@endif
						</div>
					</div>
					<div class="px-2 pt-2">
					<form name="busca" action="" method="GET">    				 
    				  	<div class="rows">
    				 		 <div class="col-4">
    				 		 <label class="text-label d-block ">Filtrar por </label>
    				  			<select class="form-campo" name="tipo">
    				  				<option value='T' {{$filtro->tipo=="T" ? "selected" : ""}} >Mostrar Tudo</option>
    				  				<option value='V' {{$filtro->tipo=="V" ? "selected" : ""}} >Somente Produtos Vinculados</option>
    				  				<option value='N' {{$filtro->tipo=="N" ? "selected" : ""}} >Somente Produtos Não Vinculados</option>
    				  							  			
    				  			</select>
    				  		</div>
    				  			
                            <div class="col-2 mt-1 pt-1">
                                    <input type="submit" value="Filtrar" class="width-100 btn btn-roxo text-uppercase">
                            </div>
                        </div>
                       </form>
                       </div>
                </div>
                     <input type="hidden" id="id_nfe" value="{{$id_nfe}}">   
					
                </div>
                </div>

		<div class="col-12">
            <div class="px-2">
                    <div class="tabela-responsiva pb-4">
                    <table cellpadding="0" cellspacing="0" id="dataTable11" class="table mt-3" width="100%">
                            <thead>
                             <tr>
                                    <th align="center" width="10">Id</th>
                                    <th align="left" width="25%">Nome</th>                                    
                                    <th align="center">Unidade</th>
                                    <th align="center">Qtde</th>
                                    <th align="center">Val Unit.</th>                                    
                                    <th align="center">Total Prod</th>
                                    <th align="center">Margem</th>
                                    <th align="center">Preço Venda</th>                                     
                                    <th align="center">Unidade</th>  
                                    <th align="center">Categoria</th>    
                                    <th align="center">Produto</th>                           
                                    <th align="center">Salvar</th>
                                </tr>
                            </thead>
                            <tbody>
                           <?php $total = 0; ?>
                     
                           @foreach($lista as $c) 
                                @php
                                	$margem_lucro = $c->margem_lucro > 0 ? $c->margem_lucro : $parametro->margem_lucro;
                                	$preco_venda  = $c->vUnCom/(1-$margem_lucro * 0.01);                                	
	
                                	
                                	$qtde_embalagem = (filter_var($c->uCom, FILTER_SANITIZE_NUMBER_INT)) ? filter_var($c->uCom, FILTER_SANITIZE_NUMBER_INT) : 1; 
                                	$qtde_total 	= $qtde_embalagem * $c->qCom;
                                	$val_unit 		= formataNumero($c->vProd / $qtde_total);
                                @endphp                     
                             <tr>
                        		<td align="center">
                        		<a href="{{route('admin.produto.novoPeloXml', $c->id)}}" target="_blank"  class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir Novo Produto"></a>
                        		{{$c->id}}</td>
                        		<td align="center">{{$c->xProd}}</td>
                        		<td align="center">{{$c->uCom}}</td>
                            	<td align="center">{{$c->qCom}}</td>
                            	<td align="center">{{$c->vUnCom}}</td>
                            	<td align="center">{{$c->vProd}}</td> 
                           	@if ($c->produto_id )
                        		<td align="center">{{$parametro->margem_lucro}}</td>
                        		<td align="center">{{$c->produto->valor_venda}}</td> 
                        		<td align="center">{{$c->produto->unidade}}  </td> 
                        		<td align="center">{{$c->produto->categoria->categoria ?? "sem Categoria"}}  {{isset($c->produto->subcategoria) ? ', '. $c->produto->subcategoria->subcategoria :''}} {{isset($c->produto->subsubcategoria) ? ', '. $c->produto->subsubcategoria->subsubcategoria :''}} </td>  
                        		<td align="center"><a href="{{route('admin.produto.edit', $c->produto->id)}}" target="_blank" >{{$c->produto->nome}}</a></td>
                        	@else
                            	
                            	<td align="center"><input  id="margem_lucro_{{$c->id}}"  value="{{$margem_lucro}}"  class="form-campo mascara-float"></td>
                            	<td align="center"><input  id="preco_{{$c->id}}"  value="{{formataNumeroBr($preco_venda)}}" class="form-campo mascara-float"></td>
                            	<td align="center">
                        			<select class="form-campo" id="unid_{{$c->id}}">
                        				@foreach($unidades as $unid)
                        					<option value='{{$unid->unidade}}' {{($unid->unidade ==$c->uCom) ? 'selected' : ''}}>{{$unid->unidade}}</option>
                        				@endforeach
                        			</select>	
                        		</td>
                        		<td align="center">
                        			<input  type="hidden" id="categoria_{{$c->id}}"  >
                        			<input  type="hidden" id="subcategoria_{{$c->id}}"  >
                        			<input  type="hidden" id="subsubcategoria_{{$c->id}}"  >
                        			<a href="javascript:;" onclick="abrirModalCadastroCategoria(1, {{$c->id}})"><span id="{{'nome_categoria_'.$c->id}}">Selecione uma Categoria</span></a>
                        		</td>
                        		<td align="center">
                        			<input type="hidden" value="{{moedaBr($c->vUnCom)}}" id="custo_{{$c->id}}" class="mascara-float"  >
                        			<a href="javascript:;" onclick="abrirModalBuscarProduto({{$c->id}})" >Vincular Produto</a>
                        		</td>
                        	@endif
                        		<td align="center">
                            		<div id="botaoOK_{{$c->id}}" style="display:{{($c->produto_id ) ? 'block' : 'none'}}">
                            			<a href="javascript:;"  class="btn btn-verde d-inline-block" ><i class="fas fa-check"></i></a>
                            		</div>
                            		
                            		<div id="botaoSalvar_{{$c->id}}" style="display:{{($c->produto_id ) ? 'none'  : 'block' }}">
                            			<a href="javascript:;" onclick="salvarReduzido({{$c->id}})" class="btn btn-azul d-inline-block" title="Salvar"><i class="fas fa-save"></i></a>
                            		</div>
                            		
                            												
                            	 </td>
                        	</tr>
                              					 
							@endforeach  
				
                             						 
                        </tbody>
                                </table>								
                        </div>
                        </div>
                </div>

        </div>
</div>


@include("Admin.Compra.Nfe.modalBuscarProduto")
@include("Admin.Compra.Nfe.modalCadastroCategoriaCompleto")
@include ("Admin.Cadastro.Categoria.modal.modalCategoria")
@include ("Admin.Cadastro.SubCategoria.modal.modalSubCategoria")
@include ("Admin.Cadastro.SubSubCategoria.modal.modalSubSubCategoria")


<div class="window medio" id="modal_confirmar_entrada">
	<div class="p-2 px-4">
			<span class="pt-4 d-block h3 border-bottom fw-700">Entrada de Mercadoria</span>
		<div class="rows">
             <div class="col-12 mb-3">
                   <span class="text-label fw-700 h5 mb-1">Selecione as opções desejadas</span>
                    <div class="width-100 border radius-4">
                        <div class="check radio p-4 d-block">							
        					<label class="d-flex mb-1"><input type="checkbox" checked  id="lancar_estoque" name="lancar_estoque" value="S"> Lançar estoque</label>
        					<label class="d-flex mb-1"><input type="checkbox" checked id="lancar_financeiro" name="lancar_financeiro" value="S" > Gerar Financeiro</label>
        				</div>        				
    				</div>
    				  
             </div>                                 
         </div>
		 <div class="tfooter border-0 between">
    		 <div class="d-flex">
    			<a href="" class="btn btn-vermelho fechar">Fechar</a>
    		 </div>
		 
			<div >
				<a href="javascript:;" onClick="confirmarEntrada()" class="btn btn-verde border-bottom" >Confirmar Entrada Da Nota</a>
		 </div>
		 
	</div>
</div>


<script>
function calcularPreco(id){
	var margem 		= converteMoedaFloat($('#margem_lucro_'+id).val());
	var preco  		= converteMoedaFloat($('#preco_'+id).val());
	var custo  		= converteMoedaFloat($('#custo_'+id).val());	
	var novo_valor  = custo * (1 + margem * 0.01);
	
	$('#preco_'+id).val(formatarFloat(novo_valor));
	
}

function abrirModalCadastroCategoria(eh_modal, nfe_item_temp_id){
	$('#nfe_item_temp_id_para_categoria').val(nfe_item_temp_id);
	$.ajax({
         url: base_url + "admin/categoria/listarCategoria" ,
         type: "get",
         dataType:"Json",
         data:{},
         success: function(data){
			  fecharGiraGira(eh_modal);
        	  html = "<option value=''>selecione</option>";
			  for (i = 0; i < data.length; i++) {	
				  html +="<option value='"+ data[i].id +"'>" + data[i].categoria + "</option>";
			  }
			 
			 abrirModal("#modalCadastroCategoriaCompleto");
			 $("#cb_categoria_id").html(html);
         },
         beforeSend: function(){           
            giraGira(); 
        }
         
     });
	
}

function selecionarCategoriaNota(){
	var nfe_item_id	= $('#nfe_item_temp_id_para_categoria').val();
	var categoria_id		= $('#cb_categoria_id').val();
	var subcategoria_id		= $('#cb_subcategoria_id').val();
	var subsubcategoria_id	= $('#cb_subsubcategoria_id').val();
	
	$('#categoria_'+nfe_item_id).val(categoria_id); 
	$('#subcategoria_'+nfe_item_id).val(subcategoria_id);
	$('#subsubcategoria_'+nfe_item_id).val(subsubcategoria_id);
	
	var nome =  $("#cb_categoria_id option:selected").text();	
	
	if($("#cb_subcategoria_id option:selected").text()!="selecione"){
		nome += ", " + $("#cb_subcategoria_id option:selected").text();
	}
	
	if($("#cb_subsubcategoria_id option:selected").text()!="selecione" &&  $("#cb_subsubcategoria_id option:selected").text() !=""){
		nome += ", " + $("#cb_subsubcategoria_id option:selected").text();
	}

	$('#nome_categoria_'+nfe_item_id).html(nome);
	
	fecharModal();
	
}

function abrirModalFinalizarVenda(){
	abrirModal("#modal_confirmar_entrada");
}

function confirmarEntrada() {
	$.ajax
	({
		type: 'POST',
		data: {
			"id": $("#id_nfe").val(),
			
		},
		url: base_url + 'admin/nfeentrada/darEntrada' ,
		dataType: 'json',
		beforeSend: function (){
		   giraGira();
	   },
		success: function (data) {
			fecharModal();
			if(data.tem_erro ==true){
				$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
			}else{
				location.href = data.redirect ;
			}
		}, error: function (e) {
			console.log(e);
			fecharModal();
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
	});
	
}

</script>



@endsection