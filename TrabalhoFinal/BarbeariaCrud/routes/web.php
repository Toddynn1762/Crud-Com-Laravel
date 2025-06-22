<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AgendamentoController; // Certifique-se de importar este Controller também

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

// Rota para a página inicial da Barbearia (mantida apenas esta)
Route::get('/', function () {
    return view('barbearia.home'); // Aponta para a view 'resources/views/barbearia/home.blade.php'
})->name('home'); // Dando um nome para a rota da página inicial

// Rotas de Clientes
Route::get('/clientes/cadastrar', [ClienteController::class, 'create'])->name('clientes.create');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
// Rota para listar clientes
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');

// Rotas de Agendamentos (você precisará criar o AgendamentoController e os métodos)
Route::get('/agendamentos/cadastrar', [AgendamentoController::class, 'create'])->name('agendamentos.create');
Route::post('/agendamentos', [AgendamentoController::class, 'store'])->name('agendamentos.store');
// Opcional: Rota para listar agendamentos
// Route::get('/agendamentos', [AgendamentoController::class, 'index'])->name('agendamentos.index');
