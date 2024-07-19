<?php
require 'config.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    header('Location: main_menu.html');
    exit;
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$_GET['id']])) {
        header('Location: view_users.php');
    } else {
        echo 'Failed to delete user.';
    }
}
?>
