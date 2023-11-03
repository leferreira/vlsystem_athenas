@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
				 <div class="p-2 py-1 bg-title text-light text-uppercase  d-flex justify-content-space-between">
					<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Saldo da Contas: <b class="ml-1 text-vermelho"> </b></span>
						<div class="d-flex">
							<a href="{{route('admin.entrada.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
							<a href="" class="btn btn-laranja ml-1 filtro btn-pequeno ml-1 d-inline-block" title="Filtrar"><i class="fas fa-filter"></i></a>
							<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
						</div>
					</div>
                                          
					 
                </div>
                </div>

		<div class="col-12 mt-3">
            <div class="px-2">
				
                <div class="tabela-responsiva pb-4 table table-bordered">
                
                      <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                           		
                               <tr>
                                  <th align="center">Id</th>
                                  <th align="center">Conta</th>
                                  <th align="center">Entradas</th>
                                  <th align="left">Saídas</th>
                                  <th align="left">Saldo Atual</th>
                                </tr>
                                
                            </thead>
                            
                            <tbody> 
                           
                           @foreach($lista as $m)                                                             
                             <tr>
									<td align="center">{{$m->conta->id}}</td>
									<td align="center">{{$m->conta->descricao}}</td>
									<td align="center">{{$m->todas_entradas}}</td>
									<td align="center">{{$m->todas_saidas}}</td> 	
									<td align="center">{{$m->saldo_atual}}</td>
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