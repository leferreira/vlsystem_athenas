@extends("templates.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">
	<div class="col-12">
 <form action="{{route('pedido.faturarPedido')}}" method="post">
 @csrf     
    <div class="rows">	
        <div class="col-12">
            <div class="caixa">
				<div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle"><i class="fas fa-search mr-1"></i> Faturar Pedido: {{ $pedido->id_pedido}} </span>			
                    <a href="{{ route('financeiro.lista_faturar_pedido')}}" class="btn btn-verde btn-pequeno float-right "><i class="fas fa-arrow-left mb-0"></i> Voltar</a>
                </div>
                </div>
                    <div class="py-4 px-4">
                        <div class="rows text-escuro">										
							<div class="col-3 px-1 d-flex">
									<div class="px-3 py-4 border radius-4 width-100">
											<i class="fas fa-users pequeno-font float-left mr-1 text-padrao"></i>
											<small>Nome do Cliente</small>
											<h4 style="line-height:1rem">{{ $pedido->contato->nome }} </h4>
									</div>
							</div>
                            <div class="col d-flex">
                                 <div class="px-3 py-4 border radius-4 width-100">
                                         <i class="fas fa-calendar-alt pequeno-font float-left mr-1 text-padrao"></i>
                                         <small>Data Emissão</small>
                                         <h4>{{ databr($pedido->data_pedido) }} </h4>
                                 </div>
                            </div>
                            <div class="col d-flex">	
                                 <div class="px-3 py-4 border radius-4 width-100">
                                         <i class="far fa-clock pequeno-font float-left mr-1 text-padrao"></i>
                                         <small>Hora Pedido</small>
                                         <h4>{{ $pedido->hora_pedido }} </h4>
                                 </div>
                            </div>
                            <div class="col d-flex">
                                 <div class="px-3 py-4 border radius-4 width-100">
                                         <i class="fab fa-bitcoin pequeno-font float-left mr-1 text-padrao"></i>
                                         <small>Total</small>
                                         <h4>R$ {{ $pedido->total }} </h4>
                                 </div>
                            </div>
                            <div class="col d-flex">
                                 <div class="px-3 py-4 border radius-4 width-100">
										<i class="fas fa-map-marker-alt  pequeno-font float-left mr-1 text-padrao"></i>
                                         <small>Status</small>
                                         <h4>{{ $pedido->status->status_pedido }} </h4>
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
					<div class="col-4 mb-3">
						<label class="text-label">Documento Origem</label>
						<select class="form-campo" name="id_documento_origem">
						
						 @foreach($documentos as $doc){
							<option value='{{ $doc->id}}'>{{$doc->documento_origem}}</option>
						 @endforeach 
						</select>
					</div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Núm. Documento</label>
						<input type="number" name="numero_documento" id="numero_documento" value="100" class="form-campo">
					</div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Intervalo Parcelas</label>
						<select class="form-campo" name="intervalo_entre_parcela" ">
							<option value="0">&#192; Vista</option>
							<option value="7"> 07 Dias</option>
							<option value="15">15 Dias</option>
							<option value="30" selected>30 Dias</option>
							<option value="60">60 Dias</option>
							<option value="90">90 Dias</option>
							<option value="180">180 Dias</option>
							<option value="360">360 Dias</option>

						</select>
					</div>
					<div class="col-2 mb-3">
						<label class="text-label">Qtde Parcela</label>
						<input type="number" min="1" name="qtde_parcela" id="qtde_parcela"  value="1" class="form-campo">
					</div>					
					
					<div class="col-2 mb-3">
						<label class="text-label">Valor Total</label>
						<input type="text" name="valor_total" value="{{ $pedido->total }}" readonly id="valor_total"  class="form-campo">												
					</div>
					<div class="col-2 mb-3">
						<label class="text-label">Juros</label>
						<input type="text" name="juros"  id="juros" value="0" class="form-campo">												
					</div>
					<div class="col-2 mb-3">
						<label class="text-label">Desconto</label>
						<input type="text" name="desconto" value="0"    class="form-campo">												
					</div>
					<div class="col-2 mb-3">
						<label class="text-label">Multa</label>
						<input type="text" name="multa" value="0"    class="form-campo">												
					</div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Valor a Pagar</label>
						 <input type="text" name="valor_a_receber" value="{{ $pedido->total}}" readonly id="valor_a_receber"  class="form-campo">												
					</div>                
					
					<div class="col-2 mb-3">
						<label class="text-label">Data Lançamento</label>
						 <input type="date" name="data_lancamento" value="{{ hoje() }}"  id="data_lancamento"  class="form-campo">												
					</div>
					
					<div class="col-2 mb-3">
						<label class="text-label">Primeiro Vencimento</label>
						 <input type="date" name="primeiro_vencimento" id="primeiro_vencimento"  class="form-campo">												
					</div>	
												
					   
					</div>
				</div>          
			</div>
			<div class="caixa p-2">                   
                <div class="caixa-rodape">
					<input type="hidden" value="{{ $pedido->id}}" name="id_pedido" />
					<input type="hidden" value="{{$pedido->id_contato }}" name="id_cliente" />
					<input type="submit" value="Fazer Lançamento" class="btn btn-verde btn-medio d-inline-block" />                   
				</div>
            </div>
        </div>
	</div>
    <div class="col-12 mb-3">
            <div class="caixa border radius-4">
            <span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Itens do Pedido</span>
            <div class="tabela-responsiva">
               <table cellpadding="0" cellspacing="0" class="table-bordered">
                   <thead>
                      <tr>
                        <th align="center">ID</th>
                        <th align="left" width="380">Produto</th>
                        <th align="center">Preço</th>
                        <th align="center">Qtde</th>                                                    
                        <th align="center">Subtotal</th>                               
                      </tr>
                   </thead>
                   <tbody>
                   @foreach($itens as $i)                                                        
                       <tr>
                           <td align="center">{{ $i->id_item }} </td>	
                           <td align="left">{{ $i->produto->produto  }}</td>
                           <td align="center">R$ {{ $i->valor }}</td>
                           <td align="center">{{ $i->qtde }}</td>  
                           <td align="center">R$ {{ $i->subtotal }}</td>
                        </tr>
                  @endforeach                                      
                       
                        <tr>
                            <td align="right" colspan="9" ><b>Total:</b> <span class="text-verde minimo-font">R$ {{ $pedido->total }}</span></td>
                        </tr>	
                    </tbody>
               </table>
                  
            </div>
                    
             
            </div>
    </div>
    </form>
    </div>
   
</div>
</div>
@endsection