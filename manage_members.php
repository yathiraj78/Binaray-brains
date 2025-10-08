<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    header("Location: index.php");
    exit();
}
include('config.php');

// Fetch club members
$members = $conn->query("SELECT club_members.id AS membership_id, users.username, clubs.club_name FROM club_members JOIN users ON club_members.user_id = users.id JOIN clubs ON club_members.club_id = clubs.id");

// Handle removing a member
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_member'])) {
    $membership_id = $_POST['membership_id'];

    $stmt = $conn->prepare("DELETE FROM club_members WHERE id = ?");
    $stmt->bind_param("i", $membership_id);

    if ($stmt->execute()) {
        header("Location: manage_members.php");
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
    <title>Manage Club Members - Binary Brains</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <header style="background-color: #333; padding: 10px;">
        <nav style="display: flex; justify-content: space-around;">
            <a href="home_admin.php" style="color: white; text-decoration: none; padding: 10px;">Home</a>
            <a href="manage_members.php" style="color: white; text-decoration: none; padding: 10px;">Manage Members</a>
            <a href="logout.php" style="color: white; text-decoration: none; padding: 10px;">Logout</a>
        </nav>
    </header>

    <main style="padding: 20px;">
        <section style="max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center;">Manage Club Members</h2>
            <ul style="list-style-type: none; padding: 0;">
                <?php while ($row = $members->fetch_assoc()): ?>
                    <li style="margin-bottom: 20px;">
                        <strong><?php echo $row['club_name']; ?></strong> - <?php echo $row['username']; ?><br>
                        <form action="manage_members.php" method="post" style="display:inline;">
                            <input type="hidden" name="membership_id" value="<?php echo $row['membership_id']; ?>">
                            <button type="submit" name="remove_member" style="background-color: #d9534f; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Remove Member</button>
                        </form>
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