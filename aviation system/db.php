<?php
$host = "localhost"; // Database host
$username = "root"; // Database username
$password = '@0706647669J'; // Database password
$dbname = "aviation_system"; // Database name

// Create a new connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "";
}

?>
