

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="wrapper">
        <form action="login_dp.php" method="POST">
            <h2>Login</h2>
            <?php
            if (isset($loginError)) {
                echo "<p style='color: red; text-align: center;'>$loginError</p>";
            }
            ?>
            <div class="input-field">
                <input type="text" name="email" required>
                <label>Enter your email</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Enter your password</label>
            </div>
            
            <button type="submit">Log In</button>
            <div class="register">
                <p>Don't have an account? <a href="registrastion.php">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>
