<!DOCTYPE html>
<html lang="en">
<head>
  <title>Manage Events - Event Management System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="open-iconic-bootstrap.min.css">
  <link rel="stylesheet" href="animate.css">
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="admin_dashboard.html">Admin Dashboard</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="admin.php" class="nav-link">Dashboard</a></li>
          <li class="nav-item"><a href="admin_users_add.php" class="nav-link">Manage Users</a></li>
          <li class="nav-item"><a href="admin_reports.php" class="nav-link">Reports</a></li>
          <li class="nav-item cta"><a href="home.html" class="nav-link">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Manage Events Section -->
  <section class="ftco-section">
    <div class="container">
      <h2 class="mb-4">Manage Events</h2>

      <!-- Add Event Form -->
      <div class="add-event mb-5">
        <h3>Add New Event</h3>
        <form action="add_event.php" method="POST">
          <div class="form-group">
            <label for="eventName">Event Name:</label>
            <input type="text" id="eventName" name="eventName" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="eventDate">Event Date:</label>
            <input type="date" id="eventDate" name="eventDate" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="eventDescription">Description:</label>
            <textarea id="eventDescription" name="eventDescription" class="form-control" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Add Event</button>
        </form>
      </div>

      <!-- Available Events -->
      <div class="available-events">
        <h3>Available Events</h3>
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>Event Name</th>
              <th>Date</th>
              <th>Description</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Replace this with dynamically generated rows -->
            <tr>
              <td>1</td>
              <td>Annual Tech Meetup</td>
              <td>2025-02-20</td>
              <td>Discussion on emerging technologies.</td>
              <td>
                <a href="edit_event.php?id=1" class="btn btn-warning btn-sm">Edit</a>
                <form action="delete_event.php" method="POST" style="display:inline;">
                  <input type="hidden" name="event_id" value="1">
                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
              </td>
            </tr>
            <!-- Example for more events -->
            <tr>
              <td>2</td>
              <td>Art Exhibition</td>
              <td>2025-03-15</td>
              <td>Showcasing local talent.</td>
              <td>
                <a href="edit_event.php?id=2" class="btn btn-warning btn-sm">Edit</a>
                <form action="delete_event.php" method="POST" style="display:inline;">
                  <input type="hidden" name="event_id" value="2">
                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Scripts -->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
