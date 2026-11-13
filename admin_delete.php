<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'event_management_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            padding: 10px;
            text-align: center;
        }

        .navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #575757;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        button {
            background-color: #ff4d4d;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="admin.php">Dashboard</a>  <!-- Link to Admin Dashboard -->
    <a href="admin_users_add.php">Manage Users</a>  <!-- Link to manage users -->
    <a href="admin_delete.php">Delete Event</a>  <!-- Link to delete an event -->
    <a href="logout_db.php">Logout</a>  <!-- Link to log out -->
</div>

<h2>Manage Events</h2>

<!-- Events Table -->
<table>
    <tr>
        <th>Event Name</th>
        <th>Event Date</th>
        <th>Club</th>
        <th>Action</th>
    </tr>
    <?php
    // Fetch events and their associated clubs
    $query = "SELECT e.EventID, e.event_name, e.eventdate, c.club_name 
              FROM events e JOIN clubs c ON e.club_id = c.club_id";
    $result = $conn->query($query);

    while ($event = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$event['event_name']}</td>
            <td>{$event['eventdate']}</td>
            <td>{$event['club_name']}</td>
            <td>
                <form action='admin_delete.db.php' method='POST' style='display:inline-block;'>
                    <input type='hidden' name='EventID' value='{$event['EventID']}'>
                    <button type='submit' onclick='return confirm(\"Are you sure you want to delete this event?\")'>Delete</button>
                </form>
            </td>
        </tr>";
    }

    // Close connection
    $conn->close();
    ?>
</table>

</body>
</html>
