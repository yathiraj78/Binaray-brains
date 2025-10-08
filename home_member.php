<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'member') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binary Brains - Member Home</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <header style="background-color: #333; padding: 10px;">
        <nav style="display: flex; justify-content: space-around;">
            <a href="home_member.php" style="color: white; text-decoration: none; padding: 10px;">Home</a>
            <a href="create_club.php" style="color: white; text-decoration: none; padding: 10px;">Create Club</a>
            <a href="view_clubs.php" style="color: white; text-decoration: none; padding: 10px;">View Clubs</a>
            <a href="join_club.php" style="color: white; text-decoration: none; padding: 10px;">Join Existing Club</a>
            <a href="view_members.php" style="color: white; text-decoration: none; padding: 10px;">View Club Members</a>
            <a href="messages.php" style="color: white; text-decoration: none; padding: 10px;">Messages</a>
            <a href="notifications.php" style="color: white; text-decoration: none; padding: 10px;">Notifications</a>
            <a href="contact_admin.php" style="color: white; text-decoration: none; padding: 10px;">Contact Admin</a>
            <a href="logout.php" style="color: white; text-decoration: none; padding: 10px;">Logout</a>
        </nav>
    </header>

    <main style="padding: 20px;">
        <section style="max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center;">Welcome, <?php echo $_SESSION['username']; ?>!</h2>
            <div style="display: flex; flex-wrap: wrap; justify-content: space-around;">
                <div class="functionality" style="text-align: center; margin: 10px;">
                    <img src="images\create_club.jpg" alt="Create Club" style="width: 100px; height: 100px; display: block; margin: auto;">
                    <a href="create_club.php" style="text-decoration: none; color: #333;">Create Club</a>
                </div>
                <div class="functionality" style="text-align: center; margin: 10px;">
                    <img src="images\view_clubs.jpg" alt="View Clubs" style="width: 100px; height: 100px; display: block; margin: auto;">
                    <a href="view_clubs.php" style="text-decoration: none; color: #333;">View Clubs</a>
                </div>
                <div class="functionality" style="text-align: center; margin: 10px;">
                    <img src="images\join_existing_club.jpg" alt="Join Existing Club" style="width: 100px; height: 100px; display: block; margin: auto;">
                    <a href="join_club.php" style="text-decoration: none; color: #333;">Join Existing Club</a>
                </div>
                <div class="functionality" style="text-align: center; margin: 10px;">
                    <img src="images\view_club_members.jpg" alt="View Club Members" style="width: 100px; height: 100px; display: block; margin: auto;">
                    <a href="view_members.php" style="text-decoration: none; color: #333;">View Club Members</a>
                </div>
                <div class="functionality" style="text-align: center; margin: 10px;">
                    <img src="images\messages.jpg" alt="Messages" style="width: 100px; height: 100px; display: block ; margin: auto;">
                    <a href="messages.php" style="text-decoration: none; color: #333;">Messages</a>
                </div>
                <div class="functionality" style="text-align: center; margin: 10px;">
                    <img src="images\notification.jpg" alt="Notifications" style="width: 100px; height: 100px; display: block; margin: auto;">
                    <a href="notifications.php" style="text-decoration: none; color: #333;">Notifications</a>
                </div>
                <div class="functionality" style="text-align: center; margin: 10px;">
                    <img src="images\contact_admin.jpg" alt="Contact Admin" style="width: 100px; height: 100px; display: block; margin: auto;">
                    <a href="contact_admin.php" style="text-decoration: none; color: #333;">Contact Admin</a>
                </div>
            </div>
        </section>
    </main>

    <footer style="text-align: center; padding: 10px; background-color: #333; color: white; position: relative; bottom: 0; width: 100%;">
        &copy; 2025 Binary Brains. All rights reserved.
    </footer>
</body>
</html>