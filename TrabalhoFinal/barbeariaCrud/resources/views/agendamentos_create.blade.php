@extends('layout')

@section('conteudo')
<div class="container bg-dark p-5 rounded">
    <h1 class="mb-4 text-white">Novo Agendamento</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('agendamentos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="cliente_id" class="form-label text-white" >Cliente</label>
            <select class="form-select" id="cliente_id" name="cliente_id" required>
                <option value="">Selecione um cliente...</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="data" class="form-label text-white">Data</label>
                <input type="date" class="form-control" id="data" name="data" value="{{ old('data') }}" required>
            </div>
            <div class="col-md-6">
                <label for="hora" class="form-label text-white">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" value="{{ old('hora') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-white">Serviços</label>
            <div class="bg-white p-3 rounded">
                @foreach($servicos as $servico)
                <div class="form-check">
                    {{-- O uso de 'servicos[]' permite enviar múltiplos valores --}}
                    <input class="form-check-input" type="checkbox" name="servicos[]" value="{{ $servico->id }}" id="servico_{{ $servico->id }}">
                    <label class="form-check-label" for="servico_{{ $servico->id }}">
                        {{ $servico->nome }} (R$ {{ number_format($servico->preco, 2, ',', '.') }})
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Agendar</button>
        <a href="{{ route('agendamentos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection