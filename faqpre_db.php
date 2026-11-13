<?php
$conn = new mysqli("localhost", "root", "", "event_management_system"); // Updated database name

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, question FROM chatbot_responses"; // Assuming 'faq' is your table name
$result = $conn->query($sql);
$questions = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}

echo json_encode($questions);
$conn->close();
?>
