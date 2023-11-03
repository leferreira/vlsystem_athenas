@extends("Admin.template")
@section("conteudo")
<div class="central">
	<div class="conteudo">
		<div class="rows">
			<div class="col-12 m-auto text-center pt-4">
				<span class="d-block text-center h4 text-escuro mt-1">Escolha uma <span class="text-azul">forma de pagamento</span> </span>
			</div>
		</div>
		
		<div class="p-3 px-4 mb-3">
		<div class="rows mt-2">
			<div class="col d-flex mb-3" :class="carregandoPix ? 'desabilitado' : ''">
				<a href="#" @click="iniciarPix" class="card pagamento width-100 p-2">
					<div class="d-flex py-3">
						<img src="{{asset('assets/admin/img/logo-pix.svg')}}" width="100">
						<div class="ml-3">
						<span class="h5 mb-1 d-block fw-700" style="color:#222;font-weight:700">Pagamento via pix</span>
						<small class="mb-3 d-block text-escuro">Clique aqui para pagamento via pix</small>
						</div>
					</div>
					
						<span class="btn btn-verde btn-medio">@{{ carregandoPix ? 'Aguarde...' : 'pagar com pix' }}</span>
				</a>
			</div>
			
			<div class="col d-flex mb-3">
				<a href="javascript:;" onclick="abrirModal('#cartao')" class="card pagamento width-100 p-2">
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
				<a href="" class="card pagamento width-100 p-2">
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
				<a href="{{route('admin.assinatura.comprovante', $planopreco->id)}}" class="card pagamento width-100 p-2">
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

    <div style="display: none;">
        <form id="form-checkout" >
            <input v-model="dadosEnviar.numero" type="text" name="cardNumber" id="form-checkout__cardNumber" />
            <input v-model="dadosEnviar.data_expira" type="text" name="cardExpirationDate" id="form-checkout__cardExpirationDate" />
            <input v-model="dadosEnviar.titular" type="text" name="cardholderName" id="form-checkout__cardholderName"/>
            <input value="{{auth()->user()->email}}" type="email" name="cardholderEmail" id="form-checkout__cardholderEmail"/>
            <input v-model="dadosEnviar.cod_seguranca" type="text" name="securityCode" id="form-checkout__securityCode" />
            <select v-model="installMentSelecionado?.issuer.id" name="issuer" id="form-checkout__issuer">
                <option>@{{ installMentSelecionado?.issuer.id }}</option>
            </select>
            <select name="identificationType" id="form-checkout__identificationType"></select>
            <input type="text" v-model="cartao.cpf" name="identificationNumber" id="form-checkout__identificationNumber"/>
            <select v-model="dadosEnviar.parcelaSelecionada.installments" name="installments" id="form-checkout__installments">
                <option v-for="parcela in parcelas" :value="parcela.installments">@{{ parcela.installments }}</option>
            </select>
            <button type="submit" id="form-checkout__submit">Pagar</button>
            <progress value="0" class="progress-bar">Carregando...</progress>
            <input type="hidden" id="MPHiddenInputPaymentMethod" :value="installMentSelecionado?.payment_method_id">
            <input type="hidden" id="MPHiddenInputToken">
            <input type="hidden" id="MPHiddenInputProcessingMode">
            <input type="hidden" id="MPHiddenInputMerchantAccountId">
        </form>
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
                            <button :disabled="carregando" @click="submeter" class="btn btn-azul m-auto">@{{ carregando ? 'Aguarde...' : 'Finalizar compra' }}</button>
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

<!-- modal pix -->

<div class="window medio" id="pix">
	<div class="card pag1">
		<div class="p-3 px-md">
			<p class="text-uppercase pt-3 text-center h5">Pague com Pix e receba a confirmação imediata do seu pagamento</p>
			<div class="rows">
				<ul class="col-8">
					<li class="d-block mb-1"><div class="li-circ">1</div><span>Abra o aplicativo do seu banco de preferência</span></li>
					<li class="d-block mb-1"><div class="li-circ">2</div><span>Selecione a opção pagar com Pix</span></li>
					<li class="d-block mb-1"><div class="li-circ">3</div><span>Leia o QR code ou copie o código abaixo e cole no campo de pagamento</span></li>
				</ul>
				<div class="col-4">
					<img :src="pix != null ? `data:image/png;base64, ${pix?.qr_code}` : ''" class="img-fluido">
				</div>
				<div class="col-12 grupo-form-btn">
					<input type="text" class="form-campo" :value="pix?.code" style="width:auto">
					<button class="btn btn-outline-azul"><i class="far fa-copy"></i> Copiar</button>
				</div>
			</div>
		</div>
		<div class="tfooter end">
			<a href="" class="fechar btn btn-vermelho btn-pequeno">Fechar</a>
		</div>
		</div>
	</div>
</div>


<div id="fundo_preto"></div>

@endsection

@section('mpjs')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const preco = "{{$planopreco->preco}}"
        const mp = new MercadoPago(MP_PUBLIC_KEY);
    </script>
    <script src="{{asset('assets/pagamento/pagamento.js')}}"></script>
@endsection
