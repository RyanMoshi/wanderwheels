<?php
session_start();
include 'db.php'; // Ensure this file correctly sets up the $conn variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        echo "Error: User not logged in.";
        exit();
    }

    $trip_id = $_POST['trip_id'];
    $user_id = $_SESSION['user_id'];

    // Check if trip_id and user_id are valid (numeric)
    if (!is_numeric($trip_id) || !is_numeric($user_id)) {
        echo "Error: Invalid trip ID or user ID.";
        exit();
    }

    // Prepare and execute the statement
    $sql = "DELETE FROM bookings WHERE id = ? AND user_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $trip_id, $user_id);
        if ($stmt->execute()) {
            // Check if any rows were affected
            if ($stmt->affected_rows > 0) {
                echo "Trip canceled successfully!";
            } else {
                echo "Error: No matching trip found.";
            }
        } else {
            echo "Error: Unable to execute the statement.";
        }
        $stmt->close();
    } else {
        echo "Error: Unable to prepare the statement.";
    }

    $conn->close();
}
?>
