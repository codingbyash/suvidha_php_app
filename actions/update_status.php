<?php
session_start();
include "../includes/config.php";

// Check if both ID and status are set in the URL
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];  // 'completed' or 'pending'

    // Ensure only the logged-in user can update their tasks
    $user_id = $_SESSION['user_id'];

    // Toggle status: if it's completed, set it to pending, and vice versa
    $new_status = ($status == 'completed') ? 'pending' : 'completed';

    // Update query to toggle task status
    $sql = "UPDATE tasks SET status = '$new_status' WHERE id = $id AND user_id = $user_id";
    
    if ($conn->query($sql)) {
        // Redirect back to the task list
        header("Location: ../index.php");
        exit();
    } else {
        // Debugging - show SQL error if query fails
        echo "Error: " . $conn->error;
    }
} else {
    // If either id or status is missing, redirect to the task list
    header("Location: ../index.php");
    exit();
}
