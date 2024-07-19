<?php
require 'config.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    header('Location: main_menu.html');
    exit;
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM trips WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $trip = $stmt->fetch();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $departure_time = $_POST['departure_time'];
        $origin = $_POST['origin'];
        $destination = $_POST['destination'];
        
        $stmt = $pdo->prepare("UPDATE trips SET departure_time = ?, origin = ?, destination = ? WHERE id = ?");
        if ($stmt->execute([$departure_time, $origin, $destination, $_GET['id']])) {
            header('Location: view_trips.php');
        } else {
            echo 'Failed to update trip.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Trip</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Trip</h2>
        <form action="" method="post">
            <label for="departure_time">Departure Time:</label>
            <input type="datetime-local" id="departure_time" name="departure_time" value="<?php echo htmlspecialchars($trip['departure_time']); ?>" required>
            <label for="origin">Origin:</label>
            <input type="text" id="origin" name="origin" value="<?php echo htmlspecialchars($trip['origin']); ?>" required>
            <label for="destination">Destination:</label>
            <input type="text" id="destination" name="destination" value="<?php echo htmlspecialchars($trip['destination']); ?>" required>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
