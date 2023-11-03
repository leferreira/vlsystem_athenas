<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Faturas</span>
						<div>
							<a href="{{route('admin.assinatura.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
						</div>
					</div>	

				
                </div>
                </div>

	
		
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
<script>
	function pesquisar(mes){
		var ano = $("#ano").val();
		window.location.href=base_url + "admin/fatura/pormes/?ano=" + ano + "&mes=" + mes;
	}
</script>
@endsection