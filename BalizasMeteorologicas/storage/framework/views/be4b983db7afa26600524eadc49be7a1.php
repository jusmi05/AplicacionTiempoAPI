<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css">
    <title>Aplicación del Tiempo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        #map {
            height: 80vh;
            width: 80%;
            display: block;
        }
        #details {
            display: none;
            text-align: center;
        }
        #details h1 {
            margin-bottom: 20px;
        }
        #back-button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #back-button:hover {
            background-color: #0056b3;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
</head>
<body>
    <!-- Mapa -->
    <div id="map"></div>

    <!-- Detalles de la ciudad -->
    <div id="details">
        <h1 id="city-name"></h1>
        <button id="back-button">Volver al mapa</button>
    </div>

    <script>
        // Llamar al método del controlador desde PHP y convertir los datos a JSON
        const estaciones = <?php echo json_encode(App\Http\Controllers\EstacionController::getEstaciones(), 15, 512) ?>;

        // Referencias a elementos
        const mapElement = document.getElementById('map');
        const detailsElement = document.getElementById('details');
        const cityNameElement = document.getElementById('city-name');
        const backButton = document.getElementById('back-button');

        // Inicializar el mapa
        const map = L.map('map').setView([43.17416597, -2.306332108], 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Agregar marcadores al mapa
        estaciones.forEach(estacion => {
            const marker = L.marker([estacion.latitud, estacion.longitud]).addTo(map);
            marker.bindPopup(`<b>${estacion.municipio}</b>`);

            // Añadir evento click para cada marcador
            marker.on('click', () => {
                showDetails(estacion.municipio);
            });
        });

        // Función para mostrar los detalles de la ciudad
        function showDetails(cityName) {
            // Ocultar el mapa y mostrar los detalles
            mapElement.style.display = 'none';
            detailsElement.style.display = 'block';
            cityNameElement.textContent = `Ciudad seleccionada: ${cityName}`;
        }

        // Volver al mapa
        backButton.addEventListener('click', () => {
            // Mostrar el mapa y ocultar los detalles
            mapElement.style.display = 'block';
            detailsElement.style.display = 'none';
        });
    </script>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/app.blade.php ENDPATH**/ ?>