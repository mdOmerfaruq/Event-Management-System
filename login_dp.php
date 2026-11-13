<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user inputs
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Password should not be sanitized as it's hashed

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'event_management_system');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize variables
    $hashedPassword = null;
    $userType = null;
    $userName = null;
    $user_id = null;

    // Check email in 'admin' table first
    $sql_admin = "SELECT AdminID, name, Password FROM admin WHERE email = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("s", $email);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    if ($result_admin->num_rows > 0) {
        $row = $result_admin->fetch_assoc();
        $hashedPassword = $row['Password'];
        $userType = 'admin';
        $userName = $row['name'];
        $user_id = $row['AdminID'];
    } else {
        // Check email in 'faculty' table
        $sql_faculty = "SELECT FacultyID, name, Password FROM faculty WHERE email = ?";
        $stmt_faculty = $conn->prepare($sql_faculty);
        $stmt_faculty->bind_param("s", $email);
        $stmt_faculty->execute();
        $result_faculty = $stmt_faculty->get_result();

        if ($result_faculty->num_rows > 0) {
            $row = $result_faculty->fetch_assoc();
            $hashedPassword = $row['Password'];
            $userType = 'faculty';
            $userName = $row['name'];
            $user_id = $row['FacultyID'];
        } else {
            // Check email in 'users' table
            $sql_users = "SELECT UserID, name, Password FROM users WHERE email = ?";
            $stmt_users = $conn->prepare($sql_users);
            $stmt_users->bind_param("s", $email);
            $stmt_users->execute();
            $result_users = $stmt_users->get_result();

            if ($result_users->num_rows > 0) {
                $row = $result_users->fetch_assoc();
                $hashedPassword = $row['Password'];
                $userType = 'user';
                $userName = $row['name'];
                $user_id = $row['UserID'];
            }
        }
    }

    // Password verification and session management
    if ($hashedPassword) {
        if (password_verify($password, $hashedPassword)) {
            // Store user information in session
            $_SESSION['is_logged_in'] = true;
            $_SESSION['user_id'] = $user_id; // Store user ID
            $_SESSION['userType'] = $userType;
            $_SESSION['user_name'] = $userName;
            $_SESSION['email'] = $email;

            // Redirect based on user type
            switch ($userType) {
                case 'admin':
                    header("Location: admin.php");
                    exit();
                case 'faculty':
                    $_SESSION['FacultyID'] = $user_id; // Store FacultyID if faculty
                    header("Location: faculty.php");
                    exit();
                case 'user':
                    header("Location: home.php");
                    exit();
                default:
                    echo "<p style='color: red;'>User type not recognized!</p>";
            }
        } else {
            echo "<p style='color: red;'>Invalid password!</p>";
        }
    } else {
        echo "<p style='color: red;'>Email not found!</p>";
    }

    // Close all prepared statements and connections
    if (isset($stmt_admin)) $stmt_admin->close();
    if (isset($stmt_faculty)) $stmt_faculty->close();
    if (isset($stmt_users)) $stmt_users->close();
    $conn->close();
}
?>
