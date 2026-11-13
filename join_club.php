<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "event_management_system";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Fetch the user's name and email
$userDetailsQuery = "SELECT name, email FROM users WHERE UserID = ?";
$stmt = $conn->prepare($userDetailsQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$userDetailsResult = $stmt->get_result();
$userDetails = $userDetailsResult->fetch_assoc();
$stmt->close();

// Fetch the clubs the user has already joined
$joinedClubsQuery = "SELECT c.club_id, c.club_name 
                     FROM user_clubs uc 
                     INNER JOIN clubs c ON uc.club_id = c.club_id 
                     WHERE uc.user_id = ?";
$stmt = $conn->prepare($joinedClubsQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$joinedResult = $stmt->get_result();

$joinedClubs = [];
while ($row = $joinedResult->fetch_assoc()) {
    $joinedClubs[$row['club_id']] = $row['club_name'];
}
$stmt->close();

// Fetch the available clubs that the user has not joined
$availableClubsQuery = "SELECT club_id, club_name 
                        FROM clubs 
                        WHERE club_id NOT IN (
                            SELECT club_id 
                            FROM user_clubs 
                            WHERE user_id = ?
                        )";
$stmt = $conn->prepare($availableClubsQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$availableResult = $stmt->get_result();

$availableClubs = [];
while ($row = $availableResult->fetch_assoc()) {
    $availableClubs[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Clubs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar .navbar-brand, .navbar .nav-link {
            color: white;
        }
        .navbar .nav-link:hover {
            color: #dcdcdc;
        }
        .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="home.php">Event Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="join_club.php">Join Clubs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="notifications.php">Notifications</a>
                </li>
                <?php if (!empty($joinedClubs)): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="joinedClubsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Joined Clubs
                        </a>
                        <div class="dropdown-menu" aria-labelledby="joinedClubsDropdown">
                            <?php foreach ($joinedClubs as $club): ?>
                                <a class="dropdown-item" href="#"><?php echo htmlspecialchars($club); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout_db.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Join Clubs Section -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <h3 class="text-center">Join a Club</h3>
                    <form action="join_club_db.php" method="POST">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($userDetails['name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($userDetails['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="club">Available Clubs</label>
                            <select name="club" id="club" class="form-control" required>
                                <option value="" disabled selected>Choose a club</option>
                                <?php if (!empty($availableClubs)): ?>
                                    <?php foreach ($availableClubs as $club): ?>
                                        <option value="<?php echo $club['club_name']; ?>">
                                            <?php echo htmlspecialchars($club['club_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>No clubs available to join</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Join Club</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
