@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de Compras </span>
						<div>
							<a href="{{route('admin.nfeentrada.index')}}" class="btn btn-azul ml-1 d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i>Importar NFE </a>
							<a href="{{route('admin.compra.create')}}" class="btn btn-azul ml-1 d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i>Compra Manual </a>
						</div>
					</div>
                        
					<form name="busca" action="{{route('admin.compra.filtro')}}" method="get">                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data 1</label>
                                            <input type="date" name="data1" value="{{$filtro->data1 ?? null}}" class="form-campo">
                                        </div>
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data 2</label>
                                            <input type="date" name="data2" value="{{$filtro->data1 ?? null}}" class="form-campo">
                                        </div>
                                      <div class="col-3">	
                                            <label class="text-label d-block text-branco">Fornecedor</label>
                                            <select class="form-campo" name="fornecedor_id">
                                            <option value="">Selecione</option>
                                            @foreach($fornecedores as $f)
												<option value="{{$f->id}}" {{($filtro->fornecedor_id ?? null)==$f->id ? 'selected' : null}}>{{$f->razao_social}}</option>
											@endforeach
											</select>
                                        </div>
                                        
                                       
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="Pesquisar" class="btn btn-roxo text-uppercase">
                                        </div>
                                </div>
                                </div>
                        </div>
                    </form>
                </div>
                </div>

		<div class="col">
            <div class="px-2">
                    <div class="tabela-responsiva pb-4">
                    <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                             <tr>
                                    <th align="center" width="10">Id</th>
                                    <th align="left">Fornecedor</th>
                                    <th align="center">Data</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Num NFE</th>
                                    <th align="center">Status</th>
                                    
                                    <th align="center" >Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total = 0; ?>
                           @foreach($lista as $c)                                      
                             <tr>
                                <td align="center">{{$c->id}}
										<input type="hidden" id="estoque_{{$c->id}}" value="{{$c->enviou_estoque}}">
										<input type="hidden" id="financeiro_{{$c->id}}" value="{{$c->enviou_financeiro}}">
                                </td>
                                <td align="center" >{{substr($c->fornecedor->razao_social, 0, 30)}}</td>
                                <td align="center">{{ databr($c->data_compra)}}</td>                                
                                <td align="center">{{ $c->valor_compra  }}	</td>
                               <td align="center">{{ $c->nf  }}	</td>
                               <td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>
                               <td align="right">
									<a href="javascript:;" onclick="abrir_opcoes_compra({{$c->id}})" ><i class="ellipsis-vertical"></i></a>
								</td>
                             </tr>
							 
							
                         @endforeach  
							
                             						 
                        </tbody>
                                </table>
								
                        </div>

                        </div>

                </div>
                
                <!-- MOSTRA AS OPÇÕES  MostraOpcoes --->
					<div class="col-2 MostraOpcoes" id="opcoes_compra">
						<ul class="cx-opcoes" >
							<li>Compra:<span id="id_compra"></span></li> 								
							<li class="concreto"><a href="javascript:;" onclick="editar()"><i class="fas fa-eye"></i> Editar</a></li>
							<li class="concreto"><a href="javascript:;" onclick="verContaPagar()" class="" title="Visualizar Contas a Pagar"><i class="fas fa-dollar-sign"></i> Ver Contas a Pagar</a></li>
								
							<li class="concreto"><a href="javascript:;" onclick="lancarEstoque()" class="" title="Visualizar Contas a Pagar"><i class="fas fa-dollar-sign"></i> Lançar Estoque</a></li>
							<li class="concreto"><a href="javascript:;" onclick="estornarEstoque()" class="" title="Visualizar Contas a Pagar"><i class="fas fa-dollar-sign"></i> Estornar Estoque</a></li>
							<li class="concreto"><a href="javascript:;" onclick="abrirModalNaturezaOperacao()"><i class="fas fa-eye"></i> Gerar Nota de Devolução</a></li>
							
							
							<li class="concreto"><a href="javascript:;" onClick="fechar_opcoes_compra()" title="Fechar Opções"><i class="fas fa-file-pdf"></i> Fechar Opções</a></li>								
						
						</ul>
					</div>

        </div>
</div>

<div class="window  medio" id="SelecionarNaturezaOperacional">
	<span class="d-block titulo mb-0"><i class="fas fa-plus-circle"></i> Gerar Nota de Devolução</span>
	
		<div class="p-3">
			<div class="rows">
                <div class="col-8">	
                    <label class="text-label d-block">Selecione a Natureza de Operação </label>
                    <select class="form-campo" id="natureza_operacao_id">
                		@foreach($naturezas as $natureza)
                			<option value="{{$natureza->id}}" {{$natureza->padrao==config('constantes.padrao_natureza.DEVOLUCAO_VENDA') ? 'selected' : ''}}>{{$natureza->descricao}}</option>
                		@endforeach
                	</select>
                </div> 
			</div>
		</div>
		<div class="tfooter end">
			<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho " >Cancelar</a>
            <input type="button"  onclick="gerarNotaDevolucaoCompra()" value="Gerar Nota Fiscal" class="btn btn-azul text-uppercase">
		</div>	

</div>

<script>
var compra_id = 0;
function abrir_opcoes_compra(id){
	//var status_id 	= $("#status_"+id).val();
	var nfe 		= $("#nfe_"+id).val();
	var estoque		= $("#estoque_"+id).val();
	var financeiro	= $("#financeiro_"+id).val();
	
	$("#id_compra").html(id);
	compra_id = id;
	mostrar_opcoes('opcoes_compra');
	

	
	if(estoque=='S' ){
		$(".estoque_on").show();
		$(".estoque_off").hide();
	}else if(estoque=='N' ){
		$(".estoque_on").hide();
		$(".estoque_off").show();
	}
	
}

function fechar_opcoes_compra(){
	esconder_opcoes('opcoes_compra');
}

function editar(){
	giraGira();
	location.href = base_url + "admin/compra/edit/" + compra_id;	
}

function abrirModalNaturezaOperacao(){	
	abrirModal("#SelecionarNaturezaOperacional");
}

function gerarNotaDevolucaoCompra(){
	var natureza_id = $("#natureza_operacao_id").val();
	giraGira();
	location.href = base_url + "admin/notafiscal/devolucaoCompra/" + compra_id + "/" + natureza_id ;	
}

function lancarEstoque(){
	giraGira();
	location.href = base_url + "admin/compra/lancarEstoque/" + compra_id;	
}

function estornarEstoque(){
	giraGira();
	location.href = base_url + "admin/compra/estornarEstoque/" + compra_id;	
}

function verContaPagar(){
	giraGira();
	location.href = base_url + "admin/compra/financeiro/" + compra_id;	
}

function verDetalhe(){
	giraGira();
	location.href = base_url + "admin/compra/detalhe/" + compra_id;	
}

function enviarPorWhatsApp(){
	giraGira();
	location.href = base_url + "admin/compra/cupom/" + compra_id;	
}

function salvarNfePorCompra(){
	giraGira();
	location.href = base_url + "admin/notafiscal/salvarNfePorCompra/" + compra_id;	
}

function transmitirNfePelaCompra(id_compra){
	$("#id_compra").val(id_compra);
	$("#giragira_compra").show();
	$("#div_retorno_negativo").hide();
	$("#div_retorno_positivo").hide();
	abrirModal('#modal_imprimir_nfe');
	$.ajax({
		url: base_url + "admin/compra/gerarNfePelaCompra/" + id_compra,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
		 	 $("#giragira_compra").hide();
		 	 if(data.tem_erro==true){
		 	 	$("#div_retorno_negativo").show();
		 	 	$("#mensagem_erro_compra").html(data.erro);
		 	 }
		 	 
		 	  if(data.tem_erro==false){
		 	 	abrirModal('#telaImprimirDanfe');
		 	 }
		}, error: function (e) {
			var response = e.responseText;	
			console.log(response.erro);			
		}
		
	});
	
}

function imprimirDanfe(id){
	id_compra = (id) ? id : $("#id_compra").val();	
	fecharModal();
	window.open(base_url + 'admin/nfe/imprimirDanfePelaCompra/'+id_compra, '_blank');
	location.href = base_url + "admin/compra";	
}
</script>
@endsection