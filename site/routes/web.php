<?php

use App\Http\Controllers\AssinarController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;



Route::get('/',[SiteController::class, 'index'])->name('home');
Route::get('/cadastro/{id}',[SiteController::class, 'cadastro'])->name('cadastro');
Route::post('/cadastrar',[SiteController::class, 'cadastrar'])->name('cadastrar');
Route::get('/sucesso',[SiteController::class, 'sucesso'])->name('sucesso');
Route::get('/testar/{}',[SiteController::class, 'sucesso'])->name('sucesso');
Route::get('/planos',[SiteController::class, 'planos'])->name('planos');

Route::get('/recorrencia/{id}',[SiteController::class, 'recorrencia'])->name('recorrencia');

Route::get('/assinar',[AssinarController::class, 'index'])->name('assinar');
Route::get('/finalizar/{id}',[AssinarController::class, 'finalizar'])->name('finalizar');