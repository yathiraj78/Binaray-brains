<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out - Binary Brains</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <header style="background-color: #333; color: white; padding: 20px; text-align: center;">
        <h1>Binary Brains - Social Club Platform</h1>
    </header>

    <main style="text-align: center; padding: 50px;">
        <h2>You have been logged out successfully.</h2>
        <p>Redirecting to the homepage...</p>
    </main>

    <footer style="text-align: center; padding: 10px; background-color: #333; color: white; position: relative; bottom: 0; width: 100%;">
        &copy; 2025 Binary Brains. All rights reserved.
    </footer>
</body>
</html>