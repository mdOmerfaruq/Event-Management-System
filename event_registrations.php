<?php
session_start();
$conn = new mysqli("localhost", "root", "", "event_management_system");

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color: red;'>You must log in to register for events.</p>";
    exit;
}

// Process the registration form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['user_id'];

    // Check if the user is already registered for the event
    $checkQuery = "SELECT * FROM event_registrations WHERE UserID = '$user_id' AND EventID = '$event_id'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // User already registered
        echo '<p style="color: red;">You have already registered for this event! <a href="All_event.php">Go back to Events</a></p>';
    } else {
        // Insert into the registration table
        $registrationQuery = "INSERT INTO event_registrations (UserID, EventID) VALUES ('$user_id', '$event_id')";
        if ($conn->query($registrationQuery) === TRUE) {
            echo '<p style="color: green;">Successfully registered for the event!</p>';
header("Location: All_event.php");
exit();

        } else {
            echo "<p style='color: red;'>Error registering: " . $conn->error . "</p>";
        }
    }
} else {
    echo "<p style='color: red;'>Invalid request.</p>";
}

$conn->close();
?>
