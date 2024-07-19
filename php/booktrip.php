<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $departure_time = $_POST['departure_time'];

    $stmt = $pdo->prepare("INSERT INTO trips_tbl (user_id, origin, destination, departure_time) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $origin, $destination, $departure_time])) {
        header('Location: ../mainpage.html');
    } else {
        $error = 'Failed to book trip.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Trip</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="assets/logo/logolight.png" alt="WanderWheel" class="logo">
        </div>
        <h2>Book a Trip</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="origin">Origin:</label>
            <input type="text" id="origin" name="origin" required readonly>
            
            <label for="destination">Destination:</label>
            <input type="text" id="destination" name="destination" required readonly>
            
            <label for="departure_time">Departure Time:</label>
            <input type="datetime-local" id="departure_time" name="departure_time" required>
            
            <div id="map" style="height: 400px;"></div>
            <p>Click on the map to select the origin and destination.</p>
            
            <button type="submit">Book Trip</button>
        </form>
    </div>
    <script>
        var map = L.map('map').setView([0, 0], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var markers = [];

        map.on('click', function(e) {
            if (markers.length < 2) {
                var marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
                markers.push(marker);

                if (markers.length === 1) {
                    document.getElementById('origin').value = `${e.latlng.lat}, ${e.latlng.lng}`;
                } else {
                    document.getElementById('destination').value = `${e.latlng.lat}, ${e.latlng.lng}`;
                    var polyline = L.polyline([markers[0].getLatLng(), markers[1].getLatLng()], {color: 'blue'}).addTo(map);
                }
            }
        });
    </script>
</body>
</html>
