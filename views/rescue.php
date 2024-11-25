<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "../includes/config.php"; // Include the database connection

// Handle form submission to save time log
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_name']) && isset($_POST['start_time']) && isset($_POST['end_time']) && isset($_POST['duration'])) {
    $task_name = $_POST['task_name'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $duration = $_POST['duration']; // Duration in seconds
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO time_logs (task_name, start_time, end_time, duration, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $task_name, $start_time, $end_time, $duration, $user_id);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Tracker</title>
    <link rel="stylesheet" href="../assets/notes.css"> <!-- Include your styles -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Add your styles here for digital clock */
        body{
          background-color: #232323;
        }
        #timerDisplay {
            font-family: 'Digital-7', sans-serif;
            font-size: 50px;
            color: #00FF00;
            text-align: center;
            background-color: black;
            border-radius: 10px;
            padding: 20px;
            width: 220px;
            margin: auto;
        }

        #timerDisplay p {
            margin: 0;
        }

        /* Timer button styling */
        .btn {
            background-color: #00BFFF;
            color: white;
            padding: 15px 32px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            display: block;
            margin: 20px auto;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .container {
            max-width: 900px;
            color:#00BFFF;    
            margin: 20px auto;
            text-align: center;
        }

        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin: 20px 0;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .log-entry {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .log-entry strong {
            display: inline-block;
            width: 120px;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Time Tracker</h2>
        <a href="../landing.php" class="btn btn-primary">Home</a>


        <!-- Task Input -->
        <form id="taskForm" method="POST" action="rescue.php">
            <input type="text" id="taskName" name="task_name" placeholder="Enter task name" required>
            <button type="submit" id="startStopBtn" class="btn">Start Timer</button>
        </form>

        <div id="timerDisplay">
            <p>Time Elapsed: <span id="time">00:00</span></p>
        </div>

        <!-- View logged time -->
        <h3>Logged Time</h3>
        <div id="loggedTime">
            <?php
            // Fetch logged times from the database for the current user
            $user_id = $_SESSION['user_id'];
            $result = $conn->query("SELECT * FROM time_logs WHERE user_id = $user_id ORDER BY start_time DESC");

            while ($row = $result->fetch_assoc()) {
                echo "<div class='log-entry'>";
                echo "<strong>Task: </strong>" . htmlspecialchars($row['task_name']) . "<br>";
                echo "<strong>Time Spent: </strong>" . gmdate("H:i:s", $row['duration']) . "<br>";
                echo "<strong>Start Time: </strong>" . $row['start_time'] . "<br>";
                echo "<strong>End Time: </strong>" . $row['end_time'] . "<br><br>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <script>
        let timer;
        let seconds = 0;
        let isRunning = false;
        let startTime;
        let taskName;

        // Handle Start/Stop Timer
        $("#startStopBtn").click(function(event) {
            event.preventDefault();
            taskName = $("#taskName").val();
            if (!taskName) {
                alert("Please enter a task name.");
                return;
            }

            if (!isRunning) {
                // Start Timer
                isRunning = true;
                startTime = new Date().toISOString().slice(0, 19).replace('T', ' '); // Current timestamp

                $(this).text("Stop Timer");
                startTimer();
            } else {
                // Stop Timer
                isRunning = false;
                let endTime = new Date().toISOString().slice(0, 19).replace('T', ' '); // Current timestamp

                // Calculate duration in seconds
                let duration = seconds;

                // Save timer data to backend
                $.post("rescue.php", {
                    task_name: taskName,
                    start_time: startTime,
                    end_time: endTime,
                    duration: duration
                }, function(response) {
                    location.reload(); // Reload to show updated time logs
                });

                $(this).text("Start Timer");
                clearInterval(timer);
                seconds = 0;
                $("#time").text("00:00");
            }
        });

        // Timer function
        function startTimer() {
            timer = setInterval(function() {
                seconds++;
                let minutes = Math.floor(seconds / 60);
                let secs = seconds % 60;
                $("#time").text((minutes < 10 ? "0" : "") + minutes + ":" + (secs < 10 ? "0" : "") + secs);
            }, 1000);
        }
    </script>
</body>
</html>
