<?php
require_once 'db.php'; // Ensure this file contains MySQLi connection setup

function registerUser($conn, $name, $email, $password, $confirm_password, $role) {
    // Sanitize and validate input
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $role = filter_var($role, FILTER_SANITIZE_STRING);

    // Check if any required field is empty
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        die("All fields are required.");
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the user already exists
    $check_sql = "SELECT * FROM users WHERE name = ? OR email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $name, $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('User already exists'); window.location.href = 'register.html';</script>";
        exit;
    }

    // Insert user into the database
    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

    // Execute the statement
    if ($stmt->execute()) {
        // Use header() for redirection
        header("Location: ../login.html");
        exit();
    } else {
        echo "Error: Unable to execute query.";
    }

    // Close statements
    $check_stmt->close();
    $stmt->close();
}

// Example usage
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure $conn is properly initialized in db.php
    if (!isset($conn)) {
        die("Database connection failed.");
    }

    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    registerUser($conn, $name, $email, $password, $confirm_password, $role);
}
?>
