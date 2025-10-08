<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    header("Location: index.php");
    exit();
}
include('config.php');

// Fetch clubs
$clubs = $conn->query("SELECT * FROM clubs");

// Handle deleting a club
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_club'])) {
    $club_id = $_POST['club_id'];

    $stmt = $conn->prepare("DELETE FROM clubs WHERE id = ?");
    $stmt->bind_param("i", $club_id);

    if ($stmt->execute()) {
        header("Location: manage_clubs.php");
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
    <title>Manage Clubs - Binary Brains</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <header style="background-color: #333; padding: 10px;">
        <nav style="display: flex; justify-content: space-around;">
            <a href="home_admin.php" style="color: white; text-decoration: none; padding: 10px;">Home</a>
            <a href="manage_clubs.php" style="color: white; text-decoration: none; padding: 10px;">Manage Clubs</a>
            <a href="logout.php" style="color: white; text-decoration: none; padding: 10px;">Logout</a>
        </nav>
    </header>

    <main style="padding: 20px;">
        <section style="max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center;">Manage Clubs</h2>
            <ul style="list-style-type: none; padding: 0;">
                <?php while ($row = $clubs->fetch_assoc()): ?>
                    <li style="margin-bottom: 20px;">
                        <strong><?php echo $row['club_name']; ?></strong><br>
                        <?php echo $row['description']; ?><br>
                        <form action="manage_clubs.php" method="post" style="display:inline;">
                            <input type="hidden" name="club_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete_club" style="background-color: #d9534f; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Delete Club</button>
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