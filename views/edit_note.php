<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "../includes/config.php";

$user_id = $_SESSION['user_id'];
$note_id = $_GET['id'];

// Fetch the note to edit
$stmt = $conn->prepare("SELECT * FROM notes WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $note_id, $user_id);
$stmt->execute();
$note = $stmt->get_result()->fetch_assoc();

if (!$note) {
    die("Note not found or you don't have permission to edit this note.");
}

// Update the note
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    $stmt = $conn->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssii", $title, $content, $note_id, $user_id);
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
    <link rel="stylesheet" href="../assets/css/notesstyle.css"; 
</head>
<body>
<div class="container">
    <h2>Edit Note</h2>

    <form method="POST" action="">
        <input type="text" name="title" value="<?= htmlspecialchars($note['title']) ?>" class="form-control mb-2" required>
        <textarea name="content" rows="4" class="form-control mb-2" required><?= htmlspecialchars($note['content']) ?></textarea>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

    
</body>
</html>

