<?php
// Start the session to track the logged-in user
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "event_management_system";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo "<script>alert('User is not logged in. Please log in to join a club.'); window.location.href='login.php';</script>";
    exit();
}

// Retrieve the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize the input
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $club_name = $conn->real_escape_string($_POST['club']);

    // Validate that the logged-in user's email matches the submitted email
    $userQuery = "SELECT email FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($userQuery);
    if (!$stmt) {
        echo "<script>alert('Database query preparation failed.'); window.location.href='join_club.php';</script>";
        exit();
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $userResult = $stmt->get_result();

    if ($userResult && $userResult->num_rows > 0) {
        $userRow = $userResult->fetch_assoc();
        if ($userRow['email'] !== $email) {
            echo "<script>alert('The email does not match the logged-in user!'); window.location.href='join_club.php';</script>";
            exit();
        }

        // Get the club_id from the clubs table
        $clubQuery = "SELECT club_id FROM clubs WHERE club_name = ?";
        $stmt = $conn->prepare($clubQuery);
        if (!$stmt) {
            echo "<script>alert('Database query preparation failed.'); window.location.href='join_club.php';</script>";
            exit();
        }
        $stmt->bind_param("s", $club_name);
        $stmt->execute();
        $clubResult = $stmt->get_result();

        if ($clubResult && $clubResult->num_rows > 0) {
            $clubRow = $clubResult->fetch_assoc();
            $club_id = $clubRow['club_id'];

            // Check if the user is already registered for the selected club
            $checkQuery = "SELECT * FROM user_clubs WHERE user_id = ? AND club_id = ?";
            $stmt = $conn->prepare($checkQuery);
            if (!$stmt) {
                echo "<script>alert('Database query preparation failed.'); window.location.href='join_club.php';</script>";
                exit();
            }
            $stmt->bind_param("ii", $user_id, $club_id);
            $stmt->execute();
            $checkResult = $stmt->get_result();

            if ($checkResult && $checkResult->num_rows > 0) {
                echo "<script>alert('You are already a member of $club_name.'); window.location.href='join_club.php';</script>";
            } else {
                // Insert the user and club relationship into the user_clubs table
                $insertQuery = "INSERT INTO user_clubs (user_id, club_id, name, email, club_name) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertQuery);
                if (!$stmt) {
                    echo "<script>alert('Database query preparation failed.'); window.location.href='join_club.php';</script>";
                    exit();
                }
                $stmt->bind_param("iisss", $user_id, $club_id, $name, $email, $club_name);

                if ($stmt->execute()) {
                    echo "<script>alert('Successfully joined $club_name!'); window.location.href='join_club.php';</script>";
                } else {
                    echo "<script>alert('An unexpected error occurred. Please try again later.'); window.location.href='join_club.php';</script>";
                }
            }
        } else {
            echo "<script>alert('Invalid club selected!'); window.location.href='join_club.php';</script>";
        }
    } else {
        echo "<script>alert('The logged-in user does not exist!'); window.location.href='join_club.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='join_club.php';</script>";
}

// Close the database connection
$conn->close();
?>
