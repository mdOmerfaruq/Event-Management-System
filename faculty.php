<?php
session_start();

// Check if the faculty is logged in
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true || !isset($_SESSION['FacultyID'])) {
    header("Location: login.php");
    exit();
}

$facultyId = $_SESSION['FacultyID'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_management_system";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle faculty join request
if (isset($_POST['requestJoinBtn']) && isset($_POST['EventID'])) {
    $eventId = $_POST['EventID'];

    $checkRequestQuery = "SELECT * FROM faculty_event_requests WHERE faculty_id = ? AND event_id = ?";
    $stmt = $conn->prepare($checkRequestQuery);
    $stmt->bind_param("ii", $facultyId, $eventId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "Request already sent.";
    } else {
        $insertQuery = "INSERT INTO faculty_event_requests (faculty_id, event_id, requested_at, status) VALUES (?, ?, NOW(), 'pending')";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ii", $facultyId, $eventId);

        if ($stmt->execute()) {
            $message = "Request sent successfully.";
        } else {
            $message = "Failed to send request.";
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Faculty Dashboard - Event Management System</title>
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
      <a class="navbar-brand" href="#">Faculty Dashboard</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="faculty.php" class="nav-link">Home</a></li>
         
          <li class="nav-item cta"><a href="logout_db.php" class="nav-link">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Faculty Dashboard Section -->
  <section class="ftco-section">
    <div class="container">
      <h2 class="mb-4">Welcome, Faculty Member</h2>

      <!-- Display message if any -->
      <?php if (isset($message)) : ?>
          <div class="alert alert-info"><?php echo $message; ?></div>
      <?php endif; ?>

      <!-- Available Events Section -->
      <div class="available-events mb-5">
        <h3>Available Events</h3>
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>Event Name</th>
              <th>Date & Time</th>
              <th>Location</th>
              <th>Description</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $eventsQuery = "SELECT * FROM events WHERE EventID NOT IN (SELECT event_id FROM faculty_event_requests WHERE faculty_id = ?)";
            $stmt = $conn->prepare($eventsQuery);
            $stmt->bind_param("i", $facultyId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $index = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$index}</td>
                        <td>{$row['event_name']}</td>
                        <td>{$row['start_date']} - {$row['end_date']}</td>
                        <td>{$row['location']}</td>
                        <td>{$row['description']}</td>
                        <td>
                          <form method='POST'>
                            <input type='hidden' name='EventID' value='{$row['EventID']}'>
                            <button type='submit' class='btn btn-primary btn-sm' name='requestJoinBtn'>Request to Join</button>
                          </form>
                        </td>
                    </tr>";
                    $index++;
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No events available</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

      <!-- Pending Requests Section -->
      <div class="required-events">
        <h3>Events You Need to Attend</h3>
        <table class="table table-bordered">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>Event Name</th>
              <th>Date & Time</th>
              <th>Location</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $pendingQuery = "SELECT e.event_name, e.start_date, e.end_date, e.location, fr.status 
                             FROM events e
                             JOIN faculty_event_requests fr ON e.EventID = fr.event_id
                             WHERE fr.faculty_id = ?";
            $stmt = $conn->prepare($pendingQuery);
            $stmt->bind_param("i", $facultyId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $index = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$index}</td>
                        <td>{$row['event_name']}</td>
                        <td>{$row['start_date']} - {$row['end_date']}</td>
                        <td>{$row['location']}</td>
                        <td>{$row['status']}</td>
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

<?php
$conn->close();
?>
