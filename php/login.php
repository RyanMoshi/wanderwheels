<?php
session_start();
require_once 'db.php'; // Ensure this file contains mysqli connection setup

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

        // Redirect to admin dashboard
        header("Location: ../admin.php"); // Assuming admin.php is in the root directory
        exit();
    }

    // For regular user or driver login
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
        if ($stmt === false) {
            throw new Exception('Failed to prepare statement: ' . $conn->error);
        }
        
        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            throw new Exception('Failed to execute statement: ' . $stmt->error);
        }

        $user = $result->fetch_assoc();

        // Verify the password using password_verify()
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $role;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username']; // Set the username session variable

            if ($role == 'user') {
                header("Location: ../user.php"); // Assuming user.php is in the root directory
            } elseif ($role == 'driver') {
                header("Location: ../driver.php"); // Assuming driver.php is in the root directory
            } else {
                die("Invalid role.");
            }
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
