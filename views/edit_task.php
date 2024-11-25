<?php
session_start();
include "../includes/config.php";

// Check if task ID is set in the URL
if (isset($_GET['id'])) {
     $id = $_GET['id'];
     $result = $conn->query("SELECT * FROM tasks WHERE id = $id");
     $task = $result->fetch_assoc();
} else {
     // If no ID, redirect to the task list page
     header("Location: ../index.php");
     exit();
}
?>

<?php include "../includes/header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="../assets/css/add_task.css"> <!-- Reusing the same CSS -->
</head>
<body>
<div class="container">
     <h2>Edit Task</h2>
     <form action="../actions/edit_task.php" method="POST">
          <!-- Pass the task ID in the form data -->
          <input type="hidden" name="id" value="<?php echo $task['id']; ?>">

          <?php if (isset($_SESSION['user_id'])): ?>
               <input type="hidden" name="user_id" value="<?php echo $task['user_id']; ?>">
          <?php endif; ?>

          <label for="title">Title:</label>
          <input type="text" id="title" name="title" value="<?php echo $task['title']; ?>" required>

          <label for="description">Description:</label>
          <textarea id="description" name="description" rows="4" required><?php echo $task['description']; ?></textarea>

          <label for="priority">Priority:</label>
          <select id="priority" name="priority">
               <option value="low" <?php echo $task['priority'] == 'low' ? 'selected' : ''; ?>>Low</option>
               <option value="medium" <?php echo $task['priority'] == 'medium' ? 'selected' : ''; ?>>Medium</option>
               <option value="high" <?php echo $task['priority'] == 'high' ? 'selected' : ''; ?>>High</option>
          </select>

          <label for="status">Status:</label>
          <select id="status" name="status">
               <option value="pending" <?= ($task['status'] === 'pending') ? 'selected' : '' ?>>Pending</option>
               <option value="completed" <?= ($task['status'] === 'completed') ? 'selected' : '' ?>>Completed</option>
          </select>

          <button type="submit">Update Task</button>
     </form>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
