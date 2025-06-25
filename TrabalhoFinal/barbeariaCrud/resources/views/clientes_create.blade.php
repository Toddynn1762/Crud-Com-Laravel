@extends('layout')

{{-- Início da seção de conteúdo principal --}}
@section('conteudo')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        
        {{-- Aqui aplicamos o estilo escuro apenas para este formulário --}}
        <div class="card shadow bg-dark text-white">
            <div class="card-header">
                <h4 class="mb-0">Cadastro de Cliente</h4>
            </div>

            <div class="card-body">
                {{-- Este DIV vai exibir as mensagens de sucesso ou erro do AJAX --}}
                <div id="mensagem"></div>

                <form id="formCadastroCliente" action="{{ route('clientes.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                            <input type="text" class="form-control" id="telefone" name="telefone" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email (Opcional)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Cadastrar Cliente</button>
                        <a href="{{ route('clientes.index') }}" class="btn btn-outline-light">Voltar para a Lista</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- Fim da seção de conteúdo --}}


{{-- Início da seção de scripts, que será injetada no final do <body> do layout --}}
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formCadastroCliente');
    const mensagemDiv = document.getElementById('mensagem');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(form);
        mensagemDiv.innerHTML = `<div class="alert alert-info">Aguarde, salvando...</div>`;

        fetch('{{ route('clientes.store') }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                // Pega o token da meta tag que está no layout
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            mensagemDiv.innerHTML = `<div class="alert alert-success">${data.mensagem}</div>`;
            form.reset();
        })
        .catch(error => {
            let errorMessages = '<div class="alert alert-danger"><ul>';
            if (error.errors) {
                // Loop para exibir corretamente os erros de validação
                for (const key in error.errors) {
                    errorMessages += `<li>${error.errors[key][0]}</li>`;
                }
            } else {
                errorMessages += `<li>Ocorreu um erro inesperado. Tente novamente.</li>`;
                console.error('Erro:', error);
            }
            errorMessages += '</ul></div>';
            mensagemDiv.innerHTML = errorMessages;
        });
    });
});
</script>
@endsection