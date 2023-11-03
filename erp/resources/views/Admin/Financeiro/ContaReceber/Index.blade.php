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
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Contas a Receber </span>
						<div>
							<a href="{{ route('admin.contareceber.create')}}" class="btn btn-azul d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i>Adicionar novo </a>
						</div>
					</div>
                        
					<form  method="GET">
                        <div class="px-2 pt-2">	
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-2 mb-2">	
                                                <label class="text-label d-block text-branco">Vencimento 01 </label>
                                                <input type="date" name="venc01" value="{{$filtro->venc01 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-2 mb-2">	
                                                <label class="text-label d-block text-branco">Vencimento 02 </label>
                                                <input type="date" name="venc02" value="{{$filtro->venc02 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-2 mb-2">	
                                                <label class="text-label d-block text-branco">Emissão 01 </label>
                                                <input type="date" name="emissao01" value="{{$filtro->emissao01 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-2 mb-2">	
                                                <label class="text-label d-block text-branco">Emissão 02 </label>
                                                <input type="date" name="emissao02" value="{{$filtro->emissao02 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-2 mb-2">	
                                                <label class="text-label d-block text-branco">Previsão 01 </label>
                                                <input type="date" name="previsao01" value="{{$filtro->previsao01 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-2 mb-2">	
                                                <label class="text-label d-block text-branco">Previsão 02 </label>
                                                <input type="date" name="previsao02" value="{{$filtro->previsao02 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-1">	
                                                <label class="text-label d-block text-branco">Venda </label>
                                                <input type="text" name="venda_id" value="{{$filtro->venda_id ?? ''}}" class="form-campo">
                                        </div>
                                        
                                        @php
                                        	$id_cliente 	= $filtro->cliente_id ?? '';
                                        	$id_status 		= $filtro->status_id ?? '';
                                        @endphp
                                        <div class="col-3">	
                                             <label class="text-label d-block text-branco">Cliente </label>
                                            <select name="cliente_id" class="form-campo">
                                                <option value="">Selecione</option>  
                                               @foreach($clientes as $c) 
                                                	<option value="{{$c->id}}" {{$id_cliente==$c->id ? 'selected' : ''}}>{{$c->nome_razao_social}}</option>  
                                               @endforeach                                                  
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3">				   
                    						<label class="text-label text-branco mb-1">Status </label>
        									<div class="check d-flex">
        										 <label class=" d-flex text-branco text-uppercase"><input type="checkbox" class="mr-1" name="status_id[]"  value="{{config('constantes.status.ABERTO')}}" {{in_array(config('constantes.status.ABERTO'), $filtro->status_id) ? 'checked' : ''}}> ABERTO</label>
        										 <label class="ml-2 d-flex text-branco text-uppercase text-uppercase ml-6"><input type="checkbox" class="mr-1" name="status_id[]" value = "{{config('constantes.status.PARCIALMENTE_PAGO')}}" {{in_array(config('constantes.status.PARCIALMENTE_PAGO'), $filtro->status_id) ? 'checked' : ''}}> PARCIALMENTE PAGO</label>
        										 <label class="ml-2 d-flex text-branco text-uppercase ml-6"><input type="checkbox" class="mr-1" name="status_id[]" value = "{{config('constantes.status.PAGO')}}" {{in_array(config('constantes.status.PAGO'), $filtro->status_id) ? 'checked' : ''}}> PAGO</label>
        									
        									</div>            						
                    					</div>
                    					
                    					<div class="col-2 ">				   
                    						<label class="text-label text-vermelho mb-1">&nbsp;</label>
        									<div class="check d-flex">
        										 <label class="text-branco text-uppercase d-flex"><input type="checkbox" class="mr-1" name="mostrar_pagto"  value="S" {{ $filtro->mostrar_pagto=="S" ? 'checked' : ''}}> Mostrar Pagto</label>
        									</div>            						
                    					</div>
                                     
                                        <div class="pt-1 col-2 mt-1">
                                                <input type="submit" value="Filtrar" class="btn btn-roxo text-uppercase width-100">
                                        </div>
                                </div>
                                </div>
                        </div>
                    </form>
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
								<?php 
								    $valor_original = 0;
								    $total_recebido = 0;
								    $total_restante = 0;
								    $total_juros    = 0;
								    $total_multa    = 0;
								    $total_desconto = 0;
								    $total_liquido = 0;
								
								?>
								
								@if($filtro->mostrar_pagto!="S")
									<tr class="thead">
                                       <th align="center">Id</th>
                                       <th class="text-left">Descrição</th>
                                       <th align="center">Data Emissão</th>
                                       <th align="center">Vencimento</th>
                                       <th align="center">Previsão Pagto</th>                                       
                                       <th align="center">Valor Original</th>
                                       <th align="center">Total Recebido</th>
                                       <th align="center">Total Restante</th>
                                       <th align="center">Juros</th>
                                       <th align="center">Multa</th>
                                       <th align="center">Desconto</th>  
                                       <th align="center">Líquido</th>                                
                                       <th align="center">Status</th>
                                       <th align="center"></th>
                                    </tr>
							@endif
							
							
							 	@foreach($lista as $lancamento) 
							 	<?php 
							 	   $valor_original += $lancamento->valor;
							 	   $total_recebido += $lancamento->total_recebido;
							 	   $total_restante += $lancamento->total_restante;
							 	   $total_juros    += $lancamento->total_juros;
							 	   $total_multa    += $lancamento->total_multa;
							 	   $total_desconto += $lancamento->total_desconto;
							 	   $total_liquido += $lancamento->total_liquido;
								
								?>
								@if($filtro->mostrar_pagto=="S")
									<tr class="thead">
                                       <th align="center">Id</th>
                                       <th class="text-left">Descrição</th>
                                       <th align="center">Data Emissão</th>
                                       <th align="center">Vencimento</th>
                                       <th align="center">Previsão Pagto</th>                                       
                                       <th align="center">Valor Original</th>
                                       <th align="center">Total Recebido</th>
                                       <th align="center">Total Restante</th>
                                       <th align="center">Juros</th>
                                       <th align="center">Multa</th>
                                       <th align="center">Desconto</th>  
                                       <th align="center">Líquido</th>                                
                                       <th align="center">Status</th>
                                       <th align="center"></th>
                                    </tr>
							@endif		
                                    <tr class="thead">
                                       <td align="center">{{ $lancamento->id }}</td>
                                       <td align="left">{{ $lancamento->descricao }} <small class="d-block text-azul text-uppercase">{{ $lancamento->cliente->nome_razao_social }} <b class="qtd">{{ $lancamento->num_parcela }} / {{ $lancamento->ult_parcela }} </b></small></td>
                                       <td align="center">{{ databr($lancamento->data_emissao) }}</td>
                                       <td align="center">{{ databr($lancamento->data_vencimento) }}</td>
                                       <td align="center">{{ ($lancamento->data_previsao) ? databr($lancamento->data_previsao) : "--" }}</td>
                                       <td align="center">{{ $lancamento->valor}}</td>
                                       <td align="center">{{ $lancamento->total_recebido }}</td>
                                       <td align="center">{{ $lancamento->total_restante }}</td>
                                       <td align="center">{{ $lancamento->total_juros }}</td>
                                       <td align="center">{{ $lancamento->total_multa }}</td>
                                       <td align="center">{{ $lancamento->total_desconto }}</td>
                                       <td align="center">{{ $lancamento->total_liquido }}</td>
                                       
                                       <td align="center"><span class="{{ strtolower($lancamento->status->status) }}">{{ $lancamento->status->status }}</span></td>
                                    
									   <td align="center">
        								<a href="javascript:;" onclick="abrir_opcoes_receber({{$lancamento->id}})" ><i class="ellipsis-vertical"></i></a>
        							</td>
							
					 @if(count($lancamento->recebimentos) > 0)           
                      @if($filtro->mostrar_pagto=="S")            
                                <tr class="thead">
                                       <td class="p-0">&nbsp;</td>                                   
                                       <td colspan="12"  class="p-1">
											<table cellpadding="0" cellspacing="0" class="table border menor fatura" width="100%">
												<thead>
													<tr>
													   <th align="left" colspan="12" style="border-top:0;padding-top:0.55rem;padding-bottom:.55rem"><span  class="h6 mb-0 text-left text-uppercase"><i class="fas fa-hand-holding-usd"></i> Lista de pagamentos</span></th>
													 </tr>
													<tr>
														<th align="center">Id</th>
                                                           <th class="text-left">Descrição</th>
                                                           <th align="center">Data Recebimento</th>
                                                           <th align="center">Número</th>
                                                           <th align="center">Valor Original</th>
                                                           <th align="center">Juros</th>
                                                           <th align="center">Desconto</th>
                                                           <th align="center">Multa</th>
                                                           <th align="center">Valor Recebido</th>
                                                           <th align="center">Forma Pagto</th>
                                                           <th align="center">Opções</th>  
													</tr>
												</thead>
												 <tbody>
												 @foreach($lancamento->recebimentos as $rec)
													<tr class="tbtd">
                                                       <td align="center">{{ $rec->id }}</td>
                                                       <td align="left">{{ $rec->descricao_recebimento }} </td>
                                                       <td align="center">{{ databr($rec->data_recebimento) }}</td>
                                                       <td align="center">{{ $rec->numero_documento }}</td>
                                                       <td align="center">{{ $rec->valor_original }}</td>
                                                       <td align="center">{{ $rec->juros }}</td>
                                                       <td align="center">{{ $rec->desconto }}</td>
                                                       <td align="center">{{ $rec->multa }}</td>
                                                       <td align="center">{{ $rec->valor_recebido }}</td>
                                                       <td align="center">{{ ($rec->forma_pagamento) ? $rec->forma_pagamento->forma_pagto : '--' }}</td>
                                                       <td align="center">
                											<a href="{{route('admin.recebimento.show', $rec->id)}}" class="btn btn-roxo d-inline-block"><i class="fas fa-eye" title="Visualizar"></i></a>
                									
                									   </td>
                                                    </tr>
													@endforeach
												</tbody>                
											</table>
									   </td>                                   
									<td class="p-0">&nbsp;</td>
                                </tr>
						@endif
					@endif
					
                                    </tr>                                      
								@endforeach
                             
                             
                
					
                                <tr style="background:#c9d0d38a;">
                                       <td align="right" colspan="5" class="border-top py-3 text-uppercase"><b>Totais</b></td>
                                       <td align="center" class="border-top py-3">{{ formataNumeroBr($valor_original) }}</td>
                                       <td align="center" class="border-top py-3">{{ formataNumeroBr($total_recebido) }}</td>
                                       <td align="center" class="border-top py-3">{{ formataNumeroBr($total_restante) }}</td>
                                       <td align="center" class="border-top py-3">{{ formataNumeroBr($total_juros) }}</td>
                                       <td align="center" class="border-top py-3">{{ formataNumeroBr($total_multa) }}</td>
                                       <td align="center"  class="border-top py-3">{{ formataNumeroBr($total_desconto) }}</td>
                                       <td align="center"  class="border-top py-3">{{ formataNumeroBr($total_liquido) }}</td>
                                       <td align="left" colspan="2" class="border-top py-3"></td>                                    
							
                                </tr> 								
                            </tbody>
                    </table>								
                 </div>

            </div>
        </div>

		<!-- MOSTRA AS OPÇÕES  MostraOpcoes --->
		<div class="col-2 mt-4 MostraOpcoes sm-mx" id="opcoes_receber">
		
			<ul class="cx-opcoes" >
				<li class="titulo bg-padrao text-branco d-flex center-middle justify-content-space-between">
					<span>Opções: <span id="id_receber"></span> </span> 
					<a href="javascript:;" onClick="fechar_opcoes_receber()" title="Fechar Opções" class="text-vermelho position-inherit p-0"><i class="fas fa-times position-inherit"></i></a>
				</li>
				<li><a href="javascript:;" onclick="verEdicao()" class="" title="Editar "><i class="fas fa-edit"></i> Editar</a></li>
				<li><a href="javascript:;" onClick="confirmarPagamento()" title="Dar baixa"><i class="fas fa-eye"></i> Dar Baixa</a></li>
				<li><a href="javascript:;" onclick="verDetalhe()" class="" title="Pagamentos "><i class="fas fa-hand-holding-usd"></i> Pagamentos</a></li>
				<li><a href="javascript:;" onclick="abrimModalPrevisao()" class="" title="Previsão de pagamento "><i class="fas fa-hand-holding-usd"></i> Previsão Pagamento</a></li>
				
				<!--  <li><a href="javascript:;" onClick="abrirDuplicata()" title="Gerar Nota Fiscal"><i class="fas fa-eye"></i> Imprimir Duplicata</a></li> -->
				<li><a href="javascript:;" onclick="excluir()" title="Excluir"><i class="fas fa-trash-alt"></i> Excluir</a></li>
	
			</ul>
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