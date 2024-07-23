<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trip_id = $_POST['trip_id'];
    $user_id = $_SESSION['user_id'];

    $sql = "DELETE FROM bookings WHERE id = :trip_id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute(['trip_id' => $trip_id, 'user_id' => $user_id])) {
        echo "Trip canceled successfully!";
    } else {
        echo "Error: Unable to cancel trip.";
    }
}
?>
