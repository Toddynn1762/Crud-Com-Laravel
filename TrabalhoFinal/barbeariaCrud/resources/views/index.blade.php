<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Página Inicial - Barbearia Los Hermanos</title>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('{{ asset('images/LosHermanos.png') }}'); 
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      font-family: 'Libre Baskerville', sans-serif;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    h1 {
      font-size: 42px;
      color: #fffefd;
      text-shadow: 1px 1px 4px #dad1d1;
      margin-bottom: 20px;
    }
    p {
      font-size: 20px;
      margin-bottom: 30px;
      text-shadow: 1px 1px 2px #000;
    }
    ul { list-style: none; padding: 0; }
    li { margin: 15px 0; }
    a {
      display: inline-block;
      padding: 15px 25px; 
      font-weight: bold;
      text-decoration: none;
      border-radius: 5px;
      font-size: 18px;
      box-shadow: 0px 2px 6px rgba(0,0,0,0.5);
      transition: all 0.3s ease;
      width: 300px;
      text-align: center;

      background-color: rgba(10, 10, 10, 0.5); 
      backdrop-filter: blur(5px); 
      -webkit-backdrop-filter: blur(5px); 
      color: #f5f5f5; 
      border: 1px solid rgba(255, 255, 255, 0.5);
    }
    
    img.logo{ width: 150px; margin-bottom: 20px; }
    a:hover { background-color: rgba(10, 10, 10, 0.7); 
      border-color: white; 
      transform: translateY(-2px) }
  </style>
</head>
<body>

  <img src="{{ asset('images/logo.jpg') }}" alt="Logo da Barbearia Los Hermanos" class="logo">
  
  <h1>Bem-vindo à Barbearia Los Hermanos</h1>
  <p>Escolha uma das opções abaixo:</p>
  <ul>
    <li><a href="{{ route('clientes.create') }}">Cadastrar Cliente</a></li>
    <li><a href="{{ route('agendamentos.create') }}">Agendar Corte</a></li>
    <li><a href="{{ route('clientes.index') }}">Ver clientes cadastrados</a></li>
  </ul>

</body>
</html>