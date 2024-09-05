<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horários de Ônibus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('img/onibus.jpg'); /* Substitua pelo caminho da sua imagem */
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
            width: 100%;
            background-color: #333;
            padding: 15px 0;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
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
            margin-top: 100px; /* Ajuste para descer a tela devido à navbar fixa */
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

        .bus-schedule {
            margin-top: 20px;
        }

        .bus-schedule h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #555;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .schedule-table th,
        .schedule-table td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        .schedule-table th {
            background-color: #333;
            color: #fff;
        }

        .schedule-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .schedule-table tr:hover {
            background-color: #f1f1f1;
        }

        .schedule-table td {
            font-size: 16px;
            color: #555;
        }

        /* Estilo para remover a sublinha do link */
        .schedule-table a {
            text-decoration: none;
            color: inherit;
        }

        .schedule-table a:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <a class="navbar-brand" href="paginaprincipal.php">Horários </a>
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

    <div class="container">
        <div class="header">
            <h1>Horários de Ônibus</h1>
        </div>

        <div class="bus-schedule">
            <h2>Rota: Centro - Bairro X</h2>
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Horário de Partida</th>
                        <th>Horário de Chegada</th>
                        <th>Dias da Semana</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="pag8.php">08:00</a></td>
                        <td>08:30</td>
                        <td>Segunda a Sexta</td>
                    </tr>
                    <tr>
                        <td><a href="pag8.php">09:00</a></td>
                        <td>09:30</td>
                        <td>Segunda a Sexta</td>
                    </tr>
                    <tr>
                        <td><a href="pag8.php">10:00</a></td>
                        <td>10:30</td>
                        <td>Segunda a Sexta</td>
                    </tr>
                    <tr>
                        <td><a href="pag8.php">11:00</a></td>
                        <td>11:30</td>
                        <td>Segunda a Sexta</td>
                    </tr>
                    <tr>
                        <td><a href="pag8.php">12:00</a></td>
                        <td>12:30</td>
                        <td>Segunda a Sexta</td>
                    </tr>
                    <tr>
                        <td><a href="pag8.php">13:00</a></td>
                        <td>13:30</td>
                        <td>Sábado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
