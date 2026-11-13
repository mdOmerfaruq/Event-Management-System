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
$clubQuery = "SELECT c.club_id, c.club_name 
              FROM clubs c 
              INNER JOIN user_clubs uc ON c.club_id = uc.club_id 
              WHERE uc.user_id = ?";
$stmt = $conn->prepare($clubQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$clubsResult = $stmt->get_result();

// Handle club join
if (isset($_POST['join_club_id'])) {
    $joinClubId = $_POST['join_club_id'];

    // Check if user is already a member of the club
    $checkQuery = "SELECT * FROM user_clubs WHERE user_id = ? AND club_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $userId, $joinClubId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert into user_clubs table to join the club
        $joinQuery = "INSERT INTO user_clubs (user_id, club_id) VALUES (?, ?)";
        $stmt = $conn->prepare($joinQuery);
        $stmt->bind_param("ii", $userId, $joinClubId);
        $stmt->execute();
        echo "<script>alert('Successfully joined the club!');</script>";
    } else {
        echo "<script>alert('You are already a member of this club.');</script>";
    }
}

// Handle notifications preference
if (isset($_POST['notify_club_id'])) {
    $notifyClubId = $_POST['notify_club_id'];

    // Set notification preference
    $notifyQuery = "INSERT INTO user_notifications (user_id, club_id) VALUES (?, ?)
                    ON DUPLICATE KEY UPDATE club_id = ?";
    $stmt = $conn->prepare($notifyQuery);
    $stmt->bind_param("iii", $userId, $notifyClubId, $notifyClubId);
    $stmt->execute();
    echo "<script>alert('You will now be notified about events in this club.');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* General Reset */
        body, h1, h2, h3, h4, p, ul { margin: 0; padding: 0; font-family: 'Roboto', sans-serif; }

        body {
            background-color: #f7f7f7;
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #333;
            padding: 15px 0;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar a {
            color: white;
            padding: 14px 25px;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
        }

        .navbar a:hover {
            background-color: #444;
        }

        /* Main Container */
        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            color: #333;
        }

        /* Section Title */
        .section-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-weight: 500;
        }

        /* Club Card Styles */
        .clubs-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-evenly;
        }

        .club-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: calc(33% - 20px);
            max-width: 300px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .club-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .club-card h4 {
            font-size: 1.5rem;
            color: #007bff;
            margin-bottom: 10px;
        }

        .club-card p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }

        .club-card button {
            font-size: 1rem;
            padding: 10px 20px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .club-card button:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .club-card {
                width: calc(50% - 20px);
            }
        }

        @media (max-width: 480px) {
            .club-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="home.php">Dashboard</a>
        <a href="notification_view.php">your notifications on club view</a>
        <a href="logout_db.php">Logout</a>
    </div>

    <div class="container">
        <h2>Welcome to the User Dashboard</h2>
        <p class="section-title">Your Clubs</p>
        <div class="clubs-container">
            <?php
            // Fetch clubs the user is a member of
            $joinedClubsQuery = "SELECT c.club_name 
                                 FROM clubs c 
                                 INNER JOIN user_clubs uc ON c.club_id = uc.club_id 
                                 WHERE uc.user_id = ?";
            $stmt = $conn->prepare($joinedClubsQuery);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $joinedClubsResult = $stmt->get_result();

            // Display the joined clubs
            if ($joinedClubsResult->num_rows > 0) {
                while ($joinedClub = $joinedClubsResult->fetch_assoc()) {
                    echo '<div class="club-card">';
                    echo '<h4>' . htmlspecialchars($joinedClub['club_name']) . '</h4>';
                    echo '<p>Explore events and updates for this club.</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>You haven\'t joined any clubs yet.</p>';
            }
            ?>
        </div>

        <!-- Notification Preference -->
        <p class="section-title">Notifications</p>
        <form method="POST">
            <select name="notify_club_id" required>
                <option value="" disabled selected>Select a club for notifications</option>
                <?php
                $clubsResult->data_seek(0); // Reset the pointer for club results
                while ($club = $clubsResult->fetch_assoc()): ?>
                    <option value="<?php echo $club['club_id']; ?>"><?php echo htmlspecialchars($club['club_name']); ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Notify Me</button>
        </form>

    </div>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>