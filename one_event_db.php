<?php
session_start();
$conn = new mysqli("localhost", "root", "", "event_management_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ensure club_id is provided in URL
if (!isset($_GET['club_id'])) {
    header("Location:home.php");
    exit();
}

$clubId = intval($_GET['club_id']);

// Fetch club name
$clubQuery = "SELECT club_name FROM clubs WHERE club_id = ?";
$stmt = $conn->prepare($clubQuery);
$stmt->bind_param("i", $clubId);
$stmt->execute();
$clubResult = $stmt->get_result();

if ($clubResult->num_rows === 0) {
    die("Club not found.");
}

$club = $clubResult->fetch_assoc();

// Fetch events for the selected club
$eventsQuery = "SELECT EventID, event_name, start_date, description FROM events WHERE club_id = ?";
$stmt = $conn->prepare($eventsQuery);
$stmt->bind_param("i", $clubId);
$stmt->execute();
$eventsResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($club['club_name']); ?> - Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            text-align: center;
            padding: 20px;
        }
        .container {
            background-color: white;
            width: 60%;
            margin: auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .event-card {
            background: #e9ecef;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            text-align: left;
            position: relative;
        }
        .btn {
            display: inline-block;
            margin: 10px 5px;
            padding: 10px 15px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }
        .back-btn {
            background: #007bff;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Events for <?php echo htmlspecialchars($club['club_name']); ?></h2>

    <div class="events-container">
        <?php if ($eventsResult->num_rows > 0): ?>
            <?php while ($event = $eventsResult->fetch_assoc()): ?>
                <div class="event-card">
                    <h4><?php echo htmlspecialchars($event['event_name']); ?></h4>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($event['start_date']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No events available for this club.</p>
        <?php endif; ?>
    </div>

    <a href="home.php" class="btn back-btn">Back to Dashboard</a>
</div>

</body>
</html>
