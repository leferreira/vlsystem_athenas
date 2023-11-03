@extends('template_loja')
@section('conteudo')
    <div class="central">
        <div class="conteudo">
            <div class="rows">
                <div class="col-12 m-auto">
                    <div class="titulo" style="justify-content: left;">
                        <span>Pagamento</span> <i class="fas fa-angle-double-right pl-3 text-laranja"></i><span
                            class="text-azul migalha" style="padding-left: 0.3rem;"> via Pix</span>
                    </div>
                </div>
            </div>

            <input type="hidden" id="cliente_id" value="<?php echo $pedido->cliente_id ?? null; ?>">
            <input type="hidden" id="pedido_id" value="<?php echo $pedido->id ?? null; ?>">
            <input type="hidden" id="pedido_uuid" value="<?php echo $pedido->uuid ?? null; ?>">
            <input type="hidden" id="empresa_id" value="<?php echo $pedido->empresa_id ?? null; ?>">

            <div class="card pag1">
                <form id="form-checkout">
                    <div class="p-3 px-md">
                        <div class="rows">
                            <div class="col-6 mb-3">
                                <strong class="text-label">Nome:</strong>
                                <input type="text" name="payerFirstName" id="payerFirstName" value="<?php echo primeiroNome($pedido->cliente->nome_razao_social) ?? null; ?>"
                                    class="form-campo">
                            </div>
                            <div class="col-6 mb-3">
                                <strong class="text-label">Sobrenome:</strong>
                                <input type="text" name="payerLastName" id="payerLastName" value="<?php echo ultimoNome($pedido->cliente->nome_razao_social) ?? null; ?>"
                                    class="form-campo">
                            </div>

                            <div class="col-3 mb-3">
                                <strong class="text-label">CPF</strong>
                                <input type="text" name="docNumber" id="docNumber" value="<?php echo $pedido->cliente->cpf_cnpj ?? null; ?>"
                                    class="form-campo">
                            </div>
                            <div class="col-6 mb-3">
                                <strong class="text-label">Email:</strong>
                                <input type="text" name="payerEmail" id="payerEmail" value="<?php echo $pedido->cliente->email ?? null; ?>"
                                    class="form-campo">
                            </div>
                            <div class="col-3 m-auto text-center ">

                            </div>

                        </div>
                    </div>
                    <div class="tfooter center">
                        <a href="javascript:;" onclick="pagarComPix()" class="btn btn-verde" id="btnPagarPix">Gerar PIX</a>
                        <a href="{{ route('pagamento.escolher', $pedido->uuid) }}" class="btn btn-vermelho ">Voltar</a>
                    </div>

                </form>
            </div>

        </div>


    </div>


    <div class="window form" id="pix">
        <span class="tacord">Pague com Pix e receba a confirmação imediata do seu pagamento</span>
        <div class="card pag1">
            <div class="p-3 px-md">
                <div class="rows">
                    <ul class="col-8 mt-4">
                        <li class="d-block mb-1"><span>1 - Abra o aplicativo do seu banco de preferência</span></li>
                        <li class="d-block mb-1"><span>2 - Selecione a opção pagar com Pix</span></li>
                        <li class="d-block mb-1"><span>3 - Leia o QR code ou copie o código abaixo e cole no campo de
                                pagamento</span></li>
                    </ul>
                    <div class="col-4">
                        <img src="" id="imageQRCode" class="img-fluido">
                    </div>
                    <div class="col-6 grupo-form-btn">
                        <input type="text" class="form-campo" id="codigoPix" style="">
                    </div>
                </div>
            </div>
            <div class="tfooter end">
                <a href="" class="fechar btn btn-vermelho ">Fechar</a>
            </div>
        </div>
    </div>
@endsection
