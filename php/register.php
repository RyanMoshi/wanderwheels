<?php
require_once 'db.php'; // Ensure this file contains PDO connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING); // Updated from 'name' to 'username'
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

    // Debugging output
    var_dump($_POST); // Check what data is being received

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Check if any required field is empty
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        die("All fields are required.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (:username, :email, :password, :role)");

        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../login.html");
            exit();
        } else {
            echo "Error: Unable to execute query.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
