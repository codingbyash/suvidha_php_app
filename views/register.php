<?php include "../includes/config.php"; ?>
<?php include "../includes/header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/register.css"> <!-- Corrected the double slash -->
    <title>Register</title>
</head>
<body>
<div class="container">
    <h2>SIGN UP GEEK</h2>
    <form action="../actions/register.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" name="username" id="username" required><br>
        
        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required><br>
        
        <button type="submit">Register</button>
    </form>
    <p style="margin-top: 20px;">
        Already registered? <a href="../views/login.php" style="color: #1e90ff; text-decoration: none; font-weight: bold;">Go to Login</a>
    </p>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
