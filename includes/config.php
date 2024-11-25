<?php
$servername = "localhost";
$username = "root"; // Default username
$password = "";     // Leave blank if no password
$dbname = "taskmanager";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
