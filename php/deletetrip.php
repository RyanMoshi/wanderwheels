<?php
require 'config.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../mainpage.html');
    exit;
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM trips WHERE id = ?");
    if ($stmt->execute([$_GET['id']])) {
        header('Location: php/viewtrips.php');
    } else {
        echo 'Failed to delete trip.';
    }
}
?>
