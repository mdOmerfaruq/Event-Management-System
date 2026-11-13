<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="wrapper"> 
    <form action="db.php" method="POST">
      <h2>Register</h2>
      
      <!-- Name Input -->
      <div class="input-field">
        <input type="text" name="name" required>
        <label>Enter your name</label>
      </div>
      
      <!-- Email Input -->
      <div class="input-field">
        <input type="email" name="email" required>
        <label>Enter your email</label>
      </div>
      
      <!-- Password Input -->
      <div class="input-field">
        <input type="password" name="password" required>
        <label>Create a password</label>
      </div>
      
      <!-- Confirm Password Input -->
      <div class="input-field">
        <input type="password" name="confirm_password" required>
        <label>Confirm your password</label>
      </div>
      
      <!-- Student ID Input -->
      <div class="input-field">
        <input type="number" name="id" required>
        <label>Enter your ID</label>
      </div>

      <!-- Role Selection -->
      <div class="input-field">
        <label>Select your role</label>
        <select name="role" required>
          <option value="">-- Select Role --</option>
          <option value="CSE">CSE</option>
          <option value="BBA">EEE</option>
          <option value="EEE">BBA</option>
        </select>
      </div>

      <button type="submit">Register</button>
      <div class="register">
        <p>Already have an account? <a href="login.php">Login</a></p>
      </div>
    </form>
  </div>
</body>
</html>
