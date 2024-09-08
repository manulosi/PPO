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
            background-color: rgba(0, 0, 0, 0.8);
            border-bottom: 2px solid #fff;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .navbar a {
            color: #fff;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 18px;
        }
        .navbar a:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }
        .navbar-brand {
            font-size: 24px;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 800px;
            width: 100%;
            margin: 20px;
            margin-top: 80px; /* Ajustado para evitar sobreposição com o navbar */
        }
        h2, h3, h4 {
            color: #333;
        }
        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
        }
        h3 {
            margin-bottom: 20px;
        }
        h4 {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #444;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        td {
            font-size: 14px;
            color: #555;
        }
        .nav-link {
            color: #fff;
        }
        .nav-link:hover {
            text-decoration: underline;
        }
        .nav-link.active {
            font-weight: bold;
        }
        /* Estilo para o menu hambúrguer */
        #checkbox-menu {
            position: absolute;
            opacity: 0;
        }

        label {
            cursor: pointer;
            position: absolute;
            left: 10px; /* Ajuste conforme necessário */
            top: 50%;
            transform: translateY(-50%);
            height: 22px;
            width: 30px;
            background: #000;
            padding: 5px;
        }

        label span {
            position: absolute;
            display: block;
            height: 5px;
            width: 100%;
            border-radius: 30px;
            background: #fff;
            transition: 0.25s ease-in-out;
        }

        label span:nth-child(1) {
            top: 0;
        }

        label span:nth-child(2) {
            top: 8px;
        }

        label span:nth-child(3) {
            top: 16px;
        }

        #checkbox-menu:checked + label span:nth-child(1) {
            transform: rotate(-45deg);
            top: 8px;
        }

        #checkbox-menu:checked + label span:nth-child(2) {
            opacity: 0;
        }

        #checkbox-menu:checked + label span:nth-child(3) {
            transform: rotate(45deg);
            top: 8px;
        }

        .menu {
            display: none;
            position: absolute;
            top: 60px;
            left: 0;
            background: #000;
            width: 200px;
            text-align: center;
            z-index: 1000;
        }

        .menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu ul li {
            border-bottom: 1px solid #444;
        }

        .menu ul li a {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            transition: background 0.3s;
        }

        .menu ul li a:hover {
            background: #333;
        }

        #checkbox-menu:checked ~ .menu {
            display: block;
        }

        .navbar-brand {
            margin-left: 50px; /* Ajuste o valor conforme necessário */
        }
    </style>
</head>
<body>
<?php
// Obtendo o destino da página anterior
$localDestino = isset($_GET['localDestino']) ? $_GET['localDestino'] : 'Destino não especificado';
?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <input type="checkbox" id="checkbox-menu">
    <label for="checkbox-menu">
        <span></span>
        <span></span>
        <span></span>
    </label>
    <div class="menu">
    <ul>
    <li><a href="paginaprincipal.php">Início</a></li>
            <li><a href="teste.php">Formulário</a></li>
            <li><a href="local.php">Lista de Pontos</a></li>
            
            <li><a href="linhas.php">Linhas</a></li>
            <li><a href="mapas.php">Rota</a></li>
    </div>
    <a class="navbar-brand" href="paginaprincipal.php">SmartBus</a>
</nav>

<div class="container mt-5">
    <h2 class="mb-4">Informações de Destino</h2>

    <h3>Destino: <?php echo htmlspecialchars($localDestino); ?></h3>

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
