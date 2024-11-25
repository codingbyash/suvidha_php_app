<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "../includes/config.php"; // Database connection

// Handle file upload and message submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['message'])) {
        $user_name = $_SESSION['username']; // Assume the username is stored in session
        $message = htmlspecialchars($_POST['message']);
        
        // Handle file upload if there is a file
        $image_path = null; // Initialize image path
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['image']['type'], $allowed_types)) {
                $upload_dir = "../uploads/";
                $image_name = time() . "_" . basename($_FILES['image']['name']);
                $image_path = $upload_dir . $image_name;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                    // File uploaded successfully
                } else {
                    echo "Error uploading image.";
                }
            } else {
                echo "Invalid file type.";
            }
        }

        // Insert message into the database
        $stmt = $conn->prepare("INSERT INTO discussion_forum (user_name, message, image_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user_name, $message, $image_path);
        $stmt->execute();
    }

    // Handle comment submission
    if (isset($_POST['comment_message']) && isset($_POST['post_id'])) {
        $comment_message = htmlspecialchars($_POST['comment_message']);
        $post_id = (int)$_POST['post_id'];
        $user_name = $_SESSION['username'];

        $stmt = $conn->prepare("INSERT INTO comments (post_id, user_name, comment_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $post_id, $user_name, $comment_message);
        $stmt->execute();
    }

    // Handle like, upvote, downvote
    if (isset($_POST['like_post_id'])) {
        $post_id = (int)$_POST['like_post_id'];
        $stmt = $conn->prepare("UPDATE discussion_forum SET likes = likes + 1 WHERE id = ?");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
    }

    if (isset($_POST['upvote_post_id'])) {
        $post_id = (int)$_POST['upvote_post_id'];
        $stmt = $conn->prepare("UPDATE discussion_forum SET upvotes = upvotes + 1 WHERE id = ?");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
    }

    if (isset($_POST['downvote_post_id'])) {
        $post_id = (int)$_POST['downvote_post_id'];
        $stmt = $conn->prepare("UPDATE discussion_forum SET downvotes = downvotes + 1 WHERE id = ?");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
    }
}

// Fetch all messages from the database
$result = $conn->query("SELECT * FROM discussion_forum ORDER BY created_at DESC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/discuss.css"

</head>
<body>
    
<div class="container">
    <h2>Discussion Forum</h2>
    <a href="../landing.php" class="vote-btn">Home</a>


    <form method="POST" action="discussion_forum.php" enctype="multipart/form-data">
        <textarea name="message" rows="4" cols="50" placeholder="Type your message here..." required></textarea><br>
        <input type="file" name="image"><br>
        <button type="submit" class="btn btn-primary">Post Message</button>
    </form>

    <div class="messages">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="message">
                <strong><?= htmlspecialchars($row['user_name']) ?>:</strong>
                <p><?= nl2br(htmlspecialchars($row['message'])) ?></p>

                <!-- Display image if exists -->
                <?php if ($row['image_path']): ?>
                    <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Uploaded Image" class="message-image">
                <?php endif; ?>
                
                <small>Posted on <?= $row['created_at'] ?></small><br>

                <!-- Like, upvote, downvote buttons with icons -->
                <form method="POST" action="discussion_forum.php" class="vote-form">
                    <button type="submit" name="like_post_id" value="<?= $row['id'] ?>" class="vote-btn">
                        <i class="fa fa-thumbs-up"></i> (<?= $row['likes'] ?>)
                    </button>
                    <button type="submit" name="upvote_post_id" value="<?= $row['id'] ?>" class="vote-btn">
                        <i class="fa fa-arrow-up"></i> Upvote (<?= $row['upvotes'] ?>)
                    </button>
                    <button type="submit" name="downvote_post_id" value="<?= $row['id'] ?>" class="vote-btn">
                        <i class="fa fa-arrow-down"></i> Downvote (<?= $row['downvotes'] ?>)
                    </button>
                </form>

                <!-- Display comments form -->
                <form method="POST" action="discussion_forum.php" class="comment-form">
                    <textarea name="comment_message" rows="2" cols="50" placeholder="Type your comment..." required></textarea><br>
                    <input type="hidden" name="post_id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-secondary">Post Comment</button>
                </form>

                <!-- Display comments -->
                <?php
                $comments_result = $conn->query("SELECT * FROM comments WHERE post_id = " . $row['id'] . " ORDER BY created_at DESC");
                while ($comment = $comments_result->fetch_assoc()):
                ?>
                    <div class="comment">
                        <strong><?= htmlspecialchars($comment['user_name']) ?>:</strong>
                        <p><?= nl2br(htmlspecialchars($comment['comment_text'])) ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
            <hr>
        <?php endwhile; ?>
    </div>
</div>

<?php include "../includes/footer.php"; ?>


    
</body>
</html>
