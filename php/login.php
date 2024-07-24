<?php
session_start();
<<<<<<< HEAD
require_once 'db.php'; // Ensure this file contains mysqli connection setup
=======
require_once 'db.php'; // Ensure this file contains PDO connection setup
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac

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
<<<<<<< HEAD

        // Redirect to admin dashboard
        header("Location: ../admin.php"); // Assuming admin.php is in the root directory
=======
        header("Location: ../admin.php"); // Redirect to the admin dashboard
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
        exit();
    }

    // For regular user or driver login
    try {
<<<<<<< HEAD
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
=======
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND role = :role");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $role;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username']; // Set the username session variable

            if ($role == 'user') {
<<<<<<< HEAD
                header("Location: ../user.php"); // Assuming user.php is in the root directory
            } elseif ($role == 'driver') {
                header("Location: ../driver.php"); // Assuming driver.php is in the root directory
=======
                header("Location: ../user.php");
            } elseif ($role == 'driver') {
                header("Location: ../driver.php");
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
            } else {
                die("Invalid role.");
            }
            exit();
        } else {
            echo "Invalid email or password.";
        }
<<<<<<< HEAD
    } catch (Exception $e) {
=======
    } catch (PDOException $e) {
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
        echo "Error: " . $e->getMessage();
    }
}
?>
