<?php
session_start();
require_once 'php/db.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'driver') {
    header('Location: login.html');
    exit();
}

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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard - WanderWheels</title>
    <link rel="stylesheet" href="css/driver.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            </div>
        </section>
        <section id="traffic">
            <h2><i class="fas fa-traffic-light"></i> Traffic Information</h2>
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
</html>
