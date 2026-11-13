<?php
session_start();
require "db_connect.php";

$sql = "SELECT fr.request_id, f.name AS faculty_name, e.event_name, fr.status, fr.requested_at
        FROM faculty_event_requests fr
        INNER JOIN faculty f ON fr.faculty_id = f.FacultyID
        INNER JOIN events e ON fr.event_id = e.EventID
        WHERE fr.status = 'pending'";

$result = $conn->query($sql);
$requests = [];
while ($row = $result->fetch_assoc()) {
    $requests[] = $row;
}

echo json_encode(["status" => "success", "requests" => $requests]);
?>
