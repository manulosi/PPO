<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linhas de Ônibus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('img/onibus.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            justify-content: center;
        }

        .navbar {
            background-color: #333;
            padding: 15px 0;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar-nav {
            flex-direction: row;
        }

        .navbar-nav .nav-item {
            margin-right: 10px;
        }

        .navbar-nav .nav-link {
            color: #fff;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 18px;
        }

        .navbar-nav .nav-link:hover {
            background-color: #555;
        }

        .container {
            text-align: center;
            max-width: 800px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }

        .bus-lines {
            margin-top: 20px;
        }

        .bus-lines h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #555;
        }

        .lines-list {
            list-style-type: none;
            padding: 0;
            text-align: left;
        }

        .lines-list li {
            background-color: #f9f9f9;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 18px;
            color: #555;
        }

        .lines-list li:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="paginaprincipal.php">Linhas de Ônibus</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="local.php">Local</a></li>
                <li class="nav-item"><a class="nav-link" href="pag8.php">Pontos</a></li>
                <li class="nav-item"><a class="nav-link" href="linhas.php">Linhas</a></li>
                <li class="nav-item"><a class="nav-link" href="mapas.php">Rota</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <h1>Linhas de Ônibus</h1>
        </div>

        <div class="bus-lines">
            <h2>Linhas Disponíveis</h2>
            <ul class="lines-list">
                <?php
                    // Informações fictícias de linhas de ônibus
                    $linhas = [
                        ["Rua Principal", "Ponto A", 10],
                        ["Avenida Central", "Ponto B", 15],
                        ["Rua das Flores", "Ponto C", 20],
                        ["Praça da Matriz", "Ponto D", 25],
                        ["Avenida dos Estudantes", "Ponto E", 30]
                    ];

                    // Exibindo as informações fictícias
                    foreach ($linhas as $linha) {
                        echo "<li> " . htmlspecialchars($linha[1]) . ", " . htmlspecialchars($linha[0]) . "  ,  " . htmlspecialchars($linha[2]) . " minutos</li>";
                    }
                ?>
            </ul>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
