@extends('layout')

@section('conteudo')
<div class="container bg-dark p-5 rounded">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white mb-0">Lista de Agendamentos</h1>
        
        {{-- Botão para cadastrar um novo agendamento --}}
        <a href="{{ route('agendamentos.create') }}" class="btn btn-primary">Novo Agendamento</a>
    </div>

    @if(session('sucesso'))
        <div class="alert alert-success">
            {{ session('sucesso') }}
        </div>
    @endif

    <table class="table table-striped table-hover table-dark">
        <thead>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Cliente</th>
                <th>Serviços</th>
                <th>Ações</th> {{-- <- NOVA COLUNA --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($agendamentos as $agendamento)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($agendamento->hora)->format('H:i') }}</td>
                    <td>{{ $agendamento->cliente->nome }}</td>
                    <td>
                        @foreach($agendamento->servicos as $servico)
                            <span class="badge bg-secondary">{{ $servico->nome }}</span>
                        @endforeach
                    </td>
                    <td>
                        {{-- <NOVA CÉLULA COM OS BOTÕES> --}}
                        <a href="{{ route('agendamentos.edit', $agendamento->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        
                        {{-- O botão de excluir fica dentro de um formulário --}}
                        <form action="{{ route('agendamentos.destroy', $agendamento->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este agendamento?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhum agendamento encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Botão para limpar toda a agenda, só aparece se houver agendamentos --}}
    @if($agendamentos->isNotEmpty())
    <div class="mt-4">
        <form action="{{ route('agendamentos.limpar') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('ATENÇÃO! Isso apagará TODOS os agendamentos e não poderá ser desfeito. Deseja continuar?')">Limpar Agenda Completa</button>
        </form>
    </div>
    @endif
</div>
@endsection