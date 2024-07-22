<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM bookings WHERE user_id='$user_id'";
$result = $conn->query($sql);

$trips = array();
while ($row = $result->fetch_assoc()) {
    $trips[] = $row;
}

echo json_encode($trips);
?>
