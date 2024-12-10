<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Corrida - SmartBS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('img/onibus.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .navbar {
            background-color: #000;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 10px;
        }
        .navbar-brand {
            color: #fff;
            margin-left: 50px;
        }
        .navbar-nav .nav-link {
            color: #fff;
        }
        .navbar-nav .nav-link:hover {
            color: #d3d3d3;
        }
        #checkbox-menu {
            display: none;
        }
        label {
            cursor: pointer;
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            z-index: 1100;
        }
        label span {
            display: block;
            width: 30px;
            height: 5px;
            background-color: #fff;
            border-radius: 5px;
            margin: 6px 0;
            transition: 0.3s ease;
        }
        #checkbox-menu:checked + label span:nth-child(1) {
            transform: rotate(45deg);
            position: relative;
            top: 9px;
        }
        #checkbox-menu:checked + label span:nth-child(2) {
            opacity: 0;
        }
        #checkbox-menu:checked + label span:nth-child(3) {
            transform: rotate(-45deg);
            position: relative;
            top: -9px;
        }
        #checkbox-menu:checked ~ .menu {
            display: block;
        }
        .menu {
            display: none;
            position: absolute;
            top: 60px;
            left: 0;
            background-color: #333;
            width: 200px;
            border-radius: 5px;
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
            background-color: #555;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            margin-top: 100px; /* Ajusta para espaçamento adequado */
        }
        h2 {
            color: #333;
            font-size: 32px;
            margin-bottom: 20px;
        }
        select {
            font-size: 16px;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #fff;
            margin-bottom: 20px;
            color: #333;
        }
        input {
            font-size: 16px;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #fff;
            margin-bottom: 20px;
            color: #333;
        }
        button {
            background-color: #000;
            color: white;
            padding: 14px 30px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }
        button:hover {
            background-color: #333;
        }
        button:active {
            background-color: #111;
        }
        h3 {
            font-size: 18px;
            color: #333;
            margin-top: 20px;
        }
        #map {
            height: 500px; /* Ajustado para não ocupar toda a altura */
            width: 100%;
            max-width: 1000px;
            border: 2px solid #ddd;
            margin: 20px auto;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        input[readonly], select[disabled] {
            background-color: #f9f9f9;
            color: #333;
            border: 1px solid #ccc;
            cursor: not-allowed;
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

<div class="container">
    <h2>Escolha a linha de ônibus</h2>
    <form action="" id="enviaLocalização" method="POST">
        <select name="linha_onibus" id="linha_onibus" required>
            <option value="" selected disabled>Selecione uma opção</option>
            <option value="001">Barra do Trombudo (Ribeirão do Tigre)</option>
            <option value="002">Barra do Trombudo</option>

            <option value="003">Barra do Trombudo (Via BR-470)</option>
            <option value="004">Morro do Budag</option>
            <option value="005">Bela Aliança</option>
            <option value="006">Alto Matador (Bela Aliança)</option>
            <option value="007">Taboão</option>
            <option value="008">Taboão – Serra Taboão</option>
            <option value="009">Rainha</option>
            <option value="010">Santa Rita</option>
            <option value="011">Rainha (Via Bairro Navegantes)</option>
            <option value="012">Fundo Canoas</option>
            <option value="013">Serra Canoas</option>
            <option value="014">Progresso</option>
            <option value="015">Fundo Cobras</option>
            <option value="016">Fundo Itoupava</option>
            <option value="017">Boa Vista</option>
            <option value="018">Ruy Barbosa</option>
            <option value="019">Albertina</option>
            <option value="020">Canta Galo</option>
            <option value="021">Lot. São Pedro (Condomínio Marcolino Felipe)</option>
            <option value="022">Saída do Condomínio</option>
            <option value="023">Loteamento Continental</option>

        </select>
        <input type="text" name="motorista" id="motorista" placeholder="Digite o nome do motorista" required>
        <br>
        <p id="status"></p>
        <br>
        <button type="submit">Iniciar Corrida</button>
    </form>
    <br><br>
    <button type="button" id="encerrarViagem">Encerrar viagem</button>
</div>

<div id="map"></div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCb2OqBOY801jMUD7jcI37VGKbhTuF6OC4&callback=initMap"></script>

<script>
    let map;
    let busMarker;
    let lat_atual;
    let long_atual;
    let intervalId = null;
    const selectLinha = document.getElementById("linha_onibus");
    const InputMotorista = document.getElementById("motorista");
    const encerrarViagem = document.getElementById("encerrarViagem");
    const status = document.getElementById('status');

    function initMap(latitude = -27.2176, longitude = -49.6456) {  
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: latitude, lng: longitude},
            zoom: 14,
            scrollwheel: true, // Permite rolar com o scroll do mouse
            gestureHandling: 'greedy' // Permite rolar e mover o mapa
        });

        busMarker = new google.maps.Marker({
            map: map,
            icon: {
                url: "https://maps.google.com/mapfiles/kml/shapes/bus.png",
                scaledSize: new google.maps.Size(50, 50)
            }
        });

        if (!navigator.geolocation) {
            status.textContent = 'Geolocalização não é suportada pelo seu navegador.';
            return;
        }

        status.textContent = 'Obtendo localização...';

        navigator.geolocation.getCurrentPosition(
            (position) => {
                lat_atual = position.coords.latitude;
                long_atual = position.coords.longitude;

                status.textContent = 'Localização carregada com sucesso';
            },
            (error) => {
                status.textContent = `Erro ao obter localização: ${error.message}`;
            }
        );
    }

    // Função para abrir/fechar o menu
    document.querySelector('label').addEventListener('click', function() {
        const menu = document.querySelector('.menu');
        menu.classList.toggle('open');
    });

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("enviaLocalização");

        form.addEventListener("submit", (event) => {
            // Capturar os dados do formulário
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            // Prevenir o refresh da página
            event.preventDefault();
            //Carrega dados de latitude e longitude
            data.latitude = lat_atual;
            data.longitude = long_atual;
            // Pega texto do campo selecionado de linha
            const selectedLinha = selectLinha.options[selectLinha.selectedIndex];
            const linhaOnibusText = selectedLinha.textContent || selectedLinha.innerText;
            data.nome_linha_onibus = linhaOnibusText;
            
            // Faz request para salvar última posição
            if(data.latitude != null && data.longitude != null){
                makeApiRequest(data);

                showPosition(lat_atual, long_atual);

                // Limpar qualquer intervalo existente antes de iniciar outro
            if (intervalId) {
                clearInterval(intervalId);
            }

            // Configurar intervalo para fazer a requisição a cada 10 segundos
            intervalId = setInterval(() => {
                makeApiRequest(data);
                showPosition(lat_atual, long_atual);
            }, 10000);
                // Bloquear edição do campo até encerrar viagem
                /*if (selectLinha.value !== "") {
                    selectLinha.setAttribute("disabled", true);
                }*/
                // Bloquear edição do campo até encerrar viagem
                if (InputMotorista.value.trim() !== "") {
                    InputMotorista.setAttribute("readonly", true);
                }
             } else {
                status.textContent = 'Localização ainda não carregada!';
             }
        });
    });

    encerrarViagem.addEventListener("click", () => {
        //selectLinha.removeAttribute("disabled");
        InputMotorista.removeAttribute("readonly");

        clearInterval(intervalId);
        console.log("Intervalo parado.");
    });
    
    function makeApiRequest(data) {
        fetch("https://manuproject-787722321547.us-east1.run.app/save", { // Substitua pela sua URL
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            })
            .then((response) => {
                if (!response.ok) {
                    console.log(response);
                    throw new Error("Erro na solicitação");
                }
                console.log("Sucesso na request");
            })
            .then((result) => {
                console.log(JSON.stringify(result));
            })
            .catch((error) => {
                console.log(JSON.stringify(error.message));
            });
    }

    function showPosition(latitude, longitude) {
        const busLocation = {
            lat: latitude,
            lng: longitude
        };

        if (busMarker) {
            busMarker.setMap(null); // Remove o marcador anterior
        }

        const busIcon = {
            url: "img/bus-icon.webp",
            scaledSize: new google.maps.Size(25, 25), // Tamanho do ícone
            origin: new google.maps.Point(0, 0), // Origem do ícone
            anchor: new google.maps.Point(25, 50), // Ponto de ancoragem
        };

        busMarker = new google.maps.Marker({
            position: busLocation,
            map: map,
            icon: busIcon,
            title: "Localização ônibus"
        });
        map.setCenter(busLocation);
    }
</script>
</body>
</html>
