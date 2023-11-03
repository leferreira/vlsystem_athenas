@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">

	<div class="col-12">
	<?php 
	  // $this->verErro();
	?>
    <form action="{{ route('admin.contapagar.pagar')}}" method="post">
     @csrf
        
        
        <div class="col-12 mb-4">
            <div class="caixa border radius-4">
            <span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Dados da Parcela: {{ $contapagar->id}}</span>

            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">
					
					<div class="col-6 mb-3">
						<label class="text-label">Nome da Despesa</label>
						 <input type="text" name="numero_despesa" value="{{ $contapagar->numero_despesa }}" id="numero_despesa"  class="form-campo">												
					</div>
					<div class="col-6">	
                        <label class="text-label d-block">Fornecedor</label>
                        <select id="fornecedor_id" name="fornecedor" class="form-campo fornecedor">
							<option value="--">Selecione o fornecedor</option>
							@foreach($fornecedores as $f)
							<option value="{{$f->id}}">{{$f->razao_social}} ({{$f->cnpj}})</option>
							@endforeach
						</select>
                    </div>
                    
                     <div class="col-4">	
                        <label class="text-label d-block">Centro de Custo</label>
                        <select id="centro_custo_id" name="centro_custo" class="form-campo ">
							<option value="--">Selecione o fornecedor</option>
							@foreach($centro_custos as $c)
							<option value="{{$c->id}}">{{$c->nome}} </option>
							@endforeach
						</select>
                    </div>
                                        
					<div class="col-3 mb-3">
						<label class="text-label">Data Emissão</label>
						 <input type="date" name="data_emissao" value="{{ $contapagar->data_emissao }}" id="data_emissao" readonly class="form-campo">												
					</div>	
					
					<div class="col-2 mb-3">
						<label class="text-label">Data Vencimento</label>
						 <input type="date" name="data_vencimento" value="{{ $contapagar->data_vencimento }}"  readonly id="data_vencimento"  class="form-campo">												
					</div>						
					<div class="col-2 mb-3">
						<label class="text-label">Valor</label>
						<input type="text" name="valor_original" id="valor_original" readonly="readonly" value="{{ $contapagar->valor_original }}"    class="form-campo">												
					</div>
					
					                
										
					   
					</div>
				</div>          
			</div>
        </div>
	</div>
	<div class="col-12 mb-4">
            <div class="caixa border radius-4">
            <span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Dados do Pagamento</span>

            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">
					<div class="col-2 mb-3">
						<label class="text-label">Data Pagamento</label>
						 <input type="date" name="data_pagamento" value="{{ hoje() }}" id="data_pagamento" readonly class="form-campo">												
					</div>
										
					<div class="col-4 mb-3">
						<label class="text-label">Forma de Pagamento</label>
						<select class="form-campo" name="id_forma_pagto" >	
							<option value="">Selecione uma Opção</option>						
							@foreach($formaPagto as $f)
							     <option value='{{ $f->id}}'>{{ $f->forma_pagto }}</option>
							@endforeach		
						</select>
					</div>			
											
						
					<div class="col-3 mb-3">
						<label class="text-label">Valor a Pagar</label>
						<input type="text" name="valor_a_pagar" id="valor_a_pagar" value="{{ $contapagar->valor_a_pagar }}"    class="form-campo">												
					</div>
					<div class="col-3 mb-3">
						<label class="text-label">Saldo Restante</label>
						<input type="text" name="saldo_restante" id="saldo_restante" value="{{ $contapagar->saldo_restante }}"    class="form-campo">												
					</div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Juros</label>
						<input type="text" name="juros" value="0" id="juros" onblur="atualizaValor()" class="form-campo">												
					</div>
					<div class="col-2 mb-3">
						<label class="text-label">Multa</label>
						<input type="text" name="multa" value="0" id="multa" onblur="atualizaValor()" class="form-campo">												
					</div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Desconto</label>
						<input type="text" name="desconto" value="0" id="desconto" onblur="atualizaValor()"  class="form-campo">												
					</div>					 
					
					<div class="col-3 mb-3">
						<label class="text-label">Valor Pago</label>
						 <input type="text" name="valor_pago" id="valor_pago" value="{{ $contapagar->saldo_devedor }}"  readonly class="form-campo">												
					</div>                
					
					
					 <div class="caixa p-2">                   
                <div class="caixa-rodape">
					<input type="submit" value="Salvar" class="btn btn-verde btn-medio d-inline-block" />                   
				</div>
            </div>							
					   
					</div>
				</div>          
			</div>
        </div>
	</div>
	
    <div class="col-12 mb-3">
            <div class="caixa border radius-4">
            <span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Pagamentos Realizados</span>
            <div class="tabela-responsiva">
               <table cellpadding="0" cellspacing="0" class="table-bordered">
                   <thead>
                      <tr>
                        <th align="center">ID</th>
                        <th align="center">Forma Pagto</th>
                        <th align="left">Data</th>
                        <th align="center">Valor</th>
                                                      
                      </tr>
                   </thead>
                   <tbody>  
                  @foreach($pagamentos as $p){?>                                                      
                       <tr>
                           <td align="center">{{ $p->id_parcela_pagamento }} </td>
                           <td align="center">{{ $p->id_forma_pagto }}</td>	
                           <td align="left">{{ databr($p->data_pagamento) }}</td>
                           <td align="center">R$ {{ $p->valor_pago }}</td>
                            
                        </tr>
                   @endforeach	
                    </tbody>
               </table>
                  
            </div>
                    
            
            </div>
    </div>
   </form>
    </div>
</div>

<script>

function tipoBaixa(){
	var tipo = $("#id_baixa").val();
	var valor_a_pagar = $("#valor_a_pagar").val();
	if(tipo=='T'){
		$("#valor_pago").val(valor_a_pagar);
		$("#valor_pago").attr("readonly", true);
		
	}else{
		$("#valor_pago").val(0);
		$("#valor_pago").attr("readonly", false);
	}
}

function atualizaValor(){
	var saldo_devedor = $("#saldo_devedor").val();
	var juros 	      = $("#juros").val();
	var multa 		  = $("#multa").val();
	var desconto 	  = $("#desconto").val();
	console.log(juros);
	var valor_a_pagar = parseFloat(saldo_devedor) + parseFloat(juros) + parseFloat(multa) - parseFloat(desconto);
	console.log(valor_a_pagar);
	$("#valor_a_pagar").val(valor_a_pagar);
	tipoBaixa();
}
</script>
@endsection