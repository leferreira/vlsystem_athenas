
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
					<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Produtos </span>
						<div>
							<a href="{{route('admin.notafiscal.index')}}" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Voltar</a>
						@if(!$pode_editar)
							<a href="{{route('admin.notafiscal.edit',$nota->id )}}" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Ir Para Edição</a>
						@endif	
						</div>
					</div>
                        
					 <input type="hidden" id="natureza_operacao_id" value="{{$nota->natureza_operacao_id }}" />
                </div>
                </div>

		<div class="col-12">
            <div class="px-2">
           
                    <div class="tabela-responsiva pb-4">
                    <table cellpadding="0" cellspacing="0" id="dataTable11" class="table mt-3" width="100%">
                            <thead>
                             <tr>
                                    <th align="center" width="10">Id</th>
                                    <th align="center">cProd</th>
                                    <th align="left">Nome</th>
                                    
                                    <th align="center">Unidade</th>
                                    <th align="center">Qtde</th>
                                    <th align="center">Val Unit.</th>                                    
                                    <th align="center">Total Prod</th>
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
                                                   
                             <tr>
                                <td align="center">{{$c->id}}</td>
                                <td align="center">{{$c->cProd}}</td>
                                @if ($c->produto_id )
                                	<td align="center">{{$c->xProd}}</td> 
                                @else
                                	<td align="center"><a href="javascript:;" onclick="abrirFormulario({{$c->id}})" >{{$c->xProd}}</a></td>                                
                                @endif
                                <td align="center">{{$c->uCom}}</td>
                                <td align="center">{{$c->qCom}}</td>
                                <td align="center">{{$c->vUnCom}}</td>                                                             
                                <td align="center">{{ formataNumero($c->vProd)  }}	</td>
                                
                                
                                @if ($c->produto_id )
                                	<td align="center">{{$c->produto->valor_venda}}</td> 
                                	<td align="center">{{$c->produto->unidade}}  </td> 
    								<td align="center">{{$c->produto->categoria->categoria ?? "Sem Categoria"}}  {{isset($c->produto->subcategoria) ? ', '. $c->produto->subcategoria->subcategoria :''}} {{isset($c->produto->subsubcategoria) ? ', '. $c->produto->subsubcategoria->subsubcategoria :''}} </td>  
    								<td align="center"><a href="javascript:;" onclick="abrirModalBuscarProduto({{$c->id}})" >{{$c->produto->nome}}</a></td>
    							                                 
                                  
								@else
								   <td align="center"><input  id="preco_{{$c->id}}"    class="form-campo mascara-float"></td>
                                   <td align="center">
                                    	<select class="form-campo" id="unid_{{$c->id}}">
    										@foreach($unidades as $unid)
    											<option value='{{$unid}}' {{($unid ==$c->uCom) ? 'selected' : ''}}>{{$unid}}</option>
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

@include("Admin.Compra.Nfe.modalProduto")
@include("Admin.Compra.Nfe.modalBuscarProduto")
@include("Admin.Compra.Nfe.modalCadastroCategoriaCompleto")
@include ("Admin.Cadastro.Categoria.modal.modalCategoria")
@include ("Admin.Cadastro.SubCategoria.modal.modalSubCategoria")
@include ("Admin.Cadastro.SubSubCategoria.modal.modalSubSubCategoria")

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
</script>



@endsection