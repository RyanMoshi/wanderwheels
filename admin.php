<?php
session_start();
<<<<<<< HEAD
require_once 'php/db.php'; // Ensure this file contains mysqli connection setup

=======
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'admin') {
    header('Location: login.html');
    exit();
}
<<<<<<< HEAD

$users = [];
$trips = [];
$tripMessage = '';
$showUsers = false;
$showTrips = false;

if (isset($_POST['fetch_users'])) {
    // Fetch user details
    $sql = "SELECT id, name, email, role FROM users";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        $showUsers = true;
    }
}

if (isset($_POST['hide_users'])) {
    $showUsers = false;
}

if (isset($_POST['fetch_trips'])) {
    // Fetch trip details
    $sql = "SELECT id, user_id, driver_id, origin, destination, date, status FROM bookings";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $trips[] = $row;
        }
        $showTrips = true;
    }
}

if (isset($_POST['hide_trips'])) {
    $showTrips = false;
}

if (isset($_POST['delete_trip'])) {
    $trip_id = $_POST['trip_id'];
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $trip_id);
    if ($stmt->execute()) {
        $tripMessage = "Trip ID $trip_id deleted successfully.";
    } else {
        $tripMessage = "Error deleting trip: " . $stmt->error;
    }
    $stmt->close();
}

if (isset($_POST['reschedule_trip'])) {
    $trip_id = $_POST['trip_id'];
    $new_date = $_POST['new_date'];

    // Validate date format
    if (DateTime::createFromFormat('Y-m-d\TH:i', $new_date) !== false) {
        $stmt = $conn->prepare("UPDATE bookings SET date = ? WHERE id = ?");
        $stmt->bind_param("si", $new_date, $trip_id);
        if ($stmt->execute()) {
            $tripMessage = "Trip ID $trip_id rescheduled to $new_date successfully.";
        } else {
            $tripMessage = "Error rescheduling trip: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $tripMessage = "Invalid date format. Please use YYYY-MM-DDTHH:MM format.";
    }
}
=======
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - WanderWheels</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<<<<<<< HEAD
=======
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
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
<<<<<<< HEAD
        
        <section id="view-users">
            <h2><i class="fas fa-users"></i> View Users</h2>
            <form method="POST" action="">
                <button type="submit" name="fetch_users" class="btn">Show Users</button>
                <button type="submit" name="hide_users" class="btn">Hide Users</button>
            </form>
            <div id="user-list-container">
                <div id="user-list">
                    <?php if ($showUsers): ?>
                        <?php if (empty($users)): ?>
                            <p>No users found.</p>
                        <?php else: ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section id="view-trips">
            <h2><i class="fas fa-road"></i> View Trips</h2>
            <form method="POST" action="">
                <button type="submit" name="fetch_trips" class="btn">Show Trips</button>
                <button type="submit" name="hide_trips" class="btn">Hide Trips</button>
            </form>
            <div id="trip-list">
                <?php if ($showTrips): ?>
                    <?php if (empty($trips)): ?>
                        <p>No trips found.</p>
                    <?php else: ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User ID</th>
                                    <th>Driver ID</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($trips as $trip): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($trip['id']); ?></td>
                                        <td><?php echo htmlspecialchars($trip['user_id']); ?></td>
                                        <td><?php echo htmlspecialchars($trip['driver_id']); ?></td>
                                        <td><?php echo htmlspecialchars($trip['origin']); ?></td>
                                        <td><?php echo htmlspecialchars($trip['destination']); ?></td>
                                        <td><?php echo htmlspecialchars($trip['date']); ?></td>
                                        <td><?php echo htmlspecialchars($trip['status']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </section>

        <section id="manage-trips">
            <h2><i class="fas fa-cogs"></i> Manage Trips</h2>
            <p><?php echo $tripMessage; ?></p>
            <form id="authorize-trip-form" method="POST" action="">
                <label for="trip-id">Trip ID:</label>
                <input type="text" id="trip-id" name="trip_id" required>
                <button type="submit" name="authorize_trip" class="btn">Authorize Trip</button>
            </form>
            <form id="reschedule-trip-form" method="POST" action="">
=======
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
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
                <label for="trip-id-reschedule">Trip ID:</label>
                <input type="text" id="trip-id-reschedule" name="trip_id" required>
                <label for="new-date">New Date:</label>
                <input type="datetime-local" id="new-date" name="new_date" required>
<<<<<<< HEAD
                <button type="submit" name="reschedule_trip" class="btn">Reschedule Trip</button>
            </form>
            <form id="delete-trip-form" method="POST" action="">
                <label for="trip-id-delete">Trip ID:</label>
                <input type="text" id="trip-id-delete" name="trip_id" required>
                <button type="submit" name="delete_trip" class="btn">Delete Trip</button>
            </form>
        </section>

=======
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
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
    </main>
    <script src="js/admin.js"></script>
</body>

</html>
