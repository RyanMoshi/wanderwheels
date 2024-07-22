<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driver_id = $_SESSION['user_id'];
    $availability = $_POST['availability'];

    $sql = "UPDATE drivers SET availability='$availability' WHERE id='$driver_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../driver.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
