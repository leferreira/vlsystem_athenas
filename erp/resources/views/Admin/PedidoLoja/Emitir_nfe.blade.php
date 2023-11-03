@extends("templates.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">
	

<form method="post" action="{{route('pedidoloja.salvarVenda')}}">
	@csrf
	<input type="hidden" value="{{$pedido->id}}" name="id">
       <div class="col-12 px-4">
          <div class="caixa border radius-4">
					<span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Cliente</span>
                    <div class="tabela-responsiva">
                            <table cellpadding="0" cellspacing="0" class="table-bordered">
                                    <thead>
                                            <tr>
                                                    <th align="center">Cliente</th>
                                                    <th align="left" >CPF</th>
                                                    <th align="center">Telefone</th>
                                                    <th align="center">Email</th>                                                       
                                                    <th align="center">Editar</th>
                                                    
                                            </tr>
                                    </thead>
                                    <tbody>
                                      
                                    <tr>
                                            <td align="center">{{ $pedido->cliente->nome }} 
														{{ $pedido->cliente->sobre_nome }}</td>	
                                            <td align="left">{{$pedido->cliente->cpf}}</td>
                                            <td align="center">{{$pedido->cliente->telefone}}</td>
                                            <td align="center">{{$pedido->cliente->telefone}}</td>                                                                      
                                            <td align="center"><a href="">editar</a></td>	                                            

                                    </tr>
                             	
                                    </tbody>
                            </table>
                          
                    </div>                   
                    </div>
		
                   
            </div>            
            
            
        <div class="col-12 px-4">
      
                    <div class="caixa border radius-4">
					<span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Endereço</span>
                    <div class="tabela-responsiva">
                            <table cellpadding="0" cellspacing="0" class="table-bordered">
                                    <thead>
                                            <tr>
                                                    <th align="center">Rua</th>
                                                    <th align="left" >Número</th>
                                                    <th align="center">Bairro</th>
                                                    <th align="center">Cidade</th>                                                       
                                                    <th align="center">UF</th>
                                                    <th align="center">CEP</th>
                                                    <th align="center">Edit</th>
                                                    <th align="center">Busca Cep</th>
                                                    
                                            </tr>
                                    </thead>
                                    <tbody>
                                 
                                    <tr>
                                            <td align="center">{{ $pedido->endereco->rua }}</td>	
                                            <td align="left">{{$pedido->endereco->numero}}</td>
                                            <td align="center">{{$pedido->endereco->bairro}}</td>
                                            <td align="center">{{$pedido->endereco->cidade}}</td>   
                                            <td align="center">{{$pedido->endereco->uf}}</td> 
                                            <td align="center">{{$pedido->endereco->cep}}</td> 
                                            <td align="center"><a href="">editar</a></td>  
                                            <td align="center"><a href="">Busca</a> </td>                                                                     

                                    </tr>
                          
                                       	
                                    </tbody>
                            </table>
                          
                    </div>
                    
                    
                   
                    
                 
                    </div>
	<div class="rows">									
								<div class="col-6 mb-3">
										<label class="text-label">Natureza de Operação</label>	
										<select class="form-campo" id="natureza" name="natureza">
											@foreach($naturezas as $n)
											<option value="{{$n->id}}">{{$n->natureza}}</option>
											@endforeach
										</select>
								</div>                                    
								<div class="col-6 mb-3">
										<label class="text-label">Transportadora</label>	
										<select class="form-campo" id="transportadora" name="transportadora">
											<option value="">--</option>
											@foreach($transportadoras as $t)
											<option value="{{$t->id}}">{{$t->razao_social}} - {{$t->cnpj_cpf}}</option>
											@endforeach
										</select>
								</div>					
								
														
								<div class="col-3 mb-3">
										<label class="text-label">Tipo</label>	
										<select class="form-campo" id="frete" name="frete">
        									<option value="0">0 - Emitente</option>
        									<option value="1">1 - Destinatário</option>
        									<option value="2">2 - Terceiros</option>
        									<option value="9">9 - Sem Frete</option>
        								</select>
								
								</div>
								
								<div class="col-3 mb-3">
										<label class="text-label">Valor do frete</label>	
										<input type="text" name="valor_frete" value="{{$pedido->valor_frete}}"  class="form-campo">
								</div>
								<div class="col-3 mb-3">
										<label class="text-label">Placa Veiculo</label>	
										<input type="text" name="placa" value=""  class="form-campo">
								</div>
								<div class="col-3 mb-3">
                                       <label class="text-label">UF</label>	
                                       <select class="form-campo" id="uf_placa" name="uf_placa">
        									<option value="">--</option>
        									<option value="AC">AC</option>
        									<option value="AL">AL</option>
        									<option value="AM">AM</option>
        									<option value="AP">AP</option>
        									<option value="BA">BA</option>
        									<option value="CE">CE</option>
        									<option value="DF">DF</option>
        									<option value="ES">ES</option>
        									<option value="GO">GO</option>
        									<option value="MA">MA</option>
        									<option value="MG">MG</option>
        									<option value="MS">MS</option>
        									<option value="MT">MT</option>
        									<option value="PA">PA</option>
        									<option value="PB">PB</option>
        									<option value="PE">PE</option>
        									<option value="PI">PI</option>
        									<option value="PR">PR</option>
        									<option value="RJ">RJ</option>
        									<option value="RN">RN</option>
        									<option value="RS">RS</option>
        									<option value="RO">RO</option>
        									<option value="RR">RR</option>
        									<option value="SC">SC</option>
        									<option value="SE">SE</option>
        									<option value="SP">SP</option>
        									<option value="TO">TO</option>
        								</select>
                               </div>
                               <div class="col-2 mb-3">
                                        <label class="text-label">Qtd Volumes</label>	
                                        <input type="text" name="qtd_volumes" value="1" id="qtd_volumes" class="form-campo">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">Num. Volumes</label>	
                                        <input type="text" name="numeracao_volumes" value="1" id="numeracao_volumes"  class="form-campo">
                                </div>
                               
                                <div class="col-3 mb-3">
                                        <label class="text-label">Espécie</label>	
                                        <input type="text" name="especie" value="" id="especie"  class="form-campo">
                                </div>
                                <div class="col-3 mb-3">
                                        <label class="text-label">Peso liquído</label>	
                                        <input type="text" name="peso_liquido" id="peso_liquido" value="{{number_format($pedido->somaPeso(), 3)}}"  class="form-campo">
                                </div>
                                 <div class="col-2 mb-3">
                                        <label class="text-label">Peso bruto</label>	
                                        <input type="text" name="peso_bruto" value="{{number_format($pedido->somaPeso(), 3)}}" id="peso_bruto"  class="form-campo">
                                </div>
                                
                                <div class="col-3 mb-3">
                                        <label class="text-label">Forma Pagamento</label>	
                                        <input type="text" disabled="disabled"  value="{{$pedido->forma_pagamento}}"   class="form-campo">
                                </div>
                                <?php 
                                if($pedido->status == 1)
								 	$status = "PENDENTE";
								else if($pedido->status == 2)
								    $status ="APROVADO";
								else if ($pedido->status == 3)
									$status ="CANCELANDO";
								
										?>	
                                <div class="col-3 mb-3">
                                        <label class="text-label">Status Pagamento</label>	
                                        <input type="text" disabled="disabled"  value="{{$status}}"   class="form-campo">
                                </div>
                                <div class="col-3 mb-3">
                                        <label class="text-label">Frete</label>	
                                        <input type="text" disabled="disabled"  value="{{ number_format($pedido->valor_frete, 2, ',', '.')}}"   class="form-campo">
                                </div>
                                <div class="col-3 mb-3">
                                        <label class="text-label">Total</label>	
                                        <input type="text" disabled="disabled"  value="{{ number_format($pedido->valor_total, 2, ',', '.')}}"   class="form-campo">
                                </div>
                
			</div>
         <div class="caixa p-2">
                   
                        <div class="caixa-rodape">
                        <button  class="btn btn-verde btn-medio d-inline-block">Salvar Pedido</button>
                                          
                    </div>
                    </div>           
            </div>
</form>
    </div>
</div>


@endsection