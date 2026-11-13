<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'event_management_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users
$userQuery = "SELECT * FROM users"; // Removed the WHERE UserID = ? clause
$userResult = $conn->query($userQuery);

// Fetch all faculty
$facultyQuery = "SELECT * FROM faculty"; // Removed the WHERE FacultyID = ? clause
$facultyResult = $conn->query($facultyQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Manage Users - Event Management System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="bootstrap.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    h2 {
      margin-top: 20px;
      text-align: center;
    }
    .table-container {
      margin-top: 30px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 10px;
      text-align: center;
      border: 1px solid #ddd;
    }
    th {
      background-color: #343a40;
      color: white;
    }
    button {
      padding: 5px 10px;
      border: none;
      cursor: pointer;
    }
    .btn-danger {
      background-color: #e74c3c;
      color: white;
    }
    .btn-danger:hover {
      background-color: #c0392b;
    }
  </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="admin.php">Admin Dashboard</a>
    <div class="navbar-collapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="admin.php" class="nav-link">Dashboard</a></li>
        <li class="nav-item"><a href="admin_add_event.php" class="nav-link">Manage Events</a></li>
        <li class="nav-item"><a href="admin_reports.php" class="nav-link">Reports</a></li>
        <li class="nav-item cta"><a href="logout_db.php" class="nav-link">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Manage Users Section -->
<div class="container">
  <h2>Manage Users</h2>

  <!-- Users Table -->
  <div class="table-container">
    <h3>All Users</h3>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>User Name</th>
          <th>Email</th>
          <th>Role_id</th>
          <th>Role</th>
       
        </tr>
      </thead>
      <tbody>
        <?php
        if ($userResult->num_rows > 0) {
            $counter = 1;
            while ($user = $userResult->fetch_assoc()) {
                echo "<tr>
                    <td>{$counter}</td>
                    <td>{$user['name']}</td>
                    <td>{$user['email']}</td>
                    <td>{$user['role_id']}</td>
                       <td>{$user['role']}</td>
                    
                </tr>";
                $counter++;
            }
        } else {
            echo "<tr><td colspan='5'>No users found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Faculty Table -->
  <div class="table-container">
    <h3>All Faculty</h3>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Faculty Name</th>
          <th>Email</th>
          <th>Role id</th>
          <th>Role</th>
     
        </tr>
      </thead>
      <tbody>
        <?php
        if ($facultyResult->num_rows > 0) {
            $counter = 1;
            while ($faculty = $facultyResult->fetch_assoc()) {
                echo "<tr>
                    <td>{$counter}</td>
                    <td>{$faculty['name']}</td>
                    <td>{$faculty['email']}</td>
                    <td>{$faculty['role_id']}</td>
                    <td>{$faculty['role']}</td>
                    
                    
                </tr>";
                $counter++;
            }
        } else {
            echo "<tr><td colspan='5'>No faculty found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Close Database Connection -->
<?php $conn->close(); ?>

</body>
</html>
