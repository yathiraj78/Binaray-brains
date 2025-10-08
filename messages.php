<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include('config.php');

// Fetch all clubs
$clubs = $conn->query("SELECT * FROM clubs");

// Initialize messages and members
$messages = null;
$members_result = null;

// Check if a club is selected
if (isset($_POST['club_id'])) {
    $club_id = $_POST['club_id'];
    $user_id = $_SESSION['id'];

    // Fetch messages
    $stmt = $conn->prepare("SELECT messages.content, messages.timestamp, users.username AS sender FROM messages JOIN users ON messages.sender_id = users.id WHERE messages.club_id = ? AND (messages.sender_id = ? OR messages.recipient_id = ?) ORDER BY messages.timestamp DESC");
    $stmt->bind_param("iii", $club_id, $user_id, $user_id);
    $stmt->execute();
    $messages = $stmt->get_result();
    $stmt->close();

    // Fetch club members for the recipient dropdown
    $members_stmt = $conn->prepare("SELECT users.id, users.username FROM club_members JOIN users ON club_members.user_id = users.id WHERE club_members.club_id = ? AND users.id != ?");
    $members_stmt->bind_param("ii", $club_id, $user_id);
    $members_stmt->execute();
    $members_result = $members_stmt->get_result();
    $members_stmt->close();
}

// Handle sending a message
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content'])) {
    $club_id = $_POST['club_id'];
    $recipient_id = $_POST['recipient_id'];
    $content = $_POST['content'];
    $user_id = $_SESSION['id'];

    $stmt = $conn->prepare("INSERT INTO messages (club_id, sender_id, recipient_id, content) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $club_id, $user_id, $recipient_id, $content);

    if ($stmt->execute()) {
        header("Location: messages.php?club_id=$club_id");
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
    <title>Messages - Binary Brains</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <header style="background-color: #333; padding: 10px;">
        <nav style="display: flex; justify-content: space-around;">
            <a href="home_member.php" style="color: white; text-decoration: none; padding: 10px;">Home</a>
            <a href="messages.php" style="color: white; text-decoration: none; padding: 10px;">Messages</a>
            <a href="logout.php" style="color: white; text-decoration: none; padding: 10px;">Logout</a>
        </nav>
    </header>

    <main style="padding: 20px;">
        <section style="max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center;">Messages</h2>
            <form action="messages.php" method="post">
                <label for="club_id" style="display: block; margin-bottom: 10px;">Select Club:</label>
                <select id="club_id" name="club_id" onchange="this.form.submit()" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="" disabled selected>Select a club</option>
                    <?php while ($row = $clubs->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>" <?php if (isset($club_id) && $club_id == $row['id']) echo 'selected'; ?>>
                            <?php echo $row['club_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </form>

            <?php if ($messages): ?>
                <form action="messages.php" method="post">
                    <input type=" hidden" name="club_id" value="<?php echo $club_id; ?>">
                    <label for="recipient_id" style="display: block; margin-bottom: 10px;">Send to:</label>
                    <select id="recipient_id" name="recipient_id" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">
                        <?php while ($row = $members_result->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['username']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <label for="content" style="display: block; margin-bottom: 10px;">Message:</label>
                    <textarea id="content" name="content" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 20px;"></textarea>
                    <button type="submit" style="background-color: #5cb85c; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">Send</button>
                </form>

                <h3 style="margin-top: 30px;">Conversation</h3>
                <ul style="list-style-type: none; padding: 0;">
                    <?php while ($row = $messages->fetch_assoc()): ?>
                        <li style="margin-bottom: 10px;"><strong><?php echo $row['sender']; ?></strong>: <?php echo $row['content']; ?> <em>(<?php echo $row['timestamp']; ?>)</em></li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
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