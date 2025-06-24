@extends('layout')

@section('conteudo')
<div class="container bg-dark p-5 rounded">
    <h1 class="mb-4 text-white">Editar Agendamento</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- O formulário aponta para a rota de update, passando o ID do agendamento --}}
    <form action="{{ route('agendamentos.update', $agendamento->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Informa ao Laravel que este formulário simula um request do tipo PUT --}}
        
        <div class="mb-3">
            <label for="cliente_id" class="form-label text-white">Cliente</label>
            <select class="form-select" id="cliente_id" name="cliente_id" required>
                @foreach($clientes as $cliente)
                    {{-- Lógica para deixar o cliente do agendamento já selecionado --}}
                    <option value="{{ $cliente->id }}" {{ $agendamento->cliente_id == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nome }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="data" class="form-label text-white">Data</label>
                {{-- O value vem do agendamento, formatado para o input type="date" --}}
                <input type="date" class="form-control" id="data" name="data" value="{{ $agendamento->data->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-6">
                <label for="hora" class="form-label text-white">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" value="{{ $agendamento->hora }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-white">Serviços</label>
            <div class="bg-white p-3 rounded text-dark">
                @foreach($servicos as $servico)
                <div class="form-check">
                    {{-- Lógica para deixar os serviços do agendamento já marcados --}}
                    <input class="form-check-input" type="checkbox" name="servicos[]" value="{{ $servico->id }}" id="servico_{{ $servico->id }}"
                        {{ $agendamento->servicos->contains($servico->id) ? 'checked' : '' }}>
                    <label class="form-check-label" for="servico_{{ $servico->id }}">
                        {{ $servico->nome }} (R$ {{ number_format($servico->preco, 2, ',', '.') }})
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="{{ route('agendamentos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection