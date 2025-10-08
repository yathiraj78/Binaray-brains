<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usn = $_POST['usn'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Plain text password
    $department = $_POST['department'];
    $user_type = 'member'; // Default to member

    $stmt = $conn->prepare("INSERT INTO users (usn, first_name, last_name, username, email, password, department, user_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $usn, $first_name, $last_name, $username, $email, $password, $department, $user_type);

    if ($stmt->execute()) {
        echo "Registration successful. You can now <a href='index.php'>login</a>.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binary Brains - Register</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <header style="background-color: #333; color: white; padding: 20px; text-align: center;">
        <h1>Binary Brains - Social Club Platform</h1>
    </header>

    <div class="container" style="max-width: 400px; margin: 50px auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2 style="text-align: center;">Register</h2>
        <form action="register.php" method="post">
            <label for="usn" style="display: block; margin-bottom: 5px;">USN:</label>
            <input type="text" id="usn" name="usn" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">

            <label for="first_name" style="display: block; margin-bottom: 5px;">First Name:</label>
            <input type="text" id="first_name" name="first_name" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">

            <label for="last_name" style="display: block; margin-bottom: 5px;">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">

            <label for="username" style="display: block; margin-bottom: 5px;">Username:</label>
            <input type="text" id="username" name="username" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">

            <label for="email" style="display: block; margin-bottom: 5px;">Email:</label>
            <input type="email" id="email" name="email" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">

            <label for="password" style="display: block; margin-bottom: 5px;">Password:</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">

            <label for="department" style="display: block; margin-bottom: 5px;">Department:</label>
            <input type="text" id="department" name="department" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">

            <button type="submit" style="width: 100%; padding: 10px; background-color: #333; color: white; border: none; border-radius: 4px; cursor: pointer;">Register</button>
        </form>
        <p style="text-align: center; margin-top: 20px;">Already have an account? <a href="index.php" style="color: #333; text-decoration: none;">Login here</a>.</p>
    </div>

    <footer style="text-align: center; padding: 10px; background-color: #333; color: white; position: relative; bottom: 0; width: 100%;">
        &copy; 2025 Binary Brains. All rights reserved.
    </footer>
</body>
</html>
