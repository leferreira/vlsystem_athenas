@extends("templates.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                    <div class="caixa mb-3">
                        <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
                           <span class="d-flex center-middle mr-1"><i class="fas fa-arrow-right"></i> COTAÇÕES POR FORNECEDORES </span>
                            <a href="" class="btn btn-verde float-right px-5 h5 mb-0"><i class="fas fa-check"></i> Aprovar Todos</a> 
                        </div>
                  @foreach($lista as $solicitacao)
                  	@php
                        $classe = ($solicitacao->solicitacao->status_solicitacao_id <=2) ? "compra_ativo" : "" ;
                    @endphp
                        <div class="rows px-2  {{ $classe}} " id="{{ 'class_ativo_' .$solicitacao->id }}"  >	
                                <div class="col-9 mb-3">	
                                    <div class="tabela-responsiva sm mt-3 tborder">
                                        <table cellpadding="0" cellspacing="0" class="mb-0 table-bordered alt" width="100%">
                                            <thead>
                                                <tr>											
                                                    <th align="center"  width="40">Id</th>
                                                    <th align="left">Produto</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="status-date"> 

                                                    <td align="center">{{ $solicitacao->solicitacao_id }}</td>
                                                    <td align="left">
                                                        <strong class="d-block">{{ $solicitacao->solicitacao->produto->nome }}</strong>
                                                        <small class="datas">Data: {{ databr($solicitacao->solicitacao->data_solicitacao) }}</small>
                                                        
                                                        <small class="datas">Status: {{ $solicitacao->solicitacao->status->status_solicitacao }}</small>
                                                    </td>	
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <table cellpadding="0" cellspacing="0" class="px-4 py-3" width="100%">
                                                            <thead>
                                                                <tr>

                                                                    <th align="center"  width="20">Id</th>
                                                                    <th align="left">Fornecedor</th>
                                                                    <th align="center">Qtde</th>
                                                                    <th align="center">Valor</th>
                                                                    <th align="center">Subtotal</th>
                                                                    <th align="center">Status</th>
                                                                    <th align="center">Ação</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($solicitacao->itens as $item) 
                                                                
                                                                <tr class="status-bg"> 
                                                                        <td align="center">{{ $item->id}}</td>
                                                                        <td align="left">{{ $item->fornecedor->nome}} </td>	
                                                                        <td align="center">{{ $item->qtde }}</td>
                                                                        <td align="center">{{ $item->valor_cotacao}}</td>
                                                                        <td align="center">{{ $item->subtotal}}</td>
                                                                        <td align="center">{{ $item->status->status_item_cotacao }}</td>
                                                                        <td align="center">
                                                                        @if($solicitacao->solicitacao->status_solicitacao_id <=2) 
                                                                          <a href="{{route('itemcotacao.aprovar',[$item->id,$item->cotacao_id])}}"  class="btn btn-pequeno d-inline-block btn-verde">Aprovar</a>
                                                                        @else
                                                                             <a href="javascript:;"  class="btn btn-pequeno d-inline-block btn-verde">Sem Ação</a>
                                                                        @endif 
                                                                        </td>
                                                                 </tr>
                                                           @endforeach   
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-3 mt-3 d-flex mb-3 aprovar">
                                    <div class="caixa-clara width-100  bg-title3 border radius-4">	
                                        <span class="bg-title h5 p-1 text-center">FORNECEDOR RECOMENDADO</span>													
                                        <div class="px-3 py-2">
                                            <div class="border-bottom pb-3 mb-3">
                                                <small class="d-block">Fornecedores Recomendados:</small>
                                                <span class="d-block h5 text-uppercase" id="{{ 'forn_' .$solicitacao->id }}">{{ $solicitacao->menor_preco->nome }} </span>
                                                <small class="d-block">Menor valor:</small>
                                                <strong class="d-block h3 text-uppercase mb-0" id="preco_' .$solicitacao->id }}">R$ {{ $solicitacao->menor_preco->valor_cotacao }}</strong>
                                            </div>
                                            <div id="butAprova_3" >
                                            @if($solicitacao->status_solicitacao_id <=2)
                                                <a href="{{route('itemcotacao.aprovar',[ $solicitacao->menor_preco->id, $item->cotacao_id])}}" class="btn btn-verde h5">Aprovar</a>
                                            @endif
                                             </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
		@endforeach
                    </div>                                                	

                    </div>

                </div>
@endsection