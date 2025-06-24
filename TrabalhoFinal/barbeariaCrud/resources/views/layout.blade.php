<!DOCTYPE html>
<html lang="pt-br">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Meta tag de segurança CSRF para o AJAX funcionar --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Barbearia Los Hermanos</title>
    
    {{-- Link para a biblioteca de Ícones do Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-image: url('{{ asset('images/LosHermanos.png') }}');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-color: #212529; 
        }
        .main-content-area {
            background-color: rgba(33, 37, 41, 0.9);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
    </style>
    
    {{-- Inclusão do CSS do Bootstrap --}}
    {{-- Inclusão do CSS e JS principais via Vite --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Los Hermanos Barbearia</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('agendamentos.index') }}">Agendamentos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        {{-- Ponto onde o conteúdo principal de cada página será inserido --}}
        @yield('conteudo')
    </main>

    {{-- Ponto onde os scripts específicos de cada página serão inseridos --}}
    @yield('scripts')
</body>
</html>