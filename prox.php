<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pontos de Ônibus Próximos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: auto; /* Permite rolar a página */
        }

        .navbar {
            background-color: #000; /* Cor de fundo do menu */
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand, .navbar-nav .nav-link {
            color: #fff; /* Cor do texto */
            margin-left: 60px; /* Ajuste para espaçamento */
        }

        .navbar-nav .nav-link:hover {
            color: #d3d3d3; /* Cor ao passar o mouse */
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            width: 100%;
            margin: 70px auto 20px; /* Ajuste superior para evitar sobreposição com a navbar */
        }

        .header {
            margin-bottom: 20px;
        }

        .header h2 {
            color: #000;
            font-size: 24px;
            animation: fadeIn 2s;
        }

        #map {
            height: 600px; /* Ajustado para uma altura fixa */
            width: 100%;
            max-width: 1000px;
            border: 2px solid #ddd;
            margin: 20px auto;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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

        .btn-primary {
            background-color: #000;
            border-color: #000;
            transition: background-color 0.3s ease, transform 0.3s ease;
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
    <a class="navbar-brand" href="paginaprincipal.php">SmartBus</a>
    <div class="menu">
    <ul>
            <li><a href="paginaprincipal.php">Início</a></li>
            <li><a href="linhas.php">Horários e linhas disponíveis</a></li>
            <li><a href="prox.php">Pontos de ônibus</a></li>
            <li><a href="lista.php">Busca rota online</a></li>
            <li><a href="motorista.php">Motorista</a></li>
        </ul>
    </div>
</nav>

<div class="container text-center">
    <div class="header">
        <h2>Pontos de Ônibus Próximos</h2>
    </div>
    <button onclick="startTrackingLocation()" class="btn btn-primary">Ver Pontos de Ônibus Próximos</button>
    <p id="resultado"></p>
</div>

<div id="map"></div>

<!-- Carregando API do Google Maps -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCb2OqBOY801jMUD7jcI37VGKbhTuF6OC4&callback=initMap"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
      let map;
    let userMarker = null;
    let userMarkerPosition = null;
    let busStopMarkers = [];
    let busStops = [
        { lat: -27.25328, lng: -49.69216, name: 'Condomínio Residencial Marcolino Martinho Felippe' },
        { lat: -27.20161, lng: -49.63158, name: 'Centro/Bairro Rodoviária de Rio do Sul' },
        { lat: -27.20633, lng: -49.62983, name: 'Centro/Bairro Olegário Motors' },
        { lat: -27.20944, lng: -49.62942, name: 'Centro/Bairro Casa do Pão' },
        { lat: -27.21100, lng: -49.63286, name: 'Centro/Bairro Supermercado Imperatriz' },
        { lat: -27.21198, lng: -49.63536, name: 'Centro/Bairro Tokio Veículos' },
        { lat: -27.21361, lng: -49.63692, name: 'Centro/Bairro V3 Automóveis' },
        { lat: -27.21556, lng: -49.64161, name: 'Centro/Bairro Terminal Urbano de Rio do Sul' },
        { lat: -27.22006, lng: -49.64864, name: 'Centro/Bairro Restaurante Crescencio Grill' },
        { lat: -27.22325, lng: -49.65772, name: 'Centro/Bairro Tilapiaria' },
        { lat: -27.22961, lng: -49.66319, name: 'Centro/Bairro Sesc Rio do Sul' },
        { lat: -27.23102, lng: -49.66525, name: 'Centro/Bairro Oficina Mecânica Diesel AB LTDA.' },
        { lat: -27.23603, lng: -49.67272, name: 'Centro/Bairro Ponte pensil BR 470' },
        { lat: -27.23800, lng: -49.67672, name: 'Centro/Bairro Cissa Magazine' },
        { lat: -27.23972, lng: -49.67756, name: 'Centro/Bairro Centro Educacional Prefeito Luiz Adelar Soldatelli' },
        { lat: -27.24139, lng: -49.68028, name: 'Centro/Bairro SENAI Rio do Sul' },
        { lat: -27.24358, lng: -49.68265, name: 'Centro/Bairro Mega Auto Elétrica e Mecânica' },
        { lat: -27.24742, lng: -49.68572, name: 'Centro/Bairro Acesso a Metalúrgica Riosulense' },
        { lat: -27.24803, lng: -49.68748, name: 'Centro/Bairro Ponte de arrame acesso ao Pamplona' },
        { lat: -27.25072, lng: -49.69025, name: 'Centro/Bairro Próximo a Padaria Sabor Em Família' },
        { lat: -27.25133, lng: -49.69097, name: 'Centro/Bairro Panificadora Osélia' },
        { lat: -27.25192, lng: -49.69069, name: 'Centro/Bairro Início da Rua José Demarchi' },
        { lat: -27.25544, lng: -49.69383, name: 'Centro/Bairro Rua Valdemiro da Silva/Rua Sebastião dos Santos' },
        { lat: -27.25842, lng: -49.69377, name: 'Centro/Bairro Condomínio Residencial Marcolino Martinho Felippe' },
        { lat: -27.25752, lng: -49.69319, name: 'Centro/Bairro Rua Valdemiro da Silva/Rua Amadeu Pavanello' },
        { lat: -27.25472, lng: -49.68925, name: 'Centro/Bairro Cruzamento Rua Joaquim Ceruruti/Rua José Demarchi' },
        { lat: -27.25506, lng: -49.68912, name: 'Centro/Bairro Eeb Prof Frederico Navarro Lins' },
        { lat: -27.25634, lng: -49.68918, name: 'Centro/Bairro Início da Alameda Mondai' },
        { lat: -27.25898, lng: -49.68900, name: 'Centro/Bairro Próximo ao Beco Edilson Martin Franco' },
        { lat: -27.25925, lng: -49.68875, name: 'Centro/Bairro 150m depois da entrada do Beco Edilson Martin Franco' },
        { lat: -27.26550, lng: -49.68665, name: 'Centro/Bairro Virador (600m depois da entrada do Beco Edilson Martin Franco)' },
        { lat: -27.26597, lng: -49.68664, name: 'Virador (600m antes da entrada do Beco Edilson Martin Franco)' },
        { lat: -27.26100, lng: -49.68931, name: '150m antes da entrada do Beco Edilson Martin Franco' },
        { lat: -27.26122, lng: -49.68900, name: 'Próximo ao Beco Edilson Martin Franco' },
        { lat: -27.25799, lng: -49.69028, name: 'Início da Alameda Mondai' },
        { lat: -27.25614, lng: -49.69022, name: 'Eeb Prof Frederico Navarro Lins' },
        { lat: -27.25472, lng: -49.69203, name: 'Cruzamento Rua Joaquim Ceruruti/Rua Patrício Noveleto' },
        { lat: -27.25753, lng: -49.69321, name: 'Rua Valdemiro da Silva/Rua Amadeu Pavanello' },
        { lat: -27.25842, lng: -49.69377, name: 'Condomínio Residencial Marcolino Martinho Felippe' },
        { lat: -27.25544, lng: -49.69382, name: 'Rua Valdemiro da Silva/Rua Sebastião dos Santos' },
        { lat: -27.25381, lng: -49.69292, name: 'Início da Rua José Demarchi' },
        { lat: -27.25244, lng: -49.69153, name: 'Panificadora Osélia' },
        { lat: -27.25072, lng: -49.69025, name: 'Próximo a Padaria Sabor Em Família' },
        { lat: -27.24911, lng: -49.68748, name: 'Ponte de arrame acesso ao Pamplona' },
        { lat: -27.24742, lng: -49.68572, name: 'Acesso a Metalúrgica Riosulense' },
        { lat: -27.24358, lng: -49.68265, name: 'Mega Auto Elétrica e Mecânica' },
        { lat: -27.24139, lng: -49.68028, name: 'SENAI Rio do Sul' },
        { lat: -27.23972, lng: -49.67756, name: 'Centro Educacional Prefeito Luiz Adelar Soldatelli' },
        { lat: -27.23800, lng: -49.67672, name: 'Cissa Magazine' },
        { lat: -27.23603, lng: -49.67272, name: 'Ponte pensil BR 470' },
        { lat: -27.23489, lng: -49.66954, name: 'Posto Pilão - Barragem' },
        { lat: -27.23375, lng: -49.66789, name: 'Após o Posto Pilão - Barragem' },
        { lat: -27.22961, lng: -49.66319, name: 'Sesc Rio do Sul' },
        { lat: -27.22786, lng: -49.66142, name: 'Mercado Steffen' },
        { lat: -27.22325, lng: -49.65772, name: 'Próximo a Tilapiaria' },
        { lat: -27.22109, lng: -49.64858, name: 'Fundação Cultural de Rio do Sul' },
        { lat: -27.21958, lng: -49.64453, name: 'Ponto Hospital Regional' },
        { lat: -27.21556, lng: -49.64161, name: 'Terminal Urbano de Rio do Sul' },
        { lat: -27.20192, lng: -49.63144, name: 'Rodoviaria de Rio do Sul' },
        { lat: -27.20633, lng: -49.62983, name: 'Centro/Bairro Olegário Motors' },
        { lat: -27.20944, lng: -49.62942, name: 'Centro/Bairro Casa do Pão' },
        { lat: -27.21100, lng: -49.63286, name: 'Centro/Bairro Supermercado Imperatriz' },
        { lat: -27.21198, lng: -49.63536, name: 'Centro/Bairro Tokio Veículos' },
        { lat: -27.21361, lng: -49.63692, name: 'Centro/Bairro V3 Automóveis' },
        { lat: -27.21556, lng: -49.64161, name: 'Centro/Bairro Terminal Rodoviário De Rio Do Sul' },
        { lat: -27.22083, lng: -49.65044, name: 'Em frente ao Restaurante do Moacir - Canoas' },
        { lat: -27.22081, lng: -49.65411, name: 'Antes do Mário Multimarcas' },
        { lat: -27.22153, lng: -49.65906, name: 'Em frente ao DEINFRA' },
        { lat: -27.22569, lng: -49.66572, name: 'Jardim Alexander' },
        { lat: -27.22472, lng: -49.66589, name: 'Início da Rua Câmara Junior' },
        { lat: -27.22444, lng: -49.66781, name: 'Rua Peroba/Rua Sassafrás' },
        { lat: -27.23017, lng: -49.66753, name: 'Em frente a Polimix Concreto' },
        { lat: -27.23308, lng: -49.67275, name: 'Ponte pensil' },
        { lat: -27.23986, lng: -49.68498, name: 'Pamplona' },
        { lat: -27.24125, lng: -49.69439, name: 'Ponte de acesso a Barra do Trombudo' },
        { lat: -27.25333, lng: -49.69222, name: 'Centro de Educação Infantil Ilse Soldatelli' },
        { lat: -27.25264, lng: -49.69175, name: 'Em frente a Panificadora Osélia' },
        { lat: -27.24653, lng: -49.69453, name: 'Trevo de acesso a Barra do Trombudo' },
        { lat: -27.23986, lng: -49.68498, name: 'Pamplona' },
        { lat: -27.23017, lng: -49.66753, name: 'Em frente a Polimix Concreto' },
        { lat: -27.23308, lng: -49.67275, name: 'Ponte pensil' },
        { lat: -27.22569, lng: -49.66572, name: 'Ponto antes do Jardim Alexander' },
        { lat: -27.22153, lng: -49.65906, name: 'Em frente ao DEINFRA' },
        { lat: -27.22089, lng: -49.65403, name: 'Metálica Canoas' },
        { lat: -27.21972, lng: -49.65081, name: 'Em frente ao Posto Brasília - Canoas' },
        { lat: -27.21556, lng: -49.64161, name: 'Terminal Urbano de Rio do Sul' },
        { lat: -27.21381, lng: -49.63756, name: 'Rede Feminina de Combate ao Câncer de Rio do Sul' },
        { lat: -27.21275, lng: -49.63528, name: 'Taliano Motos' },
        { lat: -27.21122, lng: -49.63192, name: 'Centro Educacional Sebastião Back' },
        { lat: -27.21221, lng: -49.62989, name: 'Busarello Comércio de Veículos' },
        { lat: -27.21269, lng: -49.62803, name: 'Supermercado Rabelo' },
        { lat: -27.20158, lng: -49.63104, name: 'Rodoviária de Rio do Sul' },
        { lat: -27.18878, lng: -49.58103, name: 'Entrada da Alameda Ernesto Michelson' },
        { lat: -27.18889, lng: -49.58339, name: 'Dancin Days Bar & Boate/EEB Willy Hering' },
        { lat: -27.18858, lng: -49.58656, name: 'Igreja Evangelica Assembleia de Deus de Bela Aliança' },
        { lat: -27.18825, lng: -49.58783, name: 'Mercado Zeferino Ltda (pão e cia)' },
        { lat: -27.18825, lng: -49.58756, name: 'Entrada da Rua Arnoldo Wutzow' },
        { lat: -27.18958, lng: -49.59144, name: 'Posto Bela Aliança' },
        { lat: -27.18950, lng: -49.59370, name: 'Capela São Sebastião' },
        { lat: -27.18944, lng: -49.59972, name: 'Entrada da Royal Ciclo' },
        { lat: -27.18922, lng: -49.59689, name: 'Royal Ciclo' },
        { lat: -27.19119, lng: -49.59975, name: 'Entrada da Rua João Nascheweng' },
        { lat: -27.19178, lng: -49.60117, name: 'Refrigeração e Climatização Breemer' },
        { lat: -27.19239, lng: -49.60331, name: 'Ponto de ônibus antes da Ponte Pensil' },
        { lat: -27.19381, lng: -49.60539, name: 'Entrada da Estrada Quintino' },
        { lat: -27.19411, lng: -49.60881, name: 'Entrada da Rua Ferdinando Jahn' },
        { lat: -27.19419, lng: -49.61081, name: 'Fundisul' },
        { lat: -27.19506, lng: -49.61275, name: 'Entrada da Rua Brusque' },
        { lat: -27.19567, lng: -49.61497, name: 'ICAL (Início da Alameda Itapema)' },
        { lat: -27.19644, lng: -49.61681, name: 'Contabilidade Wagner' },
        { lat: -27.20011, lng: -49.61867, name: 'Próximo as Calhas Taboão' },
        { lat: -27.20286, lng: -49.61997, name: 'Entrada da Rua João Fronza' },
        { lat: -27.20753, lng: -49.62425, name: '70m depois da Casa do Pão e Café' },
        { lat: -27.20944, lng: -49.62942, name: 'Casa do Pão' },
        { lat: -27.21099, lng: -49.63286, name: 'Supermercado Imperatriz' },
        { lat: -27.21191, lng: -49.63531, name: 'Tokio Veículos' },
        { lat: -27.21361, lng: -49.63831, name: 'V3 Automóveis' },
        { lat: -27.21556, lng: -49.64161, name: 'Terminal Urbano de Rio do Sul' },
        { lat: -27.22006, lng: -49.64864, name: 'Restaurante Crescencio Grill' },
        { lat: -27.22611, lng: -49.65822, name: 'Garagem Ônibus Circular LTDA.' },
        { lat: -27.22225, lng: -49.64801, name: 'Fundação Cultural de Rio do Sul' },
        { lat: -27.21989, lng: -49.64444, name: 'Ponto Hospital Regional' },
        { lat: -27.21561, lng: -49.64197, name: 'Terminal Urbano de Rio do Sul' },
        { lat: -27.21381, lng: -49.63756, name: 'Rede Feminina de Combate ao Câncer de Rio do Sul' },
        { lat: -27.21275, lng: -49.63531, name: 'Taliano Motos' },
        { lat: -27.21122, lng: -49.63192, name: 'Centro Educacional Sebastião Back' },
        { lat: -27.21028, lng: -49.62989, name: 'Busarello Comércio de Veículos' },
        { lat: -27.20936, lng: -49.62803, name: 'Supermercado Rabelo' },
        { lat: -27.20753, lng: -49.62425, name: 'Próximo a Casa do Pão e Café' },
        { lat: -27.20533, lng: -49.61967, name: 'Próximo ao Mercado Rossetti' },
        { lat: -27.20775, lng: -49.61844, name: 'Panificadora HS' },
        { lat: -27.21236, lng: -49.61608, name: 'Agropet Taboão' },
        { lat: -27.21683, lng: -49.61436, name: 'Entrada da Rua do Centro Educacional Willy Schleumer' },
        { lat: -27.21839, lng: -49.6135, name: 'Centro de Educação Infantil Pinguinho de Gente' },
        { lat: -27.22172, lng: -49.61272, name: '2C-1 Taboão Centro/Bairro Início da Rua Ambrósio Vieria' },
        { lat: -27.22547, lng: -49.61297, name: '2C-1 Taboão Centro/Bairro Próximo ao Disk Gás Fronza Gás' },
        { lat: -27.22753, lng: -49.61358, name: '2C-1 Taboão Centro/Bairro 150m depois do Disk Gás Fronza Gás' },
        { lat: -27.22953, lng: -49.61399, name: '2C-1 Taboão Centro/Bairro 100m antes Stolf Auto Elétrica' },
        { lat: -27.23336, lng: -49.61344, name: '2C-1 Taboão Centro/Bairro 100m antes da Igreja Nossa Senhora Do Rosário' },
        { lat: -27.23714, lng: -49.61333, name: '2C-1 Taboão Centro/Bairro 350m depois Igreja Nossa Senhora Do Rosário' },
        { lat: -27.24011, lng: -49.60975, name: '2C-1 Taboão Centro/Bairro 800m depois Igreja Nossa Senhora Do Rosário' },
        { lat: -27.24277, lng: -49.60859, name: '2C-1 Taboão Centro/Bairro Início da Rua Dezesseis' },
        { lat: -27.24542, lng: -49.60747, name: '2C-1 Taboão Centro/Bairro Conservas F&G' },
        { lat: -27.24739, lng: -49.60686, name: '2C-1 Taboão Centro/Bairro 250m depois das Conservas F&G' },
        { lat: -27.25028, lng: -49.60647, name: '2C-1 Taboão Centro/Bairro 500m depois das Conservas F&G' },
        { lat: -27.2533, lng: -49.60365, name: '2C-1 Taboão Centro/Bairro 1km depois das Conservas F&G' },
        { lat: -27.2535, lng: -49.60069, name: '2C-1 Taboão Centro/Bairro 1,5km depois das Conservas F&G' },
        { lat: -27.2535, lng: -49.60069, name: '2C-1 Taboão Bairro/Centro 1,5km antes das Conservas F&G' },
        { lat: -27.2533, lng: -49.60365, name: '2C-1 Taboão Bairro/Centro 1km antes das Conservas F&G' },
        { lat: -27.25028, lng: -49.60647, name: '2C-1 Taboão Bairro/Centro 500m antes das Conservas F&G' },
        { lat: -27.24739, lng: -49.60686, name: '2C-1 Taboão Bairro/Centro 250m antes das Conservas F&G' },
        { lat: -27.24542, lng: -49.60747, name: '2C-1 Taboão Bairro/Centro Conservas F&G' },
        { lat: -27.24277, lng: -49.60859, name: '2C-1 Taboão Bairro/Centro Início da Rua Dezesseis' },
        { lat: -27.24119, lng: -49.60933, name: '2C-1 Taboão Bairro/Centro 1km antes Igreja Nossa Senhora Do Rosário' },
        { lat: -27.23714, lng: -49.61333, name: '2C-1 Taboão Bairro/Centro 350m antes Igreja Nossa Senhora Do Rosário' },
        { lat: -27.23449, lng: -49.61328, name: '2C-1 Taboão Bairro/Centro Igreja Nossa Senhora Do Rosário' },
        { lat: -27.23244, lng: -49.61361, name: '2C-1 Taboão Bairro/Centro 250m depois da Igreja Nossa Senhora Do Rosário' },
        { lat: -27.22547, lng: -49.61297, name: '2C-1 Taboão Bairro/Centro Próximo ao Disk Gás Fronza Gás' },
        { lat: -27.22172, lng: -49.61272, name: '2C-1 Taboão Bairro/Centro Início da Rua Ambrósio Vieria' },
        { lat: -27.21839, lng: -49.6135, name: '2C-1 Taboão Bairro/Centro Centro de Educação Infantil Pinguinho de Gente' },
        { lat: -27.21683, lng: -49.61413, name: '2C-1 Taboão Bairro/Centro Entrada da Rua do Centro Educacional Willy Schleumer' },
        { lat: -27.21244, lng: -49.61597, name: '2C-1 Taboão Bairro/Centro Agropet Taboão' },
        { lat: -27.20795, lng: -49.61822, name: '2C-1 Taboão Bairro/Centro Minimercado Schaidt' },
        { lat: -27.20531, lng: -49.61975, name: '2C-1 Taboão Bairro/Centro CTM Eletrônica e Automação Industrial' },
        { lat: -27.20753, lng: -49.62309, name: '2C-1 Taboão Bairro/Centro Em frente a Box34 reforma de rodas' },
        { lat: -27.20944, lng: -49.62942, name: '2C-1 Taboão Bairro/Centro Casa do Pão' },
        { lat: -27.211, lng: -49.63286, name: '2C-1 Taboão Bairro/Centro Supermercado Imperatriz' },
        { lat: -27.21189, lng: -49.63536, name: '2C-1 Taboão Bairro/Centro Tokio Veículos' },
        { lat: -27.21361, lng: -49.63858, name: '2C-1 Taboão Bairro/Centro V3 Automóveis' },
        { lat: -27.21567, lng: -49.64197, name: '2C-1 Taboão Bairro/Centro Terminal Rodoviário De Rio Do Sul' },
        { lat: -27.22011, lng: -49.64861, name: '2C-1 Taboão Bairro/Centro Restaurante Crescencio Grill' },
        { lat: -27.19111, lng: -49.61944, name: 'Eligemar Camisaria' },
        { lat: -27.19394, lng: -49.62472, name: 'Polo Shopping' },
        { lat: -27.19672, lng: -49.62781, name: 'AudioFrahm' },
        { lat: -27.19844, lng: -49.62969, name: 'Hotel Demarchi' },
        { lat: -27.20194, lng: -49.63139, name: 'Rodoviária de Rio do Sul' },
        { lat: -27.20467, lng: -49.64208, name: 'Unidas Veículos' },
        { lat: -27.20508, lng: -49.64178, name: 'Monte Olimpo Jeans' },
        { lat: -27.20639, lng: -49.65553, name: 'Neilar Indústria e Comércio Alimentos Ltda' },
        { lat: -27.21403, lng: -49.65050, name: 'Ginásio Municipal Artenir Werner' },
        { lat: -27.21681, lng: -49.64994, name: 'Próximo ao Kebo Motos' },
        { lat: -27.22108, lng: -49.64856, name: 'Fundação Cultural de Rio do Sul' },
        { lat: -27.21961, lng: -49.64450, name: 'Ponto Hospital Regional' },
        { lat: -27.21556, lng: -49.64161, name: 'Terminal Urbano de Rio do Sul' },
        { lat: -27.21561, lng: -49.64198, name: 'Terminal Urbano de Rio do Sul (via Bairro Navegantes)' },
        { lat: -27.21381, lng: -49.63756, name: 'Rede Feminina de Combate ao Câncer de Rio do Sul' },
        { lat: -27.21272, lng: -49.63417, name: 'Taliano Motos' },
        { lat: -27.21122, lng: -49.63136, name: 'Centro Educacional Sebastião Back' },
        { lat: -27.21028, lng: -49.62989, name: 'Busarello Comércio de Veículos' },
        { lat: -27.20936, lng: -49.62769, name: 'Supermercado Rabelo' },
        { lat: -27.20536, lng: -49.63019, name: 'CELESC' },
        { lat: -27.20194, lng: -49.63139, name: 'Rodoviária de Rio do Sul (via Bairro Navegantes)' },
        { lat: -27.19944, lng: -49.62964, name: 'Hotéis Pamplona' },
        { lat: -27.19692, lng: -49.62744, name: 'Posto Brasília' },
        { lat: -27.19489, lng: -49.62467, name: 'Borba Car' },
        { lat: -27.19200, lng: -49.62164, name: 'Eligemar Camisaria (via Bairro Navegantes)' },
        { lat: -27.18931, lng: -49.60667, name: 'Mercado Esculator (Estrada Navegantes)' },
        { lat: -27.18928, lng: -49.60525, name: 'Próximo ao Centro de Educação Infantil Navegantes' },
        { lat: -27.18114, lng: -49.59456, name: '200m antes do acesso a BR 470' },
        { lat: -27.18292, lng: -49.60175, name: 'Daksul Jeans' },
        { lat: -27.17983, lng: -49.60250, name: 'Centro Educacional Ricardo Marchi' },
        { lat: -27.17531, lng: -49.60378, name: 'Mercado Medeiros' },
        { lat: -27.17411, lng: -49.60233, name: '150m do início da Rua João Marchi (á direita)' },
        { lat: -27.17531, lng: -49.59308, name: 'Padaria e Lanchonete Duvimon' },
        { lat: -27.17533, lng: -49.59075, name: 'Trevo da Metalúrgica Tonon' },
        { lat: -27.17878, lng: -49.58431, name: 'Centro Educacional Guilherme Butzke' },
        { lat: -27.18328, lng: -49.58342, name: 'Entarda da Rua Missisipe' },
        { lat: -27.18411, lng: -49.58308, name: 'Residencial Augusto Fenski' },
        { lat: -27.18475, lng: -49.58308, name: 'Residencial Augusto Fenski (via Canoas)' },
        { lat: -27.20506, lng: -49.65758, name: 'Posto Shell' },
        { lat: -27.20428, lng: -49.66000, name: 'Próximo ao Cemitério Memorial Jardim Primavera' },
        { lat: -27.20299, lng: -49.66325, name: 'Próximo a Otimiza Soldas e Arthur Restaurante' },
        { lat: -27.20236, lng: -49.66631, name: 'Em frente a Agropecuária AgroSchreiber' },
        { lat: -27.20139, lng: -49.66900, name: 'Em frente a Vice Verso Confecções' },
        { lat: -27.20069, lng: -49.67136, name: 'Capela Santa Catarina' },
        { lat: -27.20061, lng: -49.67350, name: 'Centro de Educação Infantil Dr. Romão Trauczynski' },
        { lat: -27.20406, lng: -49.67842, name: '80m depois da entrada da Rua Luiz Olímpio Ferrari' },
        { lat: -27.20483, lng: -49.68222, name: 'Bifurcação entre a Rua Oscar Strey e Estrada Braço Canoas' },
        { lat: -27.20558, lng: -49.68475, name: '200m depois da entrada da Estrada Braço Canoas' },
        { lat: -27.20550, lng: -49.68616, name: '400m depois da entrada da Estrada do Braço Canoas' },
        { lat: -27.19978, lng: -49.67392, name: 'Altermed - Material Médico Hospitalar' },
        { lat: -27.19838, lng: -49.67489, name: 'EEB Francisco Altamir Wagner' },
        { lat: -27.19504, lng: -49.67944, name: '650m depois da EEB Francisco Altamir Wagner' },
        { lat: -27.19369, lng: -49.68153, name: 'Em frente a Mecânica Nardelli' },
        { lat: -27.19088, lng: -49.68637, name: '550m depois da Mecânica Nardelli' },
        { lat: -27.18642, lng: -49.68889, name: '1km depois da Mecânica Nardelli' },
        { lat: -27.18261, lng: -49.69100, name: '1km antes da Di Marcy Confecções' },
        { lat: -27.17883, lng: -49.69108, name: '650m antes da Di Marcy Confecções' },
        { lat: -27.17497, lng: -49.69214, name: '200m antes da Di Marcy Confecções' },
        { lat: -27.17497, lng: -49.69214, name: '200m depois da Di Marcy Confecções' },
        { lat: -27.17883, lng: -49.69108, name: '650m depois da Di Marcy Confecções' },
        { lat: -27.18261, lng: -49.69100, name: '1km depois da Di Marcy Confecções' },
        { lat: -27.19088, lng: -49.68637, name: '550m antes da Mecânica Nardelli' },
        { lat: -27.19369, lng: -49.68153, name: 'Em frente a Mecânica Nardelli' },
        { lat: -27.19504, lng: -49.67944, name: '650m antes da EEB Francisco Altamir Wagner' },
        { lat: -27.19838, lng: -49.67489, name: 'EEB Francisco Altamir Wagner' },
        { lat: -27.19978, lng: -49.67392, name: 'Altermed - Material Médico Hospitalar' },
        { lat: -27.20550, lng: -49.68616, name: '400m antes da entrada da Estrada do Braço Canoas' },
        { lat: -27.20558, lng: -49.68475, name: '200m antes da entrada da Estrada Braço Canoas' },
        { lat: -27.20558, lng: -49.68475, name: '200m depois da entrada da Estrada Braço Canoas' },
        { lat: -27.20406, lng: -49.67842, name: '80m antes da entrada da Rua Luiz Olímpio Ferrari' },
        { lat: -27.20061, lng: -49.67350, name: 'Centro de Educação Infantil Dr. Romão Trauczynski' },
        { lat: -27.20069, lng: -49.67136, name: 'Capela Santa Catarina' },
        { lat: -27.20139, lng: -49.66900, name: 'Vice Verso Confecções' },
        { lat: -27.20236, lng: -49.66631, name: 'Agropecuária AgroSchreiber' },
        { lat: -27.20299, lng: -49.66325, name: 'Próximo a Otimiza Soldas e Arthur Restaurante' },
        { lat: -27.20428, lng: -49.66000, name: 'Próximo ao Cemitério Memorial Jardim Primavera' },
        { lat: -27.20506, lng: -49.65758, name: 'Posto Shell' },
        { lat: -27.15536, lng: -49.68969, name: '2km antes do Sitio Barnabé' },
        { lat: -27.14614, lng: -49.69261, name: '1km antes do Sitio Barnabé' },
        { lat: -27.14758, lng: -49.70497, name: '500m depois do Refúgio Edelweiss' },
        { lat: -27.15291, lng: -49.71108, name: '1,3km depois do Refúgio Edelweiss (a direita)' },
        { lat: -27.15763, lng: -49.70792, name: '2km depois do Refúgio Edelweiss (a direita)' },
        { lat: -27.16750, lng: -49.70600, name: '2km antes de Presidio Regional de Rio do Sul' },
        { lat: -27.17975, lng: -49.70247, name: '250m antes do Presidio Regional de Rio do Sul' },
        { lat: -27.18519, lng: -49.70189, name: '250m antes da CDL de Rio do Sul' },
        { lat: -27.18694, lng: -49.69958, name: 'Chalé Pachamama' },
        { lat: -27.19365, lng: -49.68069, name: 'Mecânica Nardelli' },
        { lat: -27.19503, lng: -49.67944, name: '650m antes da EEB Francisco Altamir Wagner' },
        { lat: -27.19838, lng: -49.67433, name: 'EEB Francisco Altamir Wagner' },
        { lat: -27.19978, lng: -49.67280, name: 'Altermed - Material Médico Hospitalar' },
        { lat: -27.20236, lng: -49.66630, name: 'Agropecuária AgroSchreiber' },
        { lat: -27.20291, lng: -49.66325, name: 'Próximo a Otimiza Soldas e Arthur Restaurante' },
        { lat: -27.20428, lng: -49.65986, name: 'Próximo ao Cemitério Memorial Jardim Primavera' },
        { lat: -27.20505, lng: -49.65758, name: 'Em frente ao Posto Shell' },
        { lat: -27.20550, lng: -49.65569, name: 'Neilar Indústria e Comércio Alimentos Ltda' },
        { lat: -27.20847, lng: -49.65325, name: 'Em frente ao Brasil Atacadista' },
        { lat: -27.20519, lng: -49.64211, name: 'Próximo a Nissan Vip Car Rio do Sul' },
        { lat: -27.20162, lng: -49.63158, name: 'Rodoviária de Rio do Sul' },
        { lat: -27.20633, lng: -49.62983, name: 'Olegário Motors' },
        { lat: -27.20945, lng: -49.62942, name: 'Casa do Pão' },
        { lat: -27.21098, lng: -49.63397, name: 'Supermercado Imperatriz' },
        { lat: -27.21210, lng: -49.63536, name: 'Tokio Veículos' },
        { lat: -27.21361, lng: -49.63858, name: 'V3 Automóveis' },
        { lat: -27.21555, lng: -49.64161, name: 'Terminal Urbano de Rio do Sul' },
        { lat: -27.20241, lng: -49.63180, name: 'Rodoviária de Rio do Sul (4C)' },
        { lat: -27.20339, lng: -49.63136, name: 'Fiat Ravena (4C)' },
        { lat: -27.20633, lng: -49.62983, name: 'Olegário Motors (4C)' },
        { lat: -27.20945, lng: -49.62942, name: 'Casa do Pão (4C)' },
        { lat: -27.21098, lng: -49.63397, name: 'Supermercado Imperatriz (4C)' },
        { lat: -27.21210, lng: -49.63536, name: 'Tokio Veículos (4C)' },
        { lat: -27.21361, lng: -49.63858, name: 'V3 Automóveis (4C)' },
        { lat: -27.21555, lng: -49.64161, name: 'Terminal Urbano de Rio do Sul (4C)' },
        { lat: -27.21744, lng: -49.65011, name: 'Duda Pet Shop (4C)' },
        { lat: -27.21403, lng: -49.65050, name: 'Ginásio Municipal Artenir Werner (4C)' },
        { lat: -27.21189, lng: -49.65017, name: 'Próximo ao Mercado Maicon (4C)' },
        { lat: -27.20880, lng: -49.65327, name: 'Início da Rua Benedito Novo (4C)' },
        { lat: -27.20986, lng: -49.65400, name: 'Cruzamento das Ruas Benedito Novo e Rua Edésio Luiz de Amorim (4C)' },
        { lat: -27.21402, lng: -49.65669, name: 'Início da Rua Santa Rita de Cássia (4C)' },
        { lat: -27.21458, lng: -49.65844, name: '150m antes do Vendas Jaque (4C)' },
        { lat: -27.21250, lng: -49.66199, name: 'Início da Rua Tulio Cezar Macedo (4C)' },
        { lat: -27.21205, lng: -49.66456, name: 'Próximo ao Campo de Futebol Guarani (4C)' },
        { lat: -27.21271, lng: -49.66506, name: 'Em frente ao Campo de Futebol Guarani (4C)' },
        { lat: -27.21205, lng: -49.66661, name: 'Conferência de São Vicente de Paulo (4C)' },
        { lat: -27.21077, lng: -49.66783, name: 'Próximo Centro Educacional Padre Ângelo Moser (4C)' },
        { lat: -27.21105, lng: -49.66814, name: 'Início da Rua Dom João VI (4C)' },
        { lat: -27.21161, lng: -49.66736, name: 'Início da Rua das Palmeiras (4C)' },
        { lat: -27.21160, lng: -49.66703, name: 'Início da Rua das Palmeiras (4C - Retorno)' },
        { lat: -27.21105, lng: -49.66814, name: 'Início da Rua Dom João VI (4C - Retorno)' },
        { lat: -27.21205, lng: -49.66661, name: 'Conferência de São Vicente de Paulo (4C - Retorno)' },
        { lat: -27.21271, lng: -49.66506, name: 'Em frente ao Campo de Futebol Guarani (4C - Retorno)' },
        { lat: -27.21205, lng: -49.66456, name: 'Próximo ao Campo de Futebol Guarani (4C - Retorno)' },
        { lat: -27.21250, lng: -49.66199, name: 'Início da Rua Tulio Cezar Macedo (4C - Retorno)' },
        { lat: -27.21458, lng: -49.65844, name: '150m depois do Vendas Jaque (4C - Retorno)' },
        { lat: -27.21450, lng: -49.65708, name: 'Fim da Rua Benedito Novo (4C - Retorno)' },
        { lat: -27.21135, lng: -49.65536, name: '50m antes do Inicio da Rua Angelo M. Vieira (4C - Retorno)' },
        { lat: -27.20986, lng: -49.65400, name: 'Cruzamento das Ruas Benedito Novo e Rua Edésio Luiz de Amorim (4C - Retorno)' },
        { lat: -27.20880, lng: -49.65327, name: 'Início da Rua Benedito Novo (4C - Retorno)' },
        { lat: -27.20650, lng: -49.64725, name: 'Próximo a Auto Elétrica GT (4C - Retorno)' },
        { lat: -27.20505, lng: -49.64175, name: 'Em frente a Loja Monte Olimpo Jeans (4C - Retorno)' },
        { lat: -27.20451, lng: -49.63610, name: 'Próximo a CASAN BR-470 (4C - Retorno)' },
        { lat: -27.22611, lng: -49.65822, name: 'Garagem Ônibus Circular LTDA.' },
        { lat: -27.22225, lng: -49.64800, name: 'Fundação Cultural de Rio do Sul' },
        { lat: -27.21561, lng: -49.64253, name: 'Terminal Urbano de Rio do Sul' },
        { lat: -27.21381, lng: -49.63756, name: 'Rede Feminina de Combate ao Câncer de Rio do Sul' },
        { lat: -27.21275, lng: -49.63528, name: 'Taliano Motos' },
        { lat: -27.21122, lng: -49.63192, name: 'Centro Educacional Sebastião Back' },
        { lat: -27.21028, lng: -49.62988, name: 'Busarello Comércio de Veículos' },
        { lat: -27.20936, lng: -49.62803, name: 'Supermercado Rabelo' },
        { lat: -27.20633, lng: -49.62983, name: 'Em frente a Olegário Motors' },
        { lat: -27.20161, lng: -49.63158, name: 'Rodoviária de Rio do Sul' },
        { lat: -27.19786, lng: -49.62903, name: 'Próximo ao Fabricenter' },
        { lat: -27.19425, lng: -49.62387, name: 'Borba Car Veículos' },
        { lat: -27.18850, lng: -49.61308, name: 'Próximo ao Feirão da Camiseta' },
        { lat: -27.18692, lng: -49.60756, name: 'Próximo a Rodo Rio Acessórios e Peças' },
        { lat: -27.18339, lng: -49.60236, name: 'Vandemaq/Andressa Maschio Moda' },
        { lat: -27.17920, lng: -49.59617, name: 'Próximo a Fan Prust Jeans' },
        { lat: -27.17544, lng: -49.59292, name: 'Próximo a Farmácia Primer' },
        { lat: -27.17461, lng: -49.59683, name: '250m depois do Mercado Sonntag' },
        { lat: -27.17252, lng: -49.59811, name: '250m depois da Clau&Tiqta' },
        { lat: -27.17008, lng: -49.59983, name: 'Inicio da Estrada Morro Funi' },
        { lat: -27.16881, lng: -49.59986, name: 'Em frente ao Salão de Beleza Flor de Lis' },
        { lat: -27.16789, lng: -49.60011, name: '150m antes da Confeitaria Dona Linda' },
        { lat: -27.16697, lng: -49.60033, name: 'Rua Prefeito A Soldatéli/Rua Antonio Dolzani' },
        { lat: -27.16241, lng: -49.60503, name: '170m depois da Comunidade Nossa Senhora Aparecida' },
        { lat: -27.15966, lng: -49.60717, name: 'Entrada da Lavanderia Cristal' },
        { lat: -27.15769, lng: -49.61122, name: 'Próximo a entrada da Rua da Sperandio Eletrica' },
        { lat: -27.14997, lng: -49.61658, name: '150m antes do Sítio Sardá' },
        { lat: -27.14595, lng: -49.62011, name: 'Igreja São Paulo Apóstolo' },
        { lat: -27.14839, lng: -49.61836, name: '250m depois da Igreja São Paulo Apóstolo' },
        { lat: -27.14936, lng: -49.61772, name: "Sítio Sardá" },
        { lat: -27.14969, lng: -49.61603, name: "100m depois do Sítio Sardá" },
        { lat: -27.15172, lng: -49.61603, name: "150m antes dos Vinhos Molinari" },
        { lat: -27.15261, lng: -49.61598, name: "160m depois dos Vinhos Molinari" },
        { lat: -27.15609, lng: -49.61080, name: "250m depois da entrada da Sperandio Eletrica" },
        { lat: -27.15800, lng: -49.61056, name: "90m antes da Lavanderia Cristal" },
        { lat: -27.16101, lng: -49.60578, name: "Peixer Confecções" },
        { lat: -27.16400, lng: -49.60367, name: "Comunidade Nossa Senhora Aparecida" },
        { lat: -27.16540, lng: -49.60157, name: "200m antes da entrada da Rua Antonio Dolzani" },
        { lat: -27.16683, lng: -49.60047, name: "Entrada da Rua Antonio Dolzani" },
        { lat: -27.16756, lng: -49.60008, name: "150m antes do Salão de Beleza Flor de Lis" },
        { lat: -27.16834, lng: -49.60003, name: "Entrada da estrada do Morro do Funi" },
        { lat: -27.16923, lng: -49.59812, name: "Clau&Tiqta" },
        { lat: -27.17100, lng: -49.59290, name: "Próximo a Farmácia Primer" },
        { lat: -27.17180, lng: -49.58738, name: "130m depois do inicio da Rua Leopoldo Kurth" },
        { lat: -27.17265, lng: -49.58674, name: "Rua Leopodo Kurth/Rua Arnoudo Hoffmann" },
        { lat: -27.17348, lng: -49.58610, name: "Rua Leopodo Kurth/Estrada Willand Kurth" },
        { lat: -27.17429, lng: -49.58562, name: "Rua Leopodo Kurth/Rua Teodoro Morastoni" },
        { lat: -27.17533, lng: -49.58514, name: "Inicio da Rua Missisipe" },
        { lat: -27.17533, lng: -49.58519, name: "Residencial Augusto Fenski" },
        { lat: -27.17533, lng: -49.58519, name: "Inicio da Rua Missisipe" },
        { lat: -27.17429, lng: -49.58562, name: "Rua Leopodo Kurth/Rua Teodoro Morastoni" },
        { lat: -27.17348, lng: -49.58610, name: "Rua Leopodo Kurth/Estrada Willand Kurth" },
        { lat: -27.17265, lng: -49.58674, name: "Rua Leopodo Kurth/Rua Arnoudo Hoffmann" },
        { lat: -27.17180, lng: -49.58738, name: "130m depois do inicio da Rua Leopoldo Kurth" },
        { lat: -27.17162, lng: -49.58517, name: "Inicio da Rua Arnoldo Hoffmann" },
        { lat: -27.17189, lng: -49.58600, name: "Próximo a Escola Modelo Ella Kurth" },
        { lat: -27.17168, lng: -49.58600, name: "100m do Acesso a BR 470" },
        { lat: -27.17084, lng: -49.58285, name: "Toca da Raposa" },
        { lat: -27.17139, lng: -49.58324, name: "W. Breitkopf Comércio de Veículos Automotores" },
        { lat: -27.17250, lng: -49.58708, name: "Trevo da Metalúrgica Tonon" },
        { lat: -27.17300, lng: -49.59309, name: "Em frente a Dicave" },
        { lat: -27.17373, lng: -49.59540, name: "Próximo a Fan Prust Jeans" },
        { lat: -27.17410, lng: -49.60206, name: "Em frente a Daksul Jeans" },
        { lat: -27.17427, lng: -49.60344, name: "Próximo a MS Mecânica Diesel" },
        { lat: -27.17419, lng: -49.60644, name: "Papa Tuti Jeans" },
        { lat: -27.17404, lng: -49.61059, name: "Próximo ao Feirão da Camiseta" },
        { lat: -27.17392, lng: -49.61477, name: "Em frente a DW Mecanica Diesel" },
        { lat: -27.17369, lng: -49.61745, name: "Próximo a Uniasselvi" },
        { lat: -27.17308, lng: -49.62105, name: "AudioFrahm" },
        { lat: -27.17252, lng: -49.62792, name: "Hotel Demarchi" },
        { lat: -27.18922, lng: -49.59689, name: "Rodoviária de Rio do Sul" },
        { lat: -27.20339, lng: -49.63171, name: "Fiat Ravena" },
        { lat: -27.20633, lng: -49.62983, name: "Olegário Motors" },
        { lat: -27.20944, lng: -49.62944, name: "Casa do Pão" },
        { lat: -27.21011, lng: -49.63286, name: "Supermercado Imperatriz" },
        { lat: -27.21100, lng: -49.63539, name: "Tokio Veículos" },
        { lat: -27.21361, lng: -49.63858, name: "V3 Automóveis" },
        { lat: -27.21556, lng: -49.64161, name: "Terminal Urbano de Rio do Sul" },
        { lat: -27.22006, lng: -49.64864, name: "Restaurante Crescencio Grill" },
        { lat: -27.22611, lng: -49.65850, name: "Garagem Ônibus Circular LTDA." },
        { lat: -27.22112, lng: -49.64911, name: "Fundação Cultural de Rio do Sul" },
        { lat: -27.21561, lng: -49.64197, name: "Rede Feminina de Combate ao Câncer de Rio do Sul" },
        { lat: -27.21276, lng: -49.63528, name: "Taliano Motos" },
        { lat: -27.21122, lng: -49.63275, name: "Centro Educacional Sebastião Back" },
        { lat: -27.20972, lng: -49.62989, name: "Busarello Comércio de Veículos" },
        { lat: -27.20769, lng: -49.62803, name: "Supermercado Rabelo" },
        { lat: -27.20419, lng: -49.63011, name: "CELESC" },
        { lat: -27.20161, lng: -49.63102, name: "Rodoviária de Rio do Sul" },
        { lat: -27.19856, lng: -49.62672, name: "Hotéis Pamplona" },
        { lat: -27.19670, lng: -49.62731, name: "Posto Ipiranga - Brasília" },
        { lat: -27.19433, lng: -49.62408, name: "Borba Car Veículos" },
        { lat: -27.19228, lng: -49.62186, name: "MD Auto Peças" },
        { lat: -27.18964, lng: -49.62006, name: "DW Mecanica Diesel" },
        { lat: -27.18911, lng: -49.62044, name: "Início da Rua Expedicionário Aleandro Stedile" },
        { lat: -27.18925, lng: -49.62046, name: "Próximo a Rua Jacarandá" },
        { lat: -27.18472, lng: -49.62453, name: "Cimentari" },
        { lat: -27.18247, lng: -49.62572, name: "Osteria La Campagnaga" },
        { lat: -27.18139, lng: -49.62592, name: "Próximo a Valiati Orgânicos" },
        { lat: -27.17908, lng: -49.62654, name: "140m antes da Tv. João Dolzan" },
        { lat: -27.17867, lng: -49.62694, name: "Entrada da Tv. João Dalzon" },
        { lat: -27.17789, lng: -49.62873, name: "300m depois da entrada da Tv. João Dalzon" },
        { lat: -27.17786, lng: -49.62950, name: "400m depois da entrada da Tv. João Dalzon" },
        { lat: -27.17728, lng: -49.63091, name: "520m depois da entrada da Tv. João Dalzon" },
        { lat: -27.17698, lng: -49.63256, name: "600m antes da Moss do Brasil" },
        { lat: -27.17637, lng: -49.63417, name: "300m antes da Moss do Brasil" },
        { lat: -27.17539, lng: -49.63596, name: "150m antes da Moss do Brasil" },
        { lat: -27.17486, lng: -49.63741, name: "Próximo a Moss do Brasil" },
        { lat: -27.17478, lng: -49.63932, name: "300m depois do Moss do Brasil" },
        { lat: -27.16625, lng: -49.64150, name: "380m antes da Igreja Nossa Senhora Imaculada Conceição" },
        { lat: -27.16613, lng: -49.64100, name: "Igreja Nossa Senhora Imaculada Conceição" },
        { lat: -27.16619, lng: -49.63953, name: "Início da Rua dos Vereadores" },
        { lat: -27.16674, lng: -49.63697, name: "500m depois do Centro de Educação Infantil Cantinho do Amor" },
        { lat: -27.16712, lng: -49.63417, name: "1km depois do Centro de Educação Infantil Cantinho do Amor" },
        { lat: -27.16767, lng: -49.63263, name: "1,3km depois do Centro de Educação Infantil Cantinho do Amor" },
        { lat: -27.16928, lng: -49.62919, name: "400m antes do Armazém Nona Clara" },
        { lat: -27.16916, lng: -49.62823, name: "150m antes do Armazém Nona Clara" },
        { lat: -27.16733, lng: -49.62698, name: "Igreja Bom Jesus" },
        { lat: -27.16715, lng: -49.62669, name: "150m depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.16669, lng: -49.62596, name: "370m depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.16590, lng: -49.62518, name: "700m depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.16544, lng: -49.62500, name: "1,5km depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.16485, lng: -49.62498, name: "1,7km depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.16415, lng: -49.62458, name: "2km depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.16322, lng: -49.62444, name: "2,5km depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.13367, lng: -49.65125, name: "1,7km antes da Igreja Bom Jesus" },
        { lat: -27.13981, lng: -49.64944, name: "900m antes da Igreja Bom Jesus" },
        { lat: -27.14313, lng: -49.65092, name: "400m antes da Igreja Bom Jesus" },
        { lat: -27.14550, lng: -49.65169, name: "150m antes da Igreja Bom Jesus" },
        { lat: -27.14678, lng: -49.65361, name: "Igreja Bom Jesus" },
        { lat: -27.14856, lng: -49.65211, name: "200m depois do Armazém Nona Clara" },
        { lat: -27.15150, lng: -49.64975, name: "600m depois do Armazém Nona Clara" },
        { lat: -27.15389, lng: -49.64600, name: "1km depois do Armazém Nona Clara" },
        { lat: -27.15608, lng: -49.64417, name: "1km antes do Centro de Educação Infantil Cantinho do Amor" },
        { lat: -27.15894, lng: -49.64425, name: "500m antes do Centro de Educação Infantil Cantinho do Amor" },
        { lat: -27.16614, lng: -49.64433, name: "Igreja Nossa Senhora Imaculada Conceição" },
        { lat: -27.16618, lng: -49.64342, name: "250m depois da Igreja Nossa Senhora Imaculada Conceição" },
        { lat: -27.16780, lng: -49.63931, name: "300m antes do Moss do Brasil" },
        { lat: -27.16797, lng: -49.63747, name: "Próximo a Moss do Brasil" },
        { lat: -27.16875, lng: -49.63594, name: "150m depois da Moss do Brasil" },
        { lat: -27.16925, lng: -49.63411, name: "300m depois da Moss do Brasil" },
        { lat: -27.17031, lng: -49.63314, name: "600m depois da Moss do Brasil" },
        { lat: -27.17450, lng: -49.63185, name: "520m antes da entrada da Tv. João Dalzon" },
        { lat: -27.17410, lng: -49.63172, name: "400m antes da entrada da Tv. João Dalzon" },
        { lat: -27.17456, lng: -49.63150, name: "300m antes da entrada da Tv. João Dalzon" },
        { lat: -27.17700, lng: -49.62750, name: "Entrada da Tv. João Dalzon" },
        { lat: -27.17775, lng: -49.62761, name: "140m depois da Tv. João Dolzan" },
        { lat: -27.18117, lng: -49.62592, name: "Próximo a Valiati Orgânicos" },
        { lat: -27.18248, lng: -49.62572, name: "Osteria La Campagnaga" },
        { lat: -27.18414, lng: -49.62453, name: "Cimentari" },
        { lat: -27.18869, lng: -49.62056, name: "Próximo a Rua Jacarandá" },
        { lat: -27.18942, lng: -49.61878, name: "Início da Rua Expedicionário Aleandro Stedile" },
        { lat: -27.18964, lng: -49.61894, name: "DW Mecanica Diesel" },
        { lat: -27.18905, lng: -49.62197, name: "MD Auto Peças" },
        { lat: -27.19044, lng: -49.62408, name: "Borba Car Veículos" },
        { lat: -27.19125, lng: -49.62794, name: "AudioFrahm" },
        { lat: -27.19168, lng: -49.62964, name: "Hotel Demarchi" },
        { lat: -27.20161, lng: -49.63158, name: "Rodoviária de Rio do Sul" },
        { lat: -27.20633, lng: -49.62983, name: "Olegário Motors" },
        { lat: -27.20944, lng: -49.62944, name: "Casa do Pão" },
        { lat: -27.21011, lng: -49.63286, name: "Supermercado Imperatriz" },
        { lat: -27.21100, lng: -49.63539, name: "Tokio Veículos" },
        { lat: -27.21194, lng: -49.63858, name: "V3 Automóveis" },
        { lat: -27.21222, lng: -49.64161, name: "Terminal Urbano de Rio do Sul" },
        { lat: -27.22611, lng: -49.65822, name: "Garagem Ônibus Circular LTDA." },
        { lat: -27.22611, lng: -49.65822, name: "Garagem Ônibus Circular LTDA." },
        { lat: -27.22228, lng: -49.64911, name: "Fundação Cultural de Rio do Sul" },
        { lat: -27.21989, lng: -49.64444, name: "Ponto Hospital Regional" },
        { lat: -27.21228, lng: -49.64172, name: "Terminal Urbano de Rio do Sul" },
        { lat: -27.21381, lng: -49.63756, name: "Em frente a Rede Feminina de Combate ao Câncer de Rio do Sul" },
        { lat: -27.21372, lng: -49.63528, name: "Taliano Motos" },
        { lat: -27.21122, lng: -49.63304, name: "Centro Educacional Sebastião Back" },
        { lat: -27.21194, lng: -49.62824, name: "Busarello Comércio de Veículos" },
        { lat: -27.21229, lng: -49.62486, name: "Supermercado Rabelo" },
        { lat: -27.20633, lng: -49.62983, name: "Em frente a Olegário Motors" },
        { lat: -27.20161, lng: -49.63158, name: "Rodoviária de Rio do Sul" },
        { lat: -27.19812, lng: -49.62844, name: "Hotéis Pamplona" },
        { lat: -27.19725, lng: -49.62730, name: "Posto Ipiranga - Brasília" },
        { lat: -27.19044, lng: -49.62408, name: "Borba Car Veículos" },
        { lat: -27.18905, lng: -49.62197, name: "MD Auto Peças" },
        { lat: -27.18964, lng: -49.61894, name: "DW Mecanica Diesel" },
        { lat: -27.18869, lng: -49.62056, name: "Início da Rua Jacarandá" },
        { lat: -27.18414, lng: -49.62453, name: "Cimentari" },
        { lat: -27.18248, lng: -49.62572, name: "Osteria La Campagnaga" },
        { lat: -27.18117, lng: -49.62592, name: "Próximo a Valiati Orgânicos" },
        { lat: -27.17775, lng: -49.62761, name: "120m antes da Tv. João Dolzan" },
        { lat: -27.17733, lng: -49.62786, name: "Após a entrada da Tv. João Dolzan" },
        { lat: -27.17456, lng: -49.63150, name: "400m após a Tv. João Dolzan" },
        { lat: -27.17489, lng: -49.63302, name: "600m após a Tv. João Dolzan" },
        { lat: -27.17245, lng: -49.63350, name: "Em frente a casa Nº2460 (portão de ferro)" },
        { lat: -27.16961, lng: -49.63453, name: "250m antes da Moss do Brasil" },
        { lat: -27.16915, lng: -49.63528, name: "100m antes da Moss do Brasil" },
        { lat: -27.16835, lng: -49.63758, name: "Após a entrada do Hotel & Canil Villa di Monique" },
        { lat: -27.16753, lng: -49.63851, name: "230m após a entrada do Hotel & Canil Villa di Monique" },
        { lat: -27.16605, lng: -49.64061, name: "500m antes da Igreja Nossa Senhora Imaculada Conceição" },
        { lat: -27.16617, lng: -49.64174, name: "300m antes da Igreja Nossa Senhora Imaculada Conceição" },
        { lat: -27.16614, lng: -49.64433, name: "Igreja Nossa Senhora Imaculada Conceição" },
        { lat: -27.16957, lng: -49.64556, name: "300m depois da Igreja Nossa Senhora Imaculada Conceição" },
        { lat: -27.17028, lng: -49.64603, name: "450m depois da Igreja Nossa Senhora Imaculada Conceição" },
        { lat: -27.17275, lng: -49.64731, name: "1km depois da Igreja Nossa Senhora Imaculada Conceição" },
        { lat: -27.17567, lng: -49.64850, name: "1,5km depois da Igreja Nossa Senhora Imaculada Conceição" },
        { lat: -27.17674, lng: -49.64931, name: "2km depois da Igreja Nossa Senhora Imaculada Conceição" },
        { lat: -27.149583, lng: -49.650583, name: "400m antes do Armazém Nona Clara" },
        { lat: -27.148222, lng: -49.651028, name: "150m antes do Armazém Nona Clara" },
        { lat: -27.147000, lng: -49.653611, name: "Igreja Bom Jesus" },
        { lat: -27.145500, lng: -49.651694, name: "150m depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.143361, lng: -49.651056, name: "370m depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.140917, lng: -49.649667, name: "700m depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.136556, lng: -49.649917, name: "1,5km depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.133667, lng: -49.651250, name: "1,7km depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.131528, lng: -49.651083, name: "2km depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.129389, lng: -49.654333, name: "2,5km depois da Igreja Bom Jesus (à direita)" },
        { lat: -27.131528, lng: -49.651083, name: "2km antes da Igreja Bom Jesus" },
        { lat: -27.133667, lng: -49.651250, name: "1,7km antes da Igreja Bom Jesus" },
        { lat: -27.136556, lng: -49.649917, name: "1,5km antes da Igreja Bom Jesus" },
        { lat: -27.140639, lng: -49.649444, name: "900m antes da Igreja Bom Jesus" },
        { lat: -27.143111, lng: -49.650917, name: "400m antes da Igreja Bom Jesus" },
        { lat: -27.145500, lng: -49.651694, name: "150m antes da Igreja Bom Jesus" },
        { lat: -27.147000, lng: -49.653611, name: "Igreja Bom Jesus" },
        { lat: -27.148222, lng: -49.651028, name: "100m depois do Armazém Nona Clara" },
        { lat: -27.148000, lng: -49.651028, name: "200m depois do Armazém Nona Clara" },
        { lat: -27.152250, lng: -49.649444, name: "800m depois do Armazém Nona Clara" },
        { lat: -27.153889, lng: -49.646556, name: "1km depois do Armazém Nona Clara" },
        { lat: -27.136556, lng: -49.649917, name: "1,5km antes da Igreja Bom Jesus" },
        { lat: -27.140917, lng: -49.649667, name: "700m antes da Igreja Bom Jesus" },
        { lat: -27.162417, lng: -49.645639, name: "300m antes da Igreja Bom Jesus" },
        { lat: -27.165417, lng: -49.644917, name: "Centro de Educação Infantil Cantinho do Amor" },
        { lat: -27.165722, lng: -49.644583, name: "50m depois Centro de Educação Infantil Cantinho do Amor" },
        { lat: -27.167944, lng: -49.643611, name: "400m depois Centro de Educação Infantil Cantinho do Amor" },
        { lat: -27.168583, lng: -49.643028, name: "600m depois Centro de Educação Infantil Cantinho do Amor" },
        { lat: -27.171000, lng: -49.643611, name: "450m antes do P33 Water Park" },
        { lat: -27.174444, lng: -49.638667, name: "P33 Water Park" },
        { lat: -27.176833, lng: -49.636917, name: "Magnani Embalagens" },
        { lat: -27.179056, lng: -49.633194, name: "Entrada da Tv. João Dolzan" },
        { lat: -27.179000, lng: -49.631750, name: "120m depois da entrada da Tv. João Dolzan" },
        { lat: -27.181167, lng: -49.630222, name: "Antes da entrada da Tv. Pedro Mazini" },
        { lat: -27.185556, lng: -49.628667, name: "250m antes do Comercial Gerdau" },
        { lat: -27.185611, lng: -49.628611, name: "Comercial Gerdau/Agilize Ind. Com. Materiais Plásticos Ltda" },
        { lat: -27.186528, lng: -49.628444, name: "Confecções Demarchi/Brix Jeanswear" },
        { lat: -27.186694, lng: -49.628444, name: "Engecass - Elevadores Automotivos/Galvosul Galvanoplastia Berto" },
        { lat: -27.186833, lng: -49.628444, name: "AudioFrahm" },
        { lat: -27.187500, lng: -49.628000, name: "Hotel Demarchi" },
        { lat: -27.201000, lng: -49.631583, name: "Rodoviária de Rio do Sul" },
        { lat: -27.206444, lng: -49.629833, name: "Olegário Motors" },
        { lat: -27.209444, lng: -49.629417, name: "Casa do Pão" },
        { lat: -27.209333, lng: -49.632583, name: "Supermercado Imperatriz" },
        { lat: -27.211000, lng: -49.635417, name: "Tokio Veículos" },
        { lat: -27.213611, lng: -49.636917, name: "V3 Automóveis" },
        { lat: -27.214444, lng: -49.641583, name: "Terminal Urbano de Rio do Sul" },
        { lat: -27.22006, lng: -49.64864, name: "Restaurante Crescencio Grill" },
        { lat: -27.20161, lng: -49.63158, name: "Rodoviária de Rio do Sul" },
        { lat: -27.20632, lng: -49.62983, name: "Olegário Motors" },
        { lat: -27.20944, lng: -49.62942, name: "Casa do Pão" },
        { lat: -27.21100, lng: -49.63286, name: "Supermercado Imperatriz" },
        { lat: -27.21556, lng: -49.64161, name: "Terminal Urbano de Rio do Sul" },
        { lat: -27.21892, lng: -49.64377, name: "Associação Renal Vida" },
        { lat: -27.21897, lng: -49.64175, name: "Estacionamento Silva" },
        { lat: -27.21892, lng: -49.64194, name: "Início da Rua Manoel Livramento" },
        { lat: -27.21861, lng: -49.63408, name: "Início da Rua Osvaldo Hadlich" },
        { lat: -27.21813, lng: -49.63408, name: "Em frente ao Supermercado Medeiros" },
        { lat: -27.21909, lng: -49.63611, name: "Próximo a Paróquia Nossa Senhora das Graças" },
        { lat: -27.22100, lng: -49.63639, name: "80m depois da Marcenaria Hellmann" },
        { lat: -27.22180, lng: -49.63639, name: "80m depois da 2 e 4 Rodas" },
        { lat: -27.22525, lng: -49.63600, name: "50m antes da H. Decker" },
        { lat: -27.22540, lng: -49.63600, name: "Início da Rua Genivaldo da Costa" },
        { lat: -27.22500, lng: -49.63608, name: "Início da Rua Antônio Chequetto" },
        { lat: -27.23392, lng: -49.63528, name: "Residencial Laranjeiras" },
        { lat: -27.23420, lng: -49.63656, name: "Início da Tv. Sete Quedas" },
        { lat: -27.23408, lng: -49.63667, name: "Em frente ao Mercado Bill" },
        { lat: -27.23450, lng: -49.63600, name: "Início da Rua Lisboa" },
        { lat: -27.23422, lng: -49.63628, name: "Cruzamento da Rua Recanto Alegre e Rua Salvador" },
        { lat: -27.23417, lng: -49.63475, name: "Em frente ao Bar Seu Maneca" },
        { lat: -27.23471, lng: -49.63647, name: "Próximo ao Clube Juventude Boa Vista" },
        { lat: -27.23508, lng: -49.64167, name: "ETA Casan Rio do Sul" },
        { lat: -27.23544, lng: -49.64178, name: "Início da Rua Vilibaldo Valentim Niehues" },
        { lat: -27.23544, lng: -49.64178, name: "Início da Rua Vilibaldo Valentim Niehues" },
        { lat: -27.23508, lng: -49.64167, name: "ETA Casan Rio do Sul" },
        { lat: -27.23471, lng: -49.63647, name: "Próximo ao Clube Juventude Boa Vista" },
        { lat: -27.23408, lng: -49.63667, name: "Em frente ao Mercado Bill" },
        { lat: -27.23420, lng: -49.63656, name: "Início da Tv. Sete Quedas" },
        { lat: -27.23392, lng: -49.63528, name: "Residencial Laranjeiras" },
        { lat: -27.22500, lng: -49.63608, name: "Início da Rua Antônio Chequetto" },
        { lat: -27.22540, lng: -49.63600, name: "Início da Rua Genivaldo da Costa" },
        { lat: -27.22525, lng: -49.63600, name: "50m depois da H. Decker" },
        { lat: -27.22348, lng: -49.63639, name: "80m antes da 2 e 4 Rodas" },
        { lat: -27.22100, lng: -49.63639, name: "80m antes da Marcenaria Hellmann" },
        { lat: -27.21909, lng: -49.63611, name: "Próximo a Paróquia Nossa Senhora das Graças" },
        { lat: -27.21813, lng: -49.63408, name: "Supermercado Medeiros" },
        { lat: -27.21861, lng: -49.63408, name: "Início da Rua Osvaldo Hadlich" },
        { lat: -27.21892, lng: -49.64194, name: "Início da Rua Manoel Livramento" },
        { lat: -27.21897, lng: -49.64175, name: "Estacionamento Silva" },
        { lat: -27.21883, lng: -49.64519, name: "Em frente ao Laboratório Vidas (Tuiuti)" },
        { lat: -27.21556, lng: -49.64161, name: "Terminal Urbano de Rio do Sul" },
        { lat: -27.21381, lng: -49.63756, name: "Rede Feminina de Combate ao Câncer de Rio do Sul" },
        { lat: -27.21275, lng: -49.63528, name: "Taliano Motos" },
        { lat: -27.21122, lng: -49.63192, name: "Centro Educacional Sebastião Back" },
        { lat: -27.21194, lng: -49.62989, name: "Busarello Comércio de Veículos" },
        { lat: -27.21075, lng: -49.62803, name: "Supermercado Rabelo" },
        { lat: -27.20161, lng: -49.63158, name: "Rodoviária de Rio do Sul" },
        { lat: -27.20192, lng: -49.63144, name: "Rodoviária de Rio do Sul" },
        { lat: -27.20632, lng: -49.62983, name: "Olegário Motors" },
        { lat: -27.20944, lng: -49.62942, name: "Casa do Pão" },
        { lat: -27.21100, lng: -49.63286, name: "Supermercado Imperatriz" },
        { lat: -27.21211, lng: -49.63429, name: "Tokio Veículos" },
        { lat: -27.21361, lng: -49.63775, name: "V3 Automóveis" },
        { lat: -27.21556, lng: -49.64167, name: "Terminal Rodoviário De Rio Do Sul" },
        { lat: -27.22006, lng: -49.64864, name: "Restaurante Crescencio Grill" },
        { lat: -27.22225, lng: -49.64800, name: "Fundação Cultural de Rio do Sul" },
        { lat: -27.22500, lng: -49.64800, name: "Paróquia Evangélica de Confissão Luterana" },
        { lat: -27.22778, lng: -49.64800, name: "Residencial Mônaco" },
        { lat: -27.22953, lng: -49.64806, name: "Em frente ao Bosque Carlos Gerd Schroeder" },
        { lat: -27.23303, lng: -49.64806, name: "Happy Day Eventos" },
        { lat: -27.23572, lng: -49.64767, name: "Rua Ruy Barbosa/Rua Ângelo Slomp" },
        { lat: -27.23611, lng: -49.64572, name: "Entrada da Avenida Jardim Panorama" },
        { lat: -27.23622, lng: -49.64539, name: "Entrada da Rua Ituporanga" },
        { lat: -27.23683, lng: -49.64500, name: "Entrada da Rua Mil Cinqüenta e Sete" },
        { lat: -27.23778, lng: -49.64486, name: "Em frente a Schmitt Compensados" },
        { lat: -27.23875, lng: -49.64503, name: "120m depois da Schmitt Compensados" },
        { lat: -27.24472, lng: -49.65220, name: "Estrada do Bonfim/Mil Trinta e Oito" },
        { lat: -27.24714, lng: -49.65319, name: "Estrada do Bonfim/Mil Trinta e Sete" },
        { lat: -27.24878, lng: -49.65303, name: "Estrada do Bonfim/Mil Trinta e Dois" },
        { lat: -27.24991, lng: -49.65300, name: "Estrada do Bonfim/Mil Trinta e Nove" },
        { lat: -27.25414, lng: -49.65364, name: "Entrada do Frigorífico Scoz" },
        { lat: -27.25679, lng: -49.65412, name: "250m depois do Frigorífico Scoz" },
        { lat: -27.25922, lng: -49.65437, name: "500m depois do Frigorífico Scoz" },
        { lat: -27.26033, lng: -49.65444, name: "700m depois do Frigorífico Scoz" },
        { lat: -27.26128, lng: -49.65753, name: "Próximo a Anna Byss Confeccoes" },
        { lat: -27.26206, lng: -49.65744, name: "350m depois da Anna Byss Confeccoes" },
        { lat: -27.26759, lng: -49.65611, name: "Entrada da Ponte Pensil (Rua Bonfim) 1º" },
        { lat: -27.26939, lng: -49.65622, name: "Entrada da Ponte Pensil (Rua Bonfim) 2º" },
        { lat: -27.27200, lng: -49.65403, name: "500m antes da Weiss Equipamentos" },
        { lat: -27.27278, lng: -49.65406, name: "350m antes da Weiss Equipamentos" },
        { lat: -27.27539, lng: -49.65456, name: "Weiss Equipamentos" },
        { lat: -27.27600, lng: -49.65458, name: "300m depois da Weiss Equipamentos" },
        { lat: -27.27506, lng: -49.65417, name: "100m antes da Weiss Equipamentos" },
        { lat: -27.27539, lng: -49.65456, name: "Weiss Equipamentos" },
        { lat: -27.27643, lng: -49.65461, name: "250m depois da Weiss Equipamentos" },
        { lat: -27.27722, lng: -49.65472, name: "350m depois da Weiss Equipamentos" },
        { lat: -27.27808, lng: -49.65456, name: "500m depois da Weiss Equipamentos" },
        { lat: -27.26939, lng: -49.65622, name: "Entrada da Ponte Pensil (Rua Bonfim) 1º" },
        { lat: -27.26759, lng: -49.65611, name: "Entrada da Ponte Pensil (Rua Bonfim) 2º" },
        { lat: -27.26128, lng: -49.65744, name: "500m antes da Anna Byss Confeccoes" },
        { lat: -27.26019, lng: -49.65875, name: "150m antes da Anna Byss Confeccoes" },
        { lat: -27.26128, lng: -49.65753, name: "Próximo a Anna Byss Confeccoes" },
        { lat: -27.26033, lng: -49.65444, name: "700m antes do Frigorífico Scoz" },
        { lat: -27.25922, lng: -49.65437, name: "500m antes do Frigorífico Scoz" },
        { lat: -27.25679, lng: -49.65412, name: "250m antes do Frigorífico Scoz" },
        { lat: -27.25414, lng: -49.65364, name: "Entrada do Frigorífico Scoz" },
        { lat: -27.24991, lng: -49.65300, name: "Estrada do Bonfim/Mil Trinta e Nove" },
        { lat: -27.24878, lng: -49.65303, name: "Estrada do Bonfim/Mil Trinta e Dois" },
        { lat: -27.24763, lng: -49.65303, name: "Estrada do Bonfim/Mil Trinta e Cinco" },
        { lat: -27.24472, lng: -49.65303, name: "Estrada do Bonfim/Mil Trinta e Oito" },
        { lat: -27.24392, lng: -49.64672, name: "280m antes da Schmitt Compensados" },
        { lat: -27.23778, lng: -49.64486, name: "Schmitt Compensados" },
        { lat: -27.23622, lng: -49.64539, name: "Entrada da Rua Ituporanga" },
        { lat: -27.23889, lng: -49.64572, name: "Entrada da Avenida Jardim Panorama" },
        { lat: -27.23767, lng: -49.64603, name: "200m antes da Rua Ruy Barbosa/Rua Ângelo Slomp" },
        { lat: -27.23572, lng: -49.64767, name: "Rua Ruy Barbosa/Rua Ângelo Slomp" },
        { lat: -27.23294, lng: -49.64748, name: "Happy Day Eventos" },
        { lat: -27.23175, lng: -49.64753, name: "Bosque Carlos Gerd Schroeder" },
        { lat: -27.22906, lng: -49.64786, name: "Antes do Residencial Mônaco" },
        { lat: -27.22678, lng: -49.64778, name: "Usamais Moda Íntima" },
        { lat: -27.22385, lng: -49.64739, name: "100m antes do Colégio Sinodal Ruy Barbosa" },
        { lat: -27.21989, lng: -49.64444, name: "Ponto Hospital Regional" },
        { lat: -27.21573, lng: -49.64178, name: "Terminal Rodoviário De Rio Do Sul" },
        { lat: -27.21381, lng: -49.63756, name: "Rede Feminina de Combate ao Câncer de Rio do Sul" },
        { lat: -27.21275, lng: -49.63528, name: "Taliano Motos" },
        { lat: -27.21122, lng: -49.63191, name: "Centro Educacional Sebastião Back" },
        { lat: -27.21194, lng: -49.62989, name: "Busarello Comércio de Veículos" },
        { lat: -27.21103, lng: -49.62803, name: "Supermercado Rabelo" },
        { lat: -27.20172, lng: -49.63102, name: "Rodoviária de Rio do Sul" },
        { lat: -27.20192, lng: -49.63139, name: "Rodoviária de Rio do Sul" },
        { lat: -27.20689, lng: -49.62983, name: "Olegário Motors" },
        { lat: -27.20944, lng: -49.62943, name: "Casa do Pão" },
        { lat: -27.21097, lng: -49.63278, name: "Supermercado Imperatriz" },
        { lat: -27.21217, lng: -49.63428, name: "Tokio Veículos" },
        { lat: -27.21361, lng: -49.63693, name: "V3 Automóveis" },
        { lat: -27.21573, lng: -49.64178, name: "Terminal Rodoviário De Rio Do Sul" },
        { lat: -27.20689, lng: -49.62983, name: "Em frente a Casa das Rações" },
        { lat: -27.20427, lng: -49.62941, name: "Próximo ao Posto Shell" },
        { lat: -27.20312, lng: -49.62933, name: "Parque Mun. Rua XV de Novembro" },
        { lat: -27.20181, lng: -49.62861, name: "Paróquia São José Operário" },
        { lat: -27.19939, lng: -49.63772, name: "Em frente a Chapeação e Pintura NW" },
        { lat: -27.19503, lng: -49.64167, name: "Prensul" },
        { lat: -27.19229, lng: -49.64186, name: "Em frente a Chapeação Pereira" },
        { lat: -27.18994, lng: -49.64167, name: "Após a entrada do Beco Arnoldo Tillmann" },
        { lat: -27.18809, lng: -49.64544, name: "Marcante Eventos" },
        { lat: -27.18194, lng: -49.65233, name: "Sociedade Esportiva Recreativa Albertinense" },
        { lat: -27.17883, lng: -49.65342, name: "Entrada da estrada Valada Albertina" },
        { lat: -27.17475, lng: -49.65369, name: "500m depois da entrada da estrada Valada Albertina" },
        { lat: -27.26811, lng: -49.65350, name: "Entrada da Ponte Pensil 1º" },
        { lat: -27.27444, lng: -49.65247, name: "Km360 da SC350" },
        { lat: -27.27685, lng: -49.64991, name: "Rodovia Luís Bertoli/Rua Vereador Carlos Probst" },
        { lat: -27.27050, lng: -49.65372, name: "Entrada da Ponte Pensil 1º" },
        { lat: -27.17475, lng: -49.65369, name: "500m antes da entrada da estrada Valada Albertina" },
        { lat: -27.17883, lng: -49.65342, name: "Entrada da estrada Valada Albertina" },
        { lat: -27.26106, lng: -49.64869, name: "700m após o início da estrada Valada Albertina" },
        { lat: -27.26178, lng: -49.64198, name: "1,5km após o início da estrada Valada Albertina" },
        { lat: -27.26322, lng: -49.63983, name: "200m antes da Casa do Mel" },
        { lat: -27.26822, lng: -49.62872, name: "380m depois do Queijos Holler" },
        { lat: -27.27089, lng: -49.62306, name: "Igreja Evangelica" },
        { lat: -27.27028, lng: -49.61770, name: "560m depois da Igreja Evangelica" },
        { lat: -27.26649, lng: -49.61178, name: "500m depois do Sítio Pontal das Águas" },
        { lat: -27.26539, lng: -49.61017, name: "Entrada do Restaurante Sabores da Roça" },
        { lat: -27.26503, lng: -49.60517, name: "350m depois da entrada do Restaurante Sabores da Roça" },
        { lat: -27.26503, lng: -49.60517, name: "350m antes da entrada do Restaurante Sabores da Roça" },
        { lat: -27.26539, lng: -49.61017, name: "Em frente a entrada do Restaurante Sabores da Roça" },
        { lat: -27.26649, lng: -49.61178, name: "500m antes do Sítio Pontal das Águas" },
        { lat: -27.27028, lng: -49.61770, name: "560m antes da Igreja Evangelica" },
        { lat: -27.27089, lng: -49.62306, name: "Igreja Evangelica" },
        { lat: -27.26822, lng: -49.62872, name: "380m antes do Queijos Holler" },
        { lat: -27.26322, lng: -49.63983, name: "200m depois da Casa do Mel" },
        { lat: -27.26178, lng: -49.64198, name: "1,5km antes do início da estrada Valada Albertina" },
        { lat: -27.26106, lng: -49.64869, name: "700m antes do início da estrada Valada Albertina" },
        { lat: -27.26178, lng: -49.64198, name: "Entrada da estrada Valada Albertina" },
        { lat: -27.25417, lng: -49.65251, name: "Sociedade Esportiva Recreativa Albertinense" },
        { lat: -27.24647, lng: -49.64705, name: "Marcante Eventos" },
        { lat: -27.24161, lng: -49.64500, name: "Antes a entrada do Beco Arnoldo Tillmann" },
        { lat: -27.24003, lng: -49.64176, name: "Chapeação Pereira" },
        { lat: -27.23778, lng: -49.64167, name: "Prensul" },
        { lat: -27.23722, lng: -49.64439, name: "Em frente a Chapeação e Pintura NW" },
        { lat: -27.23569, lng: -49.64694, name: "Paróquia São José Operário" },
        { lat: -27.23384, lng: -49.64545, name: "Em frente ao Parque Municipal Rua XV de Novembro" },
        { lat: -27.23106, lng: -49.64597, name: "Próximo ao Posto Shell" },
        { lat: -27.22758, lng: -49.64464, name: "Casa das Rações" },
        { lat: -27.21989, lng: -49.64444, name: "Ponto Hospital Regional" },
        { lat: -27.21567, lng: -49.64200, name: "Terminal Rodoviário De Rio Do Sul" },
        { lat: -27.21381, lng: -49.63756, name: "Rede Feminina de Combate ao Câncer de Rio do Sul" },
        { lat: -27.21275, lng: -49.63417, name: "Taliano Motos" },
        { lat: -27.21122, lng: -49.63192, name: "Centro Educacional Sebastião Back" },
        { lat: -27.21028, lng: -49.62988, name: "Busarello Comércio de Veículos" },
        { lat: -27.20936, lng: -49.62747, name: "Supermercado Rabelo" },
        { lat: -27.20161, lng: -49.63103, name: "Rodoviária de Rio do Sul" },
        { lat: -27.20192, lng: -49.63144, name: "Rodoviaria de Rio do Sul" },
        { lat: -27.20633, lng: -49.62983, name: "Olegário Motors" },
        { lat: -27.20944, lng: -49.62944, name: "Casa do Pão" },
        { lat: -27.21100, lng: -49.63284, name: "Supermercado Imperatriz" },
        { lat: -27.21211, lng: -49.63536, name: "Tokio Veículos" },
        { lat: -27.21361, lng: -49.63772, name: "V3 Automóveis" },
        { lat: -27.21567, lng: -49.64200, name: "Terminal Rodoviário De Rio Do Sul" },
        { lat: -27.22758, lng: -49.64464, name: "Em frente a Casa das Rações" },
        { lat: -27.23106, lng: -49.64597, name: "Próximo ao Posto Shell" },
        { lat: -27.23384, lng: -49.64545, name: "Parque Municipal Rua XV de Novembro" },
        { lat: -27.23569, lng: -49.64694, name: "Paróquia São José Operário" },
        { lat: -27.23722, lng: -49.64439, name: "Em frente a Chapeação e Pintura NW" },
        { lat: -27.23778, lng: -49.64167, name: "Prensul" },
        { lat: -27.24003, lng: -49.64176, name: "Em frente a Chapeação Pereira" },
        { lat: -27.24161, lng: -49.64500, name: "Após a entrada do Beco Arnoldo Tillmann" },
        { lat: -27.24647, lng: -49.64705, name: "Marcante Eventos" },
        { lat: -27.25417, lng: -49.65251, name: "Sociedade Esportiva Recreativa Albertinense" },
        { lat: -27.26178, lng: -49.64198, name: "Entrada da estrada Valada Albertina" },
        { lat: -27.26322, lng: -49.63983, name: "500m depois da entrada da estrada Valada Albertina" },
        { lat: -27.26811, lng: -49.65350, name: "Entrada da Ponte Pensil 1º" },
        { lat: -27.27444, lng: -49.65247, name: "Km360 da SC350" },
        { lat: -27.27685, lng: -49.64991, name: "Rodovia Luís Bertoli/Rua Vereador Carlos Probst" },
        { lat: -27.27685, lng: -49.64991, name: "Rodovia Luís Bertoli/Rua Vereador Carlos Probst" },
        { lat: -27.27444, lng: -49.65247, name: "Km360 da SC350" },
        { lat: -27.26811, lng: -49.65350, name: "Entrada da Ponte Pensil 2º" },
        { lat: -27.17475, lng: -49.65369, name: "500m antes da entrada da estrada Valada Albertina" },
        { lat: -27.17883, lng: -49.65342, name: "Entrada da estrada Valada Albertina" },
        { lat: -27.25417, lng: -49.65251, name: "Sociedade Esportiva Recreativa Albertinense" },
        { lat: -27.24647, lng: -49.64705, name: "Marcante Eventos" },
        { lat: -27.24161, lng: -49.64500, name: "Antes da entrada do Beco Arnoldo Tillmann" },
        { lat: -27.24003, lng: -49.64176, name: "Chapeação Pereira" },
        { lat: -27.23778, lng: -49.64167, name: "Prensul" },
        { lat: -27.23722, lng: -49.64439, name: "Em frente a Chapeação e Pintura NW" },
        { lat: -27.23569, lng: -49.64694, name: "Paróquia São José Operário" },
        { lat: -27.23384, lng: -49.64545, name: "Em frente ao Parque Municipal Rua XV de Novembro" },
        { lat: -27.23106, lng: -49.64597, name: "Próximo ao Posto Shell" },
        { lat: -27.22758, lng: -49.64464, name: "Casa das Rações" },
        { lat: -27.21989, lng: -49.64444, name: "Ponto Hospital Regional" },
        { lat: -27.21567, lng: -49.64200, name: "Terminal Rodoviário De Rio Do Sul" },
        { lat: -27.21381, lng: -49.63756, name: "Rede Feminina de Combate ao Câncer de Rio do Sul" },
        { lat: -27.21275, lng: -49.63417, name: "Taliano Motos" },
        { lat: -27.21122, lng: -49.63192, name: "Centro Educacional Sebastião Back" },
        { lat: -27.21028, lng: -49.62988, name: "Busarello Comércio de Veículos" },
        { lat: -27.20936, lng: -49.62747, name: "Supermercado Rabelo" },
        { lat: -27.20161, lng: -49.63103, name: "Rodoviária de Rio do Sul" },
        { lat: -27.21231, lng: -49.64933, name: "150m depois da Pista de Skate" },
        { lat: -27.20626, lng: -49.64175, name: "Rua Prefeito Wenceslau Borini/Rua Luiz Alves" },
        { lat: -27.20572, lng: -49.64172, name: "Fundos da Weber Hydraulik" },
        { lat: -27.20597, lng: -49.63728, name: "Ózee Comunicação Total" },
        { lat: -27.20598, lng: -49.63603, name: "Finestre Decor" },
        { lat: -27.20564, lng: -49.63383, name: "Edifício San Rafael" },
        { lat: -27.20498, lng: -49.63275, name: "Baterias Globo" },
        { lat: -27.20438, lng: -49.63175, name: "Em frente a Yosai Sushi" },
        { lat: -27.20161, lng: -49.63103, name: "Rodoviária de Rio do Sul" }
    ];
    let infoWindow;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -27.2176, lng: -49.6456 },
            zoom: 14,
            scrollwheel: true, // Permite rolar com o scroll do mouse
            gestureHandling: 'greedy' // Permite rolar e mover o mapa
        });

        infoWindow = new google.maps.InfoWindow();

        // Adiciona um evento de clique ao mapa para marcar a posição
        map.addListener('click', function(event) {
            placeUserMarker(event.latLng);
        });
    }

    function startTrackingLocation() {
        getLocation();
        // Chama getLocation a cada 10 segundos
        setInterval(getLocation, 10000);
    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError, {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            });
        } else {
            document.getElementById("resultado").innerHTML = "Geolocalização não é suportada pelo seu navegador.";
        }
    }

    function showPosition(position) {
        const userLocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };

        if (userMarker) {
            userMarker.setMap(null); // Remove o marcador anterior
        }

        const userIcon = {
            path: google.maps.SymbolPath.CIRCLE,
            fillColor: 'red',
            fillOpacity: 1,
            scale: 10,
            strokeColor: 'white',
            strokeWeight: 2
        };

        userMarker = new google.maps.Marker({
            position: userLocation,
            map: map,
            icon: userIcon,
            title: "Sua Localização"
        });

        userMarkerPosition = userLocation; // Salva a posição do usuário
        map.setCenter(userLocation);
        showNearbyBusStops(userLocation);
    }

    function placeUserMarker(location) {
        if (userMarker) {
            userMarker.setMap(null); // Remove o marcador anterior
        }

        userMarker = new google.maps.Marker({
            position: location,
            map: map,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                fillColor: 'red',
                fillOpacity: 1,
                scale: 10,
                strokeColor: 'white',
                strokeWeight: 2
            }
        });

        userMarkerPosition = {
            lat: location.lat(),
            lng: location.lng()

            

           
        };
        showNearbyBusStops(userMarkerPosition);
    }

    function showNearbyBusStops(userLocation) {
        const radius = 2; // Raio de proximidade em km
        clearBusStopMarkers();

        busStops.forEach(busStop => {
            const distance = calculateDistance(userLocation, busStop);
            if (distance <= radius) {
                const travelTime = (distance / 3) * 60; // Tempo em minutos (considerando 3 km/h a pé)
                const marker = new google.maps.Marker({
                    position: { lat: busStop.lat, lng: busStop.lng },
                    map: map,
                    title: busStop.name
                });

                // Adiciona evento para mostrar infoWindow ao passar o mouse
                marker.addListener('mouseover', () => {
                    infoWindow.setContent(`${busStop.name}: ${Math.round(travelTime)} minutos a pé`);
                    infoWindow.open(map, marker);
                });

                marker.addListener('mouseout', () => {
                    infoWindow.close();
                });

                busStopMarkers.push(marker);
            }
        });

        const resultText = `Foram encontrados ${busStopMarkers.length} pontos de ônibus próximos.`;
        document.getElementById("resultado").innerHTML = resultText;
    }

    function clearBusStopMarkers() {
        busStopMarkers.forEach(marker => {
            marker.setMap(null);
        });
        busStopMarkers = [];
        document.getElementById("resultado").innerHTML = ""; // Limpa o resultado anterior
    }

    function calculateDistance(loc1, loc2) {
        const R = 6371; // Raio da Terra em km
        const dLat = (loc2.lat - loc1.lat) * (Math.PI / 180);
        const dLon = (loc2.lng - loc1.lng) * (Math.PI / 180);
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(loc1.lat * (Math.PI / 180)) * Math.cos(loc2.lat * (Math.PI / 180)) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c; // Distância em km
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                document.getElementById("resultado").innerHTML = "Usuário negou a solicitação de geolocalização.";
                break;
            case error.POSITION_UNAVAILABLE:
                document.getElementById("resultado").innerHTML = "A localização não está disponível.";
                break;
            case error.TIMEOUT:
                document.getElementById("resultado").innerHTML = "A solicitação de localização expirou.";
                break;
            case error.UNKNOWN_ERROR:
                document.getElementById("resultado").innerHTML = "Um erro desconhecido ocorreu.";
                break;
        }
    }
</script>
</body>
</html>
