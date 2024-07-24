<?php
session_start();
<<<<<<< HEAD
require_once 'db.php'; // Ensure this file contains MySQLi connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure that user_id is set in the session
    if (!isset($_SESSION['user_id'])) {
        die("User not logged in.");
=======
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];

    $sql = "INSERT INTO bookings (user_id, origin, destination, date) VALUES (:user_id, :origin, :destination, :date)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute(['user_id' => $user_id, 'origin' => $origin, 'destination' => $destination, 'date' => $date])) {
        echo "Trip booked successfully!";
    } else {
        echo "Error: Unable to book trip.";
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
    }
    $user_id = $_SESSION['user_id'];

    // Retrieve and sanitize POST data
    $origin = filter_input(INPUT_POST, 'origin', FILTER_SANITIZE_STRING);
    $destination = filter_input(INPUT_POST, 'destination', FILTER_SANITIZE_STRING);
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);

    // Check if all required fields are provided
    if (empty($origin) || empty($destination) || empty($date)) {
        die("All fields are required.");
    }

    // Prepare SQL query
    $sql = "INSERT INTO bookings (user_id, origin, destination, date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if prepare was successful
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("isss", $user_id, $origin, $destination, $date);

    if ($stmt->execute()) {
        echo "Trip booked successfully!";
    } else {
        echo "Error: Unable to book trip.";
    }

    // Close statement
    $stmt->close();
}
?>
