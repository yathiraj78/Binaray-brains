<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include('config.php');

// Fetch all clubs
$clubs = $conn->query("SELECT * FROM clubs");

// Initialize selected club members
$selected_club_members = null;

// Check if a club is selected
if (isset($_POST['club_id'])) {
    $club_id = $_POST['club_id'];
    $stmt = $conn->prepare("SELECT users.username, users.first_name, users.last_name FROM club_members JOIN users ON club_members.user_id = users.id WHERE club_members.club_id = ?");
    $stmt->bind_param("i", $club_id);
    $stmt->execute();
    $selected_club_members = $stmt->get_result();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Club Members - Binary Brains</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <header style="background-color: #333; padding: 10px;">
        <nav style="display: flex; justify-content: space-around;">
            <a href="home_member.php" style="color: white; text-decoration: none; padding: 10px;">Home</a>
            <a href="view_clubs.php" style="color: white; text-decoration: none; padding: 10px;">View Clubs</a>
            <a href="view_members.php" style="color: white; text-decoration: none; padding: 10px;">View Club Members</a>
            <a href="logout.php" style="color: white; text-decoration: none; padding: 10px;">Logout</a>
        </nav>
    </header>

    <main style="padding: 20px;">
        <section style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center;">View Club Members</h2>
            <form action="view_members.php" method="post">
                <label for="club_id" style="display: block; margin-bottom: 10px;">Select Club:</label>
                <select id="club_id" name="club_id" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">
                    <?php while ($row = $clubs->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>" <?php if (isset($club_id) && $club_id == $row['id']) echo 'selected'; ?>>
                            <?php echo $row['club_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" style="background-color: #5cb85c; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; width: 100%;">View Members</button>
            </form>

            <?php if ($selected_club_members): ?>
                <h3 style="margin-top: 30px;">Club Members</h3>
                <ul style="list-style-type: none; padding: 0;">
                    <?php while ($row = $selected_club_members->fetch_assoc()): ?>
                        <li style="margin-bottom: 10px;"><?php echo $row['first_name'] . ' ' . $row['last_name'] . ' (' . $row['username'] . ')'; ?></li>
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