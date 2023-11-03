@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
				 <div class="p-2 py-1 bg-title text-light text-uppercase  d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Historico de movimentação: <b class="ml-1 text-vermelho"> {{$grade->descricao}}</b></span>
						<div class="d-flex">
							<a href="{{route('admin.estoque.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
							<a href="" class="btn btn-laranja ml-1 filtro btn-pequeno ml-1 d-inline-block" title="Filtrar"><i class="fas fa-filter"></i></a>
							<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
						</div>
					</div>                                       
					   
                   
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
                                  <th align="center">Tipo</th>
                                  <th align="center">Descrição</th>
                                  <th align="center">qtde</th>
                                </tr>
                            </thead>
                            <tbody> 
                           @foreach($lista as $m)                                     
                             <tr>
									<td align="center">{{$m->id}}</td>
									<td align="center"><i class="{{($m->ent_sai=='E') ? 'ientrada' : 'isaida'}}"></i>{{databr($m->data_movimento)}}</td>
									<td align="center">{{$m->grade->descricao}}</td> 																				
									<td align="center">{{$m->tipoMovimento->tipo_movimento}}</td>											
									<td align="center">{{$m->descricao}}</td>
									<td align="center">{{moedaBr($m->qtde_movimento)}}</td>
							</tr>                                     
                        @endforeach        
                                                          
                                            						
                        </tbody>
                                </table>
								
                        </div>

                        </div>

                </div>

        </div>
		
				
            <div class="px-2 mt-3 pb-5 historico-movimentacao">
            <div class="rows">
				<div class="col-3 d-flex">
					<div class="caixa width-100"> 
						<i class="icos far fa-arrow-alt-circle-right text-entrada"></i>
						<div class="box">
							<strong class="text-entrada">
								<span class="tt">Qtde Entradas</span>{{moedaBr($qtde_entrada)}}
							</strong>
						</div>
					</div>
				</div>
				<div class="col-3  d-flex">
					<div class="caixa width-100"> 
						<i class="icos far fa-arrow-alt-circle-left text-saida"></i>
						<div class="box">
							<strong class="text-saida">
								<span class="tt">Qtde Saídas</span>{{moedaBr($qtde_saida)}}
							</strong>
						</div>
					</div>
				</div>
			
				
				<div class="col-3 d-flex">
					<div class="caixa width-100">
						<i class="icos far fa-share-square text-estoque alt"></i>
						<div class="box">							
							<strong class="text-estoque">
								<span class="tt">Estoque Atual</span>{{isset($grade->estoque) ? moedaBr($grade->estoque) : null}}
							</strong>
						</div>
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