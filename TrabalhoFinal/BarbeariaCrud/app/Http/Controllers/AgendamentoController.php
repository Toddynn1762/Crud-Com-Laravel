<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AgendamentoController extends Controller
{
    /**
     * Mostra a lista de agendamentos (faremos a view depois)
     */
    public function index()
    {
        // Busca agendamentos, carregando os dados do cliente e dos serviços junto
        $agendamentos = Agendamento::with(['cliente', 'servicos'])->orderBy('data')->orderBy('hora')->get();
        return view('agendamentos_index', ['agendamentos' => $agendamentos]);
    }

    /**
     * Mostra o formulário para criar um novo agendamento.
     */
    public function create()
    {
        // Para montar o formulário, precisamos de todos os clientes e serviços
        $clientes = Cliente::orderBy('nome')->get();
        $servicos = Servico::orderBy('nome')->get();

        return view('agendamentos_create', compact('clientes', 'servicos'));
    }

    /**
     * Armazena um novo agendamento no banco de dados.
     */
    public function store(Request $request)
    {
        // Validação dos dados
        $regras = [
            'cliente_id' => 'required|exists:clientes,id',
            'data' => 'required|date',
            'hora' => 'required',
            'servicos' => 'required|array|min:1'
        ];

        // Adiciona uma regra de validação customizada para evitar duplicidade
        $regras['cliente_id'] = [
            'required',
            'exists:clientes,id',
            Rule::unique('agendamentos')->where(function ($query) use ($request) {
                return $query->where('data', $request->data)
                             ->where('hora', $request->hora);
            })
        ];

        $mensagens = [
            'cliente_id.unique' => 'Este cliente já possui um agendamento neste mesmo dia e horário.',
            'servicos.required' => 'Selecione pelo menos um serviço.'
        ];

        $request->validate($regras, $mensagens);

        // 1. Cria o agendamento principal
        $agendamento = Agendamento::create([
            'cliente_id' => $request->cliente_id,
            'data' => $request->data,
            'hora' => $request->hora,
        ]);

        // 2. Anexa os serviços ao agendamento na tabela pivot
        $agendamento->servicos()->attach($request->servicos);

        return redirect()->route('agendamentos.index')
                         ->with('sucesso', 'Agendamento realizado com sucesso!');
    }

    public function destroy(agendamento $agendamento){
        $agendamento->delete();

        return redirect()->route('agendamentos.index')
                         ->with('sucesso', 'Agendamento cancelado com sucesso!');
    }

    public function limpar(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('agendamento_servico')->truncate();
        DB::table('agendamentos')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('agendamentos.index')
                         ->with('sucesso', 'Todos os agendamentos foram removidos com sucesso!');
    }

    public function edit(Agendamento $agendamento){
        $clientes = Cliente::orderBy('nome')->get();
        $servicos = Servico::orderBy('nome')->get();

        return view('agendamentos_edit', compact('agendamento', 'clientes', 'servicos'));
    }


    public function update(Request $request, Agendamento $agendamento){
        $regras = [
            'cliente_id' => 'required/exists:clients,id',
            'data' => 'required|date',
            'hora' => 'required',
            'servicos' => 'required|array|min:1'
        ];

        $regras['cliente_id'] = [
            'required',
            'exists:clientes,id',
            Rule::unique('agendamentos')->ignore($agendamento->id)->where(function ($query) use ($request){
                return $query->where('data', $request->data)
                             ->where('hora', $request->hora);
            })
        ];

        $mensagens = [
            'cliente_id.unique' => 'Este cliente já possui um agendamento neste mesmo dia e horário.',
            'servicos.required' => 'Selecione pelo menos um serviço.'
        ];

        $request->validate($regras, $mensagens);

        $agendamento->update($request->only(['cliente_id', 'data', 'hora']));

        $agendamento->servicos()->sync($request->servicos);

        return redirect()->route('agendamentos.index')
                         ->with('sucesso', 'Agendamento atualizado com sucesso!');
    }
}
