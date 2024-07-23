<?php
session_start();
require_once 'db.php'; // Ensure this file contains PDO connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

    // Check if required fields are set
    if (empty($email) || empty($password)) {
        die("All fields are required.");
    }

    // Admin credentials
    $adminEmail = 'admin@wanderwheel.com'; // Replace with your admin email
    $adminPassword = 'admin@2024'; // Replace with your admin password

    // Check for admin login
    if ($email === $adminEmail && $password === $adminPassword) {
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = 'admin';
        $_SESSION['user_id'] = 0; // You can set a dummy ID or manage it as needed
        $_SESSION['username'] = 'Admin'; // Set a username for the admin
        header("Location: ../admin.php"); // Redirect to the admin dashboard
        exit();
    }

    // For regular user or driver login
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND role = :role");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $role;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username']; // Set the username session variable

            if ($role == 'user') {
                header("Location: ../user.php");
            } elseif ($role == 'driver') {
                header("Location: ../driver.php");
            } else {
                die("Invalid role.");
            }
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
