<?php
session_start();
$conn = new mysqli("localhost", "root", "", "event_management_system");

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch clubs the user has joined
$clubQuery = "SELECT c.club_name 
              FROM clubs c 
              INNER JOIN user_clubs uc ON c.club_id = uc.club_id 
              WHERE uc.user_id = ?";
$stmt = $conn->prepare($clubQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$clubsResult = $stmt->get_result();

// Fetch events the user has registered for
$eventQuery = "SELECT e.event_name, e.eventdate, e.description, e.location
               FROM events e 
               INNER JOIN event_registrations er ON e.EventID = er.EventID
               WHERE er.UserID = ?";
$stmt = $conn->prepare($eventQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$eventsResult = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Resetting default styles */
        body, h1, h2, h3, h4, p, ul { margin: 0; padding: 0; font-family: 'Roboto', sans-serif; }

        body {
            background-color: #f4f7fb;
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }

        .navbar {
            background-color: #333;
            padding: 12px 0;
            text-align: center;
        }

        .navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
        }

        .navbar a:hover {
            background-color: #444;
        }

        .container {
            width: 80%;
            margin: 30px auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            color: #333;
        }

        .section-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-weight: 500;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 15px 0;
            padding: 20px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h4 {
            margin: 0;
            font-size: 1.25rem;
            color: #333;
        }

        .card p {
            margin-top: 5px;
            font-size: 1rem;
            color: #555;
        }

        .card .date {
            font-weight: 600;
            color: #007bff;
        }

        .card .button {
            margin-top: 10px;
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .card .button:hover {
            background-color: #0056b3;
        }

        .no-data {
            text-align: center;
            color: #888;
            font-size: 1rem;
        }

        ul {
            list-style-type: none;
            padding-left: 0;
        }

        ul li {
            padding: 8px;
            margin-bottom: 8px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 1rem;
            color: #333;
        }

        /* Media Query for responsiveness */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            .navbar a {
                padding: 12px 15px;
            }

            .card h4 {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="home.php">Dashboard</a>
        <a href="logout_db.php">Logout</a>
    </div>

    <div class="container">
        <h2>Your Dashboard</h2>

        <!-- Clubs the user has joined -->
        <div>
            <p class="section-title">Your Joined Clubs</p>
            <?php if ($clubsResult->num_rows > 0): ?>
                <ul>
                    <?php while ($club = $clubsResult->fetch_assoc()): ?>
                        <li><?php echo htmlspecialchars($club['club_name']); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="no-data">You haven't joined any clubs yet.</p>
            <?php endif; ?>
        </div>

        <!-- Events the user has registered for -->
        <div>
            <p class="section-title">Your Registered Events</p>
            <?php if ($eventsResult->num_rows > 0): ?>
                <?php while ($event = $eventsResult->fetch_assoc()): ?>
                    <div class="card">
                        <h4><?php echo htmlspecialchars($event['event_name']); ?></h4>
                        <p class="date">Date: <?php echo $event['eventdate']; ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($event['description']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                        <a href="All_event.php" class="button">View Details</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-data">You haven't registered for any events yet.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
