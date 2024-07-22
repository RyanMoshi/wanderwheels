<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "SELECT * FROM users WHERE email='$email' AND role='$role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $role;
            $_SESSION['user_id'] = $row['id'];
            if ($role == 'user') {
                header("Location: user.html");
            } else {
                header("Location: driver.html");
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this email and role.";
    }
}
?>
