<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'user') {
    header('Location: ../login.html');
    exit();
}

require 'db.php'; // Add your database connection details here

$username = $_SESSION['username'];

// Fetch the user's most recent trip destination
$query = "SELECT destination FROM trips WHERE username = ? ORDER BY date DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$destination = '';

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $destination = $row['destination'];
}

echo json_encode(['destination' => $destination]);
?>
