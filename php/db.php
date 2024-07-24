<?php
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

}
?>