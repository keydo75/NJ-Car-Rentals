<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drop-off Location Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map { height: 400px; width: 100%; }
    </style>
</head>
<body>
    <h2>Select Drop-off Location</h2>
    <form method="POST" action="/save-dropoff">
        <div id="map"></div>
        <input type="hidden" id="dropoff_lat" name="dropoff_lat">
        <input type="hidden" id="dropoff_lng" name="dropoff_lng">
        <button type="submit">Save Location</button>
    </form>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
      var map = L.map('map').setView([14.5995, 120.9842], 13); // Example: Manila
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
      }).addTo(map);
      var marker;
      map.on('click', function(e) {
        var latlng = e.latlng;
        if (marker) {
          marker.setLatLng(latlng);
        } else {
          marker = L.marker(latlng).addTo(map);
        }
        document.getElementById('dropoff_lat').value = latlng.lat;
        document.getElementById('dropoff_lng').value = latlng.lng;
      });
    </script>
</body>
</html>
