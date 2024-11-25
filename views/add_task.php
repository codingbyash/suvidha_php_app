<?php include "../includes/config.php"; ?>
<?php include "../includes/header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Task</title>
    <link rel="stylesheet" href="../assets/css/add_task.css">
</head>
<body>
<div class="container">
     <h2>Add New Task</h2>
     <form action="../actions/add_task.php" method="POST">
          <label for="title">Title:</label>
          <input type="text" id="title" name="title" placeholder="Enter task title" required>
          
          <label for="description">Description:</label>
          <textarea id="description" name="description" placeholder="Enter task description" required></textarea>
          
          <label for="priority">Priority:</label>
          <select id="priority" name="priority">
               <option value="low">Low</option>
               <option value="medium" selected>Medium</option>
               <option value="high">High</option>
          </select>
          
          <label for="status">Status:</label>
          <select id="status" name="status">
               <option value="pending">Pending</option>
               <option value="completed">Completed</option>
          </select>
          
          <button type="submit">Add Task</button>
     </form>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
