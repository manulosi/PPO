<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolha de Usuário ou Funcionário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Cor de fundo mais clara */
            text-align: center;
        }
        body {
  margin: 0;
  padding: 0;
  background-image: url('img/cidades.jpg'); /*Substitua pelo caminho real da sua imagem */
  background-size: cover; /* Ajusta o tamanho da imagem para cobrir toda a tela */
  background-position: center; /* Centraliza a imagem */
  background-repeat: no-repeat; /* Evita a repetição da imagem */
  font-family: Arial, sans-serif; /* Escolha a fonte desejada para o texto */
}

        .container {
            margin-top: 4rem;
        }

        .card {
            margin-bottom: 1.5rem;
            background-color: #ffffff; /* Cor de fundo do card */
            border-radius: 10px; /* Cantos arredondados do card */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }

        .card-title {
            color: #000000; /* Cor azul para o título do card */
        }

        .card-text {
            color: #495057; /* Cor de texto mais escura */
        }

        .btn-primary {
            background-color: #007bff; /* Cor de fundo do botão */
            border-color: #007bff; /* Cor da borda do botão */
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Cor de fundo do botão ao passar o mouse */
            border-color: #0056b3; /* Cor da borda do botão ao passar o mouse */
        }
  
h2{
    color: white;
    font-weight: bold; /* Deixa o texto mais grosso */
}
a {
  color: #000000; /* Cor dos links como preto */
  text-decoration: none; /* Remove o sublinhado padrão dos links */
}
.logo {
    position: absolute;
            top: 10px; /* Ajuste conforme necessário para a posição vertical */
            left: 10px; /* Ajuste conforme necessário para a posição horizontal */
            width: 100px; /* Ajuste o tamanho conforme necessário */
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Escolha de Usuário ou Funcionário</h2> <br><br><br><br>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Usuário</h5>
                    <p class="card-text">Clique abaixo se você é um usuário.</p>
                    <a href="teste.php" class="a">Entrar como Usuário</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Funcionário</h5>
                    <p class="card-text">Clique abaixo se você é um funcionário.</p>
                    <a href="funcionario.php" class="a">Entrar como Funcionário</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
