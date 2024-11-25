<?php
include "../includes/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM tasks WHERE id = $id";
    if ($conn->query($sql)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
