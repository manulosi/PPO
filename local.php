<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pontos de Ônibus em Rio do Sul</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('img/onibus.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
            padding-left: 100px;
        }

        .navbar a {
            color: #fff;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 18px;
        }
        .navbar-brand {
            margin-left: 60px;
        }
        .navbar a:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 800px;
            width: 100%;
            margin-top: 80px;
        }
        .header {
            margin-bottom: 20px;
            text-align: center;
        }
        .header h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
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

        table a {
            color: black; /* Cor padrão do link */
            text-decoration: none; /* Remove o sublinhado dos links */
        }

        table a:hover {
            color: black; /* Cor do link quando o mouse passa sobre ele */
            text-decoration: underline; /* Adiciona um sublinhado ao passar o mouse */
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        #checkbox-menu {
            position: absolute;
            opacity: 0;
        }

        label {
            cursor: pointer;
            position: absolute;
            left: 10px;
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

        .menu-text {
            color: #fff;
            font-size: 18px;
            line-height: 22px;
            position: absolute;
            left: 50px;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <input type="checkbox" id="checkbox-menu">
        <label for="checkbox-menu">
            <span></span>
            <span></span>
            <span></span>
        </label>
        
        <a class="navbar-brand" href="paginaprincipal.php">SmartBus</a>
        <div class="menu">
            <ul>
                <li><a href="paginaprincipal.php">Início</a></li>
                <li><a href="teste.php">Formulário</a></li>
                <li><a href="local.php">Lista de Pontos</a></li>
                <li><a href="linhas.php">Linhas</a></li>
                <li><a href="mapas.php">Rota</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="header">
            <h1>Pontos de Ônibus em Rio do Sul</h1>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Local</th>
                    <th>Rua</th>
                    <th>Ponto de Referência</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="onibus.php?ponto=Centro%20de%20Rio%20do%20Sul">Ponto de Ônibus - Centro de Rio do Sul</a></td>
                    <td><a href="onibus.php?ponto=Centro%20de%20Rio%20do%20Sul">Rua XV de Novembro</a></td>
                    <td><a href="onibus.php?ponto=Centro%20de%20Rio%20do%20Sul">Próximo à Praça Ermembergo Pellizzetti</a></td>
                </tr>
                <tr>
                    <td><a href="onibus.php?ponto=Terminal%20Rodoviário">Ponto de Ônibus - Terminal Rodoviário</a></td>
                    <td><a href="onibus.php?ponto=Terminal%20Rodoviário">Rua Wenceslau Borini</a></td>
                    <td><a href="onibus.php?ponto=Terminal%20Rodoviário">Em frente ao Terminal Rodoviário</a></td>
                </tr>
                <tr>
                    <td><a href="onibus.php?ponto=Navegantes">Ponto de Ônibus - Navegantes</a></td>
                    <td><a href="onibus.php?ponto=Navegantes">Rua Rui Barbosa</a></td>
                    <td><a href="onibus.php?ponto=Navegantes">Próximo à Igreja Navegantes</a></td>
                </tr>
                <tr>
                    <td><a href="onibus.php?ponto=Santana">Ponto de Ônibus - Santana</a></td>
                    <td><a href="onibus.php?ponto=Santana">Rua Dom Bosco</a></td>
                    <td><a href="onibus.php?ponto=Santana">Próximo ao Colégio Dom Bosco</a></td>
                </tr>
                <tr>
                    <td><a href="onibus.php?ponto=Barragem">Ponto de Ônibus - Barragem</a></td>
                    <td><a href="onibus.php?ponto=Barragem">Rua Presidente Kennedy</a></td>
                    <td><a href="onibus.php?ponto=Barragem">Perto da Ponte sobre o Rio Itajaí</a></td>
                </tr>
                <tr>
                    <td><a href="onibus.php?ponto=Canta%20Galo">Ponto de Ônibus - Canta Galo</a></td>
                    <td><a href="onibus.php?ponto=Canta%20Galo">Rua Otto Renaux</a></td>
                    <td><a href="onibus.php?ponto=Canta%20Galo">Próximo ao Mercado Canta Galo</a></td>
                </tr>
                <tr>
                    <td><a href="onibus.php?ponto=Jardim%20América">Ponto de Ônibus - Jardim América</a></td>
                    <td><a href="onibus.php?ponto=Jardim%20América">Rua Anita Garibaldi</a></td>
                    <td><a href="onibus.php?ponto=Jardim%20América">Ao lado do Supermercado América</a></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
