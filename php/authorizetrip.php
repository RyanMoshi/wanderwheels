<?php
session_start();
require_once 'db.php'; // Adjust this path as needed

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'driver') {
    header('Location: login.html');
    exit();
}

// Ensure the driver ID from the session is valid
$driver_id = $_SESSION['user_id'];

// Sanitize the driver ID
$driver_id = $conn->real_escape_string($driver_id);

// Check if the driver ID exists in the users table and has the role of 'driver'
$check_driver_sql = "SELECT id FROM users WHERE id = '$driver_id' AND role = 'driver'";
$check_result = $conn->query($check_driver_sql);

if ($check_result->num_rows == 0) {
    echo "Invalid driver ID. Update failed.<br>";
    exit();
}

// Check if booking_id is set in POST request
if (isset($_POST['booking_id'])) {
    $booking_id = $conn->real_escape_string($_POST['booking_id']);
    
    // Update the selected booking status and assign driver ID
    $update_sql = "UPDATE bookings SET status='authorized', driver_id='$driver_id' WHERE id='$booking_id'";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "Booking ID $booking_id updated successfully!<br>";
    } else {
        echo "Error updating Booking ID $booking_id: " . $conn->error . "<br>";
    }
} else {
    echo "No booking ID provided.";
}
?>
