@extends("Admin.template")
@section("conteudo")
<div class="col-12 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de Vendas </span>
						
					</div>
                        
				
                </div>
                </div>

		<div class="col-12">

				<div class="px-2">
					<div class="rows">
					<div class="col">
						<div class="tabela-responsiva pb-4">
						<table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
								<thead>
								 <tr>
										<th align="center">Id</th>
										<th align="left">Cliente</th>
										<th align="center">Data</th>
										<th align="center">Valor</th>
										<th align="center">Status Venda</th>
										<th align="center">Status Financeiro</th>
										<th align="center">Nota Gerada</th>
										<th class="text-right">Obs</th>
										<th class="text-right"></th>
									</tr>
								</thead>
								<tbody>
							
								
								<?php $total = 0; ?>
							   @foreach($lista as $c)
							   @php
							   		$temNfe = isset($c->nfe) ? "S" : "N" ;
							   @endphp                                      
								 <tr>
									<td align="center">{{$c->id}} 
										<input type="hidden" id="nfe_{{$c->id}}" value="{{$c->enviou_nfe}}">										
										<input type="hidden" id="estoque_{{$c->id}}" value="{{$c->enviou_estoque}}">
									</td>
									<td align="center">{{substr($c->cliente->nome_razao_social, 0, 30)}}</td>
									<td align="center">{{ databr($c->data_venda)}}</td>
									
									<td align="center">{{ $c->valor_venda  }}	</td>
									<td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>									
									<td align="center"><span class="{{ strtolower($c->status_financeiro->status) }}">{{ $c->status_financeiro->status }}</span></td>
								    <td align="center">{{ isset($c->nfe) ? "Sim" : "Não"  }}	</td>
								
									<td align="right">	
											<input type="hidden" id="obs_{{$c->id}}" value="{{$c->observacao}}">																
											<a href="javascript:;" onclick="verObservacao({{$c->id}})" class="btn btn-verde d-inline-block" title="Observação"><i class="fas fa-edit"></i></a>
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
			
        </div>
</div>

        @endsection
		
<!--identificar cliente-->
<div class="window medio" id="modal_imprimir_nfe" style="padding:0!important">
<h4 class="d-block text-center pb-1 border-bottom mb-2 h4 p-3">Transmitir NFE</h4>
	<div class="p-2 text-center mt-2" id="giragira_venda">
		<img src="{{asset('assets/admin/img/load2.gif')}}" width="60" class="m-auto">
		<span class="text-cinza d-block mt-2 mb-2"> Aguarde carregando...</span>
	</div>
	
	<div class="p-2 text-center mt-2" id="div_retorno_negativo">
		<span class="msg msg-vermelho p-1 text-left">
			<span class="d-block text-center mb-0"> Erro: <b id="mensagem_erro_venda"></b></span>			
		</span>
	</div>	
	<div class="p-2 text-center mt-2" id="div_retorno_positivo">
		<span class="msg msg-verde p-1 text-left">
			<span class="d-block text-center mb-0"> Operação Realizada com Sucesso!!</span>			
		</span>
	</div>	
		
	<div class="text-right base-botoes radius-0 mt-0 p-1 border-top py-3 ">	
			<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho d-inline-block btn-medio"><i class="fas fa-times"></i> Fechar</a>
	</div>
</div>

<!--cancelar venda -->
<div class="window pdv medio" id="telaImprimirDanfe">	
	<div class="caixa mb-0 p-0">
	<span class="d-block text-center titulo pb-2 pt-2 h4 border-bottom mb-2 text-verde"><i class="fas fa-check"></i> Nfe Gerada Sucesso</span>
	<div class="p-2">
		<p class="h4 text-escuro text-center"><i class="fas fa-print"></i> Deseja imprimir o DANFE ?</p>							
	</div>
	<div class="tfooter center py-3">
		<a href="javascript:;" onclick="imprimirDanfe()" class="btn btn-verde"><i class="fas fa-check"></i> Sim</a>							
		<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho ml-1"><i class="fas fa-times"></i> Não</a>							
	</div>	
</div>
</div>

<div class="window menor" id="telaObservacao">
	<span class="tmodal msg msg-verde"><i class="fas fa-check"></i> <b>Observação</b></span>
	<div class="p-3 text-center">
		<p class="mb-3" id="obsVenda"></p>		 
	</div>
	
	<div class="tfooter end">
		<a href="" class="btn btn-neutro fechar p-0">Fechar</a> 
	</div>
</div>



<script>
location.href = base_url + "admin/venda";	

</script>
