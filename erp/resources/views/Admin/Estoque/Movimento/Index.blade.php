@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	

                <div class="col-12">
                <div class="caixa">
				 <div class="p-2 py-1 bg-title text-light text-uppercase  d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Historico de movimentação: <b class="ml-1 text-vermelho"> </b></span>
						<div class="d-flex">
							<a href="{{route('admin.entrada.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
							<a href="" class="btn btn-laranja ml-1 filtro btn-pequeno ml-1 d-inline-block" title="Filtrar"><i class="fas fa-filter"></i></a>
							<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
						</div>
					</div>
                      <form name="busca" action="{{route('admin.movimento.index')}}" method="get">                         
                        <div class="px-2 pt-2">
							  <div class="bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
							 
                                        <div class="col mb-2">	
                                            <label class="text-label d-block text-branco">Data 1 </label>
                                            <input type="date" name="data1" value="{{$filtro->data1 ?? null}}" class="form-campo">
                                        </div>
                                        <div class="col mb-2">	
                                             <label class="text-label d-block text-branco">Data 2 </label>
                                             <input type="date" name="data2" value="{{$filtro->data2 ?? null}}" class="form-campo">
                                        </div>
                                        <div class="col-3 mb-2">	
                                                <label class="text-label d-block text-branco">Produto {{ $filtro->origem_movimento }} </label>
                                                <select class="form-campo" name="produto_id">
													@foreach($produtos as $p)
        												<option value="{{$p->id}}" {{( $filtro->produto_id ?? null)==$p->id ? 'selected' : null}}>{{$p->nome}}</option>
        											@endforeach
												</select>
                                        </div>
                                        <div class="col-2 mb-2">	
                                                <label class="text-label d-block text-branco">Origem do Movimento</label>
                                                <select class="form-campo" name="origem_movimento">
                                                	<option value="">Selecione</option>
													<option value="venda_id" {{($filtro->origem_movimento ?? null) == 'venda_id' ? 'selected' : null}}>Venda</option>
													<option value="compra_id" {{($filtro->origem_movimento ?? null) == 'compra_id' ? 'selected' : null}}>Compra</option>
													<option value="pedido_id" {{($filtro->origem_movimento ?? null) == 'pedido_id' ? 'selected' : null}}>Pedido</option>
													<option value="entrada_avulsa_id" {{($filtro->origem_movimento ?? null) == 'entrada_avulsa_id' ? 'selected' : null}}>Entrada Avulsa</option>
													<option value="saida_avulsa_id" {{($filtro->origem_movimento ?? null) == 'saida_avulsa_id' ? 'selected' : null}}>Saída Avulsa</option>
													<option value="estorno" {{($filtro->origem_movimento ?? null) == 'estorno' ? 'selected' : null}}>Estorno </option>
												</select>
                                        </div>
                                        <div class="col-2 mb-2">	
                                                <label class="text-label d-block text-branco">Entrada e saída </label>
                                                <select class="form-campo" name="ent_sai">
                                                	<option value="">Selecione</option>
													<option value="E" {{($filtro->ent_sai ?? null) == 'E' ? 'selected' : null}}>Entrada</option>
													<option value="S" {{($filtro->ent_sai ?? null) == 'S' ? 'selected' : null}}>Saída</option>
												</select>
                                        </div>
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="Pesquisar" class="btn btn-roxo text-uppercase width-100">
                                        </div>
                                </div>
                                </div>
                        </div>
                    </form>
                   
                </div>
                </div>

		<div class="col-12 mt-3">
            <div class="px-2">
				<div class="d-flex mb-2 justify-content-space-between center-middle">
					<div class="d-flex radius-4 col-2 state-movi">
						<span><i class="ientrada"><i class="fas fa-arrow-right"></i></i>  Entrada</span>
						<span class=""><i class="isaida"><i class="fas fa-arrow-left"></i></i> Saída</span>
					</div>
					<div>
						<a href="{{route('admin.entrada.index')}}" class="btn btn-verde btn-medio d-inline-block">Entrada Avulsa</a>
						<a href="{{route('admin.saida.index')}}" class="btn btn-vermelho btn-medio d-inline-block">Saída Avulsa</a>
					</div>
				</div>
                <div class="tabela-responsiva pb-4 table table-bordered">
                      <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                               <tr>
                                  <th align="center">Id</th>
                                  <th align="center">Data</th>
                                  <th align="left">Produto</th>
                                  <th align="center">Valor</th>
                                  <th align="center">qtde</th>
                                  <th align="center">Subtotal</th>
                                  <th align="center">Tipo</th>
                                  <th align="center">Descrição</th>
                                </tr>
                            </thead>
                            <tbody> 
                           @foreach($lista as $m)                                     
                             <tr>
									<td align="center">{{$m->id}}</td>
									<td align="center"><i class="{{($m->ent_sai=='E') ? 'ientrada' : 'isaida'}}"></i>{{databr($m->data_movimento)}}</td>
									<td align="center">{{$m->produto->nome}}</td> 
									<td align="center">{{$m->valor_movimento}}</td>											
									<td align="center">{{$m->qtde_movimento}}</td>											
									<td align="center">{{$m->subtotal_movimento}}</td>											
									<td align="center">{{$m->tipoMovimento->tipo_movimento}}</td>											
									<td align="center">{{$m->descricao}}</td>
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
	function verEstoque(){
		var produto_id = $("#produto_id").val(); 	
    	giraGira();
    	location.href = base_url + "admin/movimento/" + produto_id;
	}
</script>
@endsection