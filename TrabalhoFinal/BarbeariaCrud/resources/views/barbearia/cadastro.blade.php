<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente - Barbearia</title>
    <!-- Adicione o meta token CSRF para requisições AJAX seguras -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            /* Certifique-se de que 'LosHermanos.png' está em 'public/images/' ou ajuste o caminho */
            background-image: url('{{ asset('images/LosHermanos.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat; /* Adicionado para evitar repetição se a imagem for pequena */
            font-family: 'Libre Baskerville', sans-serif; /* Usando a fonte importada */
            color: #d1d1d1; /* Cor do texto no body como você definiu para o h2 */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #d1d1d1; /* dourado mais escuro */
            text-shadow: 1px 1px 4px #000;
        }

        form {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }

        input, button {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 250px;
            font-size: 16px;
            box-sizing: border-box; /* Garante que padding e border sejam incluídos na largura */
        }

        input {
            border: none;
            border-radius: 5px;
            color: #333; /* Cor do texto dentro do input */
        }

        button {
            background-color: gold;
            color: black;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Adiciona transição ao hover */
        }

        button:hover {
            background-color: #d4af37; /* Tom dourado ao passar o mouse */
        }

        .btn-voltar { /* Nova classe para o botão Voltar */
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: gold; /* Mudei para gold para consistência */
            color: black; /* Mudei para black para consistência */
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease; /* Adiciona transição ao hover */
        }
        .btn-voltar:hover {
            background-color: #d4af37; /* Tom dourado ao passar o mouse */
        }


        #respostaCadastro {
            margin-top: 15px;
            font-size: 18px;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.7); /* Fundo para as mensagens */
        }
        .message-success {
            color: #d4edda; /* Verde claro */
            background-color: #155724; /* Fundo verde escuro */
        }
        .message-error {
            color: #f8d7da; /* Vermelho claro */
            background-color: #721c24; /* Fundo vermelho escuro */
        }
        .message-warning {
            color: #fff3cd; /* Amarelo claro */
            background-color: #856404; /* Fundo amarelo escuro */
        }
    </style>
</head>
<body>

    <h2>Cadastro de Cliente</h2>

    <!-- O action do formulário agora aponta para a rota nomeada do Laravel -->
    <form id="formCadastroAjax" action="{{ route('clientes.store') }}" method="POST">
        <!-- O Laravel exige um token CSRF para formulários POST -->
        @csrf
        <input type="text" name="nome_completo" placeholder="Nome Completo" required value="{{ old('nome_completo') }}"><br>
        <input type="text" name="telefone" placeholder="Telefone" required value="{{ old('telefone') }}"><br>
        <input type="email" name="email" placeholder="E-mail" required value="{{ old('email') }}"><br>
        <button type="submit">Cadastrar</button>
    </form>

    <div id="respostaCadastro"></div>

    <!-- O link Voltar agora usa a rota nomeada do Laravel para a home -->
    <a href="{{ route('home') }}" class="btn-voltar">← Voltar para a Página Inicial</a>

    <script>
        document.getElementById('formCadastroAjax').addEventListener('submit', function(e) {
            e.preventDefault(); // Impede o envio padrão do formulário
            const formData = new FormData(this);
            const respostaCadastroDiv = document.getElementById('respostaCadastro');
            respostaCadastroDiv.innerHTML = ''; // Limpa mensagens anteriores

            // Adiciona o token CSRF ao FormData, se ainda não estiver lá (o @csrf já faz isso)
            // formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch(this.action, { // Usa a URL definida no atributo 'action' do formulário
                method: 'POST',
                body: formData,
                headers: {
                    // Indicar que é uma requisição AJAX
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                // Clona a resposta para poder consumi-la duas vezes (checar status e ler JSON)
                const clonedResponse = response.clone();
                return clonedResponse.json().then(data => ({
                    status: response.status,
                    data: data
                }));
            })
            .then(({ status, data }) => {
                if (status === 200) {
                    // Sucesso
                    respostaCadastroDiv.className = 'message-success';
                    respostaCadastroDiv.innerHTML = `<p>${data.success}</p>`;
                    document.getElementById('formCadastroAjax').reset(); // Limpa o formulário
                } else if (status === 422) {
                    // Erros de validação
                    respostaCadastroDiv.className = 'message-warning'; // ou message-error se preferir
                    let errorMessages = '';
                    for (const field in data.errors) {
                        data.errors[field].forEach(message => {
                            errorMessages += `<li>${message}</li>`;
                        });
                    }
                    respostaCadastroDiv.innerHTML = `<p>Ocorreram erros:</p><ul>${errorMessages}</ul>`;
                } else {
                    // Outros erros
                    respostaCadastroDiv.className = 'message-error';
                    respostaCadastroDiv.innerHTML = `<p>${data.error || 'Erro desconhecido ao cadastrar.'}</p>`;
                }
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
                respostaCadastroDiv.className = 'message-error';
                respostaCadastroDiv.innerHTML = "<p>Erro de rede ou ao tentar conectar com o servidor.</p>";
            });
        });
    </script>

</body>
</html>
