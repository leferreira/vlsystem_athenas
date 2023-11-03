@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">

	<div class="col-12">
		 <div class="caixa">
           <span class="p-2 bg-title text-light text-uppercase  text-branco justify-content-space-between d-flex">
				<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Confirmar Recebimento da Conta: <b class="text-vermelho"> {{$contareceber->id}}</b> </span>
				<div class="d-flex">
					@if(isset($contareceber->venda_id))
						<a href="{{route('admin.venda.financeiro',$contareceber->venda_id )}}" class="btn btn-azul btn-pequeno ml-1" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
					@else
						<a href="{{route('admin.contareceber.index')}}" class="btn btn-azul btn-pequeno ml-1" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
					@endif
					<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
				</div>
			</div>
        
        
        <div class="col-12 mb-4">
            <div class="caixa border radius-4">
            <span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Dados da Conta a Receber: {{ $contareceber->id}}</span>

            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">
					
					<div class="col-6 mb-3">
						<label class="text-label">Descricao</label>
						 <input type="text" name="descricao" readonly="readonly" value="{{ $contareceber->descricao }}" id="descricao"  class="form-campo">												
					</div>
					<div class="col-6">	
                        <label class="text-label d-block">Cliente</label>
                        <input type="text" name="cliente" readonly="readonly" value="{{ $contareceber->cliente->nome_razao_social }}"   class="form-campo">												

                    </div>
                  
                                        
					<div class="col-3 mb-3">
						<label class="text-label">Data Emissão</label>
						 <input type="date" name="data_emissao" readonly="readonly" value="{{ $contareceber->data_emissao }}" id="data_emissao" readonly class="form-campo">												
					</div>	
					
					<div class="col-2 mb-3">
						<label class="text-label">Data Vencimento</label>
						 <input type="date" name="data_vencimento" readonly="readonly" value="{{ $contareceber->data_vencimento }}"  readonly id="data_vencimento"  class="form-campo">												
					</div>						
					<div class="col-2 mb-3">
						<label class="text-label">Valor</label>
						<input type="text" name="valor" id="valor_original" readonly="readonly" readonly="readonly" value="{{ $contareceber->valor }}"    class="form-campo">												
					</div>
					<div class="col-2 mb-3">
						<label class="text-label">Total Recedito</label>
						<input type="text" name="valor" id="valor_original" readonly="readonly" readonly="readonly" value="{{ $contareceber->total_recebido }}"    class="form-campo">												
					</div>
					<div class="col-2 mb-3">
						<label class="text-label">Total Restante</label>
						<input type="text" name="valor" id="valor_original" readonly="readonly" readonly="readonly" value="{{ $contareceber->total_restante }}"    class="form-campo">												
					</div>
									
					   
					</div>
				</div>          
			</div>
        </div>
	</div>

	  <div class="col-12 mb-3">
            <div class="caixa border radius-4">
            <span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Pagamentos</span>
            <div class="tabela-responsiva">
               <table cellpadding="0" cellspacing="0" class="table-bordered">
                   <thead>
                      <tr>
                        <th align="center">ID</th>
                        <th align="left">Data</th>
                        <th align="left">Descrição</th>
                        <th align="center">Valor Original</th>
                        <th align="center">Juros</th>                                                    
                        <th align="center">Multa</th>    
                        <th align="center">Desconto</th>
                        <th align="center">Valor Recebido</th>                           
                      </tr>
                   </thead>
                   <tbody>
                   
                   <?php 
                        $soma_juros     = 0;
                        $soma_multa     = 0;
                        $soma_desconto  = 0;
                        $soma_recebido  = 0;
                   ?>
                   @foreach($pagamentos as $i) 
                   <?php 
                        $soma_juros     += $i->juros;
                        $soma_multa     += $i->multa;
                        $soma_desconto  += $i->desconto;
                        $soma_recebido  += $i->valor_recebido;
                   ?>
                                                                          
                       <tr>
                           <td align="center">{{ $i->id }} </td>
                           <td align="left">{{ databr($i->data_recebimento)  }}</td>	
                           <td align="left">{{ $i->descricao_recebimento  }}</td>
                           <td align="center">R$ {{ $i->valor_original }}</td>
                           <td align="center">{{ $i->juros }}</td>  
                           <td align="center">{{ $i->multa }}</td>  
                           <td align="center">{{ $i->desconto }}</td>  
                           <td align="center">R$ {{ $i->valor_recebido }}</td>
                        </tr>
                  @endforeach                                      
                        <tr>
                           <td align="left" ></td> 
                           <td align="left" ></td> 
                           <td align="left" ></td> 
                           <td align="left" ></td> 
                           <td align="center" >{{ formataNumeroBr($soma_juros) }}</td>  
                           <td align="center">{{ formataNumeroBr($soma_multa) }}</td>  
                           <td align="center">{{ formataNumeroBr($soma_desconto) }}</td>  
                           <td align="center">R$ {{ formataNumeroBr($soma_recebido) }}</td>
                        </tr>
                        	
                    </tbody>
               </table>
                  
            </div>
                    
             
            </div>
    </div>
 
 
</div>

@endsection