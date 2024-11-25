<?php
session_start();
if (!isset($_SESSION['user_id'])) {
     header("Location: views/login.php");
     exit();
}

include "includes/config.php";
include "includes/header.php";

$user_id = $_SESSION['user_id'];
$search = $_GET['search'] ?? '';
$priority = $_GET['priority'] ?? '';

$sql = "SELECT * FROM tasks WHERE user_id = $user_id";
if ($search) {
     $sql .= " AND title LIKE '%$search%'";
}
if ($priority) {
     $sql .= " AND priority = '$priority'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="assets/css/task_list.css">
</head>
<body>

<div class="container">
     <h2>Task List</h2>
     <a href="./views/add_task.php" class="btn btn-primary">Add Task</a>

     <form method="GET" action="index.php" class="search-form">
          <input type="text" name="search" placeholder="Search tasks" value="<?= htmlspecialchars($search) ?>">
          <select name="priority">
               <option value="">All Priorities</option>
               <option value="low" <?= ($priority === 'low') ? 'selected' : '' ?>>Low</option>
               <option value="medium" <?= ($priority === 'medium') ? 'selected' : '' ?>>Medium</option>
               <option value="high" <?= ($priority === 'high') ? 'selected' : '' ?>>High</option>
          </select>
          <button type="submit">Search</button>
     </form>

     <table>
          <thead>
               <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Actions</th>
               </tr>
          </thead>
          <tbody>
               <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                         <td><?= htmlspecialchars($row['title']) ?></td>
                         <td><?= htmlspecialchars($row['description']) ?></td>
                         <td><?= htmlspecialchars($row['priority']) ?></td>
                         <td><?= htmlspecialchars($row['status']) ?></td>
                         <td>
                              <a href="views/edit_task.php?id=<?= $row['id'] ?>" class="edit-link">Edit</a>
                              <a href="actions/delete_task.php?id=<?= $row['id'] ?>" class="delete-link" onclick="return confirm('Are you sure?')">Delete</a>
                              <a href="actions/update_status.php?id=<?= $row['id'] ?>&status=<?= $row['status'] ?>" class="status-link">Change Status</a>
                         </td>
                    </tr>
               <?php endwhile; ?>
          </tbody>
     </table>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>
