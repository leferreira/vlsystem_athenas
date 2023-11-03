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
                                          
					
                      <form method="GET"> 
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        
                                        <div class="col-3 mb-2">	
                                                <label class="text-label d-block text-branco">Conta </label>
                                                <select class="form-campo" name="conta_id">
													@foreach($contas as $c)
        												<option value="{{$c->id}}" >{{$c->descricao}}</option>
        											@endforeach
												</select>
                                        </div> 
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Compensação 01 </label>
                                                <input type="date" name="compensacao01" value="{{$filtro->compensacao01 ?? null}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Compensação 02 </label>
                                                <input type="date" name="compensacao02" value="{{$filtro->compensacao02 ?? null}}" class="form-campo">
                                        </div>                                     
                                        
                                        <div class="col-2 mt-1 pt-1">
                                        	<input type="submit" class="btn btn-roxo text-uppercase width-100" value="filtrar">
                                        	
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
					
				</div>
                <div class="tabela-responsiva pb-4 table table-bordered">
                
                      <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                           		 <tr>
                           		 	<td align="center" colspan="5"><span><small class="text-preto">Saldo Atual</small><span class="h4 fw-700 mb-0 text-azul"><small class="mb-0 d-inline-block h6">R$</small> {{ formataNumeroBr($conta->saldo_atual ?? 0);}}</span></span></td>
                             
									<td align="center"  colspan="2c" ><span><small class="text-preto">Saldo Anterior: <span class="h4 fw-700 mb-0 text-roxo"><small class="mb-0 d-inline-block h6">R$</small>{{formataNumeroBr($conta->saldo_anterior ?? 0);}}</span></span></td>
                                </tr>
                               <tr>
                                  <th align="center">Id</th>
                                  <th align="center">Compensação</th>
                                  <th align="center">Emissão</th>
                                  <th align="left">Documento</th>
                                  <th align="left">Origem</th>
                                  <th align="center">Débito/Crédito</th>
                                  <th align="center">Saldo</th>
                                </tr>                                
                            </thead>
                            
                            <tbody> 
                            @php
                            	$saldo_anterior = $conta->saldo_anterior ?? 0;
                            	$saldo = 0;
                            @endphp
                           @foreach($conta->lista as $m) 
                           @php
                           		if($m->tipo_movimento == "C"){
                           			$saldo +=  $m->valor;
                           			$classe = "text-entrada";                           			
                           		}else{
                           			$saldo -=  $m->valor;
                           			$classe = "text-saida";                         			
								}
                           		 
                           @endphp                                    
                             <tr>
									<td align="center">{{$m->id}}</td>
									<td align="center"><i class="{{($m->tipo_movimento=='C') ? 'ientrada' : 'isaida'}}"></i>{{databr($m->data_compensacao)}}</td>
									<td align="center">{{databr($m->data_emissao)}}</td>
									<td align="center">{{$m->documento}}</td> 	
									<td align="center">{{$m->origem}}</td>
									<td align="center" > <span class="{{$classe}} fw-700"> {{formataNumeroBr($m->valor)}} {{$m->tipo_movimento}} </span></td>

									<td align="center">{{$saldo}}</td>
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
								<span class="tt">Qtde Entradas</span> {{formataNumeroBr($conta->qtde_entrada_filtro)}}
								<span class="tt">Valor Entradas</span>R$ {{formataNumeroBr($conta->soma_entrada_filtro)}}
							</strong>
						</div>
					</div>
				</div>
				<div class="col-3  d-flex">
					<div class="caixa width-100"> 
						<i class="icos far fa-arrow-alt-circle-left text-saida"></i>
						<div class="box">
							<strong class="text-saida">
								<span class="tt">Qtde Saídas</span> {{formataNumeroBr($conta->qtde_saida_filtro)}}
								<span class="tt">Valor Saídas</span>R$ {{formataNumeroBr($conta->soma_saida_filtro)}}
							</strong>
						</div>
					</div>
				</div>
				<div class="col-3  d-flex">
					<div class="caixa width-100">
						<i class="icos fas fa-dollar-sign text-estoque "></i>
						<div class="box">							
							<strong class="text-estoque">
								<span class="tt">Todas Entradas</span>R$ {{formataNumeroBr($conta->soma_entradas)}}
								<span class="tt">Todas Saídas</span>R$ {{formataNumeroBr($conta->soma_saidas)}}
							</strong>
						</div>
					</div>
				</div>
				
				<div class="col-3 d-flex">
					<div class="caixa width-100">
						<i class="icos far fa-share-square text-estoque alt"></i>
						<div class="box">							
							<strong class="text-estoque">
								<span class="tt">Saldo Atual</span> {{formataNumeroBr($conta->saldo_atual)}}
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