@extends("Admin.template")
@section("conteudo")
<div class="col-12 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Consultas Pagamento </span>
						<div>
							<a href="{{route('admin.venda.create')}}" class="btn btn-azul ml-1 d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
						
						</div>
					</div>
                        
					<form name="busca" method="get">                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">							  			
                                        
                                      	
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Origem da Conta Receber</label>
                                            <select class="form-campo" name="origem">
                                            	<option value="">Todos</option>
                                            	<option value="venda_id" {{($filtro->origem ?? null) == 'venda_id' ? 'selected' : '' }}>Venda ERP</option>
                                            	<option value="pdvduplicata_id"  {{($filtro->origem ?? null) == 'pdvduplicata_id' ? 'selected' : '' }}>Venda PDV</option>
                                            	<option value="loja_pedido_id"  {{($filtro->origem ?? null) == 'loja_pedido_id' ? 'selected' : '' }}>Venda Loja Virtual</option>
                                            	<option value="cobranca_id"  {{($filtro->origem ?? null) == 'cobranca_id' ? 'selected' : '' }}>Cobrança</option>
                                            </select>
                                        </div>
                                   
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Descrição</label>
                                            <input type="text" name="descricao"  value="{{$filtro->descricao ?? ''}}"  class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Emissão 01 </label>
                                                <input type="date" name="pagamento01" value="{{$filtro->pagamento01 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Emissão 02 </label>
                                                <input type="date" name="pagamento02" value="{{$filtro->pagamento02 ?? ''}}" class="form-campo">
                                        </div>
                                        
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Vencimento 01 </label>
                                                <input type="date" name="venc01" value="{{$filtro->venc01 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Vencimento 02 </label>
                                                <input type="date" name="venc02" value="{{$filtro->venc02 ?? ''}}" class="form-campo">
                                    
                                       
                                </div>
                                </div>
                        </div>
                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">	                                        
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Usuario</label>
                                            <select class="form-campo" name="usuario_id">
                                            <option value="">Selecione</option>
                                            @foreach($usuarios as $s)
												<option value="{{$s->id}}" {{( $filtro->usuario_id ?? null)==$s->id ? 'selected' : null}}>{{$s->name}}</option>
											@endforeach
											</select>
                                        </div>
                                        
                                         <div class="col-3">	
                                            <label class="text-label d-block text-branco">Tipo de Relatório</label>
                                            <select class="form-campo" name="tipo_relatorio">
                                            	<option value="listagem">Listagem</option>
                                            	<option value="agrupado_por_pagamento" >Agrupado por Data Pagamento</option>
                                            	<option value="agrupado_por_emissao" >Agrupado por Data Emissão</option>
                                            	<option value="agrupado_por_cliente" >Agrupado por Cliente</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Tipo de Saída</label>
                                            <select class="form-campo" name="tipo_saida">
                                            	<option value="tela">Visualizar na Tela</option>
                                            	<option value="pdf">Gerar PDF</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="Filtrar" class="btn btn-roxo text-uppercase">
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
                                            </tr>
                                    </thead>
                                    <tbody> 
                                  @foreach($lista as $lancamento)                                     
                                     <tr>
        								<td align="center">{{ $lancamento->id }}</td>
                                       <td align="left">{{ $lancamento->descricao_recebimento }} </td>
                                       <td align="center">{{ databr($lancamento->data_recebimento) }}</td>
                                       <td align="center">{{ $lancamento->numero_documento }}</td>
                                       <td align="center">{{ $lancamento->valor_original }}</td>
                                       <td align="center">{{ $lancamento->juros }}</td>
                                       <td align="center">{{ $lancamento->desconto }}</td>
                                       <td align="center">{{ $lancamento->multa }}</td>
                                       <td align="center">{{ $lancamento->valor_recebido }}</td>
                                       <td align="center">{{ ($lancamento->forma_pagamento) ? $lancamento->forma_pagamento->forma_pagto : '--' }}</td>
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
		
<
