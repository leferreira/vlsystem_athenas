@extends("Admin.template")
@section("conteudo")
<div class="col-12 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Consultas Conta a Pagar </span>
						<div>
							<a href="{{route('admin.venda.create')}}" class="btn btn-azul ml-1 d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
						
						</div>
					</div>
                        
					<form name="busca"  method="get">                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">							  			
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Origem da Conta Receber</label>
                                            <select class="form-campo" name="origem">
                                            	<option value="">Todos</option>
                                            	<option value="compra_id" {{($filtro->origem ?? null) == 'compra_id' ? 'selected' : '' }}>Compra ERP</option>
                                            	<option value="despesa_id"  {{($filtro->origem ?? null) == 'pdvduplicata_id' ? 'selected' : '' }}>Venda PDV</option>
                                            	<option value="fatura_id"  {{($filtro->origem ?? null) == 'loja_pedido_id' ? 'selected' : '' }}>Fatura</option>
                                            	<option value="avulsa"  {{($filtro->origem ?? null) == 'avulsa' ? 'selected' : '' }}>Avulsa</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Descrição</label>
                                            <input type="text" name="descricao"  value="{{$filtro->descricao ?? ''}}"  class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Emissão 01 </label>
                                                <input type="date" name="emissao01" value="{{$filtro->emissao01 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Emissão 02 </label>
                                                <input type="date" name="emissao02" value="{{$filtro->emissao02 ?? ''}}" class="form-campo">
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
                        </div>
                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">	                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Fornecedor</label>
                                            <select class="form-campo" name="fornecedor_id">
                                            <option value="">Selecione</option>
                                            @foreach($fornecedores as $c)
												<option value="{{$c->id}}" {{( $filtro->fornecedor_id ?? null)==$c->id ? 'selected' : null}}>{{$c->razao_social}}</option>
											@endforeach
											</select>
                                        </div>                                        
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Status</label>
                                            <select class="form-campo" name="status_id">
                                            <option value="">Selecione</option>
                                            @foreach($status as $s)
												<option value="{{$s->id}}" {{( $filtro->status_id  ?? null)==$s->id ? 'selected' : null}}>{{$s->status}}</option>
											@endforeach
											</select>
                                        </div>
                                        
                                        
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
                                            	<option value="agrupado_por_vencimento" >Agrupado por Data Vencimento</option>
                                            	<option value="agrupado_por_emissao" >Agrupado por Data Emissão</option>
                                            	<option value="agrupado_por_fornecedor" >Agrupado por Fornecedor</option>
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
                                               
                                               <th align="center" width="10">Id</th>
                                               <th class="text-left" >Data Emissão</th>
                                               <th class="text-left" >Descrição</th>
                                               <th class="text-left" >Fornecedor</th>
                                               <th class="text-left" >Data Vencimento</th>
                                               <th class="text-left" >Valor</th>
                                               <th class="text-left" >Status</th>
                                               <th class="text-left" >Origem</th>
                                            </tr>
                                    </thead>
                                    <tbody> 
                                  @foreach($lista as $l)                                     
                                     <tr>
        								<td align="center">{{$l->id}}</td>
        								<td align="left">{{databr($l->data_emissao)}}</td>
                                        <td align="left">{{$l->descricao}}</td>					
                                        <td align="left">{{$l->fornecedor->razao_social ?? '---'}}</td>							
                                        <td align="left">{{databr($l->data_vencimento)}}</td>
        								 <td align="left">{{$l->valor}}</td>	
        								 <td align="center"><span class="{{ strtolower($l->status->status) }}">{{ $l->status->status }}</span></td>	
        								 <td align="left">{{$l->origem}}</td>
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
