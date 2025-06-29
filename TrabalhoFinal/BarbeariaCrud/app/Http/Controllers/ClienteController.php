<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente; // Certifique-se de que o Model Cliente está sendo importado

class ClienteController extends Controller
{
    
    public function index()
    {
        // Busca todos os clientes do banco, ordenados por nome
        $clientes = Cliente::orderBy('nome')->get();
        
        // Carrega a view da lista e envia a variável $clientes para ela
        return view('clientes_index', ['clientes' => $clientes]);
    }

    /**
     * Mostra o formulário para criar um novo cliente.
     * Este método é chamado pela rota 'clientes.create'.
     */
    public function create()
    {
        
        return view('clientes_create');
    }

    /**
     * Armazena um novo cliente no banco de dados.
     * Este método é chamado pela rota 'clientes.store' quando o formulário é enviado.
     */
    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|unique:clientes,telefone',
            'email' => 'nullable|email|unique:clientes,email',
        ]);

        $cliente = Cliente::create($dadosValidados);

        // Verifica se a requisição espera uma resposta JSON (AJAX)
        if ($request->wantsJson()) {
            // Se for AJAX, retorna uma resposta JSON de sucesso.
            return response()->json([
                'mensagem' => 'Cliente cadastrado com sucesso!',
                'cliente' => $cliente
            ], 201);
        }

        // 4. Se não for AJAX, mantém o comportamento antigo de redirecionar
        return redirect()->route('clientes.index')
                         ->with('sucesso', 'Cliente cadastrado com sucesso!');
    }
}
