<?php
session_start();
include "../includes/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve values from the POST request
    $id = $_POST['id'];  // Task ID
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];  // Include priority in the update
    $status = $_POST['status'];

    // Check if admin or user is editing the task
    if (isset($_SESSION['admin'])) {
        // Admin: update without user_id check
        $sql = "UPDATE tasks SET title = '$title', description = '$description', priority = '$priority', status = '$status' WHERE id = $id";
    } elseif (isset($_SESSION['user_id'])) {
        // User: ensure only their own tasks can be updated
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE tasks SET title = '$title', description = '$description', priority = '$priority', status = '$status' WHERE id = $id AND user_id = $user_id";
    } else {
        echo "Unauthorized access.";
        exit();
    }

    if ($conn->query($sql)) {
        // Redirect back to the task list or admin panel
        if (isset($_SESSION['admin'])) {
            header("Location: ../admin/manage_tasks.php?success=1");
        } else {
            header("Location: ../index.php?success=1");
        }
        exit();
    } else {
        echo "Error updating task: " . $conn->error;
    }
} else {
    // If the request is not POST, redirect to the index page
    header("Location: ../index.php");
    exit();
}
?>
