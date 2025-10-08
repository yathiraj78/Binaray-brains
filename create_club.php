<?php
session_start();
include('config.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $club_name = $_POST['club_name'];
    $description = $_POST['description'];
    $created_by = $_SESSION['id'];

    $stmt = $conn->prepare("INSERT INTO clubs (club_name, description, created_by) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $club_name, $description, $created_by);

    if ($stmt->execute()) {
        echo "Club created successfully.";
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
    <title>Create Club - Binary Brains</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <header style="background-color: #333; padding: 10px;">
        <nav style="display: flex; justify-content: space-around;">
            <a href="home_member.php" style="color: white; text-decoration: none; padding: 10px;">Home</a>
            <a href="create_club.php" style="color: white; text-decoration: none; padding: 10px;">Create Club</a>
            <a href="view_clubs.php" style="color: white; text-decoration: none; padding: 10px;">View Clubs</a>
            <a href="logout.php" style="color: white; text-decoration: none; padding: 10px;">Logout</a>
        </nav>
    </header>

    <main style="padding: 20px;">
        <section style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center;">Create Club</h2>
            <form action="create_club.php" method="post">
                <label for="club_name" style="display: block; margin-bottom: 10px;">Club Name:</label>
                <input type="text" id="club_name" name="club_name" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">
                
                <label for="description" style="display: block; margin-bottom: 10px;">Description:</label>
                <textarea id="description" name="description" required style="width: 100%; height: 100px; margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                
                <button type="submit" style="background-color: #5cb85c; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">Create Club</button>
            </form>
        </section>
    </main>

    <footer style="text-align: center; padding: 10px; background-color: #333; color: white; position: relative; bottom: 0; width: 100%;">
        &copy; 2025 Binary Brains. All rights reserved.
    </footer>
</body>
</html>