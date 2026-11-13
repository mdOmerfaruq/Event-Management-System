<?php
session_start();
$conn = new mysqli("localhost", "root", "", "event_management_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access!";
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["club_id"])) {
    $clubId = intval($_POST["club_id"]);

    // Delete notifications for the specific user and club
    $deleteQuery = "DELETE FROM user_notifications WHERE user_id = ? AND club_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("ii", $userId, $clubId);

    if ($stmt->execute()) {
        echo "Notifications deleted successfully!";
    } else {
        echo "Failed to delete notifications.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
