<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações de Destino</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('img/onibus.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .navbar {
            background-color: #333;
        }
        .navbar a {
            color: #fff;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 18px;
        }
        .navbar a:hover {
            background-color: #555;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
            width: 100%;
            margin: 20px;
        }
        h2, h3, h4 {
            color: #000;
        }
        h2 {
            text-align: center;
        }
        th, td {
            text-align: center;
        }
        .nav-link {
            color: #000;
        }
        .nav-link:hover {
            text-decoration: underline;
        }
        .nav-link.active {
            font-weight: bold;
        }
        .b {
            margin-right: 10px;
        }
    </style>
</head>
<body>
<?php
// Obtendo o destino da página anterior
$localDestino = isset($_GET['localDestino']) ? $_GET['localDestino'] : 'Destino não especificado';
?>

   <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <a class="navbar-brand" href="paginaprincipal.php">Informações do destino</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="local.php">Local</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pag8.php">Pontos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="linhas.php">Linhas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mapas.php">Rota</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Informações de Destino</h2>

        <?php
        // Obtendo o destino da página anterior
        $localDestino = isset($_GET['localDestino']) ? $_GET['localDestino'] : 'Destino não especificado';
        ?>

        <h3>Destino: <?php echo $localDestino; ?></h3>

        <h4 class="mt-4">Ruas, Pontos Próximos e Tempo Estimado:</h4>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Ruas</th>
                    <th>Pontos Próximos</th>
                    <th>Tempo Estimado (minutos)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rua 1</td>
                    <td>Ponto A</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Rua 2</td>
                    <td>Ponto B</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>Rua 3</td>
                    <td>Ponto C</td>
                    <td>20</td>
                </tr>
            </tbody>
        </table>
       
    </div>
  

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
