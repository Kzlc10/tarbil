<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMO ve Tarım Kredi Lokasyonları</title>
    <style>
        /* Sayfa ve harita stili */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        #map {
            height: 100%;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; padding: 1rem; background-color: #4CAF50; color: white;">
        TMO ve Tarım Kredi Lokasyonları
    </h1>
    <div id="map"></div>

    <script>
        // TMO konumları (örnek veriler)
        const tmoLocations = [
            { name: "TMO Ankara", lat: 39.92077, lng: 32.85411 },
            { name: "TMO İstanbul", lat: 41.01384, lng: 28.94966 },
            { name: "TMO İzmir", lat: 38.41925, lng: 27.12872 },
            { name: "TMO Adana", lat: 37.00255, lng: 35.32133 },
            { name: "TMO Bursa", lat: 40.18257, lng: 29.06755 }
        ];

        // Tarım Kredi Kooperatifleri konumları (örnek veriler)
        const tarimKrediLocations = [
            { name: "Tarım Kredi Ankara", lat: 39.93336, lng: 32.85974 },
            { name: "Tarım Kredi İstanbul", lat: 41.03508, lng: 28.97681 },
            { name: "Tarım Kredi İzmir", lat: 38.41925, lng: 27.14333 },
            { name: "Tarım Kredi Konya", lat: 37.87135, lng: 32.48464 },
            { name: "Tarım Kredi Samsun", lat: 41.28667, lng: 36.33128 }
        ];

        // Harita yükleme fonksiyonu
        function initMap() {
            // Haritanın merkezi
            const center = { lat: 39.92077, lng: 32.85411 }; // Ankara

            // Haritayı oluştur
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 6,
                center: center
            });

            // TMO markerlarını ekle
            tmoLocations.forEach(location => {
                const marker = new google.maps.Marker({
                    position: { lat: location.lat, lng: location.lng },
                    map: map,
                    title: location.name,
                    icon: "https://maps.google.com/mapfiles/ms/icons/red-dot.png" // Kırmızı marker
                });

                // Bilgi penceresi
                const infoWindow = new google.maps.InfoWindow({
                    content: `<h3>${location.name}</h3>`
                });

                // Marker tıklama olayını bağla
                marker.addListener("click", () => {
                    infoWindow.open(map, marker);
                });
            });

            // Tarım Kredi markerlarını ekle
            tarimKrediLocations.forEach(location => {
                const marker = new google.maps.Marker({
                    position: { lat: location.lat, lng: location.lng },
                    map: map,
                    title: location.name,
                    icon: "https://maps.google.com/mapfiles/ms/icons/green-dot.png" // Yeşil marker
                });

                // Bilgi penceresi
                const infoWindow = new google.maps.InfoWindow({
                    content: `<h3>${location.name}</h3>`
                });

                // Marker tıklama olayını bağla
                marker.addListener("click", () => {
                    infoWindow.open(map, marker);
                });
            });
        }
    </script>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
</body>
</html>
