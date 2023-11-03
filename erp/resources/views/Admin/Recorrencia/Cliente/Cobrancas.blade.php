<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h5 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Vendas Recorrente do Cliente: {{$cliente->nome_razao_social}} </span>
						
					</div>
                     
                </div>
                </div>

		<div class="col-12">
		<div class="rows">
		<div class="col">
			<div class="px-2">			
				<div class="p-1">
					<?php //$this->verMsg(); ?>
				</div>
               <div class="tabela-responsiva pb-4 mt-3">
                    <table cellpadding="0" cellspacing="0"  width="100%" id="dataTable" class="border contas">
                          
							<tbody>
							
							 	@foreach($vendas as $venda) 
							 	<tr>
							 		<th align="center">Id</th>
									<th align="left">Cliente</th>
									<th align="center">Data</th>
									<th align="center">Valor Inicial</th>
									<th align="center">Valor Recorrente</th>
									<th align="center">Status Venda</th>
									<th align="center">Status Financeiro</th>
									<th class="text-right">Editar</th>										
								
																	
                                    <tr class="thead">
                                       <tr>
									<td align="center">{{$venda->id}} </td>
									<td align="center">{{substr($venda->cliente->nome_razao_social, 0, 30)}}</td>
									<td align="center">{{ databr($venda->data_vendarecorrente)}}</td>
									<td align="center">{{ $venda->valor_primeira_parcela  }}	</td>
									<td align="center">{{ $venda->valor_recorrente  }}	</td>
									<td align="center"><span class="{{ strtolower($venda->status->status) }}">{{ $venda->status->status }}</span></td>									
									<td align="center"><span class="{{ strtolower($venda->status_financeiro->status) }}">{{ $venda->status_financeiro->status }}</span></td>
									<td align="center"><a href="{{route('admin.vendarecorrente.edit', $venda->id)}}">Editar</a>	</td>
							
					            
                                <tr class="thead">
                                       <td class="p-0">&nbsp;</td>                                   
                                       <td colspan="12"  class="p-1">
											<table cellpadding="0" cellspacing="0" class="table border menor fatura" width="100%">
												<thead>
													<tr>
													   <th align="left" colspan="8" style="border-top:0;padding-top:0.55rem;padding-bottom:.55rem"><span  class="h6 mb-0 text-left text-uppercase"><i class="fas fa-hand-holding-usd"></i> Lista de pagamentos</span></th>
													 </tr>
													<tr>
														<th align="center">#</th>
                										<th align="left">Descrição</th>
                										<th align="center">Vencimento</th>
                										<th align="center">Valor</th>
                										<th align="center">Status Venda</th>
                										<th align="center">Status Financeiro</th>
                										<th align="center">Edit</th>
                										<th align="center">Excluir</th>  
													</tr>
												</thead>
												 <tbody>
												 @foreach($venda->cobrancas as $c)
													<tr>
                    									<td align="center">{{$c->id}}</td>
                    									<td align="center">{{$c->descricao}}</td>
                    									<td align="center">{{ databr($c->data_vencimento)}}</td>
                    									
                    									<td align="center">{{ $c->valor  }}	</td>
                    									<td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>									
                    									<td align="center"><span class="{{ strtolower($c->status_financeiro->status) }}">{{ $c->status_financeiro->status }}</span></td>
                    									<td align="center"><a href="{{route('admin.cobranca.edit', $c->id)}}" class="btn btn-verde d-inline-block"><i class="fas fa-edit" title="Editar"></i></a></span></td>
                    									<td align="center">
                    										<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$c->id}}').submit() : '';" class="d-inline-block btn btn-circulo btn-vermelho btn-pequeno" title="Ecluir"><i class="fas fa-trash-alt"></i></a>
                                                            <form action="{{route('admin.cobranca.destroy', $c->id)}}" method="POST" id="apagar{{$c->id}}">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                {{csrf_field()}}
                                                            </form>
                    									</td>								
                    									
                    								 </tr>
													@endforeach
												</tbody>                
											</table>
									   </td>                                   
									<td class="p-0">&nbsp;</td>
                                </tr>
						
					
                                    </tr>                                      
								@endforeach
                             
                             
                 								
                            </tbody>
                    </table>								
                 </div>

            </div>
        </div>

		
		</div>
		</div>
		
        </div>
        </div>
        @include("Admin.Financeiro.ContaReceber.modal.modalPrevisao")
<script>
var receber_id = 0;
function pesquisar(mes){
	var ano = $("#ano").val();
	window.location.href=base_url + "admin/contareceber/pormes/?ano=" + ano + "&mes=" + mes;
}
function abrir_opcoes_receber(id){
	receber_id = id;
	$("#id_receber").html(id);
	mostrar_opcoes('opcoes_receber')
}

function fechar_opcoes_receber(){
	esconder_opcoes('opcoes_receber');
}

function abrimModalPrevisao(){
	$("#conta_receber_id").val(receber_id);
	$.ajax({
	   url: base_url + "admin/contareceberprevisao/lista/"  + receber_id,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
			 lista_previsao_pagamento(data.retorno);
		 }		
	});
	abrirModal('#modalPrevisao');
}



function confirmarPagamento(){
	giraGira();
	location.href = base_url + "admin/contareceber/confirmarPagamento/" + receber_id;	
}

function verDetalhe(){
	giraGira();
	location.href = base_url + "admin/contareceber/detalhe/" + receber_id;	
}

function verEdicao(){
	giraGira();
	location.href = base_url + "admin/contareceber/" + receber_id + "/edit";	
}

function abrirDuplicata(){
	window.location.href=base_url + "admin/contareceber/duplicata";
}

function excluir(){
    if (confirm('Tem Certeza?')){
    	$.ajax({
         url: base_url + "admin/contareceber/" + receber_id,
         type: "DELETE",
         dataType:"Json",
         data:{},
         success: function(data){
			  fecharGiraGira(0);
			  location.reload();
        	
         },
         beforeSend: function(){           
            giraGira(); 
        }
         
     });
    }	
}
</script>
@endsection