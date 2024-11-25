<?php include "../includes/config.php"; ?>
<?php include "../includes/header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    
</body>
</html>
<div class="container">
    <h2>Login</h2>
    <form action="../actions/login.php" method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
    <p style="margin-top: 20px;">
        Not registered? <a href="../views/register.php" style="color: #1e90ff; text-decoration: none; font-weight: bold;">Register yourself</a>
    </p>
</div>

<?php include "../includes/footer.php"; ?>
