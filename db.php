<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $roleid = strval($_POST['id']); // User Role ID
    $role = $_POST['role'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<p style='color: red; text-align: center;'>Passwords do not match!</p>";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'event_management_system');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Step 1: Check if the email or role_id already exists
    $checkEmailSql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmailSql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<p style='color: red; text-align: center;'>Email already exists. Please use a different email.</p>";
        exit();
    }
    $stmt->close(); // Close previous statement

    // Step 2: Insert the user into the users table
    $createAt = date('Y-m-d H:i:s');
    $insertUserSql = "INSERT INTO users (name, email, password, role_id, created_at, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertUserSql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $name, $email, $hashedPassword, $roleid, $createAt, $role);

    if ($stmt->execute()) {
        $rolePrefix = substr($roleid, 0, 3);

        // Additional role-based inserts
        if ($rolePrefix === '123') { // Admin
            $insertAdminSql = "INSERT INTO admin (name, password, email, role_id, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertAdminSql);
            $stmt->bind_param("sssss", $name, $hashedPassword, $email, $roleid, $role);
        } elseif ($rolePrefix === '111') { // Faculty
            $insertFacultySql = "INSERT INTO faculty (name, email, password, role_id, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertFacultySql);
            $stmt->bind_param("sssss", $name, $email, $hashedPassword, $roleid, $role);
        } elseif ($rolePrefix === '011') {
            // No additional action needed for this role
        } else {
            echo "<p style='color: red; text-align: center;'>Invalid Role ID prefix!</p>";
            exit();
        }

        // Execute role-specific insertion
        if ($rolePrefix !== '003' && !$stmt->execute()) {
            echo "<p style='color: red; text-align: center;'>Error: " . $stmt->error . "</p>";
            exit();
        }

        // Redirect based on role
        if ($rolePrefix === '123') {
            header("Location: admin.php");
            exit();
        } elseif ($rolePrefix === '111') {
            header("Location: faculty.php");
            exit();
        } elseif ($rolePrefix === '011') {
            header("Location: home.php");
            exit();
        }
    } else {
        echo "<p style='color: red; text-align: center;'>Error: " . $stmt->error . "</p>";
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
