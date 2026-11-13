<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            text-align: center;
            padding: 20px;
            margin: 0;
        }

        .navbar {
            background-color: #333;
            padding: 10px 0;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar a {
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
        }

        .navbar a:hover {
            background-color: #444;
        }

        .container {
            background-color: white;
            width: 60%;
            margin: auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .notifications {
            background: #ffeb3b;
            color: #000;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            display: none; /* Initially hidden */
        }

        .event {
            background: #e9ecef;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            text-align: left;
        }
    </style>
    <script>
        function fetchNotifications() {
            fetch("notifications_db.php")
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success" && data.notifications.length > 0) {
                        let notificationArea = document.getElementById("notifications");
                        notificationArea.innerHTML = ""; // Clear old notifications
                        data.notifications.forEach(notification => {
                            let div = document.createElement("div");
                            div.classList.add("event");
                            div.innerHTML = `
                                <strong>${notification.club_name}:</strong> ${notification.event_name} - ${notification.event_start_date}<br>
                                <strong>Location:</strong> ${notification.event_location}<br>
                                <strong>Speaker:</strong> ${notification.event_speaker}<br>
                                <strong>Description:</strong> ${notification.event_description}<br>
                            `;
                            notificationArea.appendChild(div);
                        });
                        notificationArea.style.display = "block"; // Show notification area
                    }
                })
                .catch(error => console.error("Error fetching notifications:", error));
        }

        setInterval(fetchNotifications, 5000); // Fetch notifications every 5 seconds
        window.onload = fetchNotifications; // Load notifications on page load
    </script>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="notifications.php">Notifications</a>
        <a href="join_club.php">Clubs</a>
        <a href="logout_db.php">Logout</a>
    </div>

    <div class="container">
        <h2>Welcome to the User Dashboard</h2>

        <div id="notifications" class="notifications"></div> <!-- Notification Box -->

        <div class="clubs-container">
            <p>All your clubs and events will be displayed here.</p>
        </div>
    </div>

</body>
</html>
