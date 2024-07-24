<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'user') {
    header('Location: login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - WanderWheels</title>
    <link rel="stylesheet" href="css/user.css">
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
<<<<<<< HEAD
        <!-- PHP to show the username -->
=======
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
        <h1>
            <?php 
            if (isset($_SESSION['username'])) {
                echo 'Welcome, ' . htmlspecialchars($_SESSION['username']);
            } else {
                echo 'Welcome, Guest!';
            }
            ?>
        </h1>
<<<<<<< HEAD

=======
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
        <section id="book-trip">
            <h2><i class="fas fa-car"></i> Book Trip</h2>
            <form id="trip-form" action="php/booktrip.php" method="POST">
                <label for="origin">Origin:</label>
                <input type="text" id="origin" name="origin" required>
                <label for="destination">Destination:</label>
                <input type="text" id="destination" name="destination" required>
                <label for="date">Date:</label>
                <input type="datetime-local" id="date" name="date" required>
                <button type="submit" class="btn">Book Trip</button>
            </form>
        </section>

        <section id="cancel-trip">
            <h2><i class="fas fa-times-circle"></i> Cancel Trip</h2>
            <form id="cancel-trip-form" action="php/canceltrip.php" method="POST">
                <label for="trip-id">Trip ID:</label>
                <input type="text" id="trip-id" name="trip_id" required>
                <button type="submit" class="btn">Cancel Trip</button>
            </form>
        </section>
        
        <section id="traffic">
            <h2><i class="fas fa-traffic-light"></i> Traffic Information</h2>
            <form id="traffic-form" action="php/traffic.php" method="POST">
                <label for="location">Enter Location:</label>
                <input type="text" id="location" name="location" required>
                <button type="submit" class="btn">Get Traffic Updates</button>
            </form>
            <div id="traffic-info">
                <!-- Traffic information will be dynamically loaded here -->
            </div>
        </section>
    </main>
    <script src="js/user.js"></script>
</body>
</html>
