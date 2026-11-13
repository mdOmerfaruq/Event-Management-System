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

$userId = $_SESSION['user_id'];

// Fetch clubs where the user has notifications
$clubNotificationQuery = "SELECT DISTINCT c.club_id, c.club_name
                          FROM clubs c
                          INNER JOIN user_notifications un ON c.club_id = un.club_id
                          WHERE un.user_id = ?";
$stmt = $conn->prepare($clubNotificationQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$clubNotificationsResult = $stmt->get_result();

// Count the number of clubs with notifications
$notificationClubCount = $clubNotificationsResult->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <!-- Include CSS -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="owl.carousel.min.css">
    <link rel="stylesheet" href="owl.theme.default.min.css">
    <link rel="stylesheet" href="magnific-popup.css">
    <link rel="stylesheet" href="aos.css">
    <link rel="stylesheet" href="ionicons.min.css">
    <link rel="stylesheet" href="bootstrap-datepicker.css">
    <link rel="stylesheet" href="jquery.timepicker.css">
    <link rel="stylesheet" href="flaticon.css">
    <link rel="stylesheet" href="icomoon.css">
    <link rel="stylesheet" href="style.css"> <!-- Shared custom stylesheet -->
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="user_dashboard.php">User Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="home.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="notifications.php" class="nav-link">Notifications</a></li>
    
                <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true): ?>
                    <li class="nav-item text-white mt-2">
                        <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>
                    </li>
                <?php endif; ?>
                <li class="nav-item cta mr-md-2"><a href="logout_db.php" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- User Dashboard Content -->
<div class="container mt-5">
    
    <p class="text-center">You have <strong><?php echo $notificationClubCount; ?></strong> club(s) with notifications.</p>

    <div class="clubs-container mt-4">
        <?php if ($notificationClubCount > 0): ?>
            <?php while ($club = $clubNotificationsResult->fetch_assoc()): ?>
                <div class="club-card shadow p-3 mb-3 bg-light rounded">
                    <h4><?php echo htmlspecialchars($club['club_name']); ?></h4>
                    <a href="one_event_db.php?club_id=<?php echo $club['club_id']; ?>" class="btn btn-success btn-sm">View Events</a>
                    <button onclick="deleteNotifications(<?php echo $club['club_id']; ?>)" class="btn btn-danger btn-sm">Delete Notifications</button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center text-muted">No notifications available.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Include JS -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.timepicker.min.js"></script>
<script src="js/scrollax.min.js"></script>
<script src="js/main.js"></script> <!-- Shared custom script -->
<script>
    function deleteNotifications(clubId) {
        if (confirm("Are you sure you want to delete all notifications for this club?")) {
            fetch("delete_notification_db.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "club_id=" + clubId
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error("Error:", error));
        }
    }
</script>
</body>
</html>
