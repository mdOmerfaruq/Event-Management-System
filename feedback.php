<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "event_management_system";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the feedback table
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Hope  for the Best )home.php';</script>";
    } else {
        echo "<script>alert('Error submitting feedback. Please try again later.'); window.location.href='feedback_form.php';</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
