<?php
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

// Fetch clubs from the database
$sql = "SELECT club_id, club_name FROM clubs";
$result = $conn->query($sql);

// Generate options for the dropdown
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['club_id']) . '">' . htmlspecialchars($row['club_name']) . '</option>';
    }
} else {
    echo '<option value="">No clubs available</option>';
}

$conn->close();
?>
