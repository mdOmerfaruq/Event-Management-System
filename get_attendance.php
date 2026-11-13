<?php
session_start();

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

$facultyId = $_SESSION['faculty_id'];

// SQL query to get events and status of faculty requests
$sql = "SELECT e.event_name, e.start_date, e.end_date, e.location, fr.status
        FROM faculty_event_requests fr
        INNER JOIN events e ON fr.event_id = e.EventID
        WHERE fr.faculty_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $facultyId);  // Binding the faculty_id to the prepared statement
$stmt->execute();
$result = $stmt->get_result();
$attendance = [];

// Fetch the results and store them in an array
while ($row = $result->fetch_assoc()) {
    $attendance[] = $row;
}

// Return the attendance data as a JSON response
echo json_encode($attendance);

// Close the statement and connection
$stmt->close();
$conn->close();
?>
