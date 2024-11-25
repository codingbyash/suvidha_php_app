<?php
include "../includes/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure hashing

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql)) {
        header("Location: ../views/login.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
