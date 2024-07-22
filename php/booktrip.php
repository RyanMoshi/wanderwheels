<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];

    $sql = "INSERT INTO bookings (user_id, origin, destination, date) VALUES ('$user_id', '$origin', '$destination', '$date')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../user.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
