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
    <title>Manage Tasks</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Manage Tasks</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM tasks");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['title']}</td>
                <td>{$row['description']}</td>
                <td>{$row['status']}</td>
                <td>
                    <a href='../views/edit_task.php?id={$row['id']}'>Edit</a> | 
                    <a href='../actions/delete_task.php?id={$row['id']}'>Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</div>
</body>
</html>
