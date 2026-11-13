<?php
session_start();
$conn = new mysqli("localhost", "root", "", "event_management_system");

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all events from the database
$eventsQuery = "SELECT EventID, event_name,start_date, description, location, image_url FROM events ORDER BY start_date ASC";
$eventsResult = $conn->query($eventsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Events</title>
    <style>
       .navbar {
    background-color: white; /* Set navbar background to white */
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #ddd; /* Optional: Add a subtle border for separation */
}

.navbar a {
    color: black; /* Set text color to black */
    padding: 14px 20px;
    text-decoration: none;
    font-weight: bold; /* Optional: Make the text bold */
}

.navbar a:hover {
    background-color: #f2f2f2; /* Set hover background to a light gray */
    color: black; /* Ensure hover text stays black */
}

    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="home.php">Home</a>
    <a href="reg_even.php">Registed event view</a>
      <!-- Link to Home page -->
</div>

<h2 style="text-align:center;">All Events</h2>
<div class="event-container">
    <?php if ($eventsResult->num_rows > 0): ?>
        <?php while ($event = $eventsResult->fetch_assoc()): ?>
            <div class="event">
                <!-- Display image if it exists -->
                <?php if ($event['image_url']): ?>
                    <img src="<?php echo htmlspecialchars($event['image_url']); ?>" alt="<?php echo htmlspecialchars($event['event_name']); ?>">
                <?php endif; ?>
                
                <h3><?php echo htmlspecialchars($event['event_name']); ?></h3>
                <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($event['start_date'])); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                <p><?php echo htmlspecialchars($event['description']); ?></p>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="event_registrations.php" method="POST">
                        <input type="hidden" name="event_id" value="<?php echo $event['EventID']; ?>">
                        <button type="submit">Register</button>
                    </form>
                <?php else: ?>
                    <p><a href="login.php">Log in</a> to register for events.</p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No events found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>
