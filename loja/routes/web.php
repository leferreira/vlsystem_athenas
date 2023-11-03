<?php

use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\CartaoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ErroController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\SubCategoriaController;
use App\Http\Controllers\VendaPdvController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PixController;
use App\Http\Controllers\BoletoController;

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Limpeza total!";
});
    Route::get('erro', [ErroController::class,'index'])->name('erro');

    Route::get('configurar', [ConfiguracaoController::class,'index'])->name('configurar');
    Route::get('configuracao/editar', [ConfiguracaoController::class,'editar'])->name('configuracao.editar');
    Route::post('configuracao/salvar', [ConfiguracaoController::class,'salvar'])->name('configuracao.salvar');
    Route::post('configuracao/login', [ConfiguracaoController::class,'login'])->name('configuracao.login');
    
    Route::get('/',[HomeController::class, 'index'])->name('home');
    
    Route::get('login', [ClienteController::class,'login'])->name('login');
    Route::post('logar', [ClienteController::class,'logar'])->name('logar');
    Route::get('logoff', [ClienteController::class,'logoff'])->name('logoff');
    
    Route::get('/produto/detalhe/{uuid}',[ProdutoController::class, 'detalhe'])->name('produto.detalhe'); 
    Route::get('/produto/pesquisar',[ProdutoController::class, 'pesquisar'])->name('produto.pesquisar');
    Route::post('/produto/aplicarCupom', [ProdutoController::class,'aplicarCupom'])->name('produto.aplicarCupom');
    
    Route::get('/cartao/ver/{id}',[CartaoController::class, 'ver'])->name('cartao.ver');
    Route::get('/pix/ver/{id}',[PixController::class, 'ver'])->name('pix.ver');
    Route::get('/boleto/ver/{id}',[BoletoController::class, 'ver'])->name('boleto.ver');
    
    Route::get('/categoria/{id}',[CategoriaController::class, 'index'])->name('categoria');
    Route::get('/subcategoria/{id}',[SubCategoriaController::class, 'index'])->name('subcategoria');
    
    //Carrinho
    Route::get('carrinho', [CarrinhoController::class,'index'])->name('carrinho');
    Route::get('carrinho/acompanhar/{id}', [CarrinhoController::class,'acompanhar'])->name('acompanhar');
    Route::get('carrinho/excluirCupom/{id}', [CarrinhoController::class,'excluirCupom'])->name('excluirCupom');
    Route::get('carrinho/atualizarItem/{id}/{qtde}', [CarrinhoController::class,'atualizarItem'])->name('atualizarItem');
    Route::get('carrinho/excluir/{id}', [CarrinhoController::class,'excluir'])->name('excluir');
    Route::get('carrinho/fecharSessao', [CarrinhoController::class,'fecharSessao'])->name('carrinho.fecharSessao');
    Route::post('carrinho/aplicarCupom', [CarrinhoController::class,'aplicarCupom'])->name('carrinho.aplicarCupom');
    Route::post('carrinho/add', [CarrinhoController::class,'add'])->name('carrinho.add');
    Route::get('checkout', [CarrinhoController::class,'checkout'])->name('checkout');
    Route::get('/carrinho/retomar/{uuid}',[CarrinhoController::class,'retomar'])->name('carrinho.retomar');
    Route::get('carrinho/endereco',[CarrinhoController::class,'endereco'])->name('carrinho.endereco');
    Route::get('carrinho/pagamento',[CarrinhoController::class,'pagamento'])->name('carrinho.pagamento');
    Route::get('carrinho/finalizado/{uuid}', [CarrinhoController::class,'finalizado'])->name('carrinho.finalizado');
    
    //Mercado Pado
    Route::get('/mercadopago/verificaPagamentoPix/{id}',[MercadoPagoController::class, 'verificaPagamentoPix'])->name('mercadopago.verificaPagamentoPix');
    Route::post('/mercadopago/pix',[MercadoPagoController::class, 'pix'])->name('mercadopago.pix');
    Route::post('/mercadopago/cartao',[MercadoPagoController::class, 'cartao'])->name('mercadopago.cartao');
    Route::post('/mercadopago/boleto',[MercadoPagoController::class, 'boleto'])->name('mercadopago.boleto');
    Route::get('/mercadopago/verificaSePedidoPagoNoPix/{id}',[MercadoPagoController::class, 'verificaSePedidoPagoNoPix'])->name('mercadopago.verificaSePedidoPagoNoPix');
    
    
    //resgate
    Route::get('vendapdv', [VendaPdvController::class,'index'])->name('vendapdv.index');
    Route::get('vendapdv/vercarrinho/{uuid}',[VendaPdvController::class,'vercarrinho'])->name('vendapdv.vercarrinho');
    
    
    //Cliente
    Route::get('cliente', [ClienteController::class,'index'])->name('cliente');
    Route::get('cliente/create', [ClienteController::class,'create'])->name('cliente.create');
    Route::post('cliente/salvar',[ClienteController::class,'salvar'])->name('cliente.salvar');
    Route::get('/cliente/pedido/{id}',[ClienteController::class,'pedido'])->name('cliente.pedido');
    Route::get('/cliente/enderecoJs/{id}',[ClienteController::class,'enderecoJs'])->name('cliente.enderecoJs');
    Route::post('cliente/atualizarDadosCliente',[ClienteController::class,'atualizarDadosCliente'])->name('cliente.atualizarDadosCliente');
    Route::post('cliente/salvarEnderecoCliente',[ClienteController::class,'salvarEnderecoCliente'])->name('cliente.salvarEnderecoCliente');
    
        
    Route::get('pagamento', [PagamentoController::class,'index'])->name('pagamento');
    //Route::get('pagamento/finalizar', [PagamentoController::class,'finalizar'])->name('pagamento.finalizar');
    Route::get('pagamento/escolher/{uuid}', [PagamentoController::class,'escolher'])->name('pagamento.escolher');
    Route::get('pagamento/finalizar/{uuid}/{forma_pagto}', [PagamentoController::class,'finalizar'])->name('pagamento.finalizar');