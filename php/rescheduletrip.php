<?php
session_start();
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$trip_id = $data['trip_id'];
$new_date = $data['new_date'];

$sql = "UPDATE bookings SET date='$new_date' WHERE id='$trip_id'";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
