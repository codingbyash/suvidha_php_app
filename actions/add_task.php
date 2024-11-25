<?php
session_start();
include "../includes/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];  // Get the priority value
    $user_id = $_SESSION['user_id']; // Fetch logged-in user ID from session
    $status = $_POST['status']; // Get the status

    // Validate or sanitize input here if necessary (optional)

    // Insert the task into the database, including priority
    $sql = "INSERT INTO tasks (title, description, priority, user_id, status) VALUES ('$title', '$description', '$priority', $user_id, '$status')";
    
    if ($conn->query($sql)) {
        // Redirect to the main task list page after successful insertion
        header("Location: ../index.php");
        exit();
    } else {
        // Handle the error if the query fails
        echo "Error: " . $conn->error;
    }
} else {
    // Redirect back to the homepage if the form wasn't submitted correctly
    header("Location: ../index.php");
    exit();
}
?>
