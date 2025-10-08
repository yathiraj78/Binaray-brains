<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    header("Location: index.php");
    exit();
}
include('config.php');

// Fetch messages sent by members to the admin
$admin_id = 1; // Assuming the admin ID is 1, adjust accordingly
$messages_stmt = $conn->prepare("SELECT messages.content, messages.timestamp, users.username AS sender FROM messages JOIN users ON messages.sender_id = users.id WHERE recipient_id = ?");
$messages_stmt->bind_param("i", $admin_id);
$messages_stmt->execute();
$messages = $messages_stmt->get_result();
$messages_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - Binary Brains</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <header style="background-color: #333; padding: 10px;">
        <nav style="display: flex; justify-content: space-around;">
            <a href="home_admin.php" style="color: white; text-decoration: none; padding: 10px;">Home</a>
            <a href="logout.php" style="color: white; text-decoration: none; padding: 10px;">Logout</a>
        </nav>
    </header>

    <main style="padding: 20px;">
        <section style="max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center;">Support Messages</h2>
            <ul style="list-style-type: none; padding: 0;">
                <?php while ($row = $messages->fetch_assoc()): ?>
                    <li style="margin-bottom: 10px; border-bottom: 1px solid #ccc; padding: 10px;">
                        <strong><?php echo $row['sender']; ?></strong>: <?php echo $row['content']; ?> <em>(<?php echo $row['timestamp']; ?>)</em>
                    </li>
                <?php endwhile; ?>
            </ul>
        </section>
    </main>

    <footer style="text-align: center; padding: 10px; background-color: #333; color: white; position: relative; bottom: 0; width: 100%;">
        &copy; 2025 Binary Brains. All rights reserved.
    </footer>
</body>
</html>

<?php
$conn->close();
?>