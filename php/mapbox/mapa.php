<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Si se recibe una solicitud POST, obtener los valores de distancia y duración
      $distance = $_POST['distance'];
      $duration = $_POST['duration'];

      // Imprimir los valores en el código JavaScript
      echo "var distance = " . $distance . ";";
      echo "var duration = " . $duration . ";";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FleteAr</title>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css" type="text/css" />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.css" type="text/css" />
    <link rel='stylesheet' href='assets/css/styles.css' charset="utf-8"/>
    <style>
        .mapbox-directions-profiles .mapbox-directions-profile-option:not([data-profile="driving"]) {
            display: none;
        }
        
        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }

        #map-container {
            position: relative;
            width: 100%;
            height: 400px; /* Ajusta la altura del contenedor del mapa según tus necesidades */
            margin-top: 60px;
        }

        #distanceInput,
        #durationInput {
            margin-top: 10px;
        }

        #info-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="map-container">
        <div id="map"></div>
    </div>

    <div id="info-container">
        <input type="text" id="distanceInput" placeholder="Distancia" readonly disabled>
        <input type="text" id="durationInput" placeholder="Duración" readonly disabled>
    </div>

    <script src="https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>

    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.js"></script>

    <script>
        let map = null;

        mapboxgl.accessToken = 'YOUR_ACCESS_TOKEN';
        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [-65.779, -28.469],
            zoom: 14,
            attribution: '© Data <a href="https://openstreetmap.org/copyright/">OpenStreetMap</a> © Map <a href="https://mapbox.com/">Mapbox</a>'
        });

        map.on('load', function() {
            var directionsControl = new MapboxDirections({
                accessToken: mapboxgl.accessToken,
                unit: 'metric',
                language: 'es',
                geocoder: new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    countries: 'ar',
                    mapboxgl: mapboxgl
                })
            });

            map.addControl(directionsControl);

            directionsControl.on('route', function(e) {
                var route = e.route[0]; // Tomar la primera ruta (ruta principal)
                var distance = route.distance / 1000; // Kilómetros
                var duration = route.duration / 60; // Minutos

                // Asignar los valores a los elementos <input> fuera del contenedor del mapa
                document.getElementById('distanceInput').value = distance.toFixed(2) + " km";
                document.getElementById('durationInput').value = duration.toFixed(2) + " minutos";
            });
        });
    </script>
</body>
</html>
