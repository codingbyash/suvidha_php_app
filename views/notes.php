<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "../includes/config.php";

// Fetch user notes
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM notes WHERE user_id = $user_id ORDER BY updated_at DESC");

// Add a new note
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_note'])) {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    $stmt = $conn->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $content);
    $stmt->execute();

    header("Location: notes.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <link rel="stylesheet" href="../assets/css/notesstyle.css"
</head>
<body>
<div class="container">
    <h2>Your Notes</h2>

    <!-- Add New Note Form -->
    <form method="POST" action="notes.php" class="mb-4">
        <input type="text" name="title" placeholder="Title" class="form-control mb-2" required>
        <textarea name="content" rows="4" placeholder="Write your note here..." class="form-control mb-2" required></textarea>
        <button type="submit" name="add_note" class="btn btn-primary">Add Note</button>
    </form>

    <!-- Display Notes -->
    <div class="notes-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="note">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                <small>Last updated: <?= $row['updated_at'] ?></small><br>
                <a href="edit_note.php?id=<?= $row['id'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                <a href="delete_note.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this note?');">Delete</a>
            </div>
            <hr>
        <?php endwhile; ?>
    </div>
</div>
     
</body>
</html>

