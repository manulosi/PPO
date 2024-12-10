<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa com Pontos de Ônibus</title>
    <style>
        /* Defina a altura do mapa para garantir que ele seja visível */
        #map {
            height: 100vh; /* 100% da altura da viewport */
            width: 100%;   /* 100% da largura da viewport */
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <!-- Inclua a biblioteca do Google Maps API com sua chave de API -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCb2OqBOY801jMUD7jcI37VGKbhTuF6OC4&callback=initMap"></script>
    
    <script>
        function initMap() {
            // Cria um objeto de mapa e define as opções
            var mapOptions = {
                center: { lat: -27.2123530, lng: -49.6345052 }, // Coordenadas para o centro de Rio do Sul
                zoom: 14, // Nível de zoom
            };

            var map = new google.maps.Map(document.getElementById('map'), mapOptions);

            // Cria um objeto DirectionsService e DirectionsRenderer
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            // Define as coordenadas de origem e destino
            var start = new google.maps.LatLng(-27.2123530, -49.6345052); // Centro - Rio do Sul
            var end = new google.maps.LatLng(-27.18935, -49.60648); // Navegantes - Rio do Sul

            // Configura a solicitação de direções
            var request = {
                origin: start,
                destination: end,
                travelMode: google.maps.TravelMode.DRIVING // Modo de transporte: DIRIGINDO
            };

            // Solicita e exibe a rota
            directionsService.route(request, function(result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsRenderer.setDirections(result);
                } else {
                    console.error('Erro ao buscar direções: ' + status);
                }
            });

            // Adiciona marcadores para os pontos de ônibus
            var busStops = [
    { lat: -27.210691, lng: -49.643487, title: 'Ponto de Ônibus - Centro de Rio do Sul' },
    { lat: -27.212353, lng: -49.634505, title: 'Ponto de Ônibus - Terminal Rodoviário' },
    { lat: -27.189350, lng: -49.606480, title: 'Ponto de Ônibus - Navegantes' },
    { lat: -27.205951, lng: -49.654320, title: 'Ponto de Ônibus - Santana' },
    { lat: -27.197318, lng: -49.642573, title: 'Ponto de Ônibus - Barragem' },
    { lat: -27.223101, lng: -49.621809, title: 'Ponto de Ônibus - Canta Galo' },
    { lat: -27.195398, lng: -49.643238, title: 'Ponto de Ônibus - Jardim América' }
];


            busStops.forEach(function(busStop) {
                new google.maps.Marker({
                    position: { lat: busStop.lat, lng: busStop.lng },
                    map: map,
                    title: busStop.title,
                    icon: {
                        url: "https://maps.google.com/mapfiles/kml/shapes/bus.png", // Ícone de ônibus
                        scaledSize: new google.maps.Size(40, 40) // Tamanho do ícone
                    }
                });
            });
        }
    </script>
</body>
</html>
