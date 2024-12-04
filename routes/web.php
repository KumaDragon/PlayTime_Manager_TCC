<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(url('/home'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/clientes/criancas', [App\Http\Controllers\ClienteController::class, 'showCriancas'])->name('clientes.show');
Route::resource('/servicos', \App\Http\Controllers\ServicoController::class);
Route::resource('/clientes', \App\Http\Controllers\ClienteController::class);
Route::resource('/criancas', \App\Http\Controllers\CriancaController::class);
Route::resource('/consumo', \App\Http\Controllers\ConsumoController::class);
Route::get('/consumo/{consumo}/servico/{servico}', [\App\Http\Controllers\ConsumoController::class, 'servico'])->name('consumo.servico');
Route::get('/clientes/crianca/{cliente}', [\App\Http\Controllers\ClienteController::class, 'crianca'])->name('clientes.crianca');
Route::post('consumos/{consumo}/add-service', [ConsumoController::class, 'servico']);

