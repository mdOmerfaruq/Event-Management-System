<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'event_management_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch event details and count participants from event_registrations
$query = "
    SELECT 
        e.EventID, 
        e.event_name, 
        e.eventdate, 
        e.start_date, 
        e.end_date, 
        e.location, 
        COUNT(er.RegistrationID) AS total_participants
    FROM 
        events e
    LEFT JOIN 
        event_registrations er ON e.EventID = er.EventID
    GROUP BY 
        e.EventID, e.event_name, e.eventdate, e.start_date, e.end_date, e.location
    ORDER BY 
        e.eventdate DESC;
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Event Participants - Event Management System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="admin.php" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="admin_add_event.php" class="nav-link">Manage Events</a></li>
                <li class="nav-item"><a href="admin_users_add.php" class="nav-link">Manage Users</a></li>
                <li class="nav-item"><a href="admin_reports.php" class="nav-link">Reports</a></li>
                <li class="nav-item"><a href="logout_db.php" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<h2>Event Participants Report</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Event Name</th>
            <th>Event Date</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Location</th>
            <th>Total Participants</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            $counter = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$counter}</td>
                    <td>{$row['event_name']}</td>
                    <td>{$row['eventdate']}</td>
                    <td>{$row['start_date']}</td>
                    <td>{$row['end_date']}</td>
                    <td>{$row['location']}</td>
                    <td>{$row['total_participants']}</td>
                </tr>";
                $counter++;
            }
        } else {
            echo "<tr><td colspan='7'>No events found</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
// Close database connection
$conn->close();
?>

</body>
</html>
