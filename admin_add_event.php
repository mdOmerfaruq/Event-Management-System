<div class="navbar">
    <a href="admin.php">Dashboard</a>  <!-- Link to Admin Dashboard -->
    <a href="admin_users_add.php">Manage Users</a>  <!-- Link to manage users -->
    <a href="admin_delete.php">Delete Event</a>  <!-- Link to delete an event -->
    <a href="logout_db.php">Logout</a>  <!-- Link to log out -->
</div>
<h2>Add Event</h2>
<form action="admin_add_db.php" method="POST" enctype="multipart/form-data" class="event-form">
    <label for="event_name">Event Name:</label><br>
    <input type="text" id="event_name" name="event_name" required><br><br>

    <label for="start_date">Start Date & Time:</label><br>
    <input type="datetime-local" id="start_date" name="start_date" required><br><br>

    <label for="end_date">End Date & Time:</label><br>
    <input type="datetime-local" id="end_date" name="end_date" required><br><br>

    <label for="club_id">Club:</label><br>
    <select id="club_id" name="club_id" required>
        <?php
        // Fetch clubs from the database
        $conn = new mysqli('localhost', 'root', '', 'event_management_system');
        $clubs = $conn->query("SELECT club_id, club_name FROM clubs");
        while ($club = $clubs->fetch_assoc()) {
            echo "<option value='{$club['club_id']}'>{$club['club_name']}</option>";
        }
        ?>
    </select><br><br>

    <label for="location">Location:</label><br>
    <input type="text" id="location" name="location" required><br><br>

    <label for="speaker">Speaker:</label><br>
    <input type="text" id="speaker" name="speaker"><br><br>

    <label for="image_url">Image:</label><br>
    <input type="file" id="image_url" name="image_url"><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description"></textarea><br><br>

    <button type="submit">Add Event</button>
</form>

<!-- Embedded CSS for Styling -->
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

    .event-form {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .event-form label {
        font-size: 16px;
        color: #333;
        display: block;
        margin-bottom: 8px;
    }

    .event-form input[type="text"],
    .event-form input[type="datetime-local"],
    .event-form input[type="file"],
    .event-form select,
    .event-form textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    .event-form button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    .event-form button:hover {
        background-color: #45a049;
    }

    .event-form input[type="file"] {
        padding: 3px;
    }

    .event-form textarea {
        height: 150px;
        resize: vertical;
    }

    .event-form input[type="text"]:focus,
    .event-form input[type="datetime-local"]:focus,
    .event-form select:focus,
    .event-form textarea:focus {
        border-color: #4CAF50;
        outline: none;
    }
</style>
