<?php
session_start();
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'];

$sql = "DELETE FROM users WHERE id='$user_id'";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
