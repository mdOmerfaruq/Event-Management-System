<?php
session_start();

// Database Connection (Direct)
$servername = "localhost"; // Change if different
$username = "root"; // Change as per your database
$password = ""; // Change if password is set
$database = "event_management_system"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Check Faculty Login Session
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Faculty not logged in"]);
    exit();
}

$facultyId = $_SESSION['faculty_id'];
$eventId = $_POST['event_id'];

// Check if request already exists
$sql = "SELECT * FROM faculty_event_requests WHERE faculty_id = ? AND event_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $facultyId, $eventId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Request already sent"]);
} else {
    // Insert new request
    $insert = "INSERT INTO faculty_event_requests (faculty_id, event_id) VALUES (?, ?)";
    $stmt = $conn->prepare($insert);
    $stmt->bind_param("ii", $facultyId, $eventId);
    
    echo $stmt->execute() 
        ? json_encode(["status" => "success", "message" => "Request sent successfully"]) 
        : json_encode(["status" => "error", "message" => "Failed to send request"]);
}

$stmt->close();
$conn->close();
?>
