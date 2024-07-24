<?php
session_start();
include 'db.php';

// Check if user is logged in and has the 'user' role
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'user') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Get the user ID from session
$user_id = $_SESSION['user_id'];

// Decode the JSON input
$data = json_decode(file_get_contents('php://input'), true);
$trip_id = $data['trip_id'];

// Prepare and execute a query to check if the trip belongs to the user
$stmt = $conn->prepare("SELECT id FROM bookings WHERE id = ? AND user_id = ?");
$stmt->bind_param('ii', $trip_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Trip belongs to the user, proceed with deletion
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
    $stmt->bind_param('ii', $trip_id, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete the trip']);
    }
    $stmt->close();
} else {
    // Trip does not belong to the user
    echo json_encode(['success' => false, 'message' => 'You are not authorized to cancel this trip']);
}

$conn->close();
?>
