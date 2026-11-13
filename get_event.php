<?php
// Direct database connection parameters
$servername = "localhost";  // Your database server
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "event_management_system";  // Your database name

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// SQL query to fetch events from the events table
$sql = "SELECT EventID, event_name, start_date, end_date, location, description FROM events";
$result = $conn->query($sql);
$events = [];

// Fetch all events and store them in an array
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

// Return the events data as a JSON response
echo json_encode($events);

// Close the database connection
$conn->close();
?>
