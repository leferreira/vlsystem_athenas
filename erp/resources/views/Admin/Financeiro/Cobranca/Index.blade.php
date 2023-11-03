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
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Cobrancas</span>
						<div>
							<a href="" class="btn btn-laranja filtro  d-inline-block"><i class="fas fa-filter"></i> Filtrar</a>
						</div>
					</div>	

					<form  action="{{route('admin.cobranca.filtro')}}" method="GET">
                        <div class="px-2 pt-2">	
							  <div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
							    		@php
                                        	$id_status 		= $filtro->status_id ?? '';
                                        @endphp
                                        
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Vencimento 01 </label>
                                                <input type="date" name="venc01" value="{{$filtro->venc01 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Vencimento 02 </label>
                                                <input type="date" name="venc02" value="{{$filtro->venc02 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Emissão 01 </label>
                                                <input type="date" name="emissao01" value="{{$filtro->emissao01 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Emissão 02 </label>
                                                <input type="date" name="emissao02" value="{{$filtro->emissao02 ?? ''}}" class="form-campo">
                                        </div>
                                        
                                        <div class="col-4">	
                                             <label class="text-label d-block text-branco">Status </label>
                                            <select name="status_id" class="form-campo">
                                                <option value="">Selecione</option>  
                                               @foreach(config('constantes.status') as $c=>$v) 
                                                	<option value="{{$v}}" {{$id_status==$c ? 'selected' : ''}}>{{$c}}</option>  
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

		<div class="col-12">
			<div class="px-2 pt-2">	
				<div class="bg-body border mt-2 p-2 radius-4">
					<div class="d-flex mb-0 center-middle">
						<div class="d-flex border radius-4 col-2 state-movi p-0">
							<select class="form-campo width-100" id="ano">
							 @for($i=1;$i<=10; $i++ )
							 	<?php $ano =2021+$i ?>
								<option value="{{$ano}}" {{($ano==date('Y')) ? 'selected' : '' }}>{{$ano}}</option>
							@endfor
							</select>
						</div>
						<div class="state-movi ml-4">
						@foreach(ConstanteService::listaMeses() as $c=>$v)
							<a href="javascript:;" onclick="pesquisar({{$c}})" class="status status-{{(zeroEsquerda($c,2)==$mes) ? 'vermelho' : 'neutro'}} mb-0">{{$v}}</a>
						@endforeach
						</div>
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
											<a href="{{route('admin.cobranca.confirmarPagamento', $lancamento->id)}}" class="btn btn-roxo d-inline-block"><i class="fas fa-eye" title="Confirmar Pagamento"></i></a>
											
											<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$lancamento->id}}').submit() : '';" class="d-inline-block btn btn-circulo btn-vermelho btn-pequeno" title="Ecluir"><i class="fas fa-trash-alt"></i></a>
                                            <form action="{{route('admin.cobranca.destroy', $lancamento->id)}}" method="POST" id="apagar{{$lancamento->id}}">
                                                <input type="hidden" name="_method" value="DELETE">
                                                {{csrf_field()}}
                                            </form>
											<a href="{{route('admin.cobranca.edit', $lancamento->id)}}" class="btn btn-verde d-inline-block"><i class="fas fa-edit" title="Editar"></i></a>
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
		window.location.href=base_url + "admin/cobranca/pormes/?ano=" + ano + "&mes=" + mes;
	}
</script>
@endsection