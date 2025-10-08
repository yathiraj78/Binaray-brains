<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    header("Location: index.php");
    exit();
}
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $club_id = $_POST['club_id'];
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO events (club_id, event_name, event_date, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $club_id, $event_name, $event_date, $description);

    if ($stmt->execute()) {
        echo "Event scheduled successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch clubs for the dropdown
$clubs = $conn->query("SELECT id, club_name FROM clubs");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Events - Binary Brains</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <header style="background-color: #333; padding: 10px;">
        <nav style="display: flex; justify-content: space-around;">
            <a href="home_admin.php" style="color: white; text-decoration: none; padding: 10px;">Home</a>
            <a href="schedule_events.php" style="color: white; text-decoration: none; padding: 10px;">Schedule Events</a>
            <a href="logout.php" style="color: white; text-decoration: none; padding: 10px;">Logout</a>
        </nav>
    </header>

    <main style="padding: 20px;">
        <section style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center;">Schedule Event</h2>
            <form action="schedule_events.php" method="post">
                <label for="club_id" style="display: block; margin-bottom: 10px;">Select Club:</label>
                <select id="club_id" name="club_id" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">
                    <?php while ($row = $clubs->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['club_name']; ?></option>
                    <?php endwhile; ?>
                </select>
                
                <label for="event_name" style="display: block; margin-bottom: 10px;">Event Name:</label>
                <input type="text" id="event_name" name="event_name" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">
                
                <label for="event_date" style="display: block; margin-bottom: 10px;">Event Date:</label>
                <input type="date" id="event_date" name="event_date" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">
                
                <label for="description" style="display: block; margin-bottom: 10px;">Description:</label>
                <textarea id="description" name="description" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                
                <button type="submit" style="background-color: #5cb85c; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; width: 100%;">Schedule Event</button>
            </form>
        </section>
    </main>

    <footer style="text-align: center; padding: 10px; background-color: #333 ; color: white; position: relative; bottom: 0; width: 100%;">
        &copy; 2025 Binary Brains. All rights reserved.
    </footer>
</body>
</html>