@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle  mb-0 h5"><i class="far fa-list-alt mr-1"></i> Lista de produto </span></span>
				
			</div>
                     
				<div class="px-2 pt-2"> 
					<form  action="" method="GET">
					<div class=" bg-padrao mt-2 p-2 radius-4">
						 <div class="rows p-3">	
							<div class="col-6">
									<span class="text-label text-branco">Produto</span>
									<input type="text" name="nome" value="{{($filtro->nome) ?? null}}"  class="form-campo">
							</div>
							<div class="col-4">
									<?php $id_categoria = ($filtro->categoria_id) ?? null ?>
									<span class="text-label text-branco">Categoria</span>
									<select class="form-campo" name="categoria_id">
									<option value="">Escolha uma Opção</option>
									@foreach($categorias as $cat)
                                      	<option value="{{$cat->id}}" {{($cat->id == $id_categoria) ? 'selected': ''}}>{{$cat->categoria}}</option>
                                      @endforeach 
                                      </select>
							</div>
							 <div class="col-2 pt-1 mt-1">
								  <input type="submit" value="Pesquisar" class="btn btn-azul text-uppercase">
							  </div>
						</div>								 
                    </div>								 
                     </form>
				</div>
            </div>		
    <div class="col">
        <div class="px-2 pb-4 tabela-responsiva mt-3">
            <table cellpadding="0" cellspacing="0"  width="100%" id="dataTable" class="border contas">
                    
                    <tbody>	
                    @foreach($lista as $p)
						<tr class="thead">
                            <th align="center">Id</th>
                            <th align="left" width="380">Produto</th>
                            <th align="center">Estoque</th>
                            <th align="center">Estoque Grade</th>
                            <th align="center">Estoque Grade Temp</th>
                            <th align="center">Ver Movimento</th>
                         </tr>
						<tr class="thead">
							<td align="center">{{$p->id}}</td>
							<td align="left">{{$p->nome}}</td>
							<td align="center">{{$p->estoque->quantidade ?? "---"}}</td>
							<td align="center">{{$p->estoque->qtde_grade ?? "---"}}</td>
							<td align="center">{{$p->estoque->qtde_grade_temp ?? "---"}}</td>	 
							<td align="center">
								<a href="{{route('admin.movimento.show', $p->id)}}"  class="btn btn-azul btn-menor d-inline-block">Ver Movimentos</a>
						
						   </td>
							@if($p->usa_grade =="S")           
                                  
                                <tr>                                   
                                       <td colspan="6" class="text-center" align="center">
											<table cellpadding="0" cellspacing="0" class="table border menor fatura m-auto" style="width:90%" center="center">
												<thead>
													<tr>
													   <th align="center" colspan="11"><span  class="h6 mb-0">GRADE</span></th>
													 </tr>
													<tr>
														<th align="center">Id</th>
                                                           <th class="text-left">Código Barra</th>
                                                           <th align="center">Descrição</th>
                                                           <th align="center">Estoque</th>
                                                           <th align="center">Estoque Temp</th>
                                                           <th align="center">Alterar Cod. Barra</th> 
                                                           <th align="center">Ajuste Grade</th> 
                                                           <th align="center">Ver Movimentos</th>
													</tr>
												</thead>
												 <tbody>
												 @foreach($p->grade as $g)
													<tr>
													
                                                       <td align="center">{{ $g->id }}<input type="hidden" id="barra_{{ $g->id }}" value="{{ $g->codigo_barra }}"></td>
                                                       <td align="center">{{ $g->codigo_barra }}</td>
                                                       <td align="left">{{ $g->descricao}} </td>                                                       
                                                       <td align="center">{{ $g->estoque}}</td>
                                                       <td align="center">{{ $g->estoque_temporario }}</td>
                                                       <td align="center">
                											<a href="javascript:;" onclick="abrirModalCodigoBarra({{$g->id}})" class="btn btn-roxo btn-menor d-inline-block">Alterar Cod. Barra</a>                									
                									   </td>
                									   
                                                       <td align="center">
                											<a href="javascript:;" onclick="abrirModalAjusteGrade({{$g->id}})" class="btn btn-roxo btn-menor d-inline-block">Ajuste Estoque</a>                									
                									   </td>
                									   
                									   <td align="center">
                											<a href="{{route('admin.movimentograde.show', $g->id)}}" class="btn btn-azul btn-menor d-inline-block fas fa-eye" title="Ver Movimentos"></a>                									
                									   </td>
                                                    </tr>
													@endforeach
												</tbody>                
											</table>
									   </td>                        
                                </tr>

							@endif
					
					
                         </tr>
					@endforeach
					</tbody>
			</table> 
			<div class="paginacao">
                {{ $lista->links() }}
            </div>  
	</div>
	</div>

							
	</div>
</div>

<div class="window pequeno menor" id="modalEntradaSaidaGrade">	
	<form id="frmCadVariacaoGrade">
			<div class="p-2  bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
				<span class="mb-0 h5"><i class="fas fa-plus"></i> Ajuste Grade</span>		
			</div>
		
			<div class="p-4">
				<div class="rows">
					<div class="col-8">
					<span class="text-label ">Tipo</span>
						<select id="tipo"  class="form-campo">
							<option value="E">Entrada</option>
							<option value="S">Saída</option>
						</select>								
					</div>
					
					<div class="col-4">
						<span class="text-label ">Qtde</span>
						<input type="text"  maxlength="100"  required name="variacao" id="qtde"  class="form-campo">								
					</div>
				</div>
			</div>
			<div class="tfooter end">
				<div class="d-flex h4 d-inline-block mb-0 align-items-center">
					<input type="hidden"  id="grade_id"  >
					<a href="javascript:;" onclick="fazerMovimentacaoGrade()" class="btn btn-azul"><i class="fas fa-check"></i> Salvar</a>
					<a href="" class="btn btn-vermelho btn-menor fechar ml-1" title="Cadastrar cancelar"><i class="fas fa-times"></i> Cancelar</a>
				</div>
			</div>
		</form>
</div>

<div class="window pequeno menor" id="modalAlterarCodigoBarra">	
	<form id="frmCadVariacaoGrade">
			<div class="p-2  bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
				<span class="mb-0 h5"><i class="fas fa-plus"></i> Alterar Código Barra</span>		
			</div>
		
			<div class="p-4">
				<div class="rows">
					<div class="col-6">
						<span class="text-label ">Código Anterior</span>
						<input type="text"  maxlength="100"  readonly="readonly"  id="codigo_barra_anterior"  class="form-campo">								
					</div>
					
					<div class="col-6">
						<span class="text-label ">Código Novo</span>
						<input type="text"  maxlength="100" maxlength="13"  required  id="codigo_barra"  class="form-campo">								
					</div>
				</div>
			</div>
			<div class="tfooter end">
				<div class="d-flex h4 d-inline-block mb-0 align-items-center">
					<a href="javascript:;" onclick="alterarCodigoBarra()" class="btn btn-azul"><i class="fas fa-check"></i> Salvar</a>
					<a href="" class="btn btn-vermelho btn-menor fechar ml-1" title="Cadastrar cancelar"><i class="fas fa-times"></i> Cancelar</a>
				</div>
			</div>
		</form>
</div>

<script>
function abrirModalAjusteGrade(id){
	$("#grade_id").val(id);	
	abrirModal("#modalEntradaSaidaGrade");
}

function abrirModalCodigoBarra(id){
	$("#grade_id").val(id);
	var anterior = 	$("#barra_"+id).val();
	$("#codigo_barra_anterior").val(anterior);	
	abrirModal("#modalAlterarCodigoBarra");
}

function fazerMovimentacaoGrade(){
	var grade_id	= $("#grade_id").val();		
	var qtde		= $("#qtde").val();	
	var tipo		= $("#tipo").val();
		
	
	$.ajax({
		url: base_url + "admin/movimentograde/inserirAjusteGrade",
	   type: "POST",
	   dataType: "json",
	   data:{	
	   		grade_id	:grade_id,
	   		qtde		: qtde,
	   		tipo		: tipo,
	   	},
		 success: function(data){
			 if(data.tem_erro ==true){
				fecharGiraGira(eh_modal);
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				fecharModal();
				$("#mostrarUmErro").html(MostrarUmaMsgSucesso(" Registro Inserido com Sucesso"));
				location.reload();
			} 
		 }, error: function (e) {
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
		
	});
}

function alterarCodigoBarra(){
	var grade_id	= $("#grade_id").val();
	var barra		= $("#codigo_barra").val();	
		
	
	$.ajax({
		url: base_url + "admin/grade/alterarCodigoBarra",
	   type: "POST",
	   dataType: "json",
	   data:{	
	   		grade_id	:grade_id,
	   		codigo_barra: barra,
	   	},
		 success: function(data){
			 if(data.tem_erro ==true){
				fecharGiraGira(eh_modal);
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				fecharModal();
				$("#mostrarUmErro").html(MostrarUmaMsgSucesso(" Registro Inserido com Sucesso"));
				location.reload();
			} 
		 }, error: function (e) {
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
		
	});
}
</script>
@endsection