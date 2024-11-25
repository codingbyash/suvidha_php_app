<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "../includes/config.php";

// Get the user ID from the URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch the user information
    $user_result = $conn->query("SELECT username FROM users WHERE id = $user_id");
    if ($user_result->num_rows == 0) {
        echo "User not found!";
        exit();
    }
    $user = $user_result->fetch_assoc();

    // Fetch the tasks for the user
    $task_result = $conn->query("SELECT * FROM tasks WHERE user_id = $user_id");
} else {
    header("Location: manage_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks for <?php echo htmlspecialchars($user['username']); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Tasks for <?php echo htmlspecialchars($user['username']); ?></h2>
    <a href="add_task.php?user_id=<?php echo $user_id; ?>">Add New Task</a><br><br> <!-- Link to add new task -->

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($task = $task_result->fetch_assoc()) {
            echo "<tr>
                <td>{$task['id']}</td>
                <td>{$task['title']}</td>
                <td>{$task['description']}</td>
                <td>{$task['status']}</td>
                <td>{$task['priority']}</td>
                <td>{$task['created_at']}</td>
                <td>
                    <a href='../views/edit_task.php?id={$task['id']}'>Edit</a> | 
                    <a href='../actions/delete_task.php?task_id={$task['id']}'>Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>
    <p><a href="manage_users.php">Back to Manage Users</a></p>
</div>
</body>
</html>
