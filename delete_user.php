<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'event_management_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user_id is provided
if (isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    // Delete query
    $query = "DELETE FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId); // 'i' indicates integer type

    if ($stmt->execute()) {
        echo "User deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Close connection
$conn->close();

// Redirect back to manage users page
header("Location: admin_users_add.php");
exit();
?>
