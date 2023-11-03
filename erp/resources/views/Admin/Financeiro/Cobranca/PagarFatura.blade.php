@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-check"></i> Confirmar pagamento</span>
	<div class="d-flex">
		<a href="{{route('admin.fatura.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	</div>
</span>
<div class="rows">

	<div class="col-12 mt-4">
	
        <div class="col-12 mb-4">
            <fieldset class="caixa border radius-4">
            <legend><i class="far fa-list-alt"></i> Dados da Conta a Pagar: <b class="text-vermelho">{{ $fatura->id}}</b></legend>

            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">
					
					<div class="col-6 mb-3">
						<label class="text-label">Descricao</label>
						 <input type="text" name="descricao" value="{{ $fatura->descricao }}" id="descricao"  class="form-campo">												
					</div>
					<div class="col-6">	
                        <label class="text-label d-block">Observação</label>
                        <input type="text" name="observacao" value="{{ $fatura->observacao }}"   class="form-campo">												

                    </div>
                    
                                        
					<div class="col-4 mb-3">
						<label class="text-label">Data Emissão</label>
						 <input type="date" name="data_emissao" value="{{ $fatura->data_emissao }}" id="data_emissao" readonly class="form-campo">												
					</div>	
					
					<div class="col-4 mb-3">
						<label class="text-label">Data Vencimento</label>
						 <input type="date" name="data_vencimento" value="{{ $fatura->data_vencimento }}"  readonly id="data_vencimento"  class="form-campo">												
					</div>						
					<div class="col-4 mb-3">
						<label class="text-label">Valor</label>
						<input type="text" name="valor" id="valor_original" readonly="readonly" value="{{ $fatura->valor }}"    class="form-campo">												
					</div>
					
					                
										
					   
					</div>
				</div>          
			</div>
			
			 <div class="conteudo">
			 
			 
		<div class="p-3 px-4 mb-3">
		<div class="rows mt-2">
			<div class="col d-flex mb-3" >
				<a href="{{route('admin.fatura.pix', $fatura->id)}}"  class="card pagamento width-100 p-2">
					<div class="d-flex py-3">
						<img src="{{asset('assets/admin/img/logo-pix.svg')}}" width="100">
						<div class="ml-3">
						<span class="h5 mb-1 d-block fw-700" style="color:#222;font-weight:700">Pagamento via pix</span>
						<small class="mb-3 d-block text-escuro">Clique aqui para pagamento via pix</small>
						</div>
					</div>
					
						<span class="btn btn-verde btn-medio">Pagar</span>
				</a>
			</div>
			
			<div class="col d-flex mb-3">
				<a href="{{route('admin.fatura.cartao', $fatura->id)}}" class="card pagamento width-100 p-2">
					<div class="d-flex py-3">
						<img src="{{asset('assets/admin/img/logo-cartao.svg')}}" width="100">
						<div class="ml-3">
						<span class="h5 mb-1 d-block fw-700" style="color:#222;font-weight:700">Pagamento por cartão</span>
						<small class="mb-3 d-block text-escuro">Clique aqui para pagamento via cartão de crédito</small>
						</div>
					</div>					
						<span class="btn btn-azul btn-medio">pagar com cartão</span>
				</a>
			</div>
			<div class="col d-flex mb-3">
				<a href="{{route('admin.fatura.boleto', $fatura->id)}}" class="card pagamento width-100 p-2">
					<div class="d-flex py-3">
						<img src="{{asset('assets/admin/img/logo-boleto.svg')}}" width="100">
						<div class="ml-3">
						<span class="h5 mb-1 d-block fw-700" style="color:#222;font-weight:700">Pagamento por boleto</span>
						<small class="mb-3 d-block text-escuro">Clique aqui para pagamento via boleto bancário</small>
						</div>
					</div>
					
						<span class="btn btn-roxo btn-medio">pagar com boleto</span>
				</a>
			</div>
			<div class="col d-flex mb-3">
				<a href="{{route('admin.fatura.comprovante', $fatura->id)}}" class="card pagamento width-100 p-2">
					<div class="d-flex py-3">
						<img src="{{asset('assets/admin/img/logo-comprovante.svg')}}" width="100">
						<div class="ml-3">
						<span class="h5 mb-1 d-block fw-700" style="color:#222;font-weight:700">Enviar comprovante</span>
						<small class="mb-3 d-block text-escuro">Clique aqui para pagamento via Transferência</small>
						</div>
					</div>
					
					<span class="width-100 btn btn-roxo btn-medio">Enviar comprovante</span>
				</a>
			</div>
		</div>
		</div>
		
		
	</div>
	
        </div>
	</div>

<div id="dadosPix" class="window form">					
		<div class="card pag1">
		<span class="tacord"><i class="ico ipagseguro"></i><span>Pagamento pelo pix</span></span>
		<div class="p-3 px-md">					
			<p  class="mb-2 pt-3">Preencha os campus com os dados do titular</p>
				<div class="rows">								
					<div class="col-6 mb-3">
						<strong class="text-label">Nome:</strong>
						<input type="text" name="payerFirstName" id="payerFirstName" value="{{ primeiroNome($empresa->razao_social) ?? null }}" class="form-campo"> 
					</div>
					<div class="col-6 mb-3">
						<strong class="text-label">Sobrenome:</strong>
						<input type="text" name="payerLastName" id="payerLastName" value="{{ ultimoNome($empresa->razao_social) ?? null }}" class="form-campo"> 
					</div>
					
					<div class="col-3 mb-3">
						<strong class="text-label">CPF</strong>
						<input type="text" name="docNumber" id="docNumber" value="{{ $empresa->cpf_cnpj ?? null }}" class="form-campo"> 
					</div>
					<div class="col-6 mb-3">
						<strong class="text-label">Email:</strong>
						<input type="text" name="payerEmail" id="payerEmail" value="{{ $empresa->email ?? null }}" class="form-campo"> 
					</div>
					<div class="col-3 m-auto text-center ">										
						
					</div>	
			
		</div>
		</div>
		
		<div class="tfooter end">
			<input type="hidden" name="transactionAmount" id="transactionAmount" >		
			<input type="hidden" name="productDescription" id="productDescription" value="Nome do Produto">				
			<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho fechar">Fechar</a>
			<a href="javascript:;" onclick="pagarComPix()"  class="btn btn-verde">Finalizar Compra</a>					
		</div>
		</div>
	</div>
	
<!-- Modal cartão-->
<div class="window form" id="cartao">
	<div class="card pag1">
		<div class="p-3 px-md">
				<p class="text-uppercase pt-3 text-center h5">Preencha os campus com os dados do titular do cartão</p>
				<div class="rows mt-4">
					<div class="col-4 dados-cartao alt">
						<div class="cartao">
								<div class="cart alt"><!-- CARTÃO DE FRENTE-->
									<i class="chip"></i>
									<i class="mostrar-cart" v-show="dadosMostrar.bandeira_cartao"><img :src="dadosMostrar.bandeira_cartao"></i>
									<div class="rows mt-4 pt-1">
										<div class="col-12 mb-3">
											<span class="text-label">Nome</span>
											<span class="form-campo d-block">@{{dadosMostrar.titular}}</span>
										</div>
										<div class="col-8 mb-3">
											<span class="text-label">Número do cartão</span>
											<span class="form-campo d-block">@{{dadosMostrar.numero}}</span>
										</div>
										<div class="col-4 mb-3">
											<span class="text-label">Validade</span>
											<span class="form-campo d-block">@{{dadosMostrar.validade}}</span>
										</div>
									</div>
								</div>

								<div class="cart"><!-- CARTÃO DE COSTA-->
									<i class="tarja"></i>
									<div class="rows pt-5 mt-3 justify-text-end">
										<div class="col-4 mb-2">
											<span class="text-label">CVV</span>
											<input type="text" name="" placeholder="xxx" class="form-campo text-center">
										</div>
										<div class="col-12 mb-2 position-relative" style="top:-5px">
											<small style="display:block;color:#fff;text-align:right;font-size:.7rem">Digite neste campo</small>
										</div>
									</div>
								</div>
						</div>
					</div>
				<div class="col-8 alt-cart">
					<div class="rows">
						<div class="col-6 mb-2">
							<strong class="text-label">Titular do cartão:</strong>
							<input type="text" v-model="cartao.titular" class="form-campo">
						</div>
						<div class="col-6 mb-2">
							<strong class="text-label">CPF do Titular do cartão:</strong>
							<input type="text" v-model="cartao.cpf" class="form-campo">
						</div>
						<div class="col-4 mb-2">
							<strong class="text-label">Número do cartão:</strong>
							<input type="text" v-model="cartao.numero" class="form-campo">
						</div>

						<div class="col-2 mb-2">
							<strong class="text-label">CVV:</strong>
							<input type="text" v-model="cartao.cod_seguranca" class="form-campo">
						</div>
						<div class="col-6">
							<strong class="text-label">Validade:</strong>
							<div class="rows">
								<div class="col-6 mb-2">
									<select v-model="cartao.expira_mes" class="form-campo">
                                        @for($i=1; $i<13; $i++)
                                            <option>{{str_pad($i, 2, "0", STR_PAD_LEFT)}}</option>
                                        @endfor
									</select>
								</div>
								<div class="col-6 mb-2">
									<select v-model="cartao.expira_ano" class="form-campo">
                                        @for($i=($ano = (int)now()->format('Y')); $i<$ano+20; $i++)
                                            <option>{{$i}}</option>
                                        @endfor
									</select>
								</div>
							</div>
						</div>
                        <div class="col-6 mb-2">
                            <strong class="text-label">Tipo:</strong>
                            <select v-model="idCartaoSelecionado" class="form-campo">
                                <option v-for="tipo in tipoCartao" :value="tipo.id">@{{tipo.nome}}</option>
                            </select>
                            <input type="hidden" name="total" value="">
                        </div>
                        <div class="col-6 mb-2">
                            <strong class="text-label">Parcelas:</strong>
                            <select v-model="pagamento.parcelaSelecionada"  class="form-campo">
                                <option v-for="parcela in parcelas" :value="parcela">@{{ parcela.recommended_message }}</option>
                            </select>
                            <input type="hidden" name="total" value="">
                        </div>
                        <div class="col-12 mb-2 mt-2 text-center">
                            <button  class="btn btn-azul m-auto"></button>
                        </div>
				</div>
			    </div>
			</div>
			
			
			
		</div>
		<div class="tfooter end">
			<a href="" class="fechar btn btn-vermelho btn-pequeno">Fechar</a>
		</div>
	</div>
</div>
<script>


function atualizaValor(){
	var saldo_devedor = $("#valor_original").val();
	var juros 	      = $("#juros").val();
	var multa 		  = $("#multa").val();
	var desconto 	  = $("#desconto").val();
	
	var valor_a_pagar = parseFloat(saldo_devedor) + parseFloat(juros) + parseFloat(multa) - parseFloat(desconto);
	console.log(valor_a_pagar);
	$("#valor_a_pagar").val(valor_a_pagar);
	
}
</script>
@endsection