<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "../includes/config.php";

$user_id = $_SESSION['user_id'];
$note_id = $_GET['id'];

// Delete the note
$stmt = $conn->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $note_id, $user_id);
$stmt->execute();

header("Location: notes.php");
exit();
?>
