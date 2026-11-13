<?php
session_start();
$conn = new mysqli("localhost", "root", "", "event_management_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch notifications for the user regarding events that start within the next 24 hours
$notificationQuery = "
    SELECT 
        un.user_notification_id,
        un.user_id,
        un.notification_id,
        un.read_status,
        un.created_at AS notification_created_at,
        c.club_name,
        e.event_name,
        e.start_date AS event_start_date,
        e.location AS event_location,
        e.speaker AS event_speaker,
        e.description AS event_description
    FROM user_notifications un
    INNER JOIN clubs c ON un.club_id = c.club_id
    INNER JOIN events e ON un.club_id = e.club_id
    WHERE un.user_id = ?  
      AND e.start_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 DAY)  -- Events that start within the next 24 hours
    ORDER BY un.created_at DESC
";

$stmt = $conn->prepare($notificationQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        "user_notification_id" => $row['user_notification_id'],
        "club_name" => $row['club_name'],
        "event_name" => $row['event_name'],
        "event_start_date" => $row['event_start_date'], // Start date of the event
        "event_location" => $row['event_location'],
        "event_speaker" => $row['event_speaker'],
        "event_description" => $row['event_description'],
        "notification_created_at" => $row['notification_created_at'],
        "read_status" => $row['read_status'] // To manage read/unread status
    ];
}

echo json_encode(["status" => "success", "notifications" => $notifications]);

?>
