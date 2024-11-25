<?php
session_start();
include "../includes/config.php";

if (isset($_GET['id']) && isset($_SESSION['admin'])) {
    $id = $_GET['id'];

    // Prevent admin from deleting themselves
    if ($id == $_SESSION['admin_id']) {
        echo "Error: You cannot delete yourself!";
        exit();
    }

    $sql = "DELETE FROM users WHERE id = $id";
    if ($conn->query($sql)) {
        header("Location: ../admin/manage_users.php?success=1");
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    header("Location: ../admin/manage_users.php");
    exit();
}
?>
