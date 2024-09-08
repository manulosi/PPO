<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - SmartBus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('img/onibus.jpg');
            background-size: cover; /* Adiciona cobertura completa da imagem de fundo */
        }
        .btn-custom, .btn-back {
            background-color: #000; /* Cor preta para ambos os botões */
            color: white; /* Cor branca do texto */
            border: none;
            border-radius: 8px;
            padding: 15px 30px;
            font-size: 18px;
            transition: background-color 0.3s, transform 0.2s;
            width: 48%; /* Largura dos botões ajustada para ficarem lado a lado */
        }
        .btn-custom:hover, .btn-back:hover {
            background-color: #333; /* Um tom de cinza mais claro no hover */
            transform: scale(1.05);
        }
        .btn-custom:active, .btn-back:active {
            transform: scale(1);
        }
        .card-custom {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .button-group {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card card-custom">
        <div class="card-body">
            <h2 class="card-title">Entre em contato conosco</h2>

            <?php
            // Conexão com o banco de dados
            $host = 'localhost';
            $db = 'smartbus';
            $user = 'root';
            $pass = '';

            $conn = new mysqli($host, $user, $pass, $db);

            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            // Processa o formulário quando ele for enviado
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = $conn->real_escape_string($_POST['nome']);
                $email = $conn->real_escape_string($_POST['email']);
                $mensagem = $conn->real_escape_string($_POST['mensagem']);

                // Inserir a mensagem no banco de dados
                $sql = "INSERT INTO mensagens (nome, email, mensagem) VALUES ('$nome', '$email', '$mensagem')";

                if ($conn->query($sql) === TRUE) {
                    echo '<div class="alert alert-success" role="alert">Mensagem enviada com sucesso!</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Erro ao enviar a mensagem: ' . $conn->error . '</div>';
                }
            }

            $conn->close();
            ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="mensagem">Mensagem:</label>
                    <textarea class="form-control" id="mensagem" name="mensagem" rows="5" required></textarea>
                </div>
                <div class="button-group">
                    <a href="paginaprincipal.php" class="btn btn-custom">Voltar</a>
                   
                    <button type="submit" class="btn btn-custom">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
