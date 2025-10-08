<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'member') {
    header("Location: index.php");
    exit();
}
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id'];
    $message = $_POST['message'];
    
    // Set the recipient_id to the admin's user ID (assuming admin ID is 1, adjust accordingly)
    $recipient_id = 1;

    $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $recipient_id, $message);

    if ($stmt->execute()) {
        echo "Message sent to admin.";
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
    <title>Contact Admin - Binary Brains</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <header style="background-color: #333; padding: 10px;">
        <nav style="display: flex; justify-content: space-around;">
            <a href="home_member.php" style="color: white; text-decoration: none; padding: 10px;">Home</a>
            <a href="contact_admin.php" style="color: white; text-decoration: none; padding: 10px;">Contact Admin</a>
            <a href="logout.php" style="color: white; text-decoration: none; padding: 10px;">Logout</a>
        </nav>
    </header>

    <main style="padding: 20px;">
        <section style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center;">Contact Admin</h2>
            <form action="contact_admin.php" method="post">
                <label for="message" style="display: block; margin-bottom: 10px;">Message:</label>
                <textarea id="message" name="message" required style="width: 100%; height: 100px; margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                <button type="submit" style="background-color: #5cb85c; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">Send</button>
            </form>
        </section>
    </main>

    <footer style="text-align: center; padding: 10px; background-color: #333; color: white; position: relative; bottom: 0; width: 100%;">
        &copy; 2025 Binary Brains. All rights reserved.
    </footer>
</body>
</html>