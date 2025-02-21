<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'driver') {
    header('Location: login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard - WanderWheels</title>
    <link rel="stylesheet" href="css/driver.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
</head>

<body>
    <header>
        <img src="assets/logo/logolight.png" alt="WanderWheels Logo" class="logo">
        <nav>
            <ul>
                <li><a href="php/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
    <h1>
            <?php 
            if (isset($_SESSION['username'])) {
                echo 'Welcome, ' . htmlspecialchars($_SESSION['username']);
            } else {
                echo 'Welcome, Guest!';
            }
            ?>
        </h1>
        <section id="trip-schedule">
            <h2><i class="fas fa-calendar-alt"></i> Trip Schedule</h2>
            <div id="trip-list">
                <!-- Trip details will be dynamically loaded here -->
            </div>
        </section>
        <section id="traffic">
            <h2><i class="fas fa-traffic-light"></i> Traffic Information</h2>
            <div id="map"></div>
        </section>
        <section id="availability">
            <h2><i class="fas fa-check-circle"></i> Confirm Availability</h2>
            <form action="php/driveravailability.php" method="POST">
                <label for="availability">Are you available?</label>
                <select id="availability" name="availability" required>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <button type="submit" class="btn">Confirm</button>
            </form>
        </section>
    </main>
    <script src="js/driver.js"></script>
</body>

</html>
