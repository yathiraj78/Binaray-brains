<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'member') {
    header("Location: index.php");
    exit();
}
include('config.php');

// Handle joining a club
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $club_id = $_POST['club_id'];
    $user_id = $_SESSION['id'];

    // Check if the user is already a member of the club
    $check_membership = $conn->query("SELECT * FROM club_members WHERE club_id = $club_id AND user_id = $user_id");
    if ($check_membership->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO club_members (club_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $club_id, $user_id);

        if ($stmt->execute()) {
            echo "Successfully joined the club.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "You are already a member of this club.";
    }
}

// Fetch clubs
$clubs = $conn->query("SELECT * FROM clubs");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Club - Binary Brains</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <header style="background-color: #333; padding: 10px;">
        <nav style="display: flex; justify-content: space-around;">
            <a href="home_member.php" style="color: white; text-decoration: none; padding: 10px;">Home</a>
            <a href="join_club.php" style="color: white; text-decoration: none; padding: 10px;">Join Club</a>
            <a href="logout.php" style="color: white; text-decoration: none; padding: 10px;">Logout</a>
        </nav>
    </header>

    <main style="padding: 20px;">
        <section style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center;">Join Existing Club</h2>
            <form action="join_club.php" method="post">
                <label for="club_id" style="display: block; margin-bottom: 10px;">Select Club:</label>
                <select id="club_id" name="club_id" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    <?php while ($row = $clubs->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['club_name']; ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" style="background-color: #5cb85c; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; width: 100%;">Join Club</button>
            </form>
        </section>
    </main>

    <footer style="text-align: center; padding: 10px; background-color: #333; color: white; position: relative; bottom: 0; width: 100%;">
        &copy; 2025 Binary Brains. All rights reserved.
    </footer>
</body>
</html>