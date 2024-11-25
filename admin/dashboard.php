<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "../includes/config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>
    <p><a href="manage_tasks.php">Manage Tasks</a></p>
    <p><a href="manage_users.php">Manage Users</a></p>
    <p><a href="logout.php">Logout</a></p>
</div>
</body>
</html>
