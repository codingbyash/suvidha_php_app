<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "../includes/config.php";

// Fetch the user data
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM users WHERE id = $id");
    $user = $result->fetch_assoc();
} else {
    header("Location: manage_users.php");
    exit();
}

// Update user data
$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE users SET username = '$username', password = '$password' WHERE id = $id";
    if ($conn->query($sql)) {
        header("Location: manage_users.php?success=1");
        exit();
    } else {
        $error = "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    </head>
<body>
<div class="container">
    <h2>Edit User</h2>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>

        <label>Password (Leave blank to keep the same):</label><br>
        <input type="password" name="password"><br>

        <button type="submit">Update User</button>
    </form>
    <p><a href="manage_users.php">Back to Manage Users</a></p>
</div>
</body>
</html>
