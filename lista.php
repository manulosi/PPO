<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Rota de Ônibus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: auto;
        }
        .navbar {
            background-color: #000;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #fff;
            margin-left: 60px;
        }
        .navbar-nav .nav-link:hover {
            color: #d3d3d3;
        }
        .navbar-toggler-icon {
            background-color: #fff;
        }
        .navbar-nav {
            margin-left: auto;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            width: 100%;
            margin: 70px auto 20px;
        }
        .header {
            margin-bottom: 20px;
        }
        .header h2 {
            color: #000;
            font-size: 24px;
            animation: fadeIn 2s;
        }
        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 2px solid #333;
            font-size: 16px;
            background-color: #f9f9f9;
            color: #333;
            transition: border-color 0.3s;
        }
        input[type="submit"] {
            background-color: #333;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }
        #map {
            height: 80vh;
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
        <h2>Buscar Rota de Ônibus</h2>
    </div>
    <form id="rota-form">
        <label for="origem">Onde você está:</label>
        <input type="text" id="origem" placeholder="Digite sua localização atual" required>

        <label for="destino">Para onde você vai:</label>
        <input type="text" id="destino" placeholder="Digite seu destino" required>

        <input type="submit" value="Ver Rota de Ônibus">
        <div id="resultado" style="margin-top: 20px;"></div>
    </form>
</div>

<div id="map"></div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCb2OqBOY801jMUD7jcI37VGKbhTuF6OC4&callback=initMap"></script>

<script>
    let map;
    let busMarker;
    let directionsService;
    let directionsRenderer;
    let geocoder;
    let stepIndex = 0;
    let steps = [];
    const speed = 30; // Velocidade do ônibus em km/h

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -27.2176, lng: -49.6456 },
            zoom: 14,
            scrollwheel: true,
            gestureHandling: 'greedy'
        });

        busMarker = new google.maps.Marker({
            map: map,
            icon: {
                url: "https://maps.google.com/mapfiles/kml/shapes/bus.png",
                scaledSize: new google.maps.Size(50, 50)
            }
        });

        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({ map: map });
        geocoder = new google.maps.Geocoder();

        document.getElementById('rota-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const origem = document.getElementById('origem').value;
            const destino = document.getElementById('destino').value;

            if (origem && destino) {
                geocodeAddress(origem, destino);
            } else {
                alert('Por favor, preencha os dois campos.');
            }
        });
    }

    function geocodeAddress(origem, destino) {
        geocoder.geocode({ address: origem + ', Rio do Sul, SC' }, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                const start = results[0].geometry.location;
                geocoder.geocode({ address: destino + ', Rio do Sul, SC' }, function(results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        const end = results[0].geometry.location;
                        calculateRoute(start, end);
                    } else {
                        alert('Não foi possível encontrar o destino. Tente novamente.');
                    }
                });
            } else {
                alert('Não foi possível encontrar a origem. Tente novamente.');
            }
        });
    }

    function calculateRoute(start, end) {
        directionsService.route({
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode.DRIVING,
            provideRouteAlternatives: false
        }, function(response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsRenderer.setDirections(response);
                const routeLegs = response.routes[0].legs[0];
                const distanceInKm = routeLegs.distance.value / 1000; // Convertendo de metros para quilômetros

                // Calculando o tempo estimado com a velocidade do ônibus
                const estimatedTime = distanceInKm / speed; // Tempo em horas
                const estimatedTimeInMinutes = estimatedTime * 60; // Tempo em minutos

                // Exibindo a distância e o tempo estimado
                document.getElementById('resultado').innerHTML = `
                    <p>Distância: ${distanceInKm.toFixed(2)} km</p>
                    <p>Tempo estimado de viagem: ${estimatedTimeInMinutes.toFixed(0)} minutos</p>
                `;

                steps = routeLegs.steps;
                stepIndex = 0;
                moveBus(() => {
                    moveBusToTerminal();
                });
            } else {
                document.getElementById('resultado').innerHTML = '<p>Não foi possível encontrar uma rota. Tente novamente.</p>';
            }
        });
    }

    function moveBus(callback) {
        if (stepIndex < steps.length) {
            const step = steps[stepIndex];
            const stepLocation = step.start_location;

            busMarker.setPosition(stepLocation);
            map.setCenter(stepLocation);

            const stepDuration = step.duration.value / 60; // Tempo total do passo em minutos
            const stepInterval = (stepDuration / (speed / 60)) * 1000; // Intervalo de atualização baseado na velocidade do ônibus

            const stepDistance = google.maps.geometry.spherical.computeDistanceBetween(
                step.start_location, step.end_location
            );

            const stepAnimationDuration = stepDistance / (speed * 1000 / 3600) * 1000;

            let animationStart = Date.now();

            function animate() {
                const elapsed = Date.now() - animationStart;
                const progress = Math.min(elapsed / stepAnimationDuration, 1);
                const newLatLng = google.maps.geometry.spherical.interpolate(
                    step.start_location, step.end_location, progress
                );

                busMarker.setPosition(newLatLng);
                map.setCenter(newLatLng);

                if (progress < 1) {
                    requestAnimationFrame(animate);
                } else {
                    stepIndex++;
                    if (stepIndex < steps.length) {
                        moveBus(callback);
                    } else {
                        callback();
                    }
                }
            }

            animate();
        }
    }

    function moveBusToTerminal() {
        const terminalLatLng = new google.maps.LatLng(-27.2100, -49.6500);

        const directionsServiceToTerminal = new google.maps.DirectionsService();
        const directionsRendererToTerminal = new google.maps.DirectionsRenderer({ map: map });

        directionsServiceToTerminal.route({
            origin: busMarker.getPosition(),
            destination: terminalLatLng,
            travelMode: google.maps.TravelMode.DRIVING,
            provideRouteAlternatives: false
        }, function(response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsRendererToTerminal.setDirections(response);
                const routeLegs = response.routes[0].legs[0];
                const stepsToTerminal = routeLegs.steps;
                stepIndex = 0;
                steps = stepsToTerminal;
                moveBus(() => {
                    console.log("Ônibus chegou no terminal!");
                });
            } else {
                alert("Não foi possível calcular a rota para o terminal.");
            }
        });
    }
</script>

</body>
</html>
