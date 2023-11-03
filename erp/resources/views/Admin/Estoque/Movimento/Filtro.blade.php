@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
				 <div class="p-2 py-1 bg-title text-light text-uppercase  d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Historico do Produto</span>
						<div class="d-flex">
							<a href="{{route('admin.entrada.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
							<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
						</div>
					</div>
				                        
					<form name="busca" action="{{route('admin.movimento.filtro')}}" method="GET">
                    <div class="rows">    
                        <div class="col-8 m-auto px-2 pt-4">
							  <div class="mt-2 p-4 border radius-4">
							  <div class="rows">
							  			<div class="col-6 mb-2">	
                                                <label class="text-label d-block ">Produto </label>
                                                <select class="form-campo" name="produto_id">
    												@foreach($produtos as $p)
    													<option value="{{$p->id}}">{{$p->nome}}</option>
    												@endforeach
												</select>
                                        </div>
                                        
                                        <div class="col-3 mb-2">	
                                                <label class="text-label d-block ">Data 1 </label>
                                                <input type="date" name="data1" value="" class="form-campo">
                                        </div>
                                        <div class="col-3 mb-2">	
                                                <label class="text-label d-block ">Data 2 </label>
                                                <input type="date" name="data2" value="" class="form-campo">
                                        </div>
                                        
                                        <div class="col-4 mb-2">	
                                                <label class="text-label d-block ">Entrada ou Saída </label>
                                                <select class="form-campo" name="entrada_saida">
                                                <option value="">Selecione</option>
													<option value="E">Entrada</option>
													<option value="S">Saída</option>
												</select>
                                        </div>
                                        <div class="col-4 mb-2">	
                                                <label class="text-label d-block ">Tipo de movimentação </label>
                                                <select class="form-campo" name="tipo_movimento_id">
                                                <option value="">Selecione</option>
													<option value="E">Entrada</option>
													<option value="S">Saída</option>
												</select>
                                        </div>
                                        
                                        <div class="col-4 mb-2">	
                                                <label class="text-label d-block ">Origem do Movimento</label>
                                                <select class="form-campo" name="origem_movimento">
                                                <option value="">Selecione</option>
                                               	 	<option value="venda_id">Venda</option>
													<option value="compra_id">Compra</option>
													<option value="pedido_id">Pedido</option>
													<option value="entrada_avulsa_id">Entrada Avulsa</option>
													<option value="saida_avulsa_id">Saída Avulsa</option>
												</select>
                                        </div>
                                        
                                        <div class="col-12 mt-1 text-center">
                                                <input type="submit" value="Pesquisar" class="btn btn-roxo text-uppercase m-auto">
                                        </div>
                                </div>
                                </div>
                        </div>
					</div>
                    </form>
                </div>
                </div>
        </div>           
</div>

@endsection