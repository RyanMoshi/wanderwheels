<?php
$host = 'localhost';
$db = 'transport_system';
$user = 'root';
$password = '';
$charset="utf-8";
$port = "3307";


//$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$dsn = "mysql:host=$host;dbname=$db;port=$port";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
