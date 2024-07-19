<?php
require 'config.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    header('Location: main_menu.html');
    exit;
}

$stmt = $pdo->query("SELECT trips.*, users.username FROM trips JOIN users ON trips.user_id = users.id");
$trips = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Trips</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Trips</h2>
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
                        <a href="edit_trip.php?id=<?php echo $trip['id']; ?>">Edit</a>
                        <a href="delete_trip.php?id=<?php echo $trip['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
