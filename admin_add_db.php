<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data and ensure all fields are set
    $event_name = isset($_POST['event_name']) ? trim($_POST['event_name']) : '';
    $start_date = isset($_POST['start_date']) ? trim($_POST['start_date']) : '';
    $end_date = isset($_POST['end_date']) ? trim($_POST['end_date']) : '';
    $club_id = isset($_POST['club_id']) ? (int)$_POST['club_id'] : 0;
    $location = isset($_POST['location']) ? trim($_POST['location']) : ''; // Ensure location is a string
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $speaker = isset($_POST['speaker']) ? trim($_POST['speaker']) : '';

    // Convert start and end dates to MySQL format
    $start_date = date('Y-m-d H:i:s', strtotime($start_date));
    $end_date = date('Y-m-d H:i:s', strtotime($end_date));

    // Handle file upload
    $image_url = NULL;
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $file_name = time() . '_' . basename($_FILES['image_url']['name']);
        $image_url = 'uploads/' . $file_name;

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_extensions)) {
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }

            if ($_FILES['image_url']['size'] <= 5 * 1024 * 1024) {
                move_uploaded_file($_FILES['image_url']['tmp_name'], $image_url);
            } else {
                echo "File is too large. Max size is 5MB.";
                exit;
            }
        } else {
            echo "Invalid file type.";
            exit;
        }
    }

    // Create database connection
    $conn = new mysqli('localhost', 'root', '', 'event_management_system');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Debugging: Check the values before inserting
    echo "Event Name: $event_name<br>";
    echo "Start Date: $start_date<br>";
    echo "End Date: $end_date<br>";
    echo "Club ID: $club_id<br>";
    echo "Location: $location<br>"; // Check if location is displayed correctly
    echo "Description: $description<br>";
    echo "Speaker: $speaker<br>";
    echo "Image URL: " . ($image_url ?? 'No Image') . "<br>";

    // Prepare SQL query to insert event data
    $stmt = $conn->prepare("INSERT INTO events (event_name, start_date, end_date, club_id, location, description, speaker, image_url) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $image_url_param = $image_url ? $image_url : '';

    $stmt->bind_param("sssissss", $event_name, $start_date, $end_date, $club_id, $location, $description, $speaker, $image_url_param);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "New event added successfully.";
        header("Location: admin_add_event.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
