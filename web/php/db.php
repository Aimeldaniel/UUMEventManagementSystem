<?php
$servername = "localhost";
$username = "username"; // Replace with your username
$password = "password"; // Replace with your password
$dbname = "eventapprovalsystem"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
