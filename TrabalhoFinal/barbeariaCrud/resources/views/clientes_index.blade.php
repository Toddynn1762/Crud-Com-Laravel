@extends('layout')

@section('conteudo')
<div class="container bg-dark p-5 rounded">
    <h1 class="mb-4 text-white">Lista de Clientes</h1>

    <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">Cadastrar Novo Cliente</a>

    {{-- Este bloco exibe a mensagem de sucesso que vem do controller --}}
    @if(session('sucesso'))
        <div class="alert alert-success">
            {{ session('sucesso') }}
        </div>
    @endif

    <table class="table table-striped table-hover table-dark">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            {{-- O @forelse é um loop que tem um @empty para o caso de não haver dados --}}
            @forelse ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->telefone }}</td>
                    <td>{{ $cliente->email }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Nenhum cliente cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection