<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horários de Ônibus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('img/onibus.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #000;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #fff;
            margin-left: 50px;
        }
        .navbar-nav .nav-link:hover {
            color: #d3d3d3;
        }
        .menu {
            display: none;
            position: absolute;
            top: 56px;
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
        #checkbox-menu:checked ~ .menu {
            display: block;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 800px;
            width: 100%;
            margin: auto;
            
        }
        h2, h3 {
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
        .schedule-table a {
            color: #000;
            text-decoration: none;
        }
        .schedule-table a:hover {
            color: #000;
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
            <li><a href="teste.php">Formulário</a></li>
            <li><a href="local.php">Lista de pontos</a></li>
            
            <li><a href="linhas.php">Linhas</a></li>
            <li><a href="mapas.php">Rota</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Horários de Ônibus</h2>

    <label for="bairro">Selecione o bairro:</label>
    <select id="bairro" class="form-control mb-4" onchange="mostrarInformacoes()">
        <option value="">-- Selecione um bairro --</option>
        <option value="Barra do Trombudo (Ribeirão do Tigre)">Barra do Trombudo (Ribeirão do Tigre)</option>
        <option value="Barra do Trombudo">Barra do Trombudo</option>
        <option value="Barra do Trombudo (Via BR-470)">Barra do Trombudo (Via BR-470)</option>
        <option value="Morro do Budag">Morro do Budag</option>
        <option value="Bela Aliança">Bela Aliança</option>
        <option value="Alto Matador (Bela Aliança)">Alto Matador (Bela Aliança)</option>
        <option value="Taboão">Taboão</option>
        <option value="Taboão – Serra Taboão">Taboão – Serra Taboão</option>
        <option value="Rainha">Rainha</option>
        <option value="Santa Rita">Santa Rita</option>
        <option value="Rainha (Via Bairro Navegantes)">Rainha (Via Bairro Navegantes)</option>
        <option value="Fundo Canoas">Fundo Canoas</option>
        <option value="Serra Canoas">Serra Canoas</option>
        <option value="Progresso">Progresso</option>
        <option value="Fundo Cobras">Fundo Cobras</option>
        <option value="Fundo Itoupava">Fundo Itoupava</option>
        <option value="Boa Vista">Boa Vista</option>
        <option value="Ruy Barbosa">Ruy Barbosa</option>
        <option value="Albertina">Albertina</option>
        <option value="Canta Galo">Canta Galo</option>
        <option value="Lot. São Pedro (Condomínio Marcolino Felipe)">Lot. São Pedro (Condomínio Marcolino Felipe)</option>
        <option value="Saída do Condomínio">Saída do Condomínio</option>
        <option value="Loteamento Continental">Loteamento Continental</option>
       
    </select>

    <div id="informacoes" style="display: none;">
        <h3 id="rota"></h3>
        <table class="table table-bordered schedule-table">
            <thead class="thead-dark">
                <tr>
                    <th>Saída do Centro</th>
                    <th>Saída do Bairro</th>
                    <th>Dias da Semana</th>
                </tr>
            </thead>
            <tbody id="tabela-horarios">
                <!-- Os horários serão inseridos dinamicamente aqui -->
            </tbody>
        </table>
    </div>
</div>

<script>
    const horarios = {
        "Barra do Trombudo (Ribeirão do Tigre)": [
            { partidaCentro: "11:55", partidaBairro: "06:55", dias: "Todos os dias" },
            { partidaCentro: "18:05", partidaBairro: "12:45", dias: "Todos os dias" }
        ],
        "Barra do Trombudo": [
            { partidaCentro: "05:30", partidaBairro: "05:00", dias: "Todos os dias" },
            { partidaCentro: "06:30", partidaBairro: "05:55", dias: "Todos os dias" },
            { partidaCentro: "06:45", partidaBairro: "06:25", dias: "Todos os dias" },
            { partidaCentro: "07:10", partidaBairro: "06:35", dias: "Todos os dias" },
            { partidaCentro: "07:20", partidaBairro: "06:45", dias: "Todos os dias" },
            { partidaCentro: "08:00", partidaBairro: "07:05", dias: "Todos os dias" },
            { partidaCentro: "08:30", partidaBairro: "07:30", dias: "Todos os dias" },
            { partidaCentro: "09:50", partidaBairro: "08:00", dias: "Todos os dias" }
        ],
        "Barra do Trombudo (Via BR-470)": [
            { partidaCentro: "06:15", partidaBairro: "06:50", dias: "Todos os dias" },
            { partidaCentro: "07:05", partidaBairro: "07:35", dias: "Todos os dias" },
            { partidaCentro: "13:45", partidaBairro: "17:35", dias: "Todos os dias" }
        ],
        "Morro do Budag": [
            { partidaCentro: "12:05", partidaBairro: "06:25", dias: "Todos os dias" },
            { partidaCentro: "18:05", partidaBairro: "07:35", dias: "Todos os dias" }
        ],
        "Bela Aliança": [
            { partidaCentro: "07:10", partidaBairro: "06:25", dias: "Segunda a Sexta" },
            { partidaCentro: "07:35", partidaBairro: "07:35", dias: "Segunda a Sexta" },
            { partidaCentro: "14:35", partidaBairro: "14:35", dias: "Segunda a Sexta" }
        ],
        "Alto Matador (Bela Aliança)": [
            { partidaCentro: "06:10", partidaBairro: "06:40", dias: "Segunda a Sexta" },
            { partidaCentro: "12:05", partidaBairro: "12:40", dias: "Segunda a Sexta" },
            { partidaCentro: "15:00", partidaBairro: "15:30", dias: "Segunda a Sexta" },
            { partidaCentro: "16:55", partidaBairro: "17:30", dias: "Segunda a Sexta" },
            { partidaCentro: "18:05", partidaBairro: "17:30", dias: "Segunda a Sexta" },
            { partidaCentro: "22:10", partidaBairro: "22:10", dias: "Segunda a Sexta" }
        ],
        "Taboão": [
            { partidaCentro: "06:00", partidaBairro: "06:45", dias: "Segunda a Sexta" },
            { partidaCentro: "07:40", partidaBairro: "08:00", dias: "Segunda a Sexta" },
            { partidaCentro: "12:05", partidaBairro: "12:50", dias: "Segunda a Sexta" },
            { partidaCentro: "15:00", partidaBairro: "15:20", dias: "Segunda a Sexta" },
            { partidaCentro: "17:00", partidaBairro: "17:30", dias: "Segunda a Sexta" },
            { partidaCentro: "18:15", partidaBairro: "18:30", dias: "Segunda a Sexta" }
        ],
        "Taboão – Serra Taboão": [
            { partidaCentro: "06:00", partidaBairro: "06:35", dias: "Segunda a Sexta" },
            { partidaCentro: "12:05", partidaBairro: "12:40", dias: "Segunda a Sexta" },
            { partidaCentro: "18:15", partidaBairro: "18:15", dias: "Segunda a Sexta" }
        ],
        "Rainha": [
            { partidaCentro: "05:35", partidaBairro: "05:55", dias: "Segunda a Sexta" },
            { partidaCentro: "06:45", partidaBairro: "06:45", dias: "Segunda a Sexta" },
            { partidaCentro: "07:05", partidaBairro: "07:00", dias: "Segunda a Sexta" },
            { partidaCentro: "08:30", partidaBairro: "07:30", dias: "Segunda a Sexta" },
            { partidaCentro: "11:10", partidaBairro: "09:00", dias: "Segunda a Sexta" },
            { partidaCentro: "12:05", partidaBairro: "11:35", dias: "Segunda a Sexta" },
            { partidaCentro: "14:30", partidaBairro: "12:50", dias: "Segunda a Sexta" },
            { partidaCentro: "15:30", partidaBairro: "15:00", dias: "Segunda a Sexta" },
            { partidaCentro: "16:30", partidaBairro: "16:00", dias: "Segunda a Sexta" },
            { partidaCentro: "17:00", partidaBairro: "17:00", dias: "Segunda a Sexta" },
            { partidaCentro: "18:15", partidaBairro: "17:35", dias: "Segunda a Sexta" },
            { partidaCentro: "22:30", partidaBairro: "18:30", dias: "Segunda a Sexta" }
        ],
        "Santa Rita": [
            { partidaCentro: "05:40", partidaBairro: "06:10", dias: "Segunda a Sexta" },
            { partidaCentro: "07:05", partidaBairro: "07:30", dias: "Segunda a Sexta" },
            { partidaCentro: "08:30", partidaBairro: "09:00", dias: "Segunda a Sexta" },
            { partidaCentro: "11:10", partidaBairro: "11:35", dias: "Segunda a Sexta" },
            { partidaCentro: "12:05", partidaBairro: "12:50", dias: "Segunda a Sexta" },
            { partidaCentro: "13:15", partidaBairro: "13:30", dias: "Segunda a Sexta" },
            { partidaCentro: "15:30", partidaBairro: "15:50", dias: "Segunda a Sexta" },
            { partidaCentro: "16:30", partidaBairro: "16:55", dias: "Segunda a Sexta" },
            { partidaCentro: "17:00", partidaBairro: "17:30", dias: "Segunda a Sexta" },
            { partidaCentro: "18:15", partidaBairro: "18:30", dias: "Segunda a Sexta" }
        ],
        "Rainha (Via Bairro Navegantes)": [
            { partidaCentro: "06:15", partidaBairro: "07:30", dias: "Segunda a Sexta" }
        ],
        "Fundo Canoas": [
            { partidaCentro: "08:30", partidaBairro: "07:45", dias: "Segunda a Sexta" },
            { partidaCentro: "12:05", partidaBairro: "12:20", dias: "Segunda a Sexta" },
            { partidaCentro: "15:15", partidaBairro: "15:30", dias: "Segunda a Sexta" }
        ],
        "Serra Canoas": [
            { partidaCentro: "07:15", partidaBairro: "07:35", dias: "Segunda a Sexta" },
            { partidaCentro: "12:00", partidaBairro: "12:20", dias: "Segunda a Sexta" },
            { partidaCentro: "15:15", partidaBairro: "15:30", dias: "Segunda a Sexta" }
        ],
        "Progresso": [
            { partidaCentro: "06:00", partidaBairro: "05:30", dias: "Segunda a Sexta" },
            { partidaCentro: "07:00", partidaBairro: "07:00", dias: "Segunda a Sexta" },
            { partidaCentro: "11:05", partidaBairro: "11:20", dias: "Segunda a Sexta" },
            { partidaCentro: "14:00", partidaBairro: "14:15", dias: "Segunda a Sexta" },
            { partidaCentro: "16:00", partidaBairro: "16:15", dias: "Segunda a Sexta" },
            { partidaCentro: "17:30", partidaBairro: "17:45", dias: "Segunda a Sexta" }
        ],
        "Fundo Cobras": [
            { partidaCentro: "06:00", partidaBairro: "06:30", dias: "Segunda a Sexta" },
            { partidaCentro: "09:00", partidaBairro: "09:30", dias: "Segunda a Sexta" },
            { partidaCentro: "12:00", partidaBairro: "12:30", dias: "Segunda a Sexta" },
            { partidaCentro: "14:15", partidaBairro: "14:45", dias: "Segunda a Sexta" },
            { partidaCentro: "16:00", partidaBairro: "16:30", dias: "Segunda a Sexta" }
        ],
        "Fundo Itoupava": [
            { partidaCentro: "06:15", partidaBairro: "06:50", dias: "Segunda a Sexta" },
            { partidaCentro: "09:00", partidaBairro: "09:30", dias: "Segunda a Sexta" },
            { partidaCentro: "12:05", partidaBairro: "12:40", dias: "Segunda a Sexta" },
            { partidaCentro: "14:30", partidaBairro: "15:00", dias: "Segunda a Sexta" },
            { partidaCentro: "17:00", partidaBairro: "17:30", dias: "Segunda a Sexta" }
        ],
        "Boa Vista": [
            { partidaCentro: "05:30", partidaBairro: "06:00", dias: "Segunda a Sexta" },
            { partidaCentro: "12:00", partidaBairro: "12:30", dias: "Segunda a Sexta" },
            { partidaCentro: "16:00", partidaBairro: "16:30", dias: "Segunda a Sexta" }
        ],
        "Ruy Barbosa": [
            { partidaCentro: "06:15", partidaBairro: "07:00", dias: "Segunda a Sexta" },
            { partidaCentro: "12:05", partidaBairro: "12:50", dias: "Segunda a Sexta" },
            { partidaCentro: "17:15", partidaBairro: "18:00", dias: "Segunda a Sexta" }
        ],
        "Albertina": [
            { partidaCentro: "07:10", partidaBairro: "06:30", dias: "Segunda a Sexta" },
            { partidaCentro: "12:05", partidaBairro: "12:30", dias: "Segunda a Sexta" },
            { partidaCentro: "16:30", partidaBairro: "16:50", dias: "Segunda a Sexta" }
        ],
        "Canta Galo": [
            { partidaCentro: "05:45", partidaBairro: "05:55", dias: "Segunda a Sexta" },
            { partidaCentro: "06:30", partidaBairro: "07:00", dias: "Segunda a Sexta" },
            { partidaCentro: "12:05", partidaBairro: "12:20", dias: "Segunda a Sexta" },
            { partidaCentro: "14:00", partidaBairro: "14:20", dias: "Segunda a Sexta" },
            { partidaCentro: "16:00", partidaBairro: "16:20", dias: "Segunda a Sexta" }
        ],
        "Lot. São Pedro (Condomínio Marcolino Felipe)": [
            { partidaCentro: "05:30", partidaBairro: "06:00", dias: "Segunda a Sexta" },
            { partidaCentro: "11:10", partidaBairro: "11:30", dias: "Segunda a Sexta" },
            { partidaCentro: "15:15", partidaBairro: "15:45", dias: "Segunda a Sexta" }
        ],
        "Saída do Condomínio": [
            { partidaCentro: "07:00", partidaBairro: "07:35", dias: "Segunda a Sexta" },
            { partidaCentro: "12:00", partidaBairro: "12:40", dias: "Segunda a Sexta" },
            { partidaCentro: "15:20", partidaBairro: "15:50", dias: "Segunda a Sexta" }
        ],
        "Loteamento Continental": [
            { partidaCentro: "07:00", partidaBairro: "07:20", dias: "Segunda a Sexta" },
            { partidaCentro: "11:10", partidaBairro: "11:45", dias: "Segunda a Sexta" },
            { partidaCentro: "16:00", partidaBairro: "16:30", dias: "Segunda a Sexta" }
        ],
       
    };

    function mostrarInformacoes() {
    const bairroSelecionado = document.getElementById('bairro').value;
    const informacoes = document.getElementById('informacoes');
    const tabelaHorarios = document.getElementById('tabela-horarios');
    const rota = document.getElementById('rota');
    
    if (bairroSelecionado) {
        informacoes.style.display = 'block';
        tabelaHorarios.innerHTML = '';

        const horariosBairro = horarios[bairroSelecionado];
        if (horariosBairro && horariosBairro.length > 0) {
            rota.textContent = `Horários para ${bairroSelecionado}`;
            horariosBairro.forEach(horario => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${horario.partidaCentro}</td>
                    <td>${horario.partidaBairro}</td>
                    <td>${horario.dias}</td>
                `;
                tabelaHorarios.appendChild(row);
            });
        } else {
            rota.textContent = `Nenhuma informação disponível para ${bairroSelecionado}`;
            tabelaHorarios.innerHTML = '';
        }
    } else {
        informacoes.style.display = 'none';
    }
}

</script>
</body>
</html>
