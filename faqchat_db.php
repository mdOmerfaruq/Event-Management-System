<?php
$conn = new mysqli("localhost", "root", "", "event_management_system");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input = strtolower(trim($_POST["message"]));

    // Predefined static responses (can be moved to database)
    $predefined_responses = [
        "how_to_login" => "To log in, enter your credentials on the <a href='login.php'>Login Page</a>.",
        "how_to_register" => "To register, fill in the form on the <a href='register.php'>Registration Page</a>.",
        "about_us" => "We are a community focused on organizing events and providing club opportunities.",
        "contact_us" => "You can contact us via email at <a href='mailto:contact@university.com'>contact@university.com</a>.",
        "how_to_register_events" => "To register for events, visit the <a href='event_register.php'>Event Registration Page</a>.",
        "how_to_join_clubs" => "To join a club, fill out the membership form on the club's page.",
    ];

    // Check if input matches predefined responses
    if (isset($predefined_responses[$user_input])) {
        echo $predefined_responses[$user_input];
        exit;
    }

    // Fetch upcoming events dynamically
    if ($user_input == "upcoming_events") {
        $sql = "SELECT event_name, eventdate FROM events ORDER BY eventdate ASC";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $events = "";
            while ($row = $result->fetch_assoc()) {
                $events .= "📅 <b>Event:</b> " . $row["event_name"] . " | 🗓️ <b>Date:</b> " . $row["eventdate"] . "<br>";
            }
            echo $events;
        } else {
            echo "No upcoming events at the moment.";
        }
        exit;
    }

    // Fetch available clubs dynamically
    if ($user_input == "available_clubs") {
        $sql = "SELECT club_name FROM clubs ORDER BY club_name ASC";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $clubs = "";
            while ($row = $result->fetch_assoc()) {
                $clubs .= "🏫 <b>Club:</b> " . $row["club_name"] . "<br>";
            }
            echo $clubs;
        } else {
            echo "No clubs available at the moment.";
        }
        exit;
    }

    // Fetch responses dynamically from database
    $stmt = $conn->prepare("SELECT response FROM chatbot_responses WHERE question LIKE ?");
    $searchTerm = "%" . $user_input . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row["response"]; // Use correct column name
    } else {
        echo "❌ Sorry, I don't understand that yet.";
    }

    $stmt->close();
}
$conn->close();
?>
