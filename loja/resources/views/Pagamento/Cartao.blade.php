@extends('template_loja')
@section('conteudo')
    <div class="central">
        <div class="conteudo">
            <div class="rows">
                <div class="col-12 m-auto">
                    <div class="titulo" style="justify-content: left;">
                        <span>Pagamento</span> <i class="fas fa-angle-double-right pl-3 text-laranja"></i><span
                            class="text-azul migalha" style="padding-left: 0.3rem;"> via Cartão</span>
                    </div>
                </div>
            </div>

            <input type="hidden" id="cliente_id" value="<?php echo $pedido->cliente_id ?? null; ?>">
            <input type="hidden" id="pedido_id" value="<?php echo $pedido->id ?? null; ?>">
            <input type="hidden" id="empresa_id" value="<?php echo $pedido->empresa_id ?? null; ?>">

            <div class="card pag1">
                <form id="form-checkout">
                    <div class="p-3 px-md">
                        <div class="rows">
                            <div class="col-12">
                                <div class="rows">
                                    <div class="col-4 mb-3">
                                        <strong class="text-label">Número do cartão:</strong>
                                        <input type="text" name="cardNumber" id="form-checkout__cardNumber"
                                            class="form-campo" />
                                    </div>
                                    <div class="col-2 mb-3">
                                        <strong class="text-label">Validade(MM/YYYY)</strong>
                                        <input type="text" name="cardExpirationDate"
                                            id="form-checkout__cardExpirationDate" class="form-campo" />
                                    </div>
                                    <div class="col-6 mb-3">
                                        <strong class="text-label">Titular do cartão:</strong>
                                        <input type="text" name="cardholderName"
                                            id="form-checkout__cardholderName"class="form-campo" />
                                    </div>
                                    <div class="col-6 mb-3">
                                        <strong class="text-label">Email</strong>
                                        <input type="email" name="cardholderEmail" id="form-checkout__cardholderEmail"
                                            class="form-campo" />
                                    </div>
                                    <div class="col-3 mb-3">
                                        <strong class="text-label">Cód Segurança</strong>
                                        <input type="text" name="securityCode" id="form-checkout__securityCode"
                                            class="form-campo" />
                                    </div>
                                    <select name="issuer" id="form-checkout__issuer" class="form-campo"
                                        style="display:none"></select>

                                    <div class="col-3 mb-3">
                                        <strong class="text-label">Tipo Documento</strong>
                                        <select name="identificationType" id="form-checkout__identificationType"
                                            class="form-campo"></select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <strong class="text-label">Número do Documento:</strong>
                                        <input type="text" name="identificationNumber"
                                            id="form-checkout__identificationNumber" class="form-campo" />
                                    </div>
                                    <div class="col-6 mb-3">
                                        <strong class="text-label">Parcelas</strong>
                                        <select name="installments" id="form-checkout__installments"
                                            class="form-campo"></select>
                                    </div>
                                    <div class="col-12">
                                        <progress value="0" class="progress-bar"
                                            style="width:100%">Carregando...</progress>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="tfooter center">
                        <button type="submit" id="form-checkout__submit" class="btn btn-verde">Pagar</button>
                        <a href="{{ route('pagamento.escolher', $pedido->uuid) }}" class="btn btn-vermelho ">Voltar</a>
                    </div>

                </form>
            </div>

        </div>


    </div>

    <script>
        $(function() {
            $('.clica').click(function() {
                $('.frente').addClass("vira");
                $('.costa').addClass("desvira");
            });

        });
    </script>
@endsection
