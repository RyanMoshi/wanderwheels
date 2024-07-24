<?php
$host = 'localhost';
$db = 'wanderwheels';
$user = 'root';
$password = '';
$charset = 'utf8mb4';
$port = '3307'; // Update if using a different port

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>