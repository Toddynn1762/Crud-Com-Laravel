<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Validation\ValidationException; // Importe esta classe para capturar erros de validação

class ClienteController extends Controller
{
    /**
     * Exibe o formulário para cadastrar um novo cliente.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('barbearia.cadastro'); // Aponta para a view 'resources/views/clientes/cadastro.blade.php'
    }

    /**
     * Armazena um novo cliente no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // 1. Validação dos dados do formulário
            // Adicionado 'unique:clientes,telefone' para verificar unicidade do telefone
            $validatedData = $request->validate([
                'nome_completo' => 'required|string|max:255',
                'telefone' => 'nullable|string|max:20|unique:clientes,telefone', // 'unique:tabela,coluna'
                'email' => 'nullable|email|max:255|unique:clientes,email',
            ], [
                'nome_completo.required' => 'O nome completo é obrigatório.',
                'nome_completo.string' => 'O nome completo deve ser um texto.',
                'nome_completo.max' => 'O nome completo não pode ter mais de :max caracteres.',
                'telefone.string' => 'O telefone deve ser um texto.',
                'telefone.max' => 'O telefone não pode ter mais de :max caracteres.',
                'telefone.unique' => 'Este telefone já está cadastrado.',
                'email.email' => 'Por favor, insira um endereço de e-mail válido.',
                'email.max' => 'O e-mail não pode ter mais de :max caracteres.',
                'email.unique' => 'Este e-mail já está cadastrado.',
            ]);

            // 2. Cria um novo cliente usando o Model Eloquent
            Cliente::create($validatedData);

            // 3. Resposta para requisições AJAX ou redirecionamento para requisições normais
            if ($request->ajax()) {
                return response()->json(['success' => 'Cliente cadastrado com sucesso!'], 200);
            } else {
                return redirect()->route('clientes.create')->with('success', 'Cliente cadastrado com sucesso!');
            }

        } catch (ValidationException $e) {
            // Captura erros de validação e retorna JSON se for AJAX
            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422); // Status 422 Unprocessable Entity
            } else {
                return redirect()->back()->withInput()->withErrors($e->errors());
            }
        } catch (\Exception $e) {
            // Captura outros erros e retorna JSON se for AJAX
            if ($request->ajax()) {
                return response()->json(['error' => 'Erro ao cadastrar cliente: ' . $e->getMessage()], 500); // Status 500 Internal Server Error
            } else {
                return redirect()->back()->withInput()->with('error', 'Erro ao cadastrar cliente: ' . $e->getMessage());
            }
        }
    }

    /**
     * Exibe uma lista de clientes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $clientes = Cliente::all(); // Busca todos os clientes do banco de dados
        return view('clientes.index', compact('clientes')); // Passa os clientes para a view
    }
}
