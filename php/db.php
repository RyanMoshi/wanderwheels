<?php
<<<<<<< HEAD
// Get the form data


// Connect to our database (our database credentials)
$host = "localhost";
$user = "root";
$password = "";
$dbname = "wanderwheels";
$port = "3306";
$conn = new mysqli($host, $user, $password, $dbname, $port);

if ($conn->connect_error) {
    die('Connection Failed : '. $conn->connect_error);
} else {
    // Connection works

=======
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
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
}
?>