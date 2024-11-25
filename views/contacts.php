<?php include "../includes/config.php"; ?>
<?php include "../includes/header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../assets/css/contacts.css">
</head>
<body>
    <section id="contact">
        <h1>Contact Us</h1>
        <p>We’re here to help! Reach out with your queries, feedback, or concerns.</p>
        
        <form action="../actions/contact.php" method="POST">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>
            
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <label for="message">Message:</label>
            <textarea id="message" name="message" placeholder="Write your message here..." rows="6" required></textarea>
            
            <button type="submit">Send Message</button>
        </form>
    </section>

<?php include "../includes/footer.php"; ?>
</body>
</html>
