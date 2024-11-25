<?php
session_start();
include "../includes/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash the input password

    $result = $conn->query("SELECT * FROM admins WHERE username = '$username' AND password = '$password'");

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location: ../admin/dashboard.php");
        exit();
    } else {
        echo "Invalid credentials. <a href='../admin/login.php'>Try again</a>";
    }
}
?>
