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
     <title>Manage Users</title>
     <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
     <div class="container">
          <h2>Manage Users</h2>
          <a href="add_user.php">Add New User</a><br><br> <!-- Link to add user -->

          <table border="1">
               <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Created At</th>
                    <th>Actions</th>
               </tr>
               <?php
               $result = $conn->query("SELECT id, username, created_at FROM users");
               while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['created_at']}</td>
                <td>
                    <a href='edit_user.php?id={$row['id']}'>Edit</a> | 
                    <a href='../actions/delete_user.php?id={$row['id']}'>Delete</a>
                    <a href='user_tasks.php?user_id={$row['id']}'>Tasks</a> <!-- View Tasks button -->

                    </td>
            </tr>";
               }
               ?>
          </table>
          <p><a href="dashboard.php">Back to Dashboard</a></p>
     </div>
</body>

</html>