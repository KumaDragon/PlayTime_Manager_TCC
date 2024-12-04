<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumoController;


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
Route::resource('/servicos', \App\Http\Controllers\ServicoController::class);
Route::resource('/clientes', \App\Http\Controllers\ClienteController::class);
Route::resource('/criancas', \App\Http\Controllers\CriancaController::class);
Route::resource('/consumo', \App\Http\Controllers\ConsumoController::class);

// Somente a rota POST para adicionar serviço
Route::post('consumo/{consumo}/servico/{servico}', [ConsumoController::class, 'servico'])->name('consumo.servico');

// Outras rotas
Route::get('/clientes/crianca/{cliente}', [\App\Http\Controllers\ClienteController::class, 'crianca'])->name('clientes.crianca');
Route::get('/clientes/{cliente}/criancas', [\App\Http\Controllers\ClienteController::class, 'getCriancas'])->name('clientes.getCriancas');
Route::post('/consumo/{consumo}/adicionar-tempo', [ConsumoController::class, 'adicionarTempo']);
Route::get('consumo/{consumo}', [ConsumoController::class, 'show'])->name('consumo.show');

Route::post('/consumo/{consumo}/servico', [ConsumoController::class, 'servico'])->name('consumo.servico');
