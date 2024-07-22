<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trip_id = $_POST['trip_id'];

    $sql = "DELETE FROM bookings WHERE id='$trip_id' AND user_id='".$_SESSION['user_id']."'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../user.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
