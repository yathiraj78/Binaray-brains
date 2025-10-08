<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    $stmt = $conn->prepare("SELECT id, username, password, user_type FROM users WHERE username = ? AND user_type = ?");
    $stmt->bind_param("ss", $username, $user_type);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $stored_password, $user_type);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        // Compare input password with stored password (plain text)
        if ($password == $stored_password) {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;
            $_SESSION['user_type'] = $user_type;
            if ($user_type == 'admin') {
                header("Location: home_admin.php");
            } else {
                header("Location: home_member.php");
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that username and user type.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binary Brains - Login</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <header style="background-color: #333; color: white; padding: 20px; text-align: center;">
        <h1>Binary Brains - Social Club Platform</h1>
    </header>

    <div class="container" style="max-width: 400px; margin: 50px auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2 style="text-align: center;">Login</h2>
        <?php if (isset($error)): ?>
            <p style="color: red; text-align: center;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="username" style="display: block; margin-bottom: 5px;">Username:</label>
            <input type="text" id="username" name="username" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">
            
            <label for="password" style="display: block; margin-bottom: 5px;">Password:</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">
            
            <label for="user_type" style="display: block; margin-bottom: 5px;">User  Type:</label>
            <select id="user_type" name="user_type" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">
                <option value="member">Member</option>
                <option value="admin">Admin</option>
            </select>
            
            <button type="submit" style="background-color: #5cb85c; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; width: 100%;">Login</button>
        </form>
        <p style="text-align: center; margin-top: 10px;">Don't have an account? <a href="register.php" style="color: #5cb85c; text-decoration: none;">Register here</a>.</p>
    </div>

    <footer style="text-align: center; padding: 10px; background-color: #333; color: white; position: relative; bottom: 0; width: 100%;">
        &copy; 2025 Binary Brains. All rights reserved.
    </footer>
</body>
</html>