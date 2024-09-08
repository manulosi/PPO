<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBus - Página Principal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
        .navbar {
            background-color: #000;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #fff;
        }
        .navbar-nav .nav-link:hover {
            color: #d3d3d3;
        }
        .hero {
            background-image: url('img/cidades.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            text-align: center;
            padding: 120px 0;
            position: relative;
            box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.5); /* Escurece a imagem de fundo */
        }
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 600;
        }
        .hero p {
            font-size: 1.3rem;
            margin-bottom: 30px;
        }
        .card {
            background-color: #fff;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-title {
            color: #000;
            font-weight: 600;
        }
        .btn-primary {
    background-color: #000;
    border-color: #000;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn-primary:hover {
    background-color: #000;
    border-color: white; /* Garante que a borda também fique escura */
    transform: scale(1.05) rotate(2deg);
}

        .footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        /* Menu Hambúrguer */
        #checkbox-menu {
            position: absolute;
            opacity: 0;
        }
        .menu {
            display: none;
            position: absolute;
            top: 60px;
            left: 0;
            background: #000;
            width: 200px;
            text-align: center;
            z-index: 1000; /* Garante que o menu fique sobre outros elementos */
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
            z-index: 1001; /* Garante que o botão do menu fique sobre outros elementos */
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
        label span:nth-child(1) { top: 0; }
        label span:nth-child(2) { top: 8px; }
        label span:nth-child(3) { top: 16px; }
        #checkbox-menu:checked + label span:nth-child(1) {
            transform: rotate(-45deg); top: 8px;
        }
        #checkbox-menu:checked + label span:nth-child(2) {
            opacity: 0;
        }
        #checkbox-menu:checked + label span:nth-child(3) {
            transform: rotate(45deg); top: 8px;
        }
        .navbar-brand {
            margin-left: 50px;
        }
        .navbar-brand img {
            height: 35px; /* Ajuste a altura da logo conforme necessário */
            margin-right: 10px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <input type="checkbox" id="checkbox-menu">
    <label for="checkbox-menu">
        <span></span>
        <span></span>
        <span></span>
    </label>
    <a class="navbar-brand" href="paginaprincipal.php">
        <img src="img/logo.jpg" alt="SmartBus Logo">
    SmartBus</a>
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

<div class="hero">
    <div class="container">
        <h1>Bem-vindo ao SmartBus</h1>
        <p>O SmartBus é um sistema inovador que fornece informações em tempo real sobre o transporte público.</p>
        <a href="teste.php" class="btn btn-primary">Formulario</a>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sobre o Projeto</h5>
                    <p>O SmartBus facilita sua mobilidade, fornecendo informações em tempo real sobre o transporte público.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Funcionalidades</h5>
                    <ul>
                        <li>Informações em tempo real.</li>
                        <li>Planejamento de trajetos personalizados.</li>
                        <li>Interface amigável.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Entre em Contato</h5>
                    <p>Tem dúvidas ou sugestões? Entre em contato conosco.</p>
                    <a href="contate.php" class="btn btn-primary">Contate-nos</a>
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
