<?php
require 'config.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    header('Location: main_menu.html');
    exit;
}

// Fetch users and trips for display
$usersStmt = $pdo->query("SELECT * FROM users");
$users = $usersStmt->fetchAll();

$tripsStmt = $pdo->query("SELECT trips.*, users.username FROM trips JOIN users ON trips.user_id = users.id");
$trips = $tripsStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="assets/logo/logolight.png" alt="WanderWheel" class="logo">
        </div>
        <h2>Admin Panel</h2>
        
        <h3>Manage Users</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <a href="php/edituser.php?id=<?php echo $user['id']; ?>">Edit</a>
                        <a href="php/deleteuser.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Manage Trips</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Departure Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trips as $trip): ?>
                <tr>
                    <td><?php echo htmlspecialchars($trip['id']); ?></td>
                    <td><?php echo htmlspecialchars($trip['username']); ?></td>
                    <td><?php echo htmlspecialchars($trip['origin']); ?></td>
                    <td><?php echo htmlspecialchars($trip['destination']); ?></td>
                    <td><?php echo htmlspecialchars($trip['departure_time']); ?></td>
                    <td>
                        <a href="php/edittrip.php?id=<?php echo $trip['id']; ?>">Edit</a>
                        <a href="php/deletetrip.php?id=<?php echo $trip['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
