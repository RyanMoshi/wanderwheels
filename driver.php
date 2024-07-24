<?php
session_start();
<<<<<<< HEAD
require_once 'php/db.php';

=======
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'driver') {
    header('Location: login.html');
    exit();
}
<<<<<<< HEAD

// Fetch the logged-in user's name
$user_id = $_SESSION['user_id'];
$user_id = $conn->real_escape_string($user_id);
$sql = "SELECT name FROM users WHERE id = '$user_id' AND role = 'driver'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_name = htmlspecialchars($user['name']);
} else {
    $user_name = 'Guest';
}

// Fetch pending bookings
$sql = "SELECT * FROM bookings WHERE status = 'pending'";
$result = $conn->query($sql);
$pending_bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pending_bookings[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
=======
?>
<!DOCTYPE html>
<html lang="en">

>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard - WanderWheels</title>
    <link rel="stylesheet" href="css/driver.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<<<<<<< HEAD
</head>
=======
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
</head>

>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
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
        <h1>Welcome, <?php echo $user_name; ?>!</h1>
        <section id="trip-schedule">
            <h2><i class="fas fa-calendar-alt"></i> Pending Bookings</h2>
            <div id="trip-list">
                <?php if (empty($pending_bookings)): ?>
                    <p>No pending bookings.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Trip ID</th>
                                <th>Origin</th>
                                <th>Destination</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pending_bookings as $booking): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($booking['id']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['origin']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['destination']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['date']); ?></td>
                                    <td>
                                        <form action="php/authorizetrip.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['id']); ?>">
                                            <button type="submit">Approve</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
=======
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
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
            </div>
        </section>
        <section id="traffic">
            <h2><i class="fas fa-traffic-light"></i> Traffic Information</h2>
<<<<<<< HEAD
            <form id="traffic-form">
                <label for="location">Enter Location:</label>
                <input type="text" id="location" name="location" required>
                <button type="submit" class="btn">Get Traffic Updates</button>
            </form>
            <div id="traffic-info">
                <!-- Traffic information will be dynamically loaded here -->
            </div>
        </section>
    </main>
</body>
=======
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

>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
</html>
