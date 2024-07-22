<?php
session_start();
include 'db.php';

$driver_id = $_SESSION['user_id'];
$sql = "SELECT * FROM bookings WHERE driver_id='$driver_id'";
$result = $conn->query($sql);

$trips = array();
while ($row = $result->fetch_assoc()) {
    $trips[] = $row;
}

echo json_encode($trips);
?>
