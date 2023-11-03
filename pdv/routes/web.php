<?php

use App\Http\Controllers\CaixaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PdvController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ResgateController;
use App\Http\Controllers\SangriaController;
use App\Http\Controllers\SuplementoController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\Acl\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FrenteController;



Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login/enter', [LoginController::class,'login'])->name('login.in');
Route::get('/login/out', [LoginController::class,'logout'])->name('login.out');
Route::get('/login/erros', [LoginController::class,'erros'])->name('erros');

Route::get('/login/comparar', [LoginController::class,'comparar'])->name('login.comparar');

Route::group(['middleware' => 'UsuarioLogado'], function () { 
    Route::get('/',[HomeController::class, 'index'])->name('home');
    
    
    Route::get('/resgate/index',[ResgateController::class, 'index'])->name('resgate.index');
    Route::get('/resgate/lista',[ResgateController::class, 'lista'])->name('resgate.lista');
    Route::post('/resgate/resgatar',[ResgateController::class, 'resgatar'])->name('resgate.resgatar');
    Route::get('/resgate/excluirBalcao/{id}',[ResgateController::class, 'excluirBalcao'])->name('resgate.excluirBalcao');
    Route::get('/resgate/excluirPdvVenda/{id}',[ResgateController::class, 'excluirPdvVenda'])->name('resgate.excluirPdvVenda');
    Route::post('/resgate/enviarParaCaixa',[ResgateController::class, 'enviarParaCaixa'])->name('resgate.enviarParaCaixa');
    
    
    Route::get('/pdv/novo/{id?}',[PdvController::class, 'novo'])->name('pdv.novo');
    Route::get('/pdv/livre',[PdvController::class, 'livre'])->name('pdv.livre');
    Route::get('/pdv/create',[PdvController::class, 'create'])->name('pdv.create');
    Route::get('/pdv/index',[PdvController::class, 'index'])->name('pdv.index');
    Route::post('/pdv/gerarCrediario',[PdvController::class, 'gerarCrediario'])->name('pdv.gerarCrediario');
    Route::post('/pdv/gerarPagamentoCartao',[PdvController::class, 'gerarPagamentoCartao'])->name('pdv.gerarPagamentoCartao');
    Route::get('/pdv/pagamento/{id}',[PdvController::class, 'pagamento'])->name('pdv.pagamento');
    
    Route::get('/frente/',[FrenteController::class, 'index'])->name('frente.index');
    Route::get('/frente/modelo2',[FrenteController::class, 'modelo2'])->name('frente.modelo2');
    
    Route::post('/cliente/buscaCliente',[ClienteController::class, 'buscaCliente'])->name('cliente.buscaCliente');
    Route::post('/cliente/vincularCliente',[ClienteController::class, 'vincularCliente'])->name('cliente.vincularCliente');
    
    
    Route::get('/caixa/index',[CaixaController::class, 'index'])->name('caixa.index');
    Route::post('/caixa/abrir',[CaixaController::class, 'abrir'])->name('caixa.abrir');
    
    Route::get('/caixa/fechar/{id}',[CaixaController::class, 'fechar'])->name('caixa.fechar');
    Route::get('/caixa/create',[CaixaController::class, 'create'])->name('caixa.create');
    Route::get('/caixa/caixasAberto',[CaixaController::class, 'caixasAberto'])->name('caixa.caixasAberto');
    Route::get('/caixa/venda/{id_caixa}',[CaixaController::class, 'venda'])->name('caixa.venda');    
    Route::get('/caixa/sangria/{id_caixa}',[CaixaController::class, 'sangria'])->name('caixa.sangria');
    Route::get('/caixa/suplemento/{id_caixa}',[CaixaController::class, 'suplemento'])->name('caixa.suplemento');
    Route::get('/caixa/fechamento/{id_caixa}',[CaixaController::class, 'fechamento'])->name('caixa.fechamento');
	Route::get('/caixa/contagem/{id_caixa}',[CaixaController::class, 'contagem'])->name('caixa.contagem');
    Route::get('/caixa/detalhes/{id_caixa}',[CaixaController::class, 'detalhes'])->name('caixa.detalhes');    
    Route::get('/caixa/ver',[CaixaController::class, 'ver'])->name('caixa.ver');
    
    
    
    Route::get('/venda/inserirNfcePelaVenda/{id}',[VendaController::class, 'inserirNfcePelaVenda'])->name('venda.inserirNfcePelaVenda');
    Route::get('/venda/transmitirPelaVenda/{id}',[VendaController::class, 'transmitirPelaVenda'])->name('venda.transmitirPelaVenda');
    
    Route::get('/venda/danfce/{chave}',[VendaController::class, 'danfce'])->name('venda.danfce');
    Route::get('/venda/imprimir/{chave}',[VendaController::class, 'imprimir'])->name('venda.imprimir');
    Route::get('/venda/excluirCupom/{id}',[VendaController::class, 'excluirCupom'])->name('venda.excluirCupom');
    Route::post('/venda/salvar',[VendaController::class, 'salvar'])->name('venda.salvar');    
    Route::post('/venda/aplicarCupom',[VendaController::class, 'aplicarCupom'])->name('venda.aplicarCupom');
    Route::post('/venda/finalizarVenda',[VendaController::class, 'finalizarVenda'])->name('venda.finalizarVenda'); 
    Route::post('/venda/cancelarVenda',[VendaController::class, 'cancelarVenda'])->name('venda.cancelarVenda'); 
    Route::post('/venda/enviarDescontoAcrescimento',[VendaController::class, 'enviarDescontoAcrescimento'])->name('venda.enviarDescontoAcrescimento');  
    Route::post('/venda/salvarItensDaVendaNoBanco',[VendaController::class, 'salvarItensDaVendaNoBanco'])->name('venda.salvarItensDaVendaNoBanco');   
    Route::post('/venda/inserirItem',[VendaController::class, 'inserirItem'])->name('venda.inserirItem');  
    Route::get('/venda/excluirItem/{id}/{idVenda}',[VendaController::class, 'excluirItem'])->name('venda.excluirItem');    
    Route::get('/venda/gerarNfcePelaVenda/{id}',[VendaController::class, 'gerarNfcePelaVenda'])->name('venda.gerarNfcePelaVenda');
    Route::post('/venda/salvarPagamento',[VendaController::class, 'salvarPagamento'])->name('venda.salvarPagamento');   
    Route::get('/venda/imprimirNfcePelaVenda/{id}',[VendaController::class, 'imprimirNfcePelaVenda'])->name('venda.imprimirNfcePelaVenda');
    Route::get('/venda/excluirDuplicata/{id}/{idVenda}',[VendaController::class, 'excluirDuplicata'])->name('venda.excluirDuplicata');
    Route::get('/venda/detalhes/{id}',[VendaController::class, 'detalhes'])->name('venda.detalhes');
    Route::get('/venda/ver',[VendaController::class, 'ver'])->name('venda.ver');
    Route::post('/venda/armazenarVenda',[VendaController::class, 'armazenarVenda'])->name('venda.armazenarVenda');
    
    
    Route::get('/mercadopago/verificaPagamentoPix/{id}',[MercadoPagoController::class, 'verificaPagamentoPix'])->name('mercadopago.verificaPagamentoPix');
    Route::post('/mercadopago/pix',[MercadoPagoController::class, 'pix'])->name('mercadopago.pix');
    
    Route::get('/produto/pesquisarProdutoPorNome',[ProdutoController::class, 'pesquisarProdutoPorNome'])->name('produto.pesquisarProdutoPorNome');
    Route::get('/buscaProduto/{id}/{tipo}',[ProdutoController::class,'buscaProduto'])->name('buscaProduto');   
    
    Route::post('/sangria/salvarJs',[SangriaController::class, 'salvarJs'])->name('sangria.salvarJs');
    Route::get('sangria/ver',[SangriaController::class, 'ver'])->name('sangria.ver');
    Route::resource('/sangria',SangriaController::class);
    
    
    Route::post('/suplemento/salvarJs',[SuplementoController::class, 'salvarJs'])->name('suplemento.salvarJs');
    Route::get('/suplemento/ver',[SuplementoController::class, 'ver'])->name('suplemento.ver');
    Route::resource('/suplemento',SuplementoController::class);
    
    
});
