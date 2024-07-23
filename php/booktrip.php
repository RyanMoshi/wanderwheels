<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];

    $sql = "INSERT INTO bookings (user_id, origin, destination, date) VALUES (:user_id, :origin, :destination, :date)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute(['user_id' => $user_id, 'origin' => $origin, 'destination' => $destination, 'date' => $date])) {
        echo "Trip booked successfully!";
    } else {
        echo "Error: Unable to book trip.";
    }
}
?>
