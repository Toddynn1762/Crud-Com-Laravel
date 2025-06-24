<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController; // <-- Importe o Controller
use App\Http\Controllers\AgendamentoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
});

// --- ROTAS DE CLIENTES ---

// Rota para exibir a lista de todos os clientes
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');

// Rota para exibir o formulário de cadastro de um novo cliente
Route::get('/clientes/cadastrar', [ClienteController::class, 'create'])->name('clientes.create');

// Rota para processar o armazenamento do novo cliente (quando o formulário for enviado)
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

// --- ROTAS DE AGENDAMENTOS ---
Route::get('/agendamentos', [AgendamentoController::class, 'index'])->name('agendamentos.index');
Route::get('/agendamentos/agendar', [AgendamentoController::class, 'create'])->name('agendamentos.create');
Route::post('/agendamentos', [AgendamentoController::class, 'store'])->name('agendamentos.store');
// Rota para deletar UM agendamento específico
Route::delete('/agendamentos/{agendamento}', [AgendamentoController::class, 'destroy'])->name('agendamentos.destroy');
// Rota para deletar TODOS os agendamentos
Route::delete('/agendamentos', [AgendamentoController::class, 'limpar'])->name('agendamentos.limpar');

//Rota do formulario de edicao de um agnedamento
Route::get('/agendamentos/{agendamento}/editar', [AgendamentoController::class, 'edit'])->name('agendamentos.edit');
Route::put('/agendamentos/{agendamento}', [AgendamentoController::class, 'update'])->name('agendamentos.update');
