@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                   <span class="p-2 bg-title text-light text-uppercase  text-branco justify-content-space-between d-flex">
						<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Contas a Receber da Venda: <b class="text-vermelho"> {{$venda->id}}</b> </span>
						<div class="d-flex">
							<a href="{{ route('admin.contareceber.create')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Adicionar novo"><i class="fas fa-plus-circle"></i></a>
							<a href="{{route('admin.contareceber.index')}}" class="btn btn-azul btn-pequeno ml-1" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
							<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
						</div>
					</div>
                        
					<form name="busca" action="" method="GET">
                        <div class="px-2 pt-2">	
							  <div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-8">	
                                                <label class="text-label d-block text-branco">Nome </label>
                                                <input type="text" name="lancamento" value="" class="form-campo">
                                        </div>
                                        <div class="col-2">	
                                             <label class="text-label d-block text-branco">Ativo </label>
                                            <select name="ativo" class="form-campo">
                                                <option value="S">Sim</option>                                                 
                                                <option value="N">Não</option>                                                 
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
                                       <td align="left">{{ $lancamento->descricao }} <small class="d-block text-azul">{{ $lancamento->cliente->nome_razao_social }} <b class="qtd">{{ $lancamento->num_parcela }} / {{ $lancamento->ult_parcela }} </b></small></td>
                                       <td align="center">{{ databr($lancamento->data_emissao) }}</td>
                                       <td align="center">{{ databr($lancamento->data_vencimento) }}</td>
                                       <td align="center">{{ $lancamento->valor }}</td>
                                       <td align="center"><span class="{{ strtolower($lancamento->status->status) }}">{{ $lancamento->status->status }}</span></td>
                                       <td align="center">
											<a href="{{route('admin.contareceber.confirmarPagamento', $lancamento->id)}}" class="btn btn-roxo d-inline-block"><i class="fas fas fa-dollar-sign" title="Confirmar Pagamento"></i></a>
											<a href="" class="btn btn-vermelho d-inline-block"><i class="fas fa-trash" title="Excluir"></i></a>
											<a href="" class="btn btn-verde d-inline-block"><i class="fas fa-edit" title="Editar"></i></a>
									   </td>
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

@endsection