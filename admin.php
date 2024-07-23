<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'admin') {
    header('Location: login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - WanderWheels</title>
    <link rel="stylesheet" href="css/admin.css">
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
        <h1>Welcome, Admin!</h1>
        <section id="view-users">
            <h2><i class="fas fa-users"></i> View Users</h2>
            <div id="user-list">
                <!-- User details will be dynamically loaded here -->
            </div>
        </section>
        <section id="view-trips">
            <h2><i class="fas fa-road"></i> View Trips</h2>
            <div id="trip-list">
                <!-- Trip details will be dynamically loaded here -->
            </div>
        </section>
        <section id="manage-trips">
            <h2><i class="fas fa-cogs"></i> Manage Trips</h2>
            <form id="authorize-trip-form">
                <label for="trip-id">Trip ID:</label>
                <input type="text" id="trip-id" name="trip_id" required>
                <button type="submit" class="btn">Authorize Trip</button>
            </form>
            <form id="reschedule-trip-form">
                <label for="trip-id-reschedule">Trip ID:</label>
                <input type="text" id="trip-id-reschedule" name="trip_id" required>
                <label for="new-date">New Date:</label>
                <input type="datetime-local" id="new-date" name="new_date" required>
                <button type="submit" class="btn">Reschedule Trip</button>
            </form>
            <form id="delete-trip-form">
                <label for="trip-id-delete">Trip ID:</label>
                <input type="text" id="trip-id-delete" name="trip_id" required>
                <button type="submit" class="btn">Delete Trip</button>
            </form>
        </section>
        <section id="traffic">
            <h2><i class="fas fa-traffic-light"></i> Traffic Information</h2>
            <div id="map"></div>
        </section>
    </main>
    <script src="js/admin.js"></script>
</body>

</html>
