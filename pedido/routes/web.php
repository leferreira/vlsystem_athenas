<?php

use App\Http\Controllers\AssinaturaController;
use App\Http\Controllers\BoletoController;
use App\Http\Controllers\CartaoController;
use App\Http\Controllers\CobrancaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\Acl\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PixController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login/enter', [LoginController::class,'login'])->name('login.in');
Route::get('/login/out', [LoginController::class,'logout'])->name('login.out');
Route::get('/testeapi',[HomeController::class, 'testeapi'])->name('testeapi');

Route::get('/cobranca/detalhe/{uuid}',[CobrancaController::class, 'detalhe'])->name('detalhe');
Route::get('/cobranca/sucesso/{id}',[CobrancaController::class, 'sucesso'])->name('sucesso');
Route::get('/cartao/ver/{id}',[CartaoController::class, 'ver'])->name('cartao.ver');
Route::get('/boleto/ver/{id}',[BoletoController::class, 'ver'])->name('boleto.ver');
Route::get('/pix/ver/{id}',[PixController::class, 'ver'])->name('pix.ver');

Route::post('/mercadopago/pix',[MercadoPagoController::class, 'pix'])->name('mercadopago.pix');
Route::post('/mercadopago/cartao',[MercadoPagoController::class, 'cartao'])->name('mercadopago.cartao');
Route::post('/mercadopago/boleto',[MercadoPagoController::class, 'boleto'])->name('mercadopago.boleto');
Route::get('/mercadopago/verificaSeCobrancaPagaNoPix/{id}',[MercadoPagoController::class, 'verificaSeCobrancaPagaNoPix'])->name('mercadopago.verificaSeCobrancaPagaNoPix');


Route::group(['middleware' => 'UsuarioLogado'], function () {
    Route::get('/',[HomeController::class, 'index'])->name('home');
    Route::get('/pedido/filtro',[PedidoController::class, 'filtro'])->name('filtro');
    Route::get('/pedido/create',[PedidoController::class, 'create'])->name('create');
    Route::get('/pedido/detalhe/{uuid}',[PedidoController::class, 'detalhe'])->name('pedido.detalhe');
    Route::get('/pedido/excluir/{id}',[PedidoController::class, 'detalhe'])->name('excluir');
    
    Route::post('/pedido/salvar',[PedidoController::class, 'salvar'])->name('pedido.salvar');
    Route::get('/produto/pesquisa',[ProdutoController::class, 'pesquisa'])->name('produto.pesquisa');
    
    Route::get('/cobranca/filtro',[CobrancaController::class, 'filtro'])->name('cobranca.filtro');
    
    Route::get('/cobranca',[CobrancaController::class, 'index'])->name('cobranca.index'); 
    
    Route::get('/assinatura/cobrancas/{id}',[AssinaturaController::class, 'cobrancas'])->name('assinatura.cobrancas');   
    Route::post('/cartao/pagar',[CartaoController::class, 'pagar'])->name('cartao.pagar');
});
    