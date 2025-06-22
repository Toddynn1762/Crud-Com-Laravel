<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente; // Importa o Model Cliente
use App\Models\TiposCorte; // Importa o Model TiposCorte
use App\Models\Agendamento; // Importa o Model Agendamento

class AgendamentoController extends Controller
{
    /**
     * Exibe o formulário para agendar um corte.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Busca todos os clientes e tipos de corte para preencher os dropdowns do formulário
        $clientes = Cliente::orderBy('nome_completo')->get(); // Ordena por nome
        $tiposCorte = TiposCorte::orderBy('nome_corte')->get(); // Ordena por nome do corte

        // Passa os dados para a view
        return view('agendamentos.cadastro', compact('clientes', 'tiposCorte'));
    }

    /**
     * Armazena um novo agendamento no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validação dos dados do formulário
        $request->validate([
            'cliente_id' => 'required|exists:clientes,cliente_id', // Garante que o cliente_id existe na tabela clientes
            'corte_id' => 'required|exists:tiposcorte,corte_id',  // Garante que o corte_id existe na tabela tiposcorte
            'data_agendamento' => 'required|date|after_or_equal:today', // Data válida e não pode ser no passado
            'hora_agendamento' => 'required|date_format:H:i', // Formato de hora HH:MM
        ], [
            'cliente_id.required' => 'Por favor, selecione um cliente.',
            'cliente_id.exists' => 'O cliente selecionado não é válido.',
            'corte_id.required' => 'Por favor, selecione um serviço.',
            'corte_id.exists' => 'O serviço selecionado não é válido.',
            'data_agendamento.required' => 'O campo data é obrigatório.',
            'data_agendamento.date' => 'O campo data não é uma data válida.',
            'data_agendamento.after_or_equal' => 'A data do agendamento não pode ser no passado.',
            'hora_agendamento.required' => 'O campo hora é obrigatório.',
            'hora_agendamento.date_format' => 'O campo hora deve estar no formato HH:MM.',
        ]);

        // 2. Criação do Agendamento usando o Model Eloquent
        try {
            Agendamento::create([
                'cliente_id' => $request->cliente_id,
                'corte_id' => $request->corte_id,
                'data_agendamento' => $request->data_agendamento,
                'hora_agendamento' => $request->hora_agendamento,
            ]);

            // 3. Redireciona com mensagem de sucesso
            return redirect()->route('agendamentos.create')->with('success', 'Agendamento realizado com sucesso!');

        } catch (\Exception $e) {
            // Em caso de erro, redireciona de volta com mensagem de erro
            return redirect()->back()->withInput()->with('error', 'Erro ao agendar: ' . $e->getMessage());
        }
    }
}