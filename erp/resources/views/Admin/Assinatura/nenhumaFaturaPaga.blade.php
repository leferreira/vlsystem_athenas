@extends("Admin.template")
@section("conteudo")
<div class="base-banner">
<div class="central">
<div class="central">
	<div class="conteudo obrigado vencido">
		<div class="rows">
			<div class="col-12 m-auto text-center">
				<i class="fas fa-times"></i>
				<span class="d-block text-center text-escuro mt-0 h1 mb-0">Não Existe Nenhuma Fatura Paga</span>
			</div>
		</div>
	</div>



	<div class="p-3">
		
			<div class="col-12">
			<div class="px-2">			
				<div class="p-1">
					<?php //$this->verMsg(); ?>
				</div>
               <div class="tabela-responsiva pb-4 mt-3">
                    <table cellpadding="0" cellspacing="0"  width="100%" id="dataTable">
                            <thead>
                                    <tr>
                                       <th align="center">Id</th>
                                       <th class="text-left">Lançamento</th>
                                       <th align="center">Data Emissão</th>
                                       <th align="center">Vencimento</th>
                                       <th align="center">Valor total</th>
                                       <th align="center">Status</th>
                                       <th align="center">Opções</th>
                                    </tr>
                            </thead>                             
								
							<tbody>
							@foreach($lista as $lancamento)  
                                    <tr>
                                       <td align="center">{{ $lancamento->id }}</td>
                                      <td align="center">{{ $lancamento->descricao }}</td>                                       
                                       
                                       <td align="center">{{ databr($lancamento->data_emissao) }}</td>                                       
                                       <td align="center">{{ databr($lancamento->data_vencimento) }}</td>
                                       <td align="center">{{ $lancamento->valor }}</td>
                                       <td align="center"><span class="{{ strtolower($lancamento->status->status) }}">{{ $lancamento->status->status }}</span></td>
                                       <td align="center">
											<a href="{{route('admin.fatura.confirmarPagamento', $lancamento->id)}}" class="btn btn-roxo d-inline-block"><i class="fas fa-eye" title="Confirmar Pagamento"></i></a>
											
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