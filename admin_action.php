<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true || $_SESSION['userType'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_management_system";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle accepting the request
if (isset($_POST['acceptRequestBtn']) && isset($_POST['request_id'])) {
    $requestId = $_POST['request_id'];

    // Get the faculty ID and event ID from the request
    $sql = "SELECT faculty_id, event_id FROM faculty_event_requests WHERE request_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $facultyId = $row['faculty_id'];
        $eventId = $row['event_id'];

        // Insert into event_registrations table
        $insertQuery = "INSERT INTO event_registrations (UserID, EventID, RegistrationDate, role) 
                        VALUES (?, ?, NOW(), 'faculty')";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ii", $facultyId, $eventId);
        
        if ($insertStmt->execute()) {
            // Update the status of the request to 'approved'
            $updateQuery = "UPDATE faculty_event_requests SET status = 'approved' WHERE request_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("i", $requestId);
            $updateStmt->execute();

            $message = "Request accepted and registration added.";
        } else {
            $message = "Failed to accept request.";
        }
        
        $insertStmt->close();
        $updateStmt->close();
    } else {
        $message = "Request not found.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Dashboard - Event Management System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="home.php">Admin Dashboard</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="admin.php" class="nav-link">Home</a></li>

          <li class="nav-item cta"><a href="logout_db.php" class="nav-link">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Admin Dashboard Section -->
  <section class="ftco-section">
    <div class="container">
      <h2 class="mb-4">Admin - Event Join Requests</h2>

      <!-- Display message if any -->
      <?php if (isset($message)) : ?>
          <div class="alert alert-info"><?php echo $message; ?></div>
      <?php endif; ?>

      <!-- Event Join Requests -->
      <div class="event-join-requests mb-5">
        <h3>Pending Requests</h3>
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>Faculty Name</th>
              <th>Event Name</th>
              <th>Request Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Fetch pending requests
            $sql = "SELECT fr.request_id, f.name AS faculty_name, e.event_name, fr.requested_at
                    FROM faculty_event_requests fr
                    JOIN faculty f ON fr.faculty_id = f.FacultyID
                    JOIN events e ON fr.event_id = e.EventID
                    WHERE fr.status = 'pending'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $index = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$index}</td>
                        <td>{$row['faculty_name']}</td>
                        <td>{$row['event_name']}</td>
                        <td>{$row['requested_at']}</td>
                        <td>
                          <form method='POST'>
                            <input type='hidden' name='request_id' value='{$row['request_id']}'>
                            <button type='submit' class='btn btn-success btn-sm' name='acceptRequestBtn'>Accept</button>
                          </form>
                        </td>
                    </tr>";
                    $index++;
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No pending requests</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Scripts -->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
