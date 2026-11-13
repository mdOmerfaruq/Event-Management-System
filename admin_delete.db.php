<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "event_management_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $conn->real_escape_string($_POST['EventID']);

    // Step 1: Delete related records from faculty_event_requests
    $conn->query("DELETE FROM faculty_event_requests WHERE event_id = $event_id");

    // Step 2: Delete the event from events table
    $deleteQuery = "DELETE FROM events WHERE EventID = $event_id";
    
    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>alert('Event deleted successfully!'); window.location.href='admin_delete.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.location.href='admin_delete.php';</script>";
    }
}

$conn->close();
?>
