<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConsumoController;
use App\Http\Controllers\ReciboController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CriancaController;

// Redirecionamento inicial
Route::get('/', function () {
    return redirect(url('/home'));
});

// Autenticação
Auth::routes();

// Rotas públicas
Route::get('/welcome', fn () => view('welcome'))->name('welcome');

// Rotas protegidas
Route::middleware(['auth'])->group(function () {
    // Página inicial protegida
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Clientes
    Route::get('/clientes/criancas', [ClienteController::class, 'showCriancas'])->name('clientes.showCriancas');
    Route::get('/clientes/crianca/{cliente}', [ClienteController::class, 'crianca'])->name('clientes.crianca');
    Route::get('/clientes/{id}/criancas', [ClienteController::class, 'getCriancas'])->name('clientes.getCriancas');
    Route::get('/clientes/buscar', [ClienteController::class, 'buscar'])->name('clientes.buscar');
    Route::resource('/clientes', ClienteController::class);

    // Criancas
    Route::resource('/criancas', CriancaController::class);
    // Rota para editar a criança
    Route::get('/clientes/{cliente}/criancas/{crianca}/edit', [CriancaController::class, 'edit'])->name('criancas.edit');
    // Rota para atualizar a criança
    Route::put('/clientes/{cliente}/criancas/{crianca}', [CriancaController::class, 'update'])->name('criancas.update');

    // Serviços
    Route::resource('/servicos', ServicoController::class);

    // Consumo
    Route::resource('/consumo', ConsumoController::class);
    Route::post('consumo/{consumo}/adicionar-tempo', [ConsumoController::class, 'adicionarTempo'])->name('consumo.adicionarTempo');
    Route::post('consumo/{consumo}/servico', [ConsumoController::class, 'servico'])->name('consumo.servico');
    Route::put('consumo/{id}/finalizar', [ConsumoController::class, 'finalizar'])->name('consumo.finalizar');
    Route::get('/consumo/{consumo}', [ConsumoController::class, 'show'])->name('consumo.show');

    // Pagamentos
    Route::get('/pagamento/{consumo}', [ConsumoController::class, 'pagamento'])->name('consumo.pagamento');
    Route::post('/pagamento/{id}/confirmar', [ConsumoController::class, 'confirmarPagamento'])->name('pagamento.confirmar');

    // Relatórios
    Route::get('/relatorios', [ConsumoController::class, 'index'])->name('relatorios.index');

    // Recibos
    Route::get('/recibo/pdf/{id}', [ReciboController::class, 'gerarReciboPDF'])->name('recibo.pdf');

    // Usuários
    Route::resource('users', UserController::class);
});
