<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumoController;
use App\Http\Controllers\ReciboController;


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
Route::get('/relatorios', [ConsumoController::class, 'index'])->name('relatorios.index');
Route::get('/pagamento/{consumo}', [ConsumoController::class, 'pagamento'])->name('consumo.pagamento');
Route::get('/pagamento/{id}', [ConsumoController::class, 'show'])->name('pagamento.show');
Route::post('/pagamento/{id}/confirmar', [ConsumoController::class, 'confirmarPagamento'])->name('pagamento.confirmar');
Route::put('consumo/{id}/finalizar', [ConsumoController::class, 'finalizar'])->name('consumo.finalizar');
Route::resource('/servicos', \App\Http\Controllers\ServicoController::class);
Route::resource('/clientes', \App\Http\Controllers\ClienteController::class);
Route::resource('/criancas', \App\Http\Controllers\CriancaController::class);
Route::resource('/consumo', \App\Http\Controllers\ConsumoController::class);

Route::post('consumo/{consumo}/servico/{servico}', [ConsumoController::class, 'servico'])->name('consumo.servico');

Route::get('/clientes/crianca/{cliente}', [\App\Http\Controllers\ClienteController::class, 'crianca'])->name('clientes.crianca');
Route::get('/clientes/{cliente}/criancas', [\App\Http\Controllers\ClienteController::class, 'getCriancas'])->name('clientes.getCriancas');
Route::post('/consumo/{consumo}/adicionar-tempo', [ConsumoController::class, 'adicionarTempo']);
Route::get('consumo/{consumo}', [ConsumoController::class, 'show'])->name('consumo.show');

Route::post('/consumo/{consumo}/servico', [ConsumoController::class, 'servico'])->name('consumo.servico');

Route::get('/recibo/pdf/{id}', [App\Http\Controllers\ReciboController::class, 'gerarReciboPDF'])->name('recibo.pdf');
